<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREPlayListView.php
  Description                 : To Add/Delete/Update PlayLists details for cms
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

    <title>PlayLists Insights</title>
    <?php
    include 'src/views/header.php';
    ?>
</head>
<body>
<?php include('src/views/navbar.php') ?>
<div class="container" style="margin-top:1%">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 id="statistics" class="panel-title">PlayLists Insights</h3>
        </div>

        <div class="panel-body" style="width:100%;overflow: auto">
            <div class="table-responsive">
                <table id="playlisttable" class="table table table-hover table-bordered" style="overflow: auto">

                    <thead>
                    <tr class="table-striped">
                        <th style="text-align: center"> Insight Id</th>
                        <th style="text-align: center"> Insight Name</th>
                        <th style="text-align: center"> Sort Order</th>
                        <th width="10%"></th>
                        <th width="20%"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    if(isset($Data['insights']) && !empty($Data['insights'])) {
                        
                    
                    foreach ($Data['insights'] as $aList)
                    {   
                        if(!is_array($aList)) {
                            continue;
                        }
                    ?>

                    <tr class="table-striped">

                        <td style="text-align: center"> <?php echo $aList['insight_id']; ?> </td>
                        <td style="text-align: left" id="<?php echo $aList['insight_id']; ?>"> <?php echo $aList['insight_name']; ?> </td>
                        <td style="text-align: center"> <?php echo $aList['list_order']; ?> </td>
                        <td style="text-align: center">
                            <button onclick="onPlayListInsightDeleteBtnClick('<?php echo $playListId; ?>', '<?php echo $aList['insight_id']; ?>')" id="btnDelete" class="btn-danger"> Delete</button>
                        </td>
                        

                        <td style="text-align: center">
                            <button onclick="onPlayListInsightEditBtnClick('<?php echo $playListId; ?>', '<?php echo $aList['insight_id']; ?>','<?php echo $aList['insight_name'];?>','<?php echo $aList['list_order']; ?>');" id="btnEdit" data-toggle="modal" data-target=".audvisor-playlist-insight-edit-modal" class="btn-info"> Edit Sort Order</button>
                        </td>

                        <?php } ?>
                    </tr>
                    <?php
                    } else {
                     ?>
                    <tr><td colspan="5"> No Insights!!!</td></tr>
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

<div class="modal audvisor-playlist-insight-edit-modal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <div id="newplaylistinsightEdit" style="margin-top:2%; display: none">
                <div class="container" style="width:96%; margin-right:2%; margin-left: 2%">
                    <div id="alertMsg1" style="margin-top:1%; display: none" class="alert alert-danger"></div>

                    <form id="newplaylistinsightEditForm">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">Edit Insight List Order</h3>
                            </div>
                            <div class="panel-body" style="width:100%; margin-left: 0%;overflow: auto;">
                                <div class="col-xs-8 col-md-7">
                                    <div class="row">
                                        <input type="hidden" name="playlistid" id="playlistid" value="">
                                        <input type="hidden" name="playlistinsightid" id="playlistinsightid" value="">

                                        <div class="col-xs-8 col-md-3">
                                            <span class="pull-right"><label for="eplaylistinsightname">Insight: </label></span>
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <label id="eplaylistinsightname"></label>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <div class="col-xs-8 col-md-7">
                                    <div class="row">
                                        

                                        <div class="col-xs-8 col-md-3">
                                            <span class="pull-right"><label for="eplaylistinsightlistorder">ListOrder: </label></span>
                                        </div>
                                        <div class="col-xs-8 col-md-9">
                                            <input onkeyup="disAllowCopyPasteForSpecialCharacters(this.id)" onkeypress="disAllowCopyPasteForSpecialCharacters(this.id)" id="eplaylistinsightlistorder" type="text" class="form-control" oninput="disAllowCopyPasteForSpecialCharacters(this.id)">
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <div class="col-xs-4 col-md-5">


                                </div>
                                <br>

                            </div>
                        </div>
                    </form>

                    <div style="margin-top:1%">
                        <p style="float: right">
                            <button class="btn btn-default" type="reset" onclick="hidePlayListInsightupdateForm()">Cancel</button>
                            <button type="reset" class="btn btn-primary" id="btnUpdateplaylistinsight" onclick="playlistinsighteditconirmation()">Update</button>
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- playlist insight preview modal -->
<div class="modal audvisor-playlist-insight-preview-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">


            <div id="newplaylistinsightAdd" style="margin-top:2%; width:100%;">

                <div class="container" style="width:96%; margin-right:2%; margin-left: 2%">

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">PlayList Insight Preview </h3>
                        </div>
                        <div class="panel-body" style="width:100%; margin-left: 10%;overflow: auto;">

                            <form id="newplaylistinsightAddForm">


                                <div class="row">

                                    <div class="col-xs-8 col-md-3">
                                        <span class="pull-right"> <label for="playlistinsightName">Insight Name: </label></span></div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewplaylistinsightname"></label></div>
                                </div>
                                <div class="row">

                                    <div class="col-xs-8 col-md-3">
                                        <span class="pull-right"> <label for="playlistinsightlistorder">List Order: </label></span></div>
                                    <div class="col-xs-8 col-lg-3"><label id="previewplaylistinsightlistorder"></label></div>
                                </div>

                            </form>
                        </div>
                    </div>

                    <div style="margin-top:1%">
                        <p style="float:right">
                            <button class="btn btn-default" type="button" onclick="hideplaylistinsightpreviewform()">Cancel</button>
                            <button type="button" class="btn btn-primary" id="btnAddplaylist" onclick="UpdatePlayListInsightListOrder()">Confirm</button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
                    if(isset($Data['insights']) && !empty($Data['insights'])) {
                        ?>
<script>
    $(document).ready(function()
    {
//        getPlayListstat();
        $('#playlisttable').DataTable({
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
<?php
                    }
                    ?>
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
