<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {
	
	public function authenticate($data){
		$result = $this->db->get_where('gen_users', $data);
		if($result->num_rows() == 1){
			$row = $result->row();
			$this->db->set('last_login', time(), false);
			$this->db->where('userid', $row->userid);
			$this->db->update('gen_users');
			return $row;
		}else{
			return false;
		}
	}

	public function getUser($data){
		$result = $this->db->get_where('gen_users', $data);
		return $result->num_rows() == 1 ? $result->row() : false;
	}

	public function getAllAccess($access_level){
		$this->db->from('users');
		$this->db->join('profiles', 'profiles.userid = users.id');
		$result = $this->db->get_where('', $data);
		return $result->num_rows() == 1 ? $result->row() : false;
	}

	public function getUserByEmail($username){
		$result = $this->db->get_where('gen_users', ['username' => $username]);
		return $result->num_rows() == 1 ? $result->row() : false;
	}

	public function setResetHash($data){
		$this->db->set('password_reset_hash', $data['reset_hash']);
		$this->db->where('username', $data['username']);
		return $this->db->update('gen_users');
	}

	public function setPassword($data){
		$this->db->set('password', $data['password']);
		$this->db->where('username', $data['username']);
		return $this->db->update('gen_users');
	}

	public function changeUserPassword($data){
		$this->db->set('password', $data['password']);
		$this->db->where('username', $data['username']);
		return $this->db->update('gen_users');
	}

	public function getActiveSettings($session){
		$this->db->where('session', $session);
		return $this->db->get('gen_settings')->result();
	}
	
	public function getActiveSession(){
		$this->db->where('setting', 'session');
		$this->db->where('status', 'active');
		return $this->db->get('gen_settings')->row();
	}
	
	public function getActiveSemester(){
		$this->db->where('setting', 'semester');
		$this->db->where('status', 'active');
		return $this->db->get('gen_settings')->row();
	}

	public function getRegistrationWorkflow(){
		$data = [
			'user_id' => $_SESSION['userid'], 
			'session' => $_SESSION['active_session']
		];
		if($this->db->get_where('student_registration_workflow', $data)->num_rows() == 0){
			$this->db->insert('student_registration_workflow', $data);
		}
		return $this->db->get_where('student_registration_workflow', $data)->row();
	}

	public function setSecurityTokens($email, $mode, $status, $payload, $reason){
		
		$this->db->where('email', $email)->set('status', 'inactive')->update('sec_tokens');
		
		$this->db->reset_query();
		
		$data = [
		    'email' => $email, 
		    'attempt_mode' => $mode, 
		    'login_status' => $status, 
		    'payload'=> $payload, 
		    'reason'=> $reason
		];
		
		$data['status'] = $reason == "LOGOUT"? 'inactive': 'active';
		
		return $this->db->insert('sec_tokens', $data);
		
	}
	
	public function checkMultipleLogin($email){
	    return $this->db->where(['status'=> 'active','email' => $email])->get('sec_tokens')->num_rows();
	}
	
}
