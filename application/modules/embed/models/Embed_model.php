<?php

class Embed_model extends Base_model
{

    protected $table = 'embeds';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function getEmbedInfo($code){
        $this->db->select('E.*, U.key as merchantKey')
                 ->where('E.code',$code)
                 ->join('user U','U.id = E.user_id','inner');
        $result = $this->db->get($this->table.' E')->result();
        $this->logE($this->db->last_query());
        if (!$result) return 0;
        return $result[0];
    }
}