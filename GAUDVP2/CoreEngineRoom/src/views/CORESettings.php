<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : CORESettings.php
  Description                 : To edit the common settings of cms
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>THE BUSINESS JOURNALS Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--<link href="<?php echo BASE_URL_STRING ?>/src/views/css/style_v2.css" rel="stylesheet">-->
    <?php
    include 'src/views/header.php';
    ?>
</head>
<body>
<!--Start Header-->

<header style="margin-bottom:-20px;" class="navbar">
    <?php include('src/views/navbar.php') ?>
</header>
<!--Start Container-->


<div id="newtopicAdd">

    <div class="container" style="margin-right:20%;margin-left: 10%">
        <div id="successMsg" class="alert alert-success"></div>
        <div class="panel panel-primary" style="margin-right:15%">
            <div class="panel-heading">
                <h3 class="panel-title">Recommendation Engine Settings</h3>
            </div>
            <div class="panel-body" id="gensettingspanelbody">

                <form id="generalsettings">

                    <div class="col-xs-8 col-md-8">

                        <div class="row">
                            <div class="col-xs-8 col-md-7">
                                <span class="pull-right"><label for="topicName">Insight Weight : </label></span></div>
                            <div class="col-xs-8 col-md-3">
                                <label id="dexperttweight"><?php echo $Data[DB_COLUMN_FLD_INSIGHT_WEIGHTING] ?></label>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <button type="button" class="btn btn-info btn-xs active" data-toggle="modal" data-target=".audvisor-insightweight-edit-modal">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-8 col-md-7">
                                <span class="pull-right"><label for="topicName">Expert Weight : </label></span></div>
                            <div class="col-xs-8 col-md-3">
                                <label id="dinsightweight"><?php echo $Data[DB_COLUMN_FLD_EXPERT_WEIGHTING] ?></label>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <button type="button" class="btn btn-info btn-xs active" data-toggle="modal" data-target=".audvisor-expertweight-edit-modal">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                            </div>
                        </div>
                        <!-- <br>
                                 <div class="row">
                                    <div class="col-xs-8 col-md-7"><span class="pull-right"><label for="topicName">Minimum Listened Count :  </label></span>  </div>
                                    <div class="col-xs-8 col-md-3"> <label id="dinsightweight"><?php echo $Data[DB_COLUMN_FLD_MINIMUM_LISTENED_COUNT] ?></label>  </div>
                               <div class="col-xs-8 col-md-2">
                                <button type="button" class="btn btn-info btn-xs active"><span class="glyphicon glyphicon-edit"></span> Edit</button>
                                </div>
                                 </div>-->
                        <br>

                        <div class="row">
                            <div class="col-xs-8 col-md-7">
                                <span class="pull-right"><label for="topicName">First Most Listened Weight : </label></span>
                            </div>
                            <div class="col-xs-8 col-md-3">
                                <label id="dexperttweight"><?php echo $Data[DB_COLUMN_FLD_FIRST_LISTENED_WEIGHT] ?></label>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <button type="button" class="btn btn-info btn-xs active" data-toggle="modal" data-target=".audvisor-firstweight-edit-modal">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-8 col-md-7">
                                <span class="pull-right"><label for="topicName">Second Most Listened Weight : </label></span>
                            </div>
                            <div class="col-xs-8 col-md-3">
                                <label id="dinsightweight"><?php echo $Data[DB_COLUMN_FLD_SECOND_LISTENED_WEIGHT] ?></label>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <button type="button" class="btn btn-info btn-xs active" data-toggle="modal" data-target=".audvisor-secondweight-edit-modal">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-8 col-md-7">
                                <span class="pull-right"><label for="topicName">Third Most Listened Weight : </label></span>
                            </div>
                            <div class="col-xs-8 col-md-3">
                                <label id="dexperttweight"><?php echo $Data[DB_COLUMN_FLD_THIRD_LISTENED_WEIGHT] ?></label>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <button type="button" class="btn btn-info btn-xs active" data-toggle="modal" data-target=".audvisor-thirdweight-edit-modal">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-8 col-md-7">
                                <span class="pull-right"><label for="topicName">Rest of Most Listened Weight : </label></span>
                            </div>
                            <div class="col-xs-8 col-md-3">
                                <label id="dexperttweight"><?php echo $Data[DB_COLUMN_FLD_FOURTH_LISTENED_WEIGHT] ?></label>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <button type="button" class="btn btn-info btn-xs active" data-toggle="modal" data-target=".audvisor-fourthweight-edit-modal">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-8 col-md-7">
                                <span class="pull-right"><label for="topicName">Recommended Insight Limit : </label></span>
                            </div>
                            <div class="col-xs-8 col-md-3">
                                <label id="dexperttweight"><?php echo $Data[DB_COLUMN_FLD_RECOMMENDED_INSIGHT_LIMIT] ?></label>
                            </div>
                            <div class="col-xs-8 col-md-2">
                                <button type="button" class="btn btn-info btn-xs active" data-toggle="modal" data-target=".audvisor-insightcount-edit-modal">
                                    <span class="glyphicon glyphicon-edit"></span> Edit
                                </button>
                            </div>
                        </div>
                        <div id="avilability"></div>
                    </div>
                    <div class="col-xs-4 col-md-4">
                    </div>

                </form>
            </div>
        </div>
        <!--
                        <div  id="gsettingsnavpills" style="margin-right:30%" >
                            <p style="float:right;">

                                <button  type="button" class="btn btn-primary" id="btnAddtopic1" onclick="topicconirmation(0)">Save</button>
                            </p>
                        </div>
        -->

    </div>
</div>


<!-- Insight Weight-->


<div class="modal audvisor-insightweight-edit-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="editinsightweight">

                <div id="insightweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div id="alertMsg1" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">New Insight Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="insightweighteditform">
                                <div class="row" id="addtopicdiv">
                                    <div class="col-xs-8 col-md-6">
                                        <span class="pull-right">  <label for="topicName">New Insight Weight: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-md-4">
                                        <input onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="fldinsightweighting" type="text" maxlength="50" class="form-control" size="30" oninput="rating_range(this.id)">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right" id="topicaddbutton">
                            <button class="btn btn-default" type="button" onclick="hideinsightweight()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btncnfminsightweight" onclick="insightweightconfirm()">Save</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!--preview -->

<div class="modal audvisor-insightweight-editpreview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="previeweditinsightweight">

                <div id="previewinsightweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Preview Insight Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="previewinsghtweightform">
                                <div class="row">
                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"> <label for="topicName">Insight Weight: </label></span>
                                    </div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewinsightweight"></label></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="button" onclick="cancelinsightweightpreview()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btninsightweight" onclick="updatesettings('fldinsightweighting');">Confirm</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Expert Weight-->


<div class="modal audvisor-expertweight-edit-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="editexpertweight">

                <div id="expertweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div id="alertMsgexpertweight" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">New Expert Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="expertweighteditform">
                                <div class="row" id="addtopicdiv">
                                    <div class="col-xs-8 col-md-6">
                                        <span class="pull-right">  <label for="topicName">New Expert Weight: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-md-4">
                                        <input onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="fldexpertweighting" type="text" maxlength="50" class="form-control" size="30" oninput="rating_range(this.id)">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="button" onclick="hideexpertweight()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btncnfmexpertweight" onclick="expertweightconfirm()">Save</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!--preview -->

<div class="modal audvisor-expertweight-editpreview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="previeweditexpertweight">

                <div id="previewexpertweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Preview Expert Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="previewexpertweightform">
                                <div class="row">
                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"> <label for="topicName">Expert Weight: </label></span>
                                    </div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewexpertweight"></label></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="button" onclick="cancelexpertweightpreview()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btninsightweight" onclick="updatesettings('fldexpertweighting');">Confirm</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- First Weight -->


<div class="modal audvisor-firstweight-edit-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="editfirstweight">

                <div id="firstweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div id="alertMsgfirstweight" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">First Most Listened Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="firstweighteditform">
                                <div class="row" id="addtopicdiv">
                                    <div class="col-xs-8 col-md-6">
                                        <span class="pull-right">  <label for="topicName">New First Most Listened Weight: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-md-4">
                                        <input onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="fldfirstmostlistenedweight" type="text" maxlength="50" class="form-control" size="30" oninput="rating_range(this.id)">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;" id="topicaddbutton">
                            <button class="btn btn-default" type="button" onclick="hidefirstweight()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btncnfmexpertweight" onclick="firstweightconfirm()">Save</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!--preview -->

<div class="modal audvisor-firstweight-editpreview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="previeweditexpertweight">

                <div id="previewexpertweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Preview First Most Listened Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="previewexpertweightform">
                                <div class="row">
                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"> <label for="topicName">First Weight: </label></span>
                                    </div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewfirstweight"></label></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;">
                            <button class="btn btn-default" type="button" onclick="cancelfirstweightpreview()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btninsightweight" onclick="updatesettings('fldfirstmostlistenedweight');">Confirm</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Second Weight -->


<div class="modal audvisor-secondweight-edit-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="editsecondweight">

                <div id="secondweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div id="alertMsgsecondweight" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Second Most Listened Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="secondweighteditform">
                                <div class="row" id="addtopicdiv">
                                    <div class="col-xs-8 col-md-6">
                                        <span class="pull-right">  <label for="topicName">New Second Most Listened Weight: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-md-4">
                                        <input onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="fldsecondmostlistenedweight" type="text" maxlength="50" class="form-control" size="30" oninput="rating_range(this.id)">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;" id="topicaddbutton">
                            <button class="btn btn-default" type="button" onclick="hidesecondweight()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btncnfmexpertweight" onclick="secondweightconfirm()">Save</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!--preview -->

<div class="modal audvisor-secondweight-editpreview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="previeweditsecondweight">

                <div id="previewsecondweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Preview Second Most Listened Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="previewsecondweightform">
                                <div class="row">
                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"> <label for="topicName">Second Weight: </label></span>
                                    </div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewsecondweight"></label></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;">
                            <button class="btn btn-default" type="button" onclick="cancelsecondweightpreview()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btninsightweight" onclick="updatesettings('fldsecondmostlistenedweight');">Confirm</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Third Weight -->


<div class="modal audvisor-thirdweight-edit-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="editthirdweight">

                <div id="thirdweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div id="alertMsgthirdweight" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Third Most Listened Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="thirdweighteditform">
                                <div class="row" id="addtopicdiv">
                                    <div class="col-xs-8 col-md-6">
                                        <span class="pull-right">  <label for="topicName">New Third Most Listened Weight: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-md-4">
                                        <input onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="fldthirdmostlistenedweight" type="text" maxlength="50" class="form-control" size="30" oninput="rating_range(this.id)">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;" id="topicaddbutton">
                            <button class="btn btn-default" type="button" onclick="hidethirdweight()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btncnfmexpertweight" onclick="thirdweightconfirm()">Save</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!--preview -->

<div class="modal audvisor-thirdweight-editpreview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="previeweditthirdweight">

                <div id="previewthirdweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Preview Third Most Listened Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="previewthirdweightform">
                                <div class="row">
                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"> <label for="topicName">Third Weight: </label></span>
                                    </div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewthirdweight"></label></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;">
                            <button class="btn btn-default" type="button" onclick="cancelthirdweightpreview()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btninsightweight" onclick="updatesettings('fldthirdmostlistenedweight');">Confirm</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!-- Fourth Weight -->


<div class="modal audvisor-fourthweight-edit-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="editfourthweight">

                <div id="fourthweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div id="alertMsgfourthweight" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Rest of Most Listened Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="fourthweighteditform">
                                <div class="row" id="addtopicdiv">
                                    <div class="col-xs-8 col-md-6">
                                        <span class="pull-right">  <label for="topicName">New Rest Most Listened Weight: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-md-4">
                                        <input onkeypress="disAllowCopyPasteForSpecialCharacters(this.id);" id="fldfourthmostlistenedweight" type="text" maxlength="50" class="form-control" size="30" oninput="rating_range(this.id)">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;" id="topicaddbutton">
                            <button class="btn btn-default" type="button" onclick="hidefourthweight();">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btncnfmexpertweight" onclick="fourthweightconfirm();">Save</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!--preview -->

<div class="modal audvisor-fourthweight-editpreview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="previeweditfourthweight">

                <div id="previewfourthweighteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Preview Rest of Most Listened Weight</h3>
                        </div>
                        <div class="panel-body">
                            <form id="previewfourthweightform">
                                <div class="row">
                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"> <label for="topicName">Rest Weight: </label></span>
                                    </div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewfourthweight"></label></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;">
                            <button class="btn btn-default" type="button" onclick="cancelfourthweightpreview();">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btninsightweight" onclick="updatesettings('fldfourthmostlistenedweight');">Confirm</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- VAlue of N -->


<div class="modal audvisor-insightcount-edit-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="editinsightcount">

                <div id="insightcountcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div id="alertMsginsightcount" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recommended Insight Limit</h3>
                        </div>
                        <div class="panel-body">
                            <form id="insightcounteditform">
                                <div class="row" id="addtopicdiv">
                                    <div class="col-xs-8 col-md-6">
                                        <span class="pull-right">  <label for="topicName">New insight Limit: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-md-4">
                                        <input onkeypress="disAllowCopyPasteForSpecialCharacters(this.id);" id="fldrecommendedinsightlimit" type="text" maxlength="50" class="form-control" size="30" oninput="no_nonnumbers(this.id)">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;" id="insightlimitbutton">
                            <button class="btn btn-default" type="button" onclick="hideinsightcount();">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btncnfminsightlimit" onclick="insightcountconfirm();">Save</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- preview -->

<div class="modal audvisor-insightlimit-editpreview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="previeweditinsightlimit">

                <div id="previewinsightlimiteditcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Recommended Insight Limit</h3>
                        </div>
                        <div class="panel-body">
                            <form id="previewfourthweightform">
                                <div class="row">
                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"> <label for="topicName">Insight Limit: </label></span>
                                    </div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewinsightlimit"></label></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float:right;">
                            <button class="btn btn-default" type="button" onclick="cancelinsightcountpreview();">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btninsightweight" onclick="updatesettings('fldrecommendedinsightlimit');">Confirm</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
