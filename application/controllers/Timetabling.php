
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Timetabling extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('timetable_model');
	}

	public function index(){
		$_SESSION['pageTitle'] = 'Timetabling .::. University Portal';
		$data = [
			'timetables' => $this->timetable_model->getTimetables(),
			'semesters' => $this->timetable_model->getSemesters(),
		];
		return $this->load->view('timetable/index', $data);
	}

	public function tt(){
		$_SESSION['pageTitle'] = 'General Timetable .::. University Portal';
		
		$semester = $this->uri->segment(4, false);
		$type = $this->uri->segment(5, "EXAMS");
		
		if(!$semester){
		    $this->session->set_flashdata('msg', 'Invalid selection');
		    redirect('timetabling/index', 'refresh');
		}
		
		$params = [
		    'semester' => $semester,
		    'type' => $type
		];
		
		$timetables = $this->timetable_model->generalTimetable($params);
		
		$tt = [];
		$headers = ["Day"];
		
		foreach($timetables as $row){
		    $tt[$row->tt_date][$row->start_time][] = [$row->course_code, $row->venue];
		    $headers[] = $row->start_time;
		}
		
		$data = [
			'timetables' => $tt,
			'headers' => array_unique($headers),
			'semester' => $semester,
			'type' => $type
		];
		return $this->load->view('timetable/tt', $data);
	}

	public function course(){
		$_SESSION['pageTitle'] = 'Course Timetable .::. University Portal';
		
		$course_code = $this->uri->segment(3, false);
		$semester = $this->uri->segment(4, $_SESSION['active_semester']);
		$type = $this->uri->segment(5, "Exams");
		
		if(!$course_code){
		    $this->session->set_flashdata('msg', 'Invalid Course');
		    redirect('timetabling/index', 'refresh');
		}
		
		$params = [
		    'semester' => $semester,
		    'type' => $type,
		    'course_code' => $course_code
		];
		
		$schedule = $this->timetable_model->getCourseSchedule($params);
		
		$data = [
			'schedule' => $schedule,
			'type' => $type,
			'semester' => $semester
		];
		//var_dump($data); die;
		return $this->load->view('timetable/schedule', $data);
	}
	
	public function update(){
	    $id = $_POST['tt_id'];
	    $tt_date = $_POST['tt_date'];
	    $start_time = $_POST['start_time'];
	    $end_time = $_POST['end_time'];
	    $venue = $_POST['venue'];
	    
	    $params = [
		    'tt_date' => $tt_date,
		    'start_time' => $start_time,
		    'end_time' => $end_time,
		    'venue' => $venue
		];
		
		$course = $this->timetable_model->updateSchedule($params, $id);
		$this->session->set_flashdata('msg', 'Update completed');
		
		redirect('timetabling/course/'.$course->course_code.'/'.$course->semester.'/'.$course->type, 'refresh');
		
	    
	}
	
	public function delete(){
	    $id = $this->uri->segment(3, false);
	    
		$course = $this->timetable_model->deleteSchedule($id);
		$this->session->set_flashdata('msg', 'Update completed');
		
		redirect('timetabling/tt/'.md5(time()).'/'.$course->semester.'/'.$course->type, 'refresh');
		
	    
	}
	
}