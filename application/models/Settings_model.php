<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model {
	
	public function getDashInfo($semid){
        $sql = "SELECT * FROM `gen_settings` where id = '".$semid."' order by id asc";
		return $this->db->query($sql)->row();
	}

	public function getAllSession(){
		$sql = "SELECT * FROM `gen_settings` where setting = 'semester' order by session desc, value desc";
		return $this->db->query($sql)->result();
	}

	public function getAllDepartments(){
        $sql = "SELECT * FROM `gen_departments` order by dept_name asc";
		return $this->db->query($sql)->result();
	}

	public function getAllSettings($session){
		$sql = "SELECT * FROM gen_settings where session = ? order by setting asc";
		return $this->db->query($sql, [$session])->result();
	}

	public function getSettings($id){
		$sql = "SELECT * FROM gen_settings where id = ?";
		return $this->db->query($sql, [$id])->row();
	}

	public function getSessions(){
		$sql = "SELECT * FROM gen_settings where setting = ? order by value desc";
		return $this->db->query($sql, ["session"])->result();
	}
	
	public function updateSetting($id, $params){
	    $sql = "update gen_settings set value = ?, start_date = ?, end_date = ?, status = ?, updated_at = ? where id = ?";
		return $this->db->query($sql, [$params[0], $params[1], $params[2], $params[3], $params[4], $id]);
	}
	
	public function getRoles(){
	    $sql = "select gen_roles.id, gen_roles.role, gen_roles.status, COUNT(gen_role_permissions.id) as total_assigned, gen_roles.created_at from gen_roles left join gen_role_permissions on gen_roles.id = gen_role_permissions.role_id group by gen_roles.id order by gen_roles.role asc";
		return $this->db->query($sql)->result();
	}
	
	public function getPermissions(){
	    $sql = "select gen_permissions.id, gen_permissions.permission_name, COUNT(gen_role_permissions.id) as total_assigned, gen_permissions.status, gen_permissions.created_by, gen_permission_groups.permission_group_name from gen_permissions left join gen_role_permissions on gen_permissions.id = gen_role_permissions.permission_id join gen_permission_groups on gen_permission_groups.id = gen_permissions.permission_group_id  group by gen_permissions.id order by permission_group_name asc, gen_permissions.permission_name asc";
		return $this->db->query($sql)->result();
	}
	
	public function getPermissiongroup(){
	    $sql = "select id, permission_group_name, status, created_at from gen_permission_groups order by permission_group_name asc";
		return $this->db->query($sql)->result();
	}
	
	public function getRecentAssinments(){
	    $sql = "select grp.id, gr.role, gp.permission_name, grp.can_create, grp.can_read, grp.can_update, grp.can_delete, grp.created_by, grp.created_at, grp.status from gen_role_permissions grp join gen_roles gr on gr.id = grp.role_id join gen_permissions gp on gp.id = grp.permission_id order by grp.created_at desc limit 10";
		return $this->db->query($sql)->result();
	}
    

}
