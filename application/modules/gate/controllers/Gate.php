<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Gate extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('gate/Gate_model');

    }

    public function index()
    {
        $temp['gates'] = $this->Gate_model->find_all();
        $temp['template'] = 'gate/index_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function ajax_update()
    {

    }
}