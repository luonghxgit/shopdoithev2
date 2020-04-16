<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Cardtype extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('auth/user_model');
        $this->load->model('auth/reset_model');
        $this->load->model('cardtype/Cardtype_model');
    }

    function index()
    {
        $temp['types'] = $this->Cardtype_model->find_all();

        $temp['template'] = 'cardtype/Cardtype_index_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function update($id)
    {
        $temp['mess'] = $temp['error'] = null;
        if ($this->input->post('name')) {
            $info = $this->input->post();
            $arr = array(
                'name' => $info['name'],
                'discount' => $info['discount'],
                'allow_money' => $info['allow_money'],
                'status' => $info['status'],
                'gate' => $info['gate'],
            );
            if ($info['code'] == 'ZING') {
                $arr['zing_account'] = $info['zing_account'];
                $arr['zing_game'] = $info['zing_game'];
                $arr['config'] = $info['config'];
                $arr['zing_cookie'] = $info['zing_cookie'];
            }
            $this->Cardtype_model->update($info['id'], $arr);
            $temp['mess'] = 'Cập nhật thành công';
        }
        $temp['type'] = $this->Cardtype_model->get($id);

        $temp['template'] = 'cardtype/Cardtype_edit_view';
        $this->load->view('admin/layout.php', $temp);
    }

    public function create()
    {
        $temp['mess'] = $temp['error'] = null;
        if ($this->input->post('name')) {
            $info = $this->input->post();
            $arr = array(
                'name' => $info['name'],
                'code' => $info['code'],
                'discount' => $info['discount'],
                'allow_money' => $info['allow_money'],
                'status' => $info['status']
            );

            $arr['zing_account'] = $info['zing_account'];
            $arr['zing_game'] = $info['zing_game'];
            $arr['config'] = $info['config'];
            $arr['zing_cookie'] = $info['zing_cookie'];

            $id = $this->Cardtype_model->add($arr);
            redirect(base_url('cardtype/update/' . $id));
        }

        $temp['template'] = 'cardtype/Cardtype_add_view';
        $this->load->view('admin/layout.php', $temp);
    }



}