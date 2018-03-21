<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREInsightList.php
  Description                 : To edit/update/delete insight details for cms
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
        <title>Insight Details</title>
        <?php
        include 'src/views/header.php';
        ?>
    </head>

    <body>

        <?php include('src/views/navbar.php') ?>
        <div class="container" style="margin-top:1%;display: table">

            <div class="panel panel-primary" id="insightpanel">
                <div class="panel-heading">
                    <h3 id="statistics" class="panel-title">Insights</h3>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="tableinsight" class="table table table-hover table-bordered" cellspacing="0" width="100%">


                            <thead>
                                <tr>
                                    <th> Insight ID</th>
                                    <th> Insight Title</th>
                                    <th> Expert</th>
                                    <th>FB Share Text</th>
                                    <th>Rating</th>
                                    <th>Voice-Over</th>
                                    <th> Topics</th>
                                    <th>Online</th>
                                    <th>Is Featured?</th>

                                    <!--<th>Listen #</th>
                                    <th>Like #</th>
                                    <th>FB Share #</th>
                                    <th>Twitter Share #</th>
                                    <th>SMS Share #</th>-->
                                    <th>Mark as Featured</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>


                        </table>

                    </div>
                </div>
            </div>
        </div>


        <!-- Edit insight-->

        <div class="modal audvisor-insight-edit-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">


                    <div id="editinsight">
                        <div id="editinsightcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                            <div id="successMsg" class="alert alert-success"></div>
                            <div id="alertMsg" class="alert alert-danger"></div>


                            <div class="panel panel-primary">
                                <div class="panel-heading ">
                                    <h3 class="panel-title"> Edit Insight</h3>
                                </div>
                                <div id="editinsightpanelbody" class="panel-body">


                                    <br>

                                    <form id="regform">
                                        <div class="row">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label for="ititle">Title:</label></span></div>
                                            <div class=" col-md-6">
                                                <input type="text" id="ititle" class="form-control" maxlength="100" size="30" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                            </div>

                                        </div>
                                        <div class="row">
                                            <br>

                                            <div class=" col-md-3">
                                                <span class="pull-right"><label for="insightreputation"> Rating:</label></span>
                                            </div>
                                            <div class=" col-md-6">
                                                <input type="text" id="insightrating" class="form-control" maxlength="3" size="30" onclick=" hidesuccess();" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" oninput="rating_range(this.id)">
                                            </div>

                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3"><span class="pull-right"><label>FB Share Text:</label></span></div>
                                            <div class="col-md-6"><textarea id="fbsharedesc" rows="5" maxlength="200" placeholder="This text will be used when the insight is shared over Social Media." class="form-control"></textarea></div>

                                        </div>
                                        <br>
                                        <!--     <div class="row" >
                                     <br>
        
                                     <div class=" col-md-3"><span class="pull-right"><label for="insightreputation">  Weighting :</label></span></div>
                                     <div class=" col-md-6">  <input type="text" id="insightweighting" class="form-control" maxlength="3" size="30" onclick=" hidesuccess();" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" oninput="rating_range(this.id)" >
                                     </div>
        
                                 </div>
                                 <br>-->
                                        <div class="row" id="topicrow">

                                            <div class=" col-md-3"><span class="pull-right"><label for="topicid">Topic:</label></span>
                                            </div>
                                            <div class=" col-md-6">
                                                <select id="topicid" style="text-align:right;float: right;direction: rtl;" multiple="multiple">
                                                    <?php
                                                    foreach ($Data1[JSON_TAG_TOPICS] as $aList) {
                                                        ?>

                                                        <option value="<?php echo $aList['topic_id']; ?>"><?php echo $aList[JSON_TAG_TOPIC_NAME]; ?>  </option>

                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <button class="btn btn-primary" data-toggle="modal" data-target=".audvisor-topic-add-modal" type="button" id="" class="btn btn-primary" onclick="showaddTopic()"> Add Topic &nbsp;</button>

                                        </div>
                                        <br>
                                        <input type="hidden" name="insightid" id="insightid">
                                        <input type="hidden" name="insightsurl" id="insighturl">
                                        <input type="hidden" name="streamingurl" id="streamingurl">

                                        <div class="row">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label for="expid">Expert:</label></span></div>
                                            <div class=" col-md-6">
                                                <select id="expid" style="text-align:right;float: right;direction: rtl;">


                                                    <?php
                                                    if (count($Data2[JSON_TAG_EXPERTS]) != 0) {
                                                        foreach ($Data2[JSON_TAG_EXPERTS] as $aList1) {
                                                            ?>


                                                            <option value="<?php echo $aList1['expert_id']; ?>"><?php echo $aList1[JSON_TAG_EXPERT_NAME]; ?></option>


        <?php
    }
}
?>


                                                </select>
                                            </div>
                                            <button class="btn btn-primary" onclick="showaddExpert()" data-toggle="modal" data-target=".audvisor-expert-add-modal" type="button" id="btnaddexp" class="btn btn-primary"> Add Expert</button>


                                        </div>
                                        <br>
                                        <!-- Play List row Start -->
                                        <div class="row" id="playlistrow">

                                            <div class=" col-md-3"><span class="pull-right"><label for="playlistid">PlayList:</label></span>
                                            </div>
                                            <div class=" col-md-6">
                                                <select id="playlistid" style="text-align:right;float: right;direction: rtl;" multiple="multiple">
                                                    <?php
                                                    if(isset($playlists['playlist'])) {
                                                    foreach ($playlists['playlist'] as $aPlayList) {
                                                        ?>

                                                        <option value="<?php echo $aPlayList['playList_id']; ?>"><?php echo $aPlayList['playList_name']; ?>  </option>

                                                    <?php } }?>

                                                </select>
                                            </div>
                                            <button class="btn btn-primary" data-toggle="modal" data-target=".audvisor-playlist-add-modal" type="button" id="" class="btn btn-primary" onclick="showaddPlayList()"> Add PlayList &nbsp;</button>

                                        </div>
                                        <br>
                                        <!-- Play List row End -->

                                        <div class="row">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label id="einsightlabel" for="insight">Voice-Over:</label></span>
                                            </div>
                                            <div class="col-md-6">
                                                <label id="lblnovourl" style="display: none">Not Available</label>
                                                <audio controls id="editinsightvoplayer" style="width:100;">
                                                    <source id="voiceovermp3" src="" type="audio/mpeg">
                                                </audio>
                                            </div>
                                            <!-- /.col-lg-6 -->
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label id="evoiceoverlabel" for="insight">Replace Voice-Over:</label></span>
                                            </div>
                                            <div class="col-md-6">

                                                <input id="insightvoiceover" name="insightvoiceover" dir="rtl" type="file" accept="audio/*" class="form-control">

                                            </div>
                                            <!-- /.col-lg-6 -->
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label id="einsightlabelist" for="insight">Insight:</label></span>
                                            </div>
                                            <div class="col-md-6">
                                                <label id="lblnostreamurl" style="display: none">Not Available</label>
                                                <audio controls id="editinsightplayer">
                                                    <source id="insightmp3" src="" type="audio/mpeg">
                                                </audio>
                                            </div>
                                            <!-- /.col-lg-6 -->
                                        </div>


                                        <br>
                                        <br>

                                        <div class="row">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label id="einsightlabel" for="insight">Replace Insight:</label></span>
                                            </div>
                                            <div class="col-md-6">

                                                <input id="insight" name="insight" dir="rtl" type="file" accept="audio/*" class="form-control">

                                            </div>
                                        </div>
                                        <br>

                                    </form>

                                </div>
                            </div>


                            <div>
                                <p style="float: right">
                                    <button class="btn btn-default" type="reset" onclick="hideInsightEditForm()">Cancel</button>
                                    <button type="reset" class="btn btn-primary" id="btnupdate">Update</button>
                                </p>
                            </div>


                        </div>


                    </div>


                </div>
            </div>
        </div>


        <!--  Topic Reg modal   -->


        <div class="modal audvisor-topic-add-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">


                    <div id="newtopicAdd">

                        <div id="newtopicaddcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                            <div id="alertMsg1" class="alert alert-danger"></div>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">New Topic</h3>
                                </div>
                                <div class="panel-body">

                                    <form id="newtopicAddForm">

                                        <div class="row" id="addtopicdiv">

                                            <div class="col-xs-8 col-md-3">
                                                <span class="pull-right">  <label for="topicName">Title: </label> </span></div>
                                            <div class="col-xs-8 col-md-7">
                                                <input onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="topicname" type="text" maxlength="50" class="form-control" size="30" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <br>

                                            <div class="col-xs-8 col-md-3">
                                                <span class="pull-right"> <label for="photo">Image: </label></span></div>
                                            <div class=" col-xs-8 col-md-7">
                                                <input id="topicimages" dir="rtl" name="topicimages" type="file" onchange="showtopicimagespreview(this)" accept="image/*" class="form-control">
                                            </div>
                                        </div>
                                        <div id="avilability"></div>

                                    </form>

                                    <form id="previewtopicform">


                                        <div class="row">

                                            <div class="col-xs-8 col-md-4">
                                                <span class="pull-right"> <label for="topicName">Title: </label></span></div>
                                            <div class="col-xs-8 col-lg-3"><label id="previewtopicname"></label></div>
                                        </div>


                                        <div class="row">
                                            <div class=" col-xs-8 col-md-4">
                                                <span class="pull-right"> <label for="expertname">Preview Image: </label></span>
                                            </div>
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
                                <p id="topicaddbutton" style="float: right">
                                    <button class="btn btn-default" type="button" onclick="hideaddTopic()">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="btnAddtopic1" onclick="topicconirmation(1)">Save</button>
                                </p>
                                <p id="topicpreviewbutton" style="float: right">
                                    <button class="btn btn-default" type="button" onclick="showtopicmodalform()">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="btnAddtopic" onclick="addTopic(1)">Confirm</button>
                                </p>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Expert Reg   -->

        <div id="mymodal" class="modal  audvisor-expert-add-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div id="addexpert">
                        <div class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                            <div id="alertMsg2" class="alert alert-danger"></div>
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">New Expert</h3>
                                </div>
                                <div class="panel-body">

                                    <form id="regform1">
                                        <!--  <div class="col-xs-8 col-md-7">  -->
                                        <div style="width: 60%; float:left;overflow:hidden" class="container">
                                            <div class="row">

                                                <div class="col-md-4"><span class="pull-right">  <label for="expname">Prefix: </label></span></div>
                                                <div class=" col-md-7">
                                                    <input onclick="hidesuccess();" placeholder="" onkeyup="hidesuccess();" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="expprefix" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">

                                                <div class=" col-md-4"><span class="pull-right">  <label for="expname">First Name: </label></span></div>
                                                <div class=" col-md-7">
                                                    <input onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="expname" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">

                                                <div class=" col-md-4"><span class="pull-right">  <label for="explastname">Last Name: </label> </span></div>
                                                <div class=" col-md-7">
                                                    <input onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" size="30" id="explastname" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <input type="hidden" name="imageid" id="imageid" value="<?php echo uniqid(); ?>">

                                                <div class=" col-md-4"><span class="pull-right">  <label for="exptitle">Title: </label> </span></div>
                                                <div class=" col-md-7">
                                                    <input onkeyup="" maxlength="250" onkeypress="" id="exptitle" type="text" class="form-control" oninput="">
                                                </div>
                                            </div>
                                            <input type="hidden" name="imageid" id="imageid" value="">

                                            <br>

                                            <div class="row">
                                                <div class="col-md-4"><span class="pull-right">  <label for="exptitle">Promo Title: </label> </span></div>
                                                <div class="col-md-7">
                                                    <input onfocus="hidesuccess();" onkeyup="" onkeypress="" id="promotitle" type="text" class="form-control" maxlength="250" oninput="">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class=" col-md-4"><span class="pull-right">  <label for="exptitle">Biography: </label> </span></div>
                                                <div class=" col-md-7">
                                                    <textarea onfocus="hidesuccess();" rows="5" onkeyup="" onkeypress="" id="expdesc" type="text" class="form-control" maxlength="1000" oninput=""> </textarea>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class=" col-md-4"><span class="pull-right">  <label for="rating">Rating: </label> </span></div>
                                                <div class="  col-md-7">
                                                    <input onfocus="hidesuccess();" placeholder="" onkeyup="" onkeypress="" id="exprating" class="form-control" maxlength="3" oninput="rating_range(this.id)">
                                                </div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class="col-md-4"><span class="pull-right">  <label for="twitterhandle">Twitter Handle: </label> </span>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="input-group"><span class="input-group-addon">@</span>
                                                        <input onfocus="hidesuccess();" placeholder="" onkeyup="" onkeypress="" id="twitterhandle" class="form-control" maxlength="15" oninput="">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        <div style="width: 40%; float:right;overflow:hidden" class="container">

                                            <div class="row">

                                                <div class="col-md-6">
                                                    <span class="pull-right"> <label for="photo">Profile Image: </label></span></div>
                                                <div class="col-md-6">
                                                    <input id="images" dir="rtl" name="images" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <br>

                                                <div class="col-md-6">
                                                    <span class="pull-right"> <label for="photo"> Bio Image: </label></span></div>
                                                <div class="col-md-6">
                                                    <input id="bioimage" dir="rtl" name="bioimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <br>

                                                <div class="col-md-6">
                                                    <span class="pull-right"> <label for="photo">Share Image: </label></span></div>
                                                <div class="col-md-6">
                                                    <input id="thumbnailimage" dir="rtl" name="thumbnailimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <br>

                                                <div class="col-md-6">
                                                    <span class="pull-right"> <label for="photo">Promo Image: </label></span></div>
                                                <div class="col-md-6">
                                                    <input id="promoimage" dir="rtl" name="promoimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
                                                </div>

                                            </div>
                                            <div class="row">
                                                <br>

                                                <div class="col-md-6">
                                                    <span class="pull-right"> <label for="photo">List View Image: </label></span></div>
                                                <div class=" col-md-6">
                                                    <input id="listviewimage" dir="rtl" name="listviewimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <br>

                                                <div class="col-md-6">
                                                    <span class="pull-right"> <label for="photo">FB Share Image: </label></span></div>
                                                <div class=" col-md-6">
                                                    <input id="fbshareimage" dir="rtl" name="fbshareimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <br>

                                                <div class="col-md-6">
                                                    <span class="pull-right"> <label for="voiceover">Voice-Over: </label></span></div>
                                                <div class="col-md-6">
                                                    <input id="expertvoiceover" dir="rtl" name="expertvoiceover" type="file" accept="audio/*" class="form-control">
                                                </div>

                                            </div>
                                        </div>
                                    </form>


                                    <form id="previewexpertForm">

                                        <div style="width: 60%; float:left;overflow:hidden" class="container">


                                            <div class="row">
                                                <!-- <div class=" col-md-3"> <span class="pull-right">   <img id="previewimage" src="" alt="Image Not Selected" height="90" width="128"></img></span></div>-->
                                            </div>
                                            <div class="row">
                                                <div class=" col-md-4"><span class="pull-right"><label for="expertname">Prefix: </label></span></div>
                                                <div class=" col-md-6"><label id="previewexpertprefix"></label></div>
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class=" col-md-4"><span class="pull-right"><label for="expertname">First Name: </label></span></div>
                                                <div class=" col-md-6"><label id="previewexpertname"></label></div>
                                            </div>
                                            <br>

                                            <div class="row">

                                                <div class=" col-md-4"><span class="pull-right"> <label for="expertname">Last Name: </label></span></div>
                                                <div class=" col-md-6"><label id="previewlastname"></label></div>
                                            </div>
                                            <br>

                                            <div class="row">

                                                <div class=" col-md-4"><span class="pull-right"> <label for="expertname">Title: </label></span></div>
                                                <div class=" col-md-6"><label id="previewexperttitle"></label></div>
                                            </div>
                                            <br>


                                            <div class="row">
                                                <div class=" col-md-4"><span class="pull-right"> <label for="expertname">Promo Title: </label></span></div>
                                                <div class=" col-md-6"><label id="previewpromotitle"></label></div>
                                                <!-- </div>  -->
                                            </div>

                                            <div class="row">
                                                <div class=" col-md-4"><span class="pull-right"> <label for="expertdesc">Biography: </label></span></div>
                                                <div class=" col-md-6"><label id="previewexpertdesc"></label></div>
                                                <!-- </div>  -->
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class=" col-md-4"><span class="pull-right"> <label for="expertrating">Rating: </label></span></div>
                                                <div class=" col-md-6"><label id="previewexpertrating"></label></div>
                                                <!-- </div>  -->
                                            </div>
                                            <br>

                                            <div class="row">
                                                <div class=" col-md-4"><span class="pull-right"> <label for="twitterhandle">Twitter Handle: </label></span>
                                                </div>
                                                <div class=" col-md-6">
                                                    <a id="previewtwitterhandle" target="_blank"></a>
                                                </div>
                                                <!-- </div>  -->
                                            </div>

                                            <br>

                                            <div class="row">
                                                <div class=" col-md-4"><span class="pull-right"> <label for="expertdesc">Voice-Over: </label></span></div>
                                                <div class=" col-md-7"><label id="previewexpertvoiceover"></label></div>
                                                <!-- </div>  -->
                                            </div>
                                            <br>
                                        </div>
                                        <div style="width: 40%; float:right;overflow:hidden" class="container">
                                            <div class="row">
                                                <div class=" col-xs-8 col-md-4">
                                                    <span class="pull-right"> <label for="expertname">Preview Image: </label></span></div>
                                                <div class=" col-xs-8 col-md-7"><span class="pull-left"><label id="expertimagepresenet"></label> </span>
                                                </div>
                                            </div>
                                            <div class="col-xs-8 col-md-4">
                                            </div>
                                            <div class="col-xs-8 col-lg-12" id="previewexpertimages">
                                                <output id="expertlist">

                                                    <span id="pimagesspan">
                                                        <figure>
                                                            <img class="thumb" height="90" width="128" id="pimages" style="border:1px solid #0174DF"/>
                                                            <figcaption>Profile Image</figcaption>
                                                        </figure>
                                                    </span>
                                                    <span id="pbioimagespan">
                                                        <figure>
                                                            <img class="thumb" height="90" width="128" id="pbioimage" style="border:1px solid #0174DF"/>
                                                            <figcaption>Bio Image</figcaption>
                                                        </figure>
                                                    </span>
                                                    <span id="pthumbnailimagespan">
                                                        <figure>
                                                            <img class="thumb" height="90" width="128" id="pthumbnailimage" style="border:1px solid #0174DF"/>
                                                            <figcaption>Share Image</figcaption>
                                                        </figure>
                                                    </span>
                                                    <span id="ppromoimagespan">
                                                        <figure>
                                                            <img class="thumb" height="90" width="128" id="ppromoimage" style="border:1px solid #0174DF"/>
                                                            <figcaption>Promo Image</figcaption>
                                                        </figure>
                                                    </span>
                                                    <span style="float:left;">
                                                        <figure>
                                                            <img class="thumb" height="128" width="128" id="plistviewimage" style="border:1px solid #0174DF"/>
                                                            <figcaption>List View Image</figcaption>
                                                        </figure>
                                                    </span>
                                                    <span style="float:left;">
                                                        <figure>
                                                            <img class="thumb" height="128" width="244" id="pfbshareimage" style="border:1px solid #0174DF"/>
                                                            <figcaption>FB Share Image</figcaption>
                                                        </figure><br><br>
                                                    </span>


                                                </output>
                                            </div>
                                        </div>
                                        <div id="avilability"></div>

                                    </form>
                                </div>
                                <br>
                            </div>
                            <div>
                                <p id="expertaddbutton" style="float: right">
                                    <button class="btn btn-default" type="button" onclick="hideExpertaddForm()">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="btneditexpert1" onclick="expertconirmation(1)">Save</button>
                                </p>


                                <p id="expertpreviewbutton" style="float: right">
                                    <button class="btn btn-default" type="reset" onclick="showexpertmodalform()">Cancel</button>
                                    <button type="reset" class="btn btn-primary" id="btneditexpert" onclick="submitexpform(1)">Confirm</button>
                                </p>

                            </div>


                        </div>

                    </div>

                </div>
            </div>
        </div>
        
        <!-- Playlist Reg -->

<div class="modal audvisor-playlist-add-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="newplaylistAdd">

                <div class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div id="alertMsg1" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">New PlayList</h3>
                        </div>
                        <div class="panel-body">

                            <form id="newplaylistAddForm">

                                <!-- <div class="col-xs-8 col-md-7"> -->
                                <div class="row" id="addtopicdiv">

                                    <div class="col-xs-8 col-md-3">
                                        <span class="pull-right">  <label for="playlistName">PlayList Name: </label> </span></div>
                                    <div class="col-xs-8 col-md-7">
                                        <input onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="playlistname" type="text" maxlength="50" class="form-control" size="30" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                    </div>
                                </div>

                                <div id="avilability"></div>

                            </form>

                            <form id="previewplaylistform">


                                <div class="row">

                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"> <label for="playlistName">PlayList Name: </label></span></div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewplaylistname"></label></div>
                                </div>
                                
                                <div class="col-xs-8 col-md-4">
                                </div>

                                <div id="avilability"></div>


                            </form>

                        </div>
                    </div>

                    <div>
                        <p id="playlistaddbutton" style="display: inline-block;float:right">
                            <button class="btn btn-default" type="button" onclick="hideaddplaylist()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddplaylist1" onclick="playlistconfirmation(1)">Save</button>
                        </p>
                        <p id="playlistpreviewbutton" style="display: none;float:right">
                            <button class="btn btn-default" type="button" onclick="showplaylistmodalform()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddplaylist" onclick="addPlaylist(1)">Confirm</button>
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


        <div class="modal audvisor-insight-preview-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">

                    <div id="previewinsight">
                        <div class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                            <div id="successMsg" class="alert alert-success"></div>
                            <div id="alertMsg" class="alert alert-danger"></div>


                            <div class="panel panel-primary">
                                <div class="panel-heading ">
                                    <h3 class="panel-title"> Preview Insight</h3>
                                </div>
                                <div class="panel-body">


                                    <br>

                                    <form id="regform">
                                        <div class="row">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label for="ititle">Title:</label></span></div>
                                            <div class=" col-md-6"><label id="previewititle"></label>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <br>

                                            <div class=" col-md-3">
                                                <span class="pull-right"><label for="insightrating"> Rating:</label></span>
                                            </div>
                                            <div class=" col-md-6"><label id="previewinsightrating"></label>
                                            </div>

                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-3"><span class="pull-right"><label for="insightdescription">FB Share Text:</label></span></div>
                                            <div class="col-md-9"><textarea id="previewfbsharedesc" rows="5" readonly="true" style="font-weight: bold"></textarea></div>
                                        </div>
                                        <br>
                                        <div class="row">

                                            <div class=" col-md-3"><span class="pull-right"><label for="topicid">Topic:</label></span>
                                            </div>
                                            <div class=" col-md-6"><label id="previewtopicid"></label>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label for="expid">Expert:</label></span></div>
                                            <div class=" col-md-6"><label id="previewexpid"></label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label for="playlistid">PlayList:</label></span></div>
                                            <div class=" col-md-6"><label id="previewplaylistid"></label>
                                            </div>
                                        </div>
                                        <br>

                                        <div class="row" id="previewfilerow">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label for="filename">Insight:</label></span></div>
                                            <div class=" col-md-6"><label id="previewfile"></label>
                                            </div>
                                        </div>
                                        <div class="row" id="previewvofilerow">
                                            <div class=" col-md-3">
                                                <span class="pull-right"><label for="filename">Voice-Over:</label></span></div>
                                            <div class=" col-md-6"><label id="previewvofile"></label>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                            <div>
                                <p style="float: right">
                                    <button class="btn btn-default" type="reset" onclick="hideinsightpreview()">Cancel</button>
                                    <button type="reset" class="btn btn-primary" id="btnsubmitinsight">Confirm</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal audvisor-deleted_expert-preview-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div id="previewexpert">
                        <div class="container" id="previewexpertcontainer" style="width:96%; margin-right:2%; margin-left: 2%">
                            <div id="alertMsg" class="alert alert-danger"></div>

                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Re-Enable Expert Preview</h3>
                                </div>
                                <div class="panel-body">
                                    <form id="previewexpertForm">
                                        <!-- <div style="width: 85%; float:left">-->
                                        <div class="row">
                                        </div>
                                        <div class="row">
                                            <div class=" col-md-4">
                                                <span class="pull-right"><label for="expertname">First Name: </label></span>
                                            </div>
                                            <div class=" col-md-7"><label id="dpreviewexpertname"></label></div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class=" col-md-4">
                                                <span class="pull-right"> <label for="expertname">Last Name: </label></span>
                                            </div>
                                            <div class=" col-md-7"><label id="dpreviewlastname"></label></div>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class=" col-md-4">
                                                <span class="pull-right"> <label for="expertname">Title: </label></span></div>
                                            <div class=" col-md-7"><label id="dpreviewexperttitle"></label></div>
                                            <!-- </div>  -->
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class=" col-md-4">
                                                <span class="pull-right"> <label for="expertname">Promo Title: </label></span>
                                            </div>
                                            <div class=" col-md-7"><label id="dpreviewpromotitle"></label></div>
                                            <!-- </div>  -->
                                        </div>
                                        <br>

                                        <div class="row">
                                            <div class=" col-md-4">
                                                <span class="pull-right"> <label for="expertdesc">Biography: </label></span>
                                            </div>
                                            <div class=" col-md-7"><label id="dpreviewexpertdesc"></label></div>
                                            <!-- </div>  -->
                                        </div>
                                        <br>
                                        <!--   <div style="width: 15%; float:right">-->

                                        <div class="row">
                                            <div class=" col-xs-8 col-md-4">
                                                <span class="pull-right"> <label for="expertname">Preview Images: </label></span>
                                            </div>
                                            <div class=" col-xs-8 col-md-7">
                                                <span class="pull-left"><label id="dexpertimagepresenet"></label> </span></div>
                                        </div>
                                        <div class="col-xs-8 col-md-4">
                                        </div>
                                        <div class="col-xs-8 col-lg-3" id="dpreviewexpertimages">
                                            <output id="expertlist"></output>

                                            <span>
                                                <figure>
                                                    <img class="thumb" height="128" width="128" id="dpimages" style="border:1px solid #0174DF"/>
                                                    <figcaption>Profile</figcaption>
                                                </figure>
                                            </span>
                                            <span>
                                                <figure>
                                                    <img class="thumb" height="128" width="128" id="dpbioimage" style="border:1px solid #0174DF"/>
                                                    <br><br>
                                                    <figcaption>Biography</figcaption>
                                                    >
                                                </figure>
                                            </span>
                                            <span>
                                                <figure>
                                                    <img class="thumb" height="128" width="128" id="dpthumbnailimage" style="border:1px solid #0174DF"/>
                                                    <figcaption>Share Image</figcaption>
                                                    >
                                                </figure>
                                            </span>
                                            <span>
                                                <figure>
                                                    <img class="thumb" height="90" width="128" id="dppromoimage" style="border:1px solid #0174DF"/>
                                                    <br><br>
                                                    <figcaption>Promotional</figcaption>
                                                    >
                                                </figure>
                                            </span>
                                        </div>
                                        <label id="expiddel"></label>

                                        <div id="avilability"></div>
                                        <!-- /form</div>-->
                                    </form>
                                </div>
                            </div>

                            <div>
                                <p style="float: right;">
                                    <button class="btn btn-default" type="reset" onclick="re_enable_expert(1);">Re enable</button>
                                    <button type="reset" class="btn btn-primary" id="btneditexpert" onclick="reg_new_expert(1);">New Expert</button>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>

            $(document).ready(function ()
            {

                var topicdiv = document.getElementById("tableinsight");
                var topicrect = topicdiv.getBoundingClientRect();
                var w = window.innerHeight;
                var topicheight = w - topicrect.top - 250;
                var expertheight = topicheight - 50;
                var playlistheight = topicheight - 50;
                var table = $('#tableinsight').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "ajax": '<?php echo BASE_URL_STRING . "/src/utils/COREInsight_ServerProcessing_New.php?client_id=".$_SESSION[CLIENT_ID]; ?>',
                    "bAutoWidth": false,
                    "columns": [
                        {"data": "fldid"},
                        {"data": "title"},
                        {"data": "expertname"},
                        {"data": "fldfbsharedescription"},
                        {"data": "rating"},
                        {"data": "voiceoverurl"},
                        {"data": "topics"},
                        /*{"data": "playlistnames"},*/
                        {"data": "online"},
                        {"data": "featured"},
                         /*{"data": "listen_count"},
                        {"data": "like_count"},
                        {"data": "fb_share_count"},
                       {"data": "twitter_share_count"},
                        {"data": "sms_share_count"},*/
                        {"defaultContent": '<button class="btn-info"  id="btnfeatured">Yes/No </button>'},
                        {"defaultContent": '<button class="btn-info"  id="btnonline">Online/Offline </button>'},
                        {"defaultContent": '<button class="btn-info"  type="submit" value="Stream"  id="btnstream">Stream </button>'},
                        {"defaultContent": '<button class="btn-danger" id="btndelete">Delete </button>'},
                        {"defaultContent": '<button class="btn-info" id="btnedit">Edit </button>'},

                        {"data": "expert_id"},
                        {"data": "topicids"},

                        {"data": "streamingurl"},
                        {"data": "insight_url"},
                        {"data": "expert_image"},
                    ],
                    "oLanguage": {
                        "sProcessing": '<div id="loading"><img id="loading-image" src="<?php echo BASE_URL_STRING ?>src/views/images/load.gif" alt="Loading..." /></div>'
                    },

                    "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull)
                    {

                        $(nRow).children().each(function (index, td)
                        {
                            if (index === 7)
                            {
                                if ($(td).html() === "1")
                                {
                                    $(nRow).addClass("success");
                                    $(td).html("Yes");
                                } else
                                {
                                    $(nRow).addClass("table-striped");
                                    $(td).html("No");
                                }
                            }
                            if (index === 8)
                            {
                                if ($(td).html() === "1")
                                {
                                    $(nRow).addClass("success");
                                    $(td).html("Yes");
                                } else
                                {
                                    $(nRow).addClass("table-striped");
                                    $(td).html("No");
                                }
                            }
                            if (index === 5)
                            {
                                if ($(td).html().length > 3)
                                {
                                    $(td).html("Available");
                                } else
                                {
                                    $(td).html("Not Available");
                                }
                            }
                        });
                        return nRow;
                    },
                    "dom": 'Rlfrtip',
                    responsive: true,
                    "order": [[0, 'desc']],
                    "aoColumnDefs": [
                        {
                            'bVisible': false,
                            "aTargets": [  14, 15, 16, 17,18 ]
                        },
                        {
                            'bSortable': false,
                            'aTargets': [ 7, 8, 9, 10, 11, 12, 13, 14, 15,16 ]
                        },
                        {
                            "bSearchable": false,
                            "aTargets": [ 1, 2, 3, 6 ]
                        },
                    ],
                    "aLengthMenu": [
                        [10, 20, 50, 100, -1],
                        [10, 20, 50, 100, "All"]
                    ],
                    "iDisplayLength": 20,
                    stateSave: true,
                    "sDom": 'TRr<"inline"l> <"inline"f><>t<"inline"p><"inline"i>',
                    "fnInitComplete": function ()
                    {
                        $('#tableinsight').css('display', '');
                        $('#insightpanel').css('display', '');
                    }
                });
                $('#tableinsight')
                        .removeClass('display')
                        .addClass('table table-striped ');

                $('#topicid').multiselect({
                    nonSelectedText: "Select",
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    width: 450,
                    maxHeight: topicheight,
                    buttonWidth: '100%',

                    buttonContainer: '<span class="dropdown" />'

                });
                var topicdiv = document.getElementById("tableinsight");
                var topicrect = topicdiv.getBoundingClientRect();
                var w = window.innerHeight;
                var topicheight = w - topicrect.top;
                $('#expid').multiselect({
                    nonSelectedText: "Select",
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    width: 450,
                    minWidth: 450,
                    maxHeight: expertheight,
                    buttonWidth: '100%',
                    buttonContainer: '<span class="dropdown" />'
                });
                $('#playlistid').multiselect({
                    nonSelectedText: "Select",
                    includeSelectAllOption: true,
                    enableFiltering: true,
                    enableCaseInsensitiveFiltering: true,
                    width: 450,
                    minWidth: 450,
                    maxHeight: playlistheight,
                    buttonWidth: '100%',
                    buttonContainer: '<span class="dropdown" />'            
                });
                                                  
                getInsightstat();

                $('#tableinsight tbody').on('click', 'button', function ()
                {
                    var data = table.row($(this).parents('tr')).data();
                    var id = $(this).attr('id');
                    if (id == "btnedit")
                    {
                        onInsightEditBtnClick(data['fldid'], data['title'], data['expert_id'], data['topicids'], data['insight_url'], data['streamingurl'], data['rating'], data['voiceoverurl'], encodeURIComponent(data['fldfbsharedescription']), data['playlistids']);
                    } else if (id == "btnstream")
                    {
                        console.log(awsurl);
                        window.open(awsurl + data['streamingurl']);
                    } else if (id == "btndelete")
                    {
                        onInsightDeleteBtnClick(data['fldid']);
                    } else if (id == "btnonline")
                    {
                        var idval = "isonline2" + data['fldid'];
                        var idrow = "isonlinerow" + data['fldid'];
                        $(this).attr("id", idval);
                        $($(this).parents('tr')).attr('id', idrow);
                        online(data['fldid'], data['expert_image'], data['expert_image'], data['online']);
                    } else if (id == "btnfeatured")
                    {
                        var idval = "isfeatured2" + data['fldid'];
                        var idrow = "isfeaturedrow" + data['fldid'];
                        $(this).attr("id", idval);
                        $($(this).parents('tr')).attr('id', idrow);
                        markasfeatured(data['fldid'], data['expert_image'], data['expert_image'], data['featured']);
                    } else
                    {
                        online(data['fldid'], data['expert_image'], data['expert_image'], data['online']);
                    }
                    var data = table.row($(this).parents('tr')).data();

                });

            });

        </script>
        <script>
            /*    $('body').bind('dblclick',function(e){
             alert("Double click not allowed");
             e.preventDefault();
             });*/

            $('#btnupdate').on('click', function ()
            {
                var selected = [];
                var topictext = '';
                var topics;
                $('#topicid option:selected').each(function ()
                {
                    selected.push([$(this).val()]);
                    topics = $('#topicid option:selected').text();
                });
                
                var selected_playlist = [];
                $('#playlistid option:selected').each(function()
                {
                    selected_playlist.push([$(this).val()]);
                });
                                           
                editinsightconfirmation(selected,selected_playlist);

            });

            $('#btnsubmitinsight').on('click', function ()
            {
                this.disabled = true;
                var selected = [];
                $('#topicid option:selected').each(function ()
                {
                    selected.push([$(this).val()]);
                    topics = $('#topicid option:selected').text();
                });
                
                var selected_playlist = [];
                var playlists = null;
                $('#playlistid option:selected').each(function()
                {
                    selected_playlist.push([$(this).val()]);
                    playlists = $('#topicid option:selected').text();
                });
                                           
                //hidesuccess();
                updateInsight(selected, topics,selected_playlist,playlists);
            });
        </script>
        <style>
            div.dataTables_info
            {
                font-weight: bold;
            }

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
