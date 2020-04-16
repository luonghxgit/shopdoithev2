<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Momo extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('auth/User_model');
        $this->load->model('card/Card_model');
        $this->load->model('transaction/Transaction_model');
        $this->load->model('cardtype/Cardtype_model');
        $this->load->library('ciqrcode');

    }

    /*
     1. Tạo giao dịch --> chờ quét momo
     2. Xử lý giao dịch
     3. Trả kết quả

     * */
    public function pay2()
    {
        $key = $this->input->get('key', true);
        $userInfo = $this->User_model->find_by('key', $key);
        try {
            $value = $this->input->get('value', true);
            $arrSentMomo = array(
                'amount' => $value,
                'notifyUrl' => 'https://shopdoithe.com/momo/notifyUrl',
                'returnUrl' => 'https://shopdoithe.com/momo/returnUrl',
                'extraData' => 'merchantName=Hiệu Ảnh Thanh Xuân',
              //  'extraData' => 'merchantName=' . $userInfo->username,
                'orderId' => $userInfo->id . time() . ''
            );

            $out = $this->sendToMomo($arrSentMomo);
            $out = json_decode($out);
            if ($out->message != 'Success') {
                echo json_encode(array('status' => -1, 'msg' => $out->message));
                die;
            }
            echo json_encode($out);
            die;
            //    redirect(base_url('momo/qr?qr=' . $out->payUrl));
        } catch (Exception $e) {
            $result['msg'] = $e->getMessage();
        }
    }

    public function qr()
    {
        header("Content-Type: image/png");
        $data = $this->input->get('qr');
        $params['data'] = $data;
        $this->ciqrcode->generate($params);
    }


    public function returnUrl()
    {

    }

    public function notifyUrl()
    {

    }

    private function sendToMomo($input)
    {
        $endpoint = "https://test-payment.momo.vn/gw_payment/transactionProcessor";
        $partnerCode = 'MOMOW4WM20200227';
        $accessKey = '83LWYIfbG6rpCaBo';
        $serectkey = 'QsbDs6t6Sjmzt357bmUuw9QadCxi71SH';
        $orderId = $input['orderId']; // Mã đơn hàng
        $orderInfo = 'Thanh toan hoa don #' . $orderId;
        $amount = $input["amount"];
        $notifyurl = $input["notifyUrl"];
        $returnUrl = $input["returnUrl"];
        $extraData = $input["extraData"];

        $requestId = time() . "";
        $requestType = "captureMoMoWallet";//8474
        $extraData = ($input["extraData"] ? $input["extraData"] : "");
        //before sign HMAC SHA256 signature
        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);
        $data = array('partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'returnUrl' => $returnUrl,
            'notifyUrl' => $notifyurl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature);
        $result = $this->execPostRequest($endpoint, json_encode($data));
        return $result;

    }

    private function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}