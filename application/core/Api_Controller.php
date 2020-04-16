<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_Controller extends CI_Controller{
    protected $per_page = 20;
    protected $request;
    public function __construct(){
        parent::__construct();
        header('Access-Control-Allow-Headers: *');
        header('Access-Control-Allow-Origin: *');
        //$request_body = file_get_contents('php://input');
        //$this->request = json_decode($request_body, true);
        $this->request = $_REQUEST;
    }
    protected function message($msg, $status=false){
        return array(
            'success' => $status,
            'msg' => $msg
        );
    }
    protected function renderJSON($data, $status=true, $msg='', $meta=array()){
        $result = array(
            'success' => $status,
            'data' => $data,
            'message' => $msg
        );
        if(!empty($meta)){
            foreach($meta as $key=>$val){
                if(isset($result[$key])==false){
                    $result[$key] = $val;
                }
            }
        }
        echo json_encode($result);exit();
    }
    protected function renderXML(){

    }
    public function logE($msg){
        logE($msg);
    }
    /**
     * generate token DC version
     * @auth: thontrancong@admicro.vn
     */
    protected function generate_token(){
        return md5( 'PR-idea' . time() . 'Barry Allen' );
    }
    protected function check_auth(){
        if($this->session->userdata('user_id')){
            return true;
        }
        $token = isset($this->request['token']) ? stripslashes($this->request['token']) : '';
        $uid = isset($this->request['uid']) ? stripslashes($this->request['uid']) : '';

        $this->load->model('token_model');
        $check_token = $this->token_model->find_by('token', $token);
        if( !$check_token ){
            //$this->token_model->delete_by('uid', $uid);
            $this->renderJSON(array(), false, 'Login to access this content, please', array('logout'=>true));
        }
        if(!$uid){
            $this->request['uid'] = $check_token->uid;
        }
        if( ! isset($this->user_model) ){
            $this->load->model('auth/user_model');
        }
        $user_data = $this->user_model->get($uid);
        if(!$user_data){
            $this->renderJSON(array(), false, 'Account is not exists.', array());
        }
        if(!$user_data->status){
            $this->renderJSON(array(), false, 'Account is not activated.', array());
        }
        /*if( strtotime($user_data->expired)<time() ){
            $this->token_model->delete_by('uid', $uid);
            $this->renderJSON(array(), false, 'Account is expired. Please renew more.', array('logout'=>true));
        }*/
        /*$token_time = $check_token->created_on&&$check_token->created_on!='0000-00-00 00:00:00' ? strtotime($check_token->created_on) : 0;
        $range = $check_token->remember_me ? 60*60*24*30 : 60*60*24;
        if(!$token_time && $token_time<time()-$range){
            $this->renderJSON(array(), false, 'Vui lòng đăng nhập để xem được nội dung này', array());
        }*/
        return true;
    }
    protected function tracking($uid, $object_id, $action='viewed', $type=1){
        $this->load->model('log_model');
        $this->log_model->add(array(
            'uid' => $uid,
            'ip' => $this->get_client_ip(),
            'object_id' => $object_id,
            'object_type' => $type,
            'action' => $action,
            'user_agent' => $this->get_user_agent(),
            'created_on' => date('Y-m-d H:i:s')
        ));
    }
    protected function get_user_agent(){
        return $_SERVER['HTTP_USER_AGENT'];
    }
    protected function get_client_ip(){
        $ipAddress = null;
        if (getenv('HTTP_X_CLIENT_RIP')) $ipAddress = getenv('HTTP_X_CLIENT_RIP');
        else if (getenv('HTTP_CLIENT_IP')) $ipAddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR')) $ipAddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED')) $ipAddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR')) $ipAddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED')) $ipAddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR')) $ipAddress = getenv('REMOTE_ADDR');
        else $ipAddress = 'UNKNOWN';
        return $ipAddress;
    }

    protected function get_block($content, $start, $end, $without_start=false, $without_end=false){
        if(!$start && $start !== 0) return '';
        $start_offset = strpos($content, $start);
        if($start_offset===false) return '';

        if($end){
            $end_offset = strpos($content, $start, $start_offset);
        }else{
            $end_offset = strlen($content);
        }
        if($start_offset>=$end_offset) return '';

        if($without_start){
            $start_offset = $start_offset + strlen($start);
        }
        if($without_end==false){
            $end_offset = $end_offset + strlen($end);
        }

        return substr($content, $start_offset, $end_offset-$start_offset);
    }
}