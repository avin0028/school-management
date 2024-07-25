<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Schedule_model extends My_Model
{
    protected $table_name = "schedule";

	public function getSchedule(){
		$this->db->select('class.name,class.id');
		$this->db->from($this->table_name);
		$this->db->join('class','class.id = schedule.class_id');
		$query = $this->db->get();
		return $query->result_array();
	}
}
