<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREPromoCodeList.php
  Description                 : To Add/Delete/Update promocode details for cms
  Copyright                   : Copyright © 2015, Audvisor Inc.
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

    <title>Promo Codes</title>
    <?php
    include 'src/views/header.php';
    ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

</head>
<body>
<?php include('src/views/navbar.php') ?>
<div class="container" style="margin-top:1%">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 id="statistics" class="panel-title">Promo Codes</h3>
        </div>

        <div class="panel-body" style="width:100%;overflow: auto">
            <div class="table-responsive">

                <?php
                if (!isset($Data[JSON_TAG_COUNT]))
                {
                    echo 'No Promocode';
                }
                else {
                if (isset($Data[JSON_TAG_COUNT]) && $Data[JSON_TAG_COUNT] == 0)
                {
                    echo 'No Promocode';
                }
                else
                {
                ?>
                <table id="promocodetable" class="table table table-hover table-bordered" style="overflow: auto">
                    <thead>
                    <tr class="table-striped">
                        <th style="text-align: center">Promo code Id</th>
                        <th style="text-align: center">Promo code</th>

                        <th style="text-align: center">Start Date</th>
                        <th style="text-align: center">End Date</th>
                        <th style="text-align: center">Sign up #</th>
                        <th width="10%"></th>
                        <th width="6%"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    foreach ($Data[JSON_TAG_PROMO_CODES] as $aList)
                    {
                    ?>

                    <tr class="table-striped">

                        <td style="text-align: center"> <?php echo $aList[JSON_TAG_PROMOCODE_ID]; ?> </td>
                        <td style="text-align: left" id=""> <?php echo $aList[JSON_TAG_PROMO_CODE]; ?> </td>
                        <td style="text-align: center"> <?php
                            $startdate = explode(" ", $aList[JSON_TAG_START_DATE]);
                            echo $startdate[0]; ?> </td>
                        <td style="text-align: center"> <?php

                            $enddate = explode(" ", $aList[JSON_TAG_END_DATE]);
                            echo $enddate[0]; ?> </td>
                        <td style="text-align: center"> <?php echo $aList[JSON_TAG_COUNT]; ?> </td>

                        <td style="text-align: center">
                            <button onclick="onPromocodeDeleteBtnClick('<?php echo $aList[JSON_TAG_PROMOCODE_ID]; ?>')" id="btnDelete" class="btn-danger"> Delete</button>
                        </td>

                        <td style="text-align: center">
                            <button onclick="onpromocodeEditBtnClick('<?php echo $aList[JSON_TAG_PROMOCODE_ID]; ?>','<?php echo str_replace("'", "\'", $aList[JSON_TAG_PROMO_CODE]); ?>','<?php echo $aList[JSON_TAG_START_DATE]; ?>','<?php echo $aList[JSON_TAG_END_DATE]; ?>');" id="btnEdit" data-toggle="modal" data-target=".audvisor-promocode-edit-modal" class="btn-info"> Edit</button>
                        </td>

                        <?php } ?>
                    </tr>
                    <?php
                    }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php ?>

<div class="modal audvisor-promocode-edit-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="newpromocodeEdit" style="margin-top:2%;    ">
                <div class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div id="successMsg" class="alert alert-success"></div>
                    <div id="alertMsg" style="margin-top:1%; display: none" class="alert alert-danger"></div>

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Promo Code</h3>
                        </div>
                        <div class="panel-body" id="promoaddaddpanelbody">

                            <form id="newpromocodeAddForm">

                                <div class="col-xs-10 col-md-9">
                                    <div class="row">
                                        <div class="col-xs-4 col-md-4">
                                            <span class="pull-right"><label for="promocode">Promo Code: </label></span>
                                        </div>
                                        <div class="col-xs-8 col-md-8">
                                            <input onclick="hidesuccess();" placeholder="15 Character Promo Code" id="promocode" type="text" maxlength="15" class="form-control" required size="30" onkeypress="return letternumber(event);" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-xs-4 col-md-4">
                                            <span class="pull-right"><label for="promocode">Start Date: </label></span>
                                        </div>
                                        <div class="col-xs-6 col-xs-9">
                                            <input onclick="hidesuccess();" id="startdate" type="text" maxlength="15" class="form-control" required size="30">
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-xs-4 col-md-4">
                                            <span class="pull-right"><label for="promocode">End Date: </label></span>
                                        </div>

                                        <div class="col-xs-6 col-md-6">
                                            <input onclick="hidesuccess();" id="enddate" type="text" maxlength="15" class="form-control" required>
                                        </div>
                                    </div>

                                    <div id="avilability"><input type="hidden" id="promocodeid"></div>
                                </div>
                                <div class="col-xs-2 col-md-2">
                                </div>

                            </form>
                        </div>
                    </div>

                    <div style="margin-top:1%">
                        <p style="float: right">
                            <button class="btn btn-default" type="button" onclick="hidepromoeditForm()">Cancel</button>
                            <button type="reset" class="btn btn-primary" id="btnUpdatepromocode" onclick="promocodeconfirmation()">Update</button>
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


<!-- Promocode preview modal -->

<div class="modal audvisor-promocode-preview-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="newpromocodeAdd">

                <div class="container" id="promocodeaddcontainer" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Promo Code Preview </h3>
                        </div>
                        <div class="panel-body" id="promocodeaddpanelbody">

                            <form id="newpromocodeAddForm1">


                                <div class="row">

                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"><label for="promocode">Promo Code: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-lg-8"><label id="previewpromocode"></label></div>
                                </div>
                                <div class="row">

                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"><label for="promocode">Start Date: </label> </span>
                                    </div>
                                    <div class="col-xs-8 col-lg-8"><label id="previewstartdate"></label></div>
                                </div>

                                <div class="row">

                                    <div class="col-xs-8 col-md-4">
                                        <span class="pull-right"><label for="promocode">End Date: </label> </span></div>
                                    <div class="col-xs-8 col-lg-8"><label id="previewenddate"></label></div>
                                </div>


                                <div class="col-xs-8 col-md-4">
                                </div>
                                <div class="col-xs-8 col-lg-8">
                                    <output id="list"></output>
                                </div>
                                <div id="avilability"></div>

                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="button" onclick="hidepromopreviewform()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddpromocode" onclick="editpromocode()">Confirm</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $("#startdate").datepicker({dateFormat: 'yy-mm-dd'});
    $("#enddate").datepicker({dateFormat: 'yy-mm-dd'});
    $(document).ready(function()
                      {
                          $('#promocodetable').DataTable({
                                                             "dom": 'Rlfrtip',
                                                             responsive: true,
                                                             "order": [[0, 'desc']],
                                                             "aoColumnDefs": [
                                                                 {'bSortable': false, 'aTargets': [5, 6]},
                                                                 {"bSearchable": false, "aTargets": [5, 6]}
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
