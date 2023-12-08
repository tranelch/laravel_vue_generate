<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Exports\AdminUserExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Services\LfMail;
use App\Models\User;

use App\Imports\UsersImport;
use App\Exports\CollectionExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response | \Illuminate\Http\RedirectResponse
     */
    public function index(): \Inertia\Response | \Illuminate\Http\RedirectResponse
    {
        $sortColumns = Request::filled('sort_columns') ? Request::input('sort_columns') : ['name'];
        $sortOrders = Request::filled('sort_orders') ? Request::input('sort_orders') : ['asc'];
        $sort = array_combine($sortColumns, $sortOrders);
        Auth::user()->load('acl_groups.managed_acl_groups');
        $managedGroups = Auth::user()->managedGroupIds();

        try {
            $users = User
            ::with('acl_groups')
            ->whereExists(function ($q) use ($managedGroups) {
                $q->select(DB::raw(1))
                    ->from('acl_model_has_groups')
                    ->where('model_type', 'App\Models\User')
                    ->whereColumn('users.id', 'acl_model_has_groups.model_id')
                    ->whereIn('acl_model_has_groups.group_id', $managedGroups);
            })
            ->sort($sort)
            ->filter(Request::only('search', 'trashed', 'accepted_terms'))
            ->paginate(Request::filled('per_page') ? (int)Request::input('per_page') : 50)
            ->withQueryString()
            ->through(fn ($user) => [
				'id' => $user->id,
				'name' => $user->name,
				'username' => $user->username,
                'acl_groups' => $user->acl_groups->makeHidden('pivot'),
				'email' => $user->email,
				'accepted_terms' => $user->accepted_terms,
                'two_factor_allowed' => $user->two_factor_allowed,
                'two_factor_required' => $user->two_factor_required,
    			'deleted_at' => $user->deleted_at,
            ]);
        } catch (\Exception $e) {
            Session::flash('error', 'We could not load your users.');
            Log::error($e->getMessage());
            $users = [];
        }

        return Inertia::render('Admin/Users/AdminUserIndex', [
            'filters' => Request::all('search', 'trashed', 'accepted_terms'),
            'sort_columns' => Request::filled('sort_columns') ? Request::input('sort_columns') : [],
            'sort_orders' => Request::filled('sort_orders') ? Request::input('sort_orders') : [],
            'users' => $users,
            'managedGroups' => $managedGroups,
            //'acl_group_options' => , FOR FILTER IF IMPLEMENTED
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response | \Illuminate\Http\RedirectResponse
     */
    public function create(): \Inertia\Response | \Illuminate\Http\RedirectResponse
    {
        return Inertia::render('Admin/Users/AdminUserCreate', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\RedirectResponse | \Inertia\Response
     */
    public function store(): \Illuminate\Http\RedirectResponse | \Inertia\Response
    {
        request()->merge(['email_verified_at' => Carbon::now()]);

        $validationArray = User::getValidationArray();

        $submission = Request::validate($validationArray);


        $user = User::create($submission);

        if (Auth::user()->hasPermission('users.groups.assign')) {
            $user->groups()->sync($submission['acl_groups']);;
        }

        try {
            LfMail::send(
                [$user->email],
                "New Liquid Freight Account",
                'mail.admin_notify_new_user',
                (object)['user' => $user]
            );
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            Session::flash('error', 'The user was created, but the email to the new user failed to send.  ' . $e->getMessage());
        }

        Session::flash('success', 'User Created Successfully.');
        if (Auth::user()->hasPermission('admin.users.edit')) {
            return redirect(url()->current() . '/' . $user->id . '/edit');
        } else {
            return redirect(url()->current());
        }
    }

    /**
     * Resend User Notification
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendUserNotification(): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail((int)Request::input('user_id'));
        $emailError = '';
        //Send email to new user
        try {
            LfMail::send(
                [$user->email],
                "New Liquid Freight Account",
                'mail.admin_notify_new_user',
                (object)['user' => $user]
            );
        } catch(\Exception $e) {
            Log::error($e->getMessage());
            $emailError .= 'The user was created, but the email to the new user failed to send.  ' . $e->getMessage();
        }

        $response = ['user' => $user];
        if (!empty($emailError)) $response['flash'] = ['error' => $emailError];
        return response()->json($response);
    }

    /**
     * Resend User Password Reset
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendUserPassword(): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail((int)Request::input('user_id'));

        Request::validate(['email' => 'required|email']);

        $status = Password::sendResetLink(Request::only('email'));

        if ($status) return response()->json(['success' => true]);
        return response()->json(['flash' => ['error' => 'Password reset email failed to send.']]);
    }

    /**
     * Reset User 2FA tokens
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset2fa(): \Illuminate\Http\JsonResponse
    {
        $user = User::findOrFail((int)Request::input('user_id'));

        try {
            $user->two_factor_secret = null;
            $user->two_factor_recovery_codes = null;
            $user->save();
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['flash' => ['error' => '2FA credential reset failed']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Int $userId): \Illuminate\Http\JsonResponse
    {
        request()->session()->reflash();
        return response()->json(['show_user' => User::with('acl_groups')->findOrFail($userId)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Inertia\Response | \Illuminate\Http\RedirectResponse
     */
    public function edit(User $user): \Inertia\Response | \Illuminate\Http\RedirectResponse
    {
        if (Session::has('fromListing') || $this->previousIsIndex()) {
            Session::flash('fromListing', true);
        }

        return Inertia::render('Admin/Users/AdminUserEdit', [
            'edit_user' => $user->load('acl_groups'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user): \Illuminate\Http\RedirectResponse
    {
        Session::keep(['fromListing']);

        $validationArray = User::getValidationArray($user->id);

        $submission = Request::validate($validationArray);

        if (Auth::user()->hasPermission('users.groups.assign')) {
            $user->groups()->sync($submission['acl_groups']);;
        }

        unset($submission['acl_groups']);
        $user->update($submission);

        return redirect()->back()->with('success', 'User Updated Successfully.');
    }

    /**
     * Remove specified resource using soft delete.
     *
     * @param  User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(User $user): \Illuminate\Http\JsonResponse
    {
        $user->delete();
        return response()->json(['flash' => ['success' => 'User was removed.']]);
    }

    /**
     * Restore specified resource using soft delete.
     *
     * Cannot pass the User object because it is disabled
     *
     * @param  Int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(Int $userId): \Illuminate\Http\JsonResponse
    {
        User::where('id', $userId)->restore();
        return response()->json(['flash' => ['success' => 'User was restored.']]);
    }

    /**
     * Export records as displayed on listing screen.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export()
    {
        $managedGroups = Auth::user()->managedGroupIds();

        $collection = User
            ::with('acl_groups')
            ->whereExists(function ($q) use ($managedGroups) {
                $q->select(DB::raw(1))
                    ->from('acl_model_has_groups')
                    ->where('model_type', 'App\Models\User')
                    ->whereColumn('users.id', 'acl_model_has_groups.model_id')
                    ->whereIn('acl_model_has_groups.group_id', $managedGroups);
            })
            ->filter(Request::only('search', 'trashed', 'accepted_terms'))
            ->get();

        return Excel::download(new AdminUserExport($collection), 'User.xlsx');
    }

    public function impersonate(User $user)
    {
        $groups = $user->groups->pluck('id')->toArray();
        $managedGroups = Auth::user()->managedGroupIds();
        $impersonatingUser = Auth::user();
        if (!Auth::user()->hasPermission('admin.users.impersonate') ||
            count(array_diff($groups, $managedGroups)) > 0 || // Impersonation user cannot include groups not managed by the logged-in user
            in_array(1, $groups) // Super Admin can not be impersonated
        ) {
            return back()->with('error', 'Sorry, you cannot impersonate the requested users.');
        }

        auth()->user()->impersonate($user);
        session()->put(['impersonate' => $user->id]);
        session()->save();

        if (env('APP_ENV') === 'production') {
            try {
                LfMail::send(
                    [$user->email],
                    "Notice of Liquidfreight.com User Login",
                    'mail.user_impersonation_notification',
                    (object)[
                        'user_name' => $impersonatingUser->name,
                    ]
                );
            } catch(\Exception $e) {
                Log::error($e->getMessage());
                Session::flash('error', 'The confirmation email failed to send.');
            }
        }

        return redirect()->route('dashboard')->with('message', 'Impersonating user ' . $user->name);
    }

    public function leaveImpersonate()
    {
        auth()->user()->leaveImpersonation();
        session()->forget('impersonate');
        session()->save();

        return redirect('/admin/users')->with('message', 'Impersonation has ended');
    }


    private function previousIsIndex() {
        $urlPieces = explode('?', url()->previous());
        return $urlPieces[0] === action([UsersController::class, 'index']);
    }
}
