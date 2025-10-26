<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Accomodation_model extends CI_Model {
    
	public function getHostels(){
		$sql = "SELECT * FROM ug_hostels";
        return $this->db->query($sql)->result();
	}
	
	
	public function getHostel($hash){
		$sql = "SELECT ug_rooms.id, room_name, room_hash,  ug_rooms.capacity, sum(case when ug_bedspaces.status = 'Reserved' then 1 else 0 end) as total_reserved, ug_rooms.status, hostelcode, hostelname, hostelfor, ug_hostels.total_reserved as hotel_reserved, location, total_rooms, total_bedspaces, hostel_hash  from ug_rooms join ug_hostels on ug_hostels.id = ug_rooms.hostelid left join ug_bedspaces on ug_bedspaces.roomid=ug_rooms.id where hostel_hash = '".$hash."' group by roomid order by room_name";
        return $this->db->query($sql)->result();
	}
	
	public function updateRoomStatus($roomhash, $status){
	    $sql = "update ug_rooms set status = '".$status."' where room_hash = '".$roomhash."'";
        return $this->db->query($sql);
	}
	
	public function getRoom($hash, $session){
	    $sql = "select *, ub.id as bedspace_id, ur.status as room_status, c.pnumber, c.datereserved, c.bedspaceid, c.userid, c.reservation_status, c.session, c.current_level, c.passport, c.firstname, c.surname, c.othername, c.approval_date, c.reservation_id, c.gender from ug_bedspaces ub 
            join ug_rooms ur on ur.id = ub.roomid 
            join ug_hostels uh on uh.id = ur.hostelid 
            left join (
            select pnumber, datereserved, ug_reservations.id as reservation_id, gender, bedspaceid, userid, reservation_status, session, current_level, passport, firstname, surname, othername, approval_date from ug_reservations left join ug_profiles on user_id = userid where ug_reservations.session = '".$session."') c 
            on c.bedspaceid = ub.id 
            
            where room_hash = '".$hash."'";
	    return $this->db->query($sql)->result();
	}

	public function getMyReservations(){
		$this->db
		    ->from('ug_reservations')
            ->join('ug_bedspaces', 'ug_bedspaces.id = ug_reservations.bedspaceid')
            ->join('ug_rooms', 'ug_bedspaces.roomid = ug_rooms.id')
            ->join('ug_hostels', 'ug_hostels.id= ug_rooms.hostelid')
            //->join('ug_payments', 'ug_payments.session = ug_reservations.session', 'left')
            ->where('ug_reservations.userid', $_SESSION['userid'])
            //->where('ug_payments.type', 'Accomodation')
            ->order_by('ug_reservations.session', 'desc');
        return $this->db->get()->result();
    }
	
	public function getMyCurrentReservation(){
		return $this->db
		    ->from('ug_reservations')
           // ->join('ug_hostels', 'ug_hostels.id= ug_reservations.hostelid')
            ->where('ug_reservations.userid', $_SESSION['userid'])
            ->where('ug_reservations.session', $_SESSION['active_session'])
            ->get()
            ->row();
    }
    public function getMyCurrentReservation2(){
		$this->db
		    ->from('ug_reservations')
            ->join('ug_bedspaces', 'ug_bedspaces.id = ug_reservations.bedspaceid')
            ->join('ug_rooms', 'ug_bedspaces.roomid = ug_rooms.id')
            ->join('ug_hostels', 'ug_hostels.id= ug_rooms.hostelid')
            ->where('ug_reservations.userid', $_SESSION['userid'])
            ->where('ug_reservations.session', $_SESSION['active_session']);
          
            return $this->db->get()->row();
    }
	public function loadHostels($gender){
		return $this->db
			->where('hostelfor', $gender)
		    ->get('ug_hostels')
			->result();
					
	}
	public function user_profile(){
		return $this->db
			->where('pnumber', $_SESSION['uniqueID'])
			->get('ug_profiles')		
			->row();
	}
	public function getRooms($hostelid){
		return $this->db
					->where("hostelid", $hostelid)
					->where("status", "Visible")
					->get("ug_rooms")
					->result();
	}
	public function getRooms2($hostelid){
	    $sql = "SELECT ug_rooms.id, room_name, room_hash,  ug_rooms.capacity, sum(case when ug_bedspaces.status = 'Reserved' then 1 else 0 end) as total_reserved, ug_rooms.status, hostelcode, hostelname, hostelfor, ug_hostels.total_reserved as hotel_reserved, location, total_rooms, total_bedspaces, hostel_hash  from ug_rooms join ug_hostels on ug_hostels.id = ug_rooms.hostelid left join ug_bedspaces on ug_bedspaces.roomid=ug_rooms.id where hostelid = '".$hostelid."' group by roomid order by room_name";
	    return $this->db->query($sql)->result();
	}
	public function getBedspaces($roomid)
	{
		$this->db->where('roomid', $roomid);
		$this->db->where('status', 'available');
		return $this->db->get('ug_bedspaces')->result();
    }
	public function getBedspace($id)
	{
		
		$this->db
		    ->from('ug_bedspaces')
		    ->join('ug_rooms', 'ug_rooms.id = roomid')
		    ->join('ug_hostels', 'ug_hostels.id = ug_rooms.hostelid')
		    ->where('ug_bedspaces.id', $id);
		return $this->db->get()->row();
    }
 public function check_reservations(){
	return $this->db
				->where('session', $_SESSION['active_session'])
				->where('userid', $_SESSION['userid'])
				->get('ug_reservations')
				->row();
 }
 public function saveReservation($data)
	{
		$userid = $data['userid'];
		$session = $data['session'];
		$this->db->where('userid', $userid);
		$this->db->where('session', $session);
		$result = $this->db->get('ug_reservations');
		if ($result->num_rows > 0) {
			return false;
		} else {
			return $this->db->insert('ug_reservations', $data);
		}
	}
	public function updateBedSpace($bedspaceid)
	{
		$this->db->where('id', $bedspaceid);
		$this->db->set('status', 'Reserved');
		$this->db->set('datereserved', time());
		return $this->db->update('ug_bedspaces');
	}
	public function save_accomodation_fees($data)
	{
		return $this->db->insert('ug_payments', $data);
	}
	public function check_current_session_accomodation_payment(){
		return $this->db
				->where('user_id', $_SESSION['userid'])
				->where('session', $_SESSION['active_session'])
				->where('type', 'Accommodation')
				->get('ug_payments')
				->row();
	}
	
		public function check_current_session_fees_payment(){
		return $this->db
				->where('user_id', $_SESSION['userid'])
				->where('session', $_SESSION['active_session'])
				->where('type', 'School Fees')
				->where('status', 'Paid')
				->get('ug_payments')
				->row();
	}
	public function updatePaymentStatus($data){
		$this->db->set('rrr', $data['rrr']);
		$this->db->set('datepaid', $data['date_paid']);
		$this->db->set('status', $data['status']);
		$this->db->where('orderid', $data['orderid']);
		
		return $this->db->update('ug_payments');
	}
	public function course_reg_status($level){
		return $this->db
					->where('studentid', $_SESSION['uniqueID'])
					->where('level', $level)
					->get('ug_creg')
					->row();
	}
	public function getUserReservation($user_id){
		return $this->db
			->where('userid', $user_id)
			->where('session', $_SESSION['active_session'])
			->get('ug_reservations')
			->row();
	}
	
	public function makePriorityReservation($user, $bed){
	    $sql = "insert into ug_reservations (userid, bedspaceid, session, reservation_status, updateby, approval_date) values ('".$user."','".$bed."','".$_SESSION['active_session']."','Approved','".$_SESSION['userid']."','".date('Y-m-d H:i:s')."')";
	    $this->db->query($sql);
	    
	    $sql = "update ug_bedspaces set status = 'Reserved', datereserved = '".time()."' where id = '".$bed."'";
	    $this->db->query($sql);
	    
	    
	}
	
	public function getPendingReservations($id){
	    $sql = "select *,ug_reservations.id as reservation_id  from ug_reservations join ug_bedspaces on ug_reservations.bedspaceid = ug_bedspaces.id join ug_rooms on ug_rooms.id = roomid join ug_hostels on hostelid = ug_hostels.id join ug_profiles on ug_profiles.user_id = ug_reservations.userid where reservation_status != 'Approved' and ug_reservations.session='".$_SESSION['active_session']."' and ug_hostels.id = '".$id."' order by ug_reservations.datereserved asc, roomid asc, bedspaceid asc "; 
	    return $this->db->query($sql)->result(); 
	}
	
	public function updatePriorityReservation($id, $status){
	    if($status == 0){
	        $sql = "select * from ug_reservations where id = '".$id."'";
	        $res = $this->db->query($sql)->row();
	        
	        $bedid = $res->bedspaceid;
	        
	        $this->db->where("id", $bedid);
	        $this->db->set("status", "Available");
	        $this->db->set("datereserved", "");
	        $this->db->update("ug_bedspaces");
	        
	       // $sql = "update ug_bedspaces set status = 'Available' and datereserved = '' where id = '".$bedid."'";
	       // $this->db->query($sql);
	        
	        $this->db->where("id", $id);
	        return $this->db->delete("ug_reservations");
	       // $sql = "delete from ug_reservations where id = '".$id."'";
	       // return $this->db->query($sql);
	    }else if($status == 1){
	        $sql = "update ug_reservations set reservation_status = 'Approved', updateby='".$_SESSION['userid']."', approval_date='".date('Y-m-d H:i:s')."' where id = '".$id."'";
	        return $this->db->query($sql);
	    }
	     
	  }
	
	public function getList($id, $status){
	   $sql = "select up2.user_id, ub.id as bedspaceid, surname, ur.datereserved, ur2.hostelid, firstname, othername, pnumber, prog_abbr, hostelfor, location,current_level, bedspace, room_name, hostelname, up.status, ur.session from ug_reservations ur join ug_bedspaces ub on ub.id = ur.bedspaceid join ug_rooms ur2 on ur2.id = ub.roomid join ug_hostels uh on uh.id = ur2.hostelid left join ug_payments up on ur.userid = up.user_id left join ug_profiles up2 on up2.user_id = ur.userid left join gen_programme gp on gp.id = programid where ur.`session` = '2024/2025' and up.`type` = 'Accommodation' and ur.reservation_status = 'Approved' and up.status = '".$status."' and ur2.hostelid = '".$id."' and up.session='2024/2025' order by surname asc, bedspaceid";
	   //$sql=" select * from ug_profiles join ug_reservations
    //     join ug_bespaces join ug_rooms join ug_hostels join gen_programme 
    //     join ug_payments on ug_profiles.user_id = ug_reservations.userid and 
    //     ug_payments.userid = ug_profiles.user_id and ug_bedspaces.roomid = ug_rooms.id
    //     and ug_rooms.hostelid = ug_hostels.id and ug_profiles.programid = gen_programme.id 
    //     where ug_payments.session='2023/2024' and ug_payments.type='Accommodation'
    //     ug_payments.status ='$status' and ug_rooms.hostelid='$id'";
	    return $this->db->query($sql)->result();
	}
	
	
	public function getReservationByID($id){
	    $sql = "select *,ug_reservations.id as reservation_id  from ug_reservations join ug_bedspaces on ug_reservations.bedspaceid = ug_bedspaces.id join ug_rooms on ug_rooms.id = roomid join ug_hostels on hostelid = ug_hostels.id join ug_profiles on ug_profiles.user_id = ug_reservations.userid join gen_programme on gen_programme.id = programid where ug_reservations.id = '".$id."'"; 
	    return $this->db->query($sql)->row(); 
	}
	public function updateReservation($id, $bedspaceid, $oldbedspaceid){
	    $this->db->where("id", $id);
	    $this->db->set("bedspaceid", $bedspaceid);
	    $this->db->update("ug_reservations"); 
	    
	    $this->db->where("id", $bedspaceid);
	    $this->db->set("status", "Reserved");
	    $this->db->update("ug_bedspaces");
	    
	    $this->db->where("id", $oldbedspaceid);
	    $this->db->set("status", "Available");
	    return $this->db->update("ug_bedspaces");
	    
	    
	}
	public function search_reservation($pnumber){
	    return $this->db
	                ->select("ug_profiles.user_id, ug_payments.user_id, ug_reservations.userid, ug_reservations.id as reservationid, ug_bedspaces.id, bedspaceid, ug_rooms.id, roomid, ug_hostels.id, ug_rooms.hostelid, firstname, surname, othername, current_level, hostelname, room_name, bedspace, reservation_status, location, ug_payments.status, ug_reservations.session")
	                ->from("ug_profiles")
	                ->join("ug_reservations", "ug_profiles.user_id= ug_reservations.userid")
	                ->join("ug_payments", "ug_payments.user_id= ug_profiles.user_id")
	                ->join("ug_bedspaces", "ug_reservations.bedspaceid = ug_bedspaces.id")
	                ->join("ug_rooms", "ug_bedspaces.roomid = ug_rooms.id")
	                ->join("ug_hostels", "ug_hostels.id = ug_rooms.hostelid")
	                ->where("pnumber", $pnumber)
	                ->where("ug_reservations.session", $this->session->userdata('active_session')) 
	               
	                ->get()
	                ->row();
	}
	public function revoke($userid){
	     return $this->db
	                 ->where("userid", $userid)
	                 ->where("session", $this->session->userdata('active_session'))
	                 ->delete('ug_reservations');
	  }
	 public function update_reservation_count($hostelid, $newtotal){
	     return $this->db
	                   ->where('id', $hostelid)
	                   ->set('total_reserved', $newtotal)
	                   ->update("ug_hostels");
	 }

    public function save_reservation($data){
    return $this->db->insert("ug_reservations", $data);
    }
    
    public function get_total_reserved($hostelid){
        $this->db->select('total_reserved');
        $this->db->from("ug_hostels");
        $this->db->where("id", $hostelid);
        return $this->db->get()->row();
        
    }
    public function update_hostel($hostelid, $total){
     $this->db->where("id", $hostelid);
     $this->db->set("total_reserved", $total);
     return $this->db->update("ug_hostels");
    }
    public function load_hostel_applicant($id){
       return $this->db
                    ->select('*')        
                    ->from('ug_hostels')
                    ->join('ug_reservations', 'ug_hostels.id = ug_reservations.hostelid')
                    ->join('ug_profiles', 'ug_profiles.user_id = ug_reservations.userid')
                    ->join('gen_programme', 'gen_programme.id = ug_profiles.programid')
                    ->where('ug_reservations.session', $this->session->userdata('active_session'))
                    ->where('ug_reservations.reservation_status', 'Pending')
                    ->where("ug_hostels.id", $id)
                   // ->limit(100)
                    ->order_by('datereserved', 'asc')
                    ->get()
                    ->result();
    }

public function loadRoomsByHostelId($hostelid){
   return $this->db
             ->where("hostelid", $hostelid)
             ->get("ug_rooms")
             ->result();
}
	public function reserve_space_for_applicant($userid, $bedspaceid){
	    $this->db->where("userid", $userid);
	    $this->db->where("session", $this->session->userdata('active_session'));
	    $this->db->set("bedspaceid", $bedspaceid);
	    $this->db->set("reservation_status","Approved");
	    $this->db->update("ug_reservations");
	    
	    $this->db->where("id", $bedspaceid);
	    $this->db->set("status","Reserved");
	    return $this->db->update("ug_bedspaces");
	    
	    
	}
public function update_bedspace($bedspaceid){
    $this->db->where('id', $bedspaceid);
    $this->db->set("status","Available");
    $this->db->set("datereserved","");
    return $this->db->update("ug_bedspaces");
    
}
public function accomodation_yet_to_generate_remita(){
    //$sql="SELECT * from ug_reservations ur join ug_profiles up on up.user_id = ur.userid join ug_bedspaces ub on ub.id = ur.bedspaceid join ug_rooms ur2 on ur2.id = ub.roomid join ug_hostels uh on uh.id = ur2.hostelid where ur.session = '2023/2024' and ur.userid not in (select DISTINCT (user_id) from ug_payments up where up.type = 'Accommodation' and up.session = '2023/2024')";
    $sql="SELECT pnumber, surname, firstname,othername, bedspace, phone, ur.datereserved, room_name, hostelcode, location, prog_abbr, current_level, ur2.hostelid, user_id, bedspaceid from ug_reservations ur join ug_profiles up on up.user_id = ur.userid join ug_bedspaces ub on ub.id = ur.bedspaceid join ug_rooms ur2 on ur2.id = ub.roomid join ug_hostels uh on uh.id = ur2.hostelid join gen_programme on gen_programme.id = up.programid where ur.session = '2024/2025' and ur.userid not in (select DISTINCT (user_id) from ug_payments up where up.type = 'Accommodation' and up.session = '2024/2025') order by hostelid asc";
    return $this->db->query($sql)->result();
}
}