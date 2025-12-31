<?php
class ClientPaymentModel extends CI_Model {

    protected $table = 'client_payments';

    public function get_all()
    {
       return $this->db->get()->result();
    }

    public function storePayment($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function payment_all()
    {
        $mode = $this->input->get("mode");
        $from = $this->input->get("from");
        $to = $this->input->get("to");

        $this->db->select("
            cp.*,
            c.name,
            c.phone,
            c.email,
            pm.id AS payment_mode_id,
            pm.payment_mode AS payment_mode_name,
            dt.deposit_type AS depositType,
            COALESCE((
                SELECT SUM(cp2.security_depo)
                FROM client_payments AS cp2
                WHERE cp2.clientid = cp.clientid
            ), 0) AS total_deposit,
            COALESCE((
                SELECT SUM(cp3.security_depo)
                FROM client_payments AS cp3
                WHERE cp3.clientid = cp.clientid
                AND cp3.payment_mode_id = cp.payment_mode_id
            ), 0) AS total_deposit_mode
        ");
        $this->db->from("client_payments cp");
        $this->db->join("clients c", "c.id = cp.clientid", "left");
        $this->db->join("payment_modes pm", "pm.id = cp.payment_mode_id", "left");
        $this->db->join("deposit_types dt","dt.id = cp.deposit_type_id","left");

                // payment mode
        if (!empty($mode)) {
            $this->db->where("cp.payment_mode_id", $mode);
        }

        // date
        if (!empty($from)) {
            $this->db->where("cp.paymentDate >=", $from);
        }
        if (!empty($to)) {
            $this->db->where("cp.paymentDate <=", $to);
        }
        $this->db->order_by("cp.id", "DESC");

        $result = $this->db->get()->result();

        // return json (controller should echo json or return in CI response)
        return $result;
    }

    public function getPaymentsByUser($userid)
    {
        $this->db->select('user_payments.*, payment_modes.payment_mode, users_info.username');
        $this->db->from($this->table);
        $this->db->join('payment_modes', 'payment_modes.id = user_payments.payment_mode');
        $this->db->join('users_info', 'users_info.id = user_payments.userid');
        $this->db->where('user_payments.userid', $userid);
        return $this->db->get()->result();
    }

    public function get_user($clientid)
    {
        return $this->db->get_where("clients", ["id" => $clientid])->row();
    }

    public function get_user_transactions($clientid)
    {
        $this->db->select("
            cp.id,
            cp.paymentDate,
            cp.security_depo,
            pm.payment_mode AS payment_mode_name,
            dt.deposit_type AS depositType"
        );
        $this->db->from("client_payments cp");
        $this->db->join("payment_modes pm", "pm.id = cp.payment_mode_id", "left");
        $this->db->join("deposit_types dt", "dt.id = cp.deposit_type_id", "left");
        $this->db->where("cp.clientid", $clientid);
        $this->db->order_by("cp.id", "ASC");
        return $this->db->get()->result();
    }

    public function get_total_deposit($clientid)
    {
        return $this->db->select_sum("security_depo")
                ->from("client_payments")
                ->where("clientid", $clientid)
                ->get()->row()->security_depo ?? 0;
    }

    public function get_datatable_data($start, $length, $search)
{
    $this->db->select("
        up.*,
        u.username,
        u.mobilenumber,
        pm.payment_mode AS payment_mode_name,
        dt.deposit_type AS depositType,
        (
            SELECT SUM(security_depo)
            FROM user_payments up2
            WHERE up2.userid = up.userid
        ) AS total_deposit
    ");
    $this->db->from("user_payments up");
    $this->db->join("users_info u", "u.id = up.userid", "left");
    $this->db->join("payment_modes pm", "pm.id = up.payment_mode_id", "left");
    $this->db->join("deposit_types dt","dt.id = up.deposit_type_id","left");

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like("u.username", $search);
        $this->db->or_like("u.mobilenumber", $search);
        $this->db->or_like("pm.payment_mode", $search);
        $this->db->or_like("dt.deposit_type", $search);
        $this->db->group_end();
    }

    $this->db->order_by("up.id", "DESC");
    $this->db->limit($length, $start);
    return $this->db->get()->result();
}

public function count_all_transactions()
{
    return $this->db->count_all("user_payments");
}

public function count_filtered_transactions($search)
{
    $this->db->from("user_payments up");
    $this->db->join("users_info u", "u.id = up.userid", "left");
    $this->db->join("payment_modes pm", "pm.id = up.payment_mode_id", "left");
    $this->db->join("deposit_types dt","dt.id = up.deposit_type_id","left");

    if (!empty($search)) {
        $this->db->group_start();
        $this->db->like("u.username", $search);
        $this->db->or_like("u.mobilenumber", $search);
        $this->db->or_like("pm.payment_mode", $search);
        $this->db->or_like("dt.deposit_type", $search);
        $this->db->group_end();
    }

    return $this->db->count_all_results();
}

}