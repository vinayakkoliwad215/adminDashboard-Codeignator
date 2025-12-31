<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserCredentialsController extends CI_Controller 
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Credentials_model', 'user');
        $this->load->helper('url');
        if (!$this->session->userdata('user_logged')) {
            return redirect('login');
        }
    }

    // loads view wrapped with layout
    public function index()
    {
        $data['title'] = "User Credentials";
        $data['tableName'] = "User Details List 2025-26";
        $this->load->view('template/header',$data);
        $this->load->view('template/menubar',$data);
        $this->load->view('template/sidebar',$data);
        $this->load->view('users/user_credentials', $data);
        $this->load->view('template/footer');
    }

    public function show_all()
    {
        $users = $this->user->get_all();
        $general = $this->db->get('generalsettings')->row(); // get prefix & code settings

        foreach ($users as $u) {
            if ($general && $general->prefixchecked == 1) {
                $u->display_user_id = $general->code . $u->id;  // PREFIX + USERID
            } else {
                $u->display_user_id = $u->id;
            }
        }
        header('Content-Type: application/json');
        echo json_encode($users);
    }

    public function sendSmsAndEmail()
    {
        // get general settings one row
        $general = $this->db->get('generalsettings')->row();

        // prefix rule
        $prefix = "";
        if (!empty($general) && $general->prefixchecked == 1 && !empty($general->code)) {
            $prefix = $general->code;
        }
        $numbers = $this->input->post("numbers"); // array of selected mobile numbers
        
        if (empty($numbers) || !is_array($numbers)) {
            echo json_encode(["status" => false, "message" => "No users selected"]);
            return;
        }

        // Convert array → comma string for SMS API
        $mobileString = implode(",", $numbers);

        // Fetch one record per mobile number to avoid duplicate emails
        $users = $this->db->distinct()
                        ->select("mobilenumber, useremail, username, id, password")
                        ->where_in("mobilenumber", $numbers)
                        ->group_by("mobilenumber")
                        ->get("users_info")
                        ->result();

        if (empty($users)) {
            echo json_encode(["status" => false, "message" => "No users found"]);
            return;
        }

        /* ------------------------ SEND EMAIL (once per mobile number) -------------------------- */
        $this->load->library('email');
        $this->load->config('email');

        foreach ($users as $user) {
            $this->email->from('vinayakkoliwad42@gmail.com', 'CodeIgniter Project');
            $this->email->to($user->useremail);
            $this->email->subject('Login Credentials');
            $message = "
                <h4>Dear: Mr. {$user->username},</h4>
                <p>Your login credentials are:</p>
                <p><b>User ID:</b> {$prefix}{$user->id}</p>
                <p><b>Username:</b> {$user->username}</p>
                <p><b>Password:</b> {$user->password}</p>
                <br><p>Thank you.</p>";
            $this->email->message($message);
            // send email
            $status = $this->email->send() ? 'sent' : 'failed';

            // INSERT LOG
            $data = [
                'user_id'   => $user->id,
                'username'  => $user->username,
                'email'     => $user->useremail,
                'subject'   => 'Login Credentials',
                'message'   => $message,
                'status'    => $status,
            ];
            $this->db->insert('login_email_logs', $data);

            /* ---------------- SUPER ADMIN EMAIL (role-based) ---------------- */
            $superAdmin = $this->db->where('role', 'super_admin')->get('users_info')->row();
            if ($superAdmin) {
                // --- SUPER ADMIN EMAIL ---
                $this->email->clear(); // 🔥 VERY IMPORTANT (clear before next email)
                $this->email->from('vinayakkoliwad42@gmail.com', 'CodeIgniter Project');
                $this->email->to($superAdmin->useremail);
                $this->email->subject('Credentials Sent Notification');
                $adminMessage = "
                    <p>Credentials have been sent to:</p>
                    <p><b>Name:</b> {$user->username}<br>
                    <b>Email:</b> {$user->useremail}<br>
                    <b>User ID:</b> {$prefix}{$user->id}</p><br/>
                    <b>Password:</b>{$prefix}{$user->password}</p>
                    <p>Regards,<br>CodeIgniter Project</p>";
                $this->email->message($adminMessage);
                $adminEmailStatus = $this->email->send() ? 'sent' : 'failed';

                // Log admin email
                $this->db->insert('login_email_logs', [
                    'user_id'   => $superAdmin->id,
                    'username'  => $superAdmin->username,
                    'email'     => $superAdmin->useremail,
                    'subject'   => 'Credentials Sent Notification',
                    'role'      => 1,
                    'message'   => $adminMessage,
                    'status'    => $adminEmailStatus,
                ]);
            }
        }

        /* ------------------------ SEND SMS -------------------------- */
        $apiKey = "sqMM2Pvm7rz0antD1Fj4yg2HxunyvRK61ghKqHwbm5t82R1wK5rEt4uG2eAB";
        $templateId = 169057;  // DLT Template ID

        foreach ($users as $user) {

            $smsData = array(
                "variables_values" => $user->username . "|" . $prefix . $user->id . "|" . $user->password,
                "route"     => "dlt",
                "sender_id" => "SHAGUR",
                "message"   => $templateId,
                "numbers"   => $user->mobilenumber
            );

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://www.fast2sms.com/dev/bulkV2",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($smsData),
                CURLOPT_HTTPHEADER => array(
                    "authorization: $apiKey",
                    "content-type: application/json"
                ),
            ));
            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);

            file_put_contents('sms_log.txt', $response . "\n\n", FILE_APPEND); 
            // Determine success or failure
            $status = ($error == "") ? "success" : "failed";
            //$message_body = "Dear ".$user->username.", your login id is ".$user->id." and password is ".$user->password." -SHAALAGURU SOLUTIONS";
            $message_body = "Dear ".$user->username.", your login id is ".$prefix.$user->id." and password is ".$user->password." -SHAALAGURU SOLUTIONS";

            // Insert into SMS logs
            $data = [
                'user_id'          => $user->id,
                'username'         => $user->username,
                'mobilenumber'    => $user->mobilenumber,
                'message_data'     => json_encode($smsData),
                'response_message' => $response ? $response : $error,
                'message_body'     => $message_body,
                'status'           => $status
            ];

            $this->db->insert('login_sms_logs', $data);
            if ($error) {
                echo json_encode(["status" => false, "message" => "SMS Sending Failed"]);
            } else {
                echo json_encode(["status" => true, "message" => "SMS & Email sent successfully"]);
            }

        }
    }  
}