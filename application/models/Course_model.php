<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Course_model extends CI_Model
{
	public function getCoursesStatusByDept($deptid){
		$sql = "SELECT count(studentid) as regStudents, ug_courses.level, course_code, course_title, credit_unit, ug_courses.hashcode, ug_courses.status, csid from ug_courses left join ug_creg on ug_courses.id = ug_creg.csid where ug_courses.deptid = " . $deptid . " and ug_courses.semester = " . $_SESSION['semester_code'] . " GROUP BY csid order by course_code asc";
		return $this->db->query($sql)->result();
	}
	public function getCourseByID($courseid){
		$sql = "SELECT ug_courses.*, value, gen_settings.session from ug_courses join gen_settings on gen_settings.id = semester where ug_courses.id = '" . $courseid . "'";
		return $this->db->query($sql)->row();
	}
	public function getCourseMarksByID($courseid){
		$sql = "SELECT * FROM `ug_creg` left join ug_profiles on studentid = pnumber join gen_programme on gen_programme.id = ug_profiles.programid where csid = '" . $courseid . "' order by ug_profiles.programid asc, studentid asc";
		return $this->db->query($sql)->result();
	}
	public function getMyCourses($data){
		$sql = "SELECT distinct(ug_courses.id) as id, course_code, course_title, credit_unit, value, gen_settings.session, ug_courses.status FROM ug_course_allocation join ug_courses on ug_courses.id = ug_course_allocation.csid join gen_settings on gen_settings.id = ug_courses.semester where gen_settings.session = '".$_SESSION['active_session']."' and lecturerid = '".$_SESSION['userid']."' order by ug_courses.semester asc";
		return $this->db->query($sql)->result();
	}
	
	public function getAuthorizedStatus($id){
	    $sql = "SELECT * from ug_coursereg_code where studentid = ? and session = ?";
		return $this->db->query($sql, [$id, $_SESSION['active_session_id']])->row();
	}
	
	public function updateAuthorizedStatus($code){
	    $sql = "update ug_coursereg_code set code_used = ? where studentid = ? and session = ? and code_assigned = ?";
		return $this->db->query($sql, [true, $_SESSION['userid'], $_SESSION['active_session_id'], $code]);
	}
	public function getCourseRegHistory($uniqueID){
		$sql = "SELECT gen_settings.id, sum(ug_courses.credit_unit) as units, ug_creg.level, gen_settings.value, studentid, gen_settings.`session` 
            from ug_creg join ug_courses on ug_creg.csid = ug_courses.id 
            join gen_settings on gen_settings.id = ug_courses.session 
            where studentid = '".$uniqueID."'
            GROUP by ug_courses.session 
            order by gen_settings.value desc";
		$res = $this->db->query($sql);
		return $res->result();
	}
	public function getCurrentSessionCourseRegHistory($uniqueID){
		$sql = "SELECT gen_settings.id, sum(ug_courses.credit_unit) as units, ug_creg.level, gen_settings.value, studentid, gen_settings.`session` 
            from ug_creg join ug_courses on ug_creg.csid = ug_courses.id 
            join gen_settings on gen_settings.id = ug_courses.session 
            where studentid = '".$uniqueID."' and gen_settings.`session` = '".$_SESSION['active_session']."'
            GROUP by ug_courses.session 
            order by gen_settings.value desc";
		$res = $this->db->query($sql);
		return $res->row();
	}
	public function getExamsCard($uniqueID){
		$sql = "SELECT ug_creg.level, gen_settings.id, gen_settings.value, gen_settings.session FROM `ug_creg` join ug_courses on csid = ug_courses.id join gen_settings on gen_settings.id = ug_courses.semester  where studentid = '" . $uniqueID . "'  group by ug_courses.semester order by gen_settings.id desc ";
		$res = $this->db->query($sql);
		return $res->result();;
	}
	public function getCoursesRegisteredForSession($data){
		$sql = "select ug_creg.id as reg_id, ug_courses.id as courseid, own_by, ug_courses.course_code,course_title,credit_unit, value,ug_creg.level, gen_settings.session, ug_courses.session as session_id
            from ug_creg join ug_courses on ug_creg.csid = ug_courses.id 
            join gen_settings on gen_settings.id = ug_courses.semester
            where ug_courses.session = ? and studentid = ?
            order by  ug_courses.semester asc, ug_courses.level asc,  ug_courses.course_code asc";
		return $this->db->query($sql, [$data['session'], $data['studentid']])->result();
	}
	public function getCoursesRegisteredForSemester($data){
		$sql = "select ug_courses.course_code,course_title,credit_unit, value,ug_creg.level, gen_settings.session, ug_course_schedule.type  from ug_creg join ug_courses on ug_creg.csid = ug_courses.id join gen_settings on gen_settings.id = ug_courses.semester where ug_courses.semester = '" . $data['semester'] . "' and studentid = '" . $data['studentid'] . "' order by ug_courses.semester,  ug_courses.course_code asc";
		return $this->db->query($sql)->result();
	}
	public function getCoursesRegisteredForSemesterExamsCard($data){
		$sql = "select ug_courses.course_code,course_title,credit_unit, value,ug_creg.level, gen_settings.session  from ug_creg join ug_courses on ug_creg.csid = ug_courses.id join gen_settings on gen_settings.id = ug_courses.semester where ug_courses.semester = '" . $data['semester'] . "' and studentid = '" . $data['studentid'] . "' order by ug_courses.semester,  ug_courses.course_code asc";
		return $this->db->query($sql)->result();
	}
	public function getExamsTimetable($data){
		$sql = "SELECT * FROM gen_exams_timetable join ug_courses on ug_courses.course_code = gen_exams_timetable.course_code join ug_creg on ug_creg.csid = ug_courses.id where gen_exams_timetable.semester = '".$data['semester']."' and ug_courses.semester = '".$data['semester']."' and ug_creg.studentid = '".$data['studentid']."'";
		return $this->db->query($sql)->result();
	}
	public function getCourseCodes(){
		$sql = "SELECT DISTINCT(course_code) FROM `ug_courses` order by course_code asc";
		return $this->db->query($sql)->result();
	}
	public function getDetails($pnumber){
		$res = $this->db
		    ->from('ug_profiles')
		    ->join('gen_users', 'gen_users.userid=ug_profiles.user_id')
		    ->join('gen_departments', 'deptid = gen_departments.id')
		    ->join('gen_programme', 'programid = gen_programme.id')
		    ->join('gen_divisions', 'ug_profiles.facultyid = gen_divisions.id')
		    ->where('ug_profiles.pnumber', $pnumber)
		    ->get()->row();
		//echo $this->db->last_query(); die;
		return $res;
	}
    public function getECardCourses($data){
        $sql = "select ug_courses.course_code, start_time, tt_date, end_time, tt_time, venue, ug_creg.level, value, gen_settings.session from ug_creg join ug_courses on ug_creg.csid = ug_courses.id left join gen_timetable on gen_timetable.course_code = ug_courses.course_code and ug_courses.semester = gen_timetable.semester join gen_settings on gen_settings.id = ug_courses.semester where ug_courses.semester = '".$data['semester']."' and studentid = '".$data['studentid']."' order by tt_date asc, start_time asc";

        return $this->db->query($sql)->result();
    }
    public function getSemesterInfo($id){
        $sql = "select * from gen_settings where id = '".$id."'";

        return $this->db->query($sql)->row();
    }
    public function getECardTimetable($data){
        //$sql = "select * from gen_timetable join ug_courses on ug_courses.course_code = gen_timetable.course_code join ug_creg on csid = ug_courses.id where gen_timetable.semester = ug_courses.semester and gen_timetable.semester = '".$data['semester']."' and studentid = '".$data['studentid']."' order by tt_date asc, tt_time asc";
        $sql = "select tt_date, tt_time, venue, type, mycourses.* from gen_timetable right outer join (select course_code, semester as semester_id, value as semester, value, gen_settings.session from ug_creg join ug_courses on ug_courses.id = csid join gen_settings on gen_settings.id = ug_courses.semester where studentid = '".$data['studentid']."' and semester = '".$data['semester']."') mycourses on mycourses.course_code = gen_timetable.course_code and mycourses.semester_id = gen_timetable.semester";
        $res = $this->db->query($sql);
		return $res->result();
    }
    public function getFaculties(){
        $sql = "select * from gen_divisions order by division_name asc";
        return $this->db->query($sql)->result();
    }
    public function getDepartmentByFaculty($facultyid){
        $sql = "SELECT * FROM gen_departments where division_id = ? and dtype='Academic' ORDER BY dept_name ASC";
        return $this->db->query($sql, [$facultyid])->result();
    }
    public function getCoursesByFilter($data){
        $sql = "SELECT ug_courses.id, course_code, course_title, credit_unit, value, level, gen_settings.session FROM `ug_courses` join gen_settings on ug_courses.semester = gen_settings.id where deptid = '".$data['deptid']."' and value='".$data['semester']."' and gen_settings.session='".$data['session']."' and level= '".$data['level']."' order by course_code asc";
        return $this->db->query($sql)->result();
    }
    public function generate_ttable($studentid, $semester){
         //$sql = "select * from gen_timetable join ug_courses on ug_courses.course_code = gen_timetable.course_code join ug_creg on csid = ug_courses.id where gen_timetable.semester = ug_courses.semester and gen_timetable.semester = '".$semester."' and studentid = '".$studentid."' and gen_timetable.type in ('LECTURES', 'PRACTICALS')";
         $sql = "select tt_time, tt_date, day_number, csid, ug_courses.id, ug_courses.course_title, gen_timetable.type, gen_timetable.course_code, venue from gen_timetable join ug_courses join ug_creg on gen_timetable.course_code = ug_courses.course_code and ug_courses.id = ug_creg.csid where gen_timetable.semester = ug_courses.semester and studentid = '".$studentid."' and gen_timetable.type in ('LECTURES', 'PRACTICALS') order by day_number asc, tt_time desc";
        $res = $this->db->query($sql);
        //echo $this->db->last_query(); die;
		return $res->result();
    }
    
    public function courseScheduleDistribution($session){
        $sql = "SELECT prog_abbr, sum(credit_unit) as credit_units, ug_course_schedule.session, ug_course_schedule.programid, ug_course_schedule.level, ug_courses.session as sessionid 
                FROM ug_course_schedule
                join ug_courses on courseid = ug_courses.id 
                join gen_programme on ug_course_schedule.programid = gen_programme.id 
                where ug_course_schedule.session = '".$session."' 
                group by ug_course_schedule.programid, ug_course_schedule.level";
        $res = $this->db->query($sql);
		return $res->result();
    }
    
    public function getProgrammeInfo($programid){
        $sql = "SELECT prog_abbr, dept_name FROM `gen_programme` join gen_departments on gen_departments.id = gen_programme.deptid join gen_divisions on gen_divisions.id = gen_departments.division_id where gen_programme.id = '".$programid."'";
        $res = $this->db->query($sql);
		return $res->row();
    }
    
    public function getCourseSchedule($session, $programid, $level){
        $sql = "SELECT ug_courses.id as courseid,ug_courses.course_code, course_title, credit_unit, own_by, value as semester, type, ug_courses.level, gen_settings.session, ug_course_schedule.status as approval_status FROM `ug_course_schedule` join ug_courses on ug_courses.id = ug_course_schedule.courseid join gen_settings on gen_settings.id = ug_courses.semester where ug_course_schedule.programid = '".$programid."' and ug_course_schedule.session =  '".$_SESSION['active_session']."' and ug_course_schedule.level =  '".$level."' order by semester asc, type asc, course_code asc";
        $res = $this->db->query($sql);
		return $res->result();
    }
    
    public function getCarryOvers($studentid){
        $sql = "SELECT DISTINCT(ug_courses.course_code), ug_courses.id as courseid, course_title, credit_unit, value as semester, ug_courses.level, gen_settings.session FROM ug_carryovers join ug_courses on ug_courses.course_code = ug_carryovers.course_code join gen_settings on gen_settings.id = ug_courses.semester where ug_carryovers.student_id = ?  and ug_courses.session = ?  and ug_courses.own_by is NULL group by ug_courses.course_code order by semester asc, course_code asc";
        return $this->db->query($sql, [$studentid, $_SESSION['active_session_id']])->result();
    }
    public function register_courses($data){
        
        $this->db
            ->where('studentid', $data[0]['studentid'])
            ->where('programid', $data[0]['programid'])
            ->where('level', $data[0]['level'])
            ->delete('ug_creg');
        $this->db->reset_query();
        $this->db->insert_batch('ug_creg', $data);
        
        $this->db->reset_query();
        
        return $this->db
            ->set('course_reg_submitted', date('Y-m-d H:i:s'))
            ->where('level', $data[0]['level'])
            ->where('studentid', $_SESSION['userid'])
            ->update('ug_coursereg_code');
    }
    public function addSingleCourse($data){

        $this->db->insert('ug_creg', $data);
        
        $this->db->reset_query();
        
        return $this->db
            ->set('course_reg_submitted', date('Y-m-d H:i:s'))
            ->set('course_reg_approved', 0)
	        ->set('coursereg_approval_date', NULL)
        	->set('coursereg_approved_by', NULL)
            ->where('level', $data[0]['level'])
            ->where('studentid', $_SESSION['userid'])
            ->update('ug_coursereg_code');
    }
    public function dropCourse($id, $level){
        $this->db
            ->where('id', $id)
            ->delete('ug_creg') ? true: false;
        $this->db->reset_query();
        
        return $this->db
            ->set('course_reg_submitted', date('Y-m-d H:i:s'))
            ->set('course_reg_approved', 0)
	        ->set('coursereg_approval_date', NULL)
        	->set('coursereg_approved_by', NULL)
            ->where('level', $level)
            ->where('studentid', $_SESSION['userid'])
            ->update('ug_coursereg_code');
    }
    public function get_current_level_courses(){
        return $this->db
                ->select("*")
                ->from("ug_creg")
                ->where('level', $_SESSION["current_level"])
                ->where('studentid', $_SESSION['uniqueID'])
                ->get()
                ->result();
    }
    
    public function getcourselist($session){
        $sql = 'SELECT DISTINCT(ug_courses.id) as course_id, course_code, course_title, concat(upper(surname), ", ", firstname, " ", othername) as fullname, registry_file_no, dept_name, ug_courses.hashcode, gen_settings.value as semester, gen_settings.session 
            FROM `ug_courses` join gen_departments on gen_departments.id = ug_courses.deptid 
            join gen_settings on ug_courses.semester = gen_settings.id
            left join ug_course_allocation on ug_course_allocation.csid = ug_courses.id 
            left join staff_profiles on staff_profiles.user_id = ug_course_allocation.lecturerid 
            where gen_settings.session = "'.$session.'"  
            ORDER BY `course_code`  ASC';
        return $this->db->query($sql)->result();
    }
    
    public function get_pg_courses(){
        $sql="select * from gen_programme where prog_abbr like 'M%' or prog_abbr like 'P%' order by prog_abbr";
        return $this->db->query($sql)->result(); 
    }
    public function save_course($data){
       return $this->db->insert("ug_courses", $data);
    }
    
    public function pg_courses($level, $deptid){
        return $this->db
                    ->where("level", $level)
                    ->where("deptid", $deptid)
                    ->get("ug_courses")
                    ->result();
    }
     public function drop_courses($level, $deptid){
        return $this->db
                    ->where("level", $level)
                    ->where("deptid", $deptid)
                    ->where("session", $this->session->userdata('active_session_id'))
                    ->delete("ug_courses");
    }
    
    
    public function getStaffList(){
        $sql='SELECT user_id as id, registry_file_no, concat(upper(surname),", ", firstname," ", othername) as fullname FROM staff_profiles where employee_type = "SENIOR STAFF" order by registry_file_no asc';
        return $this->db->query($sql)->result(); 
    }
    
    public function getCourseAllocation($id){
        $sql = 'select ug_course_allocation.id,csid, concat(upper(surname),", ", firstname," ", othername) as fullname, ug_course_allocation.date, registry_file_no from ug_course_allocation join staff_profiles on user_id = lecturerid where csid = "'.$id.'"';
        return $this->db->query($sql)->result(); 
    }
    
    public function makeAllocation($data){
        return $this->db->insert('ug_course_allocation', $data);
    }
    
    public function removeAllocation($id){
        return $this->db->where('id', $id)->delete('ug_course_allocation');
    }
    
    public function course_evaluation(){
        return $this->db
             ->select("*")
             ->from('ug_courses')
             ->join('ug_creg', "ug_courses.id = ug_creg.csid")
             ->where("ug_creg.studentid", $this->session->userdata("pnumber"))
             ->where("ug_courses.session", $this->session->userdata("active_session_id"))
             ->where("course_evaluation_url !=", "")
             ->get()
             ->result();
                
    }
    
    public function getAddDropStatus($data){
        return $this->db
             ->where("user_id", $data['user_id'])
             ->where("type", 'Add & Drop')
             ->where("level", $data['level'])
             ->where("session", $_SESSION['active_session'])
             ->get('ug_payments')
             ->row();
                
    }
    
	public function deptCourseAllocation($deptid){
	    return $this->db
	        ->select('ug_courses.id, course_code, ug_course_allocation.id as allocation_id, course_title, credit_unit, ug_courses.level, gen_settings.value as semester, gen_settings.session, registry_file_no,  surname, othername, firstname')
	        ->join('gen_settings', 'gen_settings.id = ug_courses.semester')
	        ->join('ug_course_allocation', 'ug_course_allocation.csid = ug_courses.id', 'left')
	        ->join('staff_profiles', 'staff_profiles.user_id = ug_course_allocation.lecturerid ', 'left')
	        ->where('ug_courses.deptid', $deptid)
	        ->where('ug_courses.session', $_SESSION['active_session_id'])
	        ->order_by('ug_courses.semester', 'asc')
	        ->order_by('course_code', 'asc')
	        ->get('ug_courses')->result();
	}
	
	public function getSingleCourse($id){
	    return $this->db
	        ->select('ug_courses.id, course_code, course_title, credit_unit, ug_courses.level, gen_settings.value as semester, gen_settings.session')
	        ->join('gen_settings', 'gen_settings.id = ug_courses.semester')
	        ->where('ug_courses.id', $id)
	        ->get('ug_courses')->row(); 
	}
	
	public function processallocation($params){
        return $this->db->insert('ug_course_allocation', $params);
    }
	
	public function deallocatecourse($id){
        return $this->db->delete('ug_course_allocation', ['id' => $id]);
    }
    
    public function deptCourseSchedules($deptid){
	    return $this->db
	        ->select('prog_abbr, session, level, status, programid')
	        ->join('gen_programme', 'gen_programme.id = ug_course_schedule.programid')
	        ->where('deptid', $deptid)
	        ->where('session', $_SESSION['active_session'])
	        ->group_by('level, session, programid')
	        ->order_by('session', 'desc')
	        ->order_by('level', 'asc')
	        ->order_by('programid', 'asc')
	        ->get('ug_course_schedule')->result();
	}
	
	public function deptViewSchedule($params){
	    return $this->db
	        ->join('ug_courses', 'ug_courses.id = ug_course_schedule.courseid')
	        ->join('gen_programme', 'gen_programme.id = ug_course_schedule.programid')
	        ->get('ug_course_schedule')->result();
	}
	
	public function load_courses(){
	    return $this->db
	        ->select('*')
	        ->from('ug_courses')
	        ->where('session', 82)
	        ->where('level', 400)
	        ->get()->result();
	}
		public function load_programs(){
	    return $this->db
	        ->select('*')
	        ->from('gen_programme')
	        ->get()->result();
	}
	public function save_course_schedule($data){
	    return $this->db->insert('ug_course_schedule', $data);
	}
	
	
}
