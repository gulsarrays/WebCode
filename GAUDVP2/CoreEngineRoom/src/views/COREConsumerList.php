<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREConsumerList.php
  Description                 : To View the list ofusers
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

    <title>Users</title>


    <?php
    include 'src/views/header.php';
    ?>
    <link href="<?php echo S3_STATIC_URL ?>easypiechart/dist/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo S3_STATIC_URL ?>easypiechart/dist/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
    <link href="<?php echo BASE_URL_STRING ?>src/views/css/styles.css" rel="stylesheet" media="screen">

</head>

<body style="padding: 0px">
<?php include('src/views/navbar.php') ?>

<div class="row">


    <?php include('src/views/sidebar.php') ?>


    <!-- Main Content -->
    <div class="container-fluid">
        <div class="side-body">
            <div class="span12" id="content">

                <div class="panel panel-primary" style="display: table">
                    <div class="panelheading" style="background-color:#337ab7;color: #ffffff;">
                        <h3 id="statistics" class="panel-title">&nbsp&nbsp;Consumers</h3>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="usertable" class="table table table-hover table-bordered">


                                <thead>
                                <tr class="table-striped" style="border-left: 0">
                                    <th> Id</th>
                                    <th> Email Id</th>
                                    <th>IOS Device#</th>
                                    <th>Android Device #</th>
                                    <th>Insight Play #</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
</div>


</div>

<hr>


<script>
    $(document).ready(function()
                      {

                          var table = $('#usertable').DataTable({

                                                                    "processing": true,
                                                                    "serverSide": true,
                                                                    "ajax": '<?php echo BASE_URL_STRING."src/utils/COREConsumer_ServerProcessing.php?client_id=".$_SESSION[CLIENT_ID];?>',
                                                                    "columns": [
                                                                        {"data": "fldid"},
                                                                        {"data": "fldemailid"},
                                                                        {"data": "ios_count"},
                                                                        {"data": "android_count"},
                                                                        {"data": "play_count"}

                                                                    ],
                                                                    "oLanguage": {
                                                                        "sInfoFiltered": ""
                                                                    },
                                                                    "aoColumnDefs": [
                                                                        {"bSearchable": false, "aTargets": [2, 3, 4]},
                                                                        {
                                                                            'bSortable': false,
                                                                            'aTargets': [2, 3]
                                                                        }
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