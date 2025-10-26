<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Form extends CI_Controller {
    
    private $MERCHANTID = 578871000;
    private $APIKEY = 105948;

    
	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['userid'])){
			redirect('auth/logout', 'refresh');
		}
		$this->load->library('upload');
		$this->load->model(['student_model', 'form_model']);
	}
	
	public function index(){
	    $_SESSION['pageTitle'] = 'Other Forms .::. University Portal';
		$info = $this->student_model->getBio($_SESSION['userid']);
		$forms = $this->form_model->getOtherForms();
		$myforms = $this->form_model->getMyOtherForms();
		
		$data = [
			'student' => $info,
			'forms' => $forms,
			'myforms' => $myforms
		];
		return $this->load->view('forms/myforms', $data);
	}
	
	public function findFormPrice(){
	    
		$id = $_POST['id'];
		
		$forms = $this->form_model->findFormPrice($id);
		
		echo $forms->amount;
	
	}
	
	public function orderForm(){
	    
	    $serviceIDs = [
	        "Change of Course" => "577226445",
	        "ID Card Replacement" => "3671078532",
	        "Deferment of Admission" => "577220251",
	        "Upgrade of Programme" => "577224657",
	        "Transcript Processing (Local)" => "6710172757",
	        "Transcript Processing (Foreign)" => "577222863",
	        "Change of Programme" => "3487149164",
	        "Late Registration" => "577225753",
	        "Add & Drop" => "577259636",
	        "Inter University Transfer" => "3820246302", 
	        "Inter Faculty Transfer" => "2668421555", 
	        "Intra Faculty Transfer" => "2668421555",
	        "Other Fees" =>"577224818", 
	        
	    ];
	    
	    $form_name = $_POST['form_name'];
	    $form_amount = $_POST['form_amount'];

	    $student = $this->student_model->getBio($_SESSION['userid']);
        $contact = $this->student_model->getContactInfo($_SESSION['userid']);
        
        $level = $student->current_level. 'L';
        if($student->current_level%100 == 10) $level = "Spill Over I";
        if($student->current_level%100 == 20) $level = "Spill Over II";
        $name = strtoupper($student->surname).", ".ucwords(strtolower($student->firstname." ".$student->othername))." - ".substr($student->username, 0, 10)." - ".$level;
        $phone = $contact->phone ? $contact->phone : "0700 000 0000";
        $email = $contact->email ? $contact->email : "collections@fubk.edu.ng";
        
        $description = "Purchase for ".$form_name." form by ".$name." in ".$_SESSION['active_session'];
        

        $payerInfo = [
            "serviceid" => $serviceIDs[$form_name],
            "amount" => $form_amount,
            "name" => $name,
            "email" => strtolower($email),
            "phone" => $phone,
            "description" => $description,
            "orderid" => md5(time().mt_rand())
        ];
        
        $response = $this->getRemita_RRR($payerInfo);
        //print_r($response["RRR"]);
        if (isset($response) and isset($response["RRR"])){
    	    $data = [
    		    'type' => $_POST['form_name'],
    		    'amount' => $_POST['form_amount'],
    		    'user_id' => $_SESSION['userid'],
    		    'level' => $_SESSION['current_level'],
    		    'session' => $_SESSION['active_session'],
    		    'updateby' => $_SESSION['userid'],
    		    'rrr' => $response["RRR"],
    		    'original_rrr' =>$response["RRR"],
    		    'orderid' => $payerInfo["orderid"]
    		];
    		
    		echo $this->form_model->orderForm($data) ? true : false;
    		
        }else{
            echo false;
        }
	}
	
	
    function getRemita_RRR($payerInfo)
    {
        $data = [
            "serviceTypeId" => $payerInfo['serviceid'],
            "amount" => $payerInfo['amount'],
            "orderId" => $payerInfo['orderid'],
            "payerName" => $payerInfo['name'],
            "payerEmail" => $payerInfo['email'],
            "payerPhone" => $payerInfo['phone'],
            "description" => $payerInfo['description']
        ];

        $data['apiHash'] = hash('SHA512', $this->MERCHANTID . $data['serviceTypeId'] . $data['orderId'] . $data['amount'] .$this->APIKEY);

        $url = "https://login.remita.net/remita/exapp/api/v1/send/api/echannelsvc/merchant/api/paymentinit";
        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => json_encode($data),
                'header' =>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n" .
                    "Authorization:remitaConsumerKey=".$this->MERCHANTID.",remitaConsumerToken=" . $data['apiHash']
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result ? json_decode($result, true) : false ;
    }
}