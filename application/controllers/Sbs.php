<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Sbs extends CI_Controller {
	public function __construct(){
		parent::__construct();
		if(!isset($_SESSION['userid'])){
			redirect('auth/logout', 'refresh');
		}
		$this->load->library('upload');
	}
	
	public function index(){
	    $_SESSION['pageTitle'] = 'School of Basic Studies .::. Federal University Birnin Kebbi';
		
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
		return $this->load->view('sbs/index', $data);
	}
	
	
	public function viewall(){
		$_SESSION['pageTitle'] = 'SBS Forms .::. University Portal';
		
		 /*
		    0 - pending
		    1 - admitted
		    2 - rejected
		    3 - all forms
		 */
		
		$form_status = $this->uri->segment(3, 0);
		
		$curl = curl_init();

        curl_setopt_array($curl, [
          CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/sbsforms/".$form_status,
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
        
		return $this->load->view('sbs/forms', $data);
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
             return $this->load->view('sbs/applicant_info', $data);
	}
	
	public function process(){
	    $form_hash = $this->uri->segment(3, 0);
	    $status = $this->uri->segment(4, 0);
	    $form_type = $this->uri->segment(5, 0);
        
        $curl = curl_init();
        
          curl_setopt_array($curl, [
          CURLOPT_URL => "https://eforms.fubk.edu.ng/formapi/process/".$form_hash.'/'.$status,
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
        //var_dump($response);
        curl_close($curl);
        
        $this->session->set_flashdata('msg', 'Admission Status updated');
        redirect('sbs/viewall/'.$form_type, 'refresh');
	}
	

	
}