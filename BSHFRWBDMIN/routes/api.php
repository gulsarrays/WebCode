<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix'=>'v1'],function(){
  // User module API response
   Route::resource ( 'user', 'Api\UserApiController@store' );
   Route::resource ( 'user/create', 'Api\UserApiController@create' );
   Route::post ( 'user/delete', 'Api\UserApiController@destroy' );
   Route::post ( '{id}/edit', 'Api\UserApiController@editProfile' );
   Route::post ( '{id}/updateprofle', 'Api\UserApiController@updateProfile' );

   // User module verify API response
   Route::post ( 'user/verify', 'Api\UserApiController@verifyOTP' );
   // To sync the users
   Route::resource ( 'contactsync', 'Api\ContactSyncController@store' );
   
   //Broad cast to a single user
   Route::post('send-broadcast','Api\PushApiController@sendBroadcastToUser');
   
   //Notification for SIP call
   Route::post('send-call-notification/{type}','Api\PushApiController@sendNotificationToUser');
   //To get the user contacts
   Route::get('get-contacts','Users\ConversationController@getUserContacts');
   //To get the verification details
   Route::post('get-userdetails','Api\BroadcastApiController@getVerificationDetails');
   //To get the pin details
   Route::post('get-pin','Api\BroadcastApiController@getPin');
   //To set the pin details
   Route::post('set-pin','Api\BroadcastApiController@setPin');
   //To get the domain details
   Route::get('settings/domain','Api\BroadcastApiController@getDomains');
   //To get the settings details
   Route::get('settings/{id}','Api\BroadcastApiController@getSettings');
   Route::group(['middleware' => 'auth:api'],function(){
       //To post the message details
       Route::post('message/delivered','Api\MessageController@sendDeliveryResponse');    
        //To get the broadcast details
       Route::post('get-broadcasts','Api\BroadcastApiController@getBroadcast');
   });
   Route::post('user/login','Api\UserApiController@handleUserLogin');
   Route::post('message/send', 'Api\MessageController@sendMessage');
   // Route::get('login','Api\UserApiController@userLogin');
});
