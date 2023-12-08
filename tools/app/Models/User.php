<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
//use Laravel\Sanctum\HasApiTokens;
//use Laravel\Passport\HasApiTokens;



//use App\Models\AclGroup;
//use App\Models\AclUserHasGroup;
//use App\Models\AclUserHasPermission;
use Junges\ACL\Models\Group as AclGroup;
use Junges\ACL\Models\Permission as AclPermission;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Lab404\Impersonate\Models\Impersonate;
//use Junges\ACL\Concerns\UsersTrait;
use Junges\ACL\Concerns\HasGroups;

/**
 * Class User
 *
 * @property int $id
 * @property string $name
 * @property string|null $username
 * @property int|null $saas_subscription_id
 * @property int|null $carrier_id
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $ip_address
 * @property bool|null $accepted_terms
 * @property string|null $timezone
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property Carbon|null $last_login_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 *
 * @package App\Models\Base
 */

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable, SoftDeletes,
        Impersonate, HasProfilePhoto, HasGroups;// HasApiTokens, UsersTrait, ;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'accepted_terms' => 'bool',
        'email_verified_at' => 'datetime',
        'last_login_at' => 'date'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'email_verified_at',
        'password',
        'ip_address',
        'accepted_terms',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $with = [ 'acl_groups' ];

    protected $dates = [
        'email_verified_at'
    ];

    // Managed groups are ACL groups that a user is allowed to edit, view and select when managing other users
    public function managedGroups()
    {
        $this->acl_groups->load('managed_acl_groups');
        return $this->acl_groups->map(function ($item, $key) {
            return $item->managed_acl_groups->transform(function ($item, $key) {
                return ['row_num'=>$item->id, 'id'=>$item->id, 'name'=>$item->name];
            });
        })->flatten(1);
    }
    public function managedGroupIds()
    {
        $this->acl_groups->load('managed_acl_groups');
        return $this->acl_groups->map(function ($item, $key) {
            return $item->managed_acl_groups->pluck('id');
        })->flatten(1)->toArray();
    }

    public function active_scheduled_messages()
    {
        //return $this->hasMany(ScheduledMessage::class)->where('receive_invoice_emails', 1)->whereNotNull('email');
        $messages = ScheduledMessage::where(function ($q) {
            $q->whereIn('acl_group_id', $this->acl_groups->pluck('id')->toArray())
                ->orWhereNULL('acl_group_id');
        })->where(function ($q) {
            $q->whereRaw('CURRENT_TIMESTAMP between display_start_time and display_end_time')
                ->orWhereNULL('display_start_time', 'display_start_time');
        })
        ->get();

        return $messages;
    }

    protected $sortables = ['name','email','acl_groups.name'];
    protected $searchColumns = ['name','email','acl_groups.name'];

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->lfSearch($this->searchColumns, $search, 'users');
        })->when($filters['accepted_terms'] ?? null, function ($query, $accepted_terms) {
            $query->where('users.accepted_terms', $accepted_terms === 'yes' ? 1 : 0);
        })->when($filters['groups'] ?? null, function ($query, $value) {
            $query->leftJoin('acl_model_has_groups', 'users.id', 'acl_model_has_groups.model_id')
                ->whereIn('acl_model_has_groups.group_id', $value);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }

    /**
     * Scope a query to sort results.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSort(Builder $query, Array $sort)
    {
        if (empty($sort)) {
            return;
        }

        foreach ($sort as $field => $direction) {
            switch ($field) {
                //make case statement for unique sorts
                case 'acl_groups.name':
                    $query->select('users.*')
                        ->leftJoin('acl_model_has_groups', 'users.id', '=', 'acl_model_has_groups.model_id')
                        ->leftJoin('acl_groups', 'acl_model_has_groups.group_id', '=', 'acl_groups.id')
                        ->orderBy('acl_groups.name', $direction);
                    break;
                default:
                    if (!in_array($field, $this->sortables)) {
                        throw new \Exception('Sorting on the ' . $field . ' column is not allowed.');
                    }
                    $query->orderBy($field, $direction);
                    break;
            }
        }
        return $query;
    }

    public static function getValidationArray(?int $userId = null): Array
    {
        return [
            'name' => ['required', 'max:255'],
            'username' => ['nullable', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'email_verified_at' => ['nullable','date'],
            'password' => ['nullable', 'max:255'],
            'ip_address' => ['nullable', 'max:45'],
            'accepted_terms' => ['nullable'],
            'acl_groups.*' => ['nullable', 'integer'],
        ];
    }

    // overrride
    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $user
     * @param  string  $token
     * @return void
     */
    public function setRememberToken($token)
    {
        // If admin user, clear remember me token
        if (!empty(array_intersect($this->acl_groups->pluck('id')->toArray(), config('acl.admin_groups')))) {
            $this->remember_token = null;
        } else {
            parent::setRememberToken($token);
        }
    }

    // RELATIONSHIPS
    public function acl_groups()
    {
        return $this->belongsToMany(AclGroup::class, 'acl_model_has_groups', 'model_id', 'group_id');
    }

    /*** BASE RELATIONSHIPS BELOW  **********/
    /*public function acl_user_has_groups()
    {
        return $this->hasMany(AclUserHasGroup::class);
    }*/

    /*public function acl_user_has_permissions()
    {
        return $this->hasMany(AclUserHasPermission::class);
    }*/
}
