<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {
	
	public function getBio($id){
		$result = $this->db
			->from('gen_users')
			->join('ug_profiles', 'gen_users.userid = ug_profiles.user_id')
			->join('gen_programme', 'gen_programme.id = ug_profiles.programid')
			->join('gen_departments', 'gen_departments.id = gen_programme.deptid')
			->join('gen_divisions', 'gen_divisions.id = gen_departments.division_id')
			->where('ug_profiles.user_id', $id)
			->get()->row();
		//echo $this->db->last_query();
		return $result;
	}

	public function getSimpleBio($id){
		$result = $this->db
		    ->from('gen_users') 
			->join('ug_profiles', 'gen_users.userid = ug_profiles.user_id')
			->join('gen_programme', 'gen_programme.id = ug_profiles.programid')
			->join('gen_departments', 'gen_departments.id = gen_programme.deptid')
			->join('gen_divisions', 'gen_divisions.id = division_id')
			->where('ug_profiles.user_id', $id)
			->get()->row();
		//echo $this->db->last_query();
		return $result;
	}

	public function getSimpleBioByJAMBNo($id){
		$result = $this->db
		    ->select('*')
		    ->from('gen_users')
			->join('ug_profiles', 'gen_users.userid = ug_profiles.user_id')
			->join('gen_programme', 'gen_programme.id = ug_profiles.programid')
			->join('gen_departments', 'gen_departments.id = ug_profiles.deptid')
			->where('lower(ug_profiles.jamb_no)', strtolower($id))
			//->where('session_admitted', $_SESSION['active_session'])
			->get();
			//echo $this->db->last_query();
		return $result->row() ? $result->row() : false;
	}

	public function getGraduateByAdmissionNo($admissionNo){
		$result = $this->db
		    ->from('graduation_list')
			->join('ug_profiles', 'graduation_list.admission_no = ug_profiles.pnumber', 'left')
			->where('graduation_list.admission_no', $admissionNo)
			->get();
		return $result->row() ? $result->row() : false;
	}

	public function getBioByPnumber($pnumber){
		$this->db
			->from('gen_users')
			->join('ug_profiles', 'gen_users.userid = ug_profiles.user_id')
			->join('gen_programme', 'gen_programme.id = ug_profiles.programid')
			->join('gen_departments', 'gen_departments.id = gen_programme.deptid')
			->join('gen_divisions', 'gen_divisions.id = gen_departments.division_id')
			->where('gen_users.uniqueID', $pnumber);
		return $this->db->get()->row();
		
	}

	public function getContactInfo($id){
		$this->db
			->from('gen_contacts')
			->join('gen_states', 'gen_states.stateid = gen_contacts.stateid')
			->join('gen_lgas', 'gen_lgas.id = gen_contacts.lgaid')
			->where('user_id', $id);
		return  $this->db->get()->row();
	}

	public function getPaymentInfo($data){
		return $this->db->get_where('ug_payments', $data)->row();
	}

	public function saveEdit($data){
		$this->db->where('user_id', $_SESSION['userid']);
		return $this->db->update('gen_contacts', $data);
	}

	public function saveProfile($data, $userid){
	    $this->db->where('user_id', $userid)->delete('gen_contacts');
	    $this->db->reset_query();
		return $this->db->where('user_id', $userid)->insert('gen_contacts', $data);
	}

	public function savePassport($data){
		$this->db->where('user_id', $_SESSION['userid']);
		return $this->db->update('ug_profiles', $data);
	}

	public function updateWorkflow($data){
		$this->db->set($data['column'], $data['value'], false);
		$this->db->where('user_id', $data['userid'], true);
		return $this->db->update('ug_registration_workflow');
	}

	public function getAllStudentByDeptID($deptid){
		$this->db->where('deptid', $deptid);
		$this->db->where('confirm_status', 'Confirmed');
		$this->db->where('usertype', 'student');
		$this->db->order_by('pnumber', 'asc');
		$this->db->limit(10);
		return $this->db->get('ug_profiles')->result();
	}
	
	public function getStates(){
		$this->db
			->from('gen_states')
			->order_by('state_name', 'asc');
		return $this->db->get()->result();
	}

	public function getLGAs(){
		$this->db
			->select('id, lga_name')
			->from('gen_lgas')
			->order_by('lga_name', 'asc');
		return $this->db->get()->result();
	}

	public function getLGAsByStateID($stateid){
		$this->db
			->select('id, lga_name')
			->from('gen_lgas')
			->where('state_id', $stateid)
			->order_by('lga_name', 'asc');
		return $this->db->get()->result();
	}

	/*public function getAll(){
		$this->db
			->from('ug_profiles')
			->join('gen_users', 'users.userid = profiles.user_id')
			->join('staff_designations', 'profiles.designation_id = designations.id')
			->order_by('username', 'asc');
		return $this->db->get()->result();
	}

	public function addStaff($data){
		return $this->db->insert('staff', $data);
	}


	public function getStaff($hash){
		$this->db
			->from('gen_users')
			->join('staff_profiles', 'users.userid = profiles.user_id')
			->where('gen_users.user_hash', $hash);
		return $this->db->get()->row();
	}

	public function getStates(){
		$this->db
			->from('gen_states')
			->order_by('state_name', 'asc');
		return $this->db->get()->result();
	}

	public function getLGAs($stateid){
		$this->db
			->select('id, lga_name')
			->from('gen_lgas')
			->where('state_id', $stateid)
			->order_by('lga_name', 'asc');
		return $this->db->get()->result();
	}

	public function getFinInfo($staffid){
		$this->db
			->from('staff_finance_info')
			->join('staff_banks', 'staff_banks.id = staff_finance_info.bank_id')
			->join('staff_pension_administrators', 'staff_pension_administrators.id = staff_finance_info.pfa_admin_id')
			->join('staff_salary_structure', 'staff_salary_structure.id = staff_finance_info.salary_structure')
			->where('staff_finance_info.userid', $staffid);
		return $this->db->get()->row();
	}

	public function getAcadInfo($staffid){
		return $this->db
			->get_where('staff_academic_qualifications', ['userid' => $staffid])
			->result();
	}*/

}
