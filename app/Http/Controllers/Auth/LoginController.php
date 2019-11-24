<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/map';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function loginpost(Request $request)
    {
        $this->validateLogin($request);
 $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = $this->guard()->user();
            $user->generateToken();
            $arr['Uid'] = $user['Uid'];
            $arr['UserName'] = $user['UserName'];
            $arr['name'] = $user['name'];
            $arr['family'] = $user['family'];
            $arr['email'] = $user['email'];
            $arr['password'] = $user['password'];
            $arr['access'] = $user['access'];
            return redirect('map');
        }
    }
        public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            return redirect('map');
        }

        return $this->sendFailedLoginResponse($request);
    }
    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }
        Auth::logout();
        return  redirect('map');
    }
}
