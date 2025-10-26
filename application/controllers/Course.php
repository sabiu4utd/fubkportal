<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Course extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['course_model', 'student_model', 'result_model', 'settings_model', 'levelmanager_model']);
	}

    public function scramble($txt){
		$result = '';
    	for($i = 0; $i < strlen($txt); $i++){
			$result .= chr(ord(substr($txt, $i, 1)) + 20);
        }
        return $result;
    }

	public function index()
	{
		$_SESSION['pageTitle'] = 'My Courses .::. University Portal';
		$data = [
			'courses' => $this->course_model->getMyCourses()
		];
		return $this->load->view('course/index', $data);
	}
	public function courses_by_dept()
	{
		$_SESSION['pageTitle'] = 'Courses by Department .::. University Portal';
		$deptid = $this->uri->segment(4);
		$data = [
			'deptid' => $deptid,
			'dept_name' => urldecode($this->uri->segment(5)),
			'courses' => $this->course_model->getCoursesStatusByDept($deptid)
		];
		return $this->load->view('course/courses_by_dept', $data);
	}
	public function view()
	{
		$_SESSION['pageTitle'] = 'Course View .::. University Portal';
		$courseid = $this->uri->segment(4, null);
		if(!$courseid){
			redirect('staff/index', 'refresh');
		}
		$marks = $this->course_model->getCourseMarksByID($courseid);
		$analysis = [];
		foreach($marks as $row){
			$analysis[$row->prog_abbr] = ['pass' => 0, 'fail' => 0, "A" => 0,  "B" => 0,  "C" => 0,  "D" => 0,  "E" => 0,  "F" => 0];
		}
		$data = [
			'deptid' => $this->uri->segment(5, null),
			'dept_name' => $this->uri->segment(6, null),
			'courseinfo' => $this->course_model->getCourseByID($courseid),
			'coursemarks' => $marks,
			'analysis' => $analysis
		];
		return $this->load->view('course/view', $data);
	}
	public function enrollment()
	{
		$_SESSION['pageTitle'] = 'Attendance List .::. University Portal';
		$courseid = $this->uri->segment(4, null);
		if(!$courseid){
			redirect('staff/index', 'refresh');
		}
		$marks = $this->course_model->getCourseMarksByID($courseid);
		$analysis = [];
		foreach($marks as $row){
			$analysis[$row->prog_abbr] = ['pass' => 0, 'fail' => 0, "A" => 0,  "B" => 0,  "C" => 0,  "D" => 0,  "E" => 0,  "F" => 0];
		}
		$data = [
			'deptid' => $this->uri->segment(5, null),
			'dept_name' => $this->uri->segment(6, null),
			'courseinfo' => $this->course_model->getCourseByID($courseid),
			'coursemarks' => $marks,
			'analysis' => $analysis
		];
		return $this->load->view('course/enrollment', $data);
	}
	public function history()
	{
		$_SESSION['pageTitle'] = 'Course Registration .::. University Portal';
		
		$student = $this->student_model->getBioByPnumber($_SESSION['uniqueID']);
		
		$params = [
		    'user_id' => $_SESSION['userid'],
		    'level' => $student->current_level,
		    'session' => $_SESSION['active_session']
		];
		$add_drop = $this->course_model->getAddDropStatus($params);
		$authorisedstatus = $this->course_model->getAuthorizedStatus($_SESSION['userid']);
		$data = [
			'add_drop' => $add_drop,
			'course_reg_history' => $this->course_model->getCourseRegHistory($_SESSION['uniqueID']),
			'active_session_history' => $this->course_model->getCurrentSessionCourseRegHistory($_SESSION['uniqueID']),
			'student' => $student,
			'authorisedstatus' => $authorisedstatus
		];
		
		return $this->load->view('course/course_reg_history', $data);
	}
	public function print()
	{
		$_SESSION['pageTitle'] = 'Print Course Form .::. University Portal';
		$data = [
			'session' => $this->uri->segment(4),
			'studentid' => $_SESSION['uniqueID']
		];
		$courses = $this->course_model->getCoursesRegisteredForSession($data);
		if(!$courses) redirect('course/history', 'refresh');
		$student = $this->student_model->getBioByPnumber($_SESSION['uniqueID']);
		$data = [
			'courses' => $courses,
			'student' => $student,
			'authorizedStatus' => $this->course_model->getAuthorizedStatus($student->userid)
		];
		return $this->load->view('course/print', $data);
	}
	public function ammend()
	{
		$_SESSION['pageTitle'] = 'Add & Drop .::. University Portal';
		$param = [
			'session' =>$this->uri->segment(4),
			'studentid' => $_SESSION['uniqueID']
		];
		$data = [
		    
			'courses' => $this->course_model->getCoursesRegisteredForSession($param),
			//'courses' => $this->course_model->getCoursesRegisteredForSemester($param),
			'student' => $this->student_model->getBioByPnumber($_SESSION['uniqueID']),
			'faculty' => $this->course_model->getFaculties(),
		];
		return $this->load->view('course/ammend', $data);
	}
	
	public function ecard(){
		$_SESSION['pageTitle'] = 'Print Course Form .::. University Portal';
		$student = $this->student_model->getBioByPnumber($_SESSION['uniqueID']);
		$param = [
			'semester' => $this->uri->segment(4),
			'studentid' => $_SESSION['uniqueID']
		];

		$text = $this->scramble($student->pnumber);
		// Create QR code
		$result = Builder::create()
			->writer(new PngWriter())
			->writerOptions([])
			->data(site_url('card/verifyECard/'.$text))
			->encoding(new Encoding('ISO-8859-1'))
			->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
			->size(200)
			->margin(10)
			->roundBlockSizeMode(new RoundBlockSizeModeMargin())
			->labelText($student->pnumber)
			->labelFont(new NotoSans(20))
			->labelAlignment(new LabelAlignmentCenter())
			->build();
		$data = [
			'courses' => $this->course_model->getCoursesRegisteredForSemesterExamsCard($param),
			'student' => $student,
			'qr_code' => $result->getDataUri(),
			'timetable' => $this->course_model->getExamsTimetable($param),
		];
		var_dump($data); die;
		return $this->load->view('course/ecard', $data);
	}
	public function exams_card()
	{
		$_SESSION['pageTitle'] = 'Examination Cards .::. University Portal';
		$data = [
			'exams_cards' => $this->course_model->getExamsCard($_SESSION['uniqueID'])
		];
		return $this->load->view('course/exam_cards', $data);
	}

	public function elearning(){
		$_SESSION['pageTitle'] = 'eLearning .::. University Portal';
		$param = [
            'semester' => $_SESSION['active_semester'],
            'studentid' => $_SESSION['pnumber']
        ];
		$data = [
			'mycourses' => $this->course_model->getECardCourses($param),
		];
		return $this->load->view('course/elearning', $data);
	}
	
	public function printecard(){
	    $semester = $this->uri->segment(4);
	    $pnumber = substr($_SESSION['username'], 0, 10);
        $param = [
            'semester' => $semester,
            'studentid' => $pnumber
        ];
		$data = [
		    'student' => $this->course_model->getDetails($pnumber),
		    'info' => $this->course_model->getSemesterInfo($semester),
		    'courses' => $this->course_model->getECardCourses($param)
		];
	    $this->load->view('course/ecard', $data);
	}
	public function getDepartmentByFaculty(){
	    $faculty = $this->input->post('faculty');
	    echo json_encode($this->course_model->getDepartmentByFaculty($faculty));
	}
	public function getCoursesByFilter(){
	    $param = [
	        'deptid' =>$this->input->post('deptid'),
	        'level' =>$this->input->post('level'), 
	        'semester' =>$this->input->post('semester'), 
	        'session' =>$_SESSION['active_session']
	   ];
	   echo json_encode($this->course_model->getCoursesByFilter($param));
	}
	public function addSingleCourse(){
	    $param = [
	        'csid' =>$this->input->get('courseid'),
	        'studentid' =>substr($_SESSION['username'], 0, 10), 
	        'level' => $_SESSION['current_level'],
	        'programid' =>$_SESSION['programid'],
	        'levelcoord_approval' => "NO",
	        'levelcoord_date' => NULL,
	   ];
	   
	   echo $this->course_model->addSingleCourse($param);
	}
	public function dropSingleCourse(){
	   $id = $this->uri->segment(3, false);
	   $level = $this->uri->segment(4, false);
	   $session = $this->uri->segment(5, false);
	   if(!$id or !$session){
	       $this->session->set_flashdata('msg', "Course NOT FOUND"); 
	   }else{
    	   $this->course_model->dropCourse($id, $level);
    	   $this->session->set_flashdata('msg', "Course dropped successfully");
	   }
	   redirect('course/ammend/'.md5(time()).'/'.$session, 'refresh');
	}
	
	public function mycourses(){
		$_SESSION['myactive_sesssion'] = isset($_SESSION['myactive_sesssion']) ? $_SESSION['myactive_sesssion'] : $_SESSION['active_semester'];
		$param = [
			'semester' => $_SESSION['myactive_sesssion'],
			'lecturerid' => $_SESSION['userid']
		];

		$data = [
			'sessions' => $this->result_model->getAllSession(),
			'mycourses' => $this->course_model->getMyCourses($param)
		];
		//var_dump($data); die;
	
		$this->load->view('course/mycourses', $data);
	}

	public function change_semester(){
		$_SESSION['myactive_semester'] = $this->input->post('semester');
		redirect('course/mycourses', 'refresh');
	}
	public function lecture_time_table(){
	    $semester = 69;
	   // $pnumber = substr($_SESSION['username'], 0, 10);
	   $pnumber = 2010204022;
      
		$data = [
		    'student' => $this->course_model->generate_ttable($pnumber, $semester),
		   
		];
	    $this->load->view('course/ttable', $data);
	}
	
	
	public function manager(){
	    $_SESSION['pageTitle'] = 'Course Manager .::. University Portal';
	    $data = [
	        'course_dist' => $this->course_model->courseScheduleDistribution($_SESSION['active_session']) 
	    ];
        $this->load->view('coursemanager/index', $data);
	}
	
	
	public function course_schedule(){
	    $_SESSION['pageTitle'] = 'Course Schedule .::. University Portal';
	    $sessionid = $this->uri->segment(4, false);
	    $programid = $this->uri->segment(5, false);
	    $level = $this->uri->segment(6, false);
	    
	    if(!$sessionid or !$programid or !$level){
	        redirect('course/manager', 'refresh');
	    }
	    $data = [
	        'progInfo' => $this->course_model->getProgrammeInfo($programid),   
	        'courseInfo' => $this->course_model->getCourseSchedule($sessionid, $programid, $level)
	    ];
        $this->load->view('coursemanager/course_schedule', $data);
	}
	
	public function register(){
	    $_SESSION['pageTitle'] = 'Course Registration .::. University Portal';
	    
	    //form the session
	    $session = $this->uri->segment(4, false)."/".$this->uri->segment(5, false);
	    
	    //get current user info
	    $user =  $this->course_model->getDetails($_SESSION['uniqueID']);
	    
	    $authorisedstatus = $this->course_model->getAuthorizedStatus($_SESSION['userid']);
	    
	    //echo $this->db->last_query(); die;
	    
	    if(!$authorisedstatus or !$authorisedstatus->code_assigned){
	        $this->session->set_flashdata('msg', "Please contact your departmental level coordinator for your course registration code!");
    	    redirect("course/history", 'refresh');
	    }
	    
	    //check if registered and load courses
	    $data = [ 'studentid' => $user->pnumber, 'session' => $session ];
	    $courses = $this->course_model->getCoursesRegisteredForSession($data);
	    
	    if(!$courses){
    	    $programid = $user->programid;
    	    $level = $user->current_level;
    	    $courses = $this->course_model->getCourseSchedule($session, $programid, $level);
	    }
	    
	    $data = [
	        'courseInfo' => $courses,
	        'carryovers' => $this->course_model->getCarryOvers($user->pnumber),
	        'authorisedstatus' => $authorisedstatus
	    ];
	    //echo $this->db->last_qeury(); die;
        $this->load->view('course/course_reg', $data);
	}
	
	public function verifycode(){
	    $code = $this->input->post('code');
	    $authorisedstatus = $this->course_model->getAuthorizedStatus($_SESSION['userid']);
	    if($authorisedstatus->code_assigned == $code){
    	    if($this->course_model->updateAuthorizedStatus($code)){
    	        $this->session->set_flashdata('msg', "Course registration code verified!");
    	        redirect('course/register', 'refresh');
    	    }else{
    	        $this->session->set_flashdata('msg', "Course registration code verification failed. Please try again!");
    	    }
	    }else{
	        $this->session->set_flashdata('msg', "Invalid Course registration code used. Please try again!");
	    }
	    redirect('course/register/'.$_SESSION['active_session'], 'refresh');
	}
	public function creg(){
	     $studentid = $this->session->userdata('pnumber');
	     $level = $this->session->userdata('current_level');
	     $programid = $this->session->userdata('programid');
	     $courses = $this->input->post('courses');
	     $unit = 0; $cunit = 0;
	     
	     for ($i=0; $i< count($courses); $i++){
    	     $indexOfDash = strpos($courses[$i], '-');
    	     $cunit += substr($courses[$i], $indexOfDash+1); 
    	 }  
    	 if($cunit > 48){
    	     $this->session->set_flashdata('msg', "You can only register maximum of  48 Unit per  Session"); 
    	     redirect("course/history", 'refresh');
    	 }
    	 
    	 $coursedata = [];
	    
    	 for ($i=0; $i< count($courses); $i++){
    	    $indexOfDash = strpos($courses[$i], '-');
    	    $csid = substr($courses[$i], 0, $indexOfDash); 
    	    $unit += substr($courses[$i], $indexOfDash+1); 
    	    $coursedata[] = ['studentid' =>$studentid, 'csid'=>$csid, 'programid'=>$programid, 'level'=>$level, 'sessionid' => $_SESSION['active_session_id']];
    	 } 
    	 $result = $this->course_model->register_courses($coursedata);
    	 if($result){
    	    $this->session->set_flashdata('msg', "Course Registration Successful");
    	    redirect("course/history", 'refresh');
    	 }
	  
	}
	
	public function courselist(){
	     $result = $this->course_model->getcourselist($_SESSION['active_session']);
	     $data = [
	         'courselist' => $result
	     ];
	     $this->load->view('course/courselist', $data);
	}
	
	public function allocate(){
	    $id = $this->uri->segment(4, false);
	    if(!$id){
	        redirect("course/courselist", 'refresh');
	    }
	    $data = [
	        'course' => $this->course_model->getCourseByID($id),
	        'staff' => $this->course_model->getStaffList(),
	        'allocated'=> $this->course_model->getCourseAllocation($id)
	    ];
	    //echo $this->db->last_query(); var_dump($data["allocated"]); die;
	    $this->load->view('course/allocate', $data);
	  
	}
	public function pg_courses(){
	    $result = $this->course_model->get_pg_courses();
	    $data = array("result"=>$result);
	    $this->load->view("course/pg_courses", $data);
	}
	public function save_course(){
	   $data = $_POST;
	   $data['hashcode'] = hash("md5", date('his'));
	   $result = $this->course_model->save_course($data);
	   if($result){
	        $this->session->set_flashdata('msg', "Course Added Successful");
    	    redirect("course/pg_courses", 'refresh');
	   }
	   
	}
	public function load_course(){
	    $level = $this->uri->segment(3);
	    $deptid = $this->uri->segment(4);
	    $result = $this->course_model->pg_courses($level, $deptid);
	    $data = array("result"=>$result);
	    $this->load->view("course/course_manager", $data);
    }
    
	public function drop_courses(){
	    $level = $this->uri->segment(3);
	    $deptid = $this->uri->segment(4);
	  
	    $result = $this->course_model->get_pg_courses();
	    $status = $this->course_model->drop_courses($level, $deptid);
	    if($status){
	        $this->session->set_flashdata("msg", "Courses Dropped successfully");
	        $data = array("result"=>$result);
	        $this->load->view("course/course_manager", $data);
	    }
	  
    }
    
    public function makeallocation(){
        
        $course_id = $_POST['course_id'];
        $lecturer_id = $_POST['lecturer_id'];
        
        if($lecturer_id == -1){
            $this->session->set_flashdata('msg', 'Lecturer ID not selected');
            redirect('course/allocate/'.md5(time()).'/'.$course_id, 'refresh');
        }
        $data = [
            'csid' => $course_id,
            'lecturerid' => $lecturer_id
        ];
        
        $result = $this->course_model->makeAllocation($data);
        
	    if($result){
	        $this->session->set_flashdata('msg', "Course Allocated Successful");
    	    redirect('course/allocate/'.md5(time()).'/'.$course_id, 'refresh');
	    }
    }
    
    public function removeallocation(){
        $course_id = $this->uri->segment(3, false);
        $allocation_id = $this->uri->segment(4, false);
        
	    if(!$allocation_id){
	        $this->session->set_flashdata('msg', 'Invalid allocation');
            redirect('course/allocate/'.md5(time()).'/'.$course_id, 'refresh');
	    }
	    $this->course_model->removeAllocation($allocation_id);
	    $this->session->set_flashdata('msg', "Course Allocation Updated");
	    redirect('course/allocate/'.md5(time()).'/'.$course_id, 'refresh');
    }
    
    public function course_evaluation(){
        $courselist = $this->course_model->course_evaluation();
        $data = array("courselist"=>$courselist);
        $this->load->view("course/course_evaluation", $data);
    }
    
    public function deptcourses(){
        $_SESSION['pageTitle'] = 'Departmental Course Manager .::. University Portal';
        $info = $this->levelmanager_model->currentStaffInfo();
        $data = [
            "courseallocation" => $this->course_model->deptCourseAllocation($info->dept_id)
        ];
        //echo $this->db->last_query(); var_dump($data); die;
        $this->load->view("coursemanager/dept_courses", $data);
    }
    
    public function allocatecourse(){
        $_SESSION['pageTitle'] = 'Assign Course Lecturer .::. University Portal';
        $id = $this->uri->segment(3, false);
        if(!$id){
            $this->session->set_flashdata('msg', "Invalid Course ID");
            redirect('course/deptcourses', 'refresh');
        }else{
    		$info = $this->levelmanager_model->currentStaffInfo();
    		$data = [
    			'staff' => $this->levelmanager_model->currentDeptStaff($info->dept_id),
    			'course' => $this->course_model->getSingleCourse($id),
    		];
    		return $this->load->view('course/allocatelecturer', $data);
        }
    }
    

	public function processallocate(){
		$params = [
		    'lecturerid' => $this->input->post('lecturer_id'),
		    'csid' => $this->input->post('csid')
		];
		
		$this->course_model->processallocation($params);
		$this->session->set_flashdata('msg', 'Course allocated successfully.');
		return redirect('course/deptcourses', 'refresh');
	}

	public function deallocatecourse(){
		$id = $this->uri->segment(3, false);
        if(!$id){
            $this->session->set_flashdata('msg', "Invalid Course ID");
        }else{
    		$this->course_model->deallocatecourse($id);
            $this->session->set_flashdata('msg', "Course allocation updated successfully");
    		
        }
        return redirect('course/deptcourses', 'refresh');
	}
	
	
	public function deptcoursescheule(){
	    $_SESSION['pageTitle'] = 'Departmental Course schedule .::. University Portal';
	    $info = $this->levelmanager_model->currentStaffInfo();
        $data = [
            "schedules" => $this->course_model->deptCourseSchedules($info->dept_id)
        ];
        $this->load->view("coursemanager/dept_courseschedule", $data);
	}
	public function deptviewschedule(){
	    $_SESSION['pageTitle'] = 'View Course schedule .::. University Portal';
	    $programid = $this->uri->segment(3);
	    $level = $this->uri->segment(4);
        $data = [
	        'progInfo' => $this->course_model->getProgrammeInfo($programid),   
	        'courseInfo' => $this->course_model->getCourseSchedule($_SESSION['active_session_id'], $programid, $level)
	    ];
        $this->load->view("coursemanager/viewschedule", $data);
	}
public function load_courses(){
        $result = $this->course_model->load_courses();
        $programs = $this->course_model->load_programs();
        $data = ['result'=>$result, 'program'=>$programs];
       $this->load->view("coursemanager/create_course_schedule", $data);
}
public function save_course_Schedule(){
    $id = $this->input->post('ids');

    $count = count($id);
    for($i=0; $i< $count; $i++){
        $arr = explode("-",$id[$i]);
        $data = [
                "courseid"=>$arr[0],
                "course_code"=>$arr[1],
                "session"=> "2024/2025",
                "programid"=>$this->input->post("programid"),
                "level" => 200,
            ];
       
        $result = $this->course_model->save_course_schedule($data);
    }
    if($result){
            $this->session->set_flashdata('msg', 'Course Schedule Save successfully.');
		    return redirect('course/load_courses', 'refresh');
    }
}
}
