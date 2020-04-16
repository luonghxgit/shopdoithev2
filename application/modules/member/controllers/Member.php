<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Member extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('auth/user_model');
        $this->load->model('card/Card_model');
        $this->load->model('transaction/Transaction_model');
        $this->load->model('cardtype/Cardtype_model');
    }

    function index()
    {
        $user_data = $this->session->userdata('user_data');
        $userInfo = $this->user_model->find_by('id', $user_data['id']);

        if ($this->input->post('id', true)) {
            $info = $this->input->post();
            $arr = array(
                'name' => $info['name'],
                'phone' => $info['phone'],
                'address' => $info['address'],
                'email' => $info['email']
            );
            $this->user_model->update($info['id'], $arr);
            $temp['mess'] = 'Cập nhật dữ liệu thành công';
        }

        $temp['info'] = $userInfo;
        $temp['template'] = 'member/detail_index_view';
        $this->load->view('admin/layout.php', $temp);
    }

    function api()
    {
        $user_data = $this->session->userdata('user_data');
        $info = $this->user_model->get($user_data['id']);

        $temp['info'] = $info;
        $temp['template'] = 'member/api_view';
        $this->load->view('admin/layout.php', $temp);
    }

    function all()
    {
        $k = $this->input->get('k', true);
        $k = ($k) ? $k : null;
        if (!$k) {
            $info = $this->user_model->findAllMember();
        } else {
            $info = $this->user_model->like_by(array('username', 'email', 'phone'), $k);
        }
        $temp['k'] = $k;
        $temp['users'] = $info;
        $temp['total_users'] = $this->user_model->total(null);
        $temp['total_balance'] = $this->user_model->sumMoneyAllUser('balance');
        $temp['total_waitbank'] = $this->user_model->sumMoneyAllUser('waitbank');

        $temp['template'] = 'member/all_user_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function changepassword()
    {
        $user_data = $this->session->userdata('user_data');
        $userInfo = $this->user_model->find_by('id', $user_data['id']);

        if ($this->input->post('id', true)) {
            $info = $this->input->post();

            $arr = array(
                'password' => md5($info['password']),
            );
            $this->user_model->update($info['id'], $arr);
            $temp['mess'] = 'Cập nhật dữ liệu thành công';
        }

        $temp['info'] = $userInfo;
        $temp['template'] = 'member/changepassword_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function detail($userid = null)
    {
        $key = $this->input->get('key');
        $key = ($key) ? $key : null;

        $userInfo = $this->user_model->find_by('id', $userid);
        $page = (int)$this->input->get('page', true);
        $page = ($page > 0) ? $page : 1;
        $numrow = 30;


        $temp['key'] = trim($key);
        $temp['info'] = $userInfo;
        $temp['user_id'] = $userid;
        $temp['allTrans'] = $this->Transaction_model->getTransactionByUser($userid, trim($key), $page, $numrow);
        $temp['total'] = $totalRows = $this->Transaction_model->total(array('user_id' => $userid));
        $numPage = round($totalRows / $numrow);
        $temp['numPage'] = $numPage;
        $temp['page'] = $page;
        $temp['template'] = 'member/history_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function discount($user_id = null)
    {
        $user = $this->user_model->find_by('id', $user_id);
        $cardTypePrivate = $this->Cardtype_model->get_private_by_user($user_id);
        $cardType = $this->Cardtype_model->find_all();
        $temp['user'] = $user;
        $temp['cardType'] = $cardType;
        $temp['cardTypePrivate'] = $cardTypePrivate;
        $temp['template'] = 'set_discount_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function ajax_savediscount()
    {
        $input = $this->input->post(null,true);
        print_r($input);
        die;
    }
}