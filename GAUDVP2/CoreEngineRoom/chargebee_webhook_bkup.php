<?php
$receivedDataFromChargebee = json_decode(file_get_contents('php://input'), true);
//print_r($receivedDataFromChargebee);

$event_type = $receivedDataFromChargebee['event_type'];

$receivedDataContent = $receivedDataFromChargebee['content'];

$subscriptionContent = $receivedDataFromChargebee['content']['subscription'];
$customerContent = $receivedDataFromChargebee['content']['customer'];

$subscription_id = $subscriptionContent['id'];
$subscription_plan = $subscriptionContent['plan_id'];
$subscription_status = $subscriptionContent['status'];

$subscription_startTimeStamp = $subscriptionContent['current_term_start'];
$subscription_expiryTimeStamp = $subscriptionContent['current_term_end'];

$chargebee_customer_id = $customerContent['id'];
$customer_email = $customerContent['email'];
$customer_firstName = $customerContent['first_name'];
$customer_lastName = $customerContent['last_name'];



$url = "http://54.244.216.214/v1"; // DO NOT END WITH "/"
$accept_variable = "Yml6am91cm5hbHM="; // bizjournal
        
switch ($event_type) {
    case "customer_created":
        
        // {"device_id":12345, "email_id":"gg2@gmail.com", "first_name":"test", "last_name":"test",  "notification_id":1, "password": "password", "platform_id": 1,"wp_user_id":"11","wp_site_name":"customer_wp_site_name","expiry_timestamp":"1508284800"}

        $url .= "/consumers/signup";
        $data = array(
            'device_id' => '123456',
            'first_name'=> $customer_firstName,
            'last_name' => $customer_lastName,
            'email_id' => $customer_email,
            'notification_id'=>'1',
            'password' => '123456',
            'platform_id' => '1',
            "is_password_reset"=>"1",
            "wp_user_id"=>"1",
            "wp_site_name"=>"audvisort.wpengine.com",
            "chargebee_customer_id"=>$chargebee_customer_id
            );
        $json_data = json_encode($data);
            
        _curl($url,$accept_variable,$json_data, $event_type);       
        
        break;
    case "customer_deleted":
              
        
        break;
    
    case "subscription_created":
    case "subscription_renewed":
    case "subscription_cancellation_scheduled":
    case "subscription_cancelling":    
    case "subscription_changed":
    case "subscription_activated":
    case "subscription_reactivated":
    
        
        //{"expiry_timestamp":1502957728,"consumer_emailid":"g19@gmail.com"}
        
        
        $url .= "/consumers/0/renewsubscription";
        $data = array(
            'expiry_timestamp' => $subscription_expiryTimeStamp,
            'consumer_emailid' => $customer_email
            );
        $json_data = json_encode($data);
            
        
        $subscription_startDate = date('Y-m-d h:i:s',$subscription_startTimeStamp);
        $subscription_expiryDate = date('Y-m-d h:i:s',$subscription_expiryTimeStamp);
                
        print_r($json_data);
        echo "subscription_startDate : ".$subscription_startDate.'<br>';
        echo "subscription_expiryDate : ".$subscription_expiryDate.'<br>';
        
        _curl($url,$accept_variable,$json_data, $event_type); 
            
        
        break;
    
    case "subscription_cancelled":
    case "subscription_deleted":

        $url .= "/consumers/0/renewsubscription";
        $data = array(
            'expiry_timestamp' => $subscription_expiryTimeStamp,
            'consumer_emailid' => $customer_email
            );
        $json_data = json_encode($data);
        
        $subscription_startDate = date('Y-m-d h:i:s',$subscription_startTimeStamp);
        $subscription_expiryDate = date('Y-m-d 00:00:00',time());
                
        print_r($json_data);
        echo "subscription_startDate : ".$subscription_startDate.'<br>';
        echo "subscription_expiryDate : ".$subscription_expiryDate.'<br>';
            
        _curl($url,$accept_variable,$json_data, $event_type); 
        
        
        break;
    
    default:
        echo "Not useful event for us!!!";
        break;
}
function _curl($url,$accept_variable,$json_data,$event_type) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept: $accept_variable"));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);//Setting post data as xml
    $result = curl_exec($curl);
    curl_close($curl);
    
    echo "url : ".$url."<br>";
    echo "Event Type : ".$event_type."<br>";
    
    print($result);
}
?>