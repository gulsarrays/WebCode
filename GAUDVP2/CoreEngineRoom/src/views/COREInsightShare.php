<?php
/*
  Project                     : Oriole
  Module                      : Share
  File name                   : COREInsightShareFacebook.php
  Description                 : This page is used render open graph story in FB..
  Copyright                   : Copyright © 2015, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */
?>


<!DOCTYPE html>
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# audvisor: http://ogp.me/ns/fb/audvisor#">
    <title>THE BUSINESS JOURNALS - <?php echo $this->data[JSON_TAG_FBSHARE_TITLE]; ?></title>
    <meta charset="utf-8">

    <meta name="apple-itunes-app" content="app-id=963008985, app-argument=audvisor://fbshare">

    <meta property="fb:app_id" content="562600233842057"/>
    <meta property="og:site_name" content="Audvisor">

    <meta property="og:type" content="audvisor:insight"/>

    <meta property="og:title" content="<?php echo $this->data[JSON_TAG_FBSHARE_TITLE]; ?>"/>
    <meta property="audvisor:insight_title" content="<?php echo $this->data[JSON_TAG_TITLE]; ?>"/>
    <meta property="og:description" content="<?php echo $this->data[JSON_TAG_FBSHARE_DESC]; ?>"/>

    <meta property="og:image" content="<?php echo $this->data[JSON_TAG_FBSHARE_IMAGE]; ?>"/>
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>

    <meta property="og:url" content="<?php echo $this->data[JSON_TAG_REQUEST_URL]; ?>"/>

    <meta property="og:audio" content="<?php echo $this->data[JSON_TAG_STREAMINGURL]; ?>"/>
    <meta property="og:audio:url" content="<?php echo $this->data[JSON_TAG_STREAMINGURL]; ?>"/>
    <meta property="og:audio:secure_url" content="<?php echo $this->data[JSON_TAG_SECURE_STREAMING_URL]; ?>"/>
    <meta property="og:audio:type" content="audio/vnd.facebook.bridge"/>

    <meta property="al:android:app_name" content="Audvisor"/>
    <meta property="al:android:package" content="com.audvisor.audvisorapp.android"/>
    <meta property="al:android:url" content="audvisor://fbshare<?php if(isset($this->data[JSON_TAG_DEEPLINK_QUERY_PARAMS])) { echo $this->data[JSON_TAG_DEEPLINK_QUERY_PARAMS]; } ?>"/>

    <meta property="al:ios:app_name" content="Audvisor"/>
    <meta property="al:ios:app_store_id" content="963008985"/>
    <meta property="al:ios:url" content="audvisor://fbshare<?php if(isset($this->data[JSON_TAG_DEEPLINK_QUERY_PARAMS])) { echo $this->data[JSON_TAG_DEEPLINK_QUERY_PARAMS]; } ?>"/>

    <meta property="al:web:should_fallback" content="false"/>

    <meta name="twitter:card" content="summary_large_image">
    <!-- <meta name="twitter:card" content="player"> -->
    <meta name="twitter:site" content="@audvisor">
    <meta name="twitter:creator" content="<?php echo $this->data[JSON_TAG_TWITTER_HANDLE]; ?>">
    <meta name="twitter:title" content="<?php echo $this->data[JSON_TAG_TITLE]; ?>">
    <meta name="twitter:description" content="<?php echo $this->data[JSON_TAG_FBSHARE_DESC]; ?>"/>

    <meta name="twitter:image" content="<?php echo $this->data[JSON_TAG_FBSHARE_IMAGE]; ?>">
    <meta name="twitter:image:width" content="1200"/>
    <meta name="twitter:image:height" content="630"/>

    <meta name="twitter:player:stream" content="<?php echo $this->data[JSON_TAG_SECURE_STREAMING_URL]; ?>"/>
    <meta name="twitter:player:stream:content_type" content="audio/aac"/>

    <meta name="twitter:app:name:iphone" content="Audvisor" />
    <meta name="twitter:app:id:iphone" content="963008985" />
    <meta name="twitter:app:url:iphone" content="audvisor://fbshare<?php if(isset($this->data[JSON_TAG_DEEPLINK_QUERY_PARAMS])) { echo $this->data[JSON_TAG_DEEPLINK_QUERY_PARAMS]; } ?>" />
    
    <meta name="twitter:app:name:googleplay" content="Audvisor" />
    <meta name="twitter:app:id:googleplay" content="com.audvisor.audvisorapp.android" />
    <meta name="twitter:app:url:googleplay" content="audvisor://fbshare<?php if(isset($this->data[JSON_TAG_DEEPLINK_QUERY_PARAMS])) { echo $this->data[JSON_TAG_DEEPLINK_QUERY_PARAMS]; } ?>" />

    <link href='//fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet' type='text/css'>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//s3-us-west-2.amazonaws.com/audvisor-cms-static/bootstrap-3.3.2/css/bootstrap.min.css">

    <style>

        .expert {
            top: 0;
            left: 0;
            right: 0;
            width:100%;
            height:auto;
            max-height: 630px;
            padding:0px;
            margin:0px;
            background-position:center;
            background-repeat:no-repeat;
            position:relative;
            display: block;
            margin-left: auto;
            margin-right: auto;
            overflow:hidden;
        }

        .expertImage {
            background-image:url('<?php echo $this->data[JSON_TAG_FBSHARE_IMAGE]; ?>');
        }

        .insight-title h2 {
            font-family: 'Titillium Web', sans-serif;
            text-indent: 16px;
            text-decoration: underline;
            color:white;
        }

        .insight-description p {
            font-family: 'Titillium Web', sans-serif;
            text-indent: 16px;
            text-decoration: none;
            text-align: justify;
            position: relative;
            color:white;
        }


        .store-links {
            width:300px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }


    </style>
</head>

<body style="margin: 0px;" bgcolor="#252885">
<div class="container-fluid" style="background-color: #252885;">
    <div>
        <a href="http://www.audvisor.com">

            <div class="row">
                <div class="expert">
                    <img  class="img-responsive" style="justify-content: center;height: auto; margin:0px;padding: 0px;display:block; left:0;  right:0;  top:0;  margin:auto;" src="<?php echo $this->data[JSON_TAG_FBSHARE_IMAGE]; ?>" alt="Audvisor">
                </div>
            </div>

            <div class="row">
                <div class="insight-title">
                    <h2><?php echo $this->data[JSON_TAG_FBSHARE_TITLE]; ?></h2>
                </div>
            </div>

            <div class="insight-description">
                <p><?php echo$this->data[JSON_TAG_FBSHARE_DESC] ;?></p>
            </div>
        </a>
    </div>

    <div class="store-links">
        <a href="https://itunes.apple.com/us/app/audvisor/id963008985?ls=1&amp;mt=8"><img src="http://www.audvisor.com/wp-content/themes/audvisor/images/slider-app-store-img.png" class="app-store"></a>
        <a href="https://play.google.com/store/apps/details?id=com.audvisor.audvisorapp.android"><img src="http://www.audvisor.com/wp-content/themes/audvisor/images/slider-google-play-img.png" class="google-play"></a>
    </div>
</div>
</body>
</html>
