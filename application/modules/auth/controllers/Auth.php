<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Front_Controller {
    function __construct()
    {
        parent::__construct();
        $this->load->model('auth/user_model');
        $this->load->model('auth/reset_model');
        $this->load->model('auth/ebay_model');
    }
    private function redirect_back(){
        $current_url = $this->input->get('back', true);
        if($current_url){
            redirect( urldecode($current_url) );
        }else{
            redirect('/course/my');
        }
    }

    public function login(){
        if($this->session->userdata('user_id')) $this->redirect_back();

        $data = array();
        if($_POST){
            $data['message'] = $this->checkLogin();
        }
        $data['page_title'] = 'Login';
        $data['template'] = 'auth/login';
        $this->load->view('site_layout',$data);
    }

    private function checkLogin(){
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        if(!$username || !$password){
            return $this->message('Enter username and password please');
        }
        //check captcha
        /*$captchaResponse = trim($this->input->post('g-recaptcha-response'));
        $checkCaptcha = $this->captcha_http_post($captchaResponse);
        if(!$checkCaptcha || !isset($checkCaptcha->success) || $checkCaptcha->success != 1){
            return $this->message('Bạn chưa nhập đúng Captcha, vui lòng thử lại !');
        }*/

        $user_data = $this->user_model->checkUsername($username);

        if(!$user_data){
            return $this->message('Sai tên đăng nhập hoặc mật khẩu');
        }
        if($user_data->password!==md5($password)){
            return $this->message('Sai tên đăng nhập hoặc mật khẩu');
        }
        if( !$user_data->status ){
            return $this->message('Tài khoản của bạn hiện đang bị khóa');
        }
        $this->session->set_userdata('user_id', $user_data->id);
        $this->session->set_userdata('user_data', (array)$user_data);
	//	print_r($this->session->userdata('user_id'));die;
		$this->redirect_back();
        return $this->message('Login is successful');
    }
    private function captcha_http_post($captchaResponse) {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $secret='6LeCai0UAAAAAFzUVrA1xn3283SccqFQpOk2TsuK';
        $post_params = "secret=".$secret."&response=".$captchaResponse;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if(!empty($post_params)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_params);
        }
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result);
    }

    function setting(){
        if(!$this->session->userdata('user_id')) redirect('login');
        $temp = array();
        $message = $this->session->userdata('message');
        if($message){
            $this->session->unset_userdata('message');
            $temp['message'] = $message;

        }
        if($_POST){
            $message = $this->save_setting();
            $temp['message'] = $message;
        }
        $uid = $this->session->userdata('user_id');
        $temp['user'] = $this->user_model->get($uid);

        $temp['page_title'] = 'Account setting';
        $temp['template'] = 'sys';
        $this->load->view('admin/layout',$temp);
    }
    private function save_setting(){
        $uid = $this->session->userdata('user_id');
        if(!$uid) redirect('login');
        $type = isset($_POST['type']) ? stripslashes($_POST['type']) : '';
        if($type==='info'){
            return $this->save_setting_info($uid);
        }elseif($type==='account'){
            return $this->save_setting_account($uid);
        }else{
            return $this->message('Input is not valid');
        }
    }
    private function save_setting_info($uid){
        $email = isset($_POST['email']) ? stripslashes($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? stripslashes($_POST['phone']) : '';
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->message('Email is not valid');
        }
        $check_email_exists = $this->user_model->find_by('email', $email);
        if($check_email_exists && $check_email_exists->id!=$uid){
            return $this->message('Email is used');
        }
        if($phone && !preg_match( '/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i', $phone )){
            return $this->message('Phone is not valid');
        }
        $request = $_POST;
        unset($request['type']);
        $data = array();
        if($request){
            foreach($request as $field=>$val){
                $data[$field] = stripslashes($val);
            }
            $token_name = $this->security->get_csrf_token_name();
            if(isset($data[$token_name])){
                unset($data[$token_name]);
            }
            $res = $this->user_model->update($uid, $data);
            $user_data = $this->user_model->get($uid);
            $this->session->set_userdata('user_data', (array)$user_data);
            if(!$res) return $this->message('Have error. Please try again.');
            return $this->message('Saved is successful.', true);
        }else{
            return $this->message('Error. Please try again.');
        }
    }

    private function save_setting_account($uid){
        $password = isset($_POST['password']) ? stripslashes($_POST['password']) : '';
        $re_password = isset($_POST['re_password']) ? stripslashes($_POST['re_password']) : '';
        $data = array();
        if($password){
            if($re_password!=$password){
                return $this->message('Retype password is incorrect');
            }
            $data['password'] = md5($password);
        }
        if($data){
            $res = $this->user_model->update($uid, $data);
            $user_data = $this->user_model->get($uid);
            $this->session->set_userdata('user_data', (array)$user_data);
            if(!$res) return $this->message('Have error. Please try again.');
        }
        return $this->message('Save success.', true);
    }

    public function logout(){
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_data');
        $back = $this->input->get('back', true);
        if($back){
            redirect(urldecode($back));
        }else{
            redirect(site_url('/login'));
        }

    }
    public function reset_password(){
        $data = array();
        if($_POST){
            $data['message'] = $this->reset_password_action();
        }else{
            $token = $this->input->get('token', true);
            if(!$token) die('Link is expired.');
            $user_data = $this->user_model->find_by('reset_token', $token);
            if(!$user_data) die('Link is expired.');
        }
        $data['page_title'] = 'Reset password';
        $data['template'] = 'auth/reset_password';
        $this->load->view('auth/layout',$data);
    }
    private function reset_password_action(){
        $token = $this->input->get('token', true);
        $password = $this->input->post('password', true);
        $re_password = $this->input->post('re_password', true);

        if(!$token) die('Link is expired.');
        $user_data = $this->user_model->find_by('reset_token', $token);
        if(!$user_data) die('Link is expired.');

        if(!$password) return $this->message('Enter your new password');
        if($re_password!=$password){
            return $this->message('Retype password is incorrect');
        }
        $data = array();
        $data['password'] = md5($password);
        $data['reset_token'] = '';
        $res = $this->user_model->update($user_data->id, $data);
        if(!$res) return $this->message('Have error. Please try again.');
        return $this->message('Password is changed.', true);
    }

    public function activate(){
        $data = array();
        $token = $this->input->get('token', true);
        if(!$token) die('Link is expired.');
        $user_data = $this->user_model->find_by('reset_token', $token);
        if(!$user_data) die('Link is expired.');

        $res = $this->user_model->update($user_data->id, array('status'=>1, 'reset_token'=>''));
        if(!$res){
            $data['message'] = $this->message('Account is not activated. Please contact admin.', true);
        }else{
            $data['message'] = $this->message('Account is activated', true);
        }

        $data['page_title'] = 'Activate account';
        $data['template'] = 'auth/activate';
        $this->load->view('auth/layout',$data);
    }

    public function signup(){
        $data = array();
        if($_POST){
            $message = $this->save_user();
            $data['message'] = $message;
        }
        $data['page_title'] = 'Đăng ký thành viên';
        $data['template'] = 'auth/signup_view';
        $this->load->view('site_layout.php', $data);

    }

    private function save_user(){

        $email = $this->input->post('email', true);
        $phone = $this->input->post('phone', true);
        $username = $this->input->post('username', true);
        $password = $this->input->post('password', true);
        $re_password = $this->input->post('re_password', true);

        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->message('Email is not valid');
        }
        $check_email_exists = $this->user_model->find_by('email', $email);
        if($check_email_exists){
            return $this->message('Email is used');
        }
        if($phone && !preg_match( '/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i', $phone )){
            return $this->message('Phone number is not valid');
        }
        $request = $this->input->post(null, true);
        $data = array();
        //check role
        $user_data = $this->session->userdata('user_data');
        if($user_data['role']==3){
            $data = array(
                'name' => $this->input->post('name', true),
                'email' => $this->input->post('email', true),
                'phone' => $this->input->post('phone', true),
                'store' => $this->input->post('store', true),
                'country' => $this->input->post('country', true),

            );
        }else{
            if($request){
                foreach($request as $field=>$val){
                    if($val=='') continue;
                    $data[$field] = $this->input->post($field, true);
                }
            }
        }

        $token_name = $this->security->get_csrf_token_name();
        if(isset($data[$token_name])){
            unset($data[$token_name]);
        }


            if($username){
                $username_special = url_friendly($username, '_');
                if($username_special!==$username) return $this->message('Username can not have special characters');
                $check_username = $this->user_model->find_by('username', $username);
                if($check_username) return $this->message('Username is used');
                if(!$password) return $this->message('Enter password please');
                if(!$re_password || $password!==$re_password) return $this->message('Retype password is incorrect');
                $data = $this->pre_save($data);
            }

            if(isset($data['msg'])) return $data;
            $res = $this->user_model->add($data);
            if(!$res) return $this->message('Error. Please try again');
            redirect(base_url());
          //  return $this->message('Added is successfull.', true);

    }
    private function pre_save($data){
        if(isset($data['password'])){
            $data['password'] = md5($data['password']);
        }
        if(isset($data['re_password'])){
            unset($data['re_password']);
        }
        if(isset($data['id']) && !$data['id']){
            unset($data['id']);
        }
        return $data;
    }
}
