<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Socketrealtime extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('auth/user_model');
        $this->load->model('auth/reset_model');
        $this->load->helper('form');
    }

    private function redirect_back()
    {
        
    }

    public function index()
    {
        if ($this->session->userdata('user_id')) $this->redirect_back();

        $temp = array();

        $allmsgs = $this->db->select('*')->from('tbl_msg')->get()->result_array();
        $temp['allMsgs'] = $allmsgs;


        $temp['template'] = 'socket_index';
        $this->load->view('null_layout.php', $temp);

    }

     public function send(){
        $arr['msg'] = $this->input->post('message');
        $arr['date'] = date('Y-m-d');
        $arr['status'] = 1;
        $this->db->insert('tbl_msg',$arr);
        $detail = $this->db->select('*')->from('tbl_msg')->where('tbl_msg_id',$this->db->insert_id())->get()->row();
        $msgCount = $this->db->select('*')->from('tbl_msg')->get()->num_rows();
        $arr['message'] = $detail->msg;
        $arr['date'] = date('m-d-Y', strtotime($detail->date));
        $arr['msgcount'] = $msgCount;
        $arr['success'] = true;
        echo json_encode($arr);
    }


}