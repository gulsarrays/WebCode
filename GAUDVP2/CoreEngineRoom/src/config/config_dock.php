<?php
/*
  Project                     : Oriole
  Module                      : DBManager
  File name                   : config.php
  Description                 : Configurations for oriole.
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

define("REDIS_SCHEME", "tcp");
define("REDIS_DB_HOST", "audvisorcache.zwfi0n.0001.usw2.cache.amazonaws.com");
define("REDIS_PORT", 6379);

/* Docking Station */

define("ENVIRONMENT", "Production");
define("ROLE", "CMS");

define("DB_HOST", "audvisor.cgul9cvwwmt2.us-west-2.rds.amazonaws.com");
define("DB_USER_NAME", "audvisor_rocks");
define("DB_PASSWORD", "silica208!click");
define("DB_NAME", "audvisor");

define("BASE_URL_STRING", "https://cms.audvisor.com/");
define("PREDICTION_IO_APP_KEY", "q4hygVzmjGvx2NHWsupqhLQAOy8Yr8Yaigdc3y9nuttFdRedRgEg27jRCKVC3t43");

define("EMAIL_SMTP_USERNAME", "AKIAJZLUWCVDDELF25EA");
define("EMAIL_SMTP_PASSWORD", "ArWCMc4vHQTfWAYX7sfLSg5bI8B8IDcKmWIEzjjZiVeY");
define("EMAIL_SMTP_SERVER", "email-smtp.us-west-2.amazonaws.com");
define("EMAIL_FROM_ADDRESS", "password-reset@audvisor.com");
define("EMAIL_FROM_NAME", "Audvisor Password Reset Service");

define("API_BASE_URL_STRING", BASE_URL_STRING);
define("CMS_BASE_URL_STRING", BASE_URL_STRING);

/* Common */
define('APP_SESSION_NAME', "user_name");
define('CLIENT_ID', "client_id");
define('COMPANY_NAME', "company_name");

define("S3_STATIC_URL", "//s3-us-west-2.amazonaws.com/audvisor-cms-static/");

define("API_VERSION", "v1");

define('GOOGLE_URL_SHORTNER_API_KEY','AIzaSyB7lFdxKWEHC12ddXSFeBawFiWU3VwjEIA');
define('AES_ENCRYPTION_KEY','1234567891234567');

define('BITLY_URL_SHORTNER_LOGIN_ID','compassites098');
define('BITLY_URL_SHORTNER_API_KEY','R_e1963d195b0f45ada8f531ebaff01fd9');