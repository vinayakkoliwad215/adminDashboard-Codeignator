<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ClientTransactionController extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClientPaymentModel','ClientTransactions');
        $this->load->model('Client_model', 'clients');
        $this->load->model('DepositTypeModel','depositTypes');
        if (!$this->session->userdata('user_logged')) {
            return redirect('login');
        }
    }

    // loads view wrapped with layout
    public function index()
    {
        $data['title'] = "Client Transactions";
        $data['tableName'] = "Client Payment Transaction Details List 2025-26";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('payments/client_payments', $data);
        $this->load->view('template/footer');
    }
    public function store()
    {   
        $data = array(
            'clientid'        => $this->input->post('client_id'),
            'payment_mode_id'  => $this->input->post('payment_mode_id'),
            'deposit_type_id'  => $this->input->post('deposit_type_id'),
            'paymentDate'   => $this->input->post('paymentDate'),
            'security_depo' => $this->input->post('security_depo'),
            'note' => $this->input->post('note'),
        );
    
        if ($this->ClientTransactions->storePayment($data)) {
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
    
    public function client_transactions()
    {
        $transactions = $this->ClientTransactions->payment_all();
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

    public function download_receipt($clientid)
    {
        $data['client'] = $this->ClientTransactions->get_user($clientid);
        $data['transactions'] = $this->ClientTransactions->get_user_transactions($clientid);
        $data['total'] = $this->ClientTransactions->get_total_deposit($clientid);

        if (!$data['client']) show_404();

        $html = $this->load->view('payments/receipt_client_pdf', $data, TRUE);

        $options = new Dompdf\Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf\Dompdf($options);

        $options = new Dompdf\Options();
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf\Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->render();
        $dompdf->stream("Receipt_".$clientid.".pdf", array("Attachment" => true));
    }

    //view payment transaction
    public function getClientTransactions($clientid)
    {
        $data = $this->db->select("
                    cp.*,c.name,
                        c.phone,
                        c.email, pm.payment_mode, dt.deposit_type
                ")
                ->from("client_payments cp")
                ->join("clients c", "c.id = cp.clientid", "left")
                ->join("payment_modes pm", "pm.id = cp.payment_mode_id", "left")
                ->join("deposit_types dt", "dt.id = cp.deposit_type_id", "left")
                ->where("cp.clientid", $clientid)
                ->order_by("cp.id", "DESC")
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

    public function loadClients() {
        $data = $this->clients->getAll();   // return id + username
        echo json_encode($data);
    }
}