<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Auth;
use Mail;
use Debugbar;
use Socialite;
use App\User;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function authenticated()
    {
        $user = Auth::user();
         if ($user->verified == 0) {
             Auth::logout();

             $userInfo = [
                 'name' => $user['name'],
                 'token' => $user['token']
             ];

             Mail::send('emails.confirm', $userInfo, function ($message) use ($user){
                 $message->from('registration@flamingoleaves.com', 'Admin');
                 $message->to($user['email']);
                 $message->subject('Flamingoleaves.com Registration');
             });

             Session::flash('warning', 'Please confirm your email address. A confirmation email has been re-sent to you.');

             return redirect()->route('login');
         }
    }

}
