<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function index()
    {
        echo "main page";
    }
    public function migrate()
    {
        $this->load->library('migration');
        if ($this->migration->version(20240723163725) === FALSE) {
            show_error($this->migration->error_string());
        }
    }
}
