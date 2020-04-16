<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * log_model
*/
class Log_model extends Base_model
{
    protected $table = 'log';
    function __construct(){
        parent::__construct();
    }
    public function viewed(){
        $this->db->select('count(id) as viewed, date_format(created_on, \'%Y-%m-%d\') AS date_viewed');
        $this->db->group_by('date_viewed');
        $this->db->where('action', 'viewed');
        $this->db->where('object_type', '1');
        $res = $this->db->get($this->table)->result();
        if(!$res) return 0;
        return $res;
    }
    public function viewed_news(){
        $table_news = 'news';
        $this->db->select($table_news.'.*,count(t1.id) as viewed');
        $this->db->join($this->table . ' AS t1', 't1.object_id='.$table_news.'.id');
        $this->db->group_by('t1.object_id');
        $this->db->where('t1.action', 'viewed');
        $this->db->where('t1.object_type', '1');
        $this->db->order_by('viewed', 'desc');
        $res = $this->db->get($table_news, 10)->result();
        if(!$res) return 0;
        return $res;
    }
}