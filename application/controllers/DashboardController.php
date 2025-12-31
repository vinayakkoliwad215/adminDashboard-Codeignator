<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

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
        $data['title'] = "Dashboard";
        $data['productsCount']  = $this->Dashboard_model->count_products();
        $data['usersCount']     = $this->Dashboard_model->count_users();
        $data['paymentsCount']  = $this->Dashboard_model->count_payments();
        $data['otpLogsCount']   = $this->Dashboard_model->count_otp_logs();
        $data['totalDepositAmount'] = $this->Dashboard_model->totalDepositAmount();
        $data['totalSmsLogs'] = $this->Dashboard_model->totalSmsLogs();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('dashboard/home', $data);
        $this->load->view('layouts/footer');
    }

    public function show_all()
    {
        $users = $this->user->get_all();
        $general = $this->db->get('generalsettings')->row();
            // 3. Attach Display User ID
        foreach ($users as $u) {
            if (!empty($general->prefixchecked) && $general->prefixchecked == 1) {
                $u->display_user_id = $general->code . $u->id;
            } else {
                $u->display_user_id = $u->id;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function edit($id)
    {
        $u = $this->user->get($id);
        header('Content-Type: application/json');
        echo json_encode($u);
    }

    // public function store()
    // {
    //     $this->user->store();
    //     echo json_encode(['success' => true]);
    // }
    public function store()
    {
        $password = $this->user->store();
        echo json_encode(['success' => true, 'password' => $password]);
    }
    public function update($id)
    {
        $this->user->update($id);
        echo json_encode(['success' => true]);
    }

    public function delete($id)
    {
        $this->user->delete($id);
        echo json_encode(['success' => true]);
    }

    // Fetch payment modes for dropdown
    public function loadPaymentModes() {
        $data = $this->PaymentModeModel->getAllPaymentModes();
        echo json_encode($data);
    }
}