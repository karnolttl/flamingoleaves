<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Session;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $user->token = str_random(30);
        $user->save();

        $userInfo = [
            'name' => $data['name'],
            'token' => $user['token']
        ];

        Mail::send('emails.confirm', $userInfo, function ($message) use ($data){
            $message->from('registration@flamingoleaves.com', 'Admin');
            $message->to($data['email']);
            $message->subject('Flamingoleaves.com Registration');
        });

        Session::flash('warning', 'Please confirm your email address.');

        return $user;
    }

    public function registered()
    {
        $this->guard()->logout();
    }

    public function confirmEmail($token)
    {
        $user = User::whereToken($token)->firstOrFail();

        $user->verified = true;
        $user->token = null;
        $user->save();

        Session::flash('success', 'Your email is now confirmed. Please login.');

        return redirect()->route('login');
    }
}
