<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREExpertList.php
  Description                 : To List and edit the expert details for cms
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

    <title>Experts </title>

    <?php
    include 'src/views/header.php';
    ?>

</head>

<body>
<?php include('src/views/navbar.php') ?>


<div id="expertsmaincontainer" class="container">
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 id="statistics" class="panel-title">Experts</h3>
    </div>

    <div class="panel-body">
        <div class="table-responsive">
            <table id="experttable" class="table table-striped table-bordered" cellspacing="0" width="100%">

                <?php
                if (array_key_exists("code", $Data))
                {
                    $errVal = ($Data["code"]);
                    if($errVal == 205)
                    {
                        echo 'No Experts';
                    }
                }
                else
                {
                ?>
                <thead>
                <tr class="table-striped">
                    <th width="20px"> Id</th>
                    <th> Name</th>
                    <th> Title</th>
                    <th width="45px">Rating</th>
                    <th width="75px">Voice-Over</th>
                    <th>Expert Bio</th>
                    <th width="108px">Twitter Handle</th>
                    <th width="65px"> Insight #</th>
                    <th width="35px"></th>
                    <th width="20px"></th>
                </tr>
                </thead>
                <tbody>

                <?php
                if (count($Data[JSON_TAG_EXPERTS]) != 0)
                {
                foreach ($Data[JSON_TAG_EXPERTS] as $aList)
                {
                ?>

                <tr class="table-striped">

                    <td style="text-align: center"> <?php echo $aList['expert_id']; ?> </td>
                    <td style="text-align: left" id="<?php echo $aList['expert_id']; ?>"> <?php echo $aList[JSON_TAG_EXPERT_NAME] ?> </td>
                    <td style="text-align: left" id="<?php echo $aList['expert_id']; ?>title"> <?php echo $aList[JSON_TAG_EXPERT_TITLE]; ?> </td>
                    <td style="text-align: center"> <?php echo $aList[JSON_TAG_RATING]; ?> </td>
                    <td style="text-align: center"> <?php if($aList[JSON_TAG_EXPERT_VOICE_OVER_URL] == null)
                        {
                            echo 'Not Available';
                        }
                        else
                        {
                            echo "Available";
                        }

                        ?>           </td>
                    <td style="text-align: left"> <?php echo $aList[JSON_TAG_DESC]; ?> </td>
                    <td style="text-align: left">

                        <?php
                        if(isset($aList[JSON_TAG_TWITTER_HANDLE]) && trim($aList[JSON_TAG_TWITTER_HANDLE]) !== '')
                        {
                            ?>
                            <a href="<?php echo "https://twitter.com/".$aList[JSON_TAG_TWITTER_HANDLE]; ?> " target="_blank"> <?php
                                if(isset($aList[JSON_TAG_TWITTER_HANDLE]) && trim($aList[JSON_TAG_TWITTER_HANDLE]) !== '')
                                {
                                    echo $aList[JSON_TAG_TWITTER_HANDLE];
                                }
                                ?></a>
                        <?php
                        }
                        else
                        {
                            echo 'Not Available';
                        }?>
                    </td>
                    <td style="text-align: center"> <?php echo $aList[JSON_TAG_COUNT]; ?> </td>
                    <td style="text-align: center">
                        <button onclick="onExpertDeleteBtnClick('<?php echo $aList['expert_id']; ?>')" id="btnDelete" class="btn-danger"> Delete</button>
                    </td>
                    <td style="text-align: center">
                        <button onclick="onExpertEditBtnClick('<?php echo $aList['expert_id']; ?>','<?php echo str_replace("'", "\'", $aList[JSON_TAG_FIRST_NAME]); ?>','<?php echo str_replace("'", "\'", $aList[JSON_TAG_MIDDLE_NAME]); ?>','<?php echo str_replace("'", "\'", $aList[JSON_TAG_LAST_NAME]); ?>','<?php echo $aList[JSON_TAG_EXPERT_IMAGE]; ?>','<?php echo urlencode($aList[JSON_TAG_EXPERT_TITLE]); ?>','<?php echo urlencode($aList[JSON_TAG_DESC]); ?>','<?php echo $aList[JSON_TAG_AVATAR_LINK]; ?>','<?php echo $aList[JSON_TAG_BIO_IMAGE]; ?>','<?php echo $aList[JSON_TAG_THUMBNAIL_IMAGE]; ?>','<?php echo $aList[JSON_TAG_PROMO_IMAGE]; ?>','<?php echo urlencode($aList[JSON_TAG_PROMO_TITLE]); ?>','<?php echo $aList[JSON_TAG_RATING]; ?>','<?php echo $aList[JSON_TAG_EXPERT_VOICE_OVER_URL]; ?>','<?php echo $aList[JSON_TAG_LISTVIEW_IMAGE] ?>','<?php echo str_replace("'", "\'", $aList[JSON_TAG_PREFIX]); ?>', '<?php echo urlencode($aList[JSON_TAG_TWITTER_HANDLE]); ?>','<?php echo $aList[JSON_TAG_FBSHARE_IMAGE] ?>') " data-toggle="modal" data-target=".audvisor-expert-edit-modal" id="btnEdit" class="btn-info"> Edit</button>
                    </td>
                    <?php
                    }
                    } ?>
                </tr>

                <?php
                }
                ?>
                </tbody>


            </table>
        </div>
    </div>
</div>


<div class="modal audvisor-expert-edit-modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">


<div id="editexpert">
<div id="editexpertcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
<div id="alertMsg" class="alert alert-danger"></div>

<form id="editexpertForm">
<div class="panel panel-primary">
<div class="panel-heading">
    <h3 class="panel-title">Expert Edit</h3>
</div>
<div id="editexpertpanelbody" class="panel-body">
<!--<div class="col-xs-8 col-md-10">-->
<div class="row">
    <div style="width: 50%; float:left;overflow:hidden" class="container">
        <br>

        <div class="row">

            <div class=" col-md-5">
                <span class="pull-right"><label for="expertname">&nbsp;Prefix:</label></span></div>
            <div class=" col-md-7">
                <input onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="expertprefix" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
            </div>
        </div>
        <br>

        <div class="row">
            <input type="hidden" name="expertid" id="expertid" value="">

            <div class=" col-md-5">
                <span class="pull-right"><label for="expertname">&nbsp;First Name:</label></span>
            </div>
            <div class=" col-md-7">
                <input onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="expertname" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
            </div>
        </div>
        <br>

        <div class="row">

            <div class=" col-md-5">
                <span class="pull-right"> <label for="expertname">&nbsp;Middle Name:</label></span>
            </div>
            <div class=" col-md-7">
                <input onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="middlename" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
            </div>
        </div>
        <br>
        <div class="row">

            <div class=" col-md-5">
                <span class="pull-right"> <label for="expertname">&nbsp;Last Name:</label></span>
            </div>
            <div class=" col-md-7">
                <input onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="lastname" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
            </div>
        </div>
        <br>

        <div class="row">
            <div class=" col-md-5"><span class="pull-right"> <label for="expertname">Title: </label></span>
            </div>
            <div class=" col-md-7">
                <input onkeyup="" maxlength="250" onkeypress="" id="experttitle" type="text" class="form-control" oninput="">
            </div>
        </div>
        <br>

        <div class="row">
            <div class=" col-md-5">
                <span class="pull-right"> <label for="expertrating">Rating: </label></span></div>
            <div class=" col-md-7">
                <input onkeyup="" maxlength="3" onkeypress="" id="expertrating" type="text" class="form-control" oninput="rating_range(this.id)">
            </div>
        </div>
        <br>

        <div class="row">
            <div class=" col-xs-8 col-md-5">
                <span class="pull-right">  <label for="exptitle">Promo Title: </label> </span></div>
            <div class=" col-xs-8 col-md-7">
                <input onfocus="hidesuccess();" onkeyup="" onkeypress="" id="promotitle" type="text" class="form-control" maxlength="250" oninput="">
            </div>
        </div>
        <br>

        <div class="row">
            <div class=" col-xs-8 col-md-5">
                <span class="pull-right">  <label for="twitterhandle">Twitter Handle: </label> </span>
            </div>
            <div class=" col-xs-8 col-md-7">
                <div class="input-group"><span class="input-group-addon">@</span>
                    <input onfocus="hidesuccess();" placeholder="Twitter Handle" onkeyup="" onkeypress="" id="twitterhandle" class="form-control" maxlength="15" oninput="">
                </div>
            </div>
        </div>
        <br>

        <div class="row">
            <div class=" col-md-5">
                <span class="pull-right"> <label for="expertdesc">Biography: </label></span></div>
            <div class=" col-md-7">
                <textarea onkeyup="" maxlength="500" onkeypress="" id="expertdesc" rows="5" class="form-control" oninput=""> </textarea>
            </div>
        </div>

        <br>

        <div class="row">

            <div class=" col-md-5"><span class="pull-left"><label for="expertdesc">Images: </label></span>
            </div>


        </div>
    </div>
    <div style="width: 50%; float:right">

        <div class="row">
            <br>

            <div class=" col-md-6">
                <span class="pull-right"> <label for="photo">New Profile Image: </label></span>
            </div>
            <div class="col-md-6">
                <input id="images" dir="rtl" name="images" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
            </div>

        </div>

        <div class="row">
            <br>

            <div class="col-xs-8 col-md-6">
                <span class="pull-right"> <label for="photo"> New Bio Image: </label></span></div>
            <div class=" col-xs-8 col-md-6">
                <input id="bioimage" dir="rtl" name="bioimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
            </div>

        </div>
        <div class="row">
            <br>

            <div class="col-xs-8 col-md-6">
                <span class="pull-right"> <label for="photo">New Share Image: </label></span></div>
            <div class=" col-xs-8 col-md-6">
                <input id="thumbnailimage" dir="rtl" name="thumbnailimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
            </div>

        </div>
        <div class="row">
            <br>

            <div class="col-xs-8 col-md-6">
                <span class="pull-right"> <label for="photo">New Promo Image: </label></span></div>
            <div class=" col-xs-8 col-md-6">
                <input id="promoimage" dir="rtl" name="promoimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
            </div>

        </div>
        <div class="row">
            <br>

            <div class="col-xs-8 col-md-6">
                <span class="pull-right"> <label for="photo">New List View Image: </label></span>
            </div>
            <div class=" col-xs-8 col-md-6">
                <input id="listviewimage" dir="rtl" name="listviewimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
            </div>

        </div>


        <br>

        <div class="row">


            <div class="col-xs-8 col-md-6">
                <span class="pull-right"> <label for="photo">New FB Share Image: </label></span>
            </div>
            <div class=" col-xs-8 col-md-6">
                <input id="fbshareimage" dir="rtl" name="fbshareimage" type="file" onchange="showimagespreview(this)" accept="image/*" class="form-control">
            </div>

        </div>


        <br>

        <div class="row">
            <div class=" col-xs-8 col-md-6">
                <span class="pull-right"><label id="einsightlabel" for="insight">Voice-Over:</label></span>
            </div>
            <div class="col-xs-8 col-md-6">
                <label id="lblexpertvo">Not Available</label>
                <audio controls id="editexpertvoplayer" style="width:100%;">
                    <source id="expertvoiceovermp3" type="audio/mpeg">
                </audio>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <br>

        <div class="row">
            <br>

            <div class=" col-md-6">
                <span class="pull-right"> <label for="photo">New Voice-Over: </label></span></div>
            <div class="col-md-6">
                <input id="expertvoiceover" dir="rtl" name="expertvoiceover" type="file" accept="audio/*" class="form-control">
            </div>

        </div>

    </div>
</div>
<div>
    <div class='wrap'>
        <div class="blocks">
            <div>
                <figure>
                    <img id="previewexpertimage_2x" src="" alt="Image Not Available" title="" height="128" width="128"></img>
                    <figcaption>Profile Image</figcaption>
                </figure>
            </div>
        </div>

        <div class="blocks">
            <div>
                <figure>
                    <img id="ebioimage" src="" alt="Image Not Available" title="" height="128" width="128"></img>
                    <figcaption>Bio Image</figcaption>
                </figure>
            </div>
        </div>
        <div class="blocks">
            <div>
                <figure>
                    <img id="ethumbnailimage" src="" alt="Image Not Available" title="" height="128" width="128"></img>
                    <figcaption>Share Image</figcaption>
                </figure>
            </div>

        </div>

        <div class="blocks">
            <div>
                <figure>
                    <img id="elistviewimage" src="" alt="Image Not Available" title="" height="128" width="128"></img>
                    <figcaption>List VIew Image</figcaption>
                </figure>
            </div>
        </div>
        <div class="blocks">
            <div>
                <figure>
                    <img id="efbshareimage" src="" alt="Image Not Available" title="" height="128" width="244"></img>
                    <figcaption>FB Share Image</figcaption>
                </figure>
            </div>
        </div>

        <div class="blocks">
            <div>
                <figure>
                    <img id="epromoimage" src="" alt="Image Not Available" title="" height="90" width="128"></img>
                    <figcaption>Promo Image</figcaption>
                </figure>
            </div>
        </div>
    </div>
</div>


<!--</div> -->
</div>
</div>
</form>

<div>
    <p style="float: right">
        <button class="btn btn-default" type="reset" onclick="hideExpertEditForm()">Cancel</button>
        <button type="reset" class="btn btn-primary" id="btneditexpert" onclick="editexpertconirmation()">Update</button>
    </p>
</div>
</div>
</div>

</div>
</div>
</div>
</div>

<!-- expert edit preview modal-->
<div class="modal audvisor-expert-preview-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div id="previewexpert">
            <div id="expertspreviewmodal" class="container" style="width:96%; margin-right:2%; margin-left: 2%">


                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Expert Preview</h3>
                    </div>
                    <div class="panel-body">
                        <form id="previewexpertForm" class="container">
                            <div style="width: 60%; float:left;overflow:hidden" class="container">

                                <div class="row">
                                    <!--  <div class=" col-md-3"> <span class="pull-right"><img id="previewimage" src="" alt="Image Not Selected" height="90" width="128"></img></span></div>-->
                                </div>
                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"><label for="expertname">Prefix: </label></span></div>
                                    <div class=" col-md-7"><label id="previewexpertprefix"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"><label for="expertname">First Name: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewexpertname"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="expertname">Middle Name: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewmiddlename"></label></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="expertname">Last Name: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewlastname"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="expertname">Title: </label></span></div>
                                    <div class=" col-md-7"><label id="previewexperttitle"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="expertname">Rating: </label></span></div>
                                    <div class=" col-md-7"><label id="previewexpertrating"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="expertname">Promo Title: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewpromotitle"></label></div>
                                    <!-- </div>  -->
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="twitterhandle">Twitter Handle: </label></span>
                                    </div>
                                    <div class=" col-md-7">
                                        <a id="previewtwitterhandle" target="_blank"></a>
                                    </div>
                                    <!-- </div>  -->
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="expertname">Biography: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewexpertdesc"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="expertdesc">Voice-Over: </label></span>
                                    </div>
                                    <div class=" col-md-7">
                                        <span class="pull-left"><label id="previewexpertvoiceover">No New File Selected</label> </span>
                                    </div>
                                </div>
                            </div>
                            <!-- </div> -->
                            <div style="width: 40%; float:right;">
                                <div class=" col-md-4">
                                    <span class="pull-right"><label id="lblnotselected" for="expertname">Expert Image: </label></span>
                                </div>
                                <div class=" col-md-7">
                                    <span class="pull-left"> <label id="imgnotavailable" for="expertimage">No new image selected </label>  </span>
                                </div>
                                <!--   </div> -->
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"><label id="lblimgselected" for="expertname">Expert Image: </label></span>
                                    </div>
                                    <div class="col-lg-12" id="previewexpertimages">
                                        <output id="expertlist">

                                                        <span style="float:left;">
                                                <figure>
                                                    <img class="thumb" height="128" width="128" id="pimages" style="border:1px solid #0174DF"/>
                                                    <figcaption>Profile Image</figcaption>
                                                </figure>
                                            </span>
                                            <span style="float:right;">
                                                <figure>
                                                    <img class="thumb" height="128" width="128" id="pbioimage" style="border:1px solid #0174DF"/>
                                                    <figcaption>Bio Image</figcaption>

                                                </figure>
                                            </span>
                                        <br><br>
                                            <span style="float:left;"><figure>
                                                    <img class="thumb" height="128" width="128" id="pthumbnailimage" style="border:1px solid #0174DF"/>
                                                    <figcaption>Share Image</figcaption>

                                                </figure>
                                            </span>
                                            <span style="float:right;">
                                             <figure>
                                                 <img class="thumb" height="90" width="128" id="ppromoimage" style="border:1px solid #0174DF"/>
                                                 <figcaption>Promo Image</figcaption>
                                             </figure><br><br>
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

                                <div class="row">
                                    <div class=" col-md-7"><span class="pull-left">   <img id="previewimage" src="" alt="Image Not Selected" title="Image Not Selected" height="90" width="128"></img></span>
                                    </div>
                                </div>
                                <div class="col-xs-8 col-md-4">
                                </div>


                            </div>
                        </form>

                    </div>
                </div>
                <div>

                    <p style="float: right">
                        <button class="btn btn-default" type="reset" onclick="hideexpertpreviewForm()">Cancel</button>
                        <button type="reset" class="btn btn-primary" id="btneditexpert" onclick="updateExpert()">Confirm</button>
                    </p>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- deleted expert preview modal-->
<div class="modal audvisor-deletedexpert-preview-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div id="previewdeletedexpert">
                <div id="previewdeletedexpertcontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div id="alertMsg" class="alert alert-danger">This Expert Is previously deleted Do you want to bring him back</div>
                    <form id="previewdeletedexpertForm" class="container">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Expert Preview</h3>
                            </div>
                            <div class="panel-body">
                                <!--    <div style="width: 85%; float:left ;position:relative; border: solid #000"> -->

                                <div class="row">
                                    <!--  <div class=" col-md-3"> <span class="pull-right"><img id="previewimage" src="" alt="Image Not Selected" height="90" width="128"></img></span></div>-->
                                </div>
                                <div class="row">
                                    <div class=" col-md-3">
                                        <span class="pull-right"><label for="expertname">First Name: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewdeletedexpertname"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-3">
                                        <span class="pull-right"> <label for="expertname">Middle Name: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewdeletedmiddlename"></label></div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class=" col-md-3">
                                        <span class="pull-right"> <label for="expertname">Last Name: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewdeletedlastname"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-3">
                                        <span class="pull-right"> <label for="expertname">Title: </label></span></div>
                                    <div class=" col-md-7"><label id="previewdeletedexperttitle"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-3">
                                        <span class="pull-right"> <label for="expertname">Expert Bio: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewdeletedexpertdesc"></label></div>
                                </div>
                                <br>
                                <!-- </div> -->
                                <div class="row">
                                    <!--<div style="width: 15%; float:right;border: solid #000">-->
                                    <div class=" col-md-3">
                                        <span class="pull-right"><label for="expertname">Photo: </label></span></div>
                                    <div class=" col-md-7"><span class="pull-left">   <img id="previewdeletedimage" src="" alt="Image Not Selected" title="Image Not Selected" height="90" width="128" style="visibility: hidden"></img></span>
                                    </div>
                                </div>
                                <!--   </div> -->


                            </div>
                        </div>
                    </form>
                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="reset" onclick="hideexpertpreviewForm()">Register as New Expert</button>
                            <button type="reset" class="btn btn-primary" id="btneditexpert" onclick="updateExpert()">Re-enable old Expert</button>
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
                          getExpertstat();
                          $('#experttable').DataTable({
                                                          "dom": 'Rlfrtip',
                                                          responsive: true,
                                                          "order": [[0, 'desc']],
                                                          "aoColumnDefs": [
                                                              {'bSortable': false, 'aTargets': [8, 9]},
                                                              {"bSearchable": false, "aTargets": [8, 9]}
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
    .blocks
    {
        display: inline-block;
        width: 128px;
    }

    .wrap
    {
        width: 750px;
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

