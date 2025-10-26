<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class Bursary extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->model(['bursary_model', 'result_model']);
	}
	
	public function change_session(){
        $_SESSION['bursary_active_session']  = $_POST['session'] ? $_POST['session'] : $_SESSION['active_session'];
		redirect('bursary/index', 'refresh');
	}
	
	public function index(){
	    $session = isset($_SESSION['bursary_active_session']) ? $_SESSION['bursary_active_session'] : $_SESSION['active_session'];
	    $data = [
	        'sessions' => $this->result_model->getSession(),
	        'summary' => $this->bursary_model->getPaymentSummary($session)
	    ];
	    $this->load->view('bursary/index', $data);
	}
	
	public function program(){
	    $program = $this->uri->segment(4, false);
	    if(!$program){
	        redirect('bursary/index', 'refresh');
	    }
	    
	    $params = [
	        'programid' => $program,
	        'session' => isset($_SESSION['bursary_active_session']) ? $_SESSION['bursary_active_session'] : $_SESSION['active_session']
	    ];
	    
	    $data = [
	        'summary' => $this->bursary_model->getPaymentWithFilter($params),
	    ];
	    
	    $this->load->view('bursary/program', $data);
	}
	
	public function list(){
	    $active_filters = [
	        'session' => $_SESSION['active_session'],
	        'type' => 0,
	        'program' =>  1,
	        'mode' => 0,
	    ];
	    
	    if(isset($_POST['submit'])){
	        $active_filters['session'] = isset($_POST['session']) ? $_POST['session'] : $_SESSION['active_session'];
	        $active_filters['type'] = isset($_POST['type']) ? $_POST['type'] : 0;
	        $active_filters['program'] = isset($_POST['program']) ? $_POST['program'] : 0;
	        $active_filters['mode'] = isset($_POST['mode']) ? $_POST['mode'] : 0;
	    }
	    
	    $data = [
	        'filters' => $this->bursary_model->getFilters(),
	        'active_filters' => $active_filters,
	        'payments' => $this->bursary_model->getPayments($active_filters),
	    ];
	    
	    $this->load->view('bursary/list', $data);
	}
	
	public function analysis(){
	    $data = [
	        'items' => $this->bursary_model->getFeeItems($_SESSION['active_session'])
	    ];
	    $this->load->view('bursary/analysis', $data);
	}
	
	public function analyse(){
	    $itemid = $this->uri->segment(3, false);
	    
	    if(!$itemid){
	        redirect('bursary/analysis', 'refresh');
	    }
	    
	    $data = [
	        'analysis' => $this->bursary_model->getFeeItemAnalysis($itemid)
	    ];
	    $this->load->view('bursary/analyse', $data);
	}
	
	public function search(){
	    
	    $student_no = $this->input->post("student_no");
	    if($this->uri->segment(3)){
	        $student_no = $this->uri->segment(3);
	    }
	    
	    if(!is_numeric($student_no)){
	        $this->session->set_flashdata('msg', 'Invalid Admission Number');
	        redirect('bursary/index', 'refresh');
	    }
	    
	    $history = $this->bursary_model->studentPaymentHistory($student_no);
	    
	    if(!$history){
	        $this->session->set_flashdata('msg', 'Payment records not found');
	        redirect('bursary/index', 'refresh');
	    }
	    $data = [
	        'history' => $history
	    ];
	    
	    $this->load->view('bursary/student', $data);
	}
	public function graduation_fees(){
	    $data = [
	        'graduation_fees' => $this->bursary_model->getGraduationFees()
	    ];
		//var_dump($data); exit;
	    $this->load->view('bursary/graduation_fees', $data);
	}
	
	
}
