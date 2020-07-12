<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function authenticate()
    {
        if (\Auth::attempt(['email' => $email, 'password' => $password, 'is_activated' => 1]))
        {
            // The user is active, not suspended, and exists.
            // Logic that determines where to send the user
            if (\Auth::user()->org_name == 'Dibon')
            {
                return redirect()->intended('/main-organization/dashboard');
            }
            else
            {
                return redirect()->intended('/organization/dashboard');
            }
        }
    }
}
