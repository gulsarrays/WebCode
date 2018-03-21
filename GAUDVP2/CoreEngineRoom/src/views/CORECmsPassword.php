<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : CORECmsPassword.php
  Description                 : To Reset Password for cms
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

    <title>Reset Password</title>


    <?php
    include 'src/views/header.php';
    ?>


</head>

<body>
<?php include('src/views/navbar.php') ?>
<div id="newtopicAdd">

    <div class="container">
        <div id="successMsg" class="alert alert-success"></div>
        <div id="alertMsg" class="alert alert-danger"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Password Reset</h3>
            </div>
            <div class="panel-body" id="topicaddpanelbody1">


                <form class="form-horizontal">
                    <fieldset>

                        <!-- Form Name -->


                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="CurrentPassword">Current Password</label>

                            <div class="col-md-5">
                                <input id="CurrentPassword" name="CurrentPassword" type="password" placeholder="Current Password" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="NewPassword">New Password</label>

                            <div class="col-md-5">
                                <input id="NewPassword" name="NewPassword" type="password" placeholder="New Password" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Password input-->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="ConfirmPassword">Confirm Password</label>

                            <div class="col-md-5">
                                <input id="ConfirmPassword" name="ConfirmPassword" type="password" placeholder="Confirm Password" class="form-control input-md" required="">

                            </div>
                        </div>

                        <!-- Button -->
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="submit"></label>

                            <div class="col-md-5">
                                <span class="pull-right"> <button id="submit" onclick="cmsresetpassword();" type="button" name="submit" class="btn btn-primary">Submit</button></span>
                            </div>
                        </div>

                    </fieldset>
                    <input type="hidden" id="uname" value="<?php echo $Data[JSON_TAG_USER_ID]; ?>">
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
