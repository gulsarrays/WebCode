<?php

namespace App\Http\Controllers\Users;
// use group models file
use App\Models\Groups;
// use user model file
use App\User;
// use route collector
use Illuminate\Routing\Controller;
// repositroy file
use App\Repository\UserRepository as UserRepository;
// usergroup model file
use App\Models\UserGroup;
use App\Models\Chat;
use App\Models\Archive;
use App\Models\GroupChat;
use App\Models\UserContact;
// use db file
use Illuminate\Support\Facades\DB;
// Vcard model file
use App\Models\Vcard;

class ConversationController extends Controller {
   /**
    */
   public function __construct(UserRepository $user) {
      // constructor function for user
      $this->user = $user;
   }
   
   /**
    *
    * @param string $sort           
    * @param string $search           
    * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
    */
   public function getGroups($sort = 'asc', $search = null) {
      // get the group list details
      
       $groupId = array ();
       $groupCount = array ();
  $userGroup = DB::select("select DISTINCT replace(node.host, '@mix.52.53.39.123', '') as host from pubsub_node as node, pubsub_state as state where state.nodeid=node.nodeid and state.subscriptions != ''");
        $i = 0 ;
         // To get the group Id
         foreach ( $userGroup as $data ) {
			
            $groupId [] = $data->host;
              
         }
          
        // get the contact function otherthan specified user
      $user = Vcard::where ( function ($query) use ($search) {
         if (isset ( $search ) && ! empty ( $search )) {
            $query->where ( 'name', 'LIKE', '%' . $search . '%' )->orWhere ( 'mobile_number', 'LIKE', '%' . $search . '%' );
         }
      } )->where([['username', '!=', ''],['name', '!=', '']])->whereIn('username',$groupId)->orderBy('name', $sort)->paginate ( 10 );
      
      foreach ( $user as $data ) {
			
           
            $host =  $data->username.'@mix';
           
           $groupMembers = DB::select("select count(state.jid) as member_count from pubsub_node as node , pubsub_state as state , pubsub_item as item where (node.node='urn:xmpp:mix:nodes:participants' and node.host like '%$host%')  and
    (node.nodeid = state.nodeid and node.nodeid = item.nodeid) and  item.publisher like CONCAT('%', state.jid ,'%')");
   
           $groupCount[$i] = $groupMembers[0]->member_count;
           $i++;
            
         }

           
             
      // show it in blade function
      return view ( 'group.groups', [ 
                  GROUPS => $user,
                  'memberscount' => $groupCount,
                  'sort' => (! empty ( $sort )) ? $sort : '',
                  SEARCH => (! empty ( $search )) ? $search : '',
		  
      ] );
   
 
   }
   
   /**
    * this function specifies the group details functioanlity
    *
    * @param unknown $groupId           
    * @param string $sort           
    * @param string $search           
    * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
    */
   public function getGroupDetails($id, $sort = 'asc', $search = null) {
          // get the group list details
      
       $groupId = array ();
       $nodeid = array ();
       $host = $id .'@mix';
       $userGroup = DB::select("select  publisher from pubsub_item as item , pubsub_node as node where item.nodeid=node.nodeid and node.host like '%$host%' and node.node ='urn:xmpp:mix:nodes:participants'");
    
         // To get the group Id
         foreach ( $userGroup as $data ) {
			
            $nodeid  = explode('@',$data->publisher);
            $username[] = $nodeid[0]; 
         }
     	
         $users = Vcard::whereIn('username', $username)->get ()->toArray ();
         
         $groups = Vcard::where('username', $id)->get ()->toArray ();
         
   
         
              
     // show it in view blade
      return view ( 'group.group-details', [ 
                  GROUPS => $groups,
                  'group_id' => $id,
                  'contact' => (! empty ( $users )) ? $users : ''
      ] );
   }
  
 

 
   /**
    * Get the contact list for the particular user
    *
    * @param unknown_type $id           
    * @param unknown_type $sort           
    * @param unknown_type $search           
    */
   public function getContacts($id, $search = null) {
      // echo $id;
      $xmppaddr = '@'.env('xmpp');
    	$results = DB::select("select replace(jid, :xmppaddr, '') as username from rosterusers where username = :id", ['xmppaddr' => $xmppaddr, 'id' => $id]);
      // echo '<br/>',count($results);echo '<br/>';
      // print_r($results); echo '<br/>';

      $roasterusers=[];
    	//To get roasterusers.
    	for($z=0;$z<count($results);$z++) {
    		$roasterusers[] = $results[$z]->username;
    	}

	 
      // get the contact function otherthan specified user
      $user = Vcard::where ( function ($query) use ($search) {
         if (isset ( $search ) && ! empty ( $search )) {
            $query->where ( 'name', 'LIKE', '%' . $search . '%' )->orWhere ( 'mobile_number', 'LIKE', '%' . $search . '%' );
         }
      } )->where([['username', '!=', ''],['name', '!=', '']])->whereIn('username',$roasterusers)->paginate ( 10 );
      // print_r($user);
      // show it in blade function
      return view ( 'users.usercontact', [ 
                  USERS => $user,
                  USERNAME => $id,
                  'userid' => $id,
                  'sort' => (! empty ( $sort )) ? $sort : '',
                  SEARCH => (! empty ( $search )) ? $search : '' 
      ] );
   }
   
   /**
    * Get the conversation between the two users
    *
    * @param unknown_type $source           
    * @param unknown_type $destination           
    */
   public function getConversation($source, $destination) {
       // get message from archive
      $senderBroadcast = Archive::where(function($query) use ($source, $destination) {
  		  $query->where(function($query) use ($source, $destination){
  			  $query->where ( 'username', $source )->where('bare_peer',$destination);
  		   })->orWhere(function($query) use ($source, $destination){
  			   $query->where ( 'bare_peer', $source )->where('username',$destination);
  		  });
	    })->orderBy('created_at')->paginate (10);
     
		  
        $userlist = Vcard::where ( USERNAME,$source )->orwhere ( USERNAME,$destination )->get ()->toArray ();
       
        for($i=0;$i<count($userlist);$i++)
        {
		  
  		   $list [$userlist[$i]['username']] = $userlist[$i]['name'];
  	    }
        
      
      
        // show it in a view blade
        return view ( 'users.conversation', [ 
                    'conversations' => $senderBroadcast,
                    'srcuser' => $list 
        ] );
   }
   
   /**
    * Method to get the conversation between the two users
    *
    * @param integer $source           
    * @param integer $destination
    *           return array
    */
   public function getDataCass($sourceUser, $destinationUser) {
      // get single chat from casendra
      return Chat::where ( SENDER, $sourceUser )->where ( 'receiver', $destinationUser )->get ();
   }
   
   /**
    * This function is used to get the group conversation and display it in view page
    *
    * @param int $groupId           
    *
    * @return array
    */
   public function getGroupConversation($groupId) {
      $list = array ();
      $image = array ();
      
            // sender broadcast message from casendra
     $host =  $groupId.'@mix';
     $data = DB::select("select item.payload,item.creation from pubsub_node as node , pubsub_item as item
      where (node.node='urn:xmpp:mix:nodes:messages' and node.host like '%$host%'  and
     node.nodeid = item.nodeid)");
          
           $groupMembers = DB::select("select replace(state.jid, '@52.53.39.123', '') as jid from pubsub_node as node , pubsub_state as state , pubsub_item as item where (node.node='urn:xmpp:mix:nodes:participants' and node.host like '%$host%')  and
    (node.nodeid = state.nodeid and node.nodeid = item.nodeid) and  item.publisher like CONCAT('%', state.jid ,'%')");
   

	//To get roasterusers.
	for($z=0;$z<count($groupMembers);$z++) {
		$roasterusers[] = $groupMembers[$z]->jid;
	}
	
     
   
      foreach ( $roasterusers as $datas ) {
		  
         $userlist = Vcard::where ( USERNAME,$datas )->get ()->toArray ();
        
        if(!empty($userlist)){
         $list [$datas] = $userlist [0]['name'];
         $image [$datas] = $userlist [0]['image'];
        
	 }
      }
     
      // return the conversation in blade
      return view ( 'group.conversation', [ 
                  'conversations' => $data ,
                  'srcuser' => $list,
                  'image' => $image 
      ] );
   }
   
   /**
    * This function is used to get the single user chat
    *
    * @param integer $sourceUser,$destinationUser           
    *
    * @return array
    */
   public function getGroupConversationData($groupId) {
      // Get group conversation
      return GroupChat::WHERE ( 'room', $groupId )->orderby ( 'messageid', 'DESC' )->get ();
   }
  
   /**
    */
   public function getUserContacts() {
      // get contact user function
      return response ()->json ( [ 
                  'error' => false,
                  'reponse' => User::where ( USER_TYPE, 5 )->select ( 'id', 'name', 'mobile_number' )->paginate ( 20 ) 
      ] );
   }
   /**
    * user group information list
    */
   public function getGroupInfo($id, $sort = 'desc', $search = null) {
      // get the user details
     
      // get the group list details
      
       $groupId = array ();
       $groupCount = array ();
       $host = "jid=\'".$id."@";
  $userGroup = DB::select("select DISTINCT replace(node.host, '@mix.52.53.39.123', '') as host from pubsub_node as node , pubsub_state as state ,
    pubsub_item as item where (node.node='urn:xmpp:mix:nodes:participants' and item.payload like '%$host%')  and
    (node.nodeid = state.nodeid and node.nodeid = item.nodeid) and  item.publisher like CONCAT('%', state.jid ,'%')");
   
  
     
   
        $i = 0 ;
         // To get the group Id
         foreach ( $userGroup as $data ) {
			
            $groupId [] = $data->host;
              
         }
          
        // get the contact function otherthan specified user
      $user = Vcard::where ( function ($query) use ($search) {
         if (isset ( $search ) && ! empty ( $search )) {
            $query->where ( 'name', 'LIKE', '%' . $search . '%' )->orWhere ( 'mobile_number', 'LIKE', '%' . $search . '%' );
         }
      } )->where([['username', '!=', ''],['name', '!=', '']])->whereIn('username',$groupId)->orderBy('name', $sort)->paginate ( 10 );
      
      foreach ( $user as $data ) {
			
           
            $host =  $data->username.'@mix';
           
           $groupMembers = DB::select("select count(state.jid) as member_count from pubsub_node as node , pubsub_state as state , pubsub_item as item where (node.node='urn:xmpp:mix:nodes:participants' and node.host like '%$host%')  and
    (node.nodeid = state.nodeid and node.nodeid = item.nodeid) and  item.publisher like CONCAT('%', state.jid ,'%')");
   
           $groupCount[$i] = $groupMembers[0]->member_count;
           $i++;
            
         }

           
             
      // show it in blade function
      return view ( 'group.groups', [ 
                  GROUPS => $user,
                  'memberscount' => $groupCount,
                  'sort' => (! empty ( $sort )) ? $sort : '',
                  SEARCH => (! empty ( $search )) ? $search : '',
		  
      ] );
   
    
   }
   
   /**
    * Get the chat history
    * 
    * @param   $search
    * @param   $from
    * @param   $to
    * 
    * return array
    */
   public function getHistory($sort = '', $search = null, $from = null, $to = null) {
      // To get the chat history details
      $chatHistory = array ();
      $chat = Chat::with ( [ 
                  SENDERDETAILS,
                  RECEIVERDETAILS 
      ] )->where ( function ($query) use ($search, $from, $to) {
         // To get the search parameters
         $username = array ();
         // To check for search terms present in group table
         if (($search != 'null') && ! empty ( $search )) {
               $user = User::where ( NAME, 'like', '%' . $search . '%' )->get ();
               if ($user) {
                  foreach ( $user as $data ) {
                     $username [] = $data [USERNAME];
                  }
               }
            $query->whereIN( 'sender', $username );
         }
         if((isset($from)) && $from!=''){
            $from= date(CURRENTDATE,strtotime($from));
            $to= date(CURRENTDATE,strtotime($to));
         if($from=='null'){
            $query->orWhere( COM_CREATED_AT_KEYWORD,'<=',$to );
         }
         else{
            $query->orwhereBetween( COM_CREATED_AT_KEYWORD,array($from,$to));
         }
         }
         
      } )->paginate ( 10 );
      $i = 0;
      foreach ( $chat as $chatDetails ) {
         $time = round ( $chatDetails [TIME] / 1000000 );
         $chatHistory [$i] [FROM] = $chatDetails->senderDetails [NAME];
         $chatHistory [$i] [TO] = $chatDetails->receiverDetails [NAME];
         $chatHistory [$i] [COM_CHATTYPE_KEYWORD] = 'Chat';
         $chatHistory [$i] [COM_MESSAGE_TYPE_KEYWORD] = $chatDetails [TYPE];
         $chatHistory [$i] [DATETIME] = $chatDetails [COM_CREATED_AT_KEYWORD];
         $i ++;
      }
      // To get the group history details
      $groupHistory = array ();
      $groupChat = GroupChat::with ( [ 
                  'sendUser',
                  'receivedGroup' 
      ] )->where ( function ($queries) use ($search,$from,$to) {
         // To get the search parameters
         $username = array ();
         // To check for search terms present in group table
         if (($search != 'null') && ! empty ( $search )) {
               $user = User::where ( NAME, 'like', '%' . $search . '%' )->get ();
               if ($user) {
                  foreach ( $user as $data ) {
                     $username [] = $data [USERNAME];
                  }
               }
            $queries->whereIN ( 'sender', $username );
         }
         if((isset($from)) && $from!=''){
         $from= date(CURRENTDATE,strtotime($from));
         $to= date(CURRENTDATE,strtotime($to));
         if($from=='null'){
            $queries->orWhere( COM_CREATED_AT_KEYWORD,'<=',$to );
         }
         else{
            $queries->orwhereBetween( COM_CREATED_AT_KEYWORD,array($from,$to));
         }
         }
      } )->paginate ( 10 );
      $j = 0;
      foreach ( $groupChat as $groupDetails ) {
         $time = round ( $groupDetails [TIME] / 1000000 );
         $groupHistory [$j] [FROM] = $groupDetails->sendUser [NAME];
         $groupHistory [$j] [TO] = $groupDetails->receivedGroup [NAME];
         $groupHistory [$j] [COM_CHATTYPE_KEYWORD] = 'Group Chat';
         $groupHistory [$j] [COM_MESSAGE_TYPE_KEYWORD] = $groupDetails [TYPE];
         $groupHistory [$j] [DATETIME] = $groupDetails[COM_CREATED_AT_KEYWORD];
         $j ++;
      }
      // To merge the chat and group history
      if ($sort == 'chat') {
         $chatHistories = $chatHistory;
      } else if ($sort == 'groupchat') {
         $chatHistories = $groupHistory;
      } else {
         $chatHistories = array_merge ( $chatHistory, $groupHistory );
         // To sort the obtained array in desc order
         $this->array_sort_by_column ( $chatHistories, DATETIME );
      }
      
      // return it in blade file
      return view ( 'group.chat-history', [ 
                  CHAT_HISTORY => $chatHistories,
                  DATA => $chat,
                  'sort' => (! empty ( $sort )) ? $sort : '',
                  'search' => (! empty ( $search )) ? $search : '' 
      ] );
   }
   
   /**
    * To sort the array in desc order based on datetime
    *
    * return array
    */
   public function array_sort_by_column(&$array, $column, $direction = SORT_DESC) {
     $reference_array = array();
     foreach($array as $key => $row) {
        $reference_array[$key] = $row[$column];
     }
     array_multisort($reference_array, $direction, $array);
  }
 
}
