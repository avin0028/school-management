<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends My_Controller
{
    public function index()
    {
        echo "pain";
    }
    public function login()
    {
        //input
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if (!$username || !$password) {
            $invalid_input_error =  ['message' => "invalid input"];
            $this->Response($invalid_input_error, 400);
            die;
        }

        $this->load->model('User_model');
        $this->load->helper('password_hasher');
        $data = [
            'username' => $username,
            'password' => passwordhasher($password)
        ];
        $res = $this->User_model->get($data);
        $res_rows = count($res);


        if ($res_rows == 0) {
            $credentials_error =  ['message' => "invalid credentials"];
            $this->Response($credentials_error, 400);
            die;
        }


        $this->load->helper('cookie_generator');
        $cookie = generate_auth_cookie($username);
        $this->input->set_cookie($cookie);

        $data = [
            'nickname' => $res[0]['nickname'],
            'role' => $res[0]['role']
        ];

        $this->Response($data);
    }

    // Note: we don't need the register functionality since admin handles it
    // Note: code remains for further use
    public function ___register()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $nickname = $this->input->post('nickname');
        $role = $this->input->post('role');

        if (!$username || !$password || !$nickname || !$role) {
            $invalid_input_error = ['message' => "invalid input"];
            $this->Response($invalid_input_error, 400);
            die;
        }
        $this->load->model('User_model');

        $userExists = count($this->User_model->get(['username' => $username]));
        if ($userExists == 1) {
            $error_msg = ['message' => "user already exists"];
            $this->Response($error_msg, 400);
            die;
        }

        $this->load->helper('password_hasher');
        $data = [
            'username' => $username,
            "password" => passwordhasher($password),
            "nickname" => $nickname,
            "role" => $role
        ];
        $this->User_model->create($data);
        $response = [
            'nickname' => $data['nickname'],
            'role' => $data['role']
        ];
        $this->load->helper('cookie_generator');

        $cookie = generate_auth_cookie($username);
        $this->input->set_cookie($cookie);
        $this->Response($response);
    }
}
