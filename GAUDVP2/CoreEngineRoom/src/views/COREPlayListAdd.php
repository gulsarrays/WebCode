<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREPlayListAdd.php
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

    <title>Add PlayList</title>


    <?php
    include 'src/views/header.php';
    ?>


</head>

<body>
<?php include('src/views/navbar.php') ?>

<div id="newplaylistAdd">

    <div class="container">
        <div id="successMsg" class="alert alert-success"></div>
        <div id="alertMsg1" class="alert alert-danger"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">New PlayList</h3>
            </div>
            <div class="panel-body" id="playlistaddpanelbody1">

                <form id="newplaylistAddForm">

                    <div class="col-xs-8 col-md-8">
                        <div class="row">
                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"><label for="playlistName">PlayList Name: </label></span></div>
                            <div class="col-xs-8 col-md-9">
                                <input onclick="hidesuccess();" placeholder="Title" id="playlistname" type="text" maxlength="50" class="form-control" required="" size="30" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                            </div>
                        </div>


                        <div id="avilability"></div>
                    </div>
                    <div class="col-xs-4 col-md-4">
                    </div>

                </form>
            </div>
        </div>

        <div id="playlistaddnavpills">
            <p>

                <button type="button" style="float: right;" class="btn btn-primary" id="btnAddplaylist" onclick="playlistconfirmation(0)">Save</button>
            </p>
        </div>

    </div>
</div>


<div class="modal audvisor-playlist-preview-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="newplaylistAdd">

                <div class="container" id="playlistaddcontainer" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">PlayList Preview </h3>
                        </div>
                        <div class="panel-body" id="playlistaddpanelbody">

                            <form id="newplaylistAddForm1">


                                <div class="row">

                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"><label for="playlistName">PlayList Name : </label> </span></div>
                                    <div class="col-xs-8 col-lg-8"><label id="previewplaylistname"></label></div>
                                </div>
                                
                                
                                <div class="col-xs-8 col-md-4">
                                </div>
                                <div class="col-xs-8 col-lg-8" id="previewplaylistimages">
                                    <output id="list"></output>
                                </div>
                                <div id="avilability"></div>

                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="button" onclick="hideplaylistpreviewform()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddplaylist" onclick="addPlaylist(0)">Confirm</button>
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
                          $('#playlistname').value = "";

                          $("#btnAddplaylist").dblclick(function(e)
                                                     {
                                                         e.preventDefault();
                                                         alert("Double click is disabled");
                                                     });
                      });
</script>

</body>


</html>
