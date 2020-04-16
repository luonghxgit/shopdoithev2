<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Report extends Front_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('card/Card_model');
        $this->load->model('auth/user_model');
        $this->load->model('auth/reset_model');
        $this->load->model('report/Report_model');
        $this->load->library('PHPExcel');
    }

    public function index()
    {

    }

    public function ajaxEx()
    {
        $user_id = $this->input->get('user_id', true);
        $filluser = ($this->input->get('filluser', true)) ? $this->input->get('filluser', true) : null;
        $userInfo = $this->user_model->find_by('id', ($user_id) ? $user_id : $filluser);

        $fromdate = ($this->input->get('fromdate', true)) ? $this->input->get('fromdate', true) : date('Y-m-d');
        $todate = ($this->input->get('todate', true)) ? $this->input->get('todate', true) : date('Y-m-d');
        $type = ($this->input->get('type', true)) ? $this->input->get('type', true) : null;

        if (!isset($userInfo->id)) {
            $allCard = $this->Card_model->getAllCard(null, $fromdate, $todate, 0, $type, 1, null, $page = 1, $numrow = 100000000);
        } else {
            $allCard = $this->Card_model->getCardByUser($user_id, null, $fromdate, $todate, $type, 1, null, $page = 1, $numrow = 100000000);
        }
        //  export to excel
        $fileName = 'data-' . time() . '.csv';
        // load excel library

        $rowCount = 8;
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->SetCellValue('B2', 'Ngay doi soat:');
        $objPHPExcel->getActiveSheet()->SetCellValue('C2', date('d/m/Y', strtotime($fromdate)) . ' den ' . date('d/m/Y', strtotime($todate)));

        $objPHPExcel->getActiveSheet()->SetCellValue('B3', 'Doi tac: ');
        $objPHPExcel->getActiveSheet()->SetCellValue('C3', (isset($userInfo->name) ? $userInfo->name : ' tat ca doi tac'));

        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A' . ($rowCount - 1), '#');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . ($rowCount - 1), 'Seri/Code');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . ($rowCount - 1), 'Loai the');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . ($rowCount - 1), 'Menh gia gui');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . ($rowCount - 1), 'Menh gia thuc');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . ($rowCount - 1), 'Menh gia chot');
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . ($rowCount - 1), 'rate');
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . ($rowCount - 1), 'Thuc nhan');
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . ($rowCount - 1), 'Ngay');
        // set Row

        $total_card = $total_real = $total_receive = $total_money = 0;
        foreach ($allCard as $list) {
            $total_card += $list->cardvalue;
            $total_real += $list->realvalue;
            $total_receive += $list->receivevalue;
            $total_money += $list->money_after_rate;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $rowCount - 9);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list->cardseri . '    /     ' . $list->cardcode, PHPExcel_Cell_DataType::TYPE_STRING);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list->cardtype);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($list->cardvalue));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, number_format($list->realvalue));
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($list->receivevalue));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, number_format($list->rate));
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, number_format($list->money_after_rate));
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, date('H:i d/m/Y', strtotime($list->created_on)));
            $rowCount++;
        }
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, number_format($total_card));
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, number_format($total_real));
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, number_format($total_receive));
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, number_format($total_money));

        $objPHPExcel->getActiveSheet()->SetCellValue('B4', 'Tong menh gia chot: ');
        $objPHPExcel->getActiveSheet()->SetCellValue('C4', number_format($total_receive));
        $objPHPExcel->getActiveSheet()->SetCellValue('B5', 'Thuc nhan: ');
        $objPHPExcel->getActiveSheet()->SetCellValue('C5', number_format($total_money));

        $filename = "bao_cao_" . date("Y-m-d-H-i-s") . ".csv";
        header("content-type:application/csv;charset=UTF-8");
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
        $objWriter->save('php://output');


    }

    public function doisoat($userId = null)
    {
        $userdata = $this->session->userdata('user_data');

        if ($userdata['role'] == 1) {
            $userList = $this->user_model->find_all();

        } else {
            $userList[0] = (object)array('id' => $userdata['id'], 'username' => $userdata['username']);
        }
        $userinfo = $this->user_model->find_by('id', $userId);
        $fromdate = $this->input->get('fromdate', true);
        $todate = $this->input->get('todate', true);
        $fromdate = ($fromdate) ? date('Y-m-d', strtotime($fromdate)) : date('Y-m-01');
        $todate = ($todate) ? date('Y-m-d', strtotime($todate)) : date('Y-m-d');
        $temp['fromdate'] = $fromdate;
        $temp['todate'] = $todate;
        $arrayCardType = array('VTT', 'VNP', 'VMS', 'ZING', 'GARENA');
        $a = $this->Report_model->getSumCardByType($userId, 'GARENA', $fromdate, $todate);
        $data = array();
        if ($a) {
            foreach ($a as $item) {
                $data[$item->cardtype][] = $item;
            }
        }

        $temp['users'] = $userList;
        $temp['user'] = $userId;
        $temp['arrayCardType'] = $arrayCardType;
        $temp['data'] = $data;
        $temp['template'] = 'doisoat_view';
        $this->load->view('admin/layout.php', $temp);

    }

    public function test()
    {
        $a = $this->Card_model->getPrivateRate(1,'VTT',10000);
        print_r($a->id);
        die;
    }
}