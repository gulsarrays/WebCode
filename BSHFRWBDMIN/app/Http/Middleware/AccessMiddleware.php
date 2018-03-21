<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\UserRole;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
      $userType=auth()->user()->user_type;
      if($userType==1){
        return $next($request);
      }
      else{
        $userRole=UserRole::find($userType);
        if(!empty($userRole) && count($userRole)>0){
          $permissions=explode(',',$userRole->permission);
          $allow=false;
          foreach($permissions as $permission){
            if(substr_count($request->path(),$permission)>0)
            {
              $allow=true;
              break;
            }
          }
         if($allow==true){
           return $next($request);
         }
         else{
           return redirect()->back()->with('error','Sorry No Access provided to your user account. Kindly contact admin');
         }
        }
        else{
          return redirect('/')->with('error','Sorry No Access provided to your user account. Kindly contact admin'); 
        }
      }
      
    }
}
