<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Grade_model extends My_Model
{
    protected $table_name = "grade";

	public function getScore($studentId){
		$this->db->select_avg('grade');
		$this->db->where(["student_username"=>$studentId]);
		$query = $this->db->get($this->table_name);
		return $query->result_array();
	}
	public function getGrades($studentId){
		$this->db->select("grade.grade , class.name");
		$this->db->from($this->table_name);
		$this->db->join("class", "grade.class_id = class.id");
		$this->db->where(["student_username"=>$studentId]);
		$query = $this->db->get();
		return $query->result_array();
}
}
