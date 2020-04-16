<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index(){

        $temp['template'] = 'dashboard/dashboard_index_view';
        $this->load->view('admin/layout.php', $temp);

    }

}