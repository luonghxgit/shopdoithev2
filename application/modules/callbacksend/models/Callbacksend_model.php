<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Callbacksend_model extends Base_model
{

    protected $table = 'callback_sends';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function getCallbackFalse(){
        $this->db->select('*')
                 ->where('http_code',0)
                 ->where('url!=','')
            ->where('created_on >= ','2020-04-13');
        $res = $this->db->get($this->table)->result();
        if (!isset($res[0])) return null;
        return $res[0];
    }
}