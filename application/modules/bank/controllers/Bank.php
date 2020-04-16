<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Bank extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth/User_model');
        $this->load->model('card/Card_model');
        $this->load->model('bank/Bank_model');

    }
	
	public function index(){
         $user_id = $this->session->userdata('user_id');
        if($this->input->post('bankname')){
            $info = $this->input->post();
            $arr = array(
                'bankname' => $info['bankname'],    
                'chinhanh' => $info['chinhanh'],
                'name' => $info['name'],
                'bank_number' => $info['bank_number'],
                'user_id' => $user_id
            );
           
            $this->Bank_model->add($arr);
            redirect(base_url('bank'));
        }
        
         $temp['listBanks'] = $this->Bank_model->find_all_by('user_id',$user_id);   
        $temp['template'] = 'bank/index_view';
        $this->load->view('admin/layout.php', $temp);
	}
    
     public function ajxGetBank(){
        $bankid = $this->input->get('id',true);
        $bankinfo = $this->Bank_model->find_by('id',$bankid);
        echo json_encode($bankinfo);die;
    }
	
}?>