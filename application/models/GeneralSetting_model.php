<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GeneralSetting_model extends CI_Model {

    private $table = "generalsettings";

    public function getAll() {
        return $this->db->get($this->table)->result();
    }

    // public function getById($id) {
    //     return $this->db->get_where($this->table, ['id' => $id])->row();
    // }
    public function getFirst() {
        return $this->db->get($this->table)->row();
    }

    public function store($id = null) {
        $data = [
            'name'          => $this->input->post('name'),
            'code'          => $this->input->post('code'),
            'mobilenumber'  => $this->input->post('mobilenumber'),
            'address'       => $this->input->post('address'),
            'city'          => $this->input->post('city'),
            'prefixchecked' => $this->input->post('prefixchecked') ? 1 : 0,
            'currency'      => $this->input->post('currency')
        ];
        if ($id == "") {
            $this->db->insert($this->table, $data);   // CREATE
            $msg = "General Setting Created Successfully";
        } else {
            $this->db->update($this->table, $data, ['id' => $id]);  // UPDATE
            $msg = "General Setting Updated Successfully";
        }
        $this->session->set_flashdata('success', $msg);
    }

    // public function update($id) {
    //     $data = [
    //         'name'          => $this->input->post('name'),
    //         'code'          => $this->input->post('code'),
    //         'mobilenumber'  => $this->input->post('mobilenumber'),
    //         'address'       => $this->input->post('address'),
    //         'city'          => $this->input->post('city'),
    //         'prefixchecked' => $this->input->post('prefixchecked') ? 1 : 0,
    //         'currency'      => $this->input->post('currency')
    //     ];
    //     return $this->db->update($this->table, $data, ['id' => $id]);
    // }
}
