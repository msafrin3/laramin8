<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\User;
use Closure;
use App\Models\Logs;

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

    public function login(Request $request) {
        if(Auth::attempt($request->except(['_token']))) {
            $request->session()->regenerate();

            $data = [];
            $data['user_id'] = Auth::user()->id;
            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                $data['ip_address'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            } else {
                $data['ip_address'] = $request->ip();
            }
            if(Auth::check()) {
                $data['user_id'] = Auth::user()->id;
            }
            $data['user_agent'] = $request->server('HTTP_USER_AGENT');
            $data['url'] = url()->full();
            $data['method'] = $request->method();
            if($request->path() == 'login' && $request->method() == 'POST') {
                $data['params'] = json_encode($request->except(['password']), true);
                $data['is_login'] = 1;
            } else {
                $data['params'] = json_encode($request->all(), true);
            }
            Logs::create($data);

            return redirect()->intended('dashboard');
        }
    }
}
