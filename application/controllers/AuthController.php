<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Twilio\Rest\Client; 

class AuthController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('session');
        $this->load->config('twilio'); 
    }

    // 1. Load login form
    public function index() {
        $this->load->view('login');
    }

    // 2. Send OTP
    public function send_otp() {
        $mobile = $this->input->post('mobile');

        if(!$mobile) {
            $this->session->set_flashdata('error', 'Mobile number required');
            redirect('/');
        }

        // Generate 4-digit OTP
        $otp = rand(1000, 9999);
        $expire = date("Y-m-d H:i:s", strtotime("+5 minutes"));

        // insert or update
        $this->Auth_model->save_otp($mobile, $otp, $expire);

        // --------------------------------------------------
        // TWILIO SMS SENDING CODE
        // --------------------------------------------------

        require_once APPPATH . '../vendor/autoload.php';

        $sid    = $this->config->item('twilio_sid');
        $token  = $this->config->item('twilio_token');
        $twilio_number = $this->config->item('twilio_number');

        $client = new Client($sid, $token);

        try {
            $client->messages->create(
                "+91".$mobile, // Send to India
                [
                    "from" => $twilio_number,
                    "body" => "Your Login OTP is: $otp"
                ]
            );
        } catch (Exception $e) {
            echo "Error sending SMS: " . $e->getMessage();
            exit;
        }

        // --------------------------------------------------

        // save in session
        $this->session->set_userdata('mobile', $mobile);

        // show OTP page
        $data['mobile'] = $mobile;
        $this->load->view('verify_otp', $data);
    }

    // 3. Verify OTP
    public function verify_otp() {
        $mobile = $this->input->post('mobile');
        $otp = $this->input->post('otp');

        $result = $this->Auth_model->verify_otp($mobile, $otp);

        if($result) {
            $this->session->set_userdata('logged_in', true);
            redirect('products');
        } else {
            $this->session->set_flashdata('error', 'Invalid or expired OTP');
            redirect('auth');
        }
    }

    // 4. Dashboard Page
    public function dashboard() {
        if(!$this->session->userdata('logged_in')) {
            redirect('/');
        }

        $this->load->view('dashboard');
    }

    // 5. Logout
    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }
}
