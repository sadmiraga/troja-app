<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        //check if location is choosen.
        $location_id = session('location');
            
        if($location_id == null){
            return redirect()->route('locations');
        }

         // If the user is not authenticated, redirect
        if (!Auth::user()) {
            return redirect()->route('login');
        }

        // If the user is an admin (assuming user_type_id of 1 denotes an admin), allow access
        if (Auth::user()->user_type_id == 1) {
            return $next($request);
        }

        // For other user types, check permissions
        $routeName = $request->route()->getName();  // Get the current route name
        $routeGroup = explode('.', $routeName)[0];  // Extract the group part (e.g., "user" from "user.index")

        // Check if the user has the required permission
        $hasPermission = DB::table('user_permissions')
            ->join('permissions', 'permissions.id', '=', 'user_permissions.permission_id')
            ->where('user_permissions.user_id', Auth::user()->id)
            ->where('permissions.name', $routeGroup)
            ->exists();

        if ($hasPermission) {

            return $next($request);
        }

        // If no permissions match, redirect the user
        return redirect()->route('no-access');

    }
}
 