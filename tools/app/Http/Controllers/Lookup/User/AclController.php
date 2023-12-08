<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Lookup\User;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Junges\ACL\Models\Group;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use Laravel\Jetstream\Jetstream;

class AclController extends \App\Http\Controllers\Controller
{
    public function groupOptions(): \Illuminate\Http\JsonResponse
    {
        Auth::user()->load('acl_groups.managed_acl_groups');

        $managedGroups = Auth::user()->managedGroups();


        return response()->json([
            'data' => $managedGroups,
        ]);
    }
}