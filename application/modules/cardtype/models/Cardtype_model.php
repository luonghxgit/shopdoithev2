<?php

class Cardtype_model extends Base_model
{

    protected $table = 'cardtypes';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function get_private_rate($user,$money,$cardtype)
    {
        $this->db->select('*')
            ->from('cardtype_private_rates')
            ->like('allow_money',$money)
            ->where('type_code',$cardtype)
            ->where('user_id', $user);
        $res = $this->db->get()->result();
        if (!isset($res[0])) return null;
        return $res;
    }

    public function checkGate($cardtype,$money,$gate){
        $this->db->select('*')
            ->from($this->table)
            ->like('allow_money',','.$money.',')
            ->where('code',$cardtype)
            ->where('gate',$gate)
            ->where('status',1);
        $res = $this->db->get()->result();
        if (!isset($res[0])) return null;
        return $res[0];
    }

}