<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Revenue extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth/User_model');
        $this->load->model('card/Card_model');
        $this->load->model('transaction/Transaction_model');

    }

    function index()
    {
        $user_id = $this->session->userdata('user_id');
        $temp = array();
        $month = date('Y-m');

        $tdate = date('Y-m-d');
        $fdate = date('Y-m-d', strtotime($tdate . " - 30 days"));
        $temp['total']['month'] = $this->Card_model->sumByMonth($user_id,$month);
        $temp['total']['today'] = $this->Card_model->sumGroupByDate(date('Y-m-d'));
        $temp['datear'] = $this->Card_model->sumGroupByDay($fdate, $tdate);




        $temp['template'] = 'revenue/index_view';
        $this->load->view('admin/layout.php', $temp);
    }

    function dashboard()
    {
        $temp = array();
        $month = date('Y-m');

        $tdate = date('Y-m-d');
        $fdate = date('Y-m-d', strtotime($tdate . " - 7 days"));
        $temp['usersToday'] = $this->Card_model->sumGroupUserByDay(date('Y-m-d'));
        $temp['usersYesterday'] = $this->Card_model->sumGroupUserByDay(date('Y-m-d', strtotime($tdate . " - 1 days")));
        $temp['total']['month'] = $this->Card_model->sumByMonth(0,$month);
        $temp['total']['today'] = $this->Card_model->sumGroupByDate_root(date('Y-m-d'));
 
        $temp['datear'] = $this->Card_model->sumGroupByDay_root($fdate, $tdate);
        

        $temp['cur_link'] = base_url().'revenue/dashboard';
        $temp['reports'] = array();
        $year_now = date('Y');
        $month_now = date('m');

        $temp['m'] = '';
        $temp['y'] = '';

        if(!empty($_GET['m'])){
            $temp['m'] = $this->input->get('m');
            $month_now = $temp['m'];
        }

        if(!empty($_GET['y'])){
            $temp['y'] = $this->input->get('y');
            $year_now = $temp['y'];
        }

        $num_day = 0;
        if($month_now == 1 || $month_now == 3 || $month_now == 5 || $month_now == 7 || $month_now == 8 || $month_now == 10 || $month_now == 12 ){
            $num_day = 31;
        }elseif ($month_now == 4 || $month_now == 1 || $month_now == 9 ||$month_now == 11) {
            $num_day = 30;
        }elseif ($month_now == 2) {
            $num_day = 28;
        }
        for ($i = $num_day; $i >= 1; $i--) { 

            $date = $i.'/'.$month_now.'/'.$year_now;

            $total_cardvalue = $this->Card_model->TotalCardvalueForDay($i,$month_now,$year_now);
            $total_realvalue =  $this->Card_model->TotalRealvalueForDay($i,$month_now,$year_now);
            $total_receivevalue = $this->Card_model->TotalReceivevalueForDay($i,$month_now,$year_now);
            $temp['reports'][] = array(
                'date'      => $date,
                'total_cardvalue'         => $total_cardvalue,
                'total_realvalue'        => $total_realvalue,
                'total_receivevalue'        => $total_receivevalue,
            );
        }


        $temp['template'] = 'revenue/dashboard_index_view';
        $this->load->view('admin/layout.php', $temp);
    }

}