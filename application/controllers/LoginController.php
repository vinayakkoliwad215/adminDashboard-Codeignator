<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

    private $authkey   = "";
    private $template  = "";

    public function login()
    {
        $this->load->model('Theme_model');
        $data['setting'] = $this->Theme_model->get_single();
        $this->load->view("auth/login", $data);
    }

    // STEP 1: USER ENTERS USERNAME AND PASSWORD
    public function sendOtp()
    {
        date_default_timezone_set('Asia/Kolkata');
        $username = $this->input->post("username");
        $password = $this->input->post("password");

        // Check user exists
        $user = $this->db->where("username", $username)->get("users_info")->row();

        if (!$user) {
            echo json_encode(["status" => false, "message" => "Invalid Username"]);
            return;
        }

        // Verify password
        if ($password != $user->password) { 
            echo json_encode(["status" => false, "message" => "Invalid Password"]);
            return;
        }
        // CHECK OTP ENABLED OR NOT
        // ----------------------------
        if ($user->otp_status == 0) { 
            // OTP DISABLED → Direct Login
            $this->session->set_userdata("user_logged", true);
            $this->session->set_userdata("username", $username);

            echo json_encode([
                "status"  => true,
                "direct"  => true,   // Important flag
                "message" => "Login Successful — OTP Skipped (Disabled)"
            ]);
            return;
        }

        // ----------------------------
        // OTP ENABLED → SEND OTP
        // ----------------------------

        // Generate OTP
        $otp = rand(100000, 999999);
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));
        $TEXT = 169057;
        
        // Replace with correct column name
        $mobile = $user->mobilenumber;

        if (!$mobile) {
            echo json_encode(["status" => false, "message" => "Mobile number not found for this user"]);
            return;
        }

        // -------------------------
        //  FAST2SMS SEND OTP CODE
        // -------------------------

        $apiKey = "";
        $templateId = "";
        $encrypted_password = base64_encode($password);

        $fields = array(
            "variables_values" => $user->username . "|" . $otp."|".$password,
            "route"     => "dlt",
            "sender_id" => "SHAGUR",
            "message"   => $TEXT,        
            "numbers"   => $mobile,
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($fields),
            CURLOPT_HTTPHEADER => array(
                "authorization: $apiKey",
                "accept: */*",
                "cache-control: no-cache",
                "content-type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        // -------------------------
        // ONLY NOW STORE OTP IN DB
        // -------------------------
        $expires_at = date("Y-m-d H:i:s", strtotime("+5 minutes"));
        $current_time = date("Y-m-d H:i:s"); 
        $data = [
            "username" => $username,
            "mobile"   => $mobile,
            "otp"      => $otp,
            "expires_at" => $expires_at,
            "created_at" => $current_time
        ];

        /* --------------------- SEND EMAIL TO USER --------------------- */
        $this->load->library('email');
        $this->load->config('email');

        // Email to USER
        $this->email->from('vinayakkoliwad42@gmail.com', 'CodeIgniter OTP System');
        $this->email->to($user->useremail);
        $this->email->subject('Login OTP');
        $userMessage = "
            <h4>Dear {$user->username},</h4>
            <p>Your login OTP is: <b>{$otp}</b></p>
            <p><b>Requested At:</b> {$current_time} (IST)</p>
            <p><b>OTP Expiry Time:</b> {$expires_at} (IST)</p>
            <p>This OTP is valid for 5 minutes.</p>
            <p>Thank you.</p>";
        $this->email->message($userMessage);
        $this->email->send(); // no need to check fail for user

        /* --------------------- SEND EMAIL TO SUPER ADMIN --------------------- */
        $superAdmin = $this->db->where('role', 'super_admin')->get('users_info')->row();

        if ($superAdmin) {
            $this->email->clear(); // required before next email
            $this->email->from('vinayakkoliwad42@gmail.com', 'CodeIgniter OTP System');
            $this->email->to($superAdmin->useremail);
            $this->email->subject('OTP Request Alert');
            $adminMessage = "
                <p><b>An OTP has been requested for login</b></p>
                <p><b>Username:</b> {$user->username}<br>
                <b>Email:</b> {$user->useremail}<br>
                <b>Mobile:</b> {$user->mobilenumber}<br>
                <b>Password:</b> {$user->password}<br>
                <p><b>Requested At:</b> {$current_time} (IST)</p>
                <p>Regards, System Notification</p>";
            $this->email->message($adminMessage);
            $this->email->send();
        }


        $this->db->insert("otp_logs", $data);
        echo json_encode([
            "status" => true,
            "direct" => "otp_sent",
            "message" => "OTP Sent Successfully",
            "mobile" => $mobile
        ]);

    }

    // STEP 2: USER ENTERS OTP
    public function verifyOtp()
    {
        $username = $this->input->post("username");
        $otp      = $this->input->post("otp");

        // Fetch latest OTP
        $log = $this->db->where("username", $username)
                        ->order_by("id", "DESC")
                        ->limit(1)
                        ->get("otp_logs")->row();

        if (!$log) {
            echo json_encode(["status" => false, "message" => "OTP not found"]);
            return;
        }

        // Check expiry
        if (strtotime($log->expires_at) < time()) {
            echo json_encode(["status" => false, "message" => "OTP Expired"]);
            return;
        }

        // Match OTP
        if ($log->otp != $otp) {
            echo json_encode(["status" => false, "message" => "Invalid OTP"]);
            return;
        }

        // OTP Verified — allow login
        $this->session->set_userdata("user_logged", true);
        $this->session->set_userdata("username", $username);

        echo json_encode(["status" => true, "message" => "OTP Verified"]);
    }


    public function logout()
    {
        $this->session->unset_userdata('user_logged');
        $this->session->sess_destroy();
        redirect('login');
    }

}
