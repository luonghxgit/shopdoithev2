<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Cronjob extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('card/Card_model');
        $this->load->model('callbacksend/Callbacksend_model');
    }

    public function reCallback()
    {
        $data = $this->Callbacksend_model->getCallbackFalse();
        if (isset($data->id)) {
            $datasend = json_decode($data->data, true);

            print_r(http_build_query($datasend));
            $curl = curl_init();
            curl_setopt_array($curl, array(

                CURLOPT_URL => $data->url . '?' . http_build_query($datasend),
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
            $this->db->insert('callback_sends', array('responsed' => json_encode($resp), 'http_code' => $http_info['http_code'], 'http_info' => json_encode($http_info), 'card_id' => $data->card_id, 'url' => $data->url, 'data' => json_encode($datasend), 'created_on' => date('Y-m-d H:i:s')));
           $this->Callbacksend_model->update($data->id,array('http_code'=>2000));
            die;

        }
    }


}