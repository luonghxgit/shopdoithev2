<?php

class Report_model extends Base_model
{

    protected $table = 'cards';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function getSumCardByType($userid, $type,$fromdate,$todate)
    {
        $this->db->select('receivevalue, cardtype, count(*) as total')
//         ->where('cardtype', $type)
            ->where('user_id',$userid)
            ->where('modified_on >= ',$fromdate)
            ->where('modified_on <= ',$todate)
            ->where('status',1)
            ->group_by('cardtype')
            ->group_by('receivevalue');
        $res = $this->db->get($this->table)->result();
        if (!$res) return 0;
        return $res;
    }
}