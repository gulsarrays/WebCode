<?php
/*
  Project                     : Oriole
  Module                      :
  File name                   : jsontags.php
  Description                 : Contains JSON tags and Static Strings
  Copyright                   : Copyright © 2014, Audvisor Inc.
                                Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */
define("JSON_TAG_TYPE", "type");
define("JSON_TAG_ID", "id");
define("JSON_TAG_CREATED_DATE", "created_at");
define("JSON_TAG_MODIFIED_DATE", "modified_at");
define("JSON_TAG_LINK", "link");
define("JSON_TAG_REQUEST_URL", "request_url");
define("JSON_TAG_DEEPLINK_QUERY_PARAMS", "deeplink_query_params");
define("JSON_TAG_EMAIL_NOT_FOUND", "Email Address not found");
define("JSON_TAG_LINK_EXPIRED", "link Expired");
define("JSON_TAG_EXPERT", "expert");
define("JSON_TAG_CONSUMER_UID", "consumer_uid");
define("JSON_TAG_SUCCESS", "success");

define("INSIGHT_UPLOAD_FAIL", "insight upload failed");
define("VOICE_OVER_UPLOAD_FAIL", "Voice-Over upload failed");
define("JSON_TAG_PASSWORD_DOESNT_MATCH", "Password doesnt match");
define("JSON_TAG_EMPTY_ARRAY", "Returned null from database");
define("JSON_TAG_POSTDATA_ERROR", "Post data error");
define("JSON_TAG_HASHED_PASSWORD_NULL", "Hashed password is null");
define("JSON_TAG_HASHED_PASSWORD", "hashedpassword");
define("JSON_TAG_TOPICS", "topics");
define("JSON_TAG_GROUPS", "groups");
define("JSON_TAG_EXPERT_ID", "expert_id");
define("JSON_TAG_TOPIC_ID", "topic_id");
define("JSON_TAG_EXPERT_IDS", "expert_ids");
define("JSON_TAG_TOPIC_IDS", "topic_ids");
define("JSON_TAG_TOPIC_NAME", "topic_name");
define("JSON_TAG_EXPERT_NAME", "expert_name");
define("JSON_TAG_EXPERTS", "experts");
define("JSON_TAG_CONSUMER", "consumer");
define("JSON_TAG_TITLE", "title");
define("JSON_TAG_EXPERT_BIO", "expert_bio");
define("JSON_TAG_STREAMINGURL", "streaming_url");
define("JSON_TAG_SECURE_STREAMING_URL", "secure_streaming_url");
define("JSON_TAG_STREAMING_FILENAME_V4", "streaming_url_hlsv4");
define("JSON_TAG_AVATAR_LINK", "avatar_link");
define("JSON_TAG_AVATAR_LINK_2X", "avatar_link_2x");
define("JSON_TAG_AVATAR_LINK_3X", "avatar_link_3x");
define("JSON_TAG_AVATAR_LINK_2X_THUMBNAIL", "avatar_link_2x_thumbnail");
define("JSON_TAG_AVATAR_LINK_3X_THUMBNAIL", "avatar_link_3x_thumbnail");
define("JSON_TAG_NO_FAVOURITES", "no favourites");
define("JSON_TAG_API_VERSION", "api_version");
define("JSON_TAG_SETTINGS_KEY", "fldsettingsname");
define("JSON_TAG_SETTINGS_VALUE", "fldsettingsvalue");
define("JSON_TAG_INSIGHT_DURATION", "duration");
define("JSON_TAG_LISTVIEW_IMAGE", "listview_image");
define("JSON_TAG_PREFIX", "prefix");
define("JSON_TAG_LISTEN_COUNT","listen_count");
define("JSON_TAG_NAME", "name");
define("JSON_TAG_FIRST_NAME", "firstname");
define("JSON_TAG_MIDDLE_NAME", "middlename");
define("JSON_TAG_LAST_NAME", "lastname");
define("JSON_TAG_FIR_NAME", "first_name");
define("JSON_TAG_MID_NAME", "middle_name");
define("JSON_TAG_LA_NAME", "last_name");
define("JSON_TAG_INSIGHT_NAME", "insight_name");
define("JSON_TAG_INSIGHT_URL", "insight_url");
define("JSON_TAG_EXPERT_IMAGE", "expert_image");
define("JSON_TAG_INSIGHTS", "insights");
define("JSON_TAG_INSIGHT", "insight");
define("JSON_TAG_FAVOURITES", "favourites");
define("JSON_TAG_PASSWORD", "password");
define("JSON_TAG_INSIGHT_ID", "insight_id");
define("JSON_TAG_INSIGHT_IDS", "insight_ids");
define("JSON_TAG_DEVICE_ID", "device_id");
define("JSON_TAG_PLATFORM_ID", "platform_id");
define("JSON_TAG_GROUP_ID", "group_id");
define("JSON_TAG_NOTIFICATION_ID", "notification_id");
define("JSON_TAG_EXPERT_TITLE", "expert_title");
define("JSON_TAG_EMAIL", "email_id");
define("JSON_TAG_CONSUMER_ID", "consumer_id");
define("JSON_TAG_REFERRAL_LINK", "referral_link");

define("JSON_TAG_REFERRAL_ID", "referral_id");
define("JSON_TAG_SUBTITLE", "subtitle");
define("JSON_TAG_COUNT", "count");
define("JSON_TAG_DESC", "description");
define("JSON_TAG_ERROR", "error");
define("JSON_TAG_CODE", "code");
define("LOGO_UPLOAD_FAIL", "logo_upload_failed");
define("JSON_TAG_STATUS", "status");
define("JSON_TAG_EMAILID", "email_id");
define("JSON_TAG_ERRORS", "errors");
define("JSON_TAG_NEW_PASSWORD", "new_password");
define("JSON_TAG_OLD_PASSWORD", "old_password");
define("JSON_TAG_YES", "yes");
define("JSON_TAG_NO", "no");
define("JSON_TAG_TOPIC", "topic");
define("JSON_TAG_FAVORITE_INSIGHT", "favourite_insight");
define("JSON_TAG_LIKE_INSIGHT", "like_insight");
define("JSON_TAG_DATA", "Data");
define("JSON_TAG_ISONLINE", "isonline");
define("JSON_TAG_CONSUMERS", "consumers");
define("JSON_TAG_MASTER", "master");
define("JSON_TAG_ACTION_ID", "action_id");
define("JSON_TAG_ACTION_DATA", "action_data");
define("JSON_TAG_RECEIVER_ID", "receiver_id");
define("JSON_TAG_ALL_INSIGHTS", "insights");
define("JSON_TAG_ALL_EXPERTS", "experts");
define("JSON_TAG_ALL_TOPICS", "topics");
define("JSON_TAG_DELETED", "deleted");
define("JSON_TAG_INSIGHT_COUNT", "insightcount");
define("JSON_TAG_TOPIC_COUNT", "topiccount");
define("JSON_TAG_EXPERT_COUNT", "expertcount");
define("ERRCODE_SERVER_EXCEPTION_GET_STATUS", "Server Error");
define("JSON_TAG_STATISTICS", "statistics");
define("JSON_TAG_STATIC_REPUTATION", "staticreputation");
define("JSON_TAG_USERACTIONS", "actions");
define("JSON_TAG_USER_ACTIONS", "user_actions");
define("JSON_TAG_ANALYTICS_ID", "analytics_id");
define("JSON_TAG_RECEIVER_TYPE", "receiver_type");
define("JSON_TAG_APP_VERSION", "app_version");
define("JSON_TAG_APP_STORE_URL", "app_store_url");
define("JSON_TAG_VERSION_DESC", "version_description");
define("JSON_TAG_BUNDLE_VERSION", "bundle_version");
define("JSON_TAG_VERSION", "version");
define("JSON_TAG_MANDATORY_UPDATE", "mandatory_update");
define("JSON_TAG_MODE", "mode");
define("JSON_TAG_FAVORITE_TOPICS", "favorite topics");
define("JSON_TAG_ACTION", "action");
define("JSON_TAG_PIO_IIDS", "pio_iids");
define("JSON_TAG_RESPONSE_BODY", "response_body");
define("JSON_TAG_RESPONSE_STSTUS", "response_status");
define("JSON_TAG_URL", "url");
define("JSON_TAG_RECORDS", "records");
define("JSON_TAG_REC_INSIGHTS", "recommended insights");
define("JSON_TAG_RECORD", "record");
define("JSON_TAG_RESULT_BODY", "resultbody");
define("JSON_TAG_HTTP_STATUS", "httpstatus");
define("JSON_TAG_INSIGHT_INSERT_FAIL", "insight insert fail");
define("JSON_TAG_INSIGHT_NOT_AVAILABLE", "Insight not available");
define("JSON_TAG_INSIGHT_DELETE_FAIL", "Insight delete fail");
define("JSON_TAG_LIKES", "likes");
define("JSON_TAG_EXPERT_BIO_IMAGE", "expert_bio_image");
define("JSON_TAG_EXPERT_THUMBNAIL_IMAGE", "expert_thumbnail_image");
define("JSON_TAG_EXPERT_PROMO_IMAGE", "expert_promo_image");
define("JSON_TAG_EXPERT_PROMO_TITLE", "expert_promo_title");
define("JSON_TAG_INSIGHT_VOICE_OVER_URL", "insight_voiceoverurl");
define("JSON_TAG_EXPERT_VOICE_OVER_URL", "expert_voiceoverurl");
define("JSON_TAG_TOKEN", "token");
define("JSON_TAG_INSIGHT_CREATED_DATE", "insightcreateddate");
define("JSON_TAG_INSIGHT_MODIFIED_DATE", "insightmodifieddate");

define("JSON_TAG_FLD_ID", "fldid");
define("JSON_TAG_FLD_NAME", "fldname");
define("JSON_TAG_FLD_INSIGHT_URL", "fldinsighturl");
define("JSON_TAG_FLD_STREAMING_URL", "fldstreamingurl");
define("JSON_TAG_FLD_EXPERT_ID", "fldexpertid");
define("JSON_TAG_FLD_CREATED_DATE", "fldcreateddate");
define("JSON_TAG_FLD_MODIFIED_DATE", "fldmodifieddate");
define("JSON_TAG_FLD_ISONLINE", "fldisonline");
define("JSON_TAG_FLD”_STATIC_REPUTATION", "fldstaticreputation");
define("JSON_TAG_FLD_FIRST_NAME", "fldfirstname");
define("JSON_TAG_FLD_LAST_NAME", "fldlastname");
define("JSON_TAG_FLD_DESCRIPTION", "flddescription");
define("JSON_TAG_FLD_TITLE", "fldtitle");
define("JSON_TAG_FLD_3X_THUMBNAIL", "fldavatarurl_3x_thumbnail");
define("JSON_TAG_FLD_2X_THUMBNAIL", "fldavatarurl_2x_thumbnail");
define("JSON_TAG_FLD_3X_IMAGE", "fldavatarurl_3x");
define("JSON_TAG_FLD_2X_IMAGE", "fldavatarurl_2x");
define("JSON_TAG_FLD_AVATAR_URL", "fldavatarurl");
define("JSON_TAG_FLD_MANADTORYUPDATE", "fldmandatoryupdate");
define("JSON_TAG_FLD_APPVERSION", "fldappversion");
define("JSON_TAG_FLD_APPSTORE_URL", "fldappstoreurl");
define("JSON_TAG_FLD_VERSION_DESCRIPTION", "fldversiondescription");
define("JSON_TAG_FLD_BUNDLE_VERSION", "fldbundleversion");
define("JSON_TAG_FLD_TOPIC_COUNT", "topiccount");
define("JSON_TAG_FLD_ISDELETED", "fldisdeleted");
define("JSON_TAG_FLD_S3_AVATARURL", "flds3avatarurl");
define("JSON_TAG_FLD_CONSUMER_ID", "fldconsumerid");
define("JSON_TAG_FLD_DEVICE_SIGNUP", "flddevicesignup");
define("JSON_TAG_FLD_EMAIL_ID", "fldemailid");
define("JSON_TAG_FLD_EMAIL", "email");
define("JSON_TAG_FLD_USER_COUNT", "user_count");
define("JSON_TAG_FLD_INSIGHT_ID", "insightid");
define("JSON_TAG_FLD_EXPERTID", "expertid");
define("JSON_TAG_FLD_EXPERT_TITLE", "experttitle");
define("JSON_TAG_FLD_TOPIC_ID", "topicid");
define("JSON_TAG_FLD_TOPIC_NAME", "topicname");
define("JSON_TAG_RANDOM_STRING_LENGTH", 5);
define("JSON_TAG_FLD_BIO_IMAGE", "fldbioimage");
define("JSON_TAG_FLD_THUMB_IMAGE", "fldthumbimage");
define("JSON_TAG_FLD_PROMO_IMAGE", "fldpromoimage");
define("JSON_TAG_FBSHARE_TITLE", "fbshare_title");
define("JSON_TAG_FBSHARE_IMAGE", "fbshare_image");
define("JSON_TAG_FBSHARE_DESC", "fbshare_description");
define("JSON_TAG_PROMO_TITLE", "promotitle");
define("JSON_TAG_FLD_PROMO_TITLE", "fldpromotitle");
define("JSON_TAG_FLD_INSIGHT_NAME", "insightname");
define("JSON_TAG_FLD_EXPERT_SUBTITLE", "experttitle");
define("JSON_TAG_FLD_TOPIC_ICON", "fldiconurl");
define("JSON_TAG_FLD_RATING", "fldrating");
define("JSON_TAG_FLD_WEIGHTING", "fldweighting");
define("JSON_TAG_FLD_VOICEOVER_URL", "fldvoiceoverurl");
define("JSON_TAG_FLD_INSIGHT_VOICEOVER_URL", "fldinsightvoiceoverurl");

define("JSON_TAG_RATING", "rating");
define("JSON_TAG_WEIGHTING", "weighting");

define ("JSON_TAG_TOPIC_ICON", "topic_icon");

define("JSON_TAG_PROMO_IMAGE", "promotional_image");
define("JSON_TAG_BIO_IMAGE", "bio_image");
define("JSON_TAG_THUMBNAIL_IMAGE", "thumbnail_image");
define("JSON_TAG_FLD_STATIC_REPUTATION", "fldstaticreputation");
define("JSON_TAG_S3_AVATARURL", "s3avatarurl");
define("JSON_TAG_USER_ID", "user_id");
define("JSON_TAG_LIVE_INSIGHT_COUNT", "live_insightCount");
define("JSON_TAG_LIVE_EXPERT_COUNT", "live_expertCount");
define("JSON_TAG_LIVE_TOPIC_COUNT", "live_topicCount");
define("JSON_TAG_USER_COUNT_DEVICE", "device_signup_count");
define("JSON_TAG_USER_COUNT", "user_count");
define("JSON_TAG_PLATFORM", "platform");
define("JSON_TAG_MESSAGE", "message");
define("JSON_TAG_DEVICE_COUNT", "device_count");
define("JSON_TAG_CONSUMER_COUNT", "consumer_count");
define("JSON_TAG_FAVOURITE_COUNT", "fav_count");
define("JSON_TAG_RECEIVER_NAME", "receivername");
define("JSON_TAG_TOP_INSIGHTS", "top_insights");
define("JSON_TAG_TWITTER_HANDLE", "twitter_handle");
define("JSON_TAG_PROMO_CODE", "promo_code");
define("JSON_TAG_PROMO_CODES", "promo_codes");
define("JSON_TAG_START_DATE", "start_date");
define("JSON_TAG_END_DATE", "end_date");
define("JSON_TAG_PROMO_COUNT", "promocount");
define("JSON_TAG_PROMOCODE_ID", "promocode_id");
define("JSON_TAG_PROMOCODE_COUNT", "promocode_count");
define("JSON_TAG_LIKE_COUNT", "like_count");
define("JSON_TAG_FBSHARE_COUNT", "fbshare_count");
define("JSON_TAG_SMSSHARE_COUNT", "smsshare_count");
define("JSON_TAG_TWITTERSHARE_COUNT", "twittershare_count");
define("JSON_TAG_CLIENT_ID", "client_id");
define("JSON_TAG_TOTALSHARE_COUNT", "totalshare_count");


define("JSON_FB_KEY", "fb_token_key");
define("JSON_AES_KEY", "aes_token_key");

define("JSON_TAG_STREAMINGURL_ENC", "streaming_url_enc");
define("JSON_TAG_STREAMING_FILENAME_V4_ENC", "streaming_url_hlsv4_enc");


define("JSON_TAG_MEMBER_SEARCH_STRING", "search_for");
define("JSON_TAG_SHARE_WITH_CONSUMER_ID_STRING", "share_with_consumer_id");
define("JSON_TAG_SHARED_INSIGHT_STRING", "shared_insight");
define("JSON_TAG_INBOX_IDS", "inbox_ids");
define("JSON_TAG_INBOX_ID", "inbox_id");
define("JSON_TAG_INBOX_INSIGHT_SHARED_ON_DATED", "shared_on_dated");
define("JSON_TAG_INBOX_INSIGHT_SORT_BY", "sort_by");
define("JSON_TAG_INBOX_INSIGHT_SHARED_BY_NAME", "shared_by_name");
define("JSON_TAG_INBOX_INSIGHT_SHARED_BY_EMAIL", "shared_by_email");


define("JSON_TAG_NOTIFICATION_TITLE", "Working Good");
define("JSON_TAG_NOTIFICATION_BODY", "That is all we want");
define("JSON_TAG_DEVICE_OS_ANDROID", "android");
define("JSON_TAG_DEVICE_OS_IOS", "ios");


if(ENVIRONMENT === "Production") {
    define("STATIC_BUCKET_NAME_CLIENT_ID", "audvisor11012017"); //prod
} else {
    define("STATIC_BUCKET_NAME_CLIENT_ID", "compassites");// stage
}

define("ANDROID_PUSH_NOTIFICATION_API_KEY", "AAAA--45TnY:APA91bHUu1iob4EuY2AJFoTfvPFHHSzijDjphJ7XS5shBcMvLnMa3DTKwl9AQlRpLeL59nhIfcRFmW0H1k1g9spTVkBRC2Iypm8sSN33HUSzTZBlFonL6uYurPl2v0cwlHH-4vHBUT5x");
define("IOS_PUSH_NOTIFICATION_PASS_PHRASE", "compassites");
define("WIN_PUSH_NOTIFICATION_CHANNEL_NAME", "compassites");


define("DB_COLUMN_IS_PASSWORD_RESET", "is_password_reset");
define("JSON_TAG_IS_PASSWORD_RESET", "is_password_reset");

define("JSON_TAG_PLAY_LIST_NAME", "playlist_name");
define("JSON_TAG_PLAY_LIST_INSIGHTS", "playlist_insights");
define("JSON_TAG_PLAY_LIST_ID_FROM", "playlist_id_from");
define("JSON_TAG_PLAY_LIST_ID", "playlist_id");
define("JSON_TAG_PLAY_LIST_IDS", "playlist_ids");
define("JSON_TAG_CLIENT_PLAY_LIST", "client_play_list");
define("JSON_TAG_LIST_ORDER", "list_order");

define("JSON_PAGE_NO", "page_no");

define("JSON_TAG_DISPLAY_INSIGHT_LIMIT", "100");

define("JSON_TAG_DISPLAY_DATE_FORMAT", 'F d, Y'); //August 12, 2018

if(ENVIRONMENT === "Production" ) {
    define("JSON_TAG_WP_URL", 'http://www.thebusinessjournalsedge.com'); 
} else {
    define("JSON_TAG_WP_URL", 'http://audvisordev.wpengine.com'); 
}

define("JSON_PASSWORD_HINT", "<b>Hint:</b> The password should be at least twelve characters long. <br>To make it stronger, use upper and lower case letters, <br>numbers, and symbols like ! \" ? $ % ^ & ).'"); 



define("JSON_TAG_RECENT_PLAY_LIST_NAME", 'Recently Played'); 
define("JSON_TAG_RECENT_PLAY_LIST_INSIGHTS_COUNT", '20'); 

define("JSON_TAG_FEATURED_INSIGHT_COUNT", '20');
define("JSON_TAG_PEGINATION_REQUIREMENT_TEXT", 'pegination');
define("JSON_TAG_SELECTED_INSIGHTS_TEXT", 'selected_insights_arr');
define("JSON_TAG_DISPLAY_INSIGHT_UNLIMITED", '999999999');

define("JSON_TAG_MULTIPLE_PLAYLIST_IDS_ARRAY", 'playlistids_arr');
define("JSON_TAG_ADD_AS_FAVORITES_INSIGHT", 'add_to_favorites');
define("JSON_TAG_LIST_MY_FAVORITES_INSIGHTS", 'list_my_favorites');
define("JSON_TAG_MY_FAVORITE_INSIGHT_PLAYLIST_NAME", "My Favorites");

define("JSON_TAG_INSIGHT_ADDED_IN_PLAYLIST_SUCCESSFULLY", "Successfully added the selected insight to the playlist");
define("JSON_TAG_INSIGHT_ADDED_IN_MYFAVORITES_SUCCESSFULLY", "Successfully added the insight to My Favorites playlist");
define("JSON_TAG_PLAYLIST_CREATED_SUCCESSFULLY", "Successfully created a new playlist");
define("JSON_TAG_PLAYLIST_ALREADY_EXISTS", "There is already an existing playlist with the same name. Please choose another name.");
define("JSON_TAG_CANNOT_ADD_INSIGHTS_IN_PLAYLIST", "You can not add insight into this playlist");
define("JSON_TAG_PLAY_LIST_INSIGHTS_DURATION", "playlist_insights_duration");

define("JSON_TAG_PLAY_LIST_INSIGHTS_DURATION_CAPTURE_SUCCESS", "Insight duration captured successfully");
define("JSON_TAG_PLAY_LIST_SHUFFLE_EXPERTS", "Shuffle Experts Playlist");
define("JSON_TAG_PLAY_LIST_SHUFFLE_EXPERTS_LIMIT", "25");

define("JSON_TAG_WP_URL_INCORRECT", "Wordpress URL is incorrect.");
define("JSON_TAG_TOTAL_TIME_SPENT_LIFE_TIME_IN_SEC", "total_time_spent_life_time_in_sec");

define("JSON_TAG_REQUEST_OTP", "request_otp");
define("JSON_TAG_OTP_VALUE", "otp_value");
define("JSON_TAG_IS_OTP_VALIDATED", "is_otp_validated");
define("JSON_TAG_IS_OTP_LENGTH", "4");
if(!defined('NO_REPLY_EMAIL_FROM_ADDRESS')) {
    define("NO_REPLY_EMAIL_FROM_ADDRESS", "no-reply@thebusinessjournalsedge.com");
}
define("JSON_TAG_OTP_NEEDED", "opt_needed");