<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pgs extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['userid'])){
			redirect('auth/logout', 'refresh');
		}
		$this->load->library('upload');
	}
	public function index(){
	    $_SESSION['pageTitle'] = 'PGSchool Welcome .::. University Portal';
		
		$curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/types",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [],
        ]);
        
        $forms = curl_exec($curl);
        
        curl_setopt_array($curl, [
          CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/formstats",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [
            "Accept: */*",
            "User-Agent: Thunder Client (https://www.thunderclient.com)"
          ],
        ]);
        
        $stats = curl_exec($curl);
        curl_close($curl);
        
		$data = [
		    'forms' => json_decode($forms),
		    'stats' => json_decode($stats)
		];
		//var_dump($data); die;
		return $this->load->view('pgs/index', $data);
	}
	
	
	public function viewall(){
		$_SESSION['pageTitle'] = 'All Forms .::. University Portal';
		
		$curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/forms",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
          CURLOPT_HTTPHEADER => [],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        $data = [
		    'applicants' => json_decode($response)    
		];
        
		return $this->load->view('pgs/forms', $data);
	}
	
	public function view(){
		$_SESSION['pageTitle'] = 'Applicant Forms .::. University Portal';
	
            $curl = curl_init();
            
              curl_setopt_array($curl, [
              CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/details/".$this->uri->segment(3),
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => [
               
              ],
            ]);
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);
             $data = ['applicant_data' => json_decode($response)];
             return $this->load->view('pgs/applicant_info', $data);
            
           
            
            
	}
	
	
	
	
	
	
	
	
	
	/*public function edit(){
	    $_SESSION['pageTitle'] = 'Edit Student .::. University Portal';
		$studentid = $_SESSION['userid'];
		$data = [
			'student' => $this->student_model->getBio($studentid),
			'contact_info' => $this->student_model->getContactInfo($studentid)
		];
		return $this->load->view('student/edit', $data);
	}
	public function saveEdit(){
        $data = [
            'personal_phone' => trim($this->input->post('phone')), 
            'personal_email' => trim($this->input->post('personal_email')), 
            'contact_address' => trim($this->input->post('contact_address')),
            'permanent_address' => trim($this->input->post('permanent_address')),
            'nok_name' => trim($this->input->post('nok_name')),
            'nok_relationship' => trim($this->input->post('nok_relationship')),
            'nok_phone' => trim($this->input->post('nok_phone')),
            'nok_email' => trim($this->input->post('nok_email')),
            'nok_address' => trim($this->input->post('nok_address')),
        ];
		if($this->student_model->saveEdit($data)){
			$data = [
				'column' => 'bio_update',
				'value' => 1,
				'userid' => $_SESSION['userid']
			];
			if($this->student_model->updateWorkflow($data)){
				$_SESSION['workflow']->bio_update = 1;
			}
		    $this->session->set_flashdata('msg', 'Update Successful');
		}else{
		    $this->session->set_flashdata('msg', 'Update Failed, please try again');
		}
		return redirect('student/view', 'refresh');
	}
	public function uploadPassport(){
	    if($_FILES["passport"]['size'] < 2097152 or $_FILES["passport"]['size'] > 4194304){
	        $this->session->set_flashdata('msg', 'Passport size must be between 2MB and 4MB');
	    }
	    $file = $_SESSION['uniqueID'].'.'.pathinfo($_FILES['passport']['name'], PATHINFO_EXTENSION);
	    $config = [
			'upload_path' => './passport/',
			'allowed_types' => 'jpg|png|jpeg|JPG|JPEG|PNG',
			'file_name' => $file
		];
		$this->upload->initialize($config);
	    if(!$this->upload->do_upload('passport')){
            $this->session->set_flashdata('msg', $this->upload->display_errors());
        }else{
            $this->student_model->savePassport(['passport' => $file]);
            $this->session->set_flashdata('msg', 'Update Successful');
        }
        return redirect('student/edit', 'refresh');
	}

	public function studentmanager(){
		$_SESSION['pageTitle'] = 'Student Manager .::. University Portal';
		return $this->load->view('studentmanager/index');
	}*/
}