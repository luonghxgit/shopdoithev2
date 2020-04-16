<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth/User_model');
        $this->load->model('card/Card_model');
        $this->load->model('transaction/Transaction_model');
    }

    public function index()
    {
        die('1');
    }
}