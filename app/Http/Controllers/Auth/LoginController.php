<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/beranda';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    // /**
    //  * Attempt to authenticate the request's credentials.
    //  *
    //  * @return void
    //  *
    //  * @throws \Illuminate\Validation\ValidationException
    //  */
    // public function authenticate()
    // {
    //     $this->ensureIsNotRateLimited();

    //     //array_merge( $request->only($this->username(), 'password'), ['is_active' => 1 ])

    //     //if (! Auth::attempt($this->only('email', 'password'), $this->filled('remember'))) {
    //     if (!Auth::attempt(array_merge($this->only('email', 'password'), ['is_active' => 1]), $this->filled('remember'))) {
    //         RateLimiter::hit($this->throttleKey());

    //         throw ValidationException::withMessages([
    //             'email' => __('auth.failed'),
    //         ]);
    //     }

    //     RateLimiter::clear($this->throttleKey());
    // }
}
