<?php
/*
  Project                     : Oriole
  Module                      : CMS
  File name                   : CORECmsLogin.php
  Description                 : This page is used to login to the CMS.
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">


    <link rel="shortcut icon" href="#">

    <title>Sign In</title>

    <?php
    include 'src/views/header.php';
    $Error = '';
    ?>
</head>

<body>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand"> THE BUSINESS JOURNALS CMS<?php
            if(ENVIRONMENT != "" && ENVIRONMENT != "Production")
            {
                echo "(".ENVIRONMENT.")";
            }
            ?></a>
    </div>
</div>

<noscript>Kindly Enable JavaScript in your Browser</noscript>

<div id="logincontainer" class="container">
    <?php
    $uriParts = explode('/', "$_SERVER[REQUEST_URI]");
    $count    = count($uriParts);
    $j        = 0;
    $newUri   = "";

    for($i = 2; $i < $count; $i++)
    {
        $newUri = $newUri.'/'.$uriParts[$i];
    }
    ?>

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form id="loginForm" class="form-signin" method="POST" action='<?php echo $baseurlString.'home'; ?>' onsubmit="return validateLoginForm()">

                        <div id="alertMsg" class="alert alert-danger"></div>

                        <?php
                        if(!empty($Data))
                        {
                            if(array_key_exists(JSON_TAG_ERROR, $Data))
                            {
                                if($Data[JSON_TAG_ERROR] != '')
                                {
                                    ?>
                                    <div id="loginCredentialsError" class="alert alert-danger">
                                        <?php echo $Data[JSON_TAG_ERROR]; ?>
                                    </div>
                                <?php
                                }
                            }
                        }
                        ?>

                        <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-user"></span>
                                    </span>

                            <input type="text" class="form-control" id="userName" name="txtuserName" placeholder="User Name">
                        </div>
                        <br>

                        <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-lock"></span>
                                    </span>
                            <input type="password" class="form-control" id="password" name="txtpassword" placeholder="Password">

                        </div>
                        <div>
                            <br>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                        <br>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>