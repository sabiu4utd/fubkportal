<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Levelmanager extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->model(['levelmanager_model', 'student_model', 'course_model']);
	}

	public function index(){
		$_SESSION['pageTitle'] = 'Level Manager .::. University Portal';
		
		$data = [
			'levels' => $this->levelmanager_model->getLevelCoordinators()
		];
		return $this->load->view('levelmanager/index', $data);
	}

	public function dept(){
		$_SESSION['pageTitle'] = 'Level Manager .::. University Portal';
		
		$info = $this->levelmanager_model->currentStaffInfo();
		$data = [
			'levels' => $this->levelmanager_model->getDeptLevelCoordinators($info->dept_id)
		];
		return $this->load->view('levelmanager/dept', $data);
	}

	public function allocatecoordinator(){
		$_SESSION['pageTitle'] = 'Assign Level Coordinator .::. University Portal';
		$info = $this->levelmanager_model->currentStaffInfo();
		$data = [
			'staff' => $this->levelmanager_model->currentDeptStaff($info->dept_id),
			'programmes' => $this->levelmanager_model->currentDeptProgrammes($info->dept_id),
		];
		return $this->load->view('levelmanager/allocatecoordinator', $data);
	}

	public function processallocate(){
		$_SESSION['pageTitle'] = 'Assign Level Coordinator .::. University Portal';
		$params = [
		    'lecturer_id' => $this->input->post('lecturer_id'),
		    'level' => $this->input->post('level'),
		    'program_id' => $this->input->post('program_id'),
		    'session' => $_SESSION['active_session_id']
		    
		];
		
		$this->levelmanager_model->processallocation($params);
		$this->session->set_flashdata('msg', 'Level Coordinator Allocated Successfully.');
		return redirect('levelmanager/dept', 'refresh');
	}

	public function remove(){
		$id = $this->uri->segment(4, false); 
		if(!$id){
		    $this->session->set_flashdata('msg', 'Invalid ID.');
		}else{
		    $this->levelmanager_model->remove($id);
		    $this->session->set_flashdata('msg', 'Level Coordinator Updated Successfully.');
		}
		return redirect('levelmanager/dept', 'refresh');
	}

	public function mylevels(){
		$_SESSION['pageTitle'] = 'List of Levels .::. University Portal';
		
		$data = [
			'levels' => $this->levelmanager_model->getLevelCoordinatorRole($_SESSION['userid'])
		];
		return $this->load->view('levelmanager/mylevels', $data);
	}

	public function view(){
		$prog_id = $this->uri->segment(4, false);
		$level = $this->uri->segment(5, 100);
		$session = $this->uri->segment(6, $_SESSION['active_session_id']);
		
		$records = $this->levelmanager_model->getStudents($prog_id, $level, $session);
		if(!$records){
		    $this->session->set_flashdata('msg', 'Student records not found. Please refresh your codes.');
		    return redirect('levelmanager/index', 'refresh');
		}
		$data = [
			'students' => $records
		];
		return $this->load->view('levelmanager/view', $data);
	}

	public function deptview(){
	   $prog_id = $this->uri->segment(4, false); 
		//$prog_id = 61;
		$level = $this->uri->segment(5, 100);
		$session = $this->uri->segment(6, $_SESSION['active_session_id']);
		
		$records = $this->levelmanager_model->getStudents($prog_id, $level, $session);
		if(!$records){
		    $this->session->set_flashdata('msg', 'Student records not found. Please refresh your codes.');
		    return redirect('levelmanager/dept', 'refresh');
		}
		$data = [
			'students' => $records
		];
		return $this->load->view('levelmanager/deptview', $data);
	}

	public function myview(){
		$prog_id = $this->uri->segment(4, false);
		$level = $this->uri->segment(5, 100);
		$session = $this->uri->segment(6, $_SESSION['active_session_id']);
		
		$records = $this->levelmanager_model->getStudents($prog_id, $level, $session);
		//echo $this->db->last_query(); die;
		if(!$records){
		    $this->session->set_flashdata('msg', 'Student records not found. Please refresh your codes.');
		    return redirect('levelmanager/mylevels', 'refresh');
		}
		$data = [
			'students' => $records
		];
		return $this->load->view('levelmanager/myview', $data);
	}

	public function assign(){
		$prog_id = $this->input->post('programid', false);
		$level = $this->input->post('level', false);
		$session_id = $this->input->post('sessionid', false);
		$this->levelmanager_model->generateCodes($prog_id, $level, $session_id);
		echo true;
	}

	public function updateassign(){
		$prog_id = $this->input->post('programid', false);
		$level = $this->input->post('level', false);
		$session_id = $this->input->post('sessionid', false);
		$this->levelmanager_model->updateCodes($prog_id, $level, $session_id);
		echo true;
	}

	public function myassign(){
	    $prog_id = $this->input->post('programid', false);
		$level = $this->input->post('level', false);
		$session_id = $this->input->post('sessionid', false);
		$this->levelmanager_model->generateCodes($prog_id, $level, $session_id);
		echo true;
        //$prog_id = $this->uri->segment(4, false);
        //$level = $this->uri->segment(5, false);
        	
        //$this->levelmanager_model->generateCodes($prog_id, $level);
        //echo $this->db->last_query(); die;
        //$this->session->set_flashdata('msg', 'Course registration codes assigned successfully.');
        //return redirect('levelmanager/mylevels', 'refresh');
	}

	public function codeassign(){
		$id = $this->uri->segment(4, false);
		$programid = $this->uri->segment(5, false);
		$level = $this->uri->segment(6, false);
		$session = $this->uri->segment(7, false);
		
		$this->levelmanager_model->generateSingleCodes($id);
		$this->session->set_flashdata('msg', 'Course registration code assigned successfully.');
		return redirect('levelmanager/view/'.md5(time()).'/'.$programid.'/'.$level.'/'.$session.'/'.md5(time()), 'refresh');
	}

	public function deptcodeassign(){
		$id = $this->uri->segment(4, false);
		$programid = $this->uri->segment(5, false);
		$level = $this->uri->segment(6, false);
		$session = $this->uri->segment(7, false);
		
		$this->levelmanager_model->generateSingleCodes($id);
		$this->session->set_flashdata('msg', 'Course registration code assigned successfully.');
		return redirect('levelmanager/deptview/'.md5(time()).'/'.$programid.'/'.$level.'/'.$session.'/'.md5(time()), 'refresh');
	}

	public function mycodeassign(){
		$id = $this->uri->segment(4, false);
		$programid = $this->uri->segment(5, false);
		$level = $this->uri->segment(6, false);
		$session = $this->uri->segment(7, false);
		
		$this->levelmanager_model->generateSingleCodes($id);
		$this->session->set_flashdata('msg', 'Course registration code assigned successfully.');
		return redirect('levelmanager/myview/'.md5(time()).'/'.$programid.'/'.$level.'/'.$session.'/'.md5(time()), 'refresh');
	}
	
	public function coursereg(){
	    $_SESSION['pageTitle'] = $this->uri->segment(4, false).' Course Form .::. University Portal';
	    $data = [
			'session' => $this->uri->segment(5, false),
			'studentid' => $this->uri->segment(4, false)
		];
		$courses = $this->course_model->getCoursesRegisteredForSession($data);
		if(!$courses) {
		    echo "No courses registered for this student"; 
		    die;
		}
		$student = $this->student_model->getBioByPnumber($this->uri->segment(4, false));
		$data = [
			'courses' => $courses,
			'student' => $student,
			'is_lc' => true,
			'authorizedStatus' => $this->course_model->getAuthorizedStatus($student->userid)
		];
		return $this->load->view('course/print', $data);
	}
	
	public function update(){
	    //print_r($this->uri);
	    $status = $this->uri->segment(4);
	    $session = $this->uri->segment(5);
	    $prog_id = $this->uri->segment(6);
		$level = $this->uri->segment(7);
		$userid = $this->uri->segment(8);
		$pnumber = $this->uri->segment(9);
	    
	    if($status){
	        $params = [1, date('Y-m-d H:i:s'), $_SESSION['userid'], $userid, $level, $session];
	        $this->levelmanager_model->updateCourseReg($params);
	    }else{
	        $params = [$pnumber, $level, $session, $userid];
	        $this->levelmanager_model->clearCourseReg($params);
	    }
	    
		return redirect('levelmanager/view/'.md5(rand()).'/'.$prog_id.'/'.$level, 'refresh');
	}

}
