<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Card extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('card/Card_model');
        $this->load->model('auth/user_model');
        $this->load->model('auth/reset_model');
        $this->load->model('transaction/Transaction_model');
        $this->load->model('callbacksend/Callbacksend_model');
        $this->load->model('callbacklog/Callbacklog_model');
    }

    public function index()
    {
        $user_id = $this->session->userdata('user_id');
        $temp = array();
        $page = (int)$this->input->get('page', true);
        $page = ($page > 0) ? $page : 1;
        $numrow = 20;
        $fdate = ($this->input->get('fromdate')) ? $this->input->get('fromdate') : date('Y-m-d');
        $fdate = date('Y-m-d', strtotime($fdate));
        $tdate = ($this->input->get('todate')) ? $this->input->get('todate') : date('Y-m-d');
        $tdate = date('Y-m-d', strtotime($tdate));
        $type = ($this->input->get('type', true)) ? $this->input->get('type', true) : null;
        $status = ($this->input->get('status', true)) ? $this->input->get('status', true) : 100;
        $price = ($this->input->get('price', true)) ? $this->input->get('price', true) : 0;

        $k = ($this->input->get('k', true)) ? $this->input->get('k', true) : null;
        $temp['total']['today'] = $this->Card_model->sumGroupByDate_root(date('Y-m-d'));
        $temp['allCards'] = $this->Card_model->getCardByUser($user_id, $k, $fdate, $tdate, $type, $status, $price, $page, $numrow);
        $temp['total'] = $totalRows = $this->Card_model->getCardByUser_total($user_id, $k, $fdate, $tdate, $type, $status, $price);
        $temp['totalMoneyReceive'] = $this->Card_model->totalMoney($user_id, $k, $fdate, $tdate, $user_id, $type, $status, $price);
        $numPage = round($totalRows / $numrow);
        $temp['numPage'] = $numPage;
        $temp['page'] = $page;
        $temp['fdate'] = $fdate;
        $temp['tdate'] = $tdate;
        $temp['type'] = $type;
        $temp['status'] = $status;
        $temp['price'] = $price;
        $temp['k'] = $k;
        $temp['template'] = 'card/index_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function all()
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            redirect('login');
        }
        $user_data = $this->session->userdata('user_data');
        if ($user_data['role'] != 1) {
            redirect('card');
        }
        $temp = array();
        $page = (int)$this->input->get('page', true);
        $page = ($page > 0) ? $page : 1;
        $numrow = 20;
        $fdate = ($this->input->get('fromdate')) ? $this->input->get('fromdate') : null;
        $tdate = date('Y-m-d', strtotime($fdate));
        $tdate = ($this->input->get('todate')) ? $this->input->get('todate') : date('Y-m-d');
        $tdate = date('Y-m-d', strtotime($tdate));
        $type = ($this->input->get('type', true)) ? $this->input->get('type', true) : null;
        $status = ($this->input->get('status', true)) ? $this->input->get('status', true) : 100;
        $price = ($this->input->get('price', true)) ? $this->input->get('price', true) : 0;
        $k = ($this->input->get('k', true)) ? $this->input->get('k', true) : null;
        $filluser = ($this->input->get('filluser', true)) ? $this->input->get('filluser', true) : 0;
        $temp['allCards'] = $this->Card_model->getAllCard($k, $fdate, $tdate, $filluser, $type, $status, $price, $page, $numrow);
        $temp['total'] = $totalRows = $this->Card_model->getAllCardTotal($k, $fdate, $tdate, $filluser, $type, $status, $price);
        $temp['totalMoneyReceive'] = $this->Card_model->totalMoney(null, $k, $fdate, $tdate, $filluser, $type, $status, $price);


        $allCards = $this->Card_model->getAllCard($k, $fdate, $tdate, $filluser, $type, $status, $price, $page, $numrow);
        $temp['allCards'] = array();
        if($allCards){
            foreach ($allCards as $key) {
                $ss = 0;
                $s = json_decode($key->responsed);
                if(isset($s->ResponseCode)){
                    $ss .= $s->ResponseCode;
                }
                if(isset($s->status)){
                    $ss .= $s->status;
                }
                $stt = '';
                switch ($key->status) {
                    case -1:
                        $stt = '<div class="label-error">Thẻ sai</div>';
                        break;
                    case 1:
                        $stt = '<div class="label-success">Thẻ đúng</div>';
                        break;
                    default:
                        $stt = '<div class="label-waitting">Đang xử lý</div>';
                        break;
                }
                if ($key->realvalue != $key->cardvalue && $key->realvalue > 0) $stt = '<div class="label-smg">Sai mệnh giá</div>';
                $timexuly = '';
                if(isset($key->modified_on)){
                    $timexuly = $this->khoangcach2ngay($key->created_on,$key->modified_on).' giây';
                }

               $temp['allCards'][] = array(
                    'id' => $key->id, 
                    'username' => $key->username,
                    'cardseri' => $key->cardseri,
                    'cardcode' => $key->cardcode,
                    'cardtype' => $key->cardtype,
                    'cardvalue' => $key->cardvalue,
                    'realvalue' => $key->realvalue,
                    'receivevalue' => $key->receivevalue,
                    'rate' => $key->rate,
                    'http_code' => $key->http_code,
                    'created_on' => date('H:i d/m/Y', strtotime($key->created_on)),
                    'ss' => $ss,
                    'stt' => $stt,
                    'timexuly' => $timexuly,
                );
            }
        }
   /*     $temp['allCards'] = $this->Card_model->getAllCard($k, $fdate, $tdate, $filluser, $type, $status, $price, $page, $numrow);*/



            $allCardChuaXL = $this->Card_model->getAllCardChuaXL($k, $fdate, $tdate, $filluser, $type, $status, $price, $page, $numrow);
            $temp['allCardChuaXL'] = '';
            if($allCardChuaXL){
                foreach ($allCardChuaXL as $key) {
                   $allCardChuaXL[] = array(
                        'id' => $key->id, 
                    );
                }
                 $temp['allCardChuaXL'] = json_encode( $allCardChuaXL, true );
            }
       

        $temp['todayAmonut'] = $this->Card_model->sumGroupByDate_root(date('Y-m-d'));
        $temp['todayAmonutAfterFee'] = $this->Card_model->sumGroupByDate_root(date('Y-m-d'), 'money_after_rate');
        $numPage = round($totalRows / $numrow);
        $temp['numPage'] = $numPage;
        $temp['page'] = $page;
        $temp['fdate'] = $fdate;
        $temp['tdate'] = $tdate;
        $temp['k'] = $k;
        $temp['type'] = $type;
        $temp['status'] = $status;
        $temp['price'] = $price;
        $temp['user'] = $filluser;
        $temp['users'] = $this->user_model->find_all();
        $temp['template'] = 'card/card_all_index_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function khoangcach2ngay($fistday,$secondday){
        $first_date = strtotime($fistday);
        $second_date = strtotime($secondday);
        $datediff = abs($first_date - $second_date);
        return $datediff;
    }
    public function unclear()
    {
        set_time_limit(120);
        $cards = $this->Card_model->getCardByCMSType('"ResponseCode":-326');

        $temp = array();
        $temp['allCards'] = $cards;
        $temp['template'] = 'card/card_unclear_index_view';
        $this->load->view('admin/layout.php', $temp);
    }


    private function updateCardTrue($cardId, $realvalue = 0)
    {

        $cardInfo = $this->Card_model->find_by('id', $cardId);

        $user_data = $this->session->userdata('user_data');
        $username = 'system';
        if (isset($user_data['username'])) {
            $username = $user_data['username'];
        }
        $isTransactionTrue = $this->Transaction_model->checkDuplicate($cardInfo->cardcode);
        if(isset($isTransactionTrue->id)){
            die('Giao dịch này đã đc cộng tiền trước đó!');
        }
        if (isset($cardInfo->id) && $cardInfo->status != 1) {
            $userInfo = $this->user_model->find_by('id', $cardInfo->user_id);

            $cardreceive = $cardInfo->cardvalue;
            if ($realvalue != 0 && $realvalue < $cardInfo->cardvalue) {
                $cardreceive = $realvalue;
            }
            $moneyAdd = $cardreceive - (($cardreceive * $cardInfo->rate) / 100);
            // Tính triết khấu
            // - Cập nhật lại thẻ cho đúng
            $arrUpdateCard = array(
                'realvalue' => ($realvalue > 0) ? $realvalue : $cardInfo->cardvalue,
                'receivevalue' => $cardreceive,
                'money_after_rate' => $moneyAdd,
                'status' => 1,
                'isCallback' => 1,
                'responsed' => '{"ResponseCode":1,"Description":"Transaction is successful. callback time:' . date('H:i d/m/Y') . '","ResponseContent":"' . $cardreceive . '","Signature":"callback"}',
                'note' => $username . '[' . date('H:i:s d/m/Y') . '] Nạp thẻ thành công',
                'callback_note' => 'Cập nhật thẻ thành công'
            );

            $this->Card_model->update($cardInfo->id, $arrUpdateCard);
            //$tranferNote = 'Bạn đã nạp thẻ ' . number_format($response->ResponseContent) . 'đ. Seri:<strong>' . $seri . '</strong> - code: <strong>' . $pin . '</strong>';
            // - Cập nhật tiền vào tài khoản
            $moneyAfterChange = $userInfo->balance + $moneyAdd;
            $this->user_model->update($userInfo->id, array('balance' => $moneyAfterChange));

            // Tạo giao dịch cộng tiền
            $arrTransAdd = array(
                'user_id' => $cardInfo->user_id,
                'money_card' => $cardreceive,
                'money_add' => $moneyAdd,
                'money' => $moneyAdd,
                'before_change' => $userInfo->balance,
                'after_change' => $moneyAfterChange,
                'status' => 1,
                'note' => 'Bạn đã nạp thẻ ' . number_format($moneyAdd) . 'đ. Seri ' . $cardInfo->cardseri . ' code ' . $cardInfo->cardcode
            );
            $this->Transaction_model->insert($arrTransAdd);
            $a = array();
            if ($cardInfo->user_id == 45) {
                $a = $this->sendCallBackToC3Tek($cardId);
            } else {
                if (isset($userInfo->callback_url)) {
                    // $this->sentToCustomer($arrSendToCustomer, $userInfo->callback_url);

                    $arrSendToCustomer = array(
                        'status' => 1,
                        'value' => $cardInfo->cardvalue,
                        'real_value' => ($realvalue > 0) ? $realvalue : $cardInfo->cardvalue,
                        'received_value' => $cardreceive,
                        'transaction_id' => $cardInfo->request_id,
                        'card_seri' => $cardInfo->cardseri,
                        'card_code' => $cardInfo->cardcode,
                        'sign' => md5($userInfo->key . $cardInfo->request_id)
                    );


                    /*
                    * Curl
                    * */
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => $userInfo->callback_url . '?' . http_build_query($arrSendToCustomer),
                        CURLOPT_USERAGENT => 'doithe',
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "GET",
                    ));

                    $resp = curl_exec($curl);
                    $http_info = curl_getinfo($curl);
                    // End
                    curl_close($curl);
                    $this->db->insert('callback_sends', array('responsed' => json_encode($resp), 'http_code' => $http_info['http_code'], 'http_info' => json_encode($http_info), 'card_id' => $cardInfo->id, 'url' => $userInfo->callback_url, 'data' => json_encode($arrSendToCustomer), 'created_on' => date('Y-m-d H:i:s')));
                    die;
                }
            }
            print_r($arrTransAdd);
            //
        }
        die('die');

    }

    private function CardFalse($cardId)
    {
        $cardInfo = $this->Card_model->find_by('id', $cardId);
        if($cardInfo->status == 1){
            die();
        }
        if (isset($cardInfo->id) && $cardInfo->status != 1) {
            $arrUpdateCard = array(
                'status' => -1,

                'responsed' => '{"ResponseCode":-330,"Description":"Card used or does not exist.callback time: ' . date('H:i d/m/Y') . '","ResponseContent":"","Signature":""}'

            );
            $this->Card_model->update($cardInfo->id, $arrUpdateCard);

            //
        }

        if ($cardInfo->user_id == 45) {
            $this->sendCallBackToC3Tek($cardId);
        } else {
            $userInfo = $this->user_model->find_by('id', $cardInfo->user_id);
            if (isset($userInfo->callback_url) && $userInfo->callback_url != '') {
                // $this->sentToCustomer($arrSendToCustomer, $userInfo->callback_url);

                $arrSendToCustomer = array(
                    'status' => -1,
                    'value' => $cardInfo->cardvalue,
                    'real_value' => 0,
                    'received_value' => 0,
                    'transaction_id' => $cardInfo->request_id,
                    'card_seri' => $cardInfo->cardseri,
                    'card_code' => $cardInfo->cardcode,
                    'sign' => md5($userInfo->key . $cardInfo->request_id)

                );


                /*
                * Curl
                * */
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $userInfo->callback_url . '?' . http_build_query($arrSendToCustomer),
                    CURLOPT_USERAGENT => 'doithe',
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                ));

                $resp = curl_exec($curl);
                $http_info = curl_getinfo($curl);
                // End
                curl_close($curl);
                $this->db->insert('callback_sends', array('responsed' => json_encode($resp), 'http_code' => $http_info['http_code'], 'http_info' => json_encode($http_info), 'card_id' => $cardInfo->id, 'url' => $userInfo->callback_url, 'data' => json_encode($arrSendToCustomer), 'created_on' => date('Y-m-d H:i:s')));
                die;

            }
        }

        echo 'Thẻ đã được cập nhật';
        die;
    }

    public function s()
    {

    }

    public function spam()
    {

    }

    public function sendCallBackToC3Tek($cardId)
    {

        $cardInfo = $this->Card_model->find_by('id', $cardId);
        if ($cardInfo->user_id != 45) {
            die('not 45');
        }
        /*
         *  - status: 1 => Gạch thẻ thành công
               -1 => Thẻ sai hoặc đã sử dụng
         - card_seri: seri thẻ
         - card_code: mã thẻ
         - value: Giá trị thẻ gửi sang
         - real_value: Giá trị thực của thẻ
         - received_value: Giá trị thẻ chốt
         - transaction_id : Mã giao dịch
        */
        $c3tek_url = 'http://45.124.94.225/apis/partners/callback';

        $partner_token_api = 'YzUyYjMwMTdhNTViMTQ0M2ZlZjVjNzkwMTRmNzE3ZDU=';
        $partner_name = 'doanthanh';

        $param['status'] = $cardInfo->status;
        $param['value'] = $cardInfo->cardvalue;
        $param['card_seri'] = $cardInfo->cardseri;
        $param['card_code'] = $cardInfo->cardcode;
        $param['real_value'] = $cardInfo->realvalue;
        $param['received_value'] = $cardInfo->receivevalue;
        $param['transaction_id'] = $cardInfo->request_id;
        $param['partner_token_api'] = $partner_token_api;
        $param['partner_name'] = $partner_name;
        $param['partner_signature'] = md5($partner_token_api . $partner_name);


        $ch = curl_init($c3tek_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        $result = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);
        echo $httpcode . '<br/>';
        echo "<pre>";
        print_r($cardInfo);
        echo "</pre>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";
        return $result;

    }

    public function infoCard()
    {
        $id = $this->input->get('id', true);
        $cardInfo = $this->Card_model->getCardFullInfo($id);
        $callbackSend = $this->Callbacksend_model->find_by('card_id', $id);
        $callbacklog = $this->Callbacklog_model->getLog($cardInfo->request_id);
        $temp['callbackSend'] = $callbackSend;
        $temp['callbacklog'] = $callbacklog;
        $temp['card'] = $cardInfo;
        $temp['template'] = 'popup_card_info_view';
        $this->load->view('null_layout.php', $temp);


    }

    public function callbackcms()
    {
        header('Content-Type: application/json');
        $rawdata = file_get_contents("php://input");

        $this->db->insert('callback_logs', array('content' => $rawdata, 'header' => json_encode($_SERVER)));

        $rawdata = json_decode($rawdata);

        $requestId = $rawdata->RefCode;

        $cardInfo = $this->Card_model->find_by('request_id', $requestId);
        if ($cardInfo->partner == 'simbank') {
            die('end0');
        }
        if ($rawdata->Status == 1) {
            $this->updateCardTrue($cardInfo->id);
        }
        if ($rawdata->Status == -1 && $cardInfo->status != 1) {
            $this->CardFalse($cardInfo->id);
        }
        if ($rawdata->Status == -372) {
            $this->updateCardTrue($cardInfo->id, $rawdata->Amount);
        }
        die('end');
    }

    public function callbacksdtzing()
    {
        header('Content-Type: application/json');
        $rawdata = $this->input->get();

        $this->db->insert('callback_logs', array('content' => json_encode($rawdata), 'header' => json_encode($_SERVER)));

        //  $rawdata = json_decode($rawdata);

        $requestId = $rawdata['refcode'];

        $cardInfo = $this->Card_model->find_by('request_id', $requestId);

        if (!isset($cardInfo->id)) {
            die('end0');
        }

        if ($rawdata['status'] == 1) {
            if ($rawdata['value'] != $rawdata['real_value']) {
                $this->updateCardTrue($cardInfo->id, $rawdata['real_value']);
            } else {
                $this->updateCardTrue($cardInfo->id);
            }
        }
        if ($rawdata['status'] == -1 && $cardInfo->status != 1) {
            $this->CardFalse($cardInfo->id);
        }

        die('end');
    }

    public function updateReceivedMoneyCard()
    {
        // Trường hợp cập nhật lại mệnh giá thẻ sai
        $cardId = $this->input->get('cardId', true);
        $received_value_update = $this->input->get('received_value_update', true);
        $cardInfo = $this->Card_model->find_by('id', $cardId);

        if (isset($cardInfo->id)) {
            // Trường hợp thẻ sai mệnh giá --> điều chỉnh lại mệnh giá
            if ($cardInfo->status == 1 && $cardInfo->realvalue != $cardInfo->cardvalue) {
                // Tính chênh lệch
                $diff = $received_value_update - $cardInfo->receivevalue;

                $diff_after_fee = $diff - (($diff * $cardInfo->rate) / 100);

                // Update mệnh giá thẻ
                $this->Card_model->update();
                // cập nhật giao dịch

                // cập nhật tài khoản
            }
        }

    }

    public function updateGarenaTrue($cardId)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            die('unlogin');
        }

        $user_data = $this->session->userdata('user_data');
        if ($user_data['role'] == 1) {
            $this->updateCardTrue($cardId);
        } else {
            die('error');
        }
    }

    public function updateCardFalse($cardId)
    {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            die('unlogin');
        }

        $user_data = $this->session->userdata('user_data');
        if ($user_data['role'] == 1) {
            $this->CardFalse($cardId);
        } else {
            die('error');
        }
    }

    public function doithesieutoc_callback()
    {
        $rawdata = $this->input->post();
        $cardInfo = $this->Card_model->find_by('request_id', $rawdata['content']);
        $this->db->insert('callback_logs', array('content' => $rawdata, 'header' => json_encode($_SERVER)));
        if ($rawdata['status'] == -1) {
            $this->CardFalse($cardInfo->id);
            die;
        }
        if ($rawdata['status'] == 1) {

        }
    }
}