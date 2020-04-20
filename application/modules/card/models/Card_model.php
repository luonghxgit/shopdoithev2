<?php

class Card_model extends Base_model
{

    protected $table = 'cards';

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function getCardFullInfo($id)
    {
        $this->db->select('C.*, U.username as username')
            ->join('user U', 'U.id = C.user_id', 'inner')
            ->where('C.id', $id);
        $res = $this->db->get('cards C')->result();
        if (!$res[0]) return 0;
        return $res[0];
    }

    public function getCardType($type = null, $amount = null)
    {
        if ($type) {
            $types = ($type == 'viettel') ? 'VTT' : $type;
            $this->db->where(array('code' => $types));
        }
        if ($amount && is_numeric($amount))
            $this->db->like(array('allow_money' => $amount));

        $res = $this->db->get('cardtypes', 1)->result();
        if (!$res) return 0;
        return $res[0];
    }

    public function getCardByUser($userid, $k, $fdate, $todate, $type, $status, $price, $page = 1, $numrow = 15)
    {

        $this->db->select('C.*, U.username as username');
        if ($fdate) {
            $this->db->where('C.date_created >=', $fdate);
        }
        if ($todate) {
            $this->db->where('C.date_created <=', $todate);
        }
        if ($type) {
            $this->db->where('C.cardtype', $type);
        }
        if ($status != 100) {
            $this->db->where('C.status', $status);
        }
        if ($price) {
            $this->db->where('C.receivevalue', $price);
        }
        if ($k) {
            //    $this->db->like('U.username',$k);
            $this->db->like('C.cardseri', $k);
            $this->db->or_like('C.cardcode', $k);
        }
        $this->db->where('user_id', $userid);
        $this->db->join('user U', 'U.id = C.user_id', 'inner');
        $this->db->limit($numrow, $numrow * ($page - 1));
        $this->db->order_by('C.id', 'desc');
        $res = $this->db->get('cards C')->result();
        if (!$res) return 0;
        return $res;

    }

    public function getCardByUser_total($userid, $k, $fdate, $todate, $type, $status, $price)
    {

        $this->db->select('C.*, U.username as username');
        if ($fdate) {
            $this->db->where('C.date_created >=', $fdate);
        }
        if ($todate) {
            $this->db->where('C.date_created <=', $todate);
        }
        if ($type) {
            $this->db->where('C.cardtype', $type);
        }
        if ($status != 100) {
            $this->db->where('C.status', $status);
        }
        if ($price) {
            $this->db->where('C.receivevalue', $price);
        }
        if ($k) {
            //    $this->db->like('U.username',$k);
            $this->db->like('C.cardseri', $k);
            $this->db->or_like('C.cardcode', $k);
        }
        $this->db->where('user_id', $userid);
        $this->db->join('user U', 'U.id = C.user_id', 'inner');

        $this->db->order_by('C.id', 'desc');
        $res = $this->db->count_all_results($this->table . ' C');
        if (!$res) return 0;
        return $res;

    }

    public function getAllCard($k, $fdate, $todate, $filluser, $type, $status, $price, $page = 1, $numrow = 15)
    {
        $this->db->select('C.*, U.username as username, CS.http_code as http_code');
        if ($fdate) {
            $this->db->where('C.date_created >=', $fdate);
        }
        if ($todate) {
            $this->db->where('C.date_created <=', $todate);
        }
        if ($type) {
            $this->db->where('C.cardtype', $type);
        }
        if ($status != 100) {
            $this->db->where('C.status', $status);
        }
        if ($filluser) {
            $this->db->where('C.user_id', $filluser);
        }
        if ($price) {
            $this->db->where('C.receivevalue', $price);
        }
        if ($k) {
            //    $this->db->like('U.username',$k);
            $this->db->like('C.cardseri', $k);
            $this->db->or_like('C.cardcode', $k);
        }
        $this->db->join('user U', 'U.id = C.user_id', 'inner');
        $this->db->join('callback_sends CS', 'C.id = CS.card_id', 'left');
        $this->db->limit($numrow, $numrow * ($page - 1));
        $this->db->order_by('C.id', 'desc');
        $res = $this->db->get('cards C')->result();
        if (!$res) return 0;
        return $res;

    }

    public function getAllCardTotal($k, $fdate, $todate, $filluser, $type, $status, $price)
    {
        $this->db->select('C.*, U.username');
        if ($fdate) {
            $this->db->where('C.date_created >=', $fdate);
        }
        if ($fdate) {
            $this->db->where('C.date_created <=', $todate);
        }
        if ($type) {
            $this->db->where('C.cardtype', $type);
        }
        if ($status != 100) {
            $this->db->where('C.status', $status);
        }
        if ($filluser) {
            $this->db->where('C.user_id', $filluser);
        }
        if ($k) {
            $this->db->like('C.cardseri', $k);
            $this->db->or_like('C.cardcode', $k);
        }

        if ($price) {
            $this->db->where('C.receivevalue', $price);
        }
        $this->db->join('user U', 'U.id = C.user_id', 'left');

        $res = $this->db->count_all_results($this->table . ' C');
        if (!$res) return 0;
        return $res;

    }

    public function sumByMonth($userid = 0, $date = '')
    {

        $user_data = $this->session->userdata('user_data');
        $this->db->select('SUM(receivevalue) as total_realvalue');

        if ($date) {
            $this->db->like('date_created', $date);
        }
        if ($userid != 0) {
            $this->db->where('user_id', $userid);
        }
        $this->db->where('status', 1);
        $this->db->order_by('id', 'desc');
        $res = $this->db->get($this->table)->result();
        if (!$res) return 0;
        return $res[0];
    }

    public function sumByMonth_root($date = '')
    {
        $user_data = $this->session->userdata('user_data');
        $this->db->select('SUM(receivevalue) as total_realvalue');

        if ($date) {
            $this->db->like('date_created', $date);
        }
        $this->db->where('status', 1);
        $this->db->order_by('id', 'desc');
        $res = $this->db->get($this->table)->result();
        if (!$res) return 0;
        return $res[0];
    }

    public function sumGroupByDay($fd, $td)
    {
        $user_data = $this->session->userdata('user_data');

        $this->db->select('SUM(receivevalue) as realvalue, date_created');

        $this->db->where('user_id', $user_data['id']);

        if ($fd) {
            $this->db->where('date_created >=', $fd);
            $this->db->where('date_created <=', $td);
        }
        $this->db->where('status', 1);
        $this->db->group_by('date_created');
        $this->db->order_by('id', 'desc');
        $res = $this->db->get($this->table)->result();
        if (!$res) return 0;
        return $res;
    }

    public function sumGroupByDay_root($fd, $td)
    {
        $user_data = $this->session->userdata('user_data');

        $this->db->select('SUM(receivevalue) as realvalue, date_created, SUM(money_after_rate) as money_after_rate');

        if ($fd) {
            $this->db->where('date_created >=', $fd);
            $this->db->where('date_created <=', $td);
        }
        $this->db->where('status', 1);
        $this->db->group_by('date_created');
        $this->db->order_by('id', 'desc');
        $res = $this->db->get($this->table)->result();
        if (!$res) return 0;
        return $res;
    }

    public function sumGroupUserByDay($date)
    {
        $user_data = $this->session->userdata('user_data');

        $this->db->select('SUM(C.receivevalue) as realvalue, U.username as username, SUM(C.money_after_rate) as money_after_rate');
        $this->db->join('user U', 'U.id = C.user_id', 'inner');
        $this->db->where('C.date_created', $date);

        $this->db->where('C.status', 1);
        $this->db->group_by('C.user_id');
        $this->db->order_by('realvalue', 'desc');
        $res = $this->db->get($this->table . ' C')->result();
        if (!$res) return 0;
        return $res;
    }

    public function sumGroupByDate($date)
    {
        $user_data = $this->session->userdata('user_data');

        $this->db->select('SUM(receivevalue) as realvalue');

        $this->db->where('user_id', $user_data['id']);

        $this->db->where('date_created', $date);

        $this->db->where('status', 1);
        $this->db->order_by('id', 'desc');
        $res = $this->db->get($this->table)->result();
        if (!$res) return 0;
        return $res[0];
    }

    public function sumGroupByDate_root($date, $sumfield = 'receivevalue')
    {
        $user_data = $this->session->userdata('user_data');

        $this->db->select('SUM(' . $sumfield . ') as realvalue');

        $this->db->where('date_created', $date);

        $this->db->where('status', 1);
        $this->db->order_by('id', 'desc');
        $res = $this->db->get($this->table)->result();
        if (!$res) return 0;
        return $res[0];
    }

    public function totalMoney($user_id, $k, $fdate, $tdate, $filluser, $type, $status, $price)
    {
        $this->db->select('SUM(receivevalue) as total_receivalue');
        if ($user_id) {
            $this->db->where('user_id', $user_id);
        }
        if ($fdate) {
            $this->db->where('C.date_created >=', $fdate);
        }
        if ($tdate) {
            $this->db->where('C.date_created <=', $tdate);
        }
        if ($type) {
            $this->db->where('C.cardtype', $type);
        }
        if ($filluser) {
            $this->db->where('C.user_id', $filluser);
        }
        if ($status != 100) {
            $this->db->where('C.status', $status);
        }
        if ($k) {

            $this->db->like('C.cardseri', $k);
            $this->db->or_like('C.cardcode', $k);
        }
        if ($price) {
            $this->db->where('C.receivevalue', $price);
        }

        $res = $this->db->get($this->table . ' C')->result();
        if (!$res) return 0;
        return $res[0];
    }

    public function insertDetechDupplicate($data)
    {
        if ($this->checkCard($data['cardseri'], $data['cardcode'])) {

        }
    }

    public function checkCard($seri, $code, $type = null)
    {
        $this->db->where('cardseri', $seri);
        $this->db->where('cardcode', $code);
        $this->db->where('cardtype', $type);
        $res = $this->db->get($this->table, 1)->result();
        if (!$res) return 0;
        return 1;
    }

    public function getCardRecallCronjob()
    {
        $this->db->select('C.*, U.username as username')
            ->join('user U', 'U.id = C.user_id', 'inner')
            ->like('C.responsed', '-328')
            ->or_like('C.responsed', 'null')
            // ->or_like('C.responsed','"ResponseCode":-1')
            /*  ->where('C.responsed', 'null')
              ->where('C.status', -1)
              ->where_in('C.cardtype', array('GARENA', 'VTT', 'VMS', 'VNP', 'ZING'))*/
            ->where('C.date_created > ', '2020-02-06')
            ->order_by('C.id', 'desc');
        $res = $this->db->get($this->table . ' C')->result();
        if (!$res) return 0;
        return $res;
    }

    public function getCardGarenaUnClear_total()
    {
        $this->db->select('*')
            ->where('responsed', 'null')
            ->where('status', -1)
            ->where_in('cardtype', array('GARENA', 'VTT', 'VMS', 'VNP', 'ZING'))
            ->where('date_created > ', '2020-01-16')
            ->order_by('id', 'desc');
        $res = $this->db->count_all_results($this->table);
        if (!$res) return 0;
        return $res;
    }



    public function getCardTrue()
    {
        $this->db->select('*')
            ->where('status', 1)
            ->order_by('id', 'DESC')
            ->limit(50);
        $res = $this->db->get('cards')->result();
        if (!$res) return 0;
        return $res;
    }

    public function getSpamCard()
    {
        return 0;
        $this->db->select('*')
            ->where('status', -1)
            ->like('responsed', 'reject');
        $res = $this->db->get('cards')->result();
        if (!$res) return 0;
        return $res;
    }

    public function removeCardSpam($id)
    {
        $this->db->delete($this->table, array('status' => -1, 'id' => $id, 'responsed!=' => 'null'));
    }

    public function getUnclearByType($type = 'ZING')
    {
        $this->db->select('C.*')
            ->where('C.responsed', 'null')
            ->where('C.status', -1);
        if ($type != 'all') {
            $this->db->where('C.cardtype', $type);
        }
        $this->db->where('C.date_created > ', '2020-01-16')
            ->order_by('C.id', 'desc');
        $res = $this->db->get($this->table . ' C')->result();
        if (!$res) return 0;
        return $res;
    }

    public function searchCard($key)
    {
        $this->db->select('*')
            ->like('cardseri', $key)
            ->or_like('cardcode', $key)
            ->or_like('request_id', $key)
            ->order_by('id', 'DESC');
        $res = $this->db->get('cards', 1)->result();
        if (!isset($res[0])) return 0;
        return $res[0];
    }

    public function getPrivateRate($user_id, $cardType, $Amount)
    {
        if ($cardType == 'viettel') $cardType = 'VTT';
        $this->db->select('*')
            ->where('user_id', $user_id)
            ->where('type_code', $cardType)
            ->like('allow_money', $Amount)
            ->where('status', 1);
        $res = $this->db->get('cardtype_private_rates')->result();
        if (!isset($res[0])) return null;
        return $res[0];
    }

    public function getCardByCMSType($sttus)
    {
        $this->db->select('C.*, U.username as username')
            ->join('user U', 'U.id = C.user_id', 'inner')
            ->like('C.responsed', $sttus)
            ->where('C.status', -1)
            ->where('C.date_created > ', '2020-02-22')
            /*  ->where('C.responsed', 'null')
              ->where('C.status', -1)
              ->where_in('C.cardtype', array('GARENA', 'VTT', 'VMS', 'VNP', 'ZING'))*/
            ->order_by('C.id', 'desc');
        $res = $this->db->get($this->table . ' C')->result();
        if (!$res) return 0;
        return $res;
    }

    public function getCardByCMSType_total($sttus)
    {
        $this->db->select('C.*, U.username as username')
            ->join('user U', 'U.id = C.user_id', 'inner')
            ->like('C.responsed', $sttus)
            ->where('C.status', -1)
            ->where('C.date_created > ', '2020-02-22')
            /*  ->where('C.responsed', 'null')
              ->where('C.status', -1)
              ->where_in('C.cardtype', array('GARENA', 'VTT', 'VMS', 'VNP', 'ZING'))*/
            ->order_by('C.id', 'desc');
        $res = $this->db->count_all_results($this->table . ' C');
        if (!$res) return 0;
        return $res;
    }

    public function getCardForCronjobV3()
    {
        $this->db->select('id')
            ->where('status', -2)
            ->where('api', 'sendCard_v3');
        $res = $this->db->get($this->table . ' C')->result();
        if (!$res) return 0;
        return $res;
    }

    public function getCardReCallToSDT()
    {
        $this->db->select('id')
            ->where('status', -1)
            ->where('cardtype', 'VTT')
            ->where('responsed', 0)
            ->where('partner', 'sdtvn');
        $res = $this->db->get($this->table . ' C')->result();
        if (!$res) return 0;
        return $res;
    }



    public function TotalCardvalueForDay($day,$month,$year) {
        $this->db->select('cardvalue');
        $this->db->select('created_on');
        $this->db->where('status',1);
        $this->db->from('cards');
        $query =  $this->db->get()->result_array();
        
        $total = 0;
        if ($query) {
            foreach($query as $row)
            {   
                $date_search = strtotime($row['created_on']);
                $current_year = date('Y',$date_search);
                $current_month = date('m',$date_search);
                $current_day = date('d',$date_search);
                if($current_year == $year && $current_month == $month && $current_day == $day){
                    $total = $total + $row['cardvalue'];
                }
                
            }
        }

        return $total;
    }


     public function TotalRealvalueForDay($day,$month,$year) {
        $this->db->select('realvalue');
        $this->db->select('created_on');
        $this->db->where('status',1);
        $this->db->from('cards');
        $query =  $this->db->get()->result_array();
        
        $total = 0;
        if ($query) {
            foreach($query as $row)
            {   
                $date_search = strtotime($row['created_on']);
                $current_year = date('Y',$date_search);
                $current_month = date('m',$date_search);
                $current_day = date('d',$date_search);
                if($current_year == $year && $current_month == $month && $current_day == $day){
                    $total = $total + $row['realvalue'];
                }
                
            }
        }

        return $total;
    }



 public function TotalReceivevalueForDay($day,$month,$year) {
        $this->db->select('receivevalue');
        $this->db->select('created_on');
        $this->db->where('status',1);
        $this->db->from('cards');
        $query =  $this->db->get()->result_array();
        
        $total = 0;
        if ($query) {
            foreach($query as $row)
            {   
                $date_search = strtotime($row['created_on']);
                $current_year = date('Y',$date_search);
                $current_month = date('m',$date_search);
                $current_day = date('d',$date_search);
                if($current_year == $year && $current_month == $month && $current_day == $day){
                    $total = $total + $row['receivevalue'];
                }
                
            }
        }

        return $total;
    }



}