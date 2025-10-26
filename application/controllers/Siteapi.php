<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');

class Siteapi extends REST_Controller {

   public function __construct() {
       parent::__construct();
       $this->load->model(['siteapi_model']);

   }  
   
   public function programs_get(){
       $data = $this->siteapi_model->getRandomPrograms(10);
       return $this->response($data, 200);
   } 
   
   public function stafflist_get(){
       //https://portal.fubk.edu.ng/siteapi/stafflist
        $data = $this->siteapi_model->getStaffList();
        $data[] = [
            "fullname" => "FULL NAME",
            "department_name" => "DEPARTMENT",
            "email" => "EMAIL",
            "appointment_type" => "APPOINTMENT TYPE"
        ];
        $data = array_reverse($data);
        return $this->response($data, 200);
   } 
   
   public function courselist_get(){
       //https://portal.fubk.edu.ng/siteapi/courselist/1
        $id = $this->uri->segment(3, 1);
        $data = $this->siteapi_model->getCourseList($id);
        $data[] = [
            "course_code" => "COURSE CODE",
            "course_title" => "COURSE TITLE",
            "level" => "LEVEL"
        ];
        $data = array_reverse($data);
        return $this->response($data, 200);
   } 
   
   public function getCarryOvers_get(){
        $programid = $this->uri->segment(3, 1);
        $session = $this->uri->segment(4, $_SESSION['active_session_id'] ?? 73);
        $counter = 0;
        
        $carryovers = [];
       
        $sql_failed = 'select studentid, course_code, ca, exams, (ca+exams) as totalMarks, rms_course_registration.level, rms_courses.semester,rms_course_registration.programid, rms_courses.session 
            from rms_course_registration join rms_user_profile on rms_user_profile.pnumber = studentid join rms_courses on rms_courses.id = csid 
            where rms_user_profile.programid = ? 
            and ((session_admitted = "2018/2019" and entrymode = "DE" and (ca+exams) < 44.45) 
            	or (session_admitted = "2018/2019" and entrymode != "DE" and (ca+exams) < 39.45) 
            	or (session_admitted != "2018/2019" and (ca+exams) < 39.45)) order by studentid asc, course_code asc';
        $failed_co = $this->db->query($sql_failed, [$programid])->result();
        
        foreach($failed_co as $row){
            $course_check = 'select course_code from rms_course_registration join rms_user_profile on rms_user_profile.pnumber = studentid join rms_courses on rms_courses.id = csid 
            where rms_course_registration.studentid = ? and rms_courses.course_code = ? 
            and ((session_admitted = "2018/2019" and entrymode = "DE" and (ca+exams) >= 44.45) 
            	or (session_admitted = "2018/2019" and entrymode != "DE" and (ca+exams) >= 39.45) 
            	or (session_admitted != "2018/2019" and (ca+exams) >= 39.45))';
            
            $passed = $this->db->query($course_check, [$row->studentid, $row->course_code])->row();
            
            if(!$passed){
                $counter++;
                $carryovers[] = ['student_id' => $row->studentid, 'course_code' =>$row->course_code, 'program_id' =>$row->programid, 'semester' =>$row->semester, 'session' =>$row->session];
            }
            //var_dump($carryovers); die;
        }
        $this->db->delete('ug_carryovers', ['program_id' => $programid]);
        $this->db->insert_batch('ug_carryovers', $carryovers);
       
        return $this->response([
            'program_id' => $programid,
            'total_carryovers' => $counter
        ], 200);
        
   }
}