<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banking_model extends Base_model
{

    protected $table = 'bankings';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function chkBanking()
    {

    }

    public function info($bankingId)
    {
        $this->db->select('B.*,U.username as username')
            ->from($this->table . ' B')
            ->join('user U', 'U.id = B.user_id', 'inner');
       $this->db->where('B.id',$bankingId);
        $re = $this->db->get()->result();
        if(isset($re[0])) return $re[0];
        return 0;
    }

    public function getAllBanking($status = 100)
    {
        $this->db->select('B.*,U.username as username')
            ->from($this->table . ' B')
            ->join('user U', 'U.id = B.user_id', 'inner');
        if ($status != 100) {
            $this->db->where('B.status', $status);
        }
        $this->db->order_by('B.id','desc');
        return $this->db->get()->result();

    }

    public function getBankingWait(){
        $this->db->select('*')
                ->where('status',0);
        $res = $this->db->count_all_results($this->table);
        return $res;

    }

}