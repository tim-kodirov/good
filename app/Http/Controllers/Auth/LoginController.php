<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Office;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:office')->except('logout');
        $this->middleware('guest:owner')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    protected function guard()
    {
        if(Auth::guard('office')->check())
            return Auth::guard('office');
        elseif(Auth::guard('owner')->check())
            return Auth::guard('owner');
        elseif(Auth::guard('admin')->check())
            return Auth::guard('admin');
        else
            return Auth::guard();
    }

    protected function redirectTo()
    {
        if(Auth::guard('office')->check())
            return '/office';
        elseif(Auth::guard('owner')->check())
            return '/store';
        elseif(Auth::guard('admin')->check())
            return '/admin';
        else
            return '/';
    }

    protected function attemptLogin(Request $request)
    {
        if (User::where('username', $request->username)->exists())
            return Auth::guard('owner')->attempt(
            $this->credentials($request), $request->has('remember')
        );
        elseif(Office::where('username',$request->username)->exists())
            return Auth::guard('office')->attempt(
                $this->credentials($request), $request->has('remember')
            );
        elseif(Admin::where('username',$request->username)->exists())
            return Auth::guard('admin')->attempt(
                $this->credentials($request), $request->has('remember')
            );
        else
            return $this->guard()->attempt(
                $this->credentials($request), $request->has('remember')
            );
    }

}
