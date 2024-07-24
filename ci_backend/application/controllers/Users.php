<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
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
            $invalid_input_error =  [
                'message' => "invalid input",
                "status" => "400"
            ];
            $this->output
                ->set_content_type('application/json')->set_status_header('400')
                ->set_output(json_encode($invalid_input_error));
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
            $credentials_error =  [
                'message' => "invalid credentials",
                "status" => "400"
            ];
            $this->output
                ->set_status_header('400')
                ->set_content_type('application/json')
                ->set_output(json_encode($credentials_error))
                ->_display();
            die;
        }


        $this->load->helper('cookie_generator');
        $cookie = generate_cookie();
        $this->input->set_cookie($cookie);

        $data = [
            'nickname' => $res['nickname'],
            'role' => $res['role']
        ];
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    public function register()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $nickname = $this->input->post('nickname');
        $role = $this->input->post('role');

        if (!$username || !$password || !$nickname || !$role) {
            $invalid_input_error = ['message' => "invalid input", "status" => "400"];
            $this->output
                ->set_content_type('application/json')
                ->set_status_header('400')
                ->set_output(json_encode($invalid_input_error))
                ->_display();
            die;
        }
        $this->load->model('User_model');

        $userExists = count($this->User_model->get(['username' => $username]));
        if ($userExists = 1) {
            $error_msg = ['message' => "user already exists", "status" => "400"];
            $this->output
                ->set_content_type('application/json')
                ->set_status_header('400')
                ->set_output(json_encode($error_msg))
                ->_display();
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

        $cookie = generate_cookie();
        $this->input->set_cookie($cookie);
        $this->output
            ->set_content_type('application/json')
            ->set_status_header('200')
            ->set_output(json_encode($response));
    }
}
