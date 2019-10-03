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
								,'tel' => $this->input->post('tel')
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


	function usersstatusload(){

		$st = $this->db->order_by('ustid','asc')->get('userst');

		if($st->num_rows() > 0){ //$res->MessageCode == 200
			echo json_encode(array(
					'success' => true
					,'row' => $st->result_array()
				));
		}else{
			echo json_encode(array(
					'success' => false
				));
		}

	}

	function usersload(){
		$kw = $this->input->get('kw');
		$st = $this->input->get('st');
		$fdate = $this->input->get('fdate');
		$tdate = $this->input->get('tdate');

		$this->db->select("u.usid
						,u.username
						,u.staffcode
						,u.staffname
						,u.tel
						,u.updateby
						,u.updatedt
						,u.approveby
						,u.approvedt
						,u.lastlogin
						,s.stname",false)
				->from('user u')
				->join('userst s','u.ustid = s.ustid','left')
				->where('u.active <> ','I');

		if(!empty($kw)){
			$this->db->where("CONCAT(IFNULL(u.username,'')
								,IFNULL(u.staffcode,'')
								,IFNULL(u.staffname,'')
								,IFNULL(u.tel,'')
								,IFNULL(s.stname,'')
							) LIKE '%{$kw}%'");
		}

		if(!empty($fdate) && !empty($tdate)){
			$this->db->where("(DATE(u.updatedt) BETWEEN '{$fdate}' AND '{$tdate}' OR DATE(u.approvedt) BETWEEN '{$fdate}' AND '{$tdate}')");
		}else if(!empty($fdate) && empty($tdate)){
			$this->db->where("(DATE(u.updatedt) OR DATE(u.approvedt)= '{$fdate}')");
		}else if(empty($fdate) && !empty($tdate)){
			$this->db->where("(DATE(u.updatedt) OR DATE(u.approvedt)= '{$tdate}')");
		}

		if(!empty($st)){
			$this->db->where('u.ustid',$st);
		}
		$this->db->order_by('u.ustid','asc');

		$res = $this->db->get();

		log_info($this->db->last_query());

		$res = $res->result_array();

		echo json_encode(array(
			'success' => true
			,'row' => $res
		));
	}

	function userload(){
		$usid = $this->input->get('usid');

		$this->db->where('usid',$usid)
				->where('active <>','I');
		$res = $this->db->get('user');

		echo json_encode(array(
			'success' => true
			,'row' => $res->first_row()
		));
	}

	function saveedituser(){
		$usid = $this->input->post('usid');
		$staffcode = $this->input->post('staffcode');
		$ustid = $this->input->post('ustid');
		$updateby = $this->input->post('updateby');

		$this->db->set('ustid',$ustid)
				->set('updateby',$updateby)
				->set('updatedt',date('Y-m-d H:i:s'));
		if($ustid == '02'){
			$this->db->set('approveby',$updateby)
					->set('approvedt',date('Y-m-d H:i:s'));
		}
		$this->db->where('usid',$usid)
				->where('staffcode',$staffcode)
				->update('user');

		echo json_encode(array(
			'success' => true
		));
	}

	function tuhdbtest(){
		$otherdb = $this->load->database('tuhdb', TRUE);
		$p = $otherdb->get('prscst');

		var_dump($p); 
	}

	function swapi(){
		$options = array(
	        'soap_version'=>SOAP_1_2,
	        'exceptions'=>true,
	        'trace'=>1,
	        'cache_wsdl'=>WSDL_CACHE_NONE
	    );

	    $client = new SoapClient(TUH_SW_API_LOCAL,$options);

	    $params = array('hn' => 1621101);

	    $data = $client->dtApmLoadByHN($params)->dtApmLoadByHNResult;
		echo $data;
	}

}
