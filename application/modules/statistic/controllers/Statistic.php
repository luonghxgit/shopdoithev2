<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Statistic extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('card/Card_model');
        $this->load->model('auth/User_model');
        $this->load->model('statistic/Statistic_model');
        $this->load->model('transaction/Transaction_model');
    }

    public function sign($user_id,$date)
    {
        $date = date('Y-m-d',strtotime($date));
        $alltrans = $this->Transaction_model->getTransByDateUser($user_id, $date);
        $total = 0;
        $money_card = 0;
        foreach ($alltrans as $item) {
            $total += $item->money_add;
            $money_card += $item->money_card;
        }
        $chk = $this->Statistic_model->chk($user_id, $date);
        $arr = array('money' => $total, 'money_card' => $money_card);
        if ($chk) {
            $this->Statistic_model->update($chk->id, $arr);
        } else {
            $this->Statistic_model->add($arr);
        }
        echo $total;
    }

}