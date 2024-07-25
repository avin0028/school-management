<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends My_Model
{
    protected $table_name = "user";

	public function getTeachersStudent($teacher_id){
		return $this->customQuery(
			"SELECT class_students.student_username,user.nickname FROM class_students
				INNER JOIN user ON user.username = class_students.student_username 
                WHERE class_id in (SELECT id FROM class WHERE teacher_username = '$teacher_id')"
		);
	}

}
