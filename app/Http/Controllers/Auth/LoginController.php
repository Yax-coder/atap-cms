<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    protected function redirectTo()
    {
        /*if(Auth::user()->account_type == 3){
            return '/dashboard';
        } else if(Auth::user()->account_type == 2){
            // $this->changeFirstLogin();
            return '/dashboard';
        } else if(Auth::user()->account_type == 1){
            // $this->changeFirstLogin();
            return '/dashboard';
        } else{
            return '/logout';
        }*/
        return '/courses';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function changeFirstLogin()
    {
        $user = Auth::user();
        if($user->first_login == 1){
            $user->first_login = 0;
            $user->save();
        }
    }
}
