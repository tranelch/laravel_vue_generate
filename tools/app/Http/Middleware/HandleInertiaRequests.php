<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\AclGroup;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    /*public function version(Request $request)
    {
        return parent::version($request);
    }*/

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $rolePermissions = [];
        if ($request->user()) {
            $rolePermissions = $request->user()->getAllPermissions()->pluck('name')->toArray();
        }

        // Add props to built-in pages as needed
        $pageShare = [];

        if (session('impersonate')) {
            $pageShare['impersonate'] = 1;
        }

        $requestPath = $request->path();

        // Reflash if not a full page load
        if (str_starts_with($requestPath, '/lookup/')) {
            $request->session()->reflash();
        }

        return array_merge(
            parent::share($request),
            [
                'appPermissions' => $rolePermissions,
                'flash' => function () use ($request) {
                    return [
                        'message' => $request->session()->pull('message'),
                        'success' => $request->session()->pull('success'),
                        'warning' => $request->session()->pull('warning'),
                        'error' => $request->session()->pull('error'),
                        'fromListing' => $request->session()->get('fromListing'),
                    ];
                },
                'scheduledMessages' => $request->user()?->active_scheduled_messages()?->toArray() ?? [],
            ],
            $pageShare
        );
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next) {
        if (auth()->user() &&
            auth()->user()->two_factor_required &&
            empty(auth()->user()->two_factor_secret) &&
            !$request->is('user/profile') &&
            !str_starts_with($request->path(), 'lookup/') &&
            !str_starts_with($request->path(), 'user/') &&
            !str_starts_with($request->path(), 'logout') &&
            !session('impersonate')
        ) {
            return redirect('/user/profile#two-factor')->with('error', 'You are required to enable Two-factor Authentication.');
        }

        return parent::handle($request, $next);
    }
}
