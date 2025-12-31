<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FilterController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Payment_model');
    }

    public function index() {
        $data['title'] = "Payment Modes";
        $data['payment_modes'] = $this->Payment_model->getPaymentModes();
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('filter_view', $data);
        $this->load->view('layouts/footer',['custom_js' => 'assets/js/filterPayment.js']);
    }

    public function getPayments() 
    {
        $payment_mode_id = $this->input->post('payment_mode_id');

        $payments = $this->Payment_model->getPayments($payment_mode_id);
        $total = $this->Payment_model->getTotalAmount($payment_mode_id);

        // Fetch all totals for payment mode buttons
        $paymentModes = $this->Payment_model->getPaymentModes();
        $buttonTotals = [];
        foreach ($paymentModes as $pm) {
            $buttonTotals[] = [
                'id' => $pm->id,
                'payment_mode' => $pm->payment_mode,
                'total' => number_format($this->Payment_model->getTotalAmount($pm->id), 2)
            ];
        }

        echo json_encode([
            'payments' => $payments,
            'total' => number_format($total, 2),
            'buttonTotals' => $buttonTotals
        ]);
    }
}