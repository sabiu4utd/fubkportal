<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataEntry extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('DataEntry_model');
		$this->load->model('Staff_model');
	}

	public function index(){
		$_SESSION['pageTitle'] =  'Data Entry Index .::. HR-FUBK';
		$data = [
			'staff' => $this->Staff_model->getInfo(),
			'data_entry' => $this->DataEntry_model->getInfo(),
		];
		return $this->load->view('dataentry/index', $data);
	}

	public function find(){
		$_SESSION['pageTitle'] =  'Data Entry Search .::. HR-FUBK';
		$employeeID = $this->input->post('search');
		$staffid = $this->DataEntry_model->getStaffByEmployeeID($employeeID);

		if(!$staffid){
			$this->session->set_flashdata('msg', 'Invalid Staff ID provided');
			redirect('dataentry/index', 'refresh');
		} 

		$staffid =  $staffid->userid;

		$_SESSION['activeStaffID'] = $staffid;

		$data = [
			'staff' => $this->Staff_model->getBio($staffid),
			'fin_info' => $this->Staff_model->getFinInfo($staffid),
			'contact_info' => $this->Staff_model->getContactInfo($staffid),
			'acad_info' => $this->Staff_model->getAcadInfo($staffid),
		];
		
		return $this->load->view('dataentry/view', $data);
	}

	public function view(){
		$staffid = $_SESSION['activeStaffID'];
		if(!$staffid) redirect('dataentry/index', 'refresh');

		$data = [
			'staff' => $this->Staff_model->getBio($staffid),
			'fin_info' => $this->Staff_model->getFinInfo($staffid),
			'contact_info' => $this->Staff_model->getContactInfo($staffid),
			'acad_info' => $this->Staff_model->getAcadInfo($staffid),
		];
		return $this->load->view('dataentry/view', $data);
	}

	public function editbio(){
		$staffid = $_SESSION['activeStaffID'];
		if(!$staffid) redirect('dataentry/index', 'refresh');

		$data = [
			'staff' => $this->Staff_model->getBio($staffid),
			'contact_info' => $this->Staff_model->getContactInfo($staffid),
			'states' => $this->Staff_model->getStates(),
		];

		return $this->load->view('dataentry/editbio', $data);
	}

	public function editemployment(){
		$staffid = $_SESSION['activeStaffID'];
		if(!$staffid) redirect('dataentry/index', 'refresh');

		$data = [
			'staff' => $this->Staff_model->getBio($staffid),
			'contact_info' => $this->Staff_model->getContactInfo($staffid),
			'fin_info' => $this->Staff_model->getFinInfo($staffid),
			'designations' => $this->DataEntry_model->getAllDesignations(),
			'appt_types' => $this->DataEntry_model->getAllApptTypes(),
			'divisions' => $this->DataEntry_model->getAllDivisions(),
			'departments' => $this->DataEntry_model->getAllDepartments(),
		];

		return $this->load->view('dataentry/editemployment', $data);
	}

	public function editfinance(){
		$staffid = $_SESSION['activeStaffID'];
		if(!$staffid) redirect('dataentry/index', 'refresh');

		$data = [
			'finance' => $this->Staff_model->getFinInfo($staffid),
			'banks' => $this->DataEntry_model->getAllBanks(),
			'pfas' => $this->DataEntry_model->getAllPFAs(),
			'salary_structures' => $this->DataEntry_model->getAllSalaryStructures(),
		];

		return $this->load->view('dataentry/editfinance', $data);
	}

	public function load_depts(){
		$division_id = $this->input->post("divisionid");
		$depts = $this->DataEntry_model->getAllDepartmentsByDivision($division_id);
		echo json_encode($depts);
	}

	public function updatebio(){
		$staffid = $_SESSION['activeStaffID'];
		if(!$staffid) redirect('dataentry/index', 'refresh');
		
		$data = [
			'title' => $this->input->post("title"),
			'surname' => $this->input->post("surname"),
			'firstname' => $this->input->post("firstname"),
			'othernames' => $this->input->post("othernames"),
			'gender' => $this->input->post("gender"),
			'marital_status' => $this->input->post("marital_status"),
			'dob' => $this->input->post("dob")
		];

		if($this->DataEntry_model->updateBio($staffid, $data)){
			$data = [
				'stateid' => $this->input->post("state"),
				'lgaid' => $this->input->post("lga_name"),
				'town' => $this->input->post("town"),
				'personal_phone' => $this->input->post("personal_phone"),
				'personal_email' => $this->input->post("personal_email"),
				'contact_address' => $this->input->post("contact_address"),
				'permanent_address' => $this->input->post("permanent_address")
			];

			if($this->DataEntry_model->updateContact($staffid, $data)){
				$this->session->set_flashdata('msg', 'Biodata updated successfully');
			}else{
				$this->session->set_flashdata('msg', 'Biodata update FAILED. Please try again');
			}
		}else{
			$this->session->set_flashdata('msg', 'Biodata update FAILED. Please try again');
		}
	
		return redirect('dataentry/view', 'refresh');
	}

	public function updateEmploy(){
		$staffid = $_SESSION['activeStaffID'];
		if(!$staffid) redirect('dataentry/index', 'refresh');
		
		$this->session->set_flashdata('msg', 'Employment Information update FAILED. Please try again');
		
		$data = [
			'employee_no' => $this->input->post("employee_no"),
			'registry_file_no' => $this->input->post("registry_file_no"),
			'designation_id' => $this->input->post("designation"),
			'appt_type' => $this->input->post("appt_type"),
			'dofa' => $this->input->post("dofa"),
			'dolp' => $this->input->post("dolp") ? $this->input->post("dolp") : "N/A",
			'division_id' => $this->input->post("division"),
			'dept_id' => $this->input->post("department")
		];

		if($this->DataEntry_model->updateEmployment($staffid, $data)){
			$this->session->set_flashdata('msg', 'Employment Information updated successfully');
		}
	
		return redirect('dataentry/view', 'refresh');
	}

	public function updateFinance(){
		$staffid = $_SESSION['activeStaffID'];
		if(!$staffid) redirect('dataentry/index', 'refresh');
		
		$this->session->set_flashdata('msg', 'Financial Information update FAILED. Please try again');
		
		$data = [
			'ippis_no' => $this->input->post("ippis_no"),
			'bvn' => $this->input->post("bvn"),
			'bank_id' => $this->input->post("bank"),
			'account_number' => $this->input->post("account_no"),
			'pfa_admin_id' => $this->input->post("pfa_admin"),
			'pfa_pin' => $this->input->post("pfa_pin"),
			'salary_structure' => $this->input->post("salary_structure"),
			'grade_level' => $this->input->post("grade_level"),
			'step' => $this->input->post("step"),
		];

		if($this->DataEntry_model->updateFinance($staffid, $data)){
			$this->session->set_flashdata('msg', 'Financial Information updated successfully');
		}
		
		return redirect('dataentry/view', 'refresh');
	}
	
	public function paymentanalysis(){
	    $start = 0;
	    $step = 500;
	    $last = 6725;
	    
	    while($start < $last){
    	    $sql = "select ug_payments.id as payment_id, ug_payments.user_id, current_level as level, gen_settings.id as session, entrymode, programid from ug_payments join ug_profiles on ug_profiles.user_id = ug_payments.user_id join gen_settings on gen_settings.session = ug_payments.session where ug_payments.session = '2022/2023' and ug_payments.type = 'School Fees'  limit ".$start.", ".$step;
    	    $pays = $this->db->query($sql)->result();
    	    foreach($pays as $row){
    	        $sql2 = "insert into ug_payments_items (payment_id, user_id, fee_item_id, amount, session, level) SELECT ".$row->payment_id.",".$row->user_id.", itemid as fee_item_id, amount, ug_fees_schedule.session, ".$row->level." FROM `ug_fees_schedule` join ug_fee_item on ug_fee_item.id = ug_fees_schedule.itemid where ug_fees_schedule.session = '".$row->session."' and ug_fees_schedule.type='".$row->entrymode."' and level = '".$row->level."' and programid = '".$row->programid."'";
    	        $this->db->query($sql2);
    	        
    	    }
    	   $start += $step + 1;
	    }
	}
}
