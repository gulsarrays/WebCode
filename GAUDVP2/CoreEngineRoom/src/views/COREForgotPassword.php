<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREForgotPassword.php
  Description                 : To Reset the password of consumer
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>THE BUSINESS JOURNALS - Reset Password</title>
    <link href="<?php echo BASE_URL_STRING ?>/src/views/css/oriole.css" rel="stylesheet">
    <link href="<?php echo S3_STATIC_URL ?>bootstrap-3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="<?php echo S3_STATIC_URL ?>jquery/jquery-2.1.0.min.js"></script>
    <script src="<?php echo BASE_URL_STRING ?>src/views/js/validation.min.js"></script>
</head>
<!--<body style="background-color: #252885;" calss="bkimg">-->
<body  class="bkimg">
<div class="container">
    <font color="white" size="3"><b>
<!--            <div id="successMsg" style="margin-top:2px; display:none"></div>-->
        </b></font>

    <div id="alertMsg" style="margin-top:1%; display: none" class="alert alert-danger"></div>
    <?php if($Data[JSON_TAG_TYPE] == JSON_TAG_SUCCESS)
    {
        ?>
            <div style="display: none">
                <label id="consumerid"><?php print $Data[JSON_TAG_CODE]; ?></label>
            </div>
<!--            <div class="row text-center" style="display: table;height: 100%;margin:0 auto;padding-top:40px">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="display: table-cell;vertical-align: middle;float: none;padding-right:0px;">
                    <img src="<?php echo BASE_URL_STRING.'src/views/images/logo-button.png' ?>" width="100" height="100" class="img-responsive pull-right">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left" style="display: table-cell;vertical-align: middle;float: none;padding-left:0px;">
                    <span class="pull-left"><label style="color: white;font-size:25px;">AUDVISOR</label></span>
                </div>
            </div>-->

            <div class="row text-center" style="display: table;height: 100%;margin:0 auto;padding-top:40px">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="display: table-cell;vertical-align: middle;float: none;padding-right:0px;">
                    <!--<img src="<?php echo BASE_URL_STRING.'src/views/images/logo-button.png' ?>" width="100" height="100" class="img-responsive pull-right">-->
                    <img src="<?php echo BASE_URL_STRING.'src/views/images/logo-button.png' ?>" class="img-responsive pull-right">
                </div>
                <!--<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left" style="display: table-cell;vertical-align: middle;float: none;padding-left:0px;">
                    <span class="pull-left"><label style="color: white;font-size:25px;">AUDVISOR</label></span>
                </div>-->
            </div>
    
                <font color="white" size="3"><b>
                    <br><div id="successMsg" class="row text-center" style="padding-top:25px;padding-left:30px" style="display:none"></div>
        </b></font>
    
    <form id="resetform">
            <div class="row text-center" style="padding-top:25px;padding-left:30px">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <span class="centered" style="color:white;font-weight: normal;font-size:24px;font-face: Maven Pro;">
                            <!--PASSWORD RESET--> Create New Password
                        </span>
                </div>
            </div>
            <div id="errordiv" style="display:none;padding-top:20px" class="row text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="centered"><label style="color:red;font-weight:bold">ERROR</label></span>
                    <font color="red" size="3"><b>
                            <div id="forgotpassworderrormsg" style=""></div>
                        </b></font>
                </div>
            </div>
            <div class="row text-center" style="padding-top:20px">
<!--                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <font color="white" size="2">
                        <div id="successMsg111" style="margin-top:2px;"><?php echo JSON_PASSWORD_HINT; ?></div> <br>
                    </font>
                </div>-->
                
<!--                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <span class="centered">
                            <label style="color:white ">New Password</label>
                        </span>
                </div>-->
                <div>
                        <span>
                            <input id="newpassword" type="password" autocomplete="off" size="35" style="height:35px;border-radius:5px;border:0px;padding-left: 20px;" maxlength="50" placeholder=" New Password">
                        </span>
                </div>
            </div>
            <div class="row text-center" style="padding-top:20px">
<!--                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <span>
                            <label style="color:white;">Confirm Password</label>
                        </span>
                </div>-->
                <div>
                        <span>
                            <input id="confirmpassword" autocomplete="off" style="height:35px;border-radius:5px;border:0px;padding-left: 20px;" size="35" type="password" maxlength="50" placeholder=" Confirm Password">
                        </span>
                </div>
            </div>

            <div class="nav-pills row text-center" style="padding-top:20px">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <span class="pull-right">
                            <button class="btn" style="width:125px;background-color:#2c5ca6;color:#fefefe;border-radius:15px;font-face:Maven Pro;font-style: Medium;font-weight: 17pt" name="submit" type="button" id="Cancel" onclick="forgot_password_cancel();"><b>Cancel</b></button>
                        </span>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <span class="pull-left"> <button class="btn btn-primary" style="width:125px;border-radius:15px;background-color: #ffffff;font-face:Maven Pro;font-style: Medium;font-weight: 17pt;color:#444444" name="submit" type="button" id="save_btn" onclick="forgot_password_reset()"><b>Save</b></button></span>
                </div>
            </div>

            <div class="row" style="visibility: hidden">
                <div class="col-xs-10 col-xs-6"><span class="pull-right" style="color:white "><label>User</label></span>
                </div>

                <div class="col-xs-10 col-xs-6">
                    <label id="email" style="color:white "><?php print $Data[JSON_TAG_EMAILID]; ?></label></div>
            </div>
            </br>
        </form>
    <?php
    }
    else
    {
        ?>
        <div id="alertMsg" style="margin-top:1%; display:none;" class="alert alert-danger">Link has been expired.</div>
        <div></div>
        <form id="resetform">
            <div style="display: none">
                <label id="consumerid"><?php print $Data[JSON_TAG_CODE]; ?></label>
            </div>
            <div class="row text-center" style="display: table;height: 100%;margin:0 auto;padding-top:40px">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="display: table-cell;vertical-align: middle;float: none;padding-right:0px;">
                    <img src="<?php echo BASE_URL_STRING.'src/views/images/logo-button.png' ?>" class="img-responsive pull-right">
                </div>
<!--                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left" style="display: table-cell;vertical-align: middle;float: none;padding-left:0px;">
                    <span class="pull-left"><label style="color: white;font-size:25px;">THE BUSINESS JOURNALS</label></span>
                </div>-->
            </div>


            <div class="row text-center" style="padding-top:25px;padding-left:30px">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="centered" style="color:white;font-weight: 231pt;font-size:23px;font-face: Maven Pro;font-height:17pt;font-style:Medium">
                        <!--PASSWORD RESET--> Create New Password
                    </span>
                </div>
            </div>
            <div id="errordiv" style="display:block;padding-top:20px" class="row text-center">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="centered"><label style="color:red;font-weight:bold">ERROR</label></span>
                    <font color="red" size="3"><b>
                            <div id="forgotpassworderrormsg" style=""></div>
                        </b></font>

                    <div>
                        <span class="centered"> <label id="forgotpassworderrormsg"><font color="red" size="3"><b>Link has been expired.</b></font></label></span>
                    </div>
                </div>
            </div>
            <div class="row text-center" style="padding-top:20px">
<!--                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="centered">
                        <label style="color:white ">New Password</label>
                    </span>
                </div>-->
                <div>
                    <span>
                        <input id="newpassword" type="password" autocomplete="off" size="35" style="height:35px;border-radius:15px;border:0px;padding-left: 20px;" maxlength="50" placeholder="New Password">
                    </span>
                </div>
            </div>
            <div class="row text-center" style="padding-top:20px">
<!--                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span>
                        <label style="color:white;">Confirm Password</label>
                    </span>
                </div>-->
                <div>
                    <span>
                        <input id="confirmpassword" autocomplete="off" style="height:35px;border-radius:15px;border:0px;padding-left: 20px;" size="35" type="password" maxlength="50" placeholder="Confirm Password">
                    </span>
                </div>
            </div>

            <div class="nav-pills row text-center" style="padding-top:20px">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <span class="pull-right">
                        <button class="btn" style="width:125px;background-color:#2c5ca6;color:#fefefe;border-radius:15px;font-face:Maven Pro;font-style: Medium;font-weight: 17pt" name="submit" type="button" id="Cancel" onclick="forgot_password_cancel();"><b>Cancel</b></button>
                    </span>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <span class="pull-left"> <button class="btn btn-primary" style="width:125px;border-radius:15px;background-color: #ffffff;font-face:Maven Pro;font-style: Medium;font-weight: 17pt;color:#444444" name="submit" type="button" id="save_btn" onclick="forgot_password_reset()" disabled="disabled"><b>Save</b></button></span>
                </div>
            </div>
            <div class="row" style="visibility: hidden">
                <div class="col-xs-10 col-xs-6"><span class="pull-right" style="color:white "><label>User</label></span>
                </div>

                <div class="col-xs-10 col-xs-6">
                    <label id="email" style="color:white "><?php !empty($Data[JSON_TAG_EMAILID]) ? print($Data[JSON_TAG_EMAILID]) : ''; ?></label></div>
            </div>
            </br>
        </form>

    <?php
    }
    ?>
</div>
<div class="text-center">        
    <img src="<?php echo BASE_URL_STRING.'src/views/images/vector-smart-object.png' ?>" class="img-responsive center-block">
</div>
<script type="text/javascript">
    var baseurlString = "<?php echo BASE_URL_STRING; ?>";
    var cmsbaseurlString = "<?php echo CMS_BASE_URL_STRING; ?>";
    var apibaseurlString = "<?php echo API_BASE_URL_STRING . API_VERSION . "/"; ?>";
    var environment = "<?php echo (ENVIRONMENT === "Production") ? "" : ((ENVIRONMENT === "Stage") ? "-stage" : "-dev"); ?>"
</script>
<style>
    #save_btn
    {
        width: 130px;
        display: inline-block;
        text-align: center;
    }

    #Cancel
    {
        width: 130px;
        display: inline-block;
        text-align: center;
    }

    #save_btnd
    {
        width: 130px;
        display: inline-block;
        text-align: center;
    }

    #Canceld
    {
        width: 130px;
        display: inline-block;
        text-align: center;
    }
</style>
</body>

</html>