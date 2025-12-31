<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ThemeController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Theme_model');
        $this->load->library(['form_validation','upload']);
        $this->load->helper(['form','url']);
    }

    public function index()
    {
        $data['title']   = "Theme Settings";
        $data['setting'] = $this->Theme_model->get_single();

        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('themes/index',$data);
        $this->load->view('template/footer'); 
    }

    public function store()
    {
        $uploadPath = './uploads/themes/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $files = ['logo_image','login_background','background_image'];
        $data  = [];

        foreach ($files as $file) {

            if (!empty($_FILES[$file]['name'])) {

                // 🔥 RELOAD upload library per file
                $config = [
                    'upload_path'   => $uploadPath,
                    'allowed_types' => 'jpg|jpeg|png',
                    'max_size'      => 2048, // KB
                    'encrypt_name'  => TRUE
                ];

                $this->upload->initialize($config);

                if (!$this->upload->do_upload($file)) {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('themeSettings');
                }

                $uploadData = $this->upload->data();

                // Resolution validation
                if ($uploadData['image_width'] < 100 || $uploadData['image_height'] < 100) {
                    unlink($uploadData['full_path']);
                    $this->session->set_flashdata(
                        'error',
                        ucfirst(str_replace('_',' ',$file)).' must be at least 100x100'
                    );
                    redirect('themeSettings');
                }

                $data[$file] = 'uploads/themes/'.$uploadData['file_name'];
            }
        }

        if (!empty($data)) {
            $this->Theme_model->save($data);
            $this->session->set_flashdata('success','Theme images saved successfully');
        }

        redirect('themeSettings');
    }
}
