<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registrar extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	}

	public function index(){
		$this->session->set_userdata('pageTitle', 'Registrar Dashboard .::. SIMS');
		$this->load->view('registrar/index');
	}
}
