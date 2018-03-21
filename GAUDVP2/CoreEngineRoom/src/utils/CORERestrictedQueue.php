<?php

/*
  Project                     : Oriole
  Module                      : General
  File name                   : CORERestrictedQueue.php
  Description                 : Swapping insights
  Copyright                   : Copyright © 2014, Audvisor Inc.
  Written under contract by Robosoft Technologies Pvt. Ltd.
  History                     :
 */

class CORERestrictedQueue
{
    public $items = array();
    public $length;

    /**
     * Function to initialize length         
     */
    function __construct($maxLength)
    {
        $this->length = $maxLength;
    }

    /**
     * Function to insert elements into an array         
     */
    function enqueue($item)
    {
        array_push($this->items, $item);

        if(count($this->items) > $this->length)
        {
            unset($this->items[0]);
            $this->items = array_merge($this->items);
        }
    }

    /**
     * Function to check if items are present in an array        
     */
    function hasItem($itemToFind)
    {
        $found = false;
        foreach($this->items as $item)
        {
            if($itemToFind['expert_id'] == $item['expert_id'])
            {
                $found = true;
                break;
            }
        }

        return $found;
    }
}
