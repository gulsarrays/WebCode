<?php

namespace App\Http\Controllers\Users;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Models\Users;
use App\Models\AdUsers;

use App\Repository\UserRepository as UserRepository;
use App\Repository\AdUserRepository as AdUserRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\UserRole;
use App\Models\Role;

class AdUserController extends Controller {

	public function __construct(UserRepository $user, AdUserRepository $adUser) {
		// constructor function for user
		$this->user = $user;
		$this->adUser = $adUser;
	}

	public function getAdUser(Request $request)
	{
		
		if (isset ( auth ()->user ()->user_type ) && (auth ()->user ()->user_type == 1)) {
	        // staff details getting process
	        $allAdUsers = User::where ( 'is_active', '!=', null )
	        			->where ( 'user_type', '=', 6 )->get();

	        $data = User::where ( 'is_active', '!=', null )
	        			->where ( 'user_type', '=', 6 )
			        	->orderBy ( 'created_at', 'desc' )
			        	->get();
	         	         
	        $adsList = $this->adUser->getAdUserList(AD_API_BASE.LIST_ADS);
	        
	        return view ( 'users.adUsers' )->with (compact('data','allAdUsers','adsList'));
	    } else {
	        return redirect ( '/' );
	    }
		
	}

	public function createAdUser(){

		if (isset ( auth ()->user ()->user_type ) && (auth ()->user ()->user_type == 1)) {
			$roles = Role::pluck('display_name','id');
			$user_type = UserRole::where ( IS_ACTIVE, 1 )->where ( 'id', '=', 6 )         
                    ->pluck('name', 'id');
			return view ( 'users.createAdUser' )->with ( compact('user_type','roles'));
		}else {
			return redirect ( '/' );
		}
	}

	public function storeAdUser(Request $request){

		try{
			$rules = [ 
                     COM_NAME_KEYWORD => REQUIRED,
                     EMAIL => 'required|email',
                     COM_MOBILE_NUMBER_KEYWORD => REQUIRED,
                     'roles' => 'required',
                     'is_active' => 'required'
	        ];

	        $validator = validator ( $request->all (), $rules );
	        if ($validator->passes ()) {
	            
	            $alreadyexists = User::where(EMAIL,$request->input(EMAIL) )
	            				->orWhere(COM_MOBILE_NUMBER_KEYWORD, $request->input(COM_MOBILE_NUMBER_KEYWORD))
	            				->first();

	            if($alreadyexists){
	              return redirect ()->back ()->with ( ERROR, 'The Email or Mobile number already exist' );
	            }
	            
	            if ($this->adUser->createOrUpdateUser ( $request->all () )) {	                
	               
	               $path = redirect ()->to ( 'adUser' )->with ( 'success', 'Ad-User details added successfully' );
	            } else {	               
	               $path = redirect ()->back ()->with ( ERROR, 'Error while adding the Ad-User details. Please try later' );
	            }
	            
	            return $path;
	        
	        } else {
            // validation failure redirection
            return redirect ()->back ()->with ( ERROR, $validator->messages ()->first () )->withInput ();
        	}
		} catch ( \Exception $e ) {
			// return $e->getMessage();
			return redirect ()->back ()->with ( ERROR, 'Could not process! Please try later.' );
		}

	}

	public function editAdUser($id) {
		if (isset ( auth ()->user ()->id )) {
		 // edit info based on id
		 $adUser = User::where ( 'id', $id )->first ();
		 // $roles = Role::pluck('display_name','id');
		 $roles = Role::where('id',4)->pluck('display_name','id');
         $userRole = $adUser->roles->pluck('id','username','email')->toArray();

//		 if (count ( $adUser ) > 0) {
		 if (!empty ( $adUser ) ) {
		    // show it in blade file
		    return view ( 'users.editAdUser' )->with ( [
		                'user' => $adUser,
		                'userRole' => $userRole,
                        'roles' => $roles
		    ] );
		 } else {
		    return redirect ()->back ()->with ( ERROR, trans ( 'common.user.error' ) );
		 }
		} else {
		 return redirect ( '/' );
		}
	}

	public function updateAdUser(Request $request, $id){

		$rules = [ 
					COM_NAME_KEYWORD => REQUIRED,
					EMAIL => 'required|email',
					// COM_NAME_KEYWORD => 'required|regex:/^[a-zA-Z0-9\s-]+$/',
					'is_active' => 'required',
					'mobile_number' => 'required',
					'roles' => 'required'
			];
			// validation function
			$validator = validator ( $request->all (), $rules );
			if ($validator->passes ()) {
			 // success in validation
			 if ($this->adUser->createOrUpdateUser ( $request->all (), $id )) {
			    // success redirection
			    return redirect ()->back ()->with ( 'success', 'User details updated successfully' );
			 } else {
			    // failure redirection
			    return redirect ()->back ()->with ( ERROR, 'Error while updating the User details. Please try later' );
			 }
			} else {
			 // validation failure redirection
			 return redirect ()->back ()->with ( ERROR, $validator->messages ()->first () )->withInput ();
			}
	}

	public function deleteAdUser($id) {
      // get the id
      if (substr_count ( $id, '~' ) > 0) {
         // multiple id delete
         $user = User::whereIn ( ID, explode ( '~', $id ) );
      } else {
         // single id delete
         $user = User::find ( $id );
      }
      if (! empty ( $user ) && count ( $user ) > 0) {
         $user->delete ();
         // success redirection
         return redirect ()->back ()->withSuccess ( trans ( 'common.user.delete-success' ) );
      } else {
         // failure redirection
         return redirect ()->back ()->withError ( 'No user present with provided id' );
      }
   }

   public function approveAd($id)
   {
   		return $result = $this->adUser->approveAd($id, APPROVED);
   		
   }

   public function rejectAd($id)
   {
   		return $result = $this->adUser->approveAd($id, REJECTED);
   		
   }

}
