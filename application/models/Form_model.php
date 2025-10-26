<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form_model extends CI_Model {
	
	public function getOtherForms(){
		return $this->db
		    ->order_by('form_name', 'asc')
		    ->where('form_status', 'active')
		    ->get('gen_forms')
		    ->result();
	}
	
	public function getMyOtherForms(){
		return $this->db
		    ->select('gen_settings.id, form_name, ug_payments.type, ug_payments.session, ug_payments.rrr,ug_payments.status, ug_payments.amount ')
		    ->from('ug_payments')
		    ->join('gen_forms', 'form_name = type')
		    ->join('gen_settings', 'gen_settings.value = ug_payments.session')
		    ->where('user_id', $_SESSION['userid'])
		    ->where('gen_settings.setting', 'SESSION')
		    ->order_by('ug_payments.dategenerated', 'desc')
		    ->get()->result();
	}
	
	public function findFormPrice($id){
		return $this->db
		    ->from('gen_forms')
		    ->where('form_name', $id)
		    ->get()
		    ->row();
	}
	
	public function orderForm($data){
	    return $this->db->insert('ug_payments', $data);
	}
}
