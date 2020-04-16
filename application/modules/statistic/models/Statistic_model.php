<?php

class Statistic_model extends Base_model
{

    protected $table = 'daily_reports';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function chk($user, $date)
    {
        $this->db->select('id')
            ->where('user_id', $user)
            ->where('date', $date);
        $res = $this->db->count_all_results($this->table);
        return $res;
    }


}