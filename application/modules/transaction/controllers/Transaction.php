<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Transaction extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth/User_model');
        $this->load->model('card/Card_model');
        $this->load->model('transaction/Transaction_model');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $key = $this->input->get('key', true);
        $key = ($key) ? $key : null;

        $temp = array();
        $page = (int)$this->input->get('page', true);
        $page = ($page > 0) ? $page : 1;
        $numrow = 30;
        $temp['key'] = $key;
        $temp['allCards'] = $this->Transaction_model->getTransactionByUser($user_id, trim($key), $page, $numrow);
        $temp['total'] = $totalRows = $this->Transaction_model->total(array('user_id' => $user_id));
        $numPage = round($totalRows / $numrow);
        $temp['numPage'] = $numPage;
        $temp['page'] = $page;
        $temp['template'] = 'transaction/index_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function trutien($user_id)
    {
        die;
        $userInfo = $this->User_model->find_by('id', $user_id);

        $afterChange = $userInfo->balance - 345000;
        $this->User_model->update($user_id, array('balance' => $afterChange));

        if (isset($userInfo->id)) {
            $beforeChange = $userInfo->balance;
            $afterChange = $userInfo->balance - 500000;
            $arr = array(
                'user_id' => $user_id,
                'money_down' => 690000,
                'money' => 690000,
                'before_change' => $beforeChange,
                'after_change' => $afterChange,
                'status' => 1,
                'note' => 'Thu hồi '.number_format(690000).'đ do cộng sai giao dịch thẻ: 10006161230582'
            );
          //  print_r($arr);
          $tranId = $this->Transaction_model->insert($arr);
            if ($tranId) {

           }
        }
    }
}