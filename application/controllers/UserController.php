<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        $this->load->model('PaymentModeModel');
        $this->load->model('GeneralSetting_model', 'generalsettings');
        $this->load->model('BranchModel','Branch_model');
        $this->load->helper('url');
        if (!$this->session->userdata('user_logged')) {
            return redirect('login');
        }
    }

    // loads view wrapped with layout
    public function index()
    {
        $data['title'] = "Users";
        $data['tableName'] = "User Details List 2025-26";
        $data['branches'] = $this->Branch_model->getAll();
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('users/users', $data); 
        $this->load->view('template/footer');
    }

    public function show_all()
    {
        //$users = $this->user->get_all();
        $users = $this->user->get_all_users_with_branches();
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
        $this->db->select("
        u.*,
        GROUP_CONCAT(b.name ORDER BY b.name ASC SEPARATOR ', ') AS branch_names
        ");
        $this->db->from('users_info u');
        $this->db->join(
            'branches b',
            'FIND_IN_SET(b.id, u.branch_ids)',
            'left'
        );
        $this->db->where('u.id', $id);
        $this->db->group_by('u.id');

        $u = $this->db->get()->row();
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

    //otp status
    public function update_otp_status()
    {
        $id         = $this->input->post('id');
        $otp_status = $this->input->post('otp_status'); // 1 or 0 ONLY

        $this->user->updateOtpStatus($id, $otp_status);

        $msg = ($otp_status == 1) 
            ? "OTP Enabled for this user"
            : "OTP Disabled for this user";

        echo json_encode([
            "success" => true,
            "message" => $msg
        ]);
    }
}