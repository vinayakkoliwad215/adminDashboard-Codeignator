<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class HomeController extends CI_Controller 
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->helper('url');
        if (!$this->session->userdata('user_logged')) {
            return redirect('login');
        }
    }
    // loads view wrapped with layout
    public function index()
    {
        $data['title'] = "My Dashboard";
        $data['productsCount']  = $this->Dashboard_model->count_products();
        $data['usersCount']     = $this->Dashboard_model->count_users();
        $data['paymentsCount']  = $this->Dashboard_model->count_payments();
        $data['otpLogsCount']   = $this->Dashboard_model->count_otp_logs();
        $data['totalDepositAmount'] = $this->Dashboard_model->totalDepositAmount();
        $data['totalSmsLogs'] = $this->Dashboard_model->totalSmsLogs();
        $data['totalBranches'] = $this->Dashboard_model->count_branches();
        $data['totalClients'] = $this->Dashboard_model->count_clients();
        $data['totalClientTransactions'] = $this->Dashboard_model->count_clientTransactions();
        $data['totalClientPayment'] = $this->Dashboard_model->totalDepositAmountClient();


        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('template/content',$data);
        $this->load->view('template/footer',$data);
    }

}