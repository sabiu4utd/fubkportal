<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Management extends CI_Controller {

	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['userid'])){
			redirect('auth/logout', 'refresh');
		}
		$this->load->model('Staff_model');
		$this->load->model('Notifications_model');
	}

	public function index(){
	    $_SESSION['pageTitle'] = 'Staff Welcome .::. University Portal';
		$info = $this->Staff_model->getInfo();
		
		$_SESSION['ippis_no'] = $info->ippis_no;
		$_SESSION['fullname'] = strtoupper($info->surname).' '.ucwords(strtolower($info->firstname.' '.$info->othernames));
		$data = ['staff' => $info];
		return $this->load->view('mgt/index', $data);
	}

	public function viewall(){
		$_SESSION['pageTitle'] = 'Staff Dashboard .::. University Portal';
		$data = [
			'staff' => $this->Staff_model->getAll(),
		];
		$this->load->view('staff/viewall', $data);
	}

	public function add(){
		$this->Staff_model->addStaff($_POST);
		$this->session->set_flashdata('msg', 'Staff Added Successfully');
		return redirect('staff/index', 'refresh');
	}

	public function new(){
	    $_SESSION['pageTitle'] = 'Add New Staff .::. University Portal';
		$data = [
			'states' => $this->Staff_model->getStates(),
		];
		$this->load->view('staff/new', $data);
	}

	public function view(){
		$_SESSION['pageTitle'] = 'My Profile .::. University Portal';
		$staffid = $_SESSION['userid'];

		$data = [
			'staff' => $this->Staff_model->getBio($staffid),
			'fin_info' => $this->Staff_model->getFinInfo($staffid),
			'contact_info' => $this->Staff_model->getContactInfo($staffid),
			'acad_info' => $this->Staff_model->getAcadInfo($staffid),
		];
		return $this->load->view('staff/view', $data);
	}

	public function loadlga(){
	    $stateid = $this->input->post('stateid');
		$lgas = $this->Staff_model->getLGAs($stateid);
		echo json_encode($lgas);
	}
	
	public function edit(){
	    $_SESSION['pageTitle'] = 'Edit Staff .::. University Portal';

		$staffid = $_SESSION['userid'];

		$data = [
			'staff' => $this->Staff_model->getBio($staffid),
			'contact_info' => $this->Staff_model->getContactInfo($staffid)
		];
		return $this->load->view('staff/edit', $data);
	}
	
	public function saveEdit(){
        $data = [
            'personal_phone' => trim($this->input->post('phone')), 
            'personal_email' => trim($this->input->post('personal_email')), 
            'contact_address' => trim($this->input->post('contact_address')),
            'permanent_address' => trim($this->input->post('permanent_address')),
            'nok_name' => trim($this->input->post('nok_name')),
            'nok_relationship' => trim($this->input->post('nok_relationship')),
            'nok_phone' => trim($this->input->post('nok_phone')),
            'nok_email' => trim($this->input->post('nok_email')),
            'nok_address' => trim($this->input->post('nok_address')),
        ];
		if($this->Staff_model->saveEdit($data)){
		    $this->session->set_flashdata('msg', 'Update Successful');
		}else{
		    $this->session->set_flashdata('msg', 'Update Failed, please try again');
		}
		return redirect('staff/view', 'refresh');
	}
	
	public function allocated_courses(){
        $_SESSION['pageTitle'] = 'My Courses .::. University Portal';

		$staffid = $_SESSION['userid'];

		$data = [
			'courses' => $this->CourseAllocation_model->getAllocatedCourses($staffid),
		];
		return $this->load->view('staff/allocated_courses', $data);
    }
}
