<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Lib  {

	public function __construct(){
		log_message('Debug', 'PHPMailer loaded successfully');
	}

	public function initialize(){
		require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
		require_once APPPATH.'third_party/PHPMailer/Exception.php';
		require_once APPPATH.'third_party/PHPMailer/SMTP.php';

		$mail = new PHPMailer(true);
		$mail->isSMTP(); 
		$mail->Host       = 'smtp.gmail.com';
		$mail->SMTPAuth   = true;
		$mail->Username   = 'noreply@fubk.edu.ng'; 
		$mail->Password   = 'noreply123456*';
		$mail->SMTPSecure = 'tls';
		$mail->Port       = 587;
		$mail->isHTML(true);                                      

		return $mail;
	}
}
