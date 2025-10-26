<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Card_model extends CI_Model {
    
	public function getSessions(){
		return $this->db
            ->select('session_admitted')
			->from('ug_profiles')
			->group_by('session_admitted')
			->order_by('session_admitted', 'desc')
            ->get()->result();
	}


	public function getSummaryByFaculty($session){
		return $this->db
            ->select('session_admitted, division_name, prog_abbr, programid, count(user_id) as total')
			->from('ug_profiles')
            ->join('gen_divisions', 'gen_divisions.id = facultyid')
            ->join('gen_programme', 'gen_programme.id = programid')
            ->where('session_admitted', $session)
            ->where('pnumber !=', "UNASSIGNED")
			->group_by('programid')
			->order_by('session_admitted', 'desc')
            ->get()->result();
	}

    public function getStudentsByProgramID($id, $sess){
        return $this->db
            ->from('ug_profiles')
            ->join('gen_programme', 'gen_programme.id = programid')
            ->where('session_admitted', $sess)
			->where('programid', $id)
			->where('pnumber !=', 'UNASSIGNED')
			->order_by('current_level', 'asc')
			->order_by('pnumber', 'asc')
            ->get()->result();
    }

    public function getStaffList(){
        $sql = "SELECT registry_file_no, surname, firstname, othername, staff_appt_types.appointment_type, designation,employee_type, employee_mode, dept_name, passport,staff_profiles.user_id FROM `staff_profiles` join staff_designations on staff_designations.id = designation_id join staff_appt_types on staff_appt_types.id = staff_profiles.appt_type join staff_departments on staff_departments.id = dept_id order by surname asc";
        return $this->db->query($sql)->result();
    }

    public function getIDCardInfoStaff($id){
        $sql = "SELECT registry_file_no, surname, firstname, othername, staff_appt_types.appointment_type,dept_id, staff_appt_types.id as appt_id, designation,designation_id,employee_type, employee_mode, dept_name, passport,staff_profiles.user_id FROM `staff_profiles` join staff_designations on staff_designations.id = designation_id join staff_appt_types on staff_appt_types.id = staff_profiles.appt_type join staff_departments on staff_departments.id = dept_id where user_id = '".$id."'";
        return $this->db->query($sql)->result();
    }

    public function getIDCardInfo($list){
        $sql = "select * from ug_profiles join gen_departments on deptid = gen_departments.id join gen_programme on gen_programme.id = programid where user_id in ".$list;
        return $this->db->query($sql)->result();
    }

    public function getIDCardInfoByPnumber($pnumber){
        $sql = "select * from ug_profiles join gen_departments on deptid = gen_departments.id join gen_programme on gen_programme.id = programid where pnumber = ".$pnumber;
        return $this->db->query($sql)->row();
    }
    
    public function getECardCourses($data){
        $sql = "select ug_courses.course_code, start_time, value, gen_settings.session, tt_date, end_time, tt_time, venue, ug_creg.level from ug_creg join ug_courses on ug_creg.csid = ug_courses.id left join gen_timetable on gen_timetable.course_code = ug_courses.course_code and ug_courses.semester = gen_timetable.semester join gen_settings on gen_settings.id = ug_courses.semester where ug_courses.semester = '".$data['semester']."' and studentid = '".$data['studentid']."' order by tt_date asc, start_time asc";

        return $this->db->query($sql)->result();
    }
    
    public function getDesignations(){
        $sql = "SELECT * FROM `staff_designations` ORDER BY `staff_designations`.`designation` ASC";
        return $this->db->query($sql)->result();
    }
    
    public function getDepartments(){
        $sql = "SELECT * FROM `staff_departments` where division_id != 1 and id != 0 ORDER BY `staff_departments`.`dept_name` ASC";
        return $this->db->query($sql)->result();
    }
    
    public function getApptTypes(){
        $sql = "SELECT * FROM `staff_appt_types` ORDER BY `staff_appt_types`.`appointment_type` ASC";
        return $this->db->query($sql)->result();
    }
    
    public function saveEdit($params){
        return $this->db
            ->set('surname', $params['surname'])
            ->set('firstname', $params['firstname'])
            ->set('othername', $params['othername'])
            ->set('designation_id', $params['designation_id'])
            ->set('dept_id', $params['dept_id'])
            ->set('appt_type', $params['appt_type'])
            ->where('user_id', $params['user_id'])
            ->update('staff_profiles');
    }
}