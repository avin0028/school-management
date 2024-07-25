<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Class_model extends My_Model
{
    protected $table_name = "class";

	public function getStudentClasses($username)
	{
		 $query = $this->customQuery("select id,name from class 
                where id in 
            	(select class_id from class_students WHERE student_username = '{$username}')");
		 return $query;
	}


}
