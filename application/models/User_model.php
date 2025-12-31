<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table = 'users_info';

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
        // Generate random password
        $password = $this->generatePassword(8);
        $date = $this->input->post("date_of_birth");
        if ($date != "" && $date != null) {
            $date_of_birth = date("Y-m-d", strtotime($date));   
        } else {
            $date_of_birth = null;
        }
        
        //Branch IDS
        $branch_ids = $this->input->post('branch_id'); // array
        $branch_ids = !empty($branch_ids) ? implode(',', $branch_ids) : null;

        $data = [
            'username'     => $this->input->post('username'),
            'mobilenumber' => $this->input->post('mobilenumber'),
            'useremail'    => $this->input->post('useremail'),
            'password'     => $password,
            'date_of_birth' => $date_of_birth,
            'branch_ids'    => $branch_ids,
            'status'       => $this->input->post('status'),
            'created_at'   => date('Y-m-d H:i:s')
        ];
        $this->db->insert($this->table, $data);
            // return password so controller can send in SMS / Email
        return $password;

    }

    public function update($id)
    {
        $date = $this->input->post("date_of_birth");
        
        if (!empty($date)) {
        $date_of_birth = date("Y-m-d", strtotime($date));
        } else {
            $date_of_birth = null;
        }

        //Branch IDs
        $branch_ids = $this->input->post('branch_id');
        $branch_ids = !empty($branch_ids) ? implode(',', $branch_ids) : null;
        $data = [
            'username'     => $this->input->post('username'),
            'mobilenumber' => $this->input->post('mobilenumber'),
            'useremail'    => $this->input->post('useremail'),
            'date_of_birth' => $date_of_birth,
            'branch_ids'     => $branch_ids,
            'status'       => $this->input->post('status'),
            'updated_at'   => date('Y-m-d')
        ];

        if ($this->input->post('password') != "") {
            $data['password'] = $this->input->post('password');
        }

        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    //Generate the Random Password
    private function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$%&';
        return substr(str_shuffle($chars), 0, $length);
    }

    public function updateOtpStatus($id, $otp_status)
    {
        $this->db->where('id', $id);
        return $this->db->update('users_info', ['otp_status' => $otp_status]);
    }

    public function get_all_users_with_branches()
    {
        $this->db->select("
            u.*,
            GROUP_CONCAT(b.name SEPARATOR ', ') AS branch_names
        ");
        $this->db->from('users_info u');
        $this->db->join(
            'branches b',
            'FIND_IN_SET(b.id, u.branch_ids)',
            'left'
        );
        $this->db->group_by('u.id');

        return $this->db->get()->result();
    }
}