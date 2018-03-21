<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREPushnotification.php
  Description                 : To Send push notification from cms
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
    <title>Push Notifications</title>
    <?php
    include 'src/views/header.php';
    ?>
</head>
<body>
<?php include('src/views/navbar.php') ?>








<div id="Pushnotification">

    <div class="container">
        <div id="successMsg" class="alert alert-success"> Push notification successfully sent</div>
        <div id="alertMsg" class="alert alert-danger"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Push Notification</h3>
            </div>
            <div class="panel-body" id="pushnotificationpanelbody">

                <form id="PushnotificationAddForm">

                    <div class="col-xs-8 col-md-10">
                        <div class="row">
                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"><label for="topicName">Message: </label></span></div>
                            <div class="col-xs-8 col-md-9">
                                <textarea onclick="hidesuccess();" id="pushmessagetext" maxlength="1000" class="form-control" rows="10" oninput="disAllowCopyPasteForSpecialCharacters(this.id)"></textarea>
                            </div>
                        </div>


                    </div>


                </form>
            </div>
        </div>

        <div>
            <p style="float: right">

                <button type="button" class="btn btn-primary" id="pushmessage" onclick="pushconfirmation()" disabled="true">Push</button>
            </p>
        </div>

    </div>
</div>


<div class="modal audvisor-pushmessage-preview-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="newtopicAdd">

                <div class="container" id="pushnotificationcontainer" style="overflow: auto;width:90%; margin-right:5%;">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Message Preview </h3>
                        </div>
                        <div class="panel-body" id="pushnotificationpreview">

                            <form id="pushnotificationpreviewform">


                                <div class="row">

                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"><label for="previewmessage">Message: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-lg-8"><label id="previewmessage"></label></div>
                                </div>


                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="button" onclick="hidemessagepreviewForm()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddtopic" onclick="pushmessage()">Confirm</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>
