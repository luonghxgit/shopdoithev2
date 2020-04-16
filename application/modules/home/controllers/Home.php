<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('auth/user_model');
        $this->load->model('cardtype/Cardtype_model');
    }

    public function index()
    {

        $temp['allCardtypes'] = $this->Cardtype_model->find_all();
        $temp['template'] = 'home_index_view';
        $this->load->view('site_layout.php', $temp);
    }


    public function ajx_napthe()
    {

    }

    public function register()
    {
        $name = $this->input->post('name');

        $temp['template'] = 'register_view';
        $this->load->view('site_layout.php', $temp);
    }

    public function ajx_register()
    {
        try {
            $result['status'] = -1;
            $result['msg'] = 'init';
            $info = $this->input->post();
            $chkUsername = $this->user_model->checkUsername($info['username']);
            if (isset($chkUsername->id)) {
                throw new Exception('Username này đã tồn tại trong hệ thống!');
            }
            $chkEmail = $this->user_model->checkEmail($info['email']);
            if (isset($chkEmail->id)) {
                throw new Exception('Email này đã tồn tại trong hệ thống!');
            }
            if ($info['password'] != $info['repassword']) {
                throw new Exception('Mật khẩu không trùng khớp!');
            }
            $arr = array(
                'name' => $info['name'],
                'username' => $info['username'],
                'email' => $info['email'],
                'phone' => $info['phone'],
                'password' => md5($info['password']),
                'key' => md5($info['name'] . rand() . date('YmdHis')),
                'status' => 1
            );
            $userid = $this->user_model->add($arr);
            if ($userid <= 0) {
                throw new Exception('Đăng ký thành viên thất bại!');
            }
            $result['status'] = 1;
            $result['msg'] = 'Đăng kí thành công!';
        } catch (Exception $e) {
            $result['msg'] = $e->getMessage();
        }
        echo json_encode($result);
        die;
    }

    public function ajx_sendcard()
    {
        try {


            $result['status'] = -1;
            $result['msg'] = 'Nạp thẻ thất bại';
            $user_id = $this->session->userdata('user_id');
            if (!$user_id) throw new Exception('Bạn phải đăng nhập để thực hiện chức năng này');
            $cardType = $this->input->post('cardType', true);
            if (!$cardType) throw new Exception('Bạn phải chọn loại thẻ!');
            $cardValue = $this->input->post('cardValue', true);
            if (!$cardValue) throw new Exception('Bạn phải chọn mệnh giá thẻ');
            $cardSeri = $this->input->post('cardSeri', true);
            if (!$cardSeri) throw new Exception('Seri thẻ không được để trống!');
            $cardCode = $this->input->post('cardCode', true);
            if (!$cardCode) throw new Exception('Mã thẻ không được để trống!');
            $userInfo = $this->user_model->find_by('id', $user_id);
            $Signature = md5($userInfo->key . trim($cardCode) . trim($cardSeri));
            $arr = array(
                'key' => $userInfo->key,
                'cardSeri' => trim($cardSeri),
                'cardCode' => trim($cardCode),
                'cardType' => trim($cardType),
                'cardValue' => trim($cardValue),
                'Signature' => trim($Signature)
            );
            $dataUrlSend = 'https://shopdoithe.com/api/sendCard_v2?' . http_build_query($arr);
            $resultData = @file_get_contents($dataUrlSend);
            $resultData = json_decode($resultData, true);
// print_r($resultData);
            if ($resultData['status'] == 1) {
                $result['status'] = 1;
                $result['msg'] = 'Nạp thẻ thành công';
            } else {
                $result['status'] = -1;
                $result['msg'] = $resultData['msg'];
            }
        } catch (Exception $e) {
            $result['msg'] = $e->getMessage();
        }
        echo json_encode($result);
        die;
    }
}