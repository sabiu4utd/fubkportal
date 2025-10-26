<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Parttimemanager extends CI_Controller {
    
    private $MERCHANTID = 578871000;
    private $APIKEY = 105948;
    
	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['userid'])){
			redirect('auth/logout', 'refresh');
		}
		$this->load->library('upload');
		$this->load->model(['sbsmanager_model', 'student_model', 'payment_model', 'registration_model']);
	}
	
	public function index(){
	    $_SESSION['pageTitle'] = 'School of Part-Time Studies .::. Federal University Birnin Kebbi';
	    $_SESSION['sbs_session'] = "2024/2025";
	    $_SESSION['sbs_semester'] = "First";
	    
	    $curl = curl_init();
	    curl_setopt_array($curl, [
          CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/formstatpt",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [
            "Accept: *",
            "User-Agent: Thunder Client (https://www.thunderclient.com)"
          ],
        ]);
        
        $stats = curl_exec($curl);
        
		$data = [
		    'stats' => json_decode($stats)
		];
		//var_dump($data); die;
		
		return $this->load->view('parttimemanager/index', $data);
		
	}
	
	public function view(){
		$_SESSION['pageTitle'] = 'Part-Time Application .::. University Portal';
		
		//    0 - pending
		//    1 - admitted
		//    2 - rejected
		//    3 - all forms
		
		
	 	$form_type = $this->uri->segment(4, false); 
	    $form_status = $this->uri->segment(5, 0);
		
	//	echo $url = "https://eforms.fubk.edu.ng/formapi/sbsforms/".$form_type."/".$form_status;die;
		
		$curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/parttimeforms/".$form_type."/".$form_status,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [],
        ]);
        
        $response = curl_exec($curl);
       // var_dump($response); exit;
        $err = curl_error($curl);
        
        curl_close($curl);
        
        $data = [
		    'applicants' => json_decode($response)    
		];
        
		return $this->load->view('parttimemanager/applications', $data);
	}
	
	public function admissions(){
	    $_SESSION['pageTitle'] = 'SBS Admissions .::. University Portal';
	    
	    $data = [
	        'list' => $this->sbsmanager_model->getAdmissionSessions()
	    ];
	    //var_dump($data); die;
	    return $this->load->view('sbsmanager/admissions', $data);
	}
	
	public function admission(){
	    $_SESSION['pageTitle'] = 'SBS Admissions .::. University Portal';
	    
	    $session = str_replace("_", "/", $this->uri->segment(3, $_SESSION['sbs_session'])); 
	    //$session = "2024_2025";
	    $data = [
	        'list' => $this->sbsmanager_model->getAdmissionList($session)
	    ];
	    //var_dump($data); die;
	    return $this->load->view('sbsmanager/admission', $data);
	}
	
	public function candidate(){
        $userid = $this->uri->segment(4, false);
        if(!$userid){
            redirect('sbsmanager/admission', 'refresh');
        }
        
        $_SESSION['pageTitle'] = 'SBS Student View .::. University Portal';
		
		$info = $this->student_model->getBio($userid);
		
		$paramsAcceptance = [
		    'user_id' => $userid,
		    'type' => "Acceptance Fees",
		    'session' => $_SESSION['sbs_session']
		];
		
		$paramsTuition = [
		    'user_id' => $userid,
		    'type' => "School Fees",
		    'session' => $_SESSION['sbs_session']
		];
		
		$data = [
            'student_id' => $userid,
            'student_info' => $info,
            'acceptanceFee' =>  $this->payment_model->getFeeInformation($paramsAcceptance),
            'tuitionFee' =>  $this->payment_model->getFeeInformation($paramsTuition),
        ];
        
		$_SESSION['adm_session'] = $_SESSION['active_session'] ;
		$_SESSION['admin_student_pnumber'] = $info->pnumber;
		$_SESSION['admin_student_passport'] = $info->passport;
		$_SESSION['admin_student_signature'] = $info->signature;
		$_SESSION['admin_student_name'] = strtoupper($info->surname). ", " .(ucwords(strtolower($info->firstname." ".$info->othername)));
		
	    return $this->load->view('sbsmanager/candidate', $data);
        
	}
	
	public function generateAcceptanceRemita(){
		$userid = $this->uri->segment(3);
		$info = $this->student_model->getSimpleBio($userid);

		$MERCHANTID = "578871000";
    	$APIKEY = "105948";
    	
    	$serviceTypeId = "533233195";
		$amount = 5000;
		$desc = "Undergraduate";
		
		if($info->entrymode == "PG"){
		    $serviceTypeId = "11208926713";
		    $desc = "Postgraduate";
		}else if($info->entrymode == "MATRIC"){
		    $serviceTypeId = "4591235861";
		    $amount = 7000;
		    $desc = "Remedial";
		}

        $data = [
            "serviceTypeId" => $serviceTypeId,
            "amount" => $amount,
            "orderId" => md5(time().mt_rand()),
            "payerName" => trim(strtoupper($info->surname). ', '.ucwords($info->firstname. ' '.$info->othername)),
            "payerEmail" => $info->email ? strtolower($info->email) : 'collections@fubk.edu.ng' ,
            "payerPhone" => "07000000000",
            "description" => $info->session_admitted.' '.$desc.'  admission acceptance fee for '.trim(strtoupper($info->surname). ', '.strtoupper($info->firstname. ' '.$info->othername)). ' - '.strtoupper($info->jamb_no),
        ];

        $data['apiHash'] = hash('SHA512', $MERCHANTID . $data['serviceTypeId'] . $data['orderId'] . $data['amount'] .$APIKEY);
        $url = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => json_encode($data),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization:remitaConsumerKey=".$MERCHANTID.",remitaConsumerToken=" . $data['apiHash']
            ]
        ];

        
        $context  = stream_context_create($options);
        
        $result = json_decode(file_get_contents($url, false, $context));
        
        if (isset($result->RRR) && strlen($result->RRR) == 12){
            $payload = [
                "user_id" => $userid,
                "level" => $info->current_level,
                "orderid" => $data["orderId"],
                "amount" => $amount,
                "type" => "Acceptance Fees",
                "rrr" => $result->RRR,
                "status" => "Pending",
                "session" => $info->session_admitted  
            ];
            $this->payment_model->registerPayment($payload);
        }
        $this->session->set_flashdata('msg', "Operation Completed");
        redirect('sbsmanager/candidate/'.md5(time()).'/'.$userid.'/'.md5(time()), 'refresh');
	}
	
	public function checkPaymentStatus() {
        $userid = $this->uri->segment(3);
        $rrr = $this->uri->segment(4);
        
        $MERCHANTID = "578871000";
    	$APIKEY = "105948";

        $apiHash = hash('SHA512',  $rrr. $APIKEY.$MERCHANTID);

        $url = "https://login.remita.net/remita/ecomm/578871000/".$rrr."/".$apiHash."/status.reg";

        $options = [
            'http' => [
                'method'  => 'GET',
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization:remitaConsumerKey=".$this->MERCHANTID.",remitaConsumerToken=" . $apiHash
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

		redirect('sbsmanager/candidate/'.md5(time()).'/'.$userid.'/'.md5(time()), 'refresh');
    }
    
	public function deletePayment(){
		$payid = $this->uri->segment(4);
		$userid = $this->uri->segment(5);
		$data = [
			'id' => $payid,
			'user_id' => $userid,
		];
		$this->payment_model->deletePayment($data);
		$this->session->set_flashdata('msg', "Payment Record Deleted Successfully");
		redirect('sbsmanager/payments/'.md5(time()).'/'.$userid.'/'.md5(rand()), 'refresh');
	}
	
		
	public function generateTuitionRemita(){
		$userid = $this->uri->segment(3);
		$type = $this->uri->segment(4, false);  
		$info = $this->student_model->getSimpleBio($userid);
		
		
		$MERCHANTID = "578871000";
    	$APIKEY = "105948";
    	
    	$desc = "Undergraduate Tuition Fee";
		$serviceTypeId = "1099842539";
		
		if($info->entrymode == 'PG'){
		    $desc = "Postgraduate Tuition Fee";
		    $serviceTypeId = "10137758113";
		}
		if($info->entrymode == 'MATRIC'){ 
		    $desc = "SBS Tuition Fee";
		    $serviceTypeId = "1099776655";
		}
    	
		$params = [
		    'programid' => $info->programid,
		    'session' => $_SESSION['active_session'],
		    'type' => $info->entrymode,
		    'level' => $info->current_level
		];
		$schedule = $this->payment_model->getPaymentSchedule($params);
		$amount = $schedule->amount;
		if($type){
		    $amount = 0.6 * $amount;
		}
		
		$level = $info->current_level;
		if($level % 100 == 10){
		    $level = "SPILL OVER I";
		}
		if($level % 100 == 20){
		    $level = "SPILL OVER II";
		}
		
		$data = [
            "serviceTypeId" => $serviceTypeId,
            "amount" => $amount,
            "orderId" => md5(time().mt_rand()),
            "payerName" => trim(strtoupper($info->surname). ', '.ucwords($info->firstname. ' '.$info->othername)).' - '.$info->uniqueID ." - ".$level,
            "payerEmail" => $info->email ? strtolower($info->email) : 'collections@fubk.edu.ng' ,
            "payerPhone" => $info->phone ? $info->phone : "07000000000",
            "description" => $_SESSION['active_session'].' '.$desc.' for '.trim(strtoupper($info->surname). ', '.ucwords($info->firstname. ' '.$info->othername)). ' - '.strtoupper($type? "PARTIALLY PAID" : "FULLY PAID"),
        ];

        $data['apiHash'] = hash('SHA512', $MERCHANTID . $data['serviceTypeId'] . $data['orderId'] . $data['amount'] .$APIKEY);
        $url = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => json_encode($data),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization:remitaConsumerKey=".$MERCHANTID.",remitaConsumerToken=" . $data['apiHash']
            ]
        ];

        
        $context  = stream_context_create($options);
        
        $result = json_decode(file_get_contents($url, false, $context));
        
        
        if ($result && isset($result->RRR)){
            $payload = [
                "user_id" => $userid,
                "level" => $info->current_level,
                "orderid" => $data["orderId"],
                "amount" => $amount,
                "type" => "School Fees",
                "rrr" => $result->RRR,
                "status" => "Pending",
                "session" => $_SESSION['active_session'] ,
                "percentage_paid" => ($type? "60": "100")
            ];
            $this->payment_model->registerPayment($payload);
            //echo $this->db->last_query(); die;
            $this->session->set_flashdata('msg', "Operation Completed");
        }else{
            $this->session->set_flashdata('msg', "Operation Failed.");
        }
        redirect('sbsmanager/candidate/'.md5(time()).'/'.$userid, 'refresh');
	}
	
	public function assignadmission_no(){
		$userid = $this->uri->segment(3);
		$info = $this->student_model->getSimpleBio($userid);
		
		//serial number
		$params = [
		    'session_admitted' => $info->session_admitted,
		    'programid' => $info->programid,
		    'entrymode' => $info->entrymode
		];
		$serial = $this->registration_model->getAdmissionSerialNo($params);
		$admission_no = "";
		
		//First admission number in the program
		if(!$serial){
		    
    		$admission_no = date("y") - 1;
    		//DE/UTME/PG
    		if ($info->entrymode == "PG"){
    		    $admission_no .= "0";
    		    //facultyid
    		    $admission_no .= str_pad($info->facultyid, 2, "0", STR_PAD_LEFT);
    		}else if ($info->entrymode == "UG"){
    		    $admission_no .= "1";
    		    //facultyid
    		    $admission_no .= str_pad($info->facultyid, 2, "0", STR_PAD_LEFT);
    		}else if ($info->entrymode == "DE"){
    		    $admission_no .= "2";
    		    //facultyid
    		    $admission_no .= str_pad($info->facultyid, 2, "0", STR_PAD_LEFT);
    		}else if($info->entrymode == "MATRIC"){
    		    $admission_no  = date("y");
    		}
    		
    		//programid
    		$admission_no .= $info->pcode;
    		
    		//serial no
    		$admission_no .= str_pad("1", 3, "0", STR_PAD_LEFT);
		    
		}else{
		    //increment existing number
		    $serial = (int)$serial->serialValue;
		    $serial = $serial + 1;
		    $admission_no = $serial;
		}
		
		if (strlen($admission_no) == 10 or strlen($admission_no) == 7){
		    $params = [
    		    'user_id' => $info->user_id,
    		    'pnumber' => $admission_no,
    		    'entrymode'=>$info->entrymode
    		];
		    $this->registration_model->assignAdmissionNo($params);
		    $this->session->set_flashdata('msg', "Admission No Assigned Successfully");

		}else{
		    $this->session->set_flashdata('msg', "Something went wrong. Please try again");
		}
		redirect('sbsmanager/candidate/'.md5(time()).'/'.$userid, 'refresh');
	}
	
	public function printAdmissionLetter(){
	    $userid = $this->uri->segment(3);
	    $info = $this->student_model->getSimpleBio($userid);
		$data = ['info' => $info];
		
		return $this->load->view('registration/admissionLetter', $data);
	}
	
	
// 	public function view(){
// 		$_SESSION['pageTitle'] = 'Applicant Forms .::. University Portal';
	
//             $curl = curl_init();
            
//               curl_setopt_array($curl, [
//               CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/details/".$this->uri->segment(3),
//               CURLOPT_RETURNTRANSFER => true,
//               CURLOPT_ENCODING => "",
//               CURLOPT_MAXREDIRS => 10,
//               CURLOPT_TIMEOUT => 30,
//               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//               CURLOPT_CUSTOMREQUEST => "GET",
//               CURLOPT_HTTPHEADER => [
               
//               ],
//             ]);
            
//             $response = curl_exec($curl);
//             $err = curl_error($curl);
            
//             curl_close($curl);
//              $data = ['applicant_data' => json_decode($response)];
//              return $this->load->view('sbs/applicant_info', $data);
// 	}
	
	public function process(){
	    
	    $form_type = $this->uri->segment(4, 22);
		$form_status = $this->uri->segment(5, 0);
		
	    $form_hash = $this->uri->segment(3, 0);
	    $status = $this->uri->segment(4, 0);
	    $form_type = $this->uri->segment(5, 0);
        
        $curl = curl_init();
        
          curl_setopt_array($curl, [
          CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/process/".$form_hash.'/'.$status,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [
           
          ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        //var_dump($response);
        curl_close($curl);
        
        $this->session->set_flashdata('msg', 'Admission Status updated');
        redirect('sbsmanager/admission/'.$form_type, 'refresh');
	}
	

}