<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Vcard;
use App\Models\Users;
use Illuminate\Support\Facades\DB;


class BroadcastUsersController extends Controller{
	
	protected $url;
	
	public function __construct(\Illuminate\Routing\UrlGenerator $url)
	{
		$this->url = $url;
	}

	public function index($sort = 'desc', $search = null) {
				
		 // get user details with contacts
      
		 
		if (isset ( auth ()->user ()->user_type ) && (auth ()->user ()->user_type != 1)) {			
			$users = Vcard::where([['fly_users.username', '!=', ''],['fly_users.name', '!=', '']])
         ->join('users', 'users.username', '=', 'fly_users.username')->get();
         //->searchuser ( $sort, $search )->paginate (5);			
		}
		
		
		foreach($users as $user){
			
			$userdetails['user_details'][] = ['username'=>$user->username,'name'=>$user->name,'mobile'=>$user->mobile_number,'image'=>$user->image];			
		   }
			
		return \Response::json(array(
		    		'users_details'=>$userdetails,
		    		'sort' => (! empty ( $sort )) ? $sort : '',
                     'search' => (! empty ( $search )) ? $search : '' 		   		
		));  
	}
	
	public function setSession(){
		
		$selected_values = \Request::input('numbers_selected');
		
		 if (isset ( auth ()->user ()->user_type ) && (auth ()->user ()->user_type != 1)) {		 	
		 	$users = Vcard::whereIn('fly_users.username',$selected_values)->get();
		}
		
		
		 foreach($users as $user){		 	
			 $userdetails['user_details'][] = ['username'=>$user->username,'name'=>$user->name,'mobile'=>$user->mobile_number,'image'=>$user->image]; 
		} 
		
		return \Response::json(array(
				'users_details'=>$userdetails,
		)); 
	}
	
	public function getGroups($sort = 'asc', $search = null){
		
		$groupId = array ();
		$groupCount = array ();
		$userGroup = DB::select("select DISTINCT replace(node.host, '@mix.52.53.39.123', '') as host from pubsub_node as node, pubsub_state as state where state.nodeid=node.nodeid and state.subscriptions != ''");
		$i = 0 ;
		
		foreach ( $userGroup as $data ) {
				
			$groupId [] = $data->host;
		
		}
				
		$user = Vcard::where ( function ($query) use ($search) {
			if (isset ( $search ) && ! empty ( $search )) {
				$query->where ( 'name', 'LIKE', '%' . $search . '%' )->orWhere ( 'mobile_number', 'LIKE', '%' . $search . '%' );
			}
		} )->where([['username', '!=', ''],['name', '!=', '']])->whereIn('username',$groupId)->paginate ( 10 );
		
		foreach ( $user as $data ) {
							 
			$host =  $data->username.'@mix';
			 
			$groupMembers = DB::select("select count(state.jid) as member_count from pubsub_node as node , pubsub_state as state , pubsub_item as item where (node.node='urn:xmpp:mix:nodes:participants' and node.host like '%$host%')  and
					(node.nodeid = state.nodeid and node.nodeid = item.nodeid) and  item.publisher like CONCAT('%', state.jid ,'%')");
			 
			$groupCount[$i] = $groupMembers[0]->member_count;
			$i++;
		
		}
		
		return \Response::json(array(
				'group_details'=>$user,
				'group_count' =>$groupCount
		));
		 					
	}
	
	public function getGroupsSession($sort = 'asc', $search = null){
	
		$selected_values = \Request::input('groups_selected');
			
		$groupId = array ();
		$groupCount = array ();
		$userGroup = DB::select("select DISTINCT replace(node.host, '@mix.52.53.39.123', '') as host from pubsub_node as node, pubsub_state as state where state.nodeid=node.nodeid and state.subscriptions != ''");
		$i = 0 ;
		
		foreach ( $userGroup as $data ) {
		
			$groupId [] = $data->host;
		
		}				
		$user = Vcard::where ( function ($query) use ($search) {
			if (isset ( $search ) && ! empty ( $search )) {
				$query->where ( 'name', 'LIKE', '%' . $search . '%' )->orWhere ( 'mobile_number', 'LIKE', '%' . $search . '%' );
			}
		} )->where([['username', '!=', ''],['name', '!=', '']])->whereIn('username',$selected_values)->get();
		 return \Response::json(array(
				'group_details'=>$user,
		)); 
	}
	
}
