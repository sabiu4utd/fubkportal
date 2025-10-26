<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model {
	
	public function getFeeInformation($params){
        return $this->db->get_where('ug_payments', $params)->row();
    }
	
	public function getPaymentFullorPartial($params){
	    $this->db
            ->from('ug_payments')
            ->where('user_id', $params['user_id'])
            ->where('type', $params['type'])
            ->where('session', $params['session']);
        return $this->db->get()->result();
	    
	}
	
	public function getPaymentHistory($userid){
         $this->db
            ->from('ug_payments')
            ->join('ug_profiles', 'ug_profiles.user_id = ug_payments.user_id')
            ->where('ug_payments.user_id', $userid)
            ->order_by('ug_payments.session', 'desc')
            ->order_by('ug_payments.id', 'desc');
        return $this->db->get()->result();
    }
    
    public function paymentCurrentSession($userid){
        $query = $this->db
            ->from('ug_payments')
            ->join('ug_profiles', 'ug_profiles.user_id = ug_payments.user_id')
            ->where('ug_payments.user_id', $userid)
            ->where('ug_payments.type', 'School Fees')
            ->where('ug_payments.session', $_SESSION['active_session'])->get();
        return $query->row() ? $query->row() : false;
    }
    
    public function registerPayment($data){
        $this->deletePayment([
            'user_id' => $data['user_id'], 
            'type' => $data['type'],  
            'level' => $data['level'], 
            'session' => $data['session'],
            'percentage_paid' =>$data['percentage_paid'],
            'status' => 'PENDING'
        ]);
            
        $this->db->reset_query();
        return $this->db->insert('ug_payments', $data);
    }
    
    public function registerPaymentItems($data){
        return $this->db->insert_batch('ug_payments_items', $data);
    }
    
    public function deletePayment($data){
        return $this->db->delete('ug_payments', $data);
    }

    public function updatePaymentStatus($data){
        $this->db->set('status', $data['status']);
        $this->db->set('orderid', $data['orderid']);
        $this->db->where('rrr', $data['rrr']);
        return $this->db->update('ug_payments');
    }
    
    public function getPaymentAmount($param){
        $this->db
		    ->from('ug_fee_item')
		    ->join('ug_fees_schedule', 'ug_fee_item.id = ug_fees_schedule.itemid')
		    ->join('gen_settings', 'gen_settings.id = ug_fees_schedule.session')
		    ->where('ug_fees_schedule.level', $param['level'])
		    ->where('gen_settings.session', $param['session'])
		    ->where('ug_fees_schedule.programid', $param['programid']);
		if($param['level'] == 200){
		    $this->db->where('ug_fees_schedule.type', $param['entrymode']);
		}
		return $this->db->get()->result();
    }
    
    public function getPaymentSchedule($param){
        $this->db
            ->select('sum(amount) as amount')
            ->from('ug_fees_schedule')
            ->join('ug_fee_item', 'ug_fee_item.id = itemid')
            ->join('gen_settings', 'gen_settings.id = ug_fees_schedule.session')
		    ->where('ug_fees_schedule.level', $param['level'])
		    ->where('gen_settings.value', $param['session'])
		    ->where('ug_fees_schedule.programid', $param['programid']);
		    if($param['level'] <= 200){
		        $this->db->where('ug_fees_schedule.type', $param['type']);
		    }
		return $this->db->get()->row();
    }
    public function get_programs(){
        return $this->db->get("gen_programme")->result();
    }
    public function generatePaymentScheduleById($programid, $level, $session, $type){
        return $this->db
            ->from('ug_fee_item')
            ->join('ug_fees_schedule', ' ug_fee_item.id = ug_fees_schedule.itemid')
            ->join('gen_settings', ' ug_fee_item.session =gen_settings.session')
            ->where("ug_fees_schedule.programid", $programid)
            ->where("ug_fees_schedule.level", $level)
            ->where("gen_settings.value", $session)
            ->where("ug_fees_schedule.type", $type)
            ->get()->result();
        
    }
    
    public function getFeeItems($session){
        return $this->db
        ->order_by('item', 'asc')
        ->where('session', $session)
        ->get('ug_fee_item')->result();
    }
    
    public function getFilteredFeeItems($params){
        return $this->db
        ->order_by('item', 'asc')
        ->get_where('ug_fee_item', $params)->result();
    }
    
    public function createFeeItem($params){
        return $this->db->insert('ug_fee_item', $params);
    }
    
    public function deleteFeeItem($id){
        return $this->db->where('id', $id)->delete('ug_fee_item');
    }
    
    public function getFeeItem($id){
        return $this->db->where('id', $id)->get('ug_fee_item')->row();
    }
    
    public function updateFeeItem($id, $params){
        return $this->db->where('id', $id)->set($params)->update('ug_fee_item');
    }
    
    public function savePaymentSchedule($data){
        //var_dump($data[0]['level']);die; 
        $this->db
            ->where('programid', $data[0]['programid'])
            ->where('level', $data[0]['level'])
            ->where('session', $data[0]['session'])
            ->where('type', $data[0]['type'])
            ->delete('ug_fees_schedule');
        //$this->db->last_query();
        $this->db->reset_query();
        return $this->db->insert_batch('ug_fees_schedule',$data);
    }
    
    public function getNelfundHistory($session){
        return $this->db
            ->from("ug_payments")
            ->join("ug_profiles", "ug_profiles.user_id = ug_payments.user_id")
            ->where("ug_payments.sponsor", "Nelfuld")
            // ->where("session", $session)
            ->get()->result();
    }
    
    public function saveNelfund($data){
        $this->db->delete("ug_payments", [
                
        ]);
        $this->db->reset_query();
        
        return $this->db->insert("ug_payments", $data);
    }

}
