<?php
defined('BASEPATH') or exit('No direct script access allowed');

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class Registration extends CI_Controller
{
	private $MERCHANTID = 578871000;
	private $APIKEY = 105948;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('registration_model');
		$this->load->model('student_model');
		$this->load->model('payment_model');
		$this->load->model('course_model');
		$this->load->model('result_model');
	}

	private function checkUserID($userid)
	{
		if (!$userid || !is_numeric($userid)) {
			$this->session->set_flashdata('msg', 'Invalid Student Information. Please Try Again');
			redirect('registration/admissions/' . str_replace("/", "_", $_SESSION['adm_session']), 'refresh');
		} else {
			return true;
		}
	}

	private function checkRRR($rrr, $userid)
	{
		$rrr = trim(str_replace("-", "", $rrr));
		if (!$rrr || !is_numeric($rrr) || strlen($rrr) != 12) {
			$this->session->set_flashdata('msg', 'Invalid RRR. Please Try Again');
			redirect('registration/admin_payments/' . md5(time()) . '/' . $userid . '/' . md5(rand()), 'refresh');
			return;
		} else {
			return true;
		}
	}
	public function search()
	{
		$parameter = $this->input->post('search');
		$result =  $this->registration_model->search($parameter);

		if (!$result) {
			$this->session->set_flashdata('msg', 'No Student found with JAMB/Admision number ' . $parameter . ' on 2022/2023 session');
			redirect("staff/index", 'refresh');
		}
		$data = [
			'parameter' => $parameter,
			'search_results' => $result
		];
		return $this->load->view('registration/search', $data);
	}
	public function admissions()
	{
		$_SESSION['pageTitle'] = 'Admission List .::. University Portal';
		$sess = str_replace("_", "/", $this->uri->segment(3));
		$_SESSION['adm_session'] = $sess ? $sess : $_SESSION['active_session'];
		$data = [
			'adm_session' => $this->registration_model->getAdmissionSessions(),
			'adm_list' => $this->registration_model->getAdmissionList($_SESSION['adm_session']),

		];
		return $this->load->view('registration/admissions', $data);
	}
	public function change_session()
	{
		$sess = str_replace("/", "_", $this->input->post('session'));
		redirect('registration/admissions/' . urlencode($sess), 'refresh');
	}
	public function admin_view()
	{
		$_SESSION['pageTitle'] = 'Student View .::. University Portal';
		$userid = $this->uri->segment(4);
		$this->checkUserID($userid);
		$info = $this->student_model->getBio($userid);

		$paramsAcceptance = [
			'user_id' => $userid,
			'type' => "Acceptance Fees",
			'session' => $_SESSION['active_session']
		];

		$paramsTuition = [
			'user_id' => $userid,
			'type' => "School Fees",
			'session' => $_SESSION['active_session']
		];

		$data = [
			'student_id' => $userid,
			'student_info' => $info,
			'acceptanceFee' =>  $this->payment_model->getFeeInformation($paramsAcceptance),
			'tuitionFee' =>  $this->payment_model->getFeeInformation($paramsTuition),
		];

		$_SESSION['adm_session'] = $_SESSION['active_session'];
		$_SESSION['admin_student_pnumber'] = $info->pnumber;
		$_SESSION['admin_student_passport'] = $info->passport;
		$_SESSION['admin_student_signature'] = $info->signature;
		$_SESSION['admin_student_name'] = strtoupper($info->surname) . ", " . (ucwords(strtolower($info->firstname . " " . $info->othername)));


		//var_dump($data); die;
		return $this->load->view('registration/view', $data);
	}
	public function admin_bio()
	{
		$_SESSION['pageTitle'] = 'Student Bio .::. University Portal';
		$userid = $this->uri->segment(4);
		$this->checkUserID($userid);
		$info = $this->student_model->getBio($userid);
		$data = [
			'student_id' => $userid,
			'student_info' => $info,
			'contact_info' => $this->student_model->getContactInfo($userid)
		];
		return $this->load->view('registration/bio', $data);
	}


	public function uploadPassport()
	{
		//var_dump($_FILES);
		if ($_FILES["file"]['size'] < 2097152 or $_FILES["file"]['size'] > 4194304) {
			$this->session->set_flashdata('msg', 'Passport size must be between 2MB and 4MB');
		}
		$user_id = $_POST["user_id"];
		$file = "p" . (time()) . $user_id . '.' . pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

		$config = [
			'upload_path' => './passport/',
			'allowed_types' => 'jpg|png|jpeg|JPG|JPEG|PNG',
			'file_name' => $file
		];
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('file')) {
			$this->session->set_flashdata('msg', $this->upload->display_errors());
		} else {
			$this->registration_model->savePassport(['passport' => $file, 'user_id' => $user_id]);
			$this->session->set_flashdata('msg', 'Update Successful');
		}
		return redirect('registration/admin_view/' . md5(time()) . '/' . $user_id, 'refresh');
	}
	public function admin_creg()
	{
		$_SESSION['pageTitle'] = 'Student Course Reg .::. University Portal';
		$userid = $this->uri->segment(4);
		$this->checkUserID($userid);
		$info = $this->student_model->getBio($userid);
		$data = [
			'student_id' => $userid,
			'student_info' => $info,
			'creg_history' => $this->course_model->getCourseRegHistory($info->pnumber)
		];
		return $this->load->view('registration/creg', $data);
	}
	public function admin_resultSummary()
	{
		$_SESSION['pageTitle'] = 'Student Course Reg .::. University Portal';
		$userid = $this->uri->segment(4);
		$this->checkUserID($userid);
		$info = $this->student_model->getBio($userid);
		$data = [
			'student_id' => $userid,
			'student_info' => $info,
			'result_history' => $this->result_model->getResultHistory($info->pnumber)
		];
		return $this->load->view('registration/results', $data);
	}
	public function print_cform()
	{
		$data = [
			'session' => $this->uri->segment(4),
			'studentid' => $this->uri->segment(5),
		];
		$data = [
			'courses' => $this->course_model->getCoursesRegisteredForSession($data),
			'student' => $this->student_model->getBioByPnumber($data['studentid']),
		];
		return $this->load->view('course/print', $data);
	}
	public function admin_reset_password()
	{
		$userid = $this->uri->segment(4);
		$this->checkUserID($userid);
		if ($userid) {

			$info = $this->student_model->getBio($userid);

			$this->registration_model->admin_reset_password($userid, $info->pnumber);
			$this->session->set_flashdata('msg', 'Password Reset Successfully to Student\'s Admission Number');
		}
		redirect('registration/admin_view/' . md5(time()) . '/' . $userid . '/' . md5(rand()), 'refresh');
	}
	public function admin_confirm_admission()
	{
		$userid = $this->uri->segment(4);
		$this->checkUserID($userid);
		if ($userid) {
			$this->registration_model->admin_confirm_admission($userid);
			$this->session->set_flashdata('msg', 'Student\'s Admission Confirmed Successfully');
		}
		redirect('registration/admin_view/' . md5(time()) . '/' . $userid . '/' . md5(rand()), 'refresh');
	}

	public function admin_payments()
	{
		$userid = $this->uri->segment(4);
		$this->checkUserID($userid);
		$data = [
			'student_id' => $userid,
			'pay_history' => $this->payment_model->getPaymentHistory($userid)
		];
		$this->load->view('registration/payment', $data);
	}


	public function generateTuitionRemita()
	{
		$userid = $this->uri->segment(3);
		$type = $this->uri->segment(4, false);
		$info = $this->student_model->getSimpleBio($userid);


		$MERCHANTID = "578871000";
		$APIKEY = "105948";

		$desc = "Undergraduate Tuition Fee";
		$serviceTypeId = "1099842539";

		if ($info->entrymode == 'PG') {
			$desc = "Postgraduate Tuition Fee";
			$serviceTypeId = "10137758113";
		}
		if ($info->entrymode == 'MATRIC') {
			$desc = "SBS Tuition Fee";
			$serviceTypeId = "1099776655";
		}

		$session = $_SESSION['active_session'];
		$level = $info->current_level;
		if ($type and $type == 2) {
			$session = "2023/2024";
			if ($level % 100 == 10) {
				$level = $level - 10;
			}
			if ($level % 100 == 20) {
				$level = $level - 20;
			}
		}

		$params = [
			'programid' => $info->programid,
			'session' => $session,
			'type' => $info->entrymode,
			'level' => $level
			// 'level'=>810


		];

		$schedule = $this->payment_model->getPaymentSchedule($params);
		$amount = $schedule->amount;
		//echo $this->db->last_query(); var_dump($params); die;

		if ($type) {
			if ($type == 1) {
				$amount = 0.6 * $amount;
			} else if ($type == 2 || $type == 3) {
				$amount = 0.4 * $amount;
			} else {
				$amount = $amount;
			}
		} else {
			$amount = $amount;
		}

		$level = $info->current_level;
		if ($info->entrymode == "UTME" or $info->entrymode == "DE") {
			if ($level % 100 == 10) {
				$level = "SPILL OVER I";
			}
			if ($level % 100 == 20) {
				$level = "SPILL OVER II";
			}
		}

		//add late registration
		// if(date("Y-m-d") >= "2023-06-16" and date("Y-m-d") <= "2023-06-22" and $info->entrymode != "PG"){
		//     $amount += 2000;
		// }

		$data = [
			"serviceTypeId" => $serviceTypeId,
			"amount" => $amount,
			"orderId" => md5(time() . mt_rand()),
			"payerName" => trim(strtoupper($info->surname) . ', ' . ucwords($info->firstname . ' ' . $info->othername)) . ' - ' . $info->uniqueID . " - " . $level,
			"payerEmail" => $info->email ? strtolower($info->email) : 'collections@fubk.edu.ng',
			"payerPhone" => $info->phone ? $info->phone : "07000000000",
			"description" => $session . ' ' . $desc . ' for ' . trim(strtoupper($info->surname) . ', ' . ucwords($info->firstname . ' ' . $info->othername)) . ' - ' . strtoupper($type ? "PARTIALLY PAID" : "FULLY PAID"),
		];

		$data['apiHash'] = hash('SHA512', $MERCHANTID . $data['serviceTypeId'] . $data['orderId'] . $data['amount'] . $APIKEY);
		$url = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
		$options = [
			'http' => [
				'method'  => 'POST',
				'content' => json_encode($data),
				'header' =>  "Content-Type: application/json\r\n" .
					"Accept: application/json\r\n" .
					"Authorization:remitaConsumerKey=" . $MERCHANTID . ",remitaConsumerToken=" . $data['apiHash']
			]
		];


		$context  = stream_context_create($options);

		$result = json_decode(file_get_contents($url, false, $context));
		$level = $info->current_level;
		if ($type and $type == 2) {
			$session = "2022/2023";
			if ($level % 100 == 10) {
				$level = $level - 10;
			}
			if ($level % 100 == 20) {
				$level = $level - 20;
			}
		}

		if ($result && isset($result->RRR)) {
			$payload = [
				"user_id" => $userid,
				"level" => $level,
				"orderid" => $data["orderId"],
				"amount" => $amount,
				"type" => "School Fees",
				"rrr" => $result->RRR,
				"status" => "Pending",
				"session" => $session,
				"percentage_paid" => $type ? ($type == 1 ? "60" : "40") : "100"
			];
			$this->payment_model->registerPayment($payload);
			//echo $this->db->last_query(); die;
			$this->session->set_flashdata('msg', "Operation Completed");
		} else {
			$this->session->set_flashdata('msg', "Operation Failed.");
		}
		redirect('registration/admin_view/' . md5(time()) . '/' . $userid, 'refresh');
	}

	public function generateAcceptanceRemita()
	{
		$userid = $this->uri->segment(3);
		$info = $this->student_model->getSimpleBio($userid);

		$MERCHANTID = "578871000";
		$APIKEY = "105948";

		$serviceTypeId = "533233195";
		$amount = 5000;
		$desc = "Undergraduate";

		$desc = "Undergraduate Admissions Acceptance Fee";
		$serviceTypeId = "533233195";
		$amount = 5000;
		$feeitemid = NULL;

		if ($info->entrymode == 'PG') {
			$desc = "Postgraduate Admissions Acceptance Fee";
			$serviceTypeId = "533233195";
			$serviceTypeId = "11208926713";
			$amount = 10000;
			$feeitemid = 264;
		} else if ($info->entrymode == 'MATRIC') {
			$desc = "SBS Admissions Acceptance Fee";
			$serviceTypeId = "4591235861";
			$amount = 7000;
			$feeitemid = 265;
		} else {
			$serviceTypeId = "533233195";
			$amount = 5000;
			$desc = "Undergraduate Admissions Acceptance Fee";
			$feeitemid = 266;
		}

		$data = [
			"serviceTypeId" => $serviceTypeId,
			"amount" => $amount,
			"orderId" => md5(time() . mt_rand()),
			"payerName" => trim(strtoupper($info->surname) . ', ' . ucwords($info->firstname . ' ' . $info->othername)),
			"payerEmail" => $info->email ? strtolower($info->email) : 'collections@fubk.edu.ng',
			"payerPhone" => "07000000000",
			"description" => $info->session_admitted . ' ' . $desc . '  admission acceptance fee for ' . trim(strtoupper($info->surname) . ', ' . strtoupper($info->firstname . ' ' . $info->othername)) . ' - ' . strtoupper($info->jamb_no),
		];

		$data['apiHash'] = hash('SHA512', $MERCHANTID . $data['serviceTypeId'] . $data['orderId'] . $data['amount'] . $APIKEY);
		$url = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
		$options = [
			'http' => [
				'method'  => 'POST',
				'content' => json_encode($data),
				'header' =>  "Content-Type: application/json\r\n" .
					"Accept: application/json\r\n" .
					"Authorization:remitaConsumerKey=" . $MERCHANTID . ",remitaConsumerToken=" . $data['apiHash']
			]
		];


		$context  = stream_context_create($options);

		$result = json_decode(file_get_contents($url, false, $context));

		if (isset($result->RRR) && strlen($result->RRR) == 12) {
			$payload = [
				"user_id" => $userid,
				"level" => $info->current_level,
				"orderid" => $data["orderId"],
				"amount" => $amount,
				"type" => "Acceptance Fees",
				"rrr" => $result->RRR,
				"status" => "Pending",
				"session" => $info->session_admitted,
				'percentage_paid' => 100
			];

			$this->payment_model->registerPayment($payload);
			$paymentID = $this->db->insert_id();
			$feeitems = [
				[
					'user_id' => $payload['user_id'],
					'payment_id' => $paymentID,
					'fee_item_id' => $feeitemid,
					'amount' => $amount,
					'session' => $payload['session'],
					'level' => $payload['level']
				]
			];
			$this->payment_model->registerPaymentItems($feeitems);
		}
		$this->session->set_flashdata('msg', "Operation Completed");
		redirect('registration/admin_view/' . md5(time()) . '/' . $userid, 'refresh');
	}



	public function loadGraduate()
	{

		$admission_no = trim($_POST['admission_no']);
		$info = $this->student_model->getGraduateByAdmissionNo($admission_no);

		if (!$info) {
			echo "false";
			return;
		}
		echo json_encode($info);
	}

	public function generateGraduantsInvoice()
	{

		$admission_no = trim($_POST['admission_no']);
		$total_amount = trim($_POST['total_amount']);
		$info = $this->student_model->getGraduateByAdmissionNo($admission_no);

		if (!$info) {
			echo false;
			return;
		}

		$userid = $info->user_id;

		$MERCHANTID = "578871000";
		$APIKEY = "105948";
		$serviceTypeId = "577222650";

		$amount = $total_amount;

		$feeitemid = 300;
		$desc = "Payment for Academic Gown";
		if ($amount > 3000) {
			$desc = "Payment for Academic Gown/ Order of Proceedings/ Alumni Fees";
		}
		$desc .= " by " . $info->name . " (" . $info->admission_no . ")";

		$data = [
			"serviceTypeId" => $serviceTypeId,
			"amount" => $amount,
			"orderId" => md5(time() . mt_rand()),
			"payerName" => trim(strtoupper($info->surname) . ', ' . ucwords($info->firstname . ' ' . $info->othername)),
			"payerEmail" => $info->email ? strtolower($info->email) : 'collections@fubk.edu.ng',
			"payerPhone" => "07000000000",
			"description" => $desc
		];

		$data['apiHash'] = hash('SHA512', $MERCHANTID . $data['serviceTypeId'] . $data['orderId'] . $data['amount'] . $APIKEY);
		$url = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
		$options = [
			'http' => [
				'method'  => 'POST',
				'content' => json_encode($data),
				'header' =>  "Content-Type: application/json\r\n" .
					"Accept: application/json\r\n" .
					"Authorization:remitaConsumerKey=" . $MERCHANTID . ",remitaConsumerToken=" . $data['apiHash']
			]
		];


		$context  = stream_context_create($options);

		$result = json_decode(file_get_contents($url, false, $context));


		if (isset($result->RRR) && strlen($result->RRR) == 12) {
			$payload = [
				"user_id" => $userid,
				"level" => 8000,
				"orderid" => $data["orderId"],
				"amount" => $amount,
				"type" => "Graduation Fees",
				"rrr" => $result->RRR,
				"status" => "Pending",
				"session" => '2024/2025',
				'percentage_paid' => 100
			];

			$this->payment_model->registerPayment($payload);
			// $paymentID = $this->db->insert_id();
			// $feeitems = [
			//     [
			//         'user_id' => $payload['user_id'],
			//         'payment_id' => $paymentID,
			//         'fee_item_id' => $feeitemid,
			//         'amount' => $amount,
			//         'session' => $payload['session'],
			//         'level' => $payload['level']
			//     ]
			// ];
			// $this->payment_model->registerPaymentItems($feeitems);
			echo $result->RRR;
		} else {
			echo false;
		}
		return;
	}

	public function generate()
	{
		$jamb_no = trim($_POST['jamb_no']);
		$info = $this->student_model->getSimpleBioByJAMBNo($jamb_no);
		//print_r($info); die;
		if (!$info) {
			echo "false";
			return;
		}
		$active_sess = $_SESSION['active_session'] ?? '2024/2025';

		//check of Acceptance Fee RRR is already generated.
		$paramsAcceptance = [
			'user_id' => $info->user_id,
			'type' => "Acceptance Fees",
			'session' => $active_sess
		];

		$acceptanceFee = $this->payment_model->getFeeInformation($paramsAcceptance);

		$desc = "Undergraduate Admissions Acceptance Fee";
		$serviceTypeId = "533233195";
		$amount = 5000;
		$feeitemid = NULL;

		if ($info->entrymode == 'PG') {
			$desc = "Postgraduate Admissions Acceptance Fee";
			$serviceTypeId = "533233195";
			$serviceTypeId = "11208926713";
			$amount = 10000;
			$feeitemid = 264;
		} else if ($info->entrymode == 'MATRIC') {
			$desc = "SBS Admissions Acceptance Fee";
			$serviceTypeId = "4591235861";
			$amount = 7000;
			$feeitemid = 265;
		} else {
			$serviceTypeId = "533233195";
			$amount = 5000;
			$desc = "Undergraduate Admissions Acceptance Fee";
			$feeitemid = 266;
		}

		if (isset($acceptanceFee->rrr)) {
			$data = [
				'firstname' => $info->firstname,
				'surname' => $info->surname,
				'othername' => $info->othername,
				'jamb_no' => $info->jamb_no,
				'prog_abbr' => $info->prog_abbr,
				'entrymode' => $info->entrymode,
				'passport' => $info->passport,
				'gender' => $info->gender,
				'dept' => $info->dept_name,
				'session_admitted' => $info->session_admitted,
				'rrr' => $acceptanceFee->rrr,
				'status' => $acceptanceFee->status,
				'amount' => $acceptanceFee->amount,
				'desc' => $desc
			];
			echo json_encode($data);
			return;
		} else {
			$MERCHANTID = "578871000";
			$APIKEY = "105948";

			$data = [
				"serviceTypeId" => $serviceTypeId,
				"amount" => $amount,
				"orderId" => md5(time() . mt_rand()),
				"payerName" => trim(strtoupper($info->surname) . ', ' . ucwords($info->firstname . ' ' . $info->othername)) . '  -  ' . $info->jamb_no,
				"payerEmail" => $info->email ? strtolower($info->email) : 'collections@fubk.edu.ng',
				"payerPhone" => $info->phone ? $info->phone : "07000000000",
				"description" => $info->session_admitted . " " . $desc . ' for ' . trim(strtoupper($info->surname) . ', ' . strtoupper($info->firstname . ' ' . $info->othername)) . ' - (' . $info->prog_abbr . ')',
			];

			$data['apiHash'] = hash('SHA512', $MERCHANTID . $data['serviceTypeId'] . $data['orderId'] . $data['amount'] . $APIKEY);
			$url = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
			$options = [
				'http' => [
					'method'  => 'POST',
					'content' => json_encode($data),
					'header' =>  "Content-Type: application/json\r\n" .
						"Accept: application/json\r\n" .
						"Authorization:remitaConsumerKey=" . $MERCHANTID . ",remitaConsumerToken=" . $data['apiHash']
				]
			];

			$context  = stream_context_create($options);
			$result = json_decode(file_get_contents($url, false, $context));
			//echo json_encode($result); return;
			if (isset($result->RRR) && strlen($result->RRR) == 12) {
				$payload = [
					"user_id" => $info->user_id,
					"level" => $info->current_level,
					"orderid" => $data["orderId"],
					"amount" => number_format($amount, 2, '.', ','),
					"type" => "Acceptance Fees",
					"rrr" => $result->RRR,
					"status" => "Pending",
					"session" => $info->session_admitted,
					"percentage_paid" => 100
				];

				$this->payment_model->registerPayment($payload);

				$paymentID = $this->db->insert_id();
				$feeitems = [
					[
						'user_id' => $payload['user_id'],
						'payment_id' => $paymentID,
						'fee_item_id' => $feeitemid,
						'amount' => $amount,
						'session' => $payload['session'],
						'level' => $payload['level']
					]
				];
				$this->payment_model->registerPaymentItems($feeitems);

				$data = [
					'firstname' => $info->firstname,
					'surname' => $info->surname,
					'othername' => $info->othername,
					'jamb_no' => $info->jamb_no,
					'prog_abbr' => $info->prog_abbr,
					'entrymode' => $info->entrymode,
					'gender' => $info->gender,
					'passport' => $info->passport,
					'session_admitted' => $info->session_admitted,
					'rrr' => $result->RRR,
					'status' => $result->status,
					'dept' => $info->dept_name,
					'amount' => number_format($amount, 2, '.', ','),
					'desc' => $desc
				];
				echo json_encode($data);
			} else {
				echo false;
			}
		}
		return;
	}

	function checkPaymentStatus()
	{
		$userid = $this->uri->segment(3);
		$rrr = $this->uri->segment(4);

		$MERCHANTID = "578871000";
		$APIKEY = "105948";

		$apiHash = hash('SHA512',  $rrr . $APIKEY . $MERCHANTID);

		$url = "https://login.remita.net/remita/ecomm/578871000/" . $rrr . "/" . $apiHash . "/status.reg";

		$options = [
			'http' => [
				'method'  => 'GET',
				'header' =>  "Content-Type: application/json\r\n" .
					"Accept: application/json\r\n" .
					"Authorization:remitaConsumerKey=" . $this->MERCHANTID . ",remitaConsumerToken=" . $apiHash
			]
		];

		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);

		$this->session->set_flashdata('msg', "Payment updated");

		$result = json_decode($result, true);

		$data = [
			'status' => ($result['status'] == 00 || $result['status'] == 01) ? "Paid" : "Pending",
			'rrr' => $result['RRR'],
			'orderid' => $result['orderId'],
		];

		$this->payment_model->updatePaymentStatus($data);
		$this->session->set_flashdata('msg', "Payment Status Updated Successfully");

		redirect('registration/admin_view/' . md5(time()) . '/' . $userid, 'refresh');
	}

	public function deletePayment()
	{
		$payid = $this->uri->segment(4);
		$userid = $this->uri->segment(5);
		$data = [
			'id' => $payid,
			'user_id' => $userid,
		];
		$this->payment_model->deletePayment($data);
		$this->session->set_flashdata('msg', "Payment Record Deleted Successfully");
		redirect('registration/admin_payments/' . md5(time()) . '/' . $userid . '/' . md5(rand()), 'refresh');
	}

	public function assignadmission_no()
	{
		$userid = $this->uri->segment(3);

		$info = $this->student_model->getSimpleBio($userid);

		//serial number
		$params = [
			'session_admitted' => $info->session_admitted,
			'programid' => $info->programid,
			'entrymode' => $info->entrymode
		];
		$serial = $this->registration_model->getAdmissionSerialNo($params);
		//
		$admission_no = "";

		//First admission number in the program
		if (!$serial) {
			$admission_no = substr($_SESSION['active_session'], 2, 2);
			//DE/UTME/PG
			if ($info->entrymode == "PG") {
				$admission_no .= "0";
				//facultyid
				$admission_no .= str_pad($info->facultyid, 2, "0", STR_PAD_LEFT);
			} else if ($info->entrymode == "UTME") {
				$admission_no .= "1";
				//facultyid
				$admission_no .= str_pad($info->facultyid, 2, "0", STR_PAD_LEFT);
			} else if ($info->entrymode == "DE") {
				$admission_no .= "2";
				//facultyid
				$admission_no .= str_pad($info->facultyid, 2, "0", STR_PAD_LEFT);
			} else if ($info->entrymode == "MATRIC") {
				$admission_no  = date("y");
			}

			//programid
			$admission_no .= $info->pcode;

			//serial no
			$admission_no .= str_pad("1", 3, "0", STR_PAD_LEFT);
		} else {
			//increment existing number
			$serial = (int)$serial->serialValue;
			$serial = $serial + 1;
			$admission_no = $serial;
		}
		//var_dump($admission_no);die;
		if (strlen($admission_no) == 10 or strlen($admission_no) == 7) {
			$params = [
				'user_id' => $info->user_id,
				'pnumber' => $admission_no,
				'entrymode' => $info->entrymode
			];
			$this->registration_model->assignAdmissionNo($params);
			$this->session->set_flashdata('msg', "Admission No Assigned Successfully");
		} else {
			$this->session->set_flashdata('msg', "Something went wrong. Please try again");
		}
		redirect('registration/admin_view/' . md5(time()) . '/' . $userid, 'refresh');
	}

	public function printAdmissionLetter()
	{
		$userid = $this->uri->segment(3);
		$info = $this->student_model->getSimpleBio($userid);
		$data = ['info' => $info];

		return $this->load->view('registration/admissionLetter', $data);
		// 		if($info->entrymode == "PG"){
		// 		    return $this->load->view('registration/admissionLetterPG', $data);
		// 		}else{

		// 		}
	}
	public function admin_exams_card()
	{
		$_SESSION['pageTitle'] = 'Examination Cards .::. University Portal';
		$userid = $this->uri->segment(4);
		$this->checkUserID($userid);
		$info = $this->student_model->getBio($userid);
		$data = [
			'student_id' => $info->userid,
			'exams_cards' => $this->course_model->getExamsCard($info->pnumber)
		];
		return $this->load->view('registration/exam_cards', $data);
	}

	public function printecard()
	{
		$semester = $this->uri->segment(4);
		$pnumber = substr($_SESSION['admin_student_pnumber'], 0, 10);
		$param = [
			'semester' => $semester,
			'studentid' => $pnumber
		];
		$data = [
			'student' => $this->course_model->getDetails($pnumber),
			'courses' => $this->course_model->getECardCourses($param),
			'timetable' => $this->course_model->getECardTimetable($param),
		];
		$this->load->view('registration/ecard', $data);
	}

	public function scramble($txt)
	{
		$result = "";
		for ($i = 0; $i < strlen($txt); $i++) {
			$result .= chr(ord(substr($txt, $i, 1)) + 20);
		}
		return $result;
	}

	public function admin_idcard()
	{
		$_SESSION['pageTitle'] = 'ID Card .::. University Portal';
		$userid = $this->uri->segment(4);
		$this->checkUserID($userid);
		$student = $this->registration_model->admin_idCard($userid);
		$text = $this->scramble($student->pnumber);
		$text = site_url('card/verifyID/' . $text);
		// Create QR code
		$renderer = new ImageRenderer(
			new RendererStyle(400),
			new SvgImageBackEnd()
		);
		$writer = new Writer($renderer);
		$writer->writeFile($text, './assets/images/IDCardQRCode.png');

		$data = [
			'student_id' => $userid,
			'idcards' => $student
		];
		return $this->load->view('registration/idcard', $data);
	}
	public function password()
	{
		$result =  $this->registration_model->password();
		foreach ($result as $row) {
			//echo hash('sha512', $row->password)."<br />";
			$this->registration_model->update_password($row->password, $row->userid);
		}
	}
	public function saveRecord()
	{

		if ($_FILES["photo"]['size'] < 2097152 or $_FILES["photo"]['size'] > 4194304) {
			$this->session->set_flashdata('msg', 'Passport size must be between 2MB and 4MB');
		}
		$filename = md5(rand() . time()) . '.' . pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
		$config = [
			'upload_path' => './passport/',
			'allowed_types' => 'jpg|png|jpeg|JPG|JPEG|PNG|jfif',
			'file_name' => $filename
		];
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('photo')) {
			$this->session->set_flashdata('msg', $this->upload->display_errors());
		} else {
			$data = [
				'jamb_no' => $_POST['jamb_no'],
				'nin' => $_POST['nin'],
				'email' => $_POST['email'],
				'photo' => $filename,
				'phone' => $_POST['phone']
			];
			var_dump($data);
			$this->registration_model->update_basic_info($data);
		}
	}
	public function generatePercentageRemita()
	{
		$session = $_POST['session'];
		$percentage = $_POST['percentage'];
		$userid = $_POST['user_id'];
		$level = $_POST['level'];
		$info = $this->student_model->getSimpleBio($userid);
		$programid = $info->programid;
		$schedule = $this->registration_model->get_pg_fee_schedule($session, $level, $programid);
		$amount = 0;
		foreach ($schedule as $row) {
			$amount += $row->amount;
		}
		$percentage_to_pay = $amount * $percentage;

		$desc = "Postgraduate Tuition Fee";
		$serviceTypeId = "10137758113";
		$MERCHANTID = "578871000";
		$APIKEY = "105948";

		if ($percentage == 1) {
			$type = 1; //full payment
		} elseif($percentage == 0.6) {
			$type = 2; //partial payment
		}else {
			$type = 3; //partial payment
		}

		$data = [
			"serviceTypeId" => $serviceTypeId,
			"amount" => $percentage_to_pay,
			"orderId" => md5(time() . mt_rand()),
			"payerName" => trim(strtoupper($info->surname) . ', ' . ucwords($info->firstname . ' ' . $info->othername)) . ' - ' . $info->uniqueID . " - " . $level,
			"payerEmail" => $info->email ? strtolower($info->email) : 'collections@fubk.edu.ng',
			"payerPhone" => $info->phone ? $info->phone : "07000000000",
			"description" => $session . ' ' . $desc . ' for ' . trim(strtoupper($info->surname) . ', ' . ucwords($info->firstname . ' ' . $info->othername)) . ' - ' . strtoupper($type != 1 ? "PARTIALLY PAID" : "FULLY PAID"),
		];

		$data['apiHash'] = hash('SHA512', $MERCHANTID . $data['serviceTypeId'] . $data['orderId'] . $data['amount'] . $APIKEY);
		$url = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
		$options = [
			'http' => [
				'method'  => 'POST',
				'content' => json_encode($data),
				'header' =>  "Content-Type: application/json\r\n" .
					"Accept: application/json\r\n" .
					"Authorization:remitaConsumerKey=" . $MERCHANTID . ",remitaConsumerToken=" . $data['apiHash']
			]
		];

		$session_value = $this->registration_model->get_session_value($session); 
		$context  = stream_context_create($options);
		$result = json_decode(file_get_contents($url, false, $context));
		if ($result && isset($result->RRR)) {
			$payload = [
				"user_id" => $userid,
				"level" => $level,
				"orderid" => $data["orderId"],
				"amount" => $percentage_to_pay,
				"type" => "School Fees",
				"rrr" => $result->RRR,
				"status" => "Pending",
				"session" => $session_value,
				"percentage_paid" => $type != 1 ? ($type == 2 ? "60" : "40") : "100"
			];
			$this->payment_model->registerPayment($payload);
			//echo $this->db->last_query(); die;
			$this->session->set_flashdata('msg', "Operation Completed");
		} else {
			$this->session->set_flashdata('msg', "Operation Failed.");
		}
		redirect('registration/admin_view/' . md5(time()) . '/' . $userid, 'refresh');
	}
}
