<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sbsmanager_model extends CI_Model {
    
    public function search($parameter){
		$sql = "SELECT ug_profiles.user_id, passport,username, confirm_status,jamb_no, pnumber, surname, firstname, othername, gender, entrymode,  prog_abbr, session_admitted FROM `ug_profiles` join gen_programme on gen_programme.id = ug_profiles.programid join gen_users on gen_users.userid = ug_profiles.user_id where username = '".$parameter."' or pnumber = '".$parameter."' or jamb_no = '".$parameter."' order by programid asc, username asc";
        $res = $this->db->query($sql);
        //echo $this->db->last_query();
        return $res->result();
	}
	public function getAdmissionSessions(){
		$sql = "SELECT session_admitted, count(id) as total_admitted, sum(case when gender = 'Male' then 1 else 0 end) as total_male,sum(case when gender = 'Female' then 1 else 0 end) as total_female,sum(case when stateid = 21 then 1 else 0 end) as total_kebbi,sum(case when stateid != 21 then 1 else 0 end) as total_other FROM `ug_profiles` join gen_users on gen_users.userid = ug_profiles.user_id  where gen_users.type = 'SBS' group by session_admitted order by session_admitted desc";
        return $this->db->query($sql)->result();
	}
    public function getAdmissionList($session){
		$sql = "SELECT ug_profiles.user_id, passport, confirm_status, username, jamb_no, pnumber, surname, firstname, othername, gender, entrymode,  prog_abbr, session_admitted FROM `ug_profiles` join gen_programme on gen_programme.id = ug_profiles.programid join gen_users on gen_users.userid = ug_profiles.user_id and gen_users.type = 'SBS'  order by pnumber asc, programid asc";
        return $this->db->query($sql)->result();
	}
    public function candidate(){
        echo $userid = $this->uri->segment(3); die;
		$sql = "update gen_users set password = SHA2('".$username."',512) where userid = ".$userid; 
        return $this->db->query($sql);
	}
    public function admin_reset_password($userid, $username){
		$sql = "update gen_users set password = SHA2('".$username."',512) where userid = ".$userid; 
        return $this->db->query($sql);
	}
    public function admin_confirm_admission($userid){
		$sql = "update ug_profiles set confirm_status = 'Confirmed', confirm_date = now() where user_id = ".$userid;
        return $this->db->query($sql);
	}
    public function admin_idCard($userid){
		$sql = "select * from ug_profiles join gen_departments join gen_divisions join gen_programme on ug_profiles.deptid = gen_departments.id and ug_profiles.facultyid = gen_divisions.id and gen_programme.id = ug_profiles.programid where ug_profiles.user_id = ".$userid;
        return $this->db->query($sql)->row();
	}
    public function getAdmissionSerialNo($param){
		$sql = "select pnumber as serialValue from ug_profiles where session_admitted = '".$param['session_admitted']."' and programid = '".$param['programid']."' and entrymode = '".$param['entrymode']."' and pnumber != 'Unassigned' order by pnumber desc limit 1";
        return $this->db->query($sql)->row();
	}
    public function assignAdmissionNo($param){
		$sql = "update ug_profiles set pnumber = '".$param['pnumber']."' where user_id  = '".$param['user_id']."'";
        $this->db->query($sql);
        
        
        $username = $param['pnumber'];
        
        if($param['entrymode'] == "PG"){
            $username .= "@pg.fubk.edu.ng";
        }else if($param['entrymode'] == "UG"){
            $username .= "@ug.fubk.edu.ng";
        }else if($param['entrymode'] == "MATRIC"){
            $username .= "@sbs.fubk.edu.ng";
        }
        
        $password = hash('sha512', trim($param['pnumber']));
        
		$sql = "update gen_users set username = '".$username."', password = '".$password."', uniqueID = '".$param['pnumber']."' where userid  = '".$param['user_id']."'";
        return $this->db->query($sql);
	}
	
	public function savePassport($data){
		$this->db->where('user_id', $data['user_id']);
		$this->db->set('passport', $data['passport']);
		return $this->db->update('ug_profiles');
	}
	
	public function getAdmissionSummary(){
	    $sql = 'SELECT session_admitted, count(user_id) as total_admitted, sum(case WHEN confirm_status ="Confirmed" then 1 else 0 end) as total_confirmed,sum(case WHEN gender = "Male" then 1 else 0 end) as total_male, sum(case WHEN gender = "Female" then 1 else 0 end) as total_female,sum(case WHEN entrymode = "UTME" then 1 else 0 end) as total_utme,sum(case WHEN entrymode = "MATRIC" then 1 else 0 end) as total_matric, sum(case WHEN entrymode = "DE" then 1 else 0 end) as total_de,sum(case WHEN entrymode = "PG" then 1 else 0 end) as total_pg,sum(case WHEN stateid = 21 then 1 else 0 end) as total_kebbi, sum(case WHEN stateid != 21 then 1 else 0 end) as total_other from ug_profiles group by session_admitted order by session_admitted desc';
	    return $this->db->query($sql)->result();
	}
	public function getAcceptance_payment($userid){
	    return $this->db
	                ->where('userid', $userid)
	                ->where('type', 'Acceptance')
	                ->get('ug_payments')
	                ->row();
	}
}