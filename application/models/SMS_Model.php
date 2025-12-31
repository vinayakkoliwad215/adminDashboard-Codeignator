<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SMS_Model extends CI_Model {

    private $table = 'login_sms_logs';

    public function get_all()
    {
        return $this->db->where('message_body IS NOT NULL', null, false)->get($this->table)->result();
    }

    public function get($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }
}
