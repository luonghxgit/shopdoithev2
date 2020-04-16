<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Page extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('cardtype/Cardtype_model');
    }

    public function home(){
        $temp['allCardtypes'] = $this->Cardtype_model->find_all();
        $temp['template'] = 'home_index2_view';
        $this->load->view('site_layout.php', $temp);
    }

}