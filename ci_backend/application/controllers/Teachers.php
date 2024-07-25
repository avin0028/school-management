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
        $class_id = $this->input->post("classid");
        $this->load->model("Class_students_model");
        $res = $this->Class_students_model->customQuery(

            //move to model and use codeigniter 3 syntax
            "SELECT class_students.student_username, user.nickname ,class.name,class.id AS classid FROM class 
             INNER JOIN class_students ON class_students.class_id = class.id
             INNER JOIN user ON class_students.student_username = user.username

             where class_students.class_id = '{$class_id}'
            "
        );
        $this->Response($res);
        die;
    }

    public function gradeStudent()
    {
        $this->checkIsTeacher();
        $class_id = $this->input->post("class");
        $student_id = $this->input->post("student");
        $grade = $this->input->post("grade");
        $this->load->model("grade_model");
        $data = [
            'student_username' => $student_id,
            "class_id" => $class_id,
            "grade" => $grade
        ];

        $this->grade_model->create($data);
        $this->Response(["message" => "student graded!"]);
        die;
    }

    public function getGrades()
    {
        $this->checkIsTeacher();
        $classid = $this->input->post("classid");
        $this->load->model("Grade_model");
        $this->Grade_model->customQuery(
            "SELECT class_students.student_username, user.nickname ,class.name,class.id,grade.grade FROM class
            INNER JOIN class_students ON class_students.class_id = class.id
            INNER JOIN user ON class_students.student_username = user.username 
            left JOIN grade ON grade.student_username = class_students.student_username 
            where class_students.class_id = '{$classid}'
            "
        );
    }
}
