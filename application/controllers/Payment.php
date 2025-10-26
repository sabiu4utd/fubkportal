<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;
use PhpOffice\PhpSpreadsheet\IOFactory;


class Payment extends CI_Controller
{

    private $MERCHANTID = 578871000;
    private $APIKEY = 105948;
    

    private $ServiceTypes = [
        'Acceptance_Fee' => 8296745873,
        'Acceptance_Fee_PG' => 11208926713,
        'TUITION' => 1099842539,
        'TUITION_PG' => 10137758113,
        'Accommodation' => 577213877,
        'Late_Registration' => 577225753,
        'ID_Card_Replacement' => 3671078532
    ];

    public function __construct()
    {
        parent::__construct();
        $this->load->model('payment_model');
        $this->load->model('student_model');
    }


    function getRemita_RRR($payerInfo)
    {
        $data = [
            "serviceTypeId" => $this->ServiceTypes[$payerInfo['service_type']],
            "amount" => $payerInfo['amount'],
            "orderId" => md5(time().mt_rand()),
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

    function checkPaymentStatus() {

        $rrr = $this->uri->segment(3);
        $apiHash = hash('SHA512',  $rrr. $this->APIKEY.$this->MERCHANTID);

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
        if(!$result){
            $this->session->set_flashdata('msg', "Oops!!! Somthing went wrong, Please try Again");
            redirect('payment/history/'.md5(time()), 'refresh');
        }
        $result = json_decode($result, true);
        //var_dump($result); die;
        $data = [
            'status' => ($result['status'] == 00 || $result['status'] == 01) ? "PAID" : "PENDING",
            'rrr' => $result['RRR'],
            'orderid' => $result['orderId'],
        ];
        $this->payment_model->updatePaymentStatus($data);
        $this->session->set_flashdata('msg', "Payment Status Updated Successfully");
        redirect('payment/history/'.md5(time()), 'refresh');
    }
    function checkPaymentStatus1() {

        $rrr = $this->uri->segment(3);
        $apiHash = hash('SHA512',  $rrr. $this->APIKEY.$this->MERCHANTID);

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
        if(!$result){
            $this->session->set_flashdata('msg', "Oops!!! Somthing went wrong, Please try Again");
            redirect('payment/history/'.md5(time()), 'refresh');
        }
        $result = json_decode($result, true);
        //var_dump($result); die;
        $data = [
            'status' => ($result['status'] == 00 || $result['status'] == 01) ? "PAID" : "PENDING",
            'rrr' => $result['RRR'],
            'orderid' => $result['orderId'],
        ];
        $this->payment_model->updatePaymentStatus($data);
        $this->session->set_flashdata('msg', "Payment Status Updated Successfully");
        redirect('bursary/graduation_fees', 'refresh');
    }

    public function init(){
        $student = $this->student_model->getBio($_SESSION['userid']);
        $contact = $this->student_model->getContactInfo($_SESSION['userid']);
        $rrr_invoice_amount = $_SESSION['rrr_invoice_amount'];
        $per = 100;
        if($student->entrymode == "PG"){ //percetage only applicable to PG students
            if($_SESSION['total_percentage_paid'] != 100){
                $rrr_invoice_amount = $_SESSION['rrr_invoice_amount'];
                $per = 40;
            }
        }
        
        $rrr_invoice_description = $_SESSION['rrr_invoice_description'];
        $rrr_invoice_type = $_SESSION['rrr_invoice_type']; 
        
        if($student->entrymode == "PG" and $rrr_invoice_type == "TUITION"){
            $rrr_invoice_type = "TUITION_PG";
        }
        
        $level = $student->current_level. 'L';
        if($student->entrymode == "UG"){
            if($student->current_level%100 == 10) $level = "Spill Over I";
            if($student->current_level%100 == 20) $level = "Spill Over II";
        }
        if($student->entrymode == "PG"){
            if($student->current_level == 810) $level = "MSC Year II";
            if($student->current_level == 710) $level = "PGD Year II";
            if($student->current_level == 910) $level = "PHD Year II";
        }
        $name = strtoupper($student->surname).", ".ucwords(strtolower($student->firstname." ".$student->othername))." - ".substr($student->username, 0, 10)." - ".$level;
        $phone = $contact->phone ?? "0700 000 0000";
        $email = $contact->email ?? "collections@fubk.edu.ng";
       
        
        $payerInfo = [
            "service_type" => $rrr_invoice_type,
            "amount" => $rrr_invoice_amount,
            "name" => $name,
            "email" => strtolower($email),
            "phone" => $phone,
            "description" => $rrr_invoice_description
        ];
        //var_dump($payerInfo); 
        $rrr_response = $this->getRemita_RRR($payerInfo);
        
        if(!$rrr_response || !$rrr_response['RRR']){
            $this->session->set_flashdata('msg', "Oops!!! Somthing went wrong, Please generate the Invoice Again");
            redirect('payment/paymentPage/'.md5(time()), 'refresh');
        }
        
        $data = [
            'user_id' => $_SESSION['userid'],
            'rrr' => $rrr_response['RRR'],
            'original_rrr' => $rrr_response['RRR'],
            'type' => "School Fees",
            'orderid' => md5(time()),
            'amount' => $rrr_invoice_amount,
            'level' => $student->current_level,
            'session' => $_SESSION['active_session'],
            'percentage_paid' => $per
        ];
        
        
        $res = $this->payment_model->registerPayment($data);
        if($res){
            $this->session->set_flashdata('msg', "Payment Generated Successfully");
            redirect('payment/history', 'refresh');
        }else{
            $this->session->set_flashdata('msg', "Payment Generation Failed. Please Try Again");
            redirect('payment/paymentPage/'.$rrr_invoice_type, 'refresh');
        }

    }

    public function history(){
        $_SESSION['pageTitle'] = 'Payment History .::. University Portal';

        $data = [
            'pay_history' => $this->payment_model->getPaymentHistory($_SESSION['userid']),
            'curr_session' => $this->payment_model->paymentCurrentSession($_SESSION['userid'])
        ];
        $this->load->view('payment/mypayment', $data);
    }

    public function paymentPage(){
        $_SESSION['pageTitle'] = 'Payment Summary .::. University Portal';
        $type = $this->uri->segment(3);
        
        $totalAmount = false;
        $description = false;
        $role = "single";
        $student = $this->student_model->getBio($_SESSION['userid']);
        
        $current_level = $student->current_level;
        //if($current_level == 410) $current_level = 900;
        // if($current_level == 810) $current_level = 'MSC Year II';
         //if($current_level == 910) $current_level = 'PHD Year II';
        //  if($current_level == 710) $current_level = 'PGD Year II';

        
        if($type == "TUITION"){
            $param = [
                'level' => $current_level,
                'programid' => $student->programid,
                'entrymode' =>$student->entrymode,
                'session' => $_SESSION['active_session']
            ];
            
            $totalAmount = $this->payment_model->getPaymentAmount($param);
            //echo $this->db->last_query();var_dump($param); var_dump($totalAmount); die;
            $description = ($student->entrymode == "PG"? "Postgraduate" : "Undergraduate") ." Tuition Fees for ".$_SESSION['active_session']." session";
            $role="multiple";
            
        }else if($type="ACCEPTANCE"){
            $totalAmount = $student->entrymode == "PG"? 10000: 5000;
            $description = ($student->entrymode == "PG"? "Postgraduate" : "Undergraduate") ." Admissions Acceptance Fees".$_SESSION['active_session']." session";
        }else if($type = "ACCOMODATION"){
            $totalAmount = 10000;
            $description = ($student->entrymode == "PG"? "Postgraduate" : "Undergraduate") ." Accomodation Fees".$_SESSION['active_session']." session";
        }
        
        if(!$totalAmount or !$description){
            $this->session->set_flashdata('msg', "Something went wrong. Please Try Again or contact the MIS");
            redirect('payment/history/'.md5(time()), 'refresh');
        }
        
        $data = [
            'student' =>$student,
            'type'=> $type,
            'feesInfo' => $totalAmount,
            'description' => $description,
            'role' => $role
        ];
        //var_dump($data);die;
        $this->load->view('payment/paymentpage', $data);
    }

    //Payment noficiation URL
    public function notify(){
	    //get and decode JSON data sent by remita
		$paymentinfo = file_get_contents('php://input');
		$paymentinfo=json_decode($paymentinfo, true);
		
		echo "OK";
	}

    public function schedule(){
        $result = $this->payment_model->get_programs();
        $data = ["result"=>$result];
        if($_POST){
            $programid = $this->input->post("programid");
            $level = $this->input->post('level');
            $session = $this->input->post('session');
            $type = $this->input->post('type', "UTME");
            $schedule = $this->payment_model->generatePaymentScheduleById($programid, $level, $session, $type);
            $data['schedule'] = $schedule;
            foreach($result as $row){
                if($row->id == $programid){
                    $data["program"] = $row;
                }
            }
            $data["info"] = $_POST;
        }
        $this->load->view("payment/schedule", $data);
       
    }
    public function create_item(){
        if($_POST){
            $params = [
                'item' => $this->input->post("item"),
                'amount' => $this->input->post("amount"),
                'for' => $this->input->post("type"),
                'addedby' => $_SESSION['userid'],
                'session' => $_SESSION['active_session']
            ];
            $schedule = $this->payment_model->createFeeItem($params);
        }
        $data = [
            "result" => $this->payment_model->getFeeItems($_SESSION['active_session'])
        ];
        $this->session->set_flashdata('msg', "Operation completed");
        $this->load->view("payment/create_item", $data);
       
    }
    
    public function delete_item(){
        $id = $this->uri->segment(3, -1);
        $this->payment_model->deleteFeeItem($id);
        $this->session->set_flashdata('msg', "Operation completed");
        redirect("payment/create_item", 'refresh');
    }
    
    public function edit_item(){
        $id = $this->uri->segment(3, -1);
        $item = $this->payment_model->getFeeItem($id);
        $data = ['item' => $item];
        $this->load->view("payment/edit_item", $data);
    }
    
    public function update_item(){
        $id = $this->input->post('id');
        $params = [
            'item' => $this->input->post('item'),
            'amount' => $this->input->post('amount'),
            'for' => $this->input->post('type'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->payment_model->updateFeeItem($id, $params);
        $this->session->set_flashdata('msg', "Payment Item Updated.");
        redirect("payment/create_item", 'refresh');
    }
    
    public function create_schedule(){
        $data = ["result" => $this->payment_model->get_programs()];
        if($_POST){
            $params = [
                'session' => $_SESSION['active_session']
            ];
            $data["program"] = false;
            foreach($data['result'] as $row){
                if($row->id == $_POST['programid']){
                    $data["program"] = $row;
                }
            }
            $data['items'] = $this->payment_model->getFilteredFeeItems($params);
            $data['level'] = $_POST['level'];
            $data['type'] = $_POST['type'];
            $data['session'] = $params['session'];
        }
        
        $this->load->view("payment/create_schedule", $data);
       
    }
    
    public function savePaymentSchedule(){
        $programid = $_POST['programid'];
        $level = $_POST['level'];
        $type = $_POST['type'];
        $ids = $_POST['ids'];
        $session = 70;
        
        $data = [];
        foreach($ids as $row){
            $parts = explode("-", $row);
            $data[] = [
                'programid' => $programid,
                'level' => $level,
                'itemid' => $parts[0],
                'session' => $session,
                'type' => $type,
                'addedby' => $_SESSION['userid']
            ];
        }
        $this->payment_model->savePaymentSchedule($data);
        
        
        $this->session->set_flashdata('msg', "Operation completed");
        redirect("payment/create_schedule", 'refresh');
    }

    public function nelfund(){
        $session = $this->input->post('session', $_SESSION['active_session']);
        $data["history"] = $this->payment_model->getNelfundHistory($session);
        $this->load->view("payment/nelfund", $data);
    }


    public function uploadNelfund()
    {
        if (!isset($_FILES["file"]['name'])) {
            $this->session->set_flashdata('msg', 'Please Select the Payment File to upload');
            redirect('payment/nelfund', 'refresh');
        }
    
        $uploadedFile = $_FILES['file'];
        $fileTmpPath = $uploadedFile['tmp_name'];
        $fileName = $uploadedFile['name'];
    

        $allowedTypes = ['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        if (!in_array(mime_content_type($fileTmpPath), $allowedTypes)) {
            $this->session->set_flashdata('msg', 'Invalid file type. Only Excel files are allowed.');
            redirect('payment/nelfund', 'refresh');
        }
    

        $spreadsheet = IOFactory::load($fileTmpPath);
    
        $worksheet = $spreadsheet->getActiveSheet();
    
        $data = [];
        $header = [];
    
        foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
            $rowData = [];
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
    
            foreach ($cellIterator as $cellIndex => $cell) {
                $value = $cell->getValue();
                if ($rowIndex === 1) {
                    $header[$cellIndex] = trim($value);
                } else {
                    $rowData[$header[$cellIndex]] = $value;
                }
            }
            if ($rowIndex > 1) {
                $data[] = $rowData;
            }
        }
        
        $payments = [];
    
        // Process the data (for example, save to the database or log it)
        foreach ($data as $row) {
            $payments[] = [
                "studentID" => $row['StudentID'] ?? null,
                "level" => $row['Level'] ?? 100,
                "type" => $row['Type'] ?? "School Fees",
                "amount" => $row['Amount'] ?? 0,
                "session" => $row['Session'] ?? $_SESSION['active_session'],
                "orderid" => md5(time()),
	            "updateby" => $_SESSION['userid'],
	            "rrr" => "123456789123",
	            "original_rrr" => "123456789123",
	            "percentage_paid" => 100, 
	            "status" => "Paid",
	            "datepaid" => date("Y-m-d H:i:s"),
	            "sponsor" => "Nelfund",
	            "generatedby" =>  "Bursary"
            ];
        }
        // var_dump($payments);die;
    
        // Redirect after processing
        $this->session->set_flashdata('msg', 'File uploaded and processed successfully.');
        redirect('payment/nelfund', 'refresh');
    }

}
