<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    // public function index()
    // {
    //     echo "main page";
    // }
    public function index()
    {
        $this->load->library('migration');
        if ($this->migration->version(20240724253214) === FALSE) {
            show_error($this->migration->error_string());
        }
    }
}
