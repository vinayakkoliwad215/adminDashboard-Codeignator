<?php
class Auth_model extends CI_Model {

    // Save OTP
    public function save_otp($mobile, $otp, $expire) {
        $exists = $this->db->get_where('users', ['mobile' => $mobile])->row();

        $data = [
            'mobile' => $mobile,
            'otp' => $otp,
            'otp_expire' => $expire
        ];

        if ($exists) {
            $this->db->where('mobile', $mobile);
            return $this->db->update('users', $data);
        } else {
            return $this->db->insert('users', $data);
        }
    }

    // Verify OTP
    public function verify_otp($mobile, $otp) {
        $this->db->where('mobile', $mobile);
        $this->db->where('otp', $otp);
        $this->db->where('otp_expire >=', date("Y-m-d H:i:s"));

        return $this->db->get('users')->row();
    }
}
