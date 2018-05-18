<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Config;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    protected function authenticated(Request $request, $user)
    {        
        $userRole = $user->roles->pluck('name', 'name')->all();
        if(in_array('web_app_tenant', $userRole)) {
            $web_app_tenant_user = true;
            $web_app_tenant_db = 'web_app_tenant_' . $user->id;
            // Set the context connection
            \Session::put('tenant_connection_db', $web_app_tenant_db);
            \Session::put('web_app_tenant_user', $web_app_tenant_user);
        }
    }
}
