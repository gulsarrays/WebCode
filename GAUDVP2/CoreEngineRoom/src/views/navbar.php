<!--/*
  Project                     : Oriole
  Module                      : General
  File name                   : navbar.php
  Description                 : To Add/Delete/Update Topics details for cms
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */-->

<nav class="navbar navbar-default" role="navigation">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo CMS_BASE_URL_STRING."dashboard" ?>"><?php echo ($_SESSION['company_name'])?"    ".$_SESSION['company_name']."          ":"Audvisor";  ?></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Insights <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING.'addinsight' ?>">Add an Insight</a>
                        </li>
<!--                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING.'listinsights' ?>">View the Insights</a>
                        </li>-->
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING.'listinsights_new' ?>">View the Insights </a>
                        </li>


                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Experts <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING."addexpert" ?>">Add an Expert</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING."listexperts" ?>">View the Experts</a>
                        </li>


                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Topics <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING."addtopic" ?>">Add a Topic</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING."listtopics" ?>">View the Topics</a>
                        </li>


                    </ul>
                </li>
<!--                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Groups <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING.'addgroup' ?>">Add Group</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING.'listgroups' ?>">View Groups</a>
                        </li>


                    </ul>
                </li>
                -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage PlayLists <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING.'addplaylist' ?>">Add PlayList</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING.'listplaylist' ?>">View PlayList</a>
                        </li>


                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Versions <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING."addversion" ?>">Add a Version</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING."listversions" ?>">View the Versions</a>
                        </li>


                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Manage Promo Code <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING."addpromocode" ?>">Add Promo Code</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING."listpromocodes" ?>">View Promo Code</a>
                        </li>


                    </ul>
                </li>
                <?php
                if(ENVIRONMENT !== "Production")
                {
                    ?>
                    <li>
                        <a href="<?php echo CMS_BASE_URL_STRING."getuseractions" ?>">View User Actions</a>
                    </li>
                <?php } ?>
                <li>
                    <a href="<?php echo CMS_BASE_URL_STRING."pushnotification" ?>">Push Notification</a>
                </li>
                <li class="dropdown" style="float:right; right:0 px;">

                    <a href="#" class="dropdown-toggle navbar-right" data-toggle="dropdown" style="right: 0px;">Admin
                        <span class="glyphicon glyphicon-cog"></span><b class="caret"></b></a>

                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"></a>
                        </li>
                        <li>
                            <a href="<?php echo CMS_BASE_URL_STRING."dashboard" ?>">Dashboard</a>
                        </li>
                        <li class="divider"></li>
                        <li style="right: 0px;">
                            <a href="<?php echo CMS_BASE_URL_STRING."settings" ?>">Settings</a>
                        </li>

                        <li class="divider"></li>
                        <li style="right: 0px;">
                            <a href="<?php echo CMS_BASE_URL_STRING."viewpasswordreset" ?>">Change Password</a>
                        </li>
                        <li class="divider"></li>
                        <li style="right: 0px;">
                            <a href="<?php echo CMS_BASE_URL_STRING."logout" ?>">Sign Out</a>
                        </li>
                    </ul>


                </li>


        </div>
    </div>
</nav>




