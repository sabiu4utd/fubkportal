<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Result extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('PDFParser_Lib');
		$this->load->model('Result_model');
		$this->load->model('Settings_model');
		$this->load->model('Student_model');
	}
	public function index(){
		$_SESSION['pageTitle'] = 'Results Welcome .::. University Portal';
        $dash = $this->Settings_model->getDashInfo($_SESSION['active_semester']);
        $_SESSION['semester_code'] = $dash->id;
        $_SESSION['semester_val'] = $dash->value." Semester, ".$dash->session;
		$data = [
            'dash' => $dash,
			'sessions' => $this->Result_model->getAllSession(),
            'course_summary' => $this->Result_model->getCountAllCourses($_SESSION['semester_code']),
            'dept_course_summary' => $this->Result_model->getCountAllCoursesByDept($_SESSION['semester_code'])
        ];
		return $this->load->view('result/index', $data);
	}
	public function uploads(){
		$_SESSION['pageTitle'] = 'Results Uploads .::. University Portal';
        $dash = $this->Settings_model->getDashInfo($_SESSION['active_semester']);
        $_SESSION['semester_code'] = $dash->id;
        $_SESSION['semester_val'] = $dash->value." Semester, ".$dash->session;
		$data = [
            'dash' => $dash,
			'sessions' => $this->Result_model->getAllSession(),
            'course_summary' => $this->Result_model->getCountAllCourses($_SESSION['semester_code']),
            'dept_course_summary' => $this->Result_model->getCountAllCoursesByDept($_SESSION['semester_code'])
        ];
		return $this->load->view('result/uploads', $data);
	}
	public function pdf(){
		$_SESSION['pageTitle'] = 'Results Uploads .::. University Portal';
		$data = [
			'sessions' => $this->Settings_model->getAllSession(),
			'departments' => $this->Settings_model->getAllDepartments(),
			'pdf_summary' => $this->Result_model->getPDFSummary(),
        ];
		return $this->load->view('result/pdf', $data);
	}
	public function studentsummary(){
		$_SESSION['pageTitle'] = 'Student Result PDF .::. University Portal';
		$pnumber = $this->input->post('pnumber', false);
		if(!$pnumber){
		    $this->session->set_flashdata('msg', 'Invalid Student ID');
		    redirect('result/pdf', 'refresh');
		}
		
		$history = $this->Result_model->getAllStudentResult($pnumber);
		
		if(!$history){
		    $this->session->set_flashdata('msg', 'Results not found for this Student ID');
		    redirect('result/pdf', 'refresh');
		}
		$data = [
			'history' => $history
        ];
		return $this->load->view('result/studentsummary', $data);
	}
	public function gst(){
		$_SESSION['pageTitle'] = 'GST Results .::. University Portal';
		$data = [
			'results' => $this->Result_model->getGSTResult($_SESSION['pnumber'])
        ];
		return $this->load->view('result/gst', $data);
	}
	public function pdflist(){
		$_SESSION['pageTitle'] = 'Results Uploads .::. University Portal';
		$param = [
			'session' => str_replace('_', '/', $this->uri->segment(3)),
			'semester' => $this->uri->segment(4)
		];
		$data = [
			'session' => $param['session'],
			'semester' => $param['semester'],
			'summary' => $this->Result_model->getPDFSummaryByDept($param),
        ];
		return $this->load->view('result/pdflist', $data);
	}
	public function pdflistdept(){
		$_SESSION['pageTitle'] = 'Results Uploads .::. University Portal';
		$deptid = $this->uri->segment(3);
		$data = [
			'summary' => $this->Result_model->getPDFSummaryBySelectedDept($deptid),
        ];
		return $this->load->view('result/pdflistdept', $data);
	}
	public function listed(){
		$_SESSION['pageTitle'] = 'Results Uploads .::. University Portal';
		$param = [
			'deptid' => $this->uri->segment(3),
			'session' => str_replace('_', '/', $this->uri->segment(4)),
			'semester' => $this->uri->segment(5)
		];
		$data = [
			'session' => $param['session'],
			'semester' => $param['semester'],
			'summary' => $this->Result_model->getPDFSummaryForDept($param),
        ];
		return $this->load->view('result/listed', $data);
	}
	public function dropall(){
		$param = [
			'deptid' => $this->uri->segment(3),
			'session' => str_replace('_', '/', $this->uri->segment(4)),
			'semester' => $this->uri->segment(5)
		];
		$target_dir = "./results/".$param['semester']."_".str_replace("/", "", $param['session']).'/';
		$files = $this->Result_model->dropAll($param);
		$ids = "";
		foreach($files as $file){
		    @unlink($target_dir.$file->filename);
		    $ids .= $file->id.",";
		}
		$ids = substr($ids, 0, strlen($ids)-1);
		$this->Result_model->deleteAll($ids);
		redirect('result/pdf', 'refresh');
	}
	public function change_session(){
		$_SESSION['active_semester'] = $this->input->post('semester');
		return redirect('result/index', 'refresh');
	}
	public function testExcel(){
		$document_title = md5(rand().date("ymdhis")).".xlsx";
		$spreadsheet = new Spreadsheet();
		$spreadsheet->getProperties()
			->setCreator($_SESSION['username'])
			->setLastModifiedBy(date("Y-m-d H:i:s"))
			->setTitle($document_title)
			->setSubject($_SESSION['semester_val'])
			->setDescription("Uploaded result for ".$_SESSION['semester_val'])
			->setKeywords($_SESSION['semester_val'].", ".$this->input->ip_address())
			->setCategory($_SESSION['semester_val']);
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setCellValue('A1', 'Hello World !');
		$writer = new Xlsx($spreadsheet);
		$writer->save($document_title);
	}
	public function history() {
		$_SESSION['pageTitle'] = 'Result History.::. University Portal';
		$data = [
			'result_history' => $this->Result_model->getResultHistory($_SESSION['uniqueID'])
		];
		return $this->load->view('result/result_history', $data);
	}
	public function approvePayslip(){
		$hash = $this->uri->segment(3) ? $this->uri->segment(3) : false;
		if(!$hash) redirect('payslip', 'refresh');
		if($this->Payslips_model->approvePayslip($hash)){
			$this->session->set_flashdata('msg', 'Payslip Approved Successfully');
		}else{
			$this->session->set_flashdata('msg', 'Payslip Approval Failed. Please Try Again');
		}
		return redirect('payslip/index', 'refresh');
	}
	public function writePDF($filename, $pageNo, $target_dir){
		$_pdf = $this->pdfparser_lib->getFPDI();
		$_pdf->setSourceFile($filename);
		$page = $_pdf->importPage($pageNo);
		$_pdf->addPage();
		$_pdf->useTemplate($page);
		//$_pdf->SetFont('Times','B', 9);
		//$_pdf->Ln(8);
		//$_pdf->SetXY(10.9, 268);
		//$_pdf->Write(5, 'Prepared by MIS-FUBK');
		$output = $target_dir.hash('sha512', $filename.$pageNo.rand().date('YmdHis')).".pdf";
		$_pdf->Output($output, 'F');
		return $output;
	}
	public function getPDFs($filename){
		$pdfs = $this->pdfparser_lib->initializeSplitter();
		$pageCount = $pdfs->setSourceFile($filename);
        return $pageCount;
	}
	public function getText($filename){
		$parser = $this->pdfparser_lib->initializeParser();
		$slip = $parser->parseFile($filename);
        return trim($slip->getPages()[0]->getText());
	}
	public function getStudentInfo($content, $slipfile, $folder,$semester,$session){
		$begin = stripos($content, "STUDENT ID") + 11;
		$end = stripos($content, "LEVEL");
		$pnumber = trim(substr($content, $begin, $end - $begin));
		$begin = $end + 5;
		$end = stripos($content, "FULL");
		$level = trim(substr($content, $begin, $end - $begin));
		$data = [
			'studentid' => $pnumber,
			'level' => $level,
			'semester' => $semester,
            'session' => $session,
			'folder' => $folder,
			'filename' => substr($slipfile, strrpos($slipfile, "/")+1)
		];
		return $data;
	}
	public function uploadpdf(){
        $semester = explode(" ",$this->input->post('session')); 
        if(!isset($_FILES['file']['name'])){
            $this->session->set_flashdata('msg', 'Please Select the Result File to upload');
            redirect('result/pdf', 'refresh');
        }
        $param = [
            'semester' => $semester[0],
            'session' => $semester[2],
            'folder' => $semester[0]."_".str_replace("/", "", $semester[2]),
            'hash' => hash('sha512', date('YmdHis').rand())
		];
		//var_dump($param);
        $target_dir = "./results/".$param['folder']."/";
		if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        }
		//clear the directory
		//foreach(glob($target_dir . '/*') as $file) @unlink($file);
        $config = array(
            'upload_path' => $target_dir,
            'allowed_types' => 'pdf',
            'encrypt_name' => TRUE,
            'filename' => time().$_FILES["file"]['name']
        );
        $this->upload->initialize($config);
        if ($this->upload->do_upload('file')) {
            $data = [];
            $num = 0; $total = 0; 
            $info = $this->upload->data();
            $filename = $info['full_path'];
            $num_pages = $this->getPDFs($filename);
    		for($pageNo = 1; $pageNo <= $num_pages; $pageNo++){
    			$slipfile = $this->writePDF($filename, $pageNo, $target_dir);
    			$content = $this->getText($slipfile);
    			if(strlen($content) > 100){
    				$data[] = $this->getStudentInfo($content, $slipfile, $param['folder'], $param['semester'], $param['session']);
    				$num++;
    				
    			}
    			//var_dump($data); die;
    			$total++;
    		}   		
            if($this->Result_model->saveResultSlips($data)){
                $this->session->set_flashdata('msg', 'Upload completed. A total of '.$num.' out of '.$total.' Results were processed');
            }else{
                $this->session->set_flashdata('msg', '<p>Upload Failed. Please try again');
            }
        } else {
            $this->session->set_flashdata('msg', $this->upload->display_errors());
        }
        redirect('result/pdf', 'refresh');
    }
}
