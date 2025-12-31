<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SMSController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('SMS_Model', 'loginsms');
        $this->load->helper('url');
        if (!$this->session->userdata('user_logged')) {
            return redirect('login');
        }
    }

    // loads view wrapped with layout
    public function index()
    {
        $data['title'] = "SMS Reports";
        $data['tableName'] = "User SMS Details List 2025-26";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('reports/loginsmsreports', $data); 
        $this->load->view('template/footer');
    }

    public function show_all()
    {
        $smsreports = $this->loginsms->get_all();
        header('Content-Type: application/json');
        echo json_encode($smsreports);
    }
}