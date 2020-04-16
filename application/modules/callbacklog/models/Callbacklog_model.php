<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callbacklog_model extends Base_model
{

    protected $table = 'callback_logs';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function getLog($key){
        $this->db->select('*')
                 ->from($this->table)
                 ->like('content',$key);
        $result = $this->db->get()->result();

        if (!$result) return 0;
        return $result[0];
    }
}