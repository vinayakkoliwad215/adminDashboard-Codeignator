<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Client_model extends CI_Model {

    protected $table = 'clients';

    public function getAll() {
        return $this->db->get($this->table)->result();
    }

    public function autoSave($data)
    {
        if(!empty($data['id'])) {
            $this->db->where('id', $data['id']);
            $this->db->update('clients', $data);
            return $data['id'];
        } else {
            $this->db->insert('clients', $data);
            return $this->db->insert_id();
        }
    }

    public function getClients($id)
    {
        return $this->db->where('id', $id)->get('clients')->row();
    }

    public function getById($id) {
        return $this->db->get_where('clients', ['id' => $id])->row();
    }

    public function updateClient($id, $data) {
        $this->db->where('id',$id);
        return $this->db->update('clients',$data);
    }

    public function deleteClient($id) {
        $this->db->where('id',$id);
        return $this->db->delete('clients');
    }
}
