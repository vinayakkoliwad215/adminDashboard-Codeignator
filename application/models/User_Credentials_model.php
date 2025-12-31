<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_Credentials_model extends CI_Model {

    private $table = 'users_info';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }
}
