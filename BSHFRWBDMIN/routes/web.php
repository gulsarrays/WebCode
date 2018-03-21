<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::auth();
// Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
      if (Auth::guest ()) {
         return view ( 'users.login' );
      } else {
         if(isset(auth ()->user ()->user_type)&&(auth ()->user ()->user_type==1)){
            if(auth ()->user ()->hasRole('super-admin')){
              return redirect('dashboard');
            }else{
              return redirect('other/users');
            }
         }
         else{
            return view ( 'users.login' );
         }
      }
    });

    Route::get('error', function () {
        return view ( 'errors.404' );
    });

   Route::get('login',['as'=>'get:login', 'uses'=>'Users\UserController@getLogin']);
   Route::post('login',['as'=>'post:login', 'uses'=>'Users\UserController@postLogin']);
   Route::get('logout',['as'=>'get:logout', 'uses'=>'Users\UserController@getLogout']);
   Route::get('user/forgotpassword',['as'=>'get:forgotpassword', 'uses'=>'Users\UserController@getForgotPassword']);
   Route::post('user/forgotpassword',['as'=>'post:forgotpassword', 'uses'=>'Users\UserController@postForgotPassword']);
// });

Route::group(['middleware' => ['web','auth']], function () {
  Route::resource('access','Users\AccessController');
  Route::get('admin/add','Users\UserController@addStaff');
  Route::post('admin/add','Users\UserController@storeStaff');
  Route::get('sadmin','Users\UserController@getStaff');
  Route::get('admin/edit/{id}','Users\UserController@editStaff');
  Route::post('admin/{id}','Users\UserController@updateStaff');
  Route::get('admin/delete/{id}','Users\UserController@deleteStaff');
  Route::get('profile/edit/{id}','Users\UserController@editStaff');

  Route::get('adUser','Users\AdUserController@getAdUser');
  Route::get('adUser/add','Users\UserController@addStaff'); //AdUserController@createAdUser
  Route::post('adUser/add','Users\AdUserController@storeAdUser');
  Route::get('adUser/edit/{id}','Users\AdUserController@editAdUser');
  Route::post('adUser/{id}','Users\AdUserController@updateAdUser');
  Route::get('adUser/delete/{id}','Users\AdUserController@deleteAdUser');

  Route::get('dashboard',['uses'=>'ConfigController@dashboard']);
  
  // Route::get('user/{id}/{sort?}/{search?}','Users\UserController@getUser');
  Route::get('app-users/{search?}',['as'=>'get:users', 'uses'=>'Users\UserController@getUsers']);
  Route::get('app-users/{userId}',['uses'=>'Users\UserController@updateUserStatus']);
  // Route::get('user/delete/{user_id}',['as'=>'get:userdelete', 'uses'=>'Users\UserController@getDelete']);

  Route::get('other/users/create',['as'=>'users.create', 'uses'=> 'Users\UserController@addStaff']); // create
  Route::post('other/user/create',['as'=>'users.store', 'uses'=> 'Users\UserController@store']);
  Route::get('other/user/{id}',['as'=>'users.show', 'uses'=> 'Users\UserController@show']);
  Route::get('other/user/edit/{id}',['as'=>'users.edit', 'uses'=> 'Users\UserController@edit']);
  Route::post('other/user/update/{id}',['as'=>'users.update','uses'=> 'Users\UserController@update']);
  Route::get('other/users',['as'=>'users.index', 'uses'=>'Users\UserController@getOtherUsers']);
  Route::get('other/user/delete/{user_id}',['as'=>'users.destroy', 'uses'=>'Users\UserController@destroy']);

  Route::post('user/change-password','Users\UserController@changePassword');
  Route::get('change-password',function(){
    return view('users.change-password');
  });
  Route::post('/channelByUser',['uses' => 'Users\ChatsController@getChannelByUser']); 

  Route::get('/others/createcategory',['uses' => 'Others\OthersController@getOthersCreateCategory']); 
  Route::post('/others/createcategory',['uses' => 'Others\OthersController@postAddCategory']); 
  Route::get('others/category/delete/{cid}',['uses' => 'Others\OthersController@deleteCategory']); 
  Route::get('others/category/edit/{cid}',['uses' => 'Others\OthersController@editCategory']); 
  Route::post('/others/category/update',['uses' => 'Others\OthersController@postUpdateCategory']); 

  Route::get('/categories',['uses' => 'Others\OthersController@getCategories']); 
  Route::get('/ageGroups',['uses' => 'Others\OthersController@getageGroups']); 
  Route::get('/gender',['uses' => 'Others\OthersController@getgender']); 

  Route::get('/others/createagegroup',['uses' => 'Others\OthersController@getOthersAgeGroup']); 
  Route::post('/others/createagegroup',['uses' => 'Others\OthersController@postAgeGroup']); 
  Route::get('others/ageGroup/delete/{agid}',['uses' => 'Others\OthersController@deleteAgeGroup']); 
  Route::get('others/ageGroup/edit/{agid}',['uses' => 'Others\OthersController@editAgeGroup']); 
  Route::post('/others/ageGroup/update',['uses' => 'Others\OthersController@postUpdateAgeGroup']); 

  Route::get('hashtag/{name}', 'ConfigController@getHashTag');
  Route::get('hashtag/delete/{name}', 'ConfigController@deleteHashTag');
  Route::resource('settings', 'ConfigController');
  Route::resource('settings/ratecard', 'RateCardConfigController');
  
  Route::get('/audits',['uses' => 'Others\AuditController@getAllAudits']);
  
  // roles routes
  Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);
  Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create']);
  Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store']);
  Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
  Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit']);
  Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update']);
  Route::get('roles/delete/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy']);
  Route::get('getrole/{id}',['as'=>'permission.get','uses'=>'RoleController@getRole']);

// permission routes
  Route::get('permission',['as'=>'permission.index','uses'=>'PermissionController@index']);
  Route::get('permission/create',['as'=>'permission.create','uses'=>'PermissionController@create']);
  Route::post('permission/create',['as'=>'permission.store','uses'=>'PermissionController@store']);
  Route::get('permission/{id}',['as'=>'permission.show','uses'=>'PermissionController@show']);
  Route::get('permission/{id}/edit',['as'=>'permission.edit','uses'=>'PermissionController@edit']);
  Route::patch('permission/{id}',['as'=>'permission.update','uses'=>'PermissionController@update']);
  Route::delete('permission/{id}',['as'=>'permission.destroy','uses'=>'PermissionController@destroy']);

  Route::resource('reports','Channels\ReportController');
  Route::post('reports/{id}', 'Channels\ReportController@update');
  Route::get('reports/delete/{id}', 'Channels\ReportController@destroy');

  Route::post('channels/create/', 'Channels\ChannelController@createChannel');
  Route::get('ad/approve/{id}', 'Users\AdUserController@approveAd');
  Route::get('ad/reject/{id}', 'Users\AdUserController@rejectAd');
  
  Route::get('channels/{chid}', 'Channels\ChannelController@viewChannel');
  Route::get('channel/comments/{content_id}', 'Channels\ChannelController@getComments');
  Route::get('channels/reminder/{chid}', 'Channels\ChannelController@channelReminder');
  Route::post('channels/updateSettings', 'Channels\ChannelController@updateSettings');

  // content repo
  Route::get('content-repo/user-my-channel','Content\ContentRepoController@userMyChannel');
  Route::resource('content-repo','Content\ContentRepoController');

  Route::resource('pj','Content\PjController');
  Route::post('pj/{id}','Content\PjController@update');
  Route::get('pj/delete/{id}', 'Content\PjController@destroy');
  Route::resource('stringer','Content\StringerController');
  Route::post('stringer/{id}','Content\StringerController@update');
  Route::get('stringer/delete/{id}', 'Content\StringerController@destroy');
  
  Route::get('stringer/deleteContent/{content_id}', 'Content\StringerController@deleteContent');
  Route::get('getContent/{content_id}', 'Channels\ChannelController@getContent');
  Route::post('updateContent','Channels\ChannelController@updateContent');
  Route::post('publishContent/{content_id}', 'Content\PjController@publishContent');
  Route::post('unpublishContent/{content_id}', 'Content\PjController@unpublishContent');  
  Route::post('uploadContent','Channels\ChannelController@uploadContent');
  
  //emojis

  Route::resource('emojis/cats','Emojis\CategoryController');
  Route::post('emojis/cats/{id}','Emojis\CategoryController@update');  
  Route::get('emojis/deleteemojistickers/{type}/{id}', 'Emojis\EmojisController@deleteEmojiStickers');
  Route::post('emojis/{id}','Emojis\EmojisController@update');
  Route::get('emojis/cats/deletecategory/{type}/{id}', 'Emojis\CategoryController@deleteCategory');
  Route::resource('emojis','Emojis\EmojisController');

  
  Route::get('getContent/{content_id}', 'Channels\ChannelController@getContentById');
  Route::get('content-repo-data/{id}', 'Content\ContentRepoController@getContentRepoData');


  
  Route::post('other/usersajax','Users\UserController@getOtherUsersAjax');
  Route::get('other/users/download/{type}', 'Users\UserController@downloadOtherUsersCsvExcel');
  
  
  Route::post('app-users-ajax','Users\UserController@getUsersAjax');
  Route::get('app-users/download/{type}', 'Users\UserController@downloadAppUserCsvExcel');
  
  
  Route::post('/audits-ajax','Others\AuditController@getAllAuditsAjax');
  Route::get('/audits/download/{type}', 'Others\AuditController@downloadAuditsCsvExcel');

});
