<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BranchesController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('BranchModel');
    }

    public function index() 
    {
        $data['title'] = "Branches";
        $data['tableName'] = "List Of Branches";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('branches/index1', $data);
        $this->load->view('template/footer');

        // $data['title'] = "Branches";
        // $this->load->view('layouts/header', $data);
        // $this->load->view('layouts/sidebar', $data);
        // $this->load->view('branches/index', $data);
        // $this->load->view('layouts/footer',['custom_js' => 'assets/js/branches.js']);
    }

    public function show_all()
    {
        $branches = $this->BranchModel->getAll();
        header('Content-Type: application/json');
        echo json_encode($branches);
    }
    public function create() {

        $data['title'] = "Create Branch";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('branches/create1',$data);
        $this->load->view('template/footer');

        // $data['title'] = "Create Branch";
        // $this->load->view('layouts/header', $data);
        // $this->load->view('layouts/sidebar', $data);
        // $this->load->view('branches/create',$data);
        // $this->load->view('layouts/footer',['custom_js' => 'assets/js/branches.js']);
    }

    public function store()
    {
        if (
            empty($this->input->post('name')) ||
            empty($this->input->post('head')) ||
            empty($this->input->post('phone_number')) ||
            empty($this->input->post('email')) ||
            empty($this->input->post('address'))
        ) {
            echo json_encode([
                'status' => false,
                'message' => 'Required fields missing'
            ]);
            return;
        }

        $data = [
            'name'         => $this->input->post('name'),
            'head'         => $this->input->post('head'),
            'phone_number' => $this->input->post('phone_number'),
            'email'        => $this->input->post('email'),
            'address'      => $this->input->post('address'),
            'website_url'  => $this->input->post('website_url'),
            'created_at'   => date('Y-m-d H:i:s'),
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        $this->BranchModel->insert($data);

        echo json_encode([
            'status'  => true,
            'message' => 'Branch added successfully'
        ]);
    }


    public function edit($id) {

        $data['title'] = "Edit Branch Details";
        $data['branch'] = $this->BranchModel->getById($id);
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('branches/edit1',$data);
        $this->load->view('template/footer');

        // $data['title'] = "Edit Client";
        // $data['branch'] = $this->BranchModel->getById($id);
        // $this->load->view('layouts/header', $data);
        // $this->load->view('layouts/sidebar', $data);
        // $this->load->view('branches/edit', $data);
        // $this->load->view('layouts/footer',['custom_js' => 'assets/js/clients.js']);
    }

    public function update($id)
    {
        if (
            empty($this->input->post('name')) ||
            empty($this->input->post('head')) ||
            empty($this->input->post('phone_number')) ||
            empty($this->input->post('email')) ||
            empty($this->input->post('address'))
        ) {
            echo json_encode([
                'status' => false,
                'message' => 'Required fields missing'
            ]);
            return;
        }

        $data = [
            'name'         => $this->input->post('name'),
            'head'         => $this->input->post('head'),
            'phone_number' => $this->input->post('phone_number'),
            'email'        => $this->input->post('email'),
            'address'      => $this->input->post('address'),
            'website_url'  => $this->input->post('website_url'),
            'updated_at'   => date('Y-m-d H:i:s')
        ];

        $this->BranchModel->update($id, $data);

        echo json_encode([
            'status'  => true,
            'message' => 'Branch updated successfully'
        ]);
    }

    public function view($id)
    {
        $branch = $this->BranchModel->getById($id);
        header('Content-Type: application/json');
        echo json_encode($branch);
    }


    public function delete($id) {
        $this->BranchModel->delete($id);
        echo json_encode(["status" => "success"]);
    }
}
