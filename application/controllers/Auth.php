<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model(['auth_model', 'payment_model']);
		$this->load->library('phpmailer_lib');
	}

	public function index()
	{
		if (!$this->session->userdata('loginStatus')) {
			$url = "auth/login";
		} else {
			if ($this->session->userdata('user_type') == 'STAFF') {
				$url = "staff/index";
			} elseif ($this->session->userdata('user_type') == 'STUDENT') {
				$url = "student/index";
			} else {
				$url = "auth/logout";
			}
		}
		$url = "auth/login";
		redirect($url, 'refresh');
	}

	public function login()
	{
	
	   // die;
	    //echo hash('sha512', '1410206014'); die;
		$this->session->set_userdata('pageTitle', 'Please Login .::. FUBK-University Portal');
		return $this->load->view('login');
	}

	public function acceptance()
	{
		$this->session->set_userdata('pageTitle', 'Acceptance Fee .::. FUBK-University Portal');
		return $this->load->view('acceptance');
		//	$this->session->set_flashdata('msg', "Sorry, This  page is under construction, please check back later");
		//	redirect("auth/login", "referesh");
	}

	public function graduation()
	{
		$this->session->set_userdata('pageTitle', 'Graduation Gown/Order of Proceeding .::. FUBK-University Portal');
		return $this->load->view('graduation');
		//	$this->session->set_flashdata('msg', "Sorry, This  page is under construction, please check back later");
		//	redirect("auth/login", "referesh");
	}
	
	public function authenticate()
	{
		try{
    		$secretKey = "6Lc-pgseAAAAAFwC1zhb-009eLUfx2balnWnfoSp";
    		$token = trim($this->input->post('g-token'));
    		$ip = $this->input->ip_address();
    		$url = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $token . "&remoteip=" . $ip;
    		$verification = json_decode(file_get_contents($url));
    		
    		$username = trim($this->input->post('username'));
            $parts = explode(":", $username);
    		
    		if (isset($verification->success) && $verification->success == true) {
                
    			$data = [
    				'username' => $parts[0],
    				'password' => hash('sha512', trim($this->input->post('password')))
    			];
    			
    			$attemptmode = "self";
    
    			$result = $this->auth_model->authenticate($data);
    			if ($result) {
    			    
    			    $count = $this->auth_model->checkMultipleLogin($parts[0]);
    			    
    			    if($count != 0){
    			        $this->auth_model->setSecurityTokens($parts[0], $attemptmode, "fail", $username,  "MULTIPLE_LOGIN");
    			        $_SESSION['msg2'] = 'Multiple Logins detected on your account. This has been reported to the MIS';
    			        
    			    }
    			    
    			    if (count($parts) > 1){
    			        $attemptmode = "proxy";
                        if($result->type != "STAFF"){
                            $this->auth_model->setSecurityTokens($parts[0], $attemptmode, "fail", $username,  "UNAUTHORIZED_PROXY_LOGIN");
                            $this->session->set_flashdata('msg', 'This action is not authorized');
    				        return redirect('auth/login', 'refresh');
                        }
                        $result = $this->auth_model->getUser(['uniqueID' => $parts[1]]);
                        if(!$result){
                            $this->auth_model->setSecurityTokens($parts[0], $attemptmode, "fail", $username, "INVALID_USER_PROXY_LOGIN");
                            $this->session->set_flashdata('msg', 'Proxy login failed for this user');
    				        return redirect('auth/login', 'refresh');
                        }
                        
                    }
    				$activeSession = $this->auth_model->getActiveSession();
    				$activeSemester = $this->auth_model->getActiveSemester();
    				
    				$settings = $this->auth_model->getActiveSettings($activeSession->session);
    				//settings management
    				$activeSettingsManager = [];
    				foreach($settings as $key => $value){
    				    if('active' == $value->status){
        				    $activeSettingsManager[$value->setting] = [
        				        'id' => $value->id,
        				        'value' => $value->value,
        				        'session' => $value->session,
        				        'start_date' => $value->start_date,
        				        'end_date' => $value->end_date,
        				        'status' => $value->status
        				    ];
    				    }
    				}
    				//var_dump($result); die;
                    $_SESSION['loginStatus'] = true;
    				$this->session->set_userdata('loginStatus', true);
    				$this->session->set_userdata('username', $result->username);
    				$this->session->set_userdata('uniqueID', $result->uniqueID);
    				$this->session->set_userdata('userid',  $result->userid);
    				$this->session->set_userdata('ACL', $result->ACL_ID);
    				$this->session->set_userdata('user_type', $result->type);
    				$this->session->set_userdata('user_hash', $result->user_hash);
    				$this->session->set_userdata('theme_mode', '  offcanvas-active ');
    				$this->session->set_userdata('schoolName', "Central University Portal - FUBK");
    				$this->session->set_userdata('shortName', "FUBK Portal");
    				$this->session->set_userdata('last_activity', $_SERVER['REQUEST_TIME']);
    				$this->session->set_userdata('active_session', $activeSettingsManager['SESSION']['value']);
    				$this->session->set_userdata('active_session_id', $activeSettingsManager['SESSION']['id']);
    				$this->session->set_userdata('active_semester', $activeSettingsManager['SEMESTER']['id']);
    				$this->session->set_userdata('active_semester_value', $activeSettingsManager['SEMESTER']['value']);
    				$this->session->set_userdata('activeSettingsManager', $activeSettingsManager);
    				
    				if($result->type == "SBS"){
    				    $this->session->set_userdata('active_session', "2023/2024");
        				$this->session->set_userdata('active_session_id', 73);
        				$this->session->set_userdata('active_semester', 74);
        				$this->session->set_userdata('active_semester_value', "First");
        				
        				$this->session->set_userdata('course_reg_close_date', "2023-10-01");
        				$this->session->set_userdata('ecard_ready_date', "2023-10-01");
        				$this->session->set_userdata('add_drop_deadline', "2023-02-08" >= date("2023-07-19"));
    				}
    				
    				//var_dump($_SESSION); die;
    
    				$url = 'auth/logout';
    				$msg = 'Something went wrong. Please contact us via mis@fubk.edu.ng';
    
    				$ACL_ID = $result->ACL_ID; 
    
    				if (!$ACL_ID) {
    				    $this->auth_model->setSecurityTokens($parts[0], $attemptmode, "fail", $username, "INVALID_ACLID");
    					$this->session->set_flashdata('msg', $msg);
    				} else {
    					$msg = 'Login Successful, Welcome';
    					
    					//de-activate previous logins and start a fresh session.
                        $this->auth_model->setSecurityTokens($parts[0], $attemptmode, "pass", $username, "LOGIN_SUCCESS");
                        
    					if ($ACL_ID >= 1 and $ACL_ID <= 2) {
    					    
    					    if($result->status == "inactive"){
    					        $this->auth_model->setSecurityTokens($parts[0], $attemptmode, "fail", $username, "INACTIVE_ACCOUNT");
    					        $this->session->set_flashdata('msg', 'Account is Blocked. Please contact the MIS');
    					        return redirect('auth/logout', 'refresh');
    					    }
    					    $paymentStatus = $this->payment_model->paymentCurrentSession($this->session->userdata('userid')) ;
    					    $this->session->set_userdata('tuition_payment_status', $paymentStatus ? $paymentStatus->status : "Pending");
    						$url = 'student/index';
    					} elseif ($ACL_ID >= 4) {
    						$url = 'staff/index';
    					} elseif ($ACL_ID >= 13) {
    						$url = 'management/index';
    					} else {
    						$url = 'auth/logout';
    					}
    					$this->session->set_flashdata('msg', $msg);
    				
    					$this->session->set_userdata('home_url', $url);
    				
    				}
    				//echo $url; die;
    				return redirect($url, 'refresh');
    			} else {
    			    $this->auth_model->setSecurityTokens($parts[0], $attemptmode, "fail", $username, "INVALID_CREDENTIALS");
    				$this->session->set_flashdata('msg', 'Invalid Username/Password');
    				return redirect('auth/login', 'refresh');
    			}
    		}else{
    		    $this->auth_model->setSecurityTokens($parts[0], "self", "fail", $username, "INVALID_GOOGLE_CAPTCHA");
    			$this->session->set_flashdata('msg', 'Security Captcha Failed. Please try again');
    			return redirect('auth/login', 'refresh');
    		}
		}catch(Exception $e){
		    $this->auth_model->setSecurityTokens("ERROR", NULL, "fail", "ERROR", $e->getMessage());
		    $this->session->set_flashdata('msg', 'Something went wrong. Please try again');
    		return redirect('auth/login', 'refresh');
		}
	}


	public function lock_screen()
	{
		if ($this->session->userdata('username')) {
			redirect('auth/logout', 'refresh');
		}
		$this->session->set_userdata('pageTitle', 'Lock Screen .::. FUBK-University Portal');
		$data = [];
		return $this->load->view('lock', $data);
	}

	public function reset()
	{
		$this->session->set_userdata('pageTitle', 'Reset Password .::. FUBK-University Portal');
		return $this->load->view('reset');
	}

	public function activate()
	{
		return $this->load->view('activate');
	}

	public function resetPassword()
	{
		$hash = $this->uri->segment(3);
		$user = $this->auth_model->getUser(['password_reset_hash' => $hash]);

		if ($user) {
			$this->session->set_userdata('resetUserID', $user->username);
			$this->session->set_flashdata('msg', 'Please provide a secure password below');
			return $this->load->view('change_password', ['resetHash' => $hash]);
		} else {
			$this->session->set_flashdata('msg', 'Invalid Request Link. Please Try Again');
			return redirect('auth/login', 'refresh');
		}
	}

	public function changepass()
	{
		$hash = $this->input->post('resetHash');
		$password = $this->input->post('password');
		$cpassword = $this->input->post('cpassword');

		if ($password != $cpassword) {
			$this->session->set_flashdata('msg', 'Password Mismatch. Please Try Again');
			return $this->load->view('change_password', ['resetHash' => $hash]);
		} else {
			$data = [
				'username' => $this->session->userdata('resetUserID'),
				'password' => hash('sha512', $password)
			];
			$user = $this->auth_model->changeUserPassword($data);
			$this->session->set_flashdata('msg', 'Password Changed Successfully. Please Login');
			return redirect('auth/login', 'refresh');
		}
	}

	public function resspswd()
	{
		$username = $this->session->userdata('username');
		$hash = hash('sha512', $username . date('YmdHis') . rand());
		$this->auth_model->setResetHash(['reset_hash' => $hash, 'username' => $username]);
		$this->session->set_userdata('resetUserID', $username);
		return $this->load->view('change_password', ['resetHash' => $hash]);
	}

	public function resetpass()
	{
		$username = trim($this->input->post('username'));
		if (!(substr($username, strpos($username, 'fubk.edu.ng')) == "fubk.edu.ng")) {
			$this->session->set_flashdata('msg', 'Only Registred University Emails are Allowed');
			return redirect('auth/reset', 'refresh');
		}

		$hash = hash('sha512', time().$username.rand());
		$this->auth_model->setResetHash(['reset_hash' => $hash, 'username' => $username]);
		$user = $this->auth_model->getUserByEmail($username);

		if ($user) {
			$odds = array("0", "o", "O", "i", "I", "1", "C", "c", "J", 'j');

			$password = hash('sha512', date("YmdHis") . $user->username . $user->user_hash);
			$password = str_replace($odds, "", $password);
			$password = substr($password, rand(0, 8), 8);


			$msg = "<html><head><style> .myButton {
				box-shadow: 0px 10px 14px -7px #f0f0f0;
				background:linear-gradient(to bottom, #0A95FF 5%, #0A95FF 100%);
				background-color:#77b55a;
				border-radius:10px;
				border:2px solid #f0f0f0;
				display:inline-block;
				cursor:pointer;
				color:#ffffff;
				font-family:Georgia;
				font-size:16px;
				font-weight:bold;
				padding:10px 76px;
				text-decoration:none;
				text-shadow:0px 1px 0px #5b8a3c;
			}
			.myButton:hover {
				background:linear-gradient(to bottom, #72b352 5%, #77b55a 100%);
				background-color:#f0f0f0;
			}
			.myButton:active {
				position:relative;
				top:1px;
			}
			</style><body style='text-align:justify'><div style='width:800px;  margin:0 auto;'";
			$msg .= "<h4 style='text-align:center'>PRIVATE AND CONFIDENTIAL</h4><hr>";
			$msg .= "Hello,<br><br>We have received a request to reset your password. If this was not from you, immediately inform us at mis@fubk.edu.ng to secure your account.<br><br>If this was from you, kindly click below to set your new password<br><br>";
			
			$msg .= "<a class='myButton' style='color:#fff' target='_blank' href='".site_url('auth/resetPassword/'. $user->password_reset_hash)."'>Reset Password</a>.<br><br><br> ";
			
			$msg .= "Kindest regards,<br>Cloud Identity Unit<br>E: mis@fubk.edu.ng<br><br>";
			$msg .= "<p  style='color:red;'><em>PS: Disclosing your account login credentials is a serious breach of University IT security policies and could result in disciplinary procedures.</em></div><body></html>";
			try {
				$mail = $this->phpmailer_lib->initialize();
				$mail->Subject = "FUBK University Portal Password Reset";
				$mail->setFrom('noreply@fubk.edu.ng', 'FUBK Cloud ID');
				$mail->addAddress($user->username);
				$mail->Body    = $msg;
				$mail->AltBody = $msg;

				$mail->send();
				

				$data = [
					'password' => hash('sha512', $password),
					'username' => $user->username
				];
				$this->auth_model->setPassword($data);
			} catch (Exception $e) {
				log_message('error', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
			}
		}

		$this->session->set_flashdata('msg', 'If the details are correct, we have sent a reset link to your registered email address. Please check your email to proceed');
		return redirect('auth/reset', 'refresh');
	}


	public function activateacct()
	{
		$username = $this->input->post('sims_username');
		if (!(substr($username, strpos($username, '.fubk')) == ".fubk.edu.ng")) {
			$this->session->set_flashdata('msg', 'Only Registred University Emails are Allowed');
			return redirect('auth/reset', 'refresh');
		}

		$this->auth_model->setResetHash(['reset_hash' => hash('sha512', $username . date('YmdHis') . rand()), 'username' => $username]);
		$user = $this->auth_model->getUserByEmail($username);

		if ($user) {
			$odds = array("0", "o", "O", "i", "I", "1", "C", "c", "J", 'j');

			$password = hash('sha512', date("YmdHis") . $user->username . $user->user_hash);
			$password = str_replace($odds, "", $password);
			$password = substr($password, rand(0, 8), 8);


			$msg = "<h1>MIS IT Account</h1><br>";
			$msg = "<h2>PRIVATE AND CONFIDENTIAL</h2><br><br><br>";
			$msg = "Hello " . trim(ucfirst(strtolower($user->firstname))) . ",<br><br>";
			$msg .= "You have requested to activate your access to the Staff Portal. Your login details are as below: <br><br><br>";
			$msg .= "<em>Username:</em> " . $username . "<br>";
			$msg .= "<em>Password:</em> " . $password . "<br><br><br>";
			$msg .= "Visit <a target='_blank' href='https://staffportal.fubk.edu.ng'>https://staffportal.fubk.edu.ng</a> to login with these details. ";
			$msg .= "At the first opportunity, you must change your password by logging in to <a target='_blank' href='https://staffportal.fubk.edu.ng/auth/resetPassword/" . $user->password_reset_hash . "'>Password Reset</a>. ";
			$msg .= "Disclosing your network account login and password is a serious breach of University security policies and could result in disciplinary procedures.";
			$msg .= "<br><br><br>Kind regards,<br>Cloud Identity Unit<br>E: mis@fubk.edu.ng";
			try {
				$mail = $this->phpmailer_lib->initialize();
				$mail->Subject = "FUBK Human Resource";
				$mail->setFrom('noreply@fubk.edu.ng', 'Password Reset Manager');
				$mail->addAddress($user->username);
				$mail->Body    = $msg;
				$mail->AltBody = $msg;

				$mail->send();

				$data = [
					'password' => hash('sha512', $password),
					'username' => $user->username
				];
				$this->auth_model->setPassword($data);
			} catch (Exception $e) {
				log_message('error', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
			}
		}

		$this->session->set_flashdata('msg', 'If the details are correct, we have sent an activate email to your registered email address. Please check your email to proceed');
		return redirect('auth/activate', 'refresh');
	}

	public function change_theme()
	{
		$this->session->set_userdata('theme_mode', ($this->session->userdata('theme_mode') == "dark-mode offcanvas-active" ? " offcanvas-active " :  "dark-mode offcanvas-active"));
		redirect($this->uri->segment(3) . '/' . $this->uri->segment(4), 'refresh');
	}

	public function logout()
	{
	    if(isset($_SESSION['username'])){
	        $this->auth_model->setSecurityTokens($_SESSION["username"], "self", "pass", $_SESSION["username"],  "LOGOUT");
	    }
	    
		unset($_SESSION);
		session_destroy();
		redirect('auth/login', 'refresh');
	}



	/*public function authenticateWithGoogle($email){
		$this->session->set_userdata('pageTitle', 'Welcome .::. FUBK-University Portal');
		$data = ['username' => $email];
		$result = $this->auth_model->authenticate($data);
		if($result){
			$this->session->set_userdata('loginStatus'] = true;
			$this->session->set_userdata('username'] = $result->username;
			$this->session->set_userdata('employeeID'] = $result->employeeID;
			$this->session->set_userdata('fullname'] = strtoupper($result->surname).' '.ucwords(strtolower($result->firstname.' '.$result->othernames));
			$this->session->set_userdata('userid'] = $result->userid;
			$this->session->set_userdata('roleid'] = 1;$result->access_level_id;
			$this->session->set_userdata('ippis_no'] = $result->ippis_no;
			$this->session->set_userdata('role'] = $result->role_name;
			$this->session->set_userdata('userHash'] = $result->user_hash;
			$this->session->set_userdata('theme_mode'] = '';
			$this->session->set_userdata('schoolName'] = "Federal University Birnin Kebbi - HR System";
			$this->session->set_userdata('shortName'] = "FUBK-PORTAL";
			$this->session->set_userdata('last_activity'] = $_SERVER['REQUEST_TIME'];
			
			$url = 'staff/index';
			
			if(!$result->roleid){
				$url = 'auth/logout'; 
				$this->session->set_flashdata('msg', 'Something went wrong. Please contact your school administrator'); 
			}
			$this->session->set_userdata('home_url'] = $url;
			$this->session->set_flashdata('msg', 'Login Successful, Welcome to FUBK-PORTAL');
			return redirect($url, 'refresh');
		}else{
			$this->session->set_flashdata('msg', 'Invalid Username/Password');
			return redirect('auth/login', 'refresh');
		}
	}

	public function sendMail(){
		echo "Sending mail...";
		$mail = $this->phpmailer_lib->initialize();

		try {
			
			$mail->Subject = $this->input->post('subject');
			$mail->setFrom('noreply@fubk.edu.ng', 'FUBK Cloud Identity');
			$mail->addAddress($this->input->post('receipient'));
			$mail->addCC('noreply@fubk.edu.ng');
			$mail->addAttachment('./uploads/fubklogo.jpeg', 'The University Logo');
			$mail->Body    = $this->input->post('msg');
			$mail->AltBody = $this->input->post('msg');

			$mail->send();
			$this->session->set_flashdata('msg', 'Message has been sent');
		} catch (Exception $e) {
			$this->session->set_flashdata('msg', "Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
		}
		redirect('notification/index', 'refresh');
	}

	public function mongo(){
		return $this->load->view('mongo');
	}
	
	public function identity(){
	    $data = [
	        "op" => "SignIn",
	        "code" => "5603F2B95B80E37BDBE4",
	        "source_url" => "https://staffportal.fubk.edu.ng",
	        "return_url" => "https://staffportal.fubk.edu.ng/auth/complete",
	    ];
	    $jwt = JWT::encode($data, $this->config->item('encryption_key'));
	    header("location: https://identity.fubk.edu.ng/?v=".($jwt));
	}
	
	public function identitySignOut(){
	    $data = [
	        "op" => "SignOut",
	        "code" => "5603F2B95B80E37BDBE4",
	        "source_url" => "https://staffportal.fubk.edu.ng",
	        "return_url" => "https://staffportal.fubk.edu.ng/auth/complete",
	    ];
	    $jwt = JWT::encode($data, $this->config->item('encryption_key'));
	    header("location: https://identity.fubk.edu.ng/?v=".($jwt)."&op=0");
	}
	
	public function complete(){
	    header('Access-Control-Allow-Origin: *');
        header('Acces-Control-Allow-Methods','GET,POST,PUT,PATCH,DELETE');
            
	    $jwt = $_GET['v'];
	    $jwt = JWT::decode($jwt, $this->config->item('encryption_key'), true);
	    
	    if($jwt->auth_status){
	        $this->authenticateWithGoogle($jwt->username);
	    }else{
	        $this->logout();
	    }
	}*/
}
