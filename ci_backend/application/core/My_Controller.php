<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function auth()
    {

        $this->load->helper('cookie');
        $this->load->model('User_model');

        $cookie = get_cookie('auth_token');
        if (!$cookie) {
            $error = ['message' => "unathorized access"];
            $res = ['res' => $error, 'code' => 401];
            $this->Response($res);
        }

        $username = base64_decode($cookie);
        $res = $this->User_model->get(['username' => $username]);
        $isUserExists = count($res);
        if ($isUserExists == 0) {
            $error = ['message' => "unathorized access"];
            $res = ['res' => $error, 'code' => 401];
            $this->Response($res);
        }
    }
    // takes an array with code and res
    protected function Response($res, $code = 200)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_status_header($code)
            ->set_output(json_encode($res))
            ->_display();
        die;
    }
}
