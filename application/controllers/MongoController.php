<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use MongoDB\Driver\Query;
use MongoDB\Driver\Exception\Exception;
class MongoController extends CI_Controller {
	
	public function __construct(){
		parent::__construct();
		$this->load->library('mongodb_lib');
	}

	public function mongo(){
		$mongo = $this->mongodb_lib->initialize();
		//$query = new Query(["username" => 'garbai',"password"=>"garbai"]);
		$query = new Query([]);
		$result = $mongo->executeQuery('sims.users', $query);
		$data = [
			'result' => $result->toArray()
		];
		return $this->load->view('mongo', $data);
	}
}
