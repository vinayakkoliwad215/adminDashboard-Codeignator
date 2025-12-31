<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserPaymentController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserPaymentModel','transactions');
        $this->load->model('User_model', 'user');
        $this->load->model('DepositTypeModel','depositTypes');
        if (!$this->session->userdata('user_logged')) {
            return redirect('login');
        }
    }

    // loads view wrapped with layout
    public function index()
    {
        $data['title'] = "User Payment Transaction Details List 2025-26";
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('payments/payment_transactions', $data);
        $this->load->view('layouts/footer',['custom_js' => 'assets/js/payment_transactions.js']);
    }

    //User Transactions routes
    public function userTransactions()
    {
        $data['title'] = "User Transactions";
        $data['tableName'] = "User Payment Transaction Details List 2025-26";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('payments/user_payments', $data);
        $this->load->view('template/footer');
    }
    public function store()
    {
        $data = array(
            'userid'        => $this->input->post('userid'),
            'payment_mode_id'  => $this->input->post('payment_mode_id'),
            'deposit_type_id'  => $this->input->post('deposit_type_id'),
            'paymentDate'   => $this->input->post('paymentDate'),
            'security_depo' => $this->input->post('security_depo'),
            'note' => $this->input->post('note'),
        );

        if ($this->transactions->storePayment($data)) {
            echo json_encode(['status' => true, 'message' => 'Payment added successfully']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Failed to add payment']);
        }
    }

    public function show($userid)
    {
        $payments = $this->UserPaymentModel->getPaymentsByUser($userid);
        echo json_encode($payments);
    }
    
    public function show_all()
    {
        $transactions = $this->transactions->payment_all();
        header('Content-Type: application/json');
        echo json_encode($transactions);
    }

    public function loadUsers() {
        $data = $this->user->get_all();   // return id + username
        echo json_encode($data);
    }

    public function loadDepositTypes() {
        $data = $this->depositTypes->getAllDepositTypes();   // return id + username
        echo json_encode($data);
    }

    public function receipt_view($userid)
    {
        $data['user'] = $this->transactions->get_user($userid);
        $data['transactions'] = $this->transactions->get_user_transactions($userid);
        $data['total'] = $this->transactions->get_total_deposit($userid);

        if (!$data['user']) show_404();

        $this->load->view('payments/receipt_pdf_view', $data);
    }

    public function download_receipt($userid)
    {
        $data['user'] = $this->transactions->get_user($userid);
        $data['transactions'] = $this->transactions->get_user_transactions($userid);
        $data['total'] = $this->transactions->get_total_deposit($userid);

        if (!$data['user']) show_404();

        $html = $this->load->view('payments/receipt_pdf_view', $data, TRUE);

        $options = new Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf\Dompdf($options);

        $options = new Dompdf\Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("Receipt_".$userid.".pdf", array("Attachment" => true));
    }

    //view payment transaction
    public function getUserTransactions($userid)
    {
        $data = $this->db->select("
                    up.*,u.username,
                        u.mobilenumber,
                        u.useremail, pm.payment_mode, dt.deposit_type
                ")
                ->from("user_payments up")
                ->join("users_info u", "u.id = up.userid", "left")
                ->join("payment_modes pm", "pm.id = up.payment_mode_id", "left")
                ->join("deposit_types dt", "dt.id = up.deposit_type_id", "left")
                ->where("up.userid", $userid)
                ->order_by("up.id", "DESC")
                ->get()
                ->result();

        echo json_encode($data);
    }

    public function transation_show_all()
    {
        $draw   = intval($this->input->post("draw"));
        $start  = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));

        // FIX: search should not produce Notice on NULL
        $searchInput = $this->input->post("search");
        $search = isset($searchInput['value']) ? $searchInput['value'] : "";

        $transactions = $this->transactions->get_datatable_data($start, $length, $search);
        $totalRecords = $this->transactions->count_all_transactions();
        $filteredRecords = $this->transactions->count_filtered_transactions($search);

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $filteredRecords,
            "data" => $transactions
        ]);
    }
}