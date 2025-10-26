<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Levelmanager_model extends CI_Model {
	public function currentStaffInfo(){
	    return $this->db
            ->join('gen_departments', 'dept_id = gen_departments.id', 'left')
            ->where('user_id', $_SESSION['userid'])
            ->get('staff_profiles')->row();
	}
	public function getLevelCoordinatorRole($userid){
        return $this->db
            ->select('gen_settings.id as session_id, prog_abbr, level, gen_settings.value as session, lecturer_id, program_id, registry_file_no, firstname, surname, othername')
            ->from('staff_level_cordinators')
            ->join('gen_programme', 'gen_programme.id = staff_level_cordinators.program_id')
            ->join('gen_settings', 'gen_settings.id = staff_level_cordinators.session')
            ->join('staff_profiles', 'staff_profiles.user_id = staff_level_cordinators.lecturer_id')
            ->where('staff_level_cordinators.lecturer_id', $userid)
            ->order_by('gen_settings.id', 'desc')
            ->get()->result();
    }
	
	public function currentDeptStaff($deptid){
        return $this->db
            ->join('gen_departments', 'dept_id = gen_departments.id', 'left')
            ->where('dept_id', $deptid)
            ->get('staff_profiles')->result();
    }
	
	public function currentDeptProgrammes($deptid){
        return $this->db
            ->where('deptid', $deptid)
            ->get('gen_programme')->result();
    }
	
	public function processallocation($params){
        return $this->db->insert('staff_level_cordinators', $params);
    }
	
	public function remove($id){
        return $this->db->where('id', $id)->delete('staff_level_cordinators');
    }
	
	public function getDeptLevelCoordinators($deptid){
        return $this->db
            ->select('staff_level_cordinators.id as staff_level_cordinator_id, gen_settings.id as session_id, prog_abbr, level, gen_settings.value as session, lecturer_id, program_id, registry_file_no, firstname, surname, othername')
            ->from('staff_level_cordinators')
            ->join('gen_programme', 'gen_programme.id = staff_level_cordinators.program_id')
            ->join('gen_settings', 'gen_settings.id = staff_level_cordinators.session')
            ->join('staff_profiles', 'staff_profiles.user_id = staff_level_cordinators.lecturer_id')
            ->where('staff_profiles.dept_id', $deptid)
            ->order_by('gen_settings.id', 'desc')
            ->get()->result();
    }
	
	public function getLevelCoordinators(){
        return $this->db
            ->select('gen_settings.id as session_id, prog_abbr, level, gen_settings.value as session, lecturer_id, program_id, registry_file_no, firstname, surname, othername')
            ->from('staff_level_cordinators')
            ->join('gen_programme', 'gen_programme.id = staff_level_cordinators.program_id')
            ->join('gen_settings', 'gen_settings.id = staff_level_cordinators.session')
            ->join('staff_profiles', 'staff_profiles.user_id = staff_level_cordinators.lecturer_id')
            //->where('staff_level_cordinators.lecturer_id', $userid)
            ->order_by('gen_settings.id', 'desc')
            ->get()->result();
    }
    
    public function getStudents($prog_id, $level, $session){
        $sql = "select ug_coursereg_code.id, ug_profiles.user_id, surname, firstname, othername, pnumber, dob, gender, code_assigned, code_used, course_reg_submitted,
course_reg_approved, ug_coursereg_code.level, ug_coursereg_code.session as session_id,
                gen_settings.session, prog_abbr, ug_coursereg_code.level, programid, lecturer_id, ug_coursereg_code.session as session_id from ug_profiles 
                join gen_programme on gen_programme.id = ug_profiles.programid
                left join ug_coursereg_code on ug_profiles.user_id = studentid 
                left join gen_settings on gen_settings.id = ug_coursereg_code.session  where programid = ? and current_level = ? and ug_coursereg_code.session = ? and pnumber != ? order by coursereg_approval_date desc, pnumber asc";
        return $this->db->query($sql, [$prog_id, $level, $session, 'Unassigned'])->result();
    }
    
    public function generateCodes($prog_id, $level, $session){
        $sql = "delete from ug_coursereg_code where program_id = ? and session = ? and level = ?";
        $this->db->query($sql, [$prog_id, $session, $level]);
            
        $this->db->reset_query();
            
        $sql = "insert into ug_coursereg_code (studentid, session, code_assigned, code_used, lecturer_id, level, program_id) 
            select user_id, ?, ceil(rand()*7e7)+1e7 as code, 0, ?, current_level, programid 
            from ug_profiles where programid = ? and current_level = ?";
        return $this->db->query($sql, [$session,$_SESSION['userid'],$prog_id, $level]);
    }
    
    public function updateCodes($prog_id, $level, $session){
        $sql = "
        INSERT INTO ug_coursereg_code (
            studentid, 
            session, 
            code_assigned, 
            code_used, 
            lecturer_id, 
            level, 
            program_id
        )
        SELECT 
            p.user_id AS studentid,
            ?          AS session,
            CEIL(RAND() * 7e7) + 1e7 AS code_assigned,
            0          AS code_used,
            ?          AS lecturer_id,
            p.current_level AS level,
            p.programid     AS program_id
        FROM ug_profiles p
        WHERE 
            p.programid = ?
            AND p.current_level = ?
            -- Exclude rows that already exist in ug_coursereg_code for this combination
            AND NOT EXISTS (
                SELECT 1 
                FROM ug_coursereg_code c
                WHERE 
                    c.studentid  = p.user_id
                    AND c.level  = p.current_level
                    AND c.program_id = p.programid
                    AND c.session    = ?
            )";

        return $this->db->query($sql, [
            $session,
            $_SESSION['userid'],
            $prog_id,
            $level,
            $session
        ]);
    }
    
    public function generateSingleCodes($id){
        $sql = "update ug_coursereg_code set code_assigned = ceil(rand()*7e7)+1e7, code_used = ? where id = ?";
        return $this->db->query($sql, [0, $id]);
    }
    
    public function getCoursesRegisteredForSession($data){
		$sql = "select ug_creg.id as reg_id, ug_courses.id as courseid,ug_courses.course_code,course_title,credit_unit, value,ug_creg.level, gen_settings.session, ug_courses.session as session_id
            from ug_creg join ug_courses on ug_creg.csid = ug_courses.id 
            join gen_settings on gen_settings.id = ug_courses.semester
            where ug_courses.session = ? and studentid = ?
            order by  ug_courses.semester asc, ug_courses.level asc,  ug_courses.course_code asc";
		return $this->db->query($sql, [$data['session'], $data['studentid']])->result();
	}
    
    public function updateCourseReg($param){
		return $this->db
		    ->set('course_reg_approved', $param[0])
		    ->set('coursereg_approval_date', $param[1])
		    ->set('coursereg_approved_by', $param[2])
		    ->where('studentid', $param[3])
		    ->where('level', $param[4])
		    ->where('session', $param[5])
		    ->update('ug_coursereg_code');
	}
    
    public function clearCourseReg($param){
        
		$sql = $this->db
	            ->where('studentid', $param[0])
	            ->where('level', $param[1])
	            ->where('sessionid', $param[2])
	            ->delete('ug_creg');
		//echo $this->db->last_query();die;
		$this->db->reset_query();

		$this->db
		    ->set('code_assigned', 'ceil(rand()*7e7)+1e7', false)
		    ->set('code_used', 0)
		    ->set('course_reg_submitted', NULL)
		    ->set('course_reg_approved', NULL)
		    ->set('coursereg_approval_date', NULL)
		    ->set('coursereg_approved_by', NULL)
		    ->set('updated_at', date('Y:m-d H:i:s'))
		    ->where('studentid', $param[3])
            ->where('level', $param[1])
            ->where('session', $param[2])
            ->update('ug_coursereg_code');
        return true;
	}
	

}
