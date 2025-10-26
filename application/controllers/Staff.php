<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Staff extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
// 		var_dump($_SESSION); die;
		if (!isset($_SESSION['userid'])) {
			redirect('auth/logout', 'refresh');
		}
		$this->load->model('Staff_model');
		$this->load->helper('url', 'form');
	}
	public function index()
	{
		$_SESSION['pageTitle'] = 'Staff Welcome .::. University Portal';
		$info = $this->Staff_model->getBasicInfo();
		
		$_SESSION['ippis_no'] = isset($info->ippis_no) ? $info->ippis_no : "NA" ;
		$data = [
			'staff' => $info
		];
		//var_dump($_SESSION); var_dump($data); die;
		return $this->load->view('staff/index', $data);
	}
	public function viewall()
	{
		$_SESSION['pageTitle'] = 'Staff Dashboard .::. University Portal';
		$data = [
			'staff' => $this->Staff_model->getAll(),
		];
		$this->load->view('staff/viewall', $data);
	}
	public function add()
	{
		$this->Staff_model->addStaff($_POST);
		$this->session->set_flashdata('msg', 'Staff Added Successfully');
		return redirect('staff/index', 'refresh');
	}
	public function new()
	{
		$_SESSION['pageTitle'] = 'Add New Staff .::. University Portal';
		$data = [
			'states' => $this->Staff_model->getStates(),
		];
		$this->load->view('staff/new', $data);
	}
	public function view()
	{
		$_SESSION['pageTitle'] = 'My Profile .::. University Portal';
		$staffid = $this->uri->segment(3, false);
		if(!$staffid){
	    	$this->session->set_flashdata('msg', 'Invalid STaff Account');
	        return redirect('staff', 'refresh');
		}
		$data = [
			'staff' => $this->Staff_model->getBio($staffid),
			'fin_info' => $this->Staff_model->getFinInfo($staffid),
			'contact_info' => $this->Staff_model->getContactInfo($staffid),
			'acad_info' => $this->Staff_model->getAcadInfo($staffid),
		];
		//var_dump($data); die;
		return $this->load->view('staff/view', $data);
	}
	public function resetpassword()
	{
		$staffid = $this->uri->segment(3, false);
		if(!$staffid){
	    	$this->session->set_flashdata('msg', 'Invalid STaff Account');
	        return redirect('staff/viewall', 'refresh');
		}
		if($staffid){
		    $info = $this->Staff_model->getBio($staffid);
			$this->Staff_model->reset_password( $info->uniqueID, $staffid);
			$this->session->set_flashdata('msg', 'Password Reset Successfully to Staff Number');
		}
		return redirect('staff/view/'.$staffid, 'refresh');
	}
	public function loadlga()
	{
		$stateid = $this->input->post('stateid');
		$lgas = $this->Staff_model->getLGAs($stateid);
		echo json_encode($lgas);
	}
	public function edit()
	{
		$_SESSION['pageTitle'] = 'Edit Staff .::. University Portal';
		$staffid = $_SESSION['userid'];
		$data = [
			'staff' => $this->Staff_model->getBio($staffid),
			'contact_info' => $this->Staff_model->getContactInfo($staffid)
		];
		return $this->load->view('staff/edit', $data);
	}
	public function saveEdit()
	{
		$data = [
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
		$res = $this->Staff_model->saveEdit($data);
		if ($res) {
			$this->session->set_flashdata('msg', 'Update Successful');
		} else {
			$this->session->set_flashdata('msg', 'Update Failed, please try again');
		}
		return redirect('staff/view', 'refresh');
	}
	public function allocated_courses()
	{
		$_SESSION['pageTitle'] = 'My Courses .::. University Portal';
		$staffid = $_SESSION['userid'];
		$data = [
			'courses' => $this->CourseAllocation_model->getAllocatedCourses($staffid),
		];
		return $this->load->view('staff/allocated_courses', $data);
	}
	public function uploadPassport(){
	    $file = md5(time()).'.'.pathinfo($_FILES['passport']['name'], PATHINFO_EXTENSION);
	    $config = [
			'upload_path' => './passport/',
			'max_size' => 9689600, 
			'allowed_types' => 'jpg|png|jpeg|jfif|JPG|JPEG|PNG|jfif',
			'file_name' => $file
		];
		$this->upload->initialize($config);
	    if(!$this->upload->do_upload('passport')){
            $this->session->set_flashdata('msg', $this->upload->display_errors());
        }else{
            $this->Staff_model->savePassport(['passport' => $file]);
            $this->session->set_flashdata('msg', 'Update Successful');
        }
        //echo $this->db->last_query(); var_dump($this->upload->display_errors()); die;
        return redirect('staff/edit', 'refresh');
	}
	public function manager(){
	    $_SESSION['pageTitle'] = 'Staff Manager .::. University Portal';
	    $data = [
	        'staffdist' => $this->Staff_model->staffDistribution(),   
	        'apptdist' => $this->Staff_model->apptDistribution() ,
	        'facultydist' => $this->Staff_model->facultyDistribution() 
	    ];
        $this->load->view('staffmanager/index', $data);
	}
	
}
