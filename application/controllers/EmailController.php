<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('LoginEmail_Model', 'loginemail');
        $this->load->helper('url');
    }

    // loads view wrapped with layout
    public function index()
    {
        $data['title'] = "Email Reports";
        $data['tableName'] = "User Login Email Details List 2025-26";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('reports/loginemailreports', $data); 
        $this->load->view('template/footer');
    }

    public function loginEmails()
    {
        $emailreports = $this->loginemail->get_all();
        header('Content-Type: application/json');
        echo json_encode($emailreports);
    }
}