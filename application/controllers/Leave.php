<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leave extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Leave_model');
	}

	public function index(){
		$data = [
			'leave' => $this->Leave_model->getMyLeaves()
		];
		return $this->load->view('leave/index', $data);
	}

	public function create(){
		$this->session->set_userdata('pageTitle', 'Create Leave Application .::. HR-FUBK');
		return $this->load->view('leave/create');
	}

	public function edit(){
		$this->session->set_userdata('pageTitle', 'Edit Leave .::. HR-FUBK');
		$hash = $this->uri->segment(3) ? $this->uri->segment(3) : false;
		if(!$hash) {
			$this->session->set_flashdata('msg', 'Invalid Leave Information. Please Try Again');
			redirect('leave/myleave', 'refresh');
		}
		$data = [
			'leave' => $this->Leave_model->getLeave($hash),
		];
		$this->load->view('leave/edit', $data);
	}

	public function myleave(){
		$this->session->set_userdata('pageTitle', 'My Leave Dashboard .::. HR-FUBK');
		$data = [
			'leaves' => $this->Leave_model->getLeaves($_SESSION['userid']),
		];
		$this->load->view('leave/myleave', $data);
	}

	public function add(){
		$data = [
			'userid' => $_SESSION['userid'],
			'start_date' => strtotime ($this->input->post('start_date')),
			'end_date' => strtotime ($this->input->post('end_date')),
			'type' => $this->input->post('type'),
			'reason' => $this->input->post('reason'),
		];
		$this->Leave_model->addLeave($data);
		$this->session->set_flashdata('msg', 'Leave Submitted Successfully');
		return redirect('leave/myleave', 'refresh');
	}

	public function view(){
		$hash = $this->uri->segment(3) ? $this->uri->segment(3) : false;
		if(!$hash) redirect('staff', 'refresh');

		$data = [
			'staff' => $this->Leave_model->getStaff($hash)
		];
		return $this->load->view('staff/view', $data);
	}
}
