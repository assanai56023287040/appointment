<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Patient extends CI_Controller {

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
	public function index()
	{
		$this->load->view('patient/p1');
	}

	function emSignin(){
		$uid = $this->input->get('uid');
		$pwd = $this->input->get('pwd');

		$this->db->where('userid',$uid)
				->where('password',$pwd)
				->where('active <>','I');
		$qres = $this->db->get('user');
		$cnt = $qres->num_rows();
		if($cnt == 1){
			$res = array(
				'success' => true
				,'code' => 'pass'
				,'row' => $qres->result_array()
			);
		}else if($cnt > 1){
			$res = array(
				'success' => false
				,'code' => 'moreOne'
			);
		}else{
			$res = array(
				'success' => false
				,'code' => 'notPass'
			);
		}

		echo json_encode($res);
	}
}
