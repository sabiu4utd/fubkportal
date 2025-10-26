<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		//$this->load->model(['auth_model', 'payment_model']);
	}

	public function getNews()
	{
	    $news = [
	        ["date" => "2022-02-02", "news_header"=> "FUBK gets a new VC", "news_body"=> "", "news_status"=>"published", "news_author"=>"Jamilu Magaji"],
	        ["date" => "2022-02-02", "news_header"=> "UG Admission List is Out!!!", "news_body"=> "", "news_status"=>"published", "news_author"=>"Jamilu Magaji"],
	        ["date" => "2022-02-02", "news_header"=> "PG Admission List Released", "news_body"=> "", "news_status"=>"published", "news_author"=>"Jamilu Magaji"]
	    ];
		echo json_encode($news);
	}


}
