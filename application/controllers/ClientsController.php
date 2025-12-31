<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientsController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Client_model');
    }

    public function index()
    {
        $data['title'] = "Clients Form";
        $data['tableName'] = "Auto Save Clients Details";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('clients/auto_save_form', $data);
        $this->load->view('template/footer');

        // $data['title'] = "Clients Entry Form";
        // $this->load->view('layouts/header', $data);
        // $this->load->view('layouts/sidebar', $data);
        // $this->load->view('clients/auto_save_form', $data);
        // $this->load->view('layouts/footer',['custom_js' => 'assets/js/clients.js']);
    }

    // AJAX Auto Save
    public function auto_save()
    {
        $data = [
            "id"          => $this->input->post("id"),
            "name"        => $this->input->post("name"),
            "email"       => $this->input->post("email"),
            "phone"       => $this->input->post("phone"),
            "designation" => $this->input->post("designation"),
            "department"  => $this->input->post("department"),
            "address"     => $this->input->post("address"),
        ];

        $empId = $this->Client_model->autoSave($data);

        echo json_encode(["status" => true, "emp_id" => $empId]);
    }

    public function list() 
    {

        $data['title'] = "Clients Form";
        $data['tableName'] = "Client Details";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('clients/clientindex', $data);
        $this->load->view('template/footer');

        // $data['title'] = "Client Details";
        // $this->load->view('layouts/header', $data);
        // $this->load->view('layouts/sidebar', $data);
        // $this->load->view('clients/clientindex', $data);
        // $this->load->view('layouts/footer',['custom_js' => 'assets/js/clients.js']);
    }

    public function show_all()
    {
        $clients = $this->Client_model->getAll();
        header('Content-Type: application/json');
        echo json_encode($clients);
    }

    public function edit($id) {
        $data['title'] = "Edit Clients Entry Form";
        $data['client'] = $this->Client_model->getById($id);
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('clients/edit', $data);
    }

    public function update($id) {
        $data = [
            "name"        => $this->input->post('name'),
            "email"       => $this->input->post('email'),
            "phone"       => $this->input->post('phone'),
            "designation" => $this->input->post('designation'),
            "department"  => $this->input->post('department'),
            "address"     => $this->input->post('address')
        ];

        $this->Client_model->updateClient($id, $data);

        redirect('clients/list');
    }
    
    public function delete($id) {
        $this->Client_model->deleteClient($id);
        echo json_encode(["status" => "success"]);
    }
}
