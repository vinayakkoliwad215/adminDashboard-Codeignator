<?php
class Payment_model extends CI_Model {

    public function getPaymentModes() {
        return $this->db->get_where('payment_modes', ['status' => 'active'])->result();
    }

    public function getPayments($payment_mode_id = null) {
        $this->db->select('user_payments.*, payment_modes.payment_mode, deposit_types.deposit_type,users_info.mobilenumber,users_info.username');
        $this->db->from('user_payments');
        $this->db->join('payment_modes', 'payment_modes.id = user_payments.payment_mode_id');
        $this->db->join('deposit_types', 'deposit_types.id = user_payments.deposit_type_id', 'left');
        $this->db->join("users_info", "users_info.id = user_payments.userid", "left");

        if (!empty($payment_mode_id)) {
            $this->db->where('user_payments.payment_mode_id', $payment_mode_id);
        }

        return $this->db->get()->result();
    }

    public function getTotalAmount($payment_mode_id = null) {
        $this->db->select_sum('security_depo');
        if (!empty($payment_mode_id)) {
            $this->db->where('payment_mode_id', $payment_mode_id);
        }
        return $this->db->get('user_payments')->row()->security_depo ?? 0;
    }
}
