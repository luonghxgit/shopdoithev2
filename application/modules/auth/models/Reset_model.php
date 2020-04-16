<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_model extends Base_model {

    protected $table = 'password_resets';
    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    function update($id, $data){
        return $this->db->update($this->table, $data, array('id' => $id));
    }

}