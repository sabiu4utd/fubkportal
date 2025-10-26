<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accomodations extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (!isset($_SESSION['userid'])) {
			redirect('auth/logout', 'refresh');
		}
		$this->load->model(['accomodation_model', 'course_model', 'student_model']);
		$this->load->helper('url', 'form');
	}
	public function index()
	{
		$_SESSION['pageTitle'] = 'Accomodations .::. University Portal';
		
		$data = [
			'hostels' => $this->accomodation_model->getHostels()
		];
		return $this->load->view('accomodations/index', $data);
	}
	
	public function hostel()
	{
		$_SESSION['pageTitle'] = 'Hostels .::. University Portal';
		$hash = $this->uri->segment(3, false);
		
		if(!$hash) {
		    $this->session->set_flashdata('msg', 'Invalid Hostel');
		    redirect('accomodations/index', 'refresh');
		}
		
		$data = [
			'hostel' => $this->accomodation_model->getHostel($hash),
		];
		$this->load->view('accomodations/hostel', $data);
	}
	
	public function updateroom()
	{
		$hotelhash = $this->uri->segment(3, false);
		$roomhash = $this->uri->segment(4, false);
		$status = $this->uri->segment(5, false);
		
		if(!$hotelhash) {
		    $this->session->set_flashdata('msg', 'Invalid Hostel');
		    redirect('accomodations/index', 'refresh');
		}
		if(!$roomhash) {
		    $this->session->set_flashdata('msg', 'Invalid Hostel');
		    redirect('accomodations/hostel/'.$hotelhash, 'refresh');
		}
		
		if($status == "Reserved"){
		    $status = 'Visible';
		}else if($status == 'Visible'){
		    $status = 'Reserved';
		}else {
		    $status = 'Reserved';
		}
		
		$this->accomodation_model->updateRoomStatus($roomhash, $status);
		$this->session->set_flashdata('msg', 'Room status update Successful');
		redirect('accomodations/hostel/'.$hotelhash, 'refresh');
	}
	
	public function room()
	{
		$_SESSION['pageTitle'] = 'Rooms .::. University Portal';
		$hostel = $this->uri->segment(3, false);
		$room = $this->uri->segment(4, false);
		
		if(!$hostel) {
		    $this->session->set_flashdata('msg', 'Invalid Hostel');
		    redirect('accomodations/index', 'refresh');
		}
		if(!$room) {
		    $this->session->set_flashdata('msg', 'Invalid Room');
		    redirect('accomodations/hostel/'.$hostel, 'refresh');
		}
		
		
		$data = [
			'bedspaces' => $this->accomodation_model->getRoom($room, $_SESSION['active_session']),
		];
		//echo $this->db->last_query();die;
		$this->load->view('accomodations/room', $data);
	}
	
	public function pending()
	{
		$_SESSION['pageTitle'] = 'Pending Reservations .::. University Portal';
		$id = $this->uri->segment(3, false);
		if(!$id) {
		    $this->session->set_flashdata('msg', 'Invalid Hostel Selected');
			redirect('accomodations/index', 'refresh');
		}
		$data = [
			'pendings' => $this->accomodation_model->getPendingReservations($id),
		];
		$this->load->view('accomodations/pending', $data);
	}
	public function history(){
		$_SESSION['pageTitle'] = 'Reservation History .::. University Portal';
		$data = [
			'myreservation' => $this->accomodation_model->getMyReservations(),
			'current_reservation' => $this->accomodation_model->getMyCurrentReservation(),
			'accomodation_payment' => $this->accomodation_model->check_current_session_accomodation_payment(),
			'fees_payment' => $this->accomodation_model->check_current_session_fees_payment(),
			//'active_session_history' => $this->course_model->getCurrentSessionCourseRegHistory($_SESSION['uniqueID']),
			
		];
		//var_dump($this->course_model->getCurrentSessionCourseRegHistory($_SESSION['uniqueID'])); die;
		return $this->load->view('accomodations/history', $data);
	}

	public function reserve_bedspace()
	{
		$_SESSION['pageTitle'] = 'My Reservation .::. University Portal';
		$info = $this->accomodation_model->user_profile();
		$hostels = $this->accomodation_model->loadHostels($info->gender);
		$data = array('hostels' => $hostels, 'info'=>$info);
		$this->load->view('accomodations/reservations', $data);
	}


	public function rooms()
	{
		$hostelid = $this->input->post('hostelid'); 
		$rooms = $this->accomodation_model->getRooms($hostelid);
		$opt = "";
	
		foreach ($rooms as $room) {
			$opt .= "<option value=" . $room->id . ">" . $room->room_name . "</option>";
		}
		echo $opt;
		
	}
	

	public function getrooms()
	{
		$hostelid = $this->input->post('hostelid'); 
		$rooms = $this->accomodation_model->getRooms2($hostelid);
		$opt = "";
	
		foreach ($rooms as $room) {
			$opt .= "<option value=" . $room->id . ">" . $room->room_name .' - (' .$room->total_reserved.' out of '.$room->capacity .")</option>";
		}
		echo $opt;
		
	}
	
	public function bedspace()
	{
	    $userid = $this->input->post('userid');
		$roomid = $this->input->post('roomid');
		$bed = $this->accomodation_model->getBedspaces($roomid);
		//$table = "<table class=table table-hover><tr><th>SN</th><th>Bedspace</th><th>Status</th><th>Reservation</th></tr>";
		$options ="";
		$i = 1;
		foreach ($bed as $row) {
			if($row->status =="Reserved"){
				//$table .= "<tr><td>" . $i . "</td><td>" . $row->bedspace . "</td><td>" . $row->status . "</td><td>This bedspace has been reserved</td></tr>";
			} else{
				$options .= "<option value=".$row->id. " class=form-control mt-3>".$row->bedspace."</option>";
			}
			
			$i++;
		}
		echo $options;
	}
	
	public function getbedspace()
	{
		$roomid = $this->input->post('roomid');
		$bed = $this->accomodation_model->getBedspaces($roomid);
		
		$opt = "";
	
		foreach ($bed as $row) {
			$opt .= "<option value=" . $row->id . ">" . $row->bedspace .' - (' .$row->status.")</option>";
		}
		echo $opt;
		
		
	}
	public function book_space()
	{
		$check_reservations = $this->accomodation_model->check_reservations();
		if(!$check_reservations){
		$data = array('userid' => $this->session->userdata('userid'), 'bedspaceid' => $this->uri->segment(3), 'session' => $_SESSION['active_session']);
		$result = $this->accomodation_model->saveReservation($data);
		if ($result) {
			$results = $this->accomodation_model->updateBedSpace($this->uri->segment(3));
			if ($results) {
				$this->session->set_flashdata('msg', 'Reservation Successful');
				redirect('accomodations/history', 'refresh');
			}
		} else {
			$this->session->set_flashdata('msg', 'You your earlier reservation was successful');
				redirect('accomodations/history', 'refresh');
		}

	}
}

    public function gen_acco_invoice(){
        $username = $this->session->userdata('uniqueID');
	    $applicant = $this->accomodation_model->user_profile();
		$amount = 25090;
		$orderid = md5($username . date('YmdHis').rand());
        
		$MERCHANTID = "578871000";
    	$APIKEY = "105948";
    	$serviceTypeId = "577213877"; 
    	$description = 'Undergraduate University accomodation form for '.trim(strtoupper($applicant->surname). ', '.ucwords($applicant->firstname. ' '.$applicant->othername));
    	 
    	$data = [
            "serviceTypeId" => $serviceTypeId,
            "amount" => $amount,
            "orderId" => $orderid,
            "payerName" => trim(strtoupper($applicant->surname). ', '.ucwords($applicant->firstname. ' '.$applicant->othername)),
            "payerEmail" => "collections@fubk.edu.ng",
            "payerPhone" => "07000000000",
            "description" => $description
        ];
        //var_dump($data); die;
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
        
        try {
            $result = json_decode(file_get_contents($url, false, $context));
           // var_dump($result); die;
            if(isset($result->RRR)){
                 $data = array(
        			'user_id' => $this->session->userdata('userid'),
        			'level' => $applicant->current_level,
        			'orderid' => $orderid,
        			'amount' => $amount,
        			'type' => 'Accommodation',
        			'status' => 'Pending',
        			'session' => $this->session->userdata('active_session'),
        			'rrr'=>$result->RRR,
        			'original_rrr'=>$result->RRR
		          );
		
		           $this->accomodation_model->save_accomodation_fees($data);
		           $this->session->flashdata("msg", "Invoice generated Successful");
		           redirect("accomodations/history", "refresh");
            } else{
                $this->session->flashdata("msg", "Invoice Not generated");
		           redirect("accomodations/history", "refresh");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }   
         
	} 
	
	public function confirm(){
		
		define("MERCHANTID", "578871000");
		define("SERVICETYPEID", "577213877");
		define("APIKEY", "105948");
		define("CHECKSTATUSURL", "https://login.remita.net/remita/ecomm");
		$orderId = $this->uri->segment(3);
		//var_dump($orderId); exit;
		$concatString = $orderId . APIKEY . MERCHANTID;
		$hash = hash('sha512', $concatString);
		$url 	= CHECKSTATUSURL . '/' . MERCHANTID  . '/' . $orderId . '/' . $hash . '/' . 'orderstatus.reg';
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result = curl_exec($ch);
		curl_close($ch);
		
		$response = json_decode($result, true);
		
		$status = 'Pending';
		
		if($response['status'] == '00' || $response['status'] == '01'){//paid
		    $status = 'Paid';
		}
		
		$data = array(
		    'rrr'=> $response['RRR'],
	        'orderid'=> $response['orderId'],
	        'status' => $status,
	        'date_paid' => date('Y-m-d H:i:s')
	    );
	    //var_dump($response);var_dump($data); die;
		$this->accomodation_model->updatePaymentStatus($data);
		$this->session->set_flashdata('msg', 'Payment Status Updated');
		redirect('accomodations/history', 'refresh');
	}
	
	public function allocate(){
	    $bed_id = $_POST['bedspace'];
	    $pnumber = $_POST['pnumber'];
	    $room_hash = $_POST['room_hash'];
	    $hostel_hash = $_POST['hostel_hash'];
	    
	    $user = $this->student_model->getBioByPnumber($pnumber);
	    if(!$user) $this->session->set_flashdata('msg', 'Invalid Admission Number');
	    
	    $bed = $this->accomodation_model->getBedspace($bed_id);
	    //var_dump($_POST);var_dump($bed); die;
	    if(!$bed){
	        $this->session->set_flashdata('msg', 'Invalid Bedspace');
	        redirect('accomodations/room/'.$hostel_hash.'/'.$room_hash, 'refresh');
	    }
	    
	    if($user->gender != $bed->hostelfor) {
	        $this->session->set_flashdata('msg', 'Bedspace is only for '.$bed->hostelfor. ' Students');
	        redirect('accomodations/room/'.$hostel_hash.'/'.$room_hash, 'refresh');
	    }

	    if($bed->datereserved != ""){
	        $this->session->set_flashdata('msg', 'Bedspace is Unavailable');
	        redirect('accomodations/room/'.$hostel_hash.'/'.$room_hash, 'refresh');
	    }
	    
	    $reservation = $this->accomodation_model->getUserReservation($user->user_id);
	    
	    if($reservation){
	        $this->session->set_flashdata('msg', 'User Already has Reservation');
	        redirect('accomodations/room/'.$hostel_hash.'/'.$room_hash, 'refresh');
	    }
	    
	    
	    $res = $this->accomodation_model->makePriorityReservation($user->user_id, $bed_id);
	    $this->session->set_flashdata('msg', 'Allocation Successfull');
	    redirect('accomodations/room/'.$hostel_hash.'/'.$room_hash, 'refresh');
	    
	}
	
	public function priorityapproval(){
	   $status = $this->uri->segment(3, 0);
	   $id = $this->uri->segment(4, false);
	   
	   if (!$id) {
	       $this->session->set_flashdata('msg', 'Invalid Reservation');
	       redirect('accomodations/pending', 'refresh');
	   }
	   
	   
	   $res = $this->accomodation_model->updatePriorityReservation($id, $status);
	 if($res){
	       $this->session->set_flashdata('msg', 'Update Completed');
	        redirect('accomodations/', 'refresh');
	 } else {
	      $this->session->set_flashdata('msg', 'Update Unsuccessful');
	        redirect('accomodations/', 'refresh');
	 }
	 
	   
	}
	
	public function approved(){
	   $id = $this->uri->segment(3, false);
	   $status = $this->uri->segment(4, "Pending"); 
	   
	   if (!$id) {
	       $this->session->set_flashdata('msg', 'Invalid Hostel');
	       redirect('accomodations/index', 'refresh');
	   }
	   $data = [
	       'approved' => $this->accomodation_model->getList($id, $status)
	   ];
	   //var_dump($res); die;echo $this->db->last_query(); die;
	   $this->load->view('accomodations/approved', $data);
	   
	}
	
	public function clearance(){
	    $data = [
	        "result" => $user = $this->student_model->getBioByPnumber($_SESSION['pnumber']),
	        "reservation" => $this->accomodation_model->getMyCurrentReservation2(),
	   ];
	    $this->load->view("accomodations/clearance", $data);
	}
	
	public function reallocate(){
	   $hostelid = $this->uri->segment(3, false);
	   $roomid = $this->uri->segment(4, false);
	   $reservation_id = $this->uri->segment(5, false);
	   if (!$reservation_id) {
	       $this->session->set_flashdata('msg', 'Invalid Hostel');
	       redirect('accomodations/room/'.$hostelid.'/'.$roomid, 'refresh');
	   }
	   
	   $data = [
	       'hostels' => $this->accomodation_model->getHostels(),
	       'reservation' => $this->accomodation_model->getReservationByID($reservation_id)
	   ];
	   $this->load->view("accomodations/reallocate", $data);
	}
	public function updateallocation(){
	    
	  $bedspaceid = $this->input->post("bedspace"); 
	  $id = $this->input->post("reservation_id"); 
	  $oldbedspaceid = $this->input->post("oldbedspaceid"); 
	   
	   $r = $this->accomodation_model->updateReservation($id, $bedspaceid, $oldbedspaceid);
	   if ($r) {
	       $this->session->set_flashdata('msg', 'Bedspace Re-allocation successful');
	       redirect('accomodations/', 'refresh');
	   }
	   
	}
	public function search(){
	   
	    $result = $this->accomodation_model->search_reservation($this->input->post('pnumber'));
	    $data = array('result'=>$result);
	    $this->load->view("accomodations/search_result", $data);
	    
	}
	public function revoke(){
	    $hostelid = $this->uri->segment(3); 
	    $userid = $this->uri->segment(4);
	    $bedspaceid = $this->uri->segment(5); 
	    $total = $this->accomodation_model->get_total_reserved($hostelid); 
	    $total_reserved = $total->total_reserved; 
	    $new_total = $total_reserved - 1; 
	    $this->accomodation_model->revoke($userid);
	    $result=$this->accomodation_model->update_reservation_count($hostelid, $new_total);
	    if($result){
	        $this->accomodation_model->update_bedspace($bedspaceid);
	        $this->session->set_flashdata('msg', 'Reservation Revoked successfully');
	       redirect('accomodations/load_hostel_applicant/'.$hostelid, 'refresh');
	    }
	    
	}
	public function reserve_space(){
	   	    $data = array(
	        'userid'=>$this->session->userdata("userid"),
	        'hostelid'=>$this->input->post("hostel"),
	        'session'=> $this->session->userdata("active_session"),
	        'reservation_status'=>'Pending'
	        );
	    $this->accomodation_model->save_reservation($data);
	    $result = $this->accomodation_model->get_total_reserved($this->input->post("hostel"));
	    $total = $result->total_reserved+1;
	    $result = $this->accomodation_model->update_hostel($this->input->post("hostel"), $total);
	    if($result){
	        	$this->session->set_flashdata('msg', 'Reservation Successful');
				redirect('accomodations/history', 'refresh');
	    }
	    
	}
	public function load_hostel_applicant(){
	   $hostelid = $this->uri->segment(3);
	   $result = $this->accomodation_model->load_hostel_applicant($hostelid);
	   $rooms = $this->accomodation_model->loadRoomsByHostelId($hostelid);
	   $data = array('result'=>$result, 'rooms'=>$rooms);
	   $this->load->view("accomodations/load_hostel_applicant", $data);
	}
	public function loadRoom(){
	    $hostelid = $this->uri->segment(3);
	    $userid = $this->uri->segment(4);
	    $rooms = $this->accomodation_model->loadRoomsByHostelId($hostelid);
	    //var_dump($rooms); exit;
	    $data = array("rooms"=>$rooms, 'userid'=>$userid);
	    $this->load->view("accomodations/loadRooms", $data);
	}
	public function reserve_space_for_applicant(){
	    $hostelid = $this->input->post("hostelid");
	    $userid = $this->input->post("userid");
	    $bedspaceid = $this->input->post("bedspaceid");
	    $result = $this->accomodation_model->reserve_space_for_applicant($userid, $bedspaceid);
	  
	       if($result){
	        	$this->session->set_flashdata('msg', 'Reservation Successful');
				redirect('accomodations/load_hostel_applicant/'.$hostelid, 'refresh');
	    
	   }
	    
	}
	public function no_remita_record(){
	    $result = $this->accomodation_model->accomodation_yet_to_generate_remita();
	    $data = array('result'=>$result);
	    $this->load->view("accomodations/approved_no_remita", $data);
	}
	
}