<?php
/**
 * The following constants are going to hold the variable names
* which we are going to use in entire application
*
*
*/
define('TOKEN_TIME', 3.629e+6);
define('ACCESS_TOKEN','access_token');
define('ASSET_UPLOAD', '/assets/uploads/');
define('CLASS_VAL', 'class');
define('CLIENTS', 'Clients');
define('DATA','data');
define('CONFIRMPASSWORD','confirmpassword');
define('EMAIL', 'email');
define('ERROR','error');
define('FOREIGN_ID', 'foreign_id');
define('GET_CLIENTS', 'get:clients');
define('ID', 'id');
define('GROUP_ID', 'group_id');
define('IMAGE','image');
define('VIDEO','video');
define('BROADCAST_URL','get:broadcast');
define('BROADCAST','broadcast');
define('IS_ACTIVE', 'is_active');
define('LOGO_IMAGE','logo_image');
define('UPLOAD_URL','/assets/img/profiles/');
define('NAME','name');
define('NEWPASSWORD','newpassword');
define('PASSWORD', 'password');
define('RECEIPTS', 'receipts');
define('RESPONSE','response');
define('RESPONSE_CODE','response_code');
define('SEARCH','search');
define('SELECT_CLIENTS_DELETED','Selected Client successfully deleted.');
define('TOKEN', 'token');
define('USER','user');
define('CONTACT','contact');
define('CONTENT','content');
define('TITLE','title');
define('MESSAGE','message');
define('SENDER','sender');
define('RECEIVER','receiver');
define('MEDIA_URL','media_url');
define('TYPE','type');
define('PIN','pin');
define('USER_TYPE','user_type');
define('USERS','users');
define('GROUPS','groups');
define('GROUPCHAT','groupchat');
define('CHAT','chat');
define('USERNAME','username');
define('REQUIRED','required');
define('REQUIRED_NUMERIC','required|numeric');
define('REQUIRED_PASS','required|min:8');
define('REQUIRED_DOMAIN','required|min:6');
define('REQUIRED_MAX','required|max:200');
define('REQUIRED_MAX_MESSAGE','required|max:800');
define('WHOOPS_WRONG', 'Whoops, Something went wrong.');
define('API_KEY','AIzaSyDCnTSOdFBN7i-waomLF4887i11Tq_l2XE');
define('PUSH_PRODUCTION','false');
define('MAX_UPLOAD_SIZE','max_upload_size');
define('SIP_DOMAIN','sip_domain');
define('XMPP_HOST','xmpp_host');
define('OAUTH_URL_REQUIRED','oauth_url');
define('REST_API_URL_REQUIRED','rest_api_url');
define('REQUIRED_URL','required|url');
define('SIP_URL_REQUIRED','sip_url');
define('GCM_SENDER_ID','gcm_sender_id');
define('AWS_ACCESS_KEY','aws_access_key');
define('AWS_SECRET_KEY','aws_secret_key');
define('AWS_BUCKET_NAME','aws_bucket_name');
define('BUSINESS_SPECIFIC_SETTINGS','business_specific_settings');
define('SIP_PASSWORD','sip_password');
define('COM_GENDER_VALUE', 'gender');
define('COM_ERROR_KEY', 'error');
define('COM_RESPONSE_KEY', 'response');
define('COM_REQUIRED_KEYWORD', 'required');
define('COM_TOTALPAGE_KEYWORD', 'totalpage');
define('COM_PROFILE_NAME_KEYWORD', 'profile_name');
define('COM_TITLE_KEYWORD', 'title');
define('COM_DESCRIPTION_KEYWORD', 'description');
define('COM_ACCESSTOKEN_KEYWORD', 'access_token');
define('COM_EMAIL_KEYWORD', 'email');
define('COM_MOBILE_NUMBER_KEYWORD', 'mobile_number');
define('COM_COUNTRY_KEYWORD', 'country');
define('COM_IMAGE_KEYWORD', 'image');
define('COM_NAME_KEYWORD', 'name');
define('COM_PASSWORD_KEYWORD', 'password');
define('COM_NEW_PASSWORD_KEYWORD', 'new_password');
define('COM_USER_ID_KEYWORD', 'user_id');
define('COM_VERIFY_CODE_KEYWORD', 'verify_code');
define('COM_COUNTRY_CODE_KEYWORD', 'country_code');
define('COM_ADMIN_KEYWORD', 'admin');
define('COM_MESSAGE_KEYWORD', 'message');
define('COM_USERTYPE_KEYWORD', 'user_type');
define('COM_CONTACT_USER_ID_KEYWORD', 'contact_user_id');
define('COM_USERNAME_KEYWORD', 'username');
define('COM_DEVICE_ID_KEYWORD', 'device_id');
define('COM_USER_INDEX_KEYWORD', 'users/index');
define('COM_SITENAME_KEYWORD', 'compassitesfly');
define('COM_GENERAL_TYPE_KEYWORD', 'general');
define('COM_USER_NOT_FOUND_KEYWORD', 'Users not found');
define('COM_STATUS_KEYWORD', 'status');
define('COM_MIDDLEWARE_AUTH_KEYWORD', 'middleware');
define('COM_DASHBOARD_KEYWORD', 'dashboard');
define('COM_USERS_KEYWORD', 'users');
define("GOOGLE_API_KEY", "AIzaSyCcQprJG7z2-tKmPTNgPNx0SkpQPGyGVRk");
define("GOOGLE_GCM_URL", "https://android.googleapis.com/gcm/send");
define('COM_SUCCESSFUL_MESSAGE', ' succesfully');
define('COM_SIMPLEAUTH','simpleauth');
define('COM_SITENAME_MAIL_TEMPLATE',"##SITENAME##");
define('COM_FROM_MAIL_TEMPLATE','from_email');
define('COM_SITENAME_VARIABLE','site_name');
define('COM_CREATED_AT_KEYWORD', 'created_at');
define('COM_DELETED_AT_KEYWORD', 'deleted_at');
define('COM_TOTAL_KEYWORD', 'total');
define('COM_LATITUDE_KEYWORD', 'latitude');
define('COM_LONGITUDE_KEYWORD', 'longitude');
define('COM_RADIUS_KEYWORD', 'radius');
define('LOGIN_SUCCESS','Successfully logged in.');
define('EVENTNAME','eventName');
define('EVENTACTION','eventAction');
define('MEMBERID','memberId');
define('SENDERUSERNAME','senderUsername');
define('RECEIVERUSERNAME','receiverUsername');
define('KEY','key');
define('REACHED','reached');
define('NOT_REACHED','not_reached');
define('USERNOTFOUND','User Not found');
define('WEBPASSWORD','web_password');
define('UNABLE_TO_SEND_DELEIVERY_RESPONSE', 'Unable to send the deleivery response to the Server');
define('SUCCESSFULLY_SEND_DELEIVERY_RESPONSE', 'Delivery response is send to server successfully');
define('XMPP_ADDRESS', 'xmpp.address');
define('XMPP_IP', 'xmpp.ip');
define('COM_DATA_KEYWORD', 'data');
define('COM_MESSAGE_ID_KEYWORD', 'message_id');
define('COM_MESSAGEID_KEYWORD', 'messageid');
define('COM_MESSAGE_FROM_KEYWORD', 'message_from');
define('COM_MESSAGE_TO_KEYWORD', 'message_to');
define('COM_MESSAGE_TYPE_KEYWORD', 'message_type');
define('LANG_RESOURCE_NOT_EXIST','common.resource_not_exist');
define('NOT_EQUAL','!=');
define('KEY_SECRET','@compassites');
define('ROUTE_GET_USERS','get:users');
define('ROUTE_GET_LOGIN','get:login');
define('ROUTE_GET_CHANNELS','get:channels');
define('ROUTE_GET_BROADCASTS','get:broadcast');
define('ROUTE_GET_SETTINGS','get:settings');
define('DEVICE_TOKEN','device_token');
define('DEVICE','device');
define('INCOMINGCALL','Incoming Call');
define('COM_CHATTYPE_KEYWORD', 'chat_type');
define('SENDERDETAILS','senderDetails');
define('RECEIVERDETAILS','receiverDetails');
define('TIME','time');
define('FROM','from');
define('CHAT_HISTORY','chat_history');
define('TO','to');
define('DATETIME','datetime');
define('SENDUSER','sendUser');
define('CURRENTDATE','Y-m-d H:i:s');
define('MESSAGE_TIME','message_time');
define('pjRoleId',env('pjRoleId'));
define('stringerRoleId',env('stringerRoleId'));

// API URLS
define('BASE_API', env('CHANNEL_API').'channels/api/v1/');
define('API_BASE_URL', env('CHANNEL_API').'channels/api/v1/channel/');
define('AD_API_BASE', env('AD_API').'ad/api/v1/');

define('CREATE_CHANNEL', 'createChannel');
define('UPATE_CHANNEL', 'update');
define('GET_MYCHANNELS', 'myChannel');
define('GET_CHANNEL_USERS', 'userdetails/channel-id?channelId=');

// age-groups
define('GET_AGEGROUPS', 'age-group/all');
define('GET_ALL_AGEGROUPS', 'age-group/admin/all');
define('CREATE_AGEGROUP_API','age-group/create');
define('DELETE_AGEGROUP_API','age-group/delete');
define('FETCH_AGEGROUP_API','age-group/retrieve');
define('UPDATE_AGEGROUP_API','age-group/soft-delete');

//categories
define('GET_CATEGORIES', 'category/all');
define('GET_ALL_CATEGORIES', 'category/admin/all');
define('CREATE_CATEGORY_API','category/create');
define('FETCH_CATEGORY_API','category/retrieve');
define('UPDATE_CATEGORY_API','category/update');
define('DELETE_CATEGORY_API','category/delete');
define('GET_GENDER','gender/allActive');
// define('UPDATE_AGEGROUP_API','age-group/update');


define('CHANNEL_ACCOUNT', 'Business Account');
define('AD_ACCOUNT', 'Ad Account');

// report content
define('GET_REPORTS', 'content/report/comment/list');
define('GET_REPORT_TYPES', 'content/report/commentCategory/listAll');
define('CREATE_REPORT_TYPE','content/report/commentCategory/create');
define('EDIT_REPORT_TYPE','content/report/commentCategory/get');
define('UPDATE_REPORT_TYPE','content/report/commentCategory/edit');
define('DELETE_REPORT_TYPE','content/report/commentCategory/delete');
define('DELETE_REPORT_CONTENT','content/suspend');

// channels
define('CHANNEL_SUBS_COUNT_API', 'admin/businesschannel-and-subscribers-count/');
define('GET_PAID_CHANNELS','channels?channelType=PP');
define('GET_SPONSORED_CHANNELS','channels?channelType=PS');
define('FETCH_CHANNEL_CONTENT', 'content/channel-id/list?channelId=');
define('FETCH_CONTENT_COMMENT', env('CHANNEL_API').'channels/api/v1/channels/'.'social/comment/getCommentsByContentId?contentId=');
define('SEND_REMINDER', 'admin/reminder?channel_id=');

// ad settings
define('FETCH_SETTINGS_API', 'settings/getAllSettings');
define('UPDATE_SETTINGS_API', 'settings/update');
define('EDIT_SETTINGS_API', 'settings/getSettingByName');
define('LIST_ADS', 'process/ad/listAds');
define('GET_AD', 'process/ad/getAdvertisement?adId=');
define('APPROVE_AD', 'process/ad/approveAdvertisement');
define('APPROVED', 'APPROVED');
define('REJECTED', 'REJECTED');
define('REJECT_MSG', 'Rejected by Bushfire Admin');

// RATECARDS API
define('LIST_RATECARDS','ad/ratecard/listRateCards?status=1');
define('GET_RATECARDS','ad/ratecard/getRateCard?rateCardId=');
define('UPDATE_RATECARDS','ad/ratecard/modifyRateCard');

//hashtags
define('LIST_HASHTAGS', 'es/hashtags/list');
define('DELETE_HASHTAGS', 'es/hashtags/delete?hashtag=');
define('TRENDING_HASHTAGS', env('CHANNEL_API').'channels/api/v1/'.'hashtag/trending');
define('KEYWORD_DEARCH', env('CHANNEL_API').'channels/api/v1/'.'keyword/search?keyword=');
define('AUTO_SEARCH', env('CHANNEL_API').'channels/api/v1/'.'autosuggest/search?keyword=');

// settings
define('EMAIL_SETTING', 'settings/getSettingByName');
define('UPDATE_EMAIL_SETTING', 'settings/update');

//content-repo
define('MAP_STRINGER','pj-stunner/create-transaction?pjId=');
define('GET_PJ_CHANNEL_ID',BASE_API.'pj-data/channel-id?userId=');
define('GET_PJ_CONTENTS',env('CHANNEL_API').'channels/api/v1/'.'pj-data/pj-content');
define('GET_STRINGER_CONTENTS',env('CHANNEL_API').'channels/api/v1/'.'pj-data/stunner-content');
define('GET_ALL_USERMYCHANNEL_CONTENTS',env('CHANNEL_API').'channels/api/v1/'.'pj-data/channels/type?channelType=UC');

define('UPLOAD_CONTENT','content/upload');
define('UPDATE_CONTENT','content/update');

define('GET_STRINGER_ID_LIST',env('CHANNEL_API').'channels/api/v1/'.'pj-data/stringer-id/list');
define('DELETE_CONTENT_DETAILS', env('CHANNEL_API').'channels/api/v1/channel/'.'content/delete?contentId=');
define('FETCH_CONTENT_DETAILS', env('CHANNEL_API').'channels/api/v1/channel/'.'content/details/id?contentId=');

define('PJ_PUBLISH_CONTENT', env('CHANNEL_API').'channels/api/v1/'.'pj-data/publish?contentId=');
define('PJ_UNPUBLISH_CONTENT', env('CHANNEL_API').'channels/api/v1/'.'pj-data/unpublish?contentId=');

define('CONTENT_PATH', env('CHANNEL_API').'channels/api/v1/channel/content/getContent/');

define('GET_PJSTRINGER_CONTENTS', env('CHANNEL_API').'channels/api/v1/channel/'.'admin/list/pjstringercontent');

// emoji end points
// define('CREATE_EMOJI_STICKER_CATEGORY',BASE_API.'');
define('UPDATE_EMOJI_STICKER_CATEGORY',BASE_API.'emojistickers/category/update');
// define('DELETE_EMOJI_STICKER_CATEGORY',BASE_API.'');
define('LIST_EMOJI_STICKER_CATEGORY',BASE_API.'emojistickers/category/fetch?type=');
define('GET_EMOJI_STICKER_CATEGORY',BASE_API.'emojistickers/category/get?id=');

define('LIST_EMOJIS', BASE_API.'emojistickers/list?type=');
define('DELETE_EMOJIS_STICKER', BASE_API.'emojistickers/delete?id=');
define('GET_EMOJI_STICKER_DATA', BASE_API.'emojistickers/get?id=');
define('UPDATE_EMOJI_STICKER_DATA', BASE_API.'emojistickers/update');
define('UPLOAD_EMOJI_STICKER_DATA', BASE_API.'emojistickers/upload-data');
//define('UPLOAD_EMOJI_STICKER_DATA', BASE_API.'emojistickers/uploadEmojiSticker');
define('ADD_EMOJI_STICKER_CATEGORY', BASE_API.'emojistickers/category/add');
define('DELETE_EMOJIS_STICKER_CATEGORY', BASE_API.'emojistickers/category/delete?id=');
define('UPLOAD_FILE_DATA_RESTRICTION', '26214400'); // 25 MB