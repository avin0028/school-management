<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Students extends My_Controller
{
	public function getSchedule()
	{
		$this->load->model("Schedule_model");
		$res = $this->Schedule_model->getSchedule();
		return $this->Response($res);
	}

	public function getReportCard()
	{
		$username = $this->auth();
		$this->load->model("Grade_model");
		$res = $this->Grade_model->getScore($username['username']);
		$this->Response($res);
		die;

	}
	public function getGrades(){
		$username = $this->auth();
		$this->load->model("Grade_model");
		$res = $this->Grade_model->GetGrades($username['username']);
		$this->Response($res);
		die;



	}
	public function getStudentClasses(){
		$username = $this->auth();
		$this->load->model("Class_model");
		$res = $this->Class_model->getStudentClasses($username['username']);
		$this->Response($res);
		die;
	}
}
