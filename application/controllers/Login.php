<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct(){
		parent::__construct();
		// $this->load->library('PHPRequests');
	}

	public function index()
	{
		$this->load->view('login/l1');
	}

	function emSignin(){
		$uid = $this->input->get('uid');
		$pwd = $this->input->get('pwd');

		$this->db->where('userid',$uid)
				->where('password',$pwd)
				->where('active <>','I');
		$qres = $this->db->get('user');
		$cnt = $qres->num_rows();

		
		$response = Requests::get(TUH_API.'Login?user='.$uid.'&password='.$pwd ,array() ,array());

		$res = json_decode($response->body);
		$r = json_decode($res->Result)[0];

		if($res->MessageCode == 200){
			echo json_encode(
				array(
					'success' => true
					,'code' => 'pass'
					,'row' => $r
				));
		}else{
			echo json_encode(
				array(
					'success' => false
					,'code' => 'notPass'
				));
		}

	}

	function logintest(){
		// $header = array('Accept' => 'application/json');
		// $option = array('user' => 'assanai'
		// 					,'password' => '0853709109'
		// 					// ,'verify' => false
		// 				);
		$response = Requests::get(TUH_API.'Login?user=assanai&password=0853709109' ,array() ,array());

		$res = json_decode($response->body);
		$r = json_decode($res->Result)[0];


		print_r($res);
		echo '<br/>';
		print_r($r);
		echo '<br/>msg code => '.$res->MessageCode;
		echo '<br/> Staff Code => '.$r->STAFF_CODE;
		echo '<br/> Staff Name => '.$r->STAFF_NAME;
	}

		function patienttest(){
		// $header = array('Accept' => 'application/json');
		// $option = array('user' => 'assanai'
		// 					,'password' => '0853709109'
		// 					// ,'verify' => false
		// 				);
		$response = Requests::get(TUH_API.'Patient?cardno=1100600311926&notype=10' ,array() ,array());
		// $response = Requests::get(TUH_API.'Patient?cardno=1749900106140&notype=10' ,array() ,array());

		$res = json_decode($response->body);
		$r = json_decode($res->Result)[0];


		print_r($res);
		echo '<br/><br/>';
		print_r($r);
		echo '<br/>msg code => '.$res->MessageCode;
		// echo '<br/> Staff Code => '.$r->STAFF_CODE;
		// echo '<br/> Staff Name => '.$r->STAFF_NAME;
	}


}
