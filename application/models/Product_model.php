<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    private $table = 'products';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }

    public function store()
    {
        $data = [
            'name'        => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price'       => $this->input->post('price'),
            'status'      => $this->input->post('status'),
            'created_at'  => date('Y-m-d H:i:s')
        ];
        return $this->db->insert($this->table, $data);
    }

    public function update($id)
    {
        $data = [
            'name'        => $this->input->post('name'),
            'description' => $this->input->post('description'),
            'price'       => $this->input->post('price'),
            'status'      => $this->input->post('status'),
            'updated_at'  => date('Y-m-d H:i:s')
        ];
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
