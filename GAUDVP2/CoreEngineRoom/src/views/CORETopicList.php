<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : CORETopicList.php
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

    <title>Topics</title>
    <?php
    include 'src/views/header.php';
    ?>
</head>
<body>
<?php include('src/views/navbar.php') ?>
<div class="container" style="margin-top:1%">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 id="statistics" class="panel-title">Topics</h3>
        </div>

        <div class="panel-body" style="width:100%;overflow: auto">
            <div class="table-responsive">
                <table id="topictable" class="table table table-hover table-bordered" style="overflow: auto">

                    <?php
                    if (!isset($Data[JSON_TAG_COUNT]) || $Data[JSON_TAG_COUNT] == 0)
                    {
                        echo 'No Topics';
                    }
                    else
                    {
                    ?>
                    <thead>
                    <tr class="table-striped">
                        <th style="text-align: center"> Topics Id</th>
                        <th style="text-align: center"> Topics Name</th>
                        <th style="text-align: center">Insight Count</th>
                        <th width="10%"></th>
                        <th width="6%"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($Data[JSON_TAG_TOPICS] as $aList)
                    {
                    ?>

                    <tr class="table-striped">

                        <td style="text-align: center"> <?php echo $aList['topic_id']; ?> </td>
                        <td style="text-align: left" id="<?php echo $aList['topic_id']; ?>"> <?php echo $aList[JSON_TAG_TOPIC_NAME]; ?> </td>
                        <td style="text-align: center"> <?php echo $aList[JSON_TAG_COUNT]; ?> </td>
                        <td style="text-align: center">
                            <button onclick="onTopicDeleteBtnClick('<?php echo $aList['topic_id']; ?>')" id="btnDelete" class="btn-danger"> Delete</button>
                        </td>

                        <td style="text-align: center">
                            <button onclick="onTopicEditBtnClick('<?php echo $aList['topic_id']; ?>','<?php echo str_replace("'", "\'", $aList[JSON_TAG_TOPIC_NAME]); ?>','<?php echo $aList[JSON_TAG_TOPIC_ICON]; ?>');" id="btnEdit" data-toggle="modal" data-target=".audvisor-topic-edit-modal" class="btn-info"> Edit</button>
                        </td>

                        <?php } ?>
                    </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php ?>

<div class="modal audvisor-topic-edit-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div id="newtopicEdit" style="margin-top:2%; display: none">
                <div class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div id="alertMsg1" style="margin-top:1%; display: none" class="alert alert-danger"></div>

                    <form id="newtopicEditForm">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Edit Topic</h3>
                            </div>
                            <div class="panel-body" style="width:100%; margin-left: 0%;overflow: auto;">
                                <div class="col-xs-8 col-md-7">
                                    <div class="row">
                                        <input type="hidden" name="topictid" id="topicid" value="">

                                        <div class="col-xs-8 col-md-3">
                                            <span class="pull-right"><label for="etopicname">Title: </label></span>
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <input onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="etopicname" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">

                                        <div class=" col-xs-8 col-md-3">
                                            <span class="pull-right"> <label for="etopicname">Image: </label> </span>
                                        </div>
                                        <div class="col-xs-8 col-md-9"><span class="pull-right"> <img id="previewtopicimage_2x" src="" alt="Image Not Available" title="" height="90" width="128" style="border:1px solid #0174DF"></img></span>
                                        </div>

                                    </div>


                                    <div class="row">
                                        <br>

                                        <div class="col-xs-8 col-md-3">
                                            <span class="pull-right"> <label for="photo">New Image: </label></span>
                                        </div>
                                        <div class=" col-xs-8 col-md-9">
                                            <input id="topicimages" dir="rtl" name="topicimages" type="file" onchange="showtopicimagespreview(this)" accept="image/*" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4 col-md-5">


                                </div>
                                <br>

                            </div>
                        </div>
                    </form>

                    <div style="margin-top:1%">
                        <p style="float: right">
                            <button class="btn btn-default" type="reset" onclick="hideupdateForm()">Cancel</button>
                            <button type="reset" class="btn btn-primary" id="btnUpdatetopic" onclick="topiceditconirmation()">Update</button>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- topic preview modal -->
<div class="modal audvisor-topic-preview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="newtopicAdd" style="margin-top:2%; width:100%;">

                <div class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Topic Preview </h3>
                        </div>
                        <div class="panel-body" style="width:100%; margin-left: 10%;overflow: auto;">

                            <form id="newtopicAddForm">


                                <div class="row">

                                    <div class="col-xs-8 col-md-3">
                                        <span class="pull-right"> <label for="topicName">Title: </label></span></div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewtopicname"></label></div>
                                </div>
                                <div class="row">
                                    <div class=" col-xs-8 col-md-3">
                                        <span class="pull-right"> <label for="expertname">Image: </label></span></div>
                                    <div class=" col-xs-8 col-lg-3">
                                        <span class="pull-left"><label id="imgnotavailable" for="expertimage" style="visibility: hidden;">No new image selected </label></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class=" col-xs-8 col-md-3"></div>
                                    <div class="col-xs-8 col-lg-3" id="previewtopicimages">
                                        <output id="list"></output>
                                    </div>
                                    <div id="avilability"></div>
                                </div>
                                <div class="row">
                                    <div class=" col-xs-8 col-lg-3"><span class="pull-right"><img id="topicpreviewimage" src="" alt="Image Not Selected" height="90" width="128" style="border:1px solid #0174DF;visibility: hidden"></img></span>
                                    </div>

                                </div>


                            </form>
                        </div>
                    </div>

                    <div style="margin-top:1%">
                        <p style="float:right">
                            <button class="btn btn-default" type="button" onclick="hidetopicpreviewform()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddtopic" onclick="UpdateTopic()">Confirm</button>
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
                          getTopicstat();
                          $('#topictable').DataTable({
                                                         "dom": 'Rlfrtip',
                                                         responsive: true,
                                                         "order": [[0, 'desc']],
                                                         "aoColumnDefs": [
                                                             {'bSortable': false, 'aTargets': [3, 4]},
                                                             {"bSearchable": false, "aTargets": [3, 4]}
                                                         ],
                                                         "aLengthMenu": [
                                                             [10, 20, 50, 100, -1],
                                                             [10, 20, 50, 100, "All"]
                                                         ],
                                                         "iDisplayLength": 20,
                                                         stateSave: true,
                                                         "sDom": 'TRr<"inline"l> <"inline"f><>t<"inline"p><"inline"i>'
                                                     });
                      });
</script>
<style>
    div.dataTables_length label
    {
        font-weight: bold;
    }

    div.dataTables_filter label
    {
        font-weight: bold;
    }
</style>
</body>
</html>
