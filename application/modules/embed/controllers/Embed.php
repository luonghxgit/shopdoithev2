<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Embed extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('card/Card_model');
        $this->load->model('auth/User_model');
        $this->load->model('embed/Embed_model');
        $this->load->model('transaction/Transaction_model');
    }

    public function index()
    {
        $temp = array();
        $temp['embeds'] = $this->Embed_model->find_all();
        $temp['template'] = 'index_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function create()
    {

    }

    function show($token = '')
    {
        //   echo $this->generateRandomString(10);
        if ($token == '') {
            die('Mã nhúng không hợp lệ');
        }
        $infoEmbed = $this->Embed_model->getEmbedInfo($token);

        if (!isset($infoEmbed->id)) {
            die('Mã nhúng không tồn tại');
        }
        $temp = array();
        $temp['token'] = $token;
        $temp['name'] = $infoEmbed->name;
        $temp['template'] = 'embed_show';
        $this->load->view('null_layout', $temp);
    }

    public function proccess()
    {
        $token = $this->input->post('code', true);
        $cardCode = $this->input->post('C' . strtoupper(md5($token)), true);
        $cardSeri = $this->input->post('S' . strtoupper(md5($token)), true);
        $cardType = $this->input->post('T' . strtoupper(md5($token)), true);
        $cardValue = $this->input->post('V' . strtoupper(md5($token)), true);
        $infoEmbed = $this->Embed_model->getEmbedInfo($token);
        if (!isset($infoEmbed->id)) {
            die('Mã nhúng không tồn tại');
        }
        $cardTypeInfo = $this->Card_model->getCardType($cardType);
        $merchanKey = $infoEmbed->merchantKey;
        $requestId = $infoEmbed->user_id . date('Ymdhis') . rand();
        $arrSave = array(
            'cardcode' => $cardCode,
            'cardseri' => $cardSeri,
            'cardtype' => $cardType,
            'cardvalue' => $cardValue,
            'realvalue' => 0,
            'request_id' => $requestId,
            'user_id' => $infoEmbed->user_id,
            'status' => 0,
            'rate' => $cardTypeInfo->discount,
            'date_created' => date('Y-m-d'),
            'api' => 'embed-' . $token

        );

        $cardInsertId = $this->Card_model->add($arrSave);
        $keyAPI = 'fdb22287762c5f8067b8d8132d4f8064';
        $arrSend = array(

            'KeyAPI' => $keyAPI,
            'TypeCard' => $cardType,
            'CodeCard' => $cardCode,
            'SeriCard' => $cardSeri,
            'ValueCard' => $cardValue,
            'IDRequest' => $requestId,
            'Signature' => md5($keyAPI . $cardValue . $requestId),
            'card_id' => $cardInsertId,
            'transaction_id' => $requestId
        );
        $da = $this->sendChargeGarena($arrSend);
        if ($da['status'] == 1) {
            // Cộng tiền vào mã nhúng
            $embed_balance = $infoEmbed->balance;
            $balance_limit = $infoEmbed->balance_limit;
            $balance_current = $infoEmbed->balance_current + $da['received_value'];
            if ($balance_current >= $balance_limit) {
                $balance_current = 0;
                $arrUpdateEmbed = array(
                    'balance' => $embed_balance,
                    'balance_current' => $balance_current
                );
                $this->Embed_model->update($infoEmbed->id, $arrUpdateEmbed);
                $arrShow = array(
                    'status' => 1,
                    'msg' => $infoEmbed->success_msg,
                    'value' => $cardValue,
                    'received_value' => $da['received_value'],
                    'real_value' => $da['real_value']
                );

            } else {

                $arrShow = array(
                    'status' => 1,
                    'msg' => 'Nạp thẻ thành công!',
                    'value' => $cardValue,
                    'received_value' => $da['received_value'],
                    'real_value' => $da['real_value']
                );
            }
        } else {

            $arrShow = array(
                'status' => -1,
                'msg' => $da['msg'],

            );
        }
        echo json_encode($arrShow);
        die;
    }

    private function sendChargeGarena($input)
    {
        set_time_limit(500);
        //partnerCode + serviceCode + commandCode+ requestContent + partnerKey
        $partnerCode = 'ken';
        $partnerKey = 'fe41de265291d91d56e16c6ea2328ce0';
        $serviceCode = 'cardtelco';
        $commandCode = 'usecard';

        //         $card_id = $input['card_id'];
        $seri = $input['SeriCard'];
        $pin = $input['CodeCard'];
        $value = $input['ValueCard'];
        $requestid = $input['IDRequest'];
        $requestContent = array(
            'CardSerial' => $seri,
            'CardCode' => $pin,
            'CardType' => strtolower($input['TypeCard']),
            'AccountName' => $partnerCode,
            'RefCode' => $requestid,
            'AmountUser' => $value
        );
        $requestContent = json_encode($requestContent);
        $arr = array(
            'partnerCode' => 'ken',
            'serviceCode' => 'cardtelco',
            'commandCode' => 'usecard',
            'requestContent' => $requestContent,
            'signature' => md5($partnerCode . $serviceCode . $commandCode . $requestContent . $partnerKey)
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://apicard.thumuathe.shop/VPGJsonService.ashx",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 300,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($arr),
            CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        $response = json_decode($response);
        if ($response == 'null' || $response == null || !isset($response->ResponseCode)) {
            $response = $this->curlToThumuathe($arr);
            $response = json_decode($response);
        }
        if ($response->ResponseCode != 1 && $response->ResponseCode != -372) {
            $arrCallback = array('status' => -1, 'note' => 'Nạp thẻ thất bại', 'callback_note' => 'Thẻ sai hoặc đã được sử dụng', 'realvalue' => 0, 'receivevalue' => 0, 'responsed' => json_encode($response));
            $this->Card_model->update($input['card_id'], $arrCallback);
            return array('status' => -1, 'returnCode' => -1, 'returnMessage' => 'Thẻ sai hoặc đã được sử dụng', 'msg' => 'Thẻ sai hoặc đã được sử dụng', 'transaction_id' => $requestid);
        } else {
            $cardInfo = $this->Card_model->find_by('request_id', $requestid);
            $userInfo = $this->User_model->find_by('id', $cardInfo->user_id);
            $cardTypeInfo = $this->Card_model->getCardType($input['TypeCard'], $input['ValueCard']);
            $tranferNote = 'Bạn đã nạp thẻ ' . number_format($response->ResponseContent) . 'đ. mã GD ' . $requestid;
            // Tính tiền
            $cardreceive = $response->ResponseContent;
            if ($input['ValueCard'] < $response->ResponseContent) {
                $cardreceive = $input['ValueCard'];
            }
            if (in_array($input['TypeCard'], array('ZING', 'GARENA'))) {
                $cardreceive = $response->ResponseContent;
            }
            $moneyAdd = $cardreceive - (($cardreceive * $cardTypeInfo->discount) / 100);
            $moneyAfterChange = $userInfo->balance + $moneyAdd;
            // ket  thuc tính tiền
            $arrCallback = array('status' => 1, 'note' => 'Nạp thẻ thành công!', 'callback_note' => 'Nạp thẻ thành công', 'realvalue' => $response->ResponseContent, 'receivevalue' => $cardreceive, 'money_after_rate' => $moneyAdd, 'responsed' => json_encode($response));
            if (in_array($input['TypeCard'], array('ZING', 'GARENA'))) {
                $arrCallback['cardvalue'] = $response->ResponseContent;
            }
            $this->Card_model->update($input['card_id'], $arrCallback);

            // Thêm giao dich:transaction
            $arrTransAdd = array(
                'user_id' => $cardInfo->user_id,
                'money_card' => $response->ResponseContent,
                'money_add' => $moneyAdd,
                'money' => $moneyAdd,
                'before_change' => $userInfo->balance,
                'after_change' => $moneyAfterChange,
                'status' => 1,
                'note' => $tranferNote
            );
            $this->Transaction_model->insert($arrTransAdd);
            $this->User_model->update($userInfo->id, array('balance' => $moneyAfterChange));
            $arrSendToCustomer = array(
                'status' => 1,
                'value' => $response->ResponseContent,
                'real_value' => $response->ResponseContent,
                'received_value' => $cardreceive,
                'msg' => 'Nạp thẻ thành công',
                'transaction_id' => $requestid,
                'returnCode' => 1,
                'returnMessage' => 'Nạp thẻ thành công'

            );
            return $arrSendToCustomer;
        }


        //   return json_encode($response);

    }

    private function generateRandomString($length = 10)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}