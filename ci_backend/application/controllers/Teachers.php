<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teachers extends My_Controller
{
    private $teacher_id;

    private function checkIsTeacher()
    {
        $user = $this->auth();
        if ($user['role'] != 'tea') {
            $this->Response('lack of permission', 403);
            die;
        }
        $this->teacher_id =  $user['username'];
    }

    public function getclasses()
    {
        $this->checkIsTeacher();
        $this->load->model("Class_model");
        $res = $this->Class_model->get_props(
            ["name", "id"],
            ["teacher_username" => $this->teacher_id],

        );
        $this->Response($res);
        die;
    }
    public function getclassStudents()
    {
        $this->checkIsTeacher();
        $this->load->model("Class_students_model");
        $res = $this->Class_students_model->get();
    }
}
