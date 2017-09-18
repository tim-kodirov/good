<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        if (Auth::guard($guard)->check()) {
//            return redirect('/home');
//        }
        switch ($guard) {
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('admin');
                }
                break;
            case 'office':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('office');
                }
                break;
            case 'storehouse':
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('store');
                }
                break;

            default:
                if (Auth::guard($guard)->check()) {
                    return redirect()->route('login');
                }
                break;
        }

        return $next($request);
    }
}
