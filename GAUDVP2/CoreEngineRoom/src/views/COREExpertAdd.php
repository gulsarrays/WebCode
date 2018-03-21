<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREExpertAdd.php
  Description                 : To Add new expert details for cms
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

    <title>Add Expert</title>


    <?php
    include 'src/views/header.php';
    ?>

</head>

<body>
<?php include('src/views/navbar.php') ?>
<div id="addexpert">
    <div class="container">
        <div id="successMsg" class="alert alert-success"></div>
        <div id="alertMsg2" class="alert alert-danger"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">New Expert</h3>
            </div>
            <div class="panel-body">
                <form id="imageform">
                </form>
                <form id="regform1">
                    <div class="col-xs-8 col-md-8">
                        <div class="row">

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right">  <label for="expname">Prefix: </label></span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input onclick="hidesuccess();" placeholder="Prefix" onkeyup="hidesuccess();" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id);" id="expprefix" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                            </div>
                        </div>
                        <br>

                        <div class="row">

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right">  <label for="expname">First Name: </label></span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input onclick="hidesuccess();" placeholder="First Name" onkeyup="hidesuccess();" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id);" id="expname" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                            </div>
                        </div>
                        <br>
                        
                        <div class="row">

                            <div class=" col-xs-8 col-md-3">
                                <span class="pull-right">  <label for="expmiddlename">Middle Name: </label> </span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input onfocus="hidesuccess();" placeholder="Middle Name" onkeyup="disAllowCopyPasteForSpecialCharacters(this.id);" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id);" size="30" id="expmiddlename" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                            </div>
                        </div>
                        <br>

                        <div class="row">

                            <div class=" col-xs-8 col-md-3">
                                <span class="pull-right">  <label for="explastname">Last Name: </label> </span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input onfocus="hidesuccess();" placeholder="Last Name" onkeyup="disAllowCopyPasteForSpecialCharacters(this.id);" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id);" size="30" id="explastname" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class=" col-xs-8 col-md-3">
                                <span class="pull-right">  <label for="exptitle">Title: </label> </span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input onfocus="hidesuccess();" placeholder="Title" onkeyup="" onkeypress="" id="exptitle" type="text" class="form-control" maxlength="250" oninput="">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class=" col-xs-8 col-md-3">
                                <span class="pull-right">  <label for="exptitle">Promo Title: </label> </span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input onfocus="hidesuccess();" placeholder="Promo Title" onkeyup="" onkeypress="" id="promotitle" type="text" class="form-control" maxlength="250" oninput="">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class=" col-xs-8 col-md-3">
                                <span class="pull-right">  <label for="exptitle">Biography: </label> </span></div>
                            <div class=" col-xs-8 col-md-7">
                                <textarea onfocus="hidesuccess();" placeholder="Biography" onkeyup="" onkeypress="" id="expdesc" class="form-control" maxlength="500" rows="5" oninput=""></textarea>
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class=" col-xs-8 col-md-3">
                                <span class="pull-right">  <label for="rating">Rating: </label> </span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input onfocus="hidesuccess();" placeholder="50" onkeyup="" onkeypress="" id="exprating" class="form-control" maxlength="3" oninput="rating_range(this.id)">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class=" col-xs-8 col-md-3">
                                <span class="pull-right">  <label for="twitterhandle">Twitter Handle: </label> </span>
                            </div>
                            <div class=" col-xs-8 col-md-7">
                                <div class="input-group">
                                    <span class="input-group-addon">@</span><input onfocus="hidesuccess();" placeholder="Twitter Handle" onkeyup="" onkeypress="" id="twitterhandle" class="form-control" maxlength="15" oninput="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <br>

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"> <label for="photo">Profile Image: </label></span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input id="images" dir="rtl" name="images" type="file" onchange="showimagespreview(this);" accept="image/*" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <br>

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"> <label for="photo"> Bio Image: </label></span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input id="bioimage" dir="rtl" name="bioimage" type="file" onchange="showimagespreview(this);" accept="image/*" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <br>

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"> <label for="photo">Share Image: </label></span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input id="thumbnailimage" dir="rtl" name="thumbnailimage" type="file" onchange="showimagespreview(this);" accept="image/*" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <br>

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"> <label for="photo">Promo Image: </label></span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input id="promoimage" dir="rtl" name="promoimage" type="file" onchange="showimagespreview(this);" accept="image/*" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <br>

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"> <label for="photo">List View Image: </label></span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input id="listviewimage" dir="rtl" name="listviewimage" type="file" onchange="showimagespreview(this);" accept="image/*" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <br>

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"> <label for="fbshareimage">FB Share Image: </label></span>
                            </div>
                            <div class=" col-xs-8 col-md-7">
                                <input id="fbshareimage" dir="rtl" name="fbshareimage" type="file" onchange="showimagespreview(this);" accept="image/*" class="form-control">
                            </div>

                        </div>
                        <div class="row">
                            <br>

                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"> <label for="voiceover">Voice-Over: </label></span></div>
                            <div class=" col-xs-8 col-md-7">
                                <input id="expertvoiceover" dir="rtl" name="expertvoiceover" type="file" accept="audio/*" class="form-control">
                            </div>

                        </div>
                    </div>

                    <div class="col-xs-4 col-md-4">
                        <br>
                        <br>
                    </div>
                </form>

            </div>
            <br>
        </div>
        <div>
            <p>

                <button type="button" style="float: right" class="btn btn-primary" id="btneditexpert1" onclick="expertconirmation(0);">Save</button>
            </p>
        </div>
    </div>
</div>
<div class="modal audvisor-expert-preview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="previewexpert" class="row-fluid">
                <div class="container" id="previewexpertcontainer">
                    <div id="alertMsg" class="alert alert-danger"></div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Expert Preview</h3>
                        </div>
                        <div class="panel-body">
                            <form id="previewexpertForm">
                                <div style="width: 50%; float:left;overflow:hidden" class="container">
                                    <div class="row">
                                    </div>
                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"><label for="expertname">Prefix: </label></span>
                                        </div>
                                        <div class=" col-md-7"><label id="previewexpertprefix"></label></div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"><label for="expertname">First Name: </label></span>
                                        </div>
                                        <div class=" col-md-7"><label id="previewexpertname"></label></div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"> <label for="expertname">Middle Name: </label></span>
                                        </div>
                                        <div class=" col-md-7"><label id="previewmiddlename"></label></div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"> <label for="expertname">Last Name: </label></span>
                                        </div>
                                        <div class=" col-md-7"><label id="previewlastname"></label></div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"> <label for="expertname">Title: </label></span>
                                        </div>
                                        <div class=" col-md-7"><label id="previewexperttitle"></label></div>
                                        <!-- </div>  -->
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"> <label for="expertname">Promo Title: </label></span>
                                        </div>
                                        <div class=" col-md-7"><label id="previewpromotitle"></label></div>
                                        <!-- </div>  -->
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"> <label for="expertdesc">Biography: </label></span>
                                        </div>
                                        <div class=" col-md-7"><label id="previewexpertdesc"></label></div>
                                        <!-- </div>  -->
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"> <label for="expertrating">Rating: </label></span>
                                        </div>
                                        <div class=" col-md-7"><label id="previewexpertrating"></label></div>
                                        <!-- </div>  -->
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"> <label for="twitterhandle">Twitter Handle: </label></span>
                                        </div>
                                        <div class=" col-md-7">
                                            <a id="previewtwitterhandle" target="_blank"></a>
                                        </div>
                                        <!-- </div>  -->
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class=" col-md-5">
                                            <span class="pull-right"> <label for="expertdesc">Voice-Over: </label></span>
                                        </div>
                                        <div class=" col-md-7"><label id="previewexpertvoiceover"></label></div>
                                    </div>
                                </div>

                                <div style="width: 50%; float:right">

                                    <div class="row">
                                        <div class="  col-md-5">
                                            <span class="pull-right"> <label for="expertname">Preview Images: </label></span>
                                        </div>
                                        <div class=" col-md-7">
                                            <span class="pull-left"><label id="expertimagepresenet"></label> </span>
                                        </div>
                                    </div>

                                    <div class="col-lg-12" id="previewexpertimages">
                                        <output id="expertlist"></output>



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
                                    </div>
                                    <div id="avilability"></div>
                                    <!-- /form</div>-->
                                </div>
                            </form>

                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="reset" onclick="hideexpertpreviewForm();">Cancel</button>
                            <button type="reset" class="btn btn-primary" id="btneditexpert" onclick="submitexpform(0);">Confirm</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal audvisor-deleted_expert-preview-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="width:96%; margin-right:2%; margin-left: 2%">
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
                                        <span class="pull-right"> <label for="expertname">Middle Name: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="dpreviewmiddlename"></label></div>
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
                                <div class="col-xs-8 col-lg-8" id="dpreviewexpertimages">
                                    <output id="expertlist"></output>

                                            <span>
                                                <img class="thumb" height="128" width="128" id="dpimages" style="border:1px solid #0174DF"/>

                                            </span>
                                            <span>
                                                <img class="thumb" height="128" width="128" id="dpbioimage" style="border:1px solid #0174DF"/><br><br>

                                            </span>
                                            <span>
                                                <img class="thumb" height="128" width="128" id="dpthumbnailimage" style="border:1px solid #0174DF"/>

                                            </span>
                                            <span>
                                                <img class="thumb" height="90" width="128" id="dppromoimage" style="border:1px solid #0174DF"/><br><br>

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
                            <button class="btn btn-default" type="reset" onclick="re_enable_expert(0);">Re enable</button>
                            <button type="reset" class="btn btn-primary" id="btneditexpert" onclick="reg_new_expert(0);">New Expert</button>
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
                          $("#btneditexpert").dblclick(function(e)
                                                       {
                                                           e.preventDefault();
                                                           alert("Double click is disabled");
                                                       });
                      });
</script>
</body>
</html>
