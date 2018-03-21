<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREVersionList.php
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

    <title>Version Informations</title>
    <?php
    include 'src/views/header.php';
    ?>
</head>
<body>
<?php include('src/views/navbar.php') ?>
<div id="versioncontainer" class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 id="statistics" class="panel-title">Version Info </h3>
        </div>

        <div class="panel-body">
            <div class="table-responsive">
                <?php
                if ($Data[JSON_TAG_COUNT] == 0)
                {
                    echo 'No Versions Available';
                }
                else
                {
                ?>
                <table id="versiontable" class="table table table-hover table-bordered">


                    <thead>
                    <tr class="table-striped">
                        <th> Id</th>
                        <th>Platform</th>
                        <th> Version</th>
                        <th>Application URL</th>
                        <th>Bundle Version</th>
                        <th>Mandatory Update</th>
                        <th>Description</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($Data[JSON_TAG_VERSION] as $aList)
                    {
                    ?>

                    <tr class="table-striped">

                        <td> <?php echo $aList[JSON_TAG_ID]; ?> </td>
                        <td> <?php  if($aList[JSON_TAG_PLATFORM] == 2)
                            {
                                echo "Android";
                            }
                            else
                            {
                                if($aList[JSON_TAG_PLATFORM] == 3)
                                {
                                    echo "Server Api";
                                }
                                else
                                {
                                    echo "IOS";
                                }
                            }

                            ?> </td>

                        <td> <?php echo $aList[JSON_TAG_APP_VERSION]; ?> </td>
                        <td> <?php echo $aList[JSON_TAG_APP_STORE_URL]; ?> </td>
                        <td> <?php echo $aList[JSON_TAG_BUNDLE_VERSION]; ?> </td>
                        <td> <?php
                            if($aList[JSON_TAG_MANDATORY_UPDATE])
                            {
                                echo "YES";
                            }
                            else
                            {
                                echo "NO";
                            }
                            ?> </td>
                        <td style="text-align: left;"> <?php echo $aList[JSON_TAG_VERSION_DESC]; ?></td>
                        <td>
                            <button onclick="onVersionDeleteBtnClick('<?php echo $aList[JSON_TAG_ID]; ?>')" id="btnDelete" class="btn-danger"> Delete</button>
                        </td>

                        <td>
                            <button onclick="onVersionEditBtnClick('<?php echo $aList[JSON_TAG_ID]; ?>','<?php echo str_replace("'", "\'", $aList[JSON_TAG_APP_VERSION]); ?>','<?php echo str_replace("'", "\'", $aList[JSON_TAG_APP_STORE_URL]); ?>','<?php echo urlencode($aList[JSON_TAG_VERSION_DESC]); ?>','<?php echo $aList[JSON_TAG_MANDATORY_UPDATE]; ?>','<?php echo $aList[JSON_TAG_BUNDLE_VERSION]; ?>','<?php echo $aList[JSON_TAG_PLATFORM]; ?>')" id="btnEdit" data-toggle="modal" data-target=".audvisor-version-edit-modal" class="btn-info"> Edit</button>
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

<div class="modal audvisor-version-edit-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="editversion">
                <div id="editversioncontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div id="successMsg" class="alert alert-success"></div>
                    <div id="alertMsg" class="alert alert-danger"></div>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Version</h3>
                        </div>
                        <div class="panel-body">

                            <form id="regform">

                                <div class="row">

                                    <div class=" col-md-4">
                                        <span class="pull-right">  <label for="genericversion">Version: </label></span>
                                    </div>
                                    <div class=" col-md-7">
                                        <input onclick="hidesuccess();" onkeyup="hidesuccess();" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" maxlength="10" id="genericversion" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                    </div>
                                </div>
                                <br>

                                <div class="row">

                                    <div class="  col-md-4">
                                        <span class="pull-right">  <label for="applicationurl">Application URL: </label> </span>
                                    </div>
                                    <div class=" col-md-7">
                                        <input onfocus="hidesuccess();" onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" maxlength="100" size="30" id="applicationurl" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="  col-md-4">
                                        <span class="pull-right">  <label for="versiondescription">Description: </label> </span>
                                    </div>
                                    <div class="  col-md-7">
                                        <textarea onfocus="hidesuccess();" onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" maxlength="1000" id="versiondescription" type="text" rows="5" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)"> </textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <br>

                                    <div class=" col-md-4">
                                        <span class="pull-right"> <label for="bundledversion">Bundle Version: </label></span>
                                    </div>
                                    <div class="  col-md-7">
                                        <input onfocus="hidesuccess();" onkeyup="no_nonnumbers()" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="bundledversion" type="text" class="form-control" maxlength="10" oninput="no_nonnumbers(this.id)">
                                    </div>

                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="pull-right"> <label for="bundledversion">Platform: </label></span>
                                    </div>
                                    <div class=" col-md-7">
                                        <select id="platform" class="selectpicker" onchange=" hidesuccess();">
                                            <option value="-1"> Select</option>
                                            <option value="1"> IOS</option>
                                            <option value="2">Android</option>
                                            <option value="3">Server</option>
                                        </select>
                                    </div>
                                </div>
                                <br>

                                <div class="row">
                                    <div class="col-md-4">
                                        <span class="pull-right"> <label for="bundledversion">Mandatory Update: </label></span>
                                    </div>
                                    <div class=" col-md-7">
                                        <select id="update" class="selectpicker" onchange=" hidesuccess();">
                                            <option value="-1"> Select</option>
                                            <option value="0"> NO</option>
                                            <option value="1">YES</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="versionid" id="versionid" value="">
                            </form>

                        </div>
                        <br>
                    </div>
                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="reset" onclick="hideversioneditForm()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btneditexpert" onclick="versionconirmation()">Update</button>
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


<!-- Version preview modal -->
<div class="modal audvisor-version-preview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div id="previewversion">
                <div id="previewversioncontainer" class="container" style="width:96%; margin-right:2%; margin-left: 2%">

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
                                        <textarea style="width:100%;" rows="5" maxlength="1000" id="previewversiondescription" readonly></textarea>
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
                                        <span class="pull-right"> <label for="previewupdate">Platform: </label></span>
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
                            <button type="reset" class="btn btn-primary" id="btneditexpert" onclick="updateversion()">Confirm</button>
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

                          $('#versiontable').DataTable({
                                                           "dom": 'Rlfrtip',
                                                           responsive: true,
                                                           "order": [[0, 'desc']],
                                                           "aoColumnDefs": [
                                                               {'bSortable': false, 'aTargets': [7, 8]},
                                                               {"bSearchable": false, "aTargets": [7, 8]}

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
