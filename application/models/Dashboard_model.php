<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    // Count Products
    public function count_products() {
        return $this->db->count_all('products');
    }

    // Count Users
    public function count_users() {
        return $this->db->count_all('users_info');
    }

    // Count Payments
    public function count_payments() {
        return $this->db->count_all('user_payments');
    }

    //client Payment counts
     public function count_clientTransactions() {
        return $this->db->count_all('client_payments');
    }
    

    // Count OTP Logs
    public function count_otp_logs() {
        return $this->db->count_all('otp_logs');
    }

    //Total Amount of security depo
    public function totalDepositAmount()
    {
        $this->db->select('ROUND(SUM(security_depo)) AS total');
        $query = $this->db->get('user_payments');
        $result = $query->row();
        
        return (int) $result->total;
    }

    //Total Amount of security depo of Client Payments
    public function totalDepositAmountClient()
    {
        $this->db->select('ROUND(SUM(security_depo)) AS total');
        $query = $this->db->get('client_payments');
        $result = $query->row();

        return (int) $result->total;
    }

    //Login credential sent the through sms
    public function totalSmsLogs()
    {
        return $this->db->count_all('login_sms_logs'); // or otp_logs table
    }

    // Count Branches
    public function count_branches() {
        return $this->db->count_all('branches');
    }

    // Count Clients
    public function count_clients() {
        return $this->db->count_all('clients');
    }

}
