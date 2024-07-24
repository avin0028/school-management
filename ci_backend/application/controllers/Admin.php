<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends My_Controller
{
    private function checkIsAdmin()
    {
        $user = $this->auth();
        if ($user['role'] != 'adm') {
            $this->Response('lack of admin permissions', 403);
            die;
        }
    }
    public function getStudents()
    {
        $this->checkIsAdmin();
        $this->load->model("User_model");
        $res = $this->User_model->get_props(["nickname", "username"], ["role" => "stu"]);
        $this->Response($res);
        die;
    }

    public function addStudent()
    {
        //check for duplicate
        $this->checkIsAdmin();
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $nickname = $this->input->post('nickname');

        if (!$username || !$password || !$nickname) {
            $this->Response('invalid input', 400);
            die;
        }

        $this->load->model('User_model');
        $studentExists = count($this->User_model->get(['username' => $username]));
        if ($studentExists == 1) {
            $error_msg = ['message' => "student already exists"];
            $this->Response($error_msg, 400);
            die;
        }

        $this->load->helper('password_hasher');
        $data = [
            'username' => $username,
            "password" => passwordhasher($password),
            "nickname" => $nickname,
            "role" => "stu"
        ];
        $this->User_model->create($data);
        $this->Response(['message' => "student {$nickname} added"]);
    }
    public function removeStudent()
    {
        $this->checkIsAdmin();

        $username = $this->input->post('username');
        $this->load->model('User_model');
        $this->User_model->delete(['username' => $username]);
        $this->Response(["message" => "student {$username} is deleted "]);
        die;
    }

    public function getCourses()
    {
        $this->checkIsAdmin();
        $this->load->model("Course_model");
        $res = $this->Course_model->get();
        $this->Response($res);
        die;
    }

    public function addCourse()
    {
        $this->checkIsAdmin();
        $this->load->model('Course_model');
        $data = ["name" => $this->input->post('classname')];
        $this->Course_model->create($data);
        $this->Response(["message" => "course added "]);
        die;
    }


    public function removeCourse()
    {
        $this->checkIsAdmin();
        $this->load->model("Course_model");
        $data = ["id" => $this->input->post("id")];
        $this->Course_model->delete($data);
        $this->Response(["message" => "course deleted "]);
        die;
    }

    public function getClasses()
    {
        $this->checkIsAdmin();
        $this->load->model('Class_model');
        $res = $this->Class_model->get_props(["teacher_username", "name", "id"]);
        $this->Response($res);
        die;
    }

    public function addClass()
    {
        $this->checkIsAdmin();

        $this->load->model('Class_model');
        $teacher_id = $this->input->post("teacher_id");
        $course_id = $this->input->post('course_id');
        $class_name = $this->input->post('class_name');

        $data = [
            "teacher_username" => $teacher_id,
            "course_id" => $course_id,
            "name" => $class_name

        ];
        $this->Class_model->create($data);
        $this->Response(["message" => "class {$class_name} added "]);
        die;
    }

    public function deleteClass()
    {
        $this->checkIsAdmin();
        $this->load->model('Class_model');
        $class_id = $this->input->post('class_id');
        $this->Class_model->delete(["id" => $class_id]);
        $this->Response(['message' => "class deleted"]);
        die;
    }
}
