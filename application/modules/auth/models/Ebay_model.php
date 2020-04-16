<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ebay_model extends Base_model {

    protected $table = 'ebay_connection';
    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
    function get_cond($cond){
        if(isset($cond['s']) && $cond['s']){
            $this->db->group_start();
            $this->db->or_like('username', $cond['s']);
            $this->db->or_like('ebay_username', $cond['s']);
            $this->db->group_end();
            unset($cond['s']);
        }
        return $cond;
    }
    function find($cond, $page, $per_page, $order=array(), $select_fields=array()){
        $cond = $this->get_cond($cond);
        return parent::find($cond, $page, $per_page, $order, $select_fields);
    }
    function total($cond){
        $cond = $this->get_cond($cond);
        return parent::total($cond);
    }
}