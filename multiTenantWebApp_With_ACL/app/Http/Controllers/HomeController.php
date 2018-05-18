<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebAppTenant\Posts;
use App\Http\Controllers\UserController;
use Config;
use Spatie\Permission\Models\Role;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserController $user)
    {
        $this->middleware('auth');
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array();
        $dataMain = array();
        $dataTenant = array();
        
        if (!empty(\Session::get('web_app_tenant_user')) && \Session::get('web_app_tenant_user') === true) { // web Tenant
            // work normally
        } else { // Admin
//            $dataMain = Posts::orderBy('id','DESC')
//              ->get()->toArray();
            $all_web_app_tenant_users = $this->user->get_all_web_app_tenant_users();
            foreach ($all_web_app_tenant_users as $userData) {
                $web_app_tenant_db = 'web_app_tenant_' . $userData->userId;
                $web_app_tenant_user = true;
                \Session::put('tenant_connection_db', $web_app_tenant_db);
                \Session::put('web_app_tenant_user', $web_app_tenant_user);

                config::set('database.connections.webAppTenant.database', $web_app_tenant_db);
                DB::reconnect('webAppTenant');
                $dataTenant_tmp = Posts::orderBy('id', 'DESC')
                                ->get()->toArray();

                $dataTenant = array_merge($dataTenant, $dataTenant_tmp);

                $web_app_tenant_user = false;
                \Session::put('web_app_tenant_user', $web_app_tenant_user);
                DB::purge('webAppTenant');
            }
        }

        $dataMain = Posts::orderBy('id','DESC')
              ->get()->toArray();
               
        $data = array_merge($data,$dataMain,$dataTenant);
        return view('home',compact('data'));
    }
}
