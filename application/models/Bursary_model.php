<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Bursary_model extends CI_Model {
    
	public function getFilters(){
		$sql = "SELECT distinct(type) as type from ug_payments where type != ' ' order by type asc";
        $payment_types = $this->db->query($sql)->result();
        
		$sql = "SELECT id, prog_abbr from gen_programme order by prog_abbr asc";
        $programs = $this->db->query($sql)->result();
        
		$sql = "SELECT id, session from gen_settings where setting= 'SESSION' order by session desc";
        $sessions = $this->db->query($sql)->result();
        
        $data = [
            'pay_types' => $payment_types,
            'programs' => $programs,
            'sessions' => $sessions,
            'mode' => ['UG', 'PG']
        ];
        return $data;
	}
    
	public function getPayments($data){
	    $this->db
		    ->select('ug_payments.id, pnumber, concat(upper(surname), ", ", firstname, " ",othername) as fullname, ug_payments.type, ug_payments.amount, ug_payments.session, ug_payments.rrr, ug_payments.original_rrr, prog_abbr, level, ug_payments.status as payment_status')
		    ->from('ug_payments')
		    ->join('ug_profiles', 'ug_profiles.user_id = ug_payments.user_id')
		    ->join('gen_programme', 'gen_programme.id = ug_profiles.programid')
		    ->where('ug_payments.status', 'Paid')
		    ->where('ug_profiles.entrymode !=', 'PG');
		
		if($data['session'] != 0){
		    $this->db->where('ug_payments.session', $data['session']);
		}
		if($data['program'] != 0){
		    $this->db->where('ug_profiles.programid', $data['program']);
		}
		if($data['type'] != 0){
		    $this->db->where('ug_payments.type', trim($data['type']));
		}
		$this->db->order_by('level', 'asc');
		$this->db->order_by('surname', 'asc');
		$this->db->order_by('amount', 'desc');
        return $this->db->get()->result();
	}
	
	public function getPaymentWithFilter($params){
	    $this->db
		    ->select('ug_payments.id, pnumber, concat(upper(surname), ", ", firstname, " ",othername) as fullname, ug_payments.type, ug_payments.amount, ug_payments.session, ug_payments.rrr, ug_payments.original_rrr, prog_abbr, level, ug_payments.status as payment_status')
		    ->from('ug_payments')
		    ->join('ug_profiles', 'ug_profiles.user_id = ug_payments.user_id')
		    ->join('gen_programme', 'gen_programme.id = ug_profiles.programid');
		
		$this->db->where('ug_payments.session', $params['session']);
		$this->db->where('ug_profiles.programid', $params['programid']);
		$this->db->where('ug_payments.status', 'Paid');
		
		$this->db->order_by('level', 'asc');
		$this->db->order_by('surname', 'asc');
		$this->db->order_by('amount', 'desc');
        return $this->db->get()->result();
	}
	
	public function getPaymentSummary($session){
	    $sql = "SELECT programid, prog_abbr, ug_payments.session, sum(case when ug_payments.status = 'Paid' then 1 else 0 end) as paid, sum(case when ug_payments.status != 'Paid' then 1 else 0 end) as unpaid
	    FROM `ug_profiles` join gen_programme on programid = gen_programme.id left join ug_payments on ug_profiles.user_id = ug_payments.user_id where type='School Fees' and ug_payments.session = '".$session."' group by programid";
	    return $this->db->query($sql)->result();
	}
	
	public function getFeeItems($session){
	    $sql = 'SELECT id, item, CONCAT(item, " (", amount, ")") as item_amount, amount, session, ug_fee_item.for as fortype from ug_fee_item where session = "'.$session.'" and ug_fee_item.for="UG"  order by item asc';
	    return $this->db->query($sql)->result();
	}
	
	public function getFeeItemAnalysis($itemid){
    	$sql = 'select fee_item_id, item, programid, prog_abbr,ufi.session,
            sum( case when ug_payments_items.level = 100 then ug_payments_items.amount else 0 end) as L100,
            sum( case when ug_payments_items.level = 200 then ug_payments_items.amount else 0 end) as L200,
            sum( case when ug_payments_items.level = 300 then ug_payments_items.amount else 0 end) as L300,
            sum( case when ug_payments_items.level = 400 then ug_payments_items.amount else 0 end) as L400,
            sum( case when ug_payments_items.level = 410 then ug_payments_items.amount else 0 end) as L410,
            sum( case when ug_payments_items.level = 420 then ug_payments_items.amount else 0 end) as L420,
            sum( case when ug_payments_items.level = 500 then ug_payments_items.amount else 0 end) as L500,
            sum( case when ug_payments_items.level = 510 then ug_payments_items.amount else 0 end) as L510,
            sum( case when ug_payments_items.level = 520 then ug_payments_items.amount else 0 end) as L520
            from ug_payments_items 
            join ug_payments on ug_payments.id = ug_payments_items.payment_id 
            join ug_profiles on ug_profiles.user_id = ug_payments.user_id 
            join ug_fee_item ufi on ufi.id = fee_item_id
            join gen_programme gp on gp.id = programid
            where fee_item_id = '.$itemid.'
            group by programid';
        return $this->db->query($sql)->result();
	}
	
	public function studentPaymentHistory($pnumber){
	    $sql = 'select * from ug_payments 
            join ug_profiles on ug_profiles.user_id = ug_payments.user_id 
            join gen_programme on gen_programme.id = programid 
            where pnumber = "'.$pnumber.'" order by ug_payments.session desc';
	    return $this->db->query($sql)->result();
	}
	public function getGraduationFees(){
	    $sql = 'SELECT pnumber, firstname, surname, othername, prog_abbr, rrr, amount, ug_payments.status as payment_status FROM ug_payments join ug_profiles on ug_profiles.user_id = ug_payments.user_id join gen_programme on gen_programme.id = ug_profiles.programid where ug_payments.type ="Graduation Fees"';
	    return $this->db->query($sql)->result();
	}
	
	
}