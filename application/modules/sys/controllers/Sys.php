<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Sys extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
       // $this->load->model('Setting_model');

    }

    public function index()
    {
        $temp = array();
        $temp['template'] = 'setting/index_view';
        $this->load->view('admin/layout.php', $temp);
    }
}