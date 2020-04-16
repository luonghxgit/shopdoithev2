<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * remember_token
*/
class Token_model extends Base_model
{
    protected $table = 'remember_token';
    function __construct(){
        parent::__construct();
    }
}