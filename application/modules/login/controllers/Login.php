<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Login extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('auth/user_model');
        $this->load->model('auth/reset_model');
    }

    private function redirect_back()
    {
        $current_url = $this->input->get('back', true);
        if ($current_url) {
            redirect(urldecode($current_url));
        } else {
           $user_data = $this->session->userdata('user_data');
           if($user_data['role']==1){
               redirect('/card/all');
           }
            redirect('/card');
        }
    }

    public function index()
    {
        if ($this->session->userdata('user_id')) $this->redirect_back();

        $temp = array();
        if ($_POST) {
            $temp['message'] = $this->checkLogin();
        }
        $temp['template'] = 'login_view';
        $this->load->view('null_layout.php', $temp);

    }

    public function logout(){
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_data');
        $back = $this->input->get('back', true);
        if($back){
            redirect(urldecode($back));
        }else{
            redirect(site_url('login'));
        }

    }

    private function checkLogin()
    {
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        if (!$username || !$password) {
            return $this->message('Enter username and password please');
        }

        $user_data = $this->user_model->checkUsername($username);

        if (!$user_data) {
            return $this->message('Sai tên đăng nhập hoặc mật khẩu');
        }
        if ($user_data->password !== md5($password)) {
            return $this->message('Sai tên đăng nhập hoặc mật khẩu');
        }
        if (!$user_data->status) {
            return $this->message('Tài khoản của bạn hiện đang bị khóa');
        }
        $this->session->set_userdata('user_id', $user_data->id);
        $this->session->set_userdata('user_data', (array)$user_data);
        //	print_r($this->session->userdata('user_id'));die;
        $this->redirect_back();
        return $this->message('Login is successful');
    }


}