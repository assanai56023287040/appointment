<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Admin extends CI_Controller {

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
		$this->load->view('admin/a1'); 
	}

	function newuserregister(){
		$ex = $this->db->get_where('user',array(
											'staffcode' => $this->input->post('staffcode')
											,'active' => 'A'
											,'ustid' => '01'
										));
		if($ex->num_rows() == 1){
			echo json_encode(array(
								'success' => false
								,'errcode' => 'new_staff_exist'
							));
		}else{
			$this->db->insert('user',array(
								'username' => $this->input->post('username')	
								,'password' => $this->input->post('password')
								,'staffcode' => $this->input->post('staffcode')
								,'staffname' => $this->input->post('staffname')
								,'ustid' => '01'
								,'active' => 'A'
								,'lastlogin' => date("Y-m-d H:i:s")
							));
			echo json_encode(
				array(
					'success' => true
				));
		}	
	}

}
