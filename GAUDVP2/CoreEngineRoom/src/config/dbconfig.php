<?php

/*
  Project                     : Oriole
  Module                      :
  File name                   : dbconfig.php
  Description                 : Contains dbcolumn  tags and Static Strings
  Copyright                   : Copyright © 2014, Audvisor Inc.
                                Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

define("DB_TABLE_EXPERTS", "tblexperts");
define("DB_TABLE_TOPICS", "tbltopics");
define("DB_TABLE_CONSUMERANALYTICS", "tblconsumeranalytics");
define("DB_TABLE_CONSUMERS", "tblconsumers");
define("DB_TABLE_FAVOURITES", "tblfavourites");
define("DB_TABLE_STATIONS", "tblstations");
define("DB_TABLE_TOPIC_INSIGHT", "tbltopicinsight");
define("DB_TABLE_USER", "tbluser");
define("DB_TABLE_APP_VERSION_INFO", "tblappversioninfo");
define("DB_TABLE_USER_STATIONS", "tbluserstations");
define("DB_TABLE_PASSWORD_RESET", "tblpasswordreset");
define("DB_TABLE_INSIGHT_LIKES", "tblinsightlikes");
define("DB_TABLE_INSIGHTS", "tblinsights");


define("DB_COLUMN_FLD_ID", "fldid");
define("DB_COLUMN_FLD_PREFIX", "fldprefix");
define("DB_COLUMN_FLD_NAME", "fldname");
define("DB_COLUMN_FLD_INSIGHT_URL", "fldinsighturl");
define("DB_COLUMN_FLD_STREAMING_URL", "fldstreamingurl");
define("DB_COLUMN_FLD_STREAMING_FILENAME", "fldstreamingfilename");
define("DB_COLUMN_FLD_STREAMING_FILENAME_V4", "fldstreamingfilenamehlsv4");
define("DB_COLUMN_FLD_EXPERT_ID", "fldexpertid");
define("DB_COLUMN_FLD_CREATED_DATE", "fldcreateddate");
define("DB_COLUMN_FLD_MODIFIED_DATE", "fldmodifieddate");
define("DB_COLUMN_FLD_ISONLINE", "fldisonline");
define("DB_COLUMN_FLD”_STATIC_REPUTATION", "fldstaticreputation");
define("DB_COLUMN_FLD_FIRST_NAME", "fldfirstname");
define("DB_COLUMN_FLD_MIDDLE_NAME", "fldmiddlename");
define("DB_COLUMN_FLD_LAST_NAME", "fldlastname");
define("DB_COLUMN_FLD_DESCRIPTION", "flddescription");
define("DB_COLUMN_FLD_TITLE", "fldtitle");
define("DB_COLUMN_FLD_3X_THUMBNAIL", "fldavatarurl_3x_thumbnail");
define("DB_COLUMN_FLD_2X_THUMBNAIL", "fldavatarurl_2x_thumbnail");
define("DB_COLUMN_FLD_3X_IMAGE", "fldavatarurl_3x");
define("DB_COLUMN_FLD_2X_IMAGE", "fldavatarurl_2x");
define("DB_COLUMN_FLD_AVATAR_URL", "fldavatarurl");
define("DB_COLUMN_FLD_MANADTORYUPDATE", "fldmandatoryupdate");
define("DB_COLUMN_FLD_APPVERSION", "fldappversion");
define("DB_COLUMN_FLD_APiVERSION", "fldapiversion");
define("DB_COLUMN_FLD_APPSTORE_URL", "fldappstoreurl");
define("DB_COLUMN_FLD_VERSION_DESCRIPTION", "fldversiondescription");
define("DB_COLUMN_FLD_BUNDLE_VERSION", "fldbundleversion");
define("DB_COLUMN_FLD_TOPIC_COUNT", "topiccount");
define("DB_COLUMN_FLD_ISDELETED", "fldisdeleted");
define("DB_COLUMN_FLD_S3_AVATARURL", "flds3avatarurl");
define("DB_COLUMN_FLD_CONSUMER_ID", "fldconsumerid");
define("DB_COLUMN_FLD_DEVICE_SIGNUP", "flddevicesignup");
define("DB_COLUMN_FLD_TOKEN", "fldtoken");
define("DB_COLUMN_FLD_HASHED_PASSWORD", "fldhashedpassword");
define("DB_COLUMN_FLD_CLIENT_ID", "client_id");
define("DB_COLUMN_FLD_RECEIVER_ID", "fldreceiverid");
define("DB_COLUMN_FLD_ACTION_ID", "fldactionid");
define("DB_COLUMN_FLD_ACTION_DATA", "fldactiondata");
define("DB_COLUMN_FLD_RECEIVER_TYPE", "fldreceivertype");
define("DB_COLUMN_FLD_TIME_STAMP", "fldtstamp");
define("DB_COLUMN_FLD_TABLE_INSIGHT_ID", "fldinsightid");
define("DB_COLUMN_FLD_INSIGHT_DURATION", "fldduration");
define("DB_COLUMN_FLD_LISTVIEW_IMAGE", "fldlistviewimage");
define("DB_COLUMN_FLD_FBSHARE_IMAGE", "fldfbshareimage");
define("DB_COLUMN_FLD_FBSHARE_DESC", "fldfbsharedescription");

define("DB_COLUMN_FLD_EMAIL", "email");
define("DB_COLUMN_FLD_USER_COUNT", "user_count");
define("DB_COLUMN_FLD_INSIGHT_ID", "insightid");
define("DB_COLUMN_FLD_EXPERTID", "expertid");
define("DB_COLUMN_FLD_EXPERT_TITLE", "experttitle");
define("DB_COLUMN_FLD_TWITTER_HANDLE", "fldtwitterhandle");
define("DB_COLUMN_FLD_TOPIC_ID", "topicid");
define("DB_COLUMN_FLD_TOPIC_NAME", "topicname");
define("DB_COLUMN_FLD_BIO_IMAGE", "fldbioimage");
define("DB_COLUMN_FLD_THUMB_IMAGE", "fldthumbimage");
define("DB_COLUMN_FLD_PROMO_IMAGE", "fldpromoimage");
define("DB_COLUMN_FLD_PROMO_TITLE", "fldpromotitle");
define("DB_COLUMN_FLD_INSIGHT_NAME", "insightname");
define("DB_COLUMN_FLD_EXPERT_SUBTITLE", "experttitle");
define("DB_COLUMN_FLD_TOPIC_ICON", "fldiconurl");
define("DB_COLUMN_FLD_RATING", "fldrating");
define("DB_COLUMN_FLD_WEIGHTING", "fldweighting");
define("DB_COLUMN_FLD_VOICEOVER_URL", "fldvoiceoverurl");
define("DB_COLUMN_FLD_INSIGHT_VOICEOVER_URL", "fldinsightvoiceoverurl");
define("DB_COLUMN_FLD_STATIC_REPUTATION", "fldstaticreputation");
define("DB_COLUMN_TABLE_FLD_TOPIC_ID", "fldtopicid");

#------ Table General Settings ------------
define("DB_TABLE_GENERAL_SETTINGS", "tblgeneralsettings");

define("DB_COLUMN_FLD_SETTINGS_NAME", "fldsettingsname");
define("DB_COLUMN_FLD_SETTINGS_VALUE", "fldsettingsvalue");

define("DB_COLUMN_FLD_EMAIL_ID", "fldemailid");
define("DB_COLUMN_FLD_EMAIL_PASSWORD", "fldemailpassword");
define("DB_COLUMN_FLD_INSIGHT_WEIGHTING", "fldinsightweighting");
define("DB_COLUMN_FLD_EXPERT_WEIGHTING", "fldexpertweighting");
define("DB_COLUMN_FLD_FIRST_LISTENED_WEIGHT", "fldfirstmostlistenedweight");
define("DB_COLUMN_FLD_SECOND_LISTENED_WEIGHT", "fldsecondmostlistenedweight");
define("DB_COLUMN_FLD_THIRD_LISTENED_WEIGHT", "fldthirdmostlistenedweight");
define("DB_COLUMN_FLD_FOURTH_LISTENED_WEIGHT", "fldfourthmostlistenedweight");
define("DB_COLUMN_FLD_MINIMUM_LISTENED_COUNT", "fldminimumlistenedcount");
define("DB_COLUMN_FLD_RECOMMENDED_INSIGHT_LIMIT", "fldrecommendedinsightlimit");
define("DB_COLUMN_FLD_START_DATE", "fldstartdate");
define("DB_COLUMN_FLD_END_DATE", "fldenddate");
define("DB_COLUMN_FLD_PROMOCODE", "fldpromocode");


#------ Table tbluserdevices ------------

define("DB_TABLE_USER_DEVICES", "tbluserdevices");

define("DB_UD_COLUMN_FLD_ID", "fldid");
define("DB_UD_COLUMN_FLD_DEVICE_ID", "flddeviceid");
define("DB_UD_COLUMN_FLD_CONSUMER_ID", "fldconsumerid");
define("DB_UD_COLUMN_FLD_NOTIFICATION_ID", "fldnotificationid");
define("DB_UD_COLUMN_FLD_PLATFORM_ID", "fldplatformid");
define("DB_UD_COLUMN_FLD_ENDPOINT_ARN", "fldendpointARN");

#------ Table tbluserdevicesnotificationsubscriptions ------------

define("DB_TABLE_USER_DEVICES_NOTIFICATION_SUBSCRIPTIONS", "tbluserdevicesnotificationsubscriptions");

define("DB_UDNS_COLUMN_FLD_ID", "fldid");
define("DB_UDNS_COLUMN_FLD_USER_DEVICE_ID", "flduserdeviceid");
define("DB_UDNS_COLUMN_FLD_SUBSCRIPTION_ARN", "fldsubscriptionARN");

?>
