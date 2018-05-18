<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Collection;
use Auth;
use App\Repository\WebAppTenantRepository;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $data = User::orderBy('id', 'DESC')->paginate(5);
        return view('users.index', compact('data'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        $roles = $request->input('roles');
        if(in_array('administrator',$roles) && in_array('web_app_tenant',$roles)) {
            return redirect()->route('users.index')
                        ->with('error', 'User can not be admin and tenant at the same time');
        }

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));
        
        if(in_array('web_app_tenant',$roles)) {
            // set the new DB for newly created user.
            $web_app_tenant_db = WebAppTenantRepository::createWebAppTenantDB($user->id, $request->input('name'));
        }
        return redirect()->route('users.index')
                        ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);
        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = array_except($input, array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->input('roles'));
        return redirect()->route('users.index')
                        ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success', 'User deleted successfully');
    }
    
    public function get_all_web_app_tenant_users() {
        $data = DB::table("model_has_roles")
                ->select('users.name as userName','users.id as userId', 'model_has_roles.*', 'roles.name as roleName', 'roles.guard_name as guardName')
                ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->leftJoin('users', 'model_has_roles.model_id', '=', 'users.id')
                ->where('model_has_roles.model_type', 'App\User')
                ->where('roles.name', 'web_app_tenant')
                ->get()->toArray();
        return $data;
    }

}
