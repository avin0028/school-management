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
}
