<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siteapi_model extends CI_Model {
	
	public function getRandomPrograms($count){
		return $this->db
		    ->select('gen_programme.id, program, duration, dept_name')
		    ->join('gen_departments', 'gen_programme.deptid = gen_departments.id')
		    ->order_by('rand()')
            ->limit($count)
            ->get('gen_programme')
            ->result();
	}

	public function getStaffList(){
		$sql = 'select upper(CONCAT(surname, ", ", firstname, " ", othername, " (", title, ")")) as fullname, dept_name as department_name, gen_users.username as email, appointment_type from staff_profiles join staff_appt_types join gen_departments join gen_users  on gen_users.userid = staff_profiles.user_id and staff_profiles.appt_type = staff_appt_types.id and staff_profiles.dept_id = gen_departments.id order by dept_name asc';
		return $this->db->query($sql)->result();
	}

	public function getCourseList($id){
		$sql = 'select ug_courses.course_code, course_title,ug_course_schedule.level from ug_course_schedule join ug_courses on ug_course_schedule.courseid = ug_courses.id  
            join gen_programme on ug_course_schedule.programid = gen_programme.id 
            where ug_course_schedule.session = "2022/2023" and ug_course_schedule.programid = ? and mod(ug_course_schedule.level, 10) = ? and mod(ug_course_schedule.level, 20) = ?
            order by ug_course_schedule.level desc,  ug_courses.course_code asc';
		return $this->db->query($sql,[$id, 0 , 0])->result();
	}
}
