<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends Base_model {

    protected $table = 'user';
    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }
    function get_cond($cond){
        if(isset($cond['s']) && $cond['s']){
            $this->db->group_start();
            $this->db->or_like('username', $cond['s']);
            $this->db->or_like('name', $cond['s']);
            $this->db->or_like('email', $cond['s']);
            $this->db->group_end();
            unset($cond['s']);
        }
        return $cond;
    }
    function find($cond, $page, $per_page, $order=array(), $select_fields=array()){
        $cond = $this->get_cond($cond);
        return parent::find($cond, $page, $per_page, $order, $select_fields);
    }
    function total($cond){
        $cond = $this->get_cond($cond);
        return parent::total($cond);
    }
    public function checkUsername($username){
        $this->db->where(array(
            'username' => $username
        ));
        $res = $this->db->get($this->table, 1)->result();
        if(!$res) return 0;
        return $res[0];
    }
    public function checkEmail($email){
        $this->db->where(array(
            'email' => $email
        ));
        $res = $this->db->get($this->table, 1)->result();
        if(!$res) return 0;
        return $res[0];
    }
    public function checkLogin($username, $password){
        $this->db->where(array(
            'username' => $username,
            'password' => md5($password)
        ));
        $res = $this->db->get($this->table, 1)->result();
        if(!$res) return 0;
        return $res[0];
    }
 
    public function login_api($email, $password){
        $this->db->where(array(
            'email'     =>      $email,
            'password'     =>      md5($password)
        ));
        $res = $this->db->get($this->table, 1)->result_array();
        if($res) return $res[0];
        return 0;
    }
    
    public function sumMoneyAllUser($field = 'balance'){
        $this->db->select('SUM('.$field.') as total');
          $res = $this->db->get($this->table, 1)->result_array();
        if($res) return $res[0];
        return 0;
    }

    public function findAllMember(){
        $this->db->select('*')->order_by('balance','DESC')->limit(100);
          $res = $this->db->get($this->table)->result();
        if($res) return $res;
        return 0;

    }


}