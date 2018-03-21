<!--/*
  Project                     : Oriole
  Module                      : General
  File name                   : sidebar.php
  Description                 : To display sidebar menu for dash board
  Copyright                   : Copyright © 2015, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */-->


<div class="side-menu">

    <nav class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <div class="brand-wrapper">
                <!-- Hamburger -->
                <button type="button" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>

        </div>

        <!-- Main Menu -->
        <div class="side-menu-container" style="padding-left: 15px">
            <ul class="nav navbar-nav">

                <li>
                    <a href="<?php echo CMS_BASE_URL_STRING."dashboard" ?>">Dash Board</a>
                </li>
                <li>
                    <a href="<?php echo CMS_BASE_URL_STRING."consumers" ?>">Consumers</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

</div>













