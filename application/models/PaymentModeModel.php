<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PaymentModeModel extends CI_Model {

    protected $table = 'payment_modes';

    public function getAll() {
        return $this->db->get($this->table)->result();
    }

    public function getAllPaymentModes() {
        return $this->db->get($this->table)->result();
    }
    public function store() {
        $data = [
            'payment_mode' => $this->input->post('payment_mode'),
            'status' => $this->input->post('status'),
            'created_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->insert($this->table, $data);
    }

    public function get($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function update($id) {
         $data = [
            'payment_mode' => $this->input->post('payment_mode'),
            'status' => $this->input->post('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        return $this->db->where('id', $id)->update($this->table, $data);
        
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }
}