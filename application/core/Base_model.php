<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Base_model extends CI_Model
{
    protected $table;
    protected $created_on;
    protected $modified_on;

    function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->created_on = 'created_on';
        $this->modified_on = 'modified_on';
    }

    function add($data)
    {
        if ($this->created_on) {
            if (!isset($data[$this->created_on]) || !$data[$this->created_on]) {
                $data[$this->created_on] = date('Y-m-d H:i:s');
            }
        }
        $res = $this->db->insert($this->table, $data);
        $this->logE($this->db->last_query());
        if (!$res) return 0;
        return $this->db->insert_id();
    }

    function update($id, $data)
    {
        if ($this->modified_on) {
            if (!isset($data[$this->modified_on]) || !$data[$this->modified_on]) {
                $data[$this->modified_on] = date('Y-m-d H:i:s');
            }
        }
        $res = $this->db->update($this->table, $data, array('id' => $id));
        $this->logE($this->db->last_query());
        return $res;
    }

    function update_by_cond($cond = array(), $data)
    {
        if (!$cond || empty($cond)) return 0;
        foreach ($cond as $key => $item) {
            if (is_array($item)) {
                $this->db->where_in($key, $item);
            } else {
                $this->db->where($key, $item);
            }
        }
        $res = $this->db->update($this->table, $data);
        $this->logE($this->db->last_query());
        return $res;
    }

    function get($id, $select_fields = array())
    {
        if (!empty($select_fields)) {
            $this->db->select(implode(',', $select_fields));
        }
        $result = $this->db->where('id', $id)->get($this->table, 1)->result();
        $this->logE($this->db->last_query());
        if (!$result) return 0;
        return $result[0];
    }

    function find_by($field, $val, $select_fields = array())
    {
        if (!empty($select_fields)) {
            $this->db->select(implode(',', $select_fields));
        }
        $result = $this->db->where($field, $val)->get($this->table, 1)->result();
        $this->logE($this->db->last_query());
        if (!$result) return 0;
        return $result[0];
    }

    function delete($id = 0)
    {
        if (is_array($id)) {
            $res = $this->db->where_in('id', $id)->delete($this->table);
        } else {
            $res = $this->db->where('id', $id)->delete($this->table);
        }
        $this->logE($this->db->last_query());
        return $res;
    }

    function delete_by($field, $val)
    {
        if (is_array($val)) {
            $this->db->where_in($field, $val);
        } else {
            $this->db->where($field, $val);
        }
        $res = $this->db->delete($this->table);
        $this->logE($this->db->last_query());
        return $res;
    }

    function find_all($select_fields = array())
    {
        if (!empty($select_fields)) {
            $this->db->select(implode(',', $select_fields));
        }
        $result = $this->db->get($this->table)->result();
        $this->logE($this->db->last_query());
        if (!$result) return 0;
        return $result;
    }

    function find_all_by($field, $val, $select_fields = array())
    {
        if (!empty($select_fields)) {
            $this->db->select(implode(',', $select_fields));
        }
        if (is_array($val)) {
            $this->db->where_in($field, $val);
        } else {
            $this->db->where($field, $val);
        }
        $this->db->order_by('id', 'desc');
        $result = $this->db->get($this->table)->result();
        $this->logE($this->db->last_query());
        if (!$result) return 0;
        return $result;
    }

    function find_all_without($field, $val, $select_fields = array())
    {
        if (!empty($select_fields)) {
            $this->db->select(implode(',', $select_fields));
        }
        if (is_array($val)) {
            $this->db->where_not_in($field, $val);
        } else {
            $this->db->where($field . ' <>', $val);
        }
        $result = $this->db->get($this->table)->result();
        $this->logE($this->db->last_query());
        if (!$result) return 0;
        return $result;
    }

    function find($cond, $page, $per_page, $order = array(), $select_fields = array())
    {
        if (!empty($select_fields)) {
            $this->db->select(implode(',', $select_fields));
        }
        $offset = ($page - 1) * $per_page;
        if (is_string($cond)) {
            $cond = $cond ? ' where ' . $cond : '';

            $order_sql = '';
            if (!empty($order)) {
                foreach ($order as $field => $sort) {
                    $order_sql = ' ORDER BY ' . $field . ' ' . $sort;
                    break;
                }
            }
            $sql = 'select * from ' . $this->table . $cond . $order_sql . ' LIMIT ' . $per_page . ' OFFSET ' . $offset;
            $query = $this->db->query($sql);
            $data = $query->result();
            $this->logE($this->db->last_query());
            return $data;
        } else {
            if (!empty($order)) {
                foreach ($order as $field => $sort) {
                    $this->db->order_by($this->table . '.' . $field, $sort);
                }
            }
            if (is_array($cond) && !empty($cond)) {
                foreach ($cond as $field => $val) {
                    if (is_array($val)) {
                        $this->db->where_in($this->table . '.' . $field, $val);
                    } else {
                        $this->db->where($this->table . '.' . $field, $val);
                    }
                }
            }
            if ($per_page > 0) {
                $this->db->limit($per_page, $offset);
            }
            $result = $this->db->get($this->table)->result();
            $this->logE($this->db->last_query());
            if (!$result) return 0;
            return $result;
        }
    }

    public function getUser($u)
    {
    return true;

    }
 
    function total($cond)
    {
        if (is_string($cond)) {
            $cond = $cond ? ' where ' . $cond : '';
            $sql = 'select count(*) as numrows from ' . $this->table . $cond;
            $query = $this->db->query($sql);
            $result = $query->result();
            $this->logE($this->db->last_query());
            if (!$result) return 0;
            return $result[0]->numrows;
        } else {
            if (is_array($cond) && !empty($cond)) {
                foreach ($cond as $field => $val) {
                    if (is_array($val)) {
                        $this->db->where_in($this->table . '.' . $field, $val);
                    } else {
                        $this->db->where($this->table . '.' . $field, $val);
                    }
                }
            }
            $res = $this->db->count_all_results($this->table);
            $this->logE($this->db->last_query());
            return $res;
        }
    }

    function like_by($fields, $val, $select_fields = array())
    {
        if (!empty($select_fields)) {
            $this->db->select(implode(',', $select_fields));
        }
        $this->db->group_start();
        foreach ($fields as $field) {
            $this->db->or_like($field, $val);
        }
        $this->db->group_end();
        $result = $this->db->get($this->table)->result();
        $this->logE($this->db->last_query());
        if (!$result) return 0;
        return $result;
    }

    public function logE($msg)
    {
        if (defined('LOG_DB') && LOG_DB) {
            logE($msg . "\n");
        }
    }

    function empty_table()
    {
        $this->db->truncate($this->table);
    }


}