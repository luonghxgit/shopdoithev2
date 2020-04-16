<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Banking extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth/User_model');
        $this->load->model('card/Card_model');
        $this->load->model('bank/Bank_model');
        $this->load->model('banking/Banking_model');
        $this->load->model('transaction/Transaction_model');

    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $temp['userinfo'] = $this->User_model->find_by('id', $user_id);
        $temp['listBanks'] = $this->Bank_model->find_all_by('user_id', $user_id);
        $temp['listBankings'] = $this->Banking_model->find_all_by('user_id', $user_id);
        $temp['template'] = 'banking/banking_index';
        $this->load->view('admin/layout.php', $temp);
    }

    public function ajxInsertBanking()
    {
        $user_id = $this->session->userdata('user_id');
        $userInfo = $this->User_model->find_by('id', $user_id);
        if ($this->input->post('bank_id')) {
            $info = $this->input->post();
            if ($userInfo->balance < $info['money']) {
                echo json_encode(array('status' => 0, 'icon' => 'error', 'mes' => 'Tạo giao dịch thất bại. Tài khoản bạn không đủ tiền để thực hiện giao dịch này'));
                die;
            }
            $bankInfo = $this->Bank_model->find_by('id', $info['bank_id']);
            $arr = array(
                'code' => 'T' . $user_id . '.' . date('ymdHis'),
                'bank_id' => $info['bank_id'],
                'user_id' => $user_id,
                'email' => $info['email'],
                'money' => $info['money'],
                'bank_name' => $bankInfo->name,
                'bank_bankname' => $bankInfo->bankname,
                'bank_chinhanh' => $bankInfo->chinhanh,
                'bank_number' => $bankInfo->bank_number,
                'status' => 0,
                'note' => $info['note']
            );
            $bankingID = $this->Banking_model->add($arr);
            if ($bankingID) {
                // tao giao dich chuyen tien sang waitbank
                $moneyAfterChange = $userInfo->balance - $info['money'];
                $tranferNote = 'Giao dịch rút ' . number_format($info['money']) . 'VNĐ. Tiền được chuyển sang trạng thái chờ. số GD: ' . $arr['code'];
                $arrTransAdd = array(
                    'user_id' => $user_id,
                    'money_card' => 0,
                    'money_add' => 0,
                    'money_down' => $info['money'],
                    'money' => $info['money'],
                    'before_change' => $userInfo->balance,
                    'after_change' => $moneyAfterChange,
                    'status' => 1,
                    'note' => $tranferNote
                );

                $this->Transaction_model->insert($arrTransAdd);
                // end transaction
                // Trừ tiền từ tài khoản chính
                $this->User_model->update($user_id, array('balance' => $moneyAfterChange, 'waitbank' => $info['money']));
                // end trừ tiền

                // Gửi mail xác thực

                //

                echo json_encode(array('status' => 1, 'icon' => 'success', 'mes' => 'Tạo giao dịch rút tiền thành công.!'));
                die;
            }
            echo json_encode(array('status' => 0, 'icon' => 'error', 'mes' => 'Tạo giao dịch thất bại'));
            die;

            redirect(base_url('bank'));
        }

    }

    public function test()
    {
        $this->sendMail('luonghx@gmail.com');
        echo 'done';
        die;
    }

    private function sendMailActiveBanking($mailto, $bankingID)
    {
        $bankingInfo = $this->Banking_model->find_by('id', $bankingID);
        $html = 'Xin chào<br/>';
        $html .= 'Bạn đã tạo mã yêu cầu rút tiền từ shopdoithe.com. Hãy click vào link bên dưới để hoàn tất yêu cầu rút tiền</br>';
        $html .= '<a href="' . base_url('active/' . $bankingID . '-' . md5(time())) . '"></a></br>';
        $this->load->library('email');

        $this->email->from('no-reply@shopdoithe.com', 'Shopdoithe.com');
        $this->email->to($mailto);
        // $this->email->cc('another@another-example.com');
        //   $this->email->bcc('them@their-example.com');

        $this->email->subject('Xác nhận giao dịch rút tiền từ shopdoithe.com');
        $this->email->message($html);

        $this->email->send();
    }

    public function all($bankingID = null)
    {

        if ($bankingID) {
            $bill = $this->Banking_model->info($bankingID);

            $temp['bill'] = $bill;
        }
        $status = $this->input->get('status', true);
        $status = ($status > 0) ? 1 : 0;
        $temp['status'] = $status;
        $allBill = $this->Banking_model->getAllBanking($status);
        $temp['listBankings'] = $allBill;
        $temp['template'] = 'banking/banking_dashboard_index';
        $this->load->view('admin/layout.php', $temp);
    }

    public function reject()
    {
        $bankingId = $this->input->post('bankingId', true);
        $info = $this->Banking_model->find_by('id', $bankingId);
        if ($info->status != 0) {
            echo json_encode(array('status' => -1, 'msg' => 'Giao dịch này không hợp lệ để từ chối'));
            die;
        }
        if (isset($info->id)) {
            $userInfo = $this->User_model->find_by('id', $info->user_id);
            $money = $userInfo->balance + $info->money;
            $this->User_model->update($info->user_id, array('waitbank' => 0, 'balance' => $money));
            // tao giao dich
            $arrTransAdd = array(
                'user_id' => $userInfo->id,
                'money_card' => 0,
                'money_add' => $info->money,
                'money' => $info->money,
                'before_change' => $userInfo->balance,
                'after_change' => $money,
                'status' => 1,
                'note' => 'Bạn nhận lại được ' . number_format($info->money) . ' do bị từ chối giao dịch rút tiền. mã GD: ' . $info->code
            );

            $this->Transaction_model->insert($arrTransAdd);
            // update trạng thái banking
            $this->Banking_model->update($bankingId, array('status' => -1));
            echo json_encode(array('status' => 1, 'msg' => 'Bạn đã từ chối giao dịch này. Số tiền ' . number_format($info->money) . ' được hoàn trả lại tài khoản của khách hàng'));
            die;
        } else {
            echo json_encode(array('status' => -1, 'msg' => 'Giao dịch này không hợp lệ để từ chối'));
            die;
        }
    }

    public function approve()
    {
        $bankingId = $this->input->post('bankingId', true);
        $info = $this->Banking_model->find_by('id', $bankingId);
        if ($info->status != 0) {
            echo json_encode(array('status' => -1, 'msg' => 'Giao dịch này đã xử lý'));
            die;
        }
        if (isset($info->id)) {
            $userInfo = $this->User_model->find_by('id', $info->user_id);
            $money = $userInfo->balance;
            $this->User_model->update($info->user_id, array('waitbank' => 0));
            // tao giao dich
            $arrTransAdd = array(
                'user_id' => $userInfo->id,
                'money_card' => 0,
                'money_down' => $info->money,
                'money' => $info->money,
                'before_change' => $userInfo->balance,
                'after_change' => $money,
                'status' => 1,
                'note' => 'Bạn đã rút tiền thành công. Số tiền ' . $info->money . ' đã được chuyển khoản. Mã GD:' . $info->code
            );

            $this->Transaction_model->insert($arrTransAdd);
            // update trạng thái banking
            $this->Banking_model->update($bankingId, array('status' => 1));
            echo json_encode(array('status' => 1, 'msg' => 'Giao dịch thành công'));
            die;
        } else {
            echo json_encode(array('status' => -1, 'msg' => 'Giao dịch không hợp lệ'));
            die;
        }
    }
} ?>