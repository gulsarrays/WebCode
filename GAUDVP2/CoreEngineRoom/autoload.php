<?php

/*
  Project                     : Oriole
  Module                      :
  File name                   : autoload.php
  Description                 : Autoloads the necessary classes.
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

spl_autoload_register(null, false);

function class_autoloader($inClass)
{
    $sClass = str_replace('_', '/', $inClass);

    $sCtrClass   = dirname(__FILE__).'/src/controller/'.$sClass.'.php';
    $sDBClass    = dirname(__FILE__).'/src/dbmanager/'.$sClass.'.php';
    $sModelClass = dirname(__FILE__).'/src/model/'.$sClass.'.php';
    $utilClass   = dirname(__FILE__).'/src/utils/'.$sClass.'.php';

    if(file_exists($sCtrClass) && include_once($sCtrClass))
    {
        return TRUE;
    }
    elseif(file_exists($sDBClass) && include_once($sDBClass))
    {
        return TRUE;
    }
    elseif(file_exists($sModelClass) && include_once($sModelClass))
    {
        return TRUE;
    }
    elseif(file_exists($utilClass) && include_once($utilClass))
    {
        return TRUE;
    }
    else
    {
        trigger_error("The class '$inClass'  failed to spl_autoload  ", E_USER_WARNING);
        return FALSE;
    }
}

spl_autoload_register('class_autoloader');

