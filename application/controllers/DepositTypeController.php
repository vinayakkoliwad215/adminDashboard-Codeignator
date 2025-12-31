<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DepositTypeController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('DepositTypeModel');
        $this->load->database();
        $this->load->helper('url');
        
        if (!$this->session->userdata('user_logged')) {
            return redirect('login');
        }
    }

    public function index() 
    {
        $data['title'] = "Deposit Types";
        $data['tableName'] = "List Of Deposit Types";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('deposits/deposit_type', $data); 
        $this->load->view('template/footer');
    }

    public function show_all()
    {
        $depositTypes = $this->DepositTypeModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($depositTypes);
    }

    public function store() {
        $this->DepositTypeModel->store();
        echo json_encode(['success' => true]);
    }


    public function edit($id) {
        $depositTypes = $this->DepositTypeModel->get($id);
        header('Content-Type: application/json');
        echo json_encode($depositTypes);
    }

    public function update($id) {
       $this->DepositTypeModel->update($id);
        echo json_encode(['success' => true]);
    }


    public function delete($id) {
        $delete = $this->DepositTypeModel->delete($id);
        echo json_encode(['success' => true]);
    }
}
