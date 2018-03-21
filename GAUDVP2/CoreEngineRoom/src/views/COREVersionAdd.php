<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREVersionAdd.php
  Description                 : To Add new Version details for cms
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

    <title>Add Version</title>


    <?php
    include 'src/views/header.php';
    ?>

</head>

<body onload="hideAlert()">
<?php include('src/views/navbar.php') ?>
<div id="addversion">
    <div class="container">
        <div id="successMsg" class="alert alert-success">Version Added Successfully</div>
        <div id="alertMsg" class="alert alert-danger"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">New Version</h3>
            </div>
            <div class="panel-body">

                <form id="regform">

                    <div class="row">

                        <div class="col-xs-8 col-md-3">
                            <span class="pull-right">  <label for="genericversion">Version: </label></span></div>
                        <div class=" col-xs-8 col-md-4">
                            <input onclick="hidesuccess();" placeholder="Version" onkeyup="hidesuccess();" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" maxlength="10" id="genericversion" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                        </div>
                    </div>
                    <br>

                    <div class="row">

                        <div class=" col-xs-8 col-md-3">
                            <span class="pull-right">  <label for="applicationurl">Application URL: </label> </span>
                        </div>
                        <div class=" col-xs-8 col-md-4">
                            <input onfocus="hidesuccess();" placeholder="Application URL" onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" maxlength="100" size="30" id="applicationurl" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class=" col-xs-8 col-md-3">
                            <span class="pull-right">  <label for="versiondescription">Description: </label> </span>
                        </div>
                        <div class=" col-xs-8 col-md-4">
                            <textarea onfocus="hidesuccess();" placeholder="Description" onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" maxlength="1000" id="versiondescription" rows="5" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)"> </textarea>
                        </div>
                    </div>
                    <div class="row">
                        <br>

                        <div class="col-xs-8 col-md-3">
                            <span class="pull-right"> <label for="bundledversion">Bundle Version: </label></span></div>
                        <div class=" col-xs-8 col-md-4">
                            <input onfocus="hidesuccess();" placeholder="Bundle Version" onkeyup="no_nonnumbers()" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="bundledversion" type="text" class="form-control" maxlength="10" oninput="no_nonnumbers(this.id)">
                        </div>

                    </div>
                    <br>

                    <div class="row">
                        <div class="col-xs-8 col-md-3">
                            <span class="pull-right"> <label for="bundledversion">Platform: </label></span></div>
                        <div class=" col-xs-8 col-md-4">
                            <select id="platform" class="selectpicker" onchange=" hidesuccess();">
                                <option value="-1"> Select</option>
                                <option value="1">IOS</option>
                                <option value="2">Android</option>
                                <option value="3">Server</option>
                            </select>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="col-xs-8 col-md-3">
                            <span class="pull-right"> <label for="bundledversion">Mandatory Update: </label></span>
                        </div>
                        <div class=" col-xs-8 col-md-4">
                            <select id="update" class="selectpicker" onchange=" hidesuccess();">
                                <option value="-1"> Select</option>
                                <option value="0"> NO</option>
                                <option value="1">YES</option>
                            </select>
                        </div>
                    </div>

                </form>

            </div>
            <br>
        </div>
        <div>
            <p>

                <button type="button" style="float: right" class="btn btn-primary" id="btnaddversion1" onclick="versionconirmation()">Save</button>
            </p>
        </div>
    </div>
</div>

<div class="modal audvisor-version-preview-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div id="previewversion">
                <div class="container" id="previewversioncontainer" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Version Preview</h3>
                        </div>
                        <div class="panel-body">
                            <form id="previewversionForm">
                                <!-- <div style="width: 85%; float:left">-->
                                <div class="row">
                                </div>
                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"><label for="previewgenericversion">Version: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewgenericversion"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="previewapplicationurl">Application URL: </label></span>
                                    </div>
                                    <div class=" col-md-7"><label id="previewapplicationurl"></label></div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="previewversiondescription">Description: </label></span>
                                    </div>
                                    <div class=" col-md-7">
                                        <textarea style="width:100%;" id="previewversiondescription" maxlength="1000" rows="5" readonly></textarea>
                                    </div>
                                    <!-- </div>  -->
                                </div>
                                <br>
                                <!--   <div style="width: 15%; float:right">-->
                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="previewbundledversion">Bundle Version: </label></span>
                                    </div>

                                    <div class=" col-md-7"><label id="previewbundledversion"></label></div>
                                </div>
                                <!-- /form</div>-->
                                <br>

                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="previewplatform">Platform: </label></span>
                                    </div>

                                    <div class=" col-md-7"><label id="previewplatform"></label></div>
                                </div>
                                <br>


                                <div class="row">
                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="previewupdate">Mandatory Update: </label></span>
                                    </div>

                                    <div class=" col-md-7"><label id="previewupdate"></label></div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="reset" onclick="hideversiontpreviewForm()">Cancel</button>
                            <button type="reset" class="btn btn-primary" id="btnaddversion" onclick="submitversion()">Confirm</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
