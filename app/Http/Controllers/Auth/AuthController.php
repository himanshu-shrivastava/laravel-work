<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getSocialRedirect( $provider )
    {
        $providerKey = \Config::get('services.' . $provider);
        if(empty($providerKey))
            return view('pages.status')
                ->with('error','No such provider');
        return Socialite::driver( $provider )->redirect();
    }

    public function getSocialHandle( $provider )
    {
        $user = Socialite::driver( $provider )->user();
        $socialUser = null;

        //Check is this email present
        $userCheck = User::getUserDetails($user->id);
        if(!empty($userCheck))
        {
            $socialUser = $userCheck;

            $inputs         =   [
                'name'  => $user->name,
                'email' => $user->email
            ];

            User::updateUserDetail($user->id, $inputs);
        }
        else
        {
            $inputs         =   [
                'name'          => $user->name,
                'auth_source'   => $provider,
                'auth_id'       => $user->id
            ];

            if($user->email)
                $inputs['email']= $user->email;

            $socialUser = User::create($inputs);
        }

        Auth::login($socialUser);

        return redirect('/home');
    }
}
