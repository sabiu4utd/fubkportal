<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payslip extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
		$this->load->model('Payslips_model');
		$this->load->library('PDFParser_Lib');
	}

	public function index(){
		$_SESSION['pageTitle'] = 'Payslips Welcome .::. University Portal';
		$data = [
			'payslips' => $this->Payslips_model->getPayslips()
		];
		
		return $this->load->view('payslips/index', $data);
	}

	public function myslips(){
		$data = [
			'payslips' => $this->Payslips_model->getMySlips()
		];
		return $this->load->view('payslips/slips', $data);
	}

	public function slips(){
		$hash = $this->uri->segment(3) ? $this->uri->segment(3) : false;
		if(!$hash) redirect('payslip', 'refresh');

		$data = [
			'slips' => $this->Payslips_model->getSlips($hash)
		];
		return $this->load->view('payslips/allslips', $data);
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

	public function disapprovePayslip(){
		$hash = $this->uri->segment(3) ? $this->uri->segment(3) : false;
		if(!$hash) redirect('payslip', 'refresh');

		if($this->Payslips_model->disapprovePayslip($hash)){
			$this->session->set_flashdata('msg', 'Payslip Disapproved Successfully');
		}else{
			$this->session->set_flashdata('msg', 'Payslip Disapproval Failed. Please Try Again');
		}
		
		return redirect('payslip/index', 'refresh');
	}

	public function deletePayslip(){
		$hash = $this->uri->segment(3) ? $this->uri->segment(3) : false;
		if(!$hash) redirect('payslip', 'refresh');

		if($this->Payslips_model->deletePayslip($hash)){
			$this->session->set_flashdata('msg', 'Payslip Deleted Successfully');
		}else{
			$this->session->set_flashdata('msg', 'Payslip Deletion Failed. Please Try Again');
		}
		
		return redirect('payslip/index', 'refresh');
	}
	
	public function writePDF($filename, $pageNo, $target_dir){
		$_pdf = $this->pdfparser_lib->getFPDI();
		$_pdf->setSourceFile($filename);
		$page = $_pdf->importPage($pageNo);
		
		$_pdf->addPage();
		$_pdf->useTemplate($page);
		$_pdf->SetFont('Times','B', 9);
		//$_pdf->SetXY(161, 260);
		//$_pdf->Write(5, 'Prepared by MIS-FUBK');
		$_pdf->Ln(8);
		$_pdf->SetXY(8.9, 268);
		$_pdf->Write(5, 'Prepared by MIS-FUBK');
		//$_pdf->Write(3.5, 'If you have any questions or need further clarifications, please contact the Bursary department on +234(0)8175042173, +234(0)8034309138, +234(0)8080352522, +234(0)8065519260 or email payslip@fubk.edu.ng');

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

    public function getEmployeeInfo($content, $slipid, $slipfile, $month, $year){

        $begin = stripos($content, "ACCTNO")+ 19;
		$end = stripos($content, "Legal ID:");
		$ippis_no = trim(substr($content, $begin, $end - $begin));
    
        // Extract Staff ID
        $begin = stripos($content, "Legal ID:") + strlen("Legal ID:");
        $end = stripos($content, "FEDERAL UNIVERSITY BIRNIN KEBBI:");
        $staffid = trim(substr($content, $begin, $end - $begin));
    
        // Prepare the data array
        $data = [
            'month' => $month,
            'year' => $year,
            'ippis_no' => $ippis_no,
            'staff_id' => $staffid,
            'payslip_id' => $slipid,
            'filename' => substr($slipfile, strrpos($slipfile, "/") + 1),
            'slip_unixdate' => strtotime($month . ' ' . $year),
            'slip_hash' => hash('sha512', $slipfile . rand() . date('YmdHis'))
        ];
    
        return $data;
    }


// 	public function getEmployeeInfoIPPIS($content, $slipid, $slipfile){
		
// 		$begin = stripos($content, "EMPLOYEE PAYSLIP") + 16;
// 		$end = stripos($content, "Employee Name:");
// 		$data = explode(" ", trim(substr($content, $begin, $end - $begin)));
// 		$month = trim($data[0]);
// 		$year = trim($data[1]);

// 		$begin = stripos($content, "IPPIS Number:");
// 		$end = stripos($content, "Step:");
// 		$data = explode(":", trim(substr($content, $begin, $end - $begin)));
// 		$ippis_no = isset($data[1]) ? trim($data[1]) : "";
		
// 		$begin = stripos($content, "Staff ID:");
// 		$end = stripos($content, "Step:");
// 		$data = explode(":", trim(substr($content, $begin, $end - $begin)));
// 		$staffid = isset($data[1]) ? trim($data[1]) : "";
		
// 		$begin = stripos($content, "Legacy ID:");
// 		$end = stripos($content, "Gender:");
// 		$data = explode(":", trim(substr($content, $begin, $end - $begin)));
// 		$staffid_ = isset($data[1]) ? trim($data[1]) : "";
// 		$staffid = (substr($staffid_, 0, 2) == 'SP' || substr($staffid_, 0, 2) == 'JP') ? $staffid_ : $staffid;
		
// 		$ippis_no = substr($ippis_no, 0, 1) == 'T' ? $ippis_no : $staffid;

// 		$data = [
// 			'month' => $month,
// 			'year' => $year,
// 			//'staffid' => $staffid,
// 			'ippis_no' => $ippis_no,
// 			'payslip_id' => $slipid,
// 			'filename' => substr($slipfile, strrpos($slipfile, "/")+1),
// 			'slip_unixdate' => strtotime($month.' '.$year),
// 			'slip_hash' => hash('sha512', $slipfile.rand().date('YmdHis'))
// 		];
// 		echo $data; die;

// 		return $data;
// 	}
	
	public function upload(){

        $month = $this->input->post('month');  
        $year = $this->input->post('year');  
        
        if(!isset($_FILES["file"]['name'])){
            $this->session->set_flashdata('msg', 'Please Select the Payslip File to upload');
            redirect('payslip/index', 'refresh');
        }

        $data = array(
            'reference' => 'PAYSLIP_'.$month.'_'.$year,
            'description' => 'Payslip for the '.$month.', '.$year,
            'month' => $month,
            'year' => $year,
            'folder' => $month.$year,
            'unix_date' => strtotime($month.' '.$year),
            'generated_by' => $this->session->userdata('userid'),
            'hash' => hash('sha512', date('YmdHis').rand())
        );

        $target_dir = "./payslips/".$data['month'].$data['year']."/";
        
        if(!file_exists($target_dir)){
            mkdir($target_dir,0777);
        }
        $config = array(
            'upload_path' => $target_dir,
            'allowed_types' => 'pdf',
            'encrypt_name' => TRUE,
            'filename' => time().$_FILES["file"]['name']
        );

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $slipid = $this->Payslips_model->savePaySlip($data);
            if(!$slipid){
                $this->session->set_flashdata('msg', '<p>Upload FAILED</p><p>An error occured, please try again</p>');
                redirect('payslip', 'refresh');
            }
            $slips = array();

            $info = $this->upload->data();
            
            $filename = $info['full_path'];
            $num = 0; $total = 0; $data = [];
            
            $num_pages = $this->getPDFs($filename);
    		for($pageNo = 1; $pageNo <= $num_pages; $pageNo++){
    
    			$slipfile = $this->writePDF($filename, $pageNo, $target_dir);
    			$content = $this->getText($slipfile); 
    			if(strlen($content) > 100){
    				// $data[] = $this->getEmployeeInfoIPPIS($content, $slipid, $slipfile);
    				$data[] = $this->getEmployeeInfo($content, $slipid, $slipfile, $month, $year);
    				$num++;
    			}
    			$total++;
    		}
            if($this->Payslips_model->saveSlips($data)){
                $this->session->set_flashdata('msg', 'Upload completed. A total of '.$num.' out of '.$total.' payslips were processed');
            }else{
                $this->session->set_flashdata('msg', '<p>Upload Failed. Please try again');
            }
            
        } else {
            $this->session->set_flashdata('msg', $this->upload->display_errors());
        }
        redirect('payslip/index', 'refresh');

    }
}
