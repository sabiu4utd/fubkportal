<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\Label\Alignment\LabelAlignmentCenter;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class SettingManager extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(['settings_model']);
	}

	public function index()
	{
		$_SESSION['pageTitle'] = 'Settings .::. University Portal';
		
		if(!$this->input->post("sessions")){
		    $_SESSION['settings_session'] = $_SESSION['active_session'];
		}else{
		    $_SESSION['settings_session'] = $this->input->post("sessions");
		}
		$session = $_SESSION['settings_session'];
		$data = [
			'settings' => $this->settings_model->getAllSettings($session),
			'sessions' => $this->settings_model->getSessions()
		];
		return $this->load->view('settingmanager/index', $data);
	}

	public function edit()
	{
		$_SESSION['pageTitle'] = 'Edit Settings .::. University Portal';
		$setting_id = $this->uri->segment(3, false);
		
		if(!$setting_id){
		    $this->session->set_flashdata('msg', 'Invalid Setting');
		    redirect('settingmanager/index', 'refresh');
		}
		$data = [
			'setting' => $this->settings_model->getSettings($setting_id)
		];
		return $this->load->view('settingmanager/edit', $data);
	}
	
	public function saveEdit()
	{
	    $id = $this->input->post("id");
	    
	    $params = [
	        $this->input->post("value"),
	        $this->input->post("start_date"),
	        $this->input->post("end_date"),
	        $this->input->post("status"),
	        date("Y-m-d H:i:s")
	    ];
	    
		if($this->settings_model->updateSetting($id, $params)){
		    $this->session->set_flashdata('msg', 'Settings updated successfully');
		}else{
		    $this->session->set_flashdata('msg', 'Settings update FAILED');
		}
		redirect('settingmanager/index', 'refresh'); 
	}
	
	public function acl()
	{
	    $_SESSION['pageTitle'] = 'Access Control Settings .::. University Portal';
	    $data = ['roles' => $this->settings_model->getRoles()];
		return $this->load->view('settingmanager/acl', $data); 
	}
	
	public function permissions()
	{
	    $_SESSION['pageTitle'] = 'Persmissions Settings .::. University Portal';
	    $data = ['permissions' => $this->settings_model->getPermissions()];
		return $this->load->view('settingmanager/permissions', $data); 
	}
	
	public function permissiongroup()
	{
	    $_SESSION['pageTitle'] = 'Persmission Groups Settings .::. University Portal';
	    $data = ['permissiongroup' => $this->settings_model->getPermissionGroup()];
		return $this->load->view('settingmanager/permissiongroup', $data); 
	}
	
	public function roles()
	{
	    $_SESSION['pageTitle'] = 'Role Assignment Settings .::. University Portal';
	    $data = ['assignments' => $this->settings_model->getRecentAssinments()];
		return $this->load->view('settingmanager/roles', $data); 
	}
	
}
