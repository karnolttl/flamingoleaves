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

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect()->route('auth/google');
        }

        $authUser = $this ->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect()->route('pages.home');
    }

    private function findOrCreateUser($googleUser)
    {
        if ($authUser = User::where('google_id', $googleUser->id)->first()) {
            return $authUser;
        }

        return User:: create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => 'secret',
            'google_id' => $googleUser->id,
            'verified' => true,
            'token' => null
        ]);
    }

}
