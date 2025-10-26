<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Timetable_model extends CI_Model
{
	public function getTimetables(){
		$sql = "SELECT gen_settings.id, gen_settings.value, gen_timetable.semester, gen_settings.session, gen_timetable.type FROM `gen_timetable` left join gen_settings on gen_settings.id = gen_timetable.semester group by semester, type order by semester desc";
		return $this->db->query($sql)->result();
	}
	
	
	public function getTimetable(){
		$sql = "SELECT gen_settings.id, gen_settings.value, gen_settings.session from gen_settings where setting = 'SEMESTER' order by id desc";
		return $this->db->query($sql)->result();
	}
	
	public function getSemesters(){
		$sql = "SELECT gen_settings.id, gen_settings.value, gen_settings.session from gen_settings where setting = 'SEMESTER' order by id desc";
		return $this->db->query($sql)->result();
	}
	
	public function generalTimetable($params){
	    $sql = "SELECT * FROM `gen_timetable` where semester = '".$params['semester']."' and type = '".$params['type']."' order by CONVERT(tt_date, DATE) asc, CONVERT(start_time, TIME) asc";
		return $this->db->query($sql)->result();
	}
	
	public function getCourseSchedule($params){
	    $sql = "SELECT gen_timetable.*, course_title, credit_unit,gen_settings.value, gen_settings.session FROM `gen_timetable` join ug_courses on gen_timetable.course_code = ug_courses.course_code and ug_courses.semester = gen_timetable.semester join gen_settings on gen_settings.id = gen_timetable.semester where gen_timetable.semester = '".$params['semester']."' and gen_timetable.type = '".$params['type']."' and gen_timetable.course_code = '".$params['course_code']."' order by CONVERT(tt_date, DATE) asc, CONVERT(start_time, TIME) asc";
		return $this->db->query($sql)->row();
	}
	
	public function updateSchedule($params, $id){
	    $this->db->set($params)->where('id', $id)->update('gen_timetable');
	    $this->db->reset_query();
	    return $this->db->get_where('gen_timetable', ['id' => $id])->row();
	}
	
	public function deleteSchedule($id){
	    $course = $this->db->get_where('gen_timetable', ['id' => $id])->row();
	    $this->db->reset_query();
	    $this->db->where('id', $id)->delete('gen_timetable');
	    return $course;
	}
	
	
}