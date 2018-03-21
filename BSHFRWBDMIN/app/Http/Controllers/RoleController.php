<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::where('deleted_at','=',null)->orderBy('id','DESC')->get();
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::get();
        return view('roles.create',compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $errorMessage = '';
        $messsages = [
              'name.required' => 'The Name field is required and unique.',
              'display_name.required' => 'The display name is required.',
              'description.required' => 'The Description is required.',
              'permission.required' => 'Please select the permissions'
            ];
        // $validator = $this->validate($request, [
        //     'name' => 'required|unique:roles,name',
        //     'display_name' => 'required',
        //     'description' => 'required',
        //     'permission' => 'required',
        // ]);

        $rules = [
            'name' => 'required|unique:roles,name',
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ];

        $validator = \Validator::make ( $request->all (), $rules, $messsages );

        if ($validator->passes ()) {

            $role = new Role();
            $role->name = $request->input('name');
            $role->display_name = $request->input('display_name');
            $role->description = $request->input('description');
            $role->save();

            foreach ($request->input('permission') as $key => $value) {
                $role->attachPermission($value);
            }

            return redirect()->route('roles.index')
                        ->with('success','Role created successfully');
        } else {
            $request->flash();
            $errorMessage = $validator->messages ()->toArray ();
            return redirect ()->back ()->withError ( $errorMessage );
       }

    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("permission_role","permission_role.permission_id","=","permissions.id")
            ->where("permission_role.role_id",$id)
            ->get();

        return view('roles.show',compact('role','rolePermissions'));
    }

    public function getRole($id)
    {
        $rolePermissions = Permission::join("permission_role","permission_role.permission_id","=","permissions.id")
            ->where("permission_role.role_id",$id)
            ->get();

        return $rolePermissions;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        $permission = Permission::get();
        $rolePermissions = DB::table("permission_role")->where("permission_role.role_id",$id)
            ->pluck('permission_role.permission_id','permission_role.permission_id')->toArray();

        return view('roles.edit',compact('role','permission','rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'display_name' => 'required',
            'description' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::find($id);
        
        $roles = Role::find($id)->update([
            'display_name' => $request->input('display_name'),
            'description' => $request->input('description')
            ]);

        DB::table("permission_role")->where("permission_role.role_id",$id)
            ->delete();

        foreach ($request->input('permission') as $key => $value) {
            $role->attachPermission($value);
        }

        return redirect()->route('roles.index')
                        ->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Role::where('id',$id)->delete();
        Role::destroy($id);
        return redirect()->route('roles.index')
                        ->with('success','Role deleted successfully');
    }
}
