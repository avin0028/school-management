<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_Model extends CI_Model
{
    protected $table_name;

    public function get($condition = false)
    {

        $res = [];
        if ($condition = false) {
            $res = $this->db->get_where($this->table_name, $condition);
        } else {
            $res = $this->db->get($this->table_name);
        }
        return $res->result_array();
    }
    public function create($data)
    {
        return $this->db->insert($this->table_name, $data);
    }
}
