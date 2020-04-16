<?php

class Setting_model extends Base_model
{

    protected $table = 'settings';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
}