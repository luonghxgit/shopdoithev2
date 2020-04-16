<?php

class Gate_model extends Base_model
{

    protected $table = 'gates';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function checkGate($api, $gateName, $money)
    {
        $this->db->select('*')
            ->from($this->table)
            ->where('gate', $gateName)
            ->where('api', $api)
            ->like('money', $money);
        $rs = $this->db->get()->result();
        if (isset($rs[0])) return $rs[0];
        return 0;
    }

}