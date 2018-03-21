<?php
/**
 * AccessController
 *
 * This controller will going to hold all operations related the AccessController
 *
 * @category  compassites
 * @package   compassites_laravel 5.2
 * @author    compassites Team <developers@compassitesinc.com>
 * @copyright Copyright (C) 2016 compassites. All rights reserved.
 * @license   GNU General Public License http://www.gnu.org/copyleft/gpl.html
 * @version   Release: 1.0
 */
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
//getting the request file
use App\Http\Requests;
//getting the controller file
use App\Http\Controllers\Controller;
//geting the userrole model
use App\Models\UserRole;

class AccessController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
       if(isset(auth ()->user ()->user_type)&&(auth ()->user ()->user_type==1)){
       //geting the user role details
        $userroles=UserRole::where('id','!=',1)->paginate(10);        
        //show it in a blade fiel
        return view('access.list')->with(['data'=>$userroles,'modules'=>\CustomHelper::$modules]);
       }
       else{
          return redirect('/');
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
       if(isset(auth ()->user ()->user_type)&&(auth ()->user ()->user_type==1)){
       $role=UserRole::find($id);
       if(!empty($role)){
         return view('access.edit')->with(['role'=>$role,'modules'=>\CustomHelper::$modules]);
       }
       else{
         return redirect()->back()->withError('Sorry invalid request id');  
       }
       }
       else{
          return redirect('/');
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
       //geting user role based on id
      $role=UserRole::find($id);
      //validation parameter
      $rules=['name'=>'required'];
      //validation process
      $validator=validator($request->all(),$rules);
      if($validator->passes()){
         //success in validation
        if(!empty($role)){
           //getting name value
          $role->name=$request->name;
          //provide permission
          if(isset($request->module) && !empty($request->module)){
             //To get the old values from the database
             $oldValues=$role->permission;
             $oldArray=\CustomHelper::$list_permissions; //explode(',',$oldValues);
             $newArray=$request->module;
             $permission = array_intersect($oldArray,$newArray);

             //To merge the old and new values
             // $array=array_merge($oldArray,$newArray);
             //To remove the duplicate values
             // $permission=array_unique($array);
             
            $role->permission = implode(',', $permission); //'user,'. 
          }
          //If the value is empty then the empty value is updated
          else{
             $role->permission=$request->module;
          }
          //save the value
          $role->save();
          //success redirection
          return redirect()->to('/access')->with('success','Updated successfully');
        }
        else{
           //failure redirection
          return redirect()->back()->withError('Sorry invalid request id');
        }
      }
      else{
         //validation redirection
        return redirect()->back()->withError($validator->messages()->first())->withInput();
      }
      
    }
  
    
}
