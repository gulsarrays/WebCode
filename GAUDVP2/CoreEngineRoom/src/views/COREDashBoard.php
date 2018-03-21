<?php
/*
  Project                     : Oriole
  Module                      : General
  File name                   : COREDashBoard.php
  Description                 : To View the dashBoard of cms
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

    <title>Admin Dashboard</title>


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
<!-- uncomment code for absolute positioning tweek see top comment in css -->
<!-- <div class="absolute-wrapper"> </div> -->
<!-- Menu -->
<?php include('src/views/sidebar.php') ?>

<!-- Main Content -->
<div class="container-fluid">
<div class="side-body">
<div class="container-fluid">
<div class="row-fluid">

<div class="span12" id="content">
<div class="row-fluid" style="margin-top: -20px">
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Statistics</div>
            <div class="pull-right">
            </div>
        </div>
        <div class="block-content collapse in">
            <div class="span3">
                <div class="chart" data-percent="<?php if($count[JSON_TAG_INSIGHT_COUNT])
                {
                    echo floor($count[JSON_TAG_LIVE_INSIGHT_COUNT] / $count[JSON_TAG_INSIGHT_COUNT] * 100);
                }
                else
                {
                    echo "0";
                } ?>"><?php if($count[JSON_TAG_INSIGHT_COUNT])
                    {
                        echo floor($count[JSON_TAG_LIVE_INSIGHT_COUNT] / $count[JSON_TAG_INSIGHT_COUNT] * 100);
                    }
                    else
                    {
                        echo '0';
                    } ?>%
                </div>
                <div class="chart-bottom-heading"><span class="label label-info">Insights Online</span>

                </div>
            </div>
            <div class="span3">
                <div class="chart" data-percent="<?php if($count[JSON_TAG_TOPIC_COUNT])
                {
                    echo floor($count[JSON_TAG_LIVE_TOPIC_COUNT] / $count[JSON_TAG_TOPIC_COUNT] * 100);
                }
                else
                {
                    echo "0";
                } ?>"><?php if($count[JSON_TAG_TOPIC_COUNT])
                    {
                        echo floor($count[JSON_TAG_LIVE_TOPIC_COUNT] / $count[JSON_TAG_TOPIC_COUNT] * 100);
                    }
                    else
                    {
                        echo '0';
                    } ?> %
                </div>
                <div class="chart-bottom-heading"><span class="label label-info">Topics have insights online</span>
                </div>
            </div>
            <div class="span3">
                <div class="chart" data-percent="<?php if($count[JSON_TAG_EXPERT_COUNT])
                {
                    echo floor($count[JSON_TAG_LIVE_EXPERT_COUNT] / $count[JSON_TAG_EXPERT_COUNT] * 100);
                } ?>"> <?php if($count[JSON_TAG_EXPERT_COUNT])
                    {
                        echo floor($count[JSON_TAG_LIVE_EXPERT_COUNT] / $count[JSON_TAG_EXPERT_COUNT] * 100);
                    }
                    else
                    {
                        echo '0';
                    } ?>%
                </div>
                <div class="chart-bottom-heading"><span class="label label-info">Experts have insights online</span>
                </div>
            </div>
            <div class="span3">
                <div class="chart" data-percent="<?php if($count[JSON_TAG_USER_COUNT] - $count[JSON_TAG_USER_COUNT_DEVICE])
                {
                    echo floor($count[JSON_TAG_USER_COUNT_DEVICE] / ($count[JSON_TAG_USER_COUNT] - $count[JSON_TAG_USER_COUNT_DEVICE]) * 100);
                } ?>"><?php if($count[JSON_TAG_USER_COUNT] - $count[JSON_TAG_USER_COUNT_DEVICE])
                    {
                        echo floor($count[JSON_TAG_USER_COUNT_DEVICE] / ($count[JSON_TAG_USER_COUNT] - $count[JSON_TAG_USER_COUNT_DEVICE]) * 100);
                    }
                    else
                    {
                        echo '0';
                    } ?> %
                </div>
                <div class="chart-bottom-heading"><span class="label label-info">% of User Sign up</span>

                </div>
            </div>
        </div>
    </div>

</div>
<div class="row-fluid">
    <div class="span6">

        <div class="block">
            <div id="insightheader" class="navbar navbar-inner block-header">
                <div id="mli" class="muted pull-left">Most Listened Insights</div>
                <div id="mlic" class="pull-right">
                    <span class="badge badge-info"><?php echo $count[JSON_TAG_INSIGHT_COUNT] ?> Total</span>

                </div>
            </div>
            <div class="block-content collapse in">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">Insight Id</th>
                        <th>Insight Title</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    if(empty($insights))
                    {
                        echo 'No Insights';
                    }
                    else
                    {
                        $i = 1;
                        foreach($insights as $insight)
                        {
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $insight[JSON_TAG_INSIGHT_ID]; ?></td>
                                <td><?php echo $insight[JSON_TAG_INSIGHT_NAME]; ?></td>
                                <!--<td>@mdo</td>-->
                            </tr>
                        <?php
                        }
                    } ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="span6">
        <!-- block -->
        <div class="block">
            <div id="expertheader" class="navbar navbar-inner block-header" style="text-align: center">
                <div id="mle" class="muted pull-left">Most Listened Experts</div>
                <div id="mlec" class="pull-right">
                    <span class="badge badge-info"><?php echo $count[JSON_TAG_EXPERT_COUNT]; ?> Total</span>

                </div>
            </div>
            <div class="block-content collapse in">
                <table class="table table-striped">


                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">Expert Id</th>
                        <th>Expert Name</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(empty($experts))
                    {
                        echo 'No Experts';
                    }
                    else
                    {
                        $i = 1;
                        foreach($experts as $expert)
                        {
                            if($i == 11)
                            {
                                break;
                            }
                            ?>
                            <tr>
                                <td><?php echo $i++ ?></td>
                                <td><?php echo $expert[JSON_TAG_EXPERT_ID]; ?></td>
                                <td><?php echo $expert[JSON_TAG_EXPERT_NAME]; ?></td>

                            </tr>

                        <?php
                        }
                    } ?>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<div class="row-fluid">
    <div class="span6">

        <div class="block">
            <div id="topicheader" class="navbar navbar-inner block-header">
                <div id="mlt" class="muted pull-left">Most Listened Topics</div>
                <div id="mltc" class="pull-right">
                    <span class="badge badge-info"><?php echo $count[JSON_TAG_TOPIC_COUNT]; ?> Total</span>

                </div>
            </div>
            <div class="block-content collapse in" id="toptable">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th width="20%">Topic Id</th>
                        <th>Topic Name</th>
                    </tr>
                    </thead>
                    <?php
                    if (empty($topics))
                    {
                        echo 'No Topics';
                    }
                    else{
                    $i = 1;
                    foreach ($topics as $newtopic){
                    ?>

                    <tbody>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $newtopic[JSON_TAG_TOPIC_ID]; ?></td>
                        <td><?php echo $newtopic[JSON_TAG_TOPIC_NAME]; ?></td>

                    </tr>
                    <?php
                    }
                    } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="block">
            <div id="topinsightheader" class="navbar navbar-inner block-header">
                <br>

                <div class="muted pull-left">Top Rated Insights</div>
                <div class="pull-right">
                    <select id="topiclist" onchange="filterinsights();">
                        <option>All</option>
                        <?php
if(!empty($topics)) {
                        foreach($topic as $i => $t)
                        {
                            ?>
                            <option><?php echo $t ?></option>

                        <?php }} ?>
                    </select><span class="badge badge-info"></span>

                </div>
            </div>
            <div class="block-content collapse in" style="overflow: auto;height:460px" id="topdiv">


                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th width="20%">Insight Id</th>
                        <th>Insight Name</th>
                    </tr>
                    </thead>
                    <tbody id="topinsight" style="overflow: auto">
                    <?php
                    if(empty($top_insights))
                    {
                        echo 'NO Insights';
                    }
                    else
                    {

                        $i = 1;
                        foreach($top_insights as $insight)
                        {
                            if($i == 111)
                            {
                                break;
                            }
                            ?>
                            <tr>

                                <td><?php echo $insight[JSON_TAG_INSIGHT_ID]; ?></td>
                                <td style="text-align: left"><?php echo $insight[JSON_TAG_INSIGHT_NAME]; ?></td>
                                <?php
                                foreach($insight[JSON_TAG_TOPICS] as $itopic)
                                {
                                    ?>
                                    <td class="topic" style="visibility:hidden;display: none"><?php echo($itopic) ?> </td>

                                <?php } ?>

                            </tr>
                        <?php
                        }
                    } ?>

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
</div>
</div>


<script src="<?php echo S3_STATIC_URL ?>easypiechart/dist/jquery.easy-pie-chart.js"></script>

<script>
    $(function()
      {
          // Easy pie charts
          $('.chart').easyPieChart({
                                       animate: 1000,
                                       barColor: '#148ca6',
                                       scaleColor: false,
                                       lineCap: "square",
                                       lineWidth: 15
                                   });
      });
    $(document).ready(function()
                      {
                          var height = $('#toptable').height();
                          $('#topdiv').height(height);

                          var height = $('#topinsightheader').height();
                          $('#topicheader').height(height);
                          $('#insightheader').height(height);
                          $('#expertheader').height(height);

                      });
    $("#topdiv").change(function()
                        {
                            var s = $("#toptable").height();
                            $(this).height(s);
                        });
</script>
</body>

</html>