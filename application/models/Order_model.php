<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Order_model
*/
class Order_model extends Base_model
{
    protected $table = 'tbl_order';
    function __construct(){
        parent::__construct();
    }
    function check_exists_order($uid, $order_ebay){
        $this->db->where('uid', $uid);
        $this->db->where('order_ebay', $order_ebay);
        $res = $this->db->get($this->table, 1)->result();
        if(!$res) return 0;
        return $res[0];
    }

	function get_template_email_order_id($order_id,$template_id){
		
		$this->db->where('id', $order_id);
        $this->db->where('tbl_order');
        $res_1 = $this->db->get('tbl_order')->result_array();
		$this->db->where('status', 1);
		$this->db->where('id', $template_id);
		$res_2 = $this->db->get('template_email')->result_array();
		if(!$res_1 && !$res_2) return 0;
		return array_merge($res_1,$res_2);
		
	}
	function find_all_by($field, $val, $select_fields=array()){
        $this->db->order_by('created_on', 'desc');
        return parent::find_all_by($field, $val, $select_fields);
    }

    function condToQuery($tag_id){
        $table_news = 'news';
        $this->db->select($table_news.'.*');
        $this->db->from($table_news);
		$relationship = 'tag_news';
        $this->db->join($relationship . ' as t1', 't1.news_id=' . $table_news . '.id');
        $this->db->where('t1.tag_id', $tag_id);
    }
	function find_news($tag_id, $page=1, $per_page=21){
        $offset = ($page-1)*$per_page;
        $this->condToQuery($tag_id);
        $this->db->limit($per_page, $offset);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if($query->num_rows() != 0){
            return $query->result();
        }
        return false;
    }
    function total_news($cond=array()){
        $this->condToQuery($cond);
        $query = $this->db->get();
        return $query->num_rows();
    }
}