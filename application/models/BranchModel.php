<?php
class BranchModel extends CI_Model {

    public function getAll() {
        return $this->db->get('branches')->result();
    }

    public function insert($data) {
        return $this->db->insert('branches', $data);
    }

    public function getById($id) {
        return $this->db->where('id', $id)->get('branches')->row();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('branches', $data);
    }
    public function delete($id) {
        $this->db->where('id',$id);
        return $this->db->delete('branches');
    }

}
