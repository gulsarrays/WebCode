<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREInsightAdd.php
  Description                 : To Addinsights to cms
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */
?>
<html>

<head>


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Insights</title>

    <?php
    include 'src/views/header.php';
    ?>


</head>

<body>
<?php include('src/views/navbar.php') ;
?>


<div class="container">
    <div id="successMsg" class="alert alert-success"></div>
    <div id="alertMsg" class="alert alert-danger"></div>
    <div class="panel panel-primary">
        <div class="panel-heading ">
            <h3 class="panel-title" style="margin-left: 1%"> New Insight</h3>
        </div>
        <div id="insightpanelbody" class="panel-body">
            <div style="margin-left: 10%">


                <form id="regform">
                    <div class="row">
                        <div class="col-xs-8 col-md-2">
                            <span class="pull-right"><label for="ititle"> Title:</label></span></div>
                        <div class="col-xs-8 col-md-4">
                            <input type="text" placeholder="Title" id="ititle" class="form-control" maxlength="150" size="30" onclick=" hidesuccess();" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                        </div>

                    </div>

                    <div class="row">
                        <br>

                        <div class="col-xs-8 col-md-2">
                            <span class="pull-right"><label for="insightrating"> Rating:</label></span></div>
                        <div class="col-xs-8 col-md-4">
                            <input type="text" placeholder="50" id="insightrating" class="form-control" maxlength="3" size="30" onclick=" hidesuccess();" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" oninput="rating_range(this.id)">
                        </div>

                    </div>

                    <br>
                    <div class="row">
                      <div class="col-xs-8 col-md-2">
                            <span class="pull-right"> <label for="fbsharedesc">FB Share Text:</label></span></div>
                        <div class="col-xs-8 col-md-4">
                            <textarea  id="fbsharedesc" placeholder="This text will be used when the insight is shared over Social Media." name="fbsharedesc" type="text"  rows="5" maxlength="200" class="form-control" onclick=" hidesuccess();"></textarea>
                        </div>

                     </div>
                    <br>

                    <div class="row">

                        <div class="col-xs-8 col-md-2">
                            <span class="pull-right"> <label for="topicid">Groups :</label></span>
                        </div>
                        <?php //   print_r(); exit; ?>
                        <div class="col-xs-8 col-md-4" >
                            <select  id="groupid"  class="form-control">
                                      <?php
                            if(isset($groups[JSON_TAG_GROUPS])) {                                
                            foreach($groups[JSON_TAG_GROUPS] as $aList)
                                {
                                    ?>

                                    <option value=" <?php echo $aList['id']; ?>"> <?php echo $aList[JSON_TAG_TITLE]; ?>  </option>

                            <?php } } ?>

                            </select>
                            </select>

                        </div>
                        <!--<button class="btn btn-primary" data-toggle="modal" data-target=".audvisor-topic-add-modal" type="button" id="" class="btn btn-primary" onclick="showaddTopic()"> Add Topic &nbsp;</button>-->

                    </div>

                    <br>

                    <div class="row" id="topicrow">


                        <div class="col-xs-8 col-md-2">
                            <span class="pull-right"> <label for="topicid">Topic:</label></span></div>
                        <div class="col-xs-8 col-md-4" id="width1">
                            <select id="topicid" onchange="hidesuccess();" multiple="multiple" size="30" style="width:600px;" class="form-control">
                                
                            <?php
                            if(isset($Data[JSON_TAG_TOPICS])) {
                            foreach($Data[JSON_TAG_TOPICS] as $aList)
                                {
                                    ?>

                                    <option value=" <?php echo $aList['topic_id']; ?>"> <?php echo $aList[JSON_TAG_TOPIC_NAME]; ?>  </option>

                            <?php } } ?>

                            </select>

                        </div>
                        <button class="btn btn-primary" data-toggle="modal" data-target=".audvisor-topic-add-modal" type="button" id="" class="btn btn-primary" onclick="showaddTopic()"> Add Topic &nbsp;</button>

                    </div>

                    <br>

                    <div class="row" id="expertrow">
                        <div class="col-xs-8 col-md-2">
                            <span class="pull-right"><label for="expid">Expert:</label></span></div>
                        <div class="col-xs-8 col-md-4">
                            <div>
                                <select id="expid" style="text-align:right;float: right;direction: rtl;" size="30" data-width="100%" onchange=" hidesuccess();">

                                    <option style="text-align:right" value="-1"> Select</option>

                                    <?php foreach($Data1[JSON_TAG_EXPERTS] as $aList1)
                                    {
                                        ?>


                                        <option style="text-align:right" value=" <?php echo $aList1['expert_id']; ?>"> <?php echo $aList1[JSON_TAG_EXPERT_NAME] ?>  </option>


                                    <?php } ?>


                                </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" onclick="showaddExpert()" data-toggle="modal" data-target=".audvisor-expert-add-modal" type="button" id="btnaddexp" class="btn btn-primary"> Add Expert</button>

                    </div>
                    
                    <br>
                    <!-- PlayList Row start -->
                    <div class="row" id="playlistrow">


                        <div class="col-xs-8 col-md-2">
                            <span class="pull-right"> <label for="playlistid">PlayList:</label></span></div>
                        <div class="col-xs-8 col-md-4" id="width1">
                            <select id="playlistid" onchange="hidesuccess();" multiple="multiple" size="30" style="width:600px;" class="form-control">
                                
                            <?php
                            
                                    
                            if(isset($playlists['playlist'])) {
                                foreach($playlists['playlist'] as $aList)
                                {
                                    
                                    if(!is_array($aList)) {
                                        continue;
                                    }
                                    ?>

                                    <option value=" <?php echo $aList['playList_id']; ?>"> <?php echo $aList['playList_name']; ?>  </option>

                            <?php } } ?>

                            </select>

                        </div>
                        <button class="btn btn-primary" data-toggle="modal" data-target=".audvisor-playlist-add-modal" type="button" id="" class="btn btn-primary" onclick="showaddPlayList()"> Add PlayList &nbsp;</button>

                    </div>

                    <br>
                    <!-- PlayList Row end -->
                    
                    <div class="row">

                        <div class="col-xs-8 col-md-2">
                            <span class="pull-right"> <label for="insight">Insight:</label></span></div>
                        <div class="col-xs-8 col-md-4">
                            <span class="pull-right">  <input dir="rtl" id="insight" name="insight" type="file" accept="audio/*" class="form-control" onclick=" hidesuccess();"> </span>
                        </div>

                    </div>
                    <br>

                    <div class="row">
                        <div class="col-xs-8 col-md-2">
                            <span class="pull-right"> <label for="insight">Voice-Over:</label></span></div>
                        <div class="col-xs-8 col-md-4">
                            <span class="pull-right">  <input dir="rtl" id="insightvoiceover" name="insightvoiceover" type="file" accept="audio/*" class="form-control" onclick=" hidesuccess();"> </span>
                        </div>
                    </div>
                    <br>

                </form>


            </div>
        </div>
    </div>

    <div>
        <p>
            <button class="btn btn-primary" name="submit" id="save_btn" style="float: right">Save</button>

        </p>
    </div>
</div>

<!--  Topic Reg modal   -->


<div class="modal audvisor-topic-add-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="newtopicAdd">

                <div class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div id="alertMsg1" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">New Topic</h3>
                        </div>
                        <div class="panel-body">

                            <form id="newtopicAddForm">

                                <!-- <div class="col-xs-8 col-md-7"> -->
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
                        <p id="topicaddbutton" style="display: inline-block;float:right">
                            <button class="btn btn-default" type="button" onclick="hideaddTopic()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddtopic1" onclick="topicconirmation(1)">Save</button>
                        </p>
                        <p id="topicpreviewbutton" style="display: none;float:right">
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


<div id="mymodal" class="modal  audvisor-expert-add-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
    <!-- <div class="col-xs-8 col-md-7"> -->
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
                <textarea onfocus="hidesuccess();" onkeyup="" onkeypress="" id="expdesc" type="text" rows="5" class="form-control" maxlength="1000" oninput=""> </textarea>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="  col-md-4"><span class="pull-right">  <label for="rating">Rating: </label> </span></div>
            <div class="  col-md-7">
                <input onfocus="hidesuccess();" placeholder="" onkeyup="" onkeypress="" id="exprating" class="form-control" maxlength="3" oninput="rating_range(this.id)">
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-4"><span class="pull-right">  <label for="twitterhandle">Twitter Handle: </label> </span>
            </div>
            <div class="col-md-7">
                <div class="input-group">
                    <span class="input-group-addon">@</span><input onfocus="hidesuccess();" placeholder="" onkeyup="" onkeypress="" id="twitterhandle" class="form-control" maxlength="15" oninput="">
                </div>
            </div>
        </div>
        <br>
        <input type="hidden" name="imageid" id="imageid" value="">
    </div>
    <div style="width: 40%; float:right;overflow:hidden" class="container">
        <div class="row">
            <br>

            <div class=" col-md-6">
                <span class="pull-right"> <label for="photo">Profile Image: </label></span></div>
            <div class="  col-md-6">
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
        <br>

        <div class="row">
            <div class="col-md-6">
                <span class="pull-right">
                    <label for="fbshareimage">FB Share Image: </label>
                </span>
            </div>
            <div class="col-md-6">
                <input id="fbshareimage" dir="rtl" name="fbshareimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
            </div>
        </div>
        <div class="row">
            <br>

            <div class="col-md-6">
                <span class="pull-right"> <label for="voiceover">Voice-Over: </label></span></div>
            <div class="  col-md-6">
                <input id="expertvoiceover" dir="rtl" name="expertvoiceover" type="file" accept="audio/*" class="form-control">
            </div>

        </div>
    </div>
</form>
<form id="previewexpertForm">
    <div style="width: 60%; float:left;overflow:hidden" class="container">

        <div class="row">
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
            <div class=" col-md-7"><label id="previewpromotitle"></label></div>
            <!-- </div>  -->
        </div>
        <br>

        <div class="row">
            <div class=" col-md-4"><span class="pull-right"> <label for="expertdesc">Biography: </label></span></div>
            <div class=" col-md-6"><label id="previewexpertdesc"></label></div>
            <!-- </div>  -->
        </div>
        <br>

        <div class="row">
            <div class=" col-md-4"><span class="pull-right"> <label for="expertrating">Rating: </label></span></div>
            <div class=" col-md-7"><label id="previewexpertrating"></label></div>
            <!-- </div>  -->
        </div>
        <br>

        <div class="row">
            <div class=" col-md-4"><span class="pull-right"> <label for="twitterhandle">Twitter Handle: </label></span>
            </div>
            <div class=" col-md-7">
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
                <span class="pull-right"> <label for="expertname">Preview Images: </label></span></div>
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
        <div id="avilability"></div>
    </div>

</form>
</div>
<br>
</div>
<div>
    <p id="expertaddbutton" style="float: right;">
        <button class="btn btn-default" type="button" onclick="hideExpertaddForm()">Cancel</button>
        <button type="button" class="btn btn-primary" id="btneditexpert1" onclick="expertconirmation(1)">Save</button>
    </p>


    <p id="expertpreviewbutton" style="display: none;float: right;">
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


<!-- Insight Preview Modal -->


<div class="modal audvisor-insight-preview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
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
                                        <span class="pull-right"><label for="insightreputation"> Rating:</label></span>
                                    </div>
                                    <div class=" col-md-6"><label id="previewinsightrating"></label>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-3"><span class="pull-right"><label>FB Share Text:</label></span></div>
                                    <div class="col-md-9"><textarea readonly="true" rows="5" style="font-weight: bold;"  id="previewfbsharedesc"></textarea></label></div>
                                </div>
                                <br>
                                <div class="row">

                                    <div class=" col-md-3"><span class="pull-right"><label for="groupid">Group:</label></span>
                                    </div>
                                    <div class=" col-md-6"><label id="previewgroupid"></label>
                                    </div>
                                </div>
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
                                <br>

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
                        <p style="float: right;">
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
                <div class="container" id="previewexpertcontainer">
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

                                            <span id="dpimagesspan">
                                                <figure>
                                                    <img class="thumb" height="128" width="128" id="dpimages" style="border:1px solid #0174DF"/>
                                                    <figcaption>Profile</figcaption>
                                                </figure>
                                            </span>
                                            <span id="dpbioimagespan">
                                                <figure>
                                                    <img class="thumb" height="128" width="128" id="dpbioimage" style="border:1px solid #0174DF"/>
                                                    <figcaption>Biography</figcaption>
                                                </figure>
                                            </span>
                                    <br><br>
                                            <span id="dpthumbnailimagespan">
                                                <figure>
                                                    <img class="thumb" height="128" width="128" id="dpthumbnailimage" style="border:1px solid #0174DF"/>
                                                    <figcaption>Share Image</figcaption>
                                                </figure>
                                            </span>
                                            <span id="dppromoimagespan">
                                                <figure>
                                                    <img class="thumb" height="90" width="128" id="dppromoimage" style="border:1px solid #0174DF"/>
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
                        <p style="float: right">
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

    $(document).ready(function()
                      {
                          var topicdiv = document.getElementById("topicrow");
                          var topicrect = topicdiv.getBoundingClientRect();
                          var w = window.innerHeight;
                          var topicheight = w - topicrect.top - 100;
                          $('#topicid').multiselect(
                              {
                                  nonSelectedText: "Select",
                                  includeSelectAllOption: true,
                                  enableFiltering: true,
                                  enableCaseInsensitiveFiltering: true,
                                  width: 450,
                                  maxHeight: topicheight,
                                  buttonWidth: '100%',
                                  buttonContainer: '<span class="dropdown" />'
                              });
                          var expertdiv = document.getElementById("expertrow");
                          var expertrect = expertdiv.getBoundingClientRect();
                          var expertheight = window.innerHeight - expertrect.top - 100;
                          $('#expid').multiselect({
                                                      nonSelectedText: "Select",
                                                      includeSelectAllOption: true,
                                                      enableFiltering: true,
                                                      enableCaseInsensitiveFiltering: true,
                                                      width: 450,
                                                      minWidth: 450,
                                                      maxHeight: expertheight,
                                                      buttonWidth: '100%',
                                                      buttonContainer: '<span class="dropdown" />'
                                                  });
                                                  
                                                  
                                                  
                          var playlistdiv = document.getElementById("playlistrow");
                          var playlistrect = playlistdiv.getBoundingClientRect();
                          var playlistheight = window.innerHeight - playlistrect.top - 100;
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
                                                  
                                                  
                      });
    $('#save_btn').on('click', function()
    {
        hidesuccess();
        var selected = [];
        $('#topicid option:selected').each(function()
                                           {
                                               selected.push([$(this).val()]);
                                           });
                                           
        var selected_playlist = [];
        $('#playlistid option:selected').each(function()
                                           {
                                               selected_playlist.push([$(this).val()]);
                                           });
        hidesuccess();
        insightconfirmation(selected);
    });
    $('#btnsubmitinsight').on('click', function()
    {
        this.disabled = true;
        var selected = [];
        $('#topicid option:selected').each(function()
                                           {
                                               selected.push([$(this).val()]);
                                           });
        var selected_playlist = [];
        $('#playlistid option:selected').each(function()
                                           {
                                               selected_playlist.push([$(this).val()]);
                                           });
        hidesuccess();
        submitform(selected,selected_playlist);
    });

    $('#insightreputation').on('keypress', function(ev)
    {
        var keyCode = window.event ? ev.keyCode : ev.which;
        //codes for 0-9

        if(keyCode < 48 || keyCode > 57)
        {

            //codes for backspace, delete, enter
            if(keyCode != 0 && keyCode != 8 && keyCode != 13 && !ev.ctrlKey)
            {
                ev.preventDefault();
            }

        }
    });
</script>
</body>
</html>