<?php

/*
  Project                     : Oriole
  Module                      :
  File name                   : index.php
  Description                 : Contains the routes used in oriole.
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');

session_cache_limiter(false);
session_start();
ini_set('display_errors', 1);

require 'vendor/autoload.php';
include('src/config/config_stage.php');
include('src/config/descriptions.php');
include('src/config/jsontags.php');
include('src/config/dbconfig.php');
include('src/config/errorcodes.php');
include('src/config/serverErrorcodes.php');
#include ('src/middleware/COREBasicAuth.php');
include('src/middleware/COREEmbedVersion.php');
include('src/middleware/COREEmbedTimestamp.php');
include('src/middleware/Encrypt.php');
include('src/middleware/PushNotification.php');

include('src/views/COREJsonApiView.php');

date_default_timezone_set('UTC');

use Slim\Slim;


Slim::registerAutoloader();

$app = new Slim();

$app->config(array('templates.path' => 'src/views',));

//k Make sure to make this the first middleware to capture time consumed by other middlewares
$app->add(new \COREEmbedTimestamp());
$app->add(new \COREEmbedVersion());

include('autoload.php');

function APIrequest() {
    $app = \Slim\Slim::getInstance();
    $app->view(new \COREJsonApiView());
}

$app->group('/temp', function () use ($app) {
    $app->get('/insighturl', '\COREInsightUrl:getInsightUrls');

    $app->get('/invalidatecache/:cacheKey', '\COREInvalidateCaching:invalidateCache');
    $app->get('/cacheddata/:cacheKey', 'APIrequest', '\COREInvalidateCaching:getCachedData');
    $app->get('/cacheKeys', 'APIrequest', '\COREInvalidateCaching:getCachedKeys');
    $app->get('/cachetopicids', '\COREInvalidateCaching:cacheTopicIdsForInsights');
    $app->get('/invalidatetopicids', '\COREInvalidateCaching:invalidateCacheForTopicIds');

    //recommendation with redis caching
    $app->post('/recommendations_latest(/)', 'APIrequest', '\COREInsightController:recommended_latestcode');
    $app->post('/recommendations_newcode(/)', 'APIrequest', '\COREInsightController:recommended_insight_newcode');
    $app->post('/recommendations_redis(/)', 'APIrequest', '\COREInsightController:recommended_insight_redis');
    $app->post('/recommendations_rediswithtopicids(/)', 'APIrequest', '\COREInsightController:recommended_insight_redis_topicIds');
    $app->post('/recommendations_withouturls(/)', 'APIrequest', '\COREInsightController:recommended_insight_withouturls');

    $app->get('/createTestData', '\COREInvalidateCaching:loadTestData');
    $app->get('/purgeTestData', '\COREInvalidateCaching:purgeTestData');
});

$app->group('/v1', function () use ($app) {

    // $app->post('/bulk(/)','APIrequest','\COREAdminController:bulk');

    $app->group('/consumers', function () use ($app) {
        $app->post('/signup(/)', 'APIrequest', '\COREConsumerController:signup'); //client_id//
        $app->post('/signin(/)', 'APIrequest', '\COREConsumerController:signin'); //client_id//
        $app->post('/:id/favourites(/)', 'APIrequest', '\COREConsumerController:user_like'); //client_id//
        $app->delete('/:id/favourites/:fid/', 'APIrequest', '\COREConsumerController:user_unlike'); //client_id//
        $app->put('/performpasswordreset(/)', 'APIrequest', '\COREConsumerController:forgot_password_reset'); //client_id//
        $app->put('/requestpasswordreset(/)', 'APIrequest', '\COREConsumerController:forgot_password'); //client_id//
        $app->put('/updatepassword(/)', 'APIrequest', '\COREConsumerController:update_password'); //client_id//
        $app->put('/:id(/)', 'APIrequest', '\COREConsumerController:modify_consumer');
        $app->patch('/:id(/)', 'APIrequest', '\COREConsumerController:patch_consumer');
        $app->delete('/:id/insightlikes/:insightid/', 'APIrequest', '\COREInsightController:insight_unlike'); //client_id//
        $app->post('/getinsightlikes(/)', 'APIrequest', '\COREInsightController:get_insight_likes_list'); //client_id//
        $app->get('/:id/insightlikes', 'APIrequest', '\COREInsightController:insight_likes_list'); //client_id//
        $app->post('/:id/insightlikes(/)', 'APIrequest', '\COREInsightController:insight_like'); //client_id//
        $app->get('/:id/favourites', 'APIrequest', '\COREConsumerController:favourites_list'); //client_id//
        $app->put('/:id/resetpass(/)', 'APIrequest', '\COREConsumerController:reset_password'); //client_id//
        $app->put('/:id/record_action(/)', 'APIrequest', '\COREConsumerController:consumer_analytics'); //client_id//
        $app->post('/devicesignup(/)', 'APIrequest', '\COREConsumerController:device_signup'); //client_id//
        $app->post('/:id/follow(/)', 'APIrequest', '\COREConsumerController:userfollow'); //client_id//
        $app->post('/:id/unfollow/:fid(/)', 'APIrequest', '\COREConsumerController:user_unfollow'); ////request is not there
        $app->get('/:id/followingexperts(/)', 'APIrequest', '\COREConsumerController:following_experts_list'); //client_id//
        $app->get('/:id/followingtopics(/)', 'APIrequest', '\COREConsumerController:following_topics_list'); //client_id//
        
        $app->post('/:id/renewsubscription', 'APIrequest', '\COREConsumerController:renew_subscription');
        $app->get('/:id/checksubscription', 'APIrequest', '\COREConsumerController:check_subscription');
        
        $app->post('/updatewpconsumer', 'APIrequest', '\COREConsumerController:updateWPConsumer');
        $app->get('/:id/consumerprofile', 'APIrequest', '\COREConsumerController:consumer_profile');
        $app->post('/:id/capturetotaltimespentlifetime(/)', 'APIrequest', '\COREConsumerController:capture_total_time_spent_life_time');
        
    });

    $app->group('/insights', function () use ($app) {
        $app->post('/recommendations(/)', 'APIrequest', '\COREInsightController:recommended_insight'); //mobile
        $app->post('/updateInsightShortUrl(/)', 'APIrequest', '\COREInsightController:update_insight_short_url'); //mobile
        $app->post('/featuredInsight(/)', 'APIrequest', '\COREInsightController:getFeaturedInsights'); //mobile
        $app->post('/trendingInsight(/)', 'APIrequest', '\COREInsightController:getTrendingInsights'); //mobile
         $app->get('/r3/:short_code(/)', 'APIrequest', '\COREInsightController:redirect3');//mobile
        $app->get('/r4/:short_code(/)', 'APIrequest', '\COREInsightController:redirect4');//mobile
        $app->get('/:id/disengage', 'APIrequest', '\COREInsightController:disengage_active_user');//mobile
    });

    $app->group('/insights', function () use ($app) {
        $app->get('/:insightid/streaming_url/', 'APIrequest', '\COREInsightController:getStreamingUrl');
        $app->get('/:insightid/share', '\COREInsightController:opengraphSharePage');
        $app->get('/:insight_id(/)', 'APIrequest', '\COREInsightController:list_insight_by_id');
        $app->post('/:id/online(/)', 'APIrequest', '\COREInsightController:onlineInsight');
        $app->post('/:id/togglefeaturedinsight(/)', 'APIrequest', '\COREInsightController:toggleFeaturedInsight');
        $app->post('/:insightId/uploadaudio(/)', 'APIrequest', '\COREInsightController:upload_insight_audio');
        $app->post('/:insightId/uploadvoiceoveraudio(/)', 'APIrequest', '\COREInsightController:upload_insight_voiceover');
        $app->get('(/)', 'APIrequest', '\COREInsightController:insights');
        $app->delete('/:insightId', 'APIrequest', '\COREInsightController:deleteInsight');
        $app->put('/:insightId', 'APIrequest', '\COREInsightController:edit_insight');        
    });

    $app->group('/experts', function () use ($app) {
        $app->get('(/)', 'APIrequest', '\COREExpertController:list_all_experts'); //mobile//===
        $app->get('/advisor(/)', 'APIrequest', '\COREExpertController:list_all_audvisor_experts'); //mobile//===
        $app->get('/:expertId', 'APIrequest', '\COREExpertController:get_expertdetails');

    });

    $app->group('/experts', function () use ($app) {
        $app->delete('/:expertId', '\COREExpertController:deleteExpert');
        $app->put('/:expertId', 'APIrequest', '\COREExpertController:edit_expert');
        $app->get('/:expertId/deleted(/)', 'APIrequest', '\COREExpertController:get_deleted_expertdetails');
        $app->post('/:expertId/reenable(/)', 'APIrequest', '\COREExpertController:re_enable_expert');
        $app->post('/regnew', 'APIrequest', '\COREExpertController:reg_new_expert');
        $app->post('/:expertId/uploadexpertimage(/)', 'APIrequest', '\COREExpertController:dnd_upload_expert_images');
        $app->post('/:expertId/updateexpertimage(/)', 'APIrequest', '\COREExpertController:update_expert_image');
        $app->post('/:expertId/uploadexpertvoiceover(/)', 'APIrequest', '\COREExpertController:upload_expert_voiceover');
    });

    $app->group('/topics', function () use ($app) {
        $app->get('/audvisor(/)', 'APIrequest', '\CORETopicController:list_all_audvisor_topics'); //mobile
        $app->get('/:topicId', '\CORETopicController:get_topicdetails');
        $app->get('(/)', 'APIrequest', '\CORETopicController:list_all_topics'); //mobile   
     });
    $app->group('/groups', function () use ($app) {
        $app->get('(/)', '\COREGroupController:list_grops');
    });
   
    $app->group('/topics', function () use ($app) {
        $app->delete('/:topicId', '\CORETopicController:deleteTopic');
        $app->put('/:topicId', 'APIrequest', '\CORETopicController:edit_topic');
        $app->post('/:topicId/uploadtopicimage(/)', 'APIrequest', '\CORETopicController:upload_topic_images');
    });

    $app->group('/versions', function () use ($app) {
        $app->get('/:platform/latest/', 'APIrequest', '\COREVersionsController:latest_version');
        $app->get('/:platform/:version/', 'APIrequest', '\COREVersionsController:send_bundle_version');
        $app->post('/', 'APIrequest', '\COREVersionsController:add_new_version');
        $app->put('/:versionid', 'APIrequest', '\COREVersionsController:edit_version');
        $app->delete('/:versionid', 'APIrequest', '\COREVersionsController:delete_version');
    });
    $app->group('/promocode', function () use ($app) {
        $app->post('(/)', 'APIrequest', '\COREPromocodeController:addPromocode');
        $app->put('/:promocodeid', 'APIrequest', '\COREPromocodeController:edit_promocode');
        $app->delete('/:promocodeid', 'APIrequest', '\COREPromocodeController:deletePromocode');
    });

    /* changing end */
    $app->get('/admin/dashboard(/)', '\COREAdminController:adminDashBoard');
    $app->get('_ios/appversion/', 'APIrequest', '\COREVersionsController:latest_version');
    $app->post('/addinsights(/)', 'APIrequest', '\COREInsightController:addInsight');
    $app->post('/addtopics(/)', 'APIrequest', '\CORETopicController:addTopic');
    $app->post('/addexperts(/)', 'APIrequest', '\COREExpertController:addExpert');
    $app->post('/generalsettings/', 'APIrequest', '\COREAdminController:update_generalSettings');
    $app->post('/publishpushnotification(/)', 'APIrequest', '\COREAdminController:publishBroadcastMessage');
    $app->post('/addPlayList(/)', 'APIrequest', '\COREPlayListController:addPlayList');
    
    $app->group('/inbox', function () use ($app) {
        $app->get('/', 'APIrequest', '\COREInboxController:list_inbox_data'); //mobile
        $app->post('/searchMembers(/)', 'APIrequest', '\COREInboxController:search_members'); //mobile
        $app->post('/shareInsight(/)', 'APIrequest', '\COREInboxController:share_insight'); //mobile
        $app->put('/markAsRead(/)', 'APIrequest', '\COREInboxController:mark_as_read'); //mobile
        $app->put('/markAsUnRead(/)', 'APIrequest', '\COREInboxController:mark_as_unread'); //mobile
        $app->post('/sortInboxInsightAsc(/)', 'APIrequest', '\COREInboxController:sort_inbox_insight_asc'); //mobile
        $app->post('/sortInboxInsightDesc(/)', 'APIrequest', '\COREInboxController:sort_inbox_insight_desc'); //mobile
        $app->put('/deleteInboxInsight(/)', 'APIrequest', '\COREInboxController:delete_inbox_insight'); //mobile
        $app->get('/insightSharedByme(/)', 'APIrequest', '\COREInboxController:insight_shared_by_me'); //mobile
        $app->delete('/removeInsightSharedByme(/)', 'APIrequest', '\COREInboxController:remove_insight_shared_by_me'); //mobile
    });
    
    $app->group('/playlists', function () use ($app) {
        $app->get('/shuffleExperts(/)', 'APIrequest', '\COREPlayListController:getPlayListInsightsShuffleExperts');
        $app->post('/captureInsightListenTime(/)', 'APIrequest', '\COREPlayListController:captureInsightListenTime');
        $app->post('/createRecentPlayList(/)', 'APIrequest', '\COREPlayListController:createRecentPlayList');
        $app->post('/addToRecentPlayList(/)', 'APIrequest', '\COREPlayListController:addToRecentPlayList');
        $app->get('/recentPlaylist(/)', 'APIrequest', '\COREPlayListController:getRecentPlaylistInsights'); 
        
        $app->post('/createPlayList(/)', 'APIrequest', '\COREPlayListController:createPlayList');
        $app->put('/updatePlayList(/)', 'APIrequest', '\COREPlayListController:updatePlayList');
        $app->put('/deletePlayList(/)', 'APIrequest', '\COREPlayListController:deletePlayList');
        
        $app->post('/addToPlayList(/)', 'APIrequest', '\COREPlayListController:addToPlayList');
        //$app->put('/moveToPlayList(/)', 'APIrequest', '\COREPlayListController:moveToPlayList');
        $app->put('/removeFromPlayList(/)', 'APIrequest', '\COREPlayListController:removeFromPlayList');
        
        $app->post('(/)', 'APIrequest', '\COREPlayListController:getAllPlayLists'); //mobile//===
        $app->post('/:playListId(/)', 'APIrequest', '\COREPlayListController:getPlayListInsights');
        $app->put('/reorder(/)', 'APIrequest', '\COREPlayListController:reorderPlayListInsights');
        $app->put('/reorderPlayList/', 'APIrequest', '\COREPlayListController:reorderPlayLists');

        
        
        //from backend
        $app->put('/update/:playListId', 'APIrequest', '\COREPlayListController:updatePlayListFromBackend');
        $app->put('/delete/:playListId', 'APIrequest', '\COREPlayListController:deletePlayListFromBackend');
        $app->put('/deletePlayListInsights/', 'APIrequest', '\COREPlayListController:deletePlayListInsightsFromBackend');
        $app->put('/updateListOrder/', 'APIrequest', '\COREPlayListController:updatePlayListInsightsListOrder');

    });
    
});
/* CMS API  */
if (ROLE == "CMS") {
    $app->get('/signin(/)', '\COREAdminController:showsignin');
    $app->get('/', '\COREAdminController:showsignin');
    $app->post('/home(/)', '\COREAdminController:login');
    $app->get('/getstatistics(/)', 'APIrequest', '\COREAdminController:getstatistics');
    if (isset($_SESSION[CLIENT_ID])) {
        $app->get('/dashboard(/)', '\COREAdminController:render_dashBoard');
        $app->get('/listinsights(/)', '\COREInsightController:viewInsights');
        $app->get('/listinsights_new(/)', '\COREInsightController:viewInsights_new');
        $app->get('/addinsight(/)', '\COREAdminController:getcms');
        $app->get('/listexperts(/)', '\COREExpertController:viewExperts');
        $app->get('/addexpert(/)', '\COREAdminController:expertadd');
        $app->get('/consumers(/)', '\COREConsumerController:get_consumers_list');
        $app->get('/listtopics(/)', '\CORETopicController:viewTopics');
        $app->get('/addtopic(/)', '\CORETopicController:showaddTopic');
        $app->get('/addversion(/)', '\COREVersionsController:show_addversion');
        $app->get('/listversions(/)', '\COREVersionsController:all_versions');
        $app->get('/addpromocode(/)', '\COREPromocodeController:showaddPromocode');
        $app->get('/listpromocodes(/)', '\COREPromocodeController:viewPromocodes');
        $app->get('/getuseractions(/)', '\COREConsumerController:get_useractions');
        $app->get('/pushnotification(/)', '\COREAdminController:push_notification');
        $app->get('/settings(/)', '\COREAdminController:render_settings');
        $app->get('/viewpasswordreset(/)', '\COREAdminController:CmsPassword_reset');
        $app->post('/passwordreset(/)', 'APIrequest', '\COREAdminController:resetPassword');
        $app->get('/logout(/)', '\COREAdminController:signout');
        
        $app->get('/listgroups(/)', '\COREInsightController:viewGroups');
        $app->get('/addgroup(/)', '\COREAdminController:getcms');
        $app->get('/listplaylist(/)', '\COREPlayListController:viewPlayList');
        $app->get('/addplaylist(/)', '\COREPlayListController:showaddPlayList');
        $app->get('/playlistInsightsView/:playlistid', '\COREPlayListController:playlistInsights');
    }
}
/* web page */
$app->get('/createbuckets/:clientid(/)', 'APIrequest', '\COREConsumerController:createBuckets');
$app->get('/resetpassword(/)', '\COREConsumerController:view_reset_password');

$app->get('/', '\COREAdminController:redirect_to_home');

$app->error('error_handler');

$app->notFound('errorPage');

function error_handler(Exception $e) {
    print_r($e);
}

function errorPage() {
    print_r("404 not found");
}

$app->run();
?>
