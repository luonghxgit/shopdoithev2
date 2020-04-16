<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin_Controller extends Vcc_Controller{
    protected $per_page = 20;
    public function __construct()
    {
        parent::__construct();
        $current_url = current_url();
        if(!$this->session->userdata('user_id')){
            redirect('auth/login?back='.urlencode($current_url));
        }
		//echo "121_tesst".$this->session->userdata('user_id');
		
		//die;
        // $user_data = $this->session->userdata('user_data');
        // if($user_data['role'] != 1){
        //     die('Website is building, coming soon');
        // }
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
    public function del($id){
        $confirm = $this->input->get('confirm', true);
        if(!$confirm){
            $back_url = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : ''.$this->router->fetch_class();
            $data = array(
                'redirect' => $back_url,
                'del' => base_url(''.$this->router->fetch_class().'/del/'.$id.'?confirm=1&back='.urlencode($back_url))
            );
            echo '<script>'.
                'var r = confirm("Bạn có chắc chắn muốn xóa dữ liệu này.");'.
                'if(r==true){'.
                'window.location.href = "'.$data['del'].'";'.
                '}else{'.
                'window.location.href = "'.$data['redirect'].'";}</script>';
            exit();
        }
    }
}
