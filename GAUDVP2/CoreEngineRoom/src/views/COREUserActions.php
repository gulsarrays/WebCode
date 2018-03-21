<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREUserActions.php
  Description                 : To List al user actions in cms
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

    <title>User Actions</title>
    <?php
    include 'src/views/header.php';
    ?>
</head>
<body>
<?php include('src/views/navbar.php') ?>
<div id="useractionscontainer" class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 id="statistics" class="panel-title">User Actions</h3>
        </div>

        <div class="panel-body">
            <div class="table-responsive">

                <table id="actionstable" class="table table table-hover table-bordered">


                    <thead>
                    <tr class="table-striped">
                        <th> id</th>
                        <th> Consumer Id</th>
                        <th>Receiver Id</th>
                        <th>Action Id</th>
                        <th>Action Data</th>
                        <th>Receiver Name</th>


                    </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php ?>

<script>
    $(document).ready(function()
                      {

        var table = $('#actionstable').DataTable({

                 "processing": true,
                 "serverSide": true,
                 "ajax": '<?php echo BASE_URL_STRING . "src/utils/COREUseractions_ServerProcessing.php?client_id=".$_SESSION[CLIENT_ID]; ?>',
                 "columns": [
                     {"data": "fldid"},
                     {"data": "fldconsumerid"},
                     {"data": "fldreceiverid"},
                     {"data": "fldactionid"},
                     {"data": "fldactiondata"},
                     {"data": "fldname"}
                 ],
                 "aoColumnDefs": [
                     {"bSearchable": false, "aTargets": [5]}
                 ],
                 "dom": 'Rlfrtip',
                 responsive: true,
                "order": [[0, 'desc']],
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


<script>
    /*
     $(document).ready(function() {

     $('#actionstable').DataTable( {
     "dom": 'Rlfrtip',
     responsive: true,
     "order": [[0, 'desc']],
     "aoColumnDefs": [

     ],
     "aLengthMenu": [
     [10, 20, 50, 100, -1],
     [10, 20, 50, 100, "All"]
     ],
     "iDisplayLength" : 20 ,
     stateSave:true,
     "sDom": 'TRr<"inline"l> <"inline"f><>t<"inline"p><"inline"i>'
     } );
     });*/
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
