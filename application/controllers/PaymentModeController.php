<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentModeController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('PaymentModeModel');
        $this->load->database();
        $this->load->helper('url');
        if (!$this->session->userdata('user_logged')) {
            return redirect('login');
        }
    }

    public function index() 
    {
        $data['title'] = "Payment Modes";
        $data['tableName'] = "List Of Payment Modes";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('payment_modes/index', $data); 
        $this->load->view('template/footer');   
    }

    public function show_all()
    {
        $modes = $this->PaymentModeModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($modes);
    }

   public function store() {
        $this->PaymentModeModel->store();
        echo json_encode(['success' => true]);
    }


    public function edit($id) {
        $mode = $this->PaymentModeModel->get($id);
        header('Content-Type: application/json');
        echo json_encode($mode);
    }

    public function update($id) {
       $this->PaymentModeModel->update($id);
        echo json_encode(['success' => true]);
    }


    public function delete($id) {
        $delete = $this->PaymentModeModel->delete($id);
        echo json_encode(['success' => true]);
    }

    public function list() {
        $data = $this->PaymentModeModel->getAllPaymentModes();
        echo json_encode($data);
    }

}
