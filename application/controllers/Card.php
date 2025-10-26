<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class Card extends CI_Controller {
    
	public function __construct(){
		parent::__construct();
		$this->load->model(['student_model', 'staff_model', 'card_model']);
	}
	
    private function checkUserID($userid){
		if(!$userid || !is_numeric($userid)){
			$this->session->set_flashdata('msg', 'Invalid Student Information. Please Try Again');
			redirect('registration/admissions/'.str_replace("/", "_",$_SESSION['adm_session']), 'refresh');
		}else{
			return true;
		}
	}
    
	public function change_session(){
        $sess = str_replace("/", "_",$this->input->post('session'));
        //var_dump($sess); die;
        $_SESSION['current_session'] = $sess ;
		redirect('card/index', 'refresh');
	}
	
    public function index(){
        $session = isset($_SESSION['current_session']) ? str_replace("_", "/",$_SESSION['current_session']) : $_SESSION['active_session'];
        //var_dump($session); die;
		$data = [
            'adm_session' => $this->card_model->getSessions(),   
	        'summary' => $this->card_model->getSummaryByFaculty($session),   
	    ];
        return $this->load->view('cardservices/index', $data);
	}
	
    public function list(){
        $session = isset($_SESSION['current_session']) ? str_replace("_", "/",$_SESSION['current_session']) : $_SESSION['active_session'];
        $programid = $this->uri->segment(3, false);
        if (!$programid){
            redirect('card/index', 'refresh');
        }
        $data = [
            'list' => $this->card_model->getStudentsByProgramID($programid, $session),   
	    ];
        return $this->load->view('cardservices/list', $data);
	}
	
	public function stafflist(){
        $data = [
            'list' => $this->card_model->getStaffList(),   
	    ];
        return $this->load->view('cardservices/stafflist', $data);
	}
	
    public function generate(){
        if(!isset($_POST['selected_ids']) or count($_POST['selected_ids']) == 0){
            $this->session->set_flashdata('msg', 'Invalid/Empty Selection. Please try again');
            return redirect('card/index', 'refresh');
        }
        $ids = $_POST['selected_ids'];
        
        $list = "(";
        foreach($ids as $id){
            $list .= $id.", ";
        }
        $list = substr($list, 0, strlen($list)-2). ")"; 
        
        $data = [
            'idcards' => $this->card_model->getIDCardInfo($list),   
	    ];
        return $this->load->view('cardservices/print', $data);
	}

    public function generateForStaff(){
        
        $id = $this->uri->segment(3, false);
        
        $data = [
            'idcards' => $this->card_model->getIDCardInfoStaff($id),   
	    ];
        return $this->load->view('cardservices/printstaff', $data);
	}

    public function edit(){
        
        $id = $this->uri->segment(3, false);
        
        $data = [
            'staff' => $this->card_model->getIDCardInfoStaff($id)[0] ?? NULL, 
            'designations' => $this->card_model->getDesignations(),
            'departments' => $this->card_model->getDepartments(),
            'appts' => $this->card_model->getApptTypes(),
	    ];
        return $this->load->view('cardservices/editstaff', $data);
	}

    public function saveedit(){
        $this->card_model->saveEdit($_POST);
        
        return redirect('card/stafflist', 'refresh');
	}

    public function verify(){
        $data = [];
        
        if(isset($_POST['studentid'])){
            $row = $this->card_model->getIDCardInfoByPnumber($_POST['studentid']);
            $data = [
                'user' => $row,
                'found' => $row ? true : false ,
                'type' => $_POST['type']
            ];
            
            if($_POST['type'] != "Identity Card"){
                $param = [
                    'studentid' => $_POST['studentid'],
                    'semester' => 71
                ];
                $data['courses'] = $this->card_model->getECardCourses($param);
            }
            
        }
        return $this->load->view('cardservices/verify', $data);
	}
	
    
}