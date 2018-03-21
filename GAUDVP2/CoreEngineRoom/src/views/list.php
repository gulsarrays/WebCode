<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREConsumerList.php
  Description                 : To View the dashBoard of cms
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

    <title> Admin Dashboard</title>


    <?php
    include 'src/views/header.php';
    ?>
    <link href="<?php echo S3_STATIC_URL ?>easypiechart/dist/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="<?php echo S3_STATIC_URL ?>easypiechart/dist/jquery.easy-pie-chart.css" rel="stylesheet" media="screen">
    <link href="<?php echo BASE_URL_STRING ?>src/views/css/styles.css" rel="stylesheet" media="screen">

</head>

<body style="padding: 0px">
<?php include('src/views/navbar.php') ?>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span1" id="sidebar" style="width: 10%;padding-top: -15px;margin-top: -15px">
            <li class="dropdown" style="float:right; right:0 px;">

                <ul class="nav">
                    <li>
                        <a href="<?php echo CMS_BASE_URL_STRING."dashboard" ?>">Dash Board</a>
                    </li>
                    <li>
                        <a href="<?php echo CMS_BASE_URL_STRING."consumers" ?>">Users</a>
                    </li>
                    <!-- <li><a href="#" data-toggle="collapse" data-target="#sub1">Link 4 (submenu)</a>
                     <ul class="nav collapse" id="sub1">
                        <li><a href="#">Sub Link 1</a></li>
                        <li><a href="#">Sub Link 2</a></li>
                        <li><a href="#">Sub Link 3</a></li>
                      </ul>
                    </li>
                    <li><a href="#">Link 5</a></li>-->
                </ul>


        </div>
        <div class="span9" id="content">
            <div id="usercontainer" class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 id="statistics" class="panel-title">Consumers</h3>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">

                            <table id="usertable" class="table table table-hover table-bordered">


                                <thead>
                                <tr class="table-striped">
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
<hr>


<script>
    $(document).ready(function()
                      {

                          var table = $('#usertable').DataTable({

                                                                    "processing": true,
                                                                    "serverSide": true,
                                                                    "ajax": '<?php echo BASE_URL_STRING."src/utils/COREConsumer_ServerProcessing.php"?>',
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