<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralSettingsController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('GeneralSetting_model', 'generalsettings');
        $this->load->helper('url');
        if (!$this->session->userdata('user_logged')) {
            return redirect('login');
        }
    }


    // loads view wrapped with layout
    public function index()
    {
        $data['title'] = "General Settings";
        $data['setting'] = $this->generalsettings->getFirst();
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('settings/generalSettings');
        $this->load->view('template/footer'); 

        // $data['title'] = "General Settings";
        // $data['setting'] = $this->generalsettings->getFirst();
        // $this->load->view('layouts/header', $data);
        // $this->load->view('layouts/sidebar', $data);
        // $this->load->view('settings/generalSettings');
        // $this->load->view('layouts/footer', ['custom_js' => 'assets/js/generalSettings.js']);
    }

    public function show_all()
    {
        $generalsettings = $this->generalsettings->get_all();
        header('Content-Type: application/json');
        echo json_encode($generalsettings);
    }

    public function store()
    {
        $id = $this->input->post('id');
        $this->generalsettings->store($id);
        echo json_encode(['success' => true]);
        redirect('generalSettings');
    }

    public function update($id)
    {
        $this->user->update($id);
        echo json_encode(['success' => true]);
    }

    public function storeImages()
{
    $id = $this->input->post('id');
    $uploadPath = './uploads/settings/';

    if (!is_dir($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    $fields = ['logo_image','login_background','site_background'];
    $data = [];

    foreach ($fields as $field) {
        if (!empty($_FILES[$field]['name'])) {

            $config = [
                'upload_path'   => $uploadPath,
                'allowed_types' => 'jpg|jpeg|png',
                'max_size'      => 2048,
                'encrypt_name'  => true
            ];

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload($field)) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('generalSettings');
            }

            $img = $this->upload->data();

            // Resolution validation
            if ($img['image_width'] < 300 || $img['image_height'] < 300) {
                unlink($img['full_path']);
                $this->session->set_flashdata(
                    'error',
                    ucfirst(str_replace('_',' ',$field)).' must be at least 300x300'
                );
                redirect('generalSettings');
            }

            $data[$field] = 'uploads/settings/'.$img['file_name'];
        }
    }

    if (!empty($data)) {
        $this->db->where('id', $id)->update('general_settings', $data);
    }

    $this->session->set_flashdata('success','Images updated successfully');
    redirect('generalSettings');
}

}