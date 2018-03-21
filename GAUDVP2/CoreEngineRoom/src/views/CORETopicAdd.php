<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : CORETopicAdd.php
  Description                 : To Add/Delete/Update Topics details for cms
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

    <title>Add Topic</title>


    <?php
    include 'src/views/header.php';
    ?>


</head>

<body>
<?php include('src/views/navbar.php') ?>

<div id="newtopicAdd">

    <div class="container">
        <div id="successMsg" class="alert alert-success"></div>
        <div id="alertMsg1" class="alert alert-danger"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">New Topic</h3>
            </div>
            <div class="panel-body" id="topicaddpanelbody1">

                <form id="newtopicAddForm">

                    <div class="col-xs-8 col-md-8">
                        <div class="row">
                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"><label for="topicName">Title: </label></span></div>
                            <div class="col-xs-8 col-md-9">
                                <input onclick="hidesuccess();" placeholder="Title" id="topicname" type="text" maxlength="50" class="form-control" required="" size="30" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                            </div>
                        </div>
                        <div class="row">
                            <br>

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"> <label for="photo">Image: </label></span></div>
                            <div class=" col-xs-8 col-md-9">
                                <input id="topicimages" dir="rtl" name="topicimages" type="file" onchange="showtopicimagespreview(this)" accept="image/*" class="form-control">
                            </div>
                        </div>

                        <div id="avilability"></div>
                    </div>
                    <div class="col-xs-4 col-md-4">
                    </div>

                </form>
            </div>
        </div>

        <div id="topicaddnavpills">
            <p>

                <button type="button" style="float: right;" class="btn btn-primary" id="btnAddtopic1" onclick="topicconirmation(0)">Save</button>
            </p>
        </div>

    </div>
</div>


<div class="modal audvisor-topic-preview-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="newtopicAdd">

                <div class="container" id="topicaddcontainer" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Topic Preview </h3>
                        </div>
                        <div class="panel-body" id="topicaddpanelbody">

                            <form id="newtopicAddForm1">


                                <div class="row">

                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"><label for="topicName">Title: </label> </span></div>
                                    <div class="col-xs-8 col-lg-8"><label id="previewtopicname"></label></div>
                                </div>
                                <div class="row">
                                    <div class=" col-xs-8 col-md-4">
                                        <span class="pull-right"> <label for="expertname">Image: </label></span></div>
                                    <div class=" col-xs-8 col-md-6">
                                        <span class="pull-left"> <label id="topicimagepresenet"></label> </span></div>
                                </div>
                                <div class="col-xs-8 col-md-4">
                                </div>
                                <div class="col-xs-8 col-lg-8" id="previewtopicimages">
                                    <output id="list"></output>
                                </div>
                                <div id="avilability"></div>

                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="button" onclick="hidetopicpreviewform()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddtopic" onclick="addTopic(0)">Confirm</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function()
                      {
                          $('#topicname').value = "";

                          $("#btnAddtopic").dblclick(function(e)
                                                     {
                                                         e.preventDefault();
                                                         alert("Double click is disabled");
                                                     });
                      });
</script>

</body>


</html>
