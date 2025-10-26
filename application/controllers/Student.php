<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Student extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['userid'])){
			redirect('auth/logout', 'refresh');
		}
		$this->load->library('upload');
		$this->load->model(['student_model', 'registration_model', 'payment_model']);
	}
	public function index(){
	    $_SESSION['pageTitle'] = 'Student Welcome .::. University Portal';
		$info = $this->student_model->getBio($_SESSION['userid']);
		$_SESSION['fullname'] = strtoupper($info->surname).' '.ucwords(strtolower($info->firstname.' '.$info->othername));
		$_SESSION['pnumber'] = substr($info->username, 0, 10);
		$_SESSION['programid'] = $info->programid;
		$_SESSION['current_level'] = $info->current_level;
		
		//check if payment is complete
		$params = [
		    'type' => 'School Fees',
		    'user_id' => $_SESSION['userid'],
		    'session' => $_SESSION['active_session']
		];
		
		$data = [
			'student' => $info,
			'payments' => $this->payment_model->getPaymentFullorPartial($params)
		];
		return $this->load->view('student/index', $data);
	}
	public function view(){
		$_SESSION['pageTitle'] = 'My Profile .::. University Portal';
		$studentid = $_SESSION['userid'];
		$data = [
			'student' => $this->student_model->getBio($studentid),
			'contact_info' => $this->student_model->getContactInfo($studentid),
		];
		return $this->load->view('student/view', $data);
	}
	public function edit(){
	    $_SESSION['pageTitle'] = 'Edit Student .::. University Portal';
		$studentid = $_SESSION['userid'];
		$data = [
			'student' => $this->student_model->getBio($studentid),
			'contact_info' => $this->student_model->getContactInfo($studentid),
			'states' => $this->student_model->getStates(),
			'lgas' => $this->student_model->getLGAs(),
		];
		return $this->load->view('student/edit', $data);
	}
	public function saveEdit(){
        $data = [
            'stateid' => trim($this->input->post('state')), 
            'lgaid' => trim($this->input->post('lga')), 
            'phone' => trim($this->input->post('phone')), 
            'email' => trim($this->input->post('personal_email')), 
            'caddress' => trim($this->input->post('contact_address')),
            'haddress' => trim($this->input->post('permanent_address')),
            'nok_name' => trim($this->input->post('nok_name')),
            'nok_relationship' => trim($this->input->post('nok_relationship')),
            'nok_phone' => trim($this->input->post('nok_phone')),
            'nok_email' => trim($this->input->post('nok_email')),
            'nok_address' => trim($this->input->post('nok_address')),
        ];
		if($this->student_model->saveEdit($data)){
			$data = [
				'column' => 'bio_update',
				'value' => 1,
				'userid' => $_SESSION['userid']
			];
			if($this->student_model->updateWorkflow($data)){
				$_SESSION['workflow']->bio_update = 1;
			}
		    $this->session->set_flashdata('msg', 'Update Successful');
		}else{
		    $this->session->set_flashdata('msg', 'Update Failed, please try again');
		}
		return redirect('student/view', 'refresh');
	}
	
	public function saveprofile(){
	    //var_dump($_SESSION["userid"]); die;
        $data = [
            'stateid' => trim($this->input->post('state')), 
            'lgaid' => trim($this->input->post('lga')), 
            'phone' => trim($this->input->post('phone')), 
            'email' => trim($this->input->post('personal_email')), 
            'caddress' => trim($this->input->post('contact_address')),
            'haddress' => trim($this->input->post('permanent_address')),
            'nok_name' => trim($this->input->post('nok_name')),
            'nok_relationship' => trim($this->input->post('nok_relationship')),
            'nok_phone' => trim($this->input->post('nok_phone')),
            'nok_email' => trim($this->input->post('nok_email')),
            'nok_address' => trim($this->input->post('nok_address')),
            'user_id' => $_SESSION["userid"]
        ];
        
		if($this->student_model->saveProfile($data, $_SESSION["userid"])){
		    $this->session->set_flashdata('msg', 'Update Successful');
		}else{
		    $this->session->set_flashdata('msg', 'Update Failed, please try again');
		}
		//echo $this->db->last_query();
		return redirect('student/view', 'refresh');
	}
	public function uploadPassport(){
	   // var_dump($_FILES);
	    if($_FILES["passport"]['size'] < 2097152 or $_FILES["passport"]['size'] > 4194304){
	        $this->session->set_flashdata('msg', 'Passport size must be between 2MB and 4MB');
	    }
	    $filename = md5(rand().time()).'.'.pathinfo($_FILES['passport']['name'], PATHINFO_EXTENSION);
	    $config = [
			'upload_path' => './passport/',
			'allowed_types' => 'jpg|png|jpeg|JPG|JPEG|PNG|jfif',
			'file_name' => $filename
		];
		$this->upload->initialize($config);
	    if(!$this->upload->do_upload('passport')){
            $this->session->set_flashdata('msg', $this->upload->display_errors());
        }else{
            $this->student_model->savePassport(['passport' => $filename]);
            $this->session->set_flashdata('msg', 'Update Successful');
        }
        //echo $this->db->last_query(); var_dump($this->upload->display_errors()); die;
        return redirect('student/edit', 'refresh');
	}

	public function studentmanager(){
		$_SESSION['pageTitle'] = 'Student Manager .::. University Portal';
		$sess = $this->uri->segment(3, false);
		$_SESSION['adm_session'] = $sess ? str_replace("_", "/", $sess) : $_SESSION['active_session'] ; 
		$data = [
            'adm_session' => $this->registration_model->getAdmissionSessions(),
            'adm_list' => $this->registration_model->getAdmissionList($_SESSION['adm_session']),
            'adm_summary' => $this->registration_model->getAdmissionSummary()
        ];
		return $this->load->view('studentmanager/index', $data);
	}
}