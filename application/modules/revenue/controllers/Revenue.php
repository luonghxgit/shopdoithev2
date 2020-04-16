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
            
        $temp['template'] = 'revenue/dashboard_index_view';
        $this->load->view('admin/layout.php', $temp);
    }

}