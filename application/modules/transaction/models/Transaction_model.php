<?php

class Transaction_model extends Base_model
{

    protected $table = 'transactions';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function insert($data)
    {
        $data['created_on'] = date('Y-m-d H:i:s');
        $res = $this->db->insert($this->table, $data);
        $this->logE($this->db->last_query());
        if (!$res) return 0;
        return $this->db->insert_id();
    }

    public function getTransactionByUser($userid, $key = null, $page = 1, $numrow = 15)
    {
        $this->db->where('user_id', $userid);
        if ($key) $this->db->like('note', $key);

        $this->db->limit($numrow, $numrow * ($page - 1));
        $this->db->order_by('id', 'desc');
        $res = $this->db->get($this->table)->result();
        if (!$res) return 0;
        return $res;
    }


    public function getTransByDateUser($userId, $date)
    {
        $this->db->where('user_id', $userId);
        $this->db->like('created_on', $date);
        $this->db->order_by('id', 'desc');
        $res = $this->db->get($this->table)->result();
        if (!$res) return 0;
        return $res;
    }

    public function checkDuplicate($code)
    {
        $this->db->like('note', $code);

        $this->db->order_by('id', 'desc');
        $res = $this->db->get($this->table)->result();
        if (!$res[0]) return 0;
        return $res[0];
    }
}