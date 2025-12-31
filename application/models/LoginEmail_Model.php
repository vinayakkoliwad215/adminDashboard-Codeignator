<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginEmail_Model extends CI_Model {

    private $table = 'login_email_logs';

    public function get_all()
    {
        return $this->db->get($this->table)->result();
    }

    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }
}
