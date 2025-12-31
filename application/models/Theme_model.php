<?php
class Theme_model extends CI_Model {

    private $table = 'themes';

    public function get_single()
    {
        return $this->db->get($this->table)->row();
    }

    public function save($data)
    {
        $row = $this->get_single();

        if ($row) {
            $this->db->where('id', $row->id);
            $this->db->update($this->table, $data);
            return $this->db->update($this->table, $data);
        } else {
            $data['theme_name'] = 'Login Images';
            return $this->db->insert($this->table, $data);
        }
    }
}

