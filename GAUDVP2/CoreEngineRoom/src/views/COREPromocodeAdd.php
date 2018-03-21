<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREPromocodeAdd.php
  Description                 : To Add/Delete/Update Topics details for cms
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

    <title>Add Promo Code</title>


    <?php
    include 'src/views/header.php';
    ?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


</head>

<body>
<?php include('src/views/navbar.php') ?>

<div id="newpromoAdd">

    <div class="container">
        <div id="successMsg" class="alert alert-success"></div>
        <div id="alertMsg" class="alert alert-danger"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">New Promo Code</h3>
            </div>
            <div class="panel-body" id="promoaddaddpanelbody">

                <form id="newpromocodeAddForm">

                    <div class="col-xs-8 col-md-8">
                        <div class="row">
                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"><label for="promocode">Promo Code: </label></span></div>
                            <div class="col-xs-8 col-md-4">
                                <input onclick="hidesuccess();" placeholder="15 Character Promo Code" id="promocode" type="text" maxlength="15" class="form-control" required size="20" onkeypress="return letternumber(event);" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"><label for="promocode">Start Date: </label></span></div>
                            <div class="col-xs-8 col-xs-3">
                                <input onclick="hidesuccess();" id="startdate" type="text" maxlength="15" class="form-control" required size="30">
                            </div>
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-xs-8 col-md-3">
                                <span class="pull-right"><label for="promocode">End Date: </label></span></div>
                            <div class="col-xs-8 col-md-3">
                                <input onclick="hidesuccess();" id="enddate" type="text" maxlength="15" class="form-control" required>
                            </div>
                        </div>

                        <div id="avilability"></div>
                    </div>
                    <div class="col-xs-4 col-md-4">
                    </div>

                </form>
            </div>
        </div>

        <div id="promocodeaddnavpills">
            <p>

                <button type="button" style="float: right;" class="btn btn-primary" id="btnAddpromocode" onclick="promocodeconfirmation()">Save</button>
            </p>
        </div>

    </div>
</div>


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
                                <div class="col-xs-8 col-lg-8" id="previewtopicimages">
                                    <output id="list"></output>
                                </div>
                                <div id="avilability"></div>

                            </form>
                        </div>
                    </div>

                    <div>
                        <p style="float: right">
                            <button class="btn btn-default" type="button" onclick="hidepromopreviewform()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddpromocode" onclick="addpromocode()">Confirm</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
    $(function()
      {
          $("#startdate").datepicker({dateFormat: 'yy-mm-dd'});
          $("#enddate").datepicker({dateFormat: 'yy-mm-dd'});
          $("#enddate").datepicker("setDate", new Date());
          $("#startdate").datepicker("setDate", new Date());
      });

    $(document).ready(function()
                      {
                          var today = new Date();
                          var dd = today.getDate();
                          var mm = today.getMonth() + 1; //January is 0!

                          var yyyy = today.getFullYear();
                          if(dd < 10)
                          {
                              dd = '0' + dd
                          }
                          if(mm < 10)
                          {
                              mm = '0' + mm
                          }
                          var today = yyyy + '-' + mm + '-' + dd;
                          document.getElementById("startdate").value = today;
                          document.getElementById("enddate").value = today;
                          $('#promocode').value = "";
                          $("#btnAddpromocode").dblclick(function(e)
                                                         {
                                                             e.preventDefault();
                                                             alert("Double click is disabled");
                                                         });
                      });
</script>

</body>


</html>
