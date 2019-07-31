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

	function register(){
		$idcard = $this->input->get('idcard');

		$response = Requests::get(TUH_API.'Patient?cardno='.$idcard.'&notype=10' ,array() ,array());

		$res = json_decode($response->body);
		$r = json_decode($res->Result)[0];

		if($res->MessageCode == 200){
			$ptid = $this->integrate($idcard ,$r);
			echo json_encode(
				array(
					'success' => true
					,'code' => 'pass'
					,'row' => $r
					,'ptid' => $ptid
				));
		}else{
			echo json_encode(
				array(
					'success' => false
					,'code' => 'notPass'
				));
		}
	}

	function integrate($idcard , $data){
		// $idcard = $this->input->post('idcard');
		// $data = json_decode($this->input->post('patientdata'));
		log_info('test log message abababab');

		$this->db->where('cardno',$idcard)->where('active <> ','I');
		$ex = $this->db->get('pt');

		$patientdata = array(
				'hn' => $data->HN
				,'an' => $data->AN
				,'fname' => $data->FNAME
				,'lname' => $data->LNAME
				,'birthdate' => $data->BIRTHDATE
				// ,'cardno' => $data->cardno
				,'notype' => $data->NOTYPE
				,'male' => $data->MALE
				,'sex' => $data->SEX
				,'allergy' => $data->ALLERGY
				,'congenital' => $data->CONGENITAL
				,'insurance_code' => $data->INSURANCE_CODE
				,'insurance_name' => $data->INSURANCE_NAME
				,'lastdatetime' => date("Y-m-d H:i:s")
			);

		if($ex->num_rows() == 0){
			$this->db->set('cardno',$data->CARDNO);
			$this->db->insert('pt',$patientdata);
			$id = $this->db->insert_id();
		}else{
			$this->db->where('cardno',$data->CARDNO);
			$this->db->update('pt',$patientdata);
			$id = $ex->row()->ptid;
		}

		$this->db->insert('ptlogin',array(
			'ptid' => $id
			,'cardno' => $idcard
			,'logindatetime' => date("Y-m-d H:i:s")
		));

		// $params = array('ptid' => $id);

		// $this->load->view('patient/p1',$params);
		return $id;
	}

	function listpage(){
		$this->load->view('patient/p1');
	}

	function date_formysql($date){
		if(!empty($date)){
			$date = explode('/', $date);
			return ($date[2]-543).'-'.$date[1].'-'.$date[0];
		}else{
			return '';
		}
		
	}

	function newapm(){

		$this->db->insert('apmpt',array(
			'header' => $this->input->post('header')
			,'apmdate' =>$this->input->post('apmdate')
			,'sicktxt' => $this->input->post('sicktxt')
			,'tel' => $this->input->post('tel')
			,'stid' => $this->input->post('stid')
			,'ptid' => $this->input->post('ptid')
			,'hn' => $this->input->post('hn')
			,'chcnt' => 1
			,'active' => 'A'
			,'credt' => date("Y-m-d H:i:s")
		));

		$id = $this->db->insert_id();

		echo json_encode(array(
			'success' => true
			,'apmid' => $id
		));
	}

	function listload(){

		$ptid = $this->input->post('ptid');
		$keyword = $this->input->post('keyword');
		$fdate = $this->input->post('fdate');
		$tdate = $this->input->post('tdate');

		$this->db->select("a.apmid
						,a.apmdate
						,a.tel
						,a.stid
						,a.ptid
						,a.hn
						,a.newcnt
						,a.credt
						,a.updt
						,a.header
						,a.sicktxt
						,p.fname
						,p.lname
						,s.stname
					",false)
				->from('apmpt a')
				->join('pt p','a.ptid = p.ptid','left')
				->join('st s','s.stid = a.stid','left')
				->where('a.ptid',$ptid)
				->where('a.active <> ','I');

		if(!empty($keyword)){
			$this->db->where("CONCAT(IFNULL(a.header,'')
								,IFNULL(a.sicktxt,'')
							) LIKE '%{$keyword}%'");
		}

		if(!empty($fdate) && !empty($tdate)){
			$this->db->where("apmdate BETWEEN '{$fdate}' AND '{$tdate}'");
		}else if(!empty($fdate) && empty($tdate)){
			$this->db->where('apmdate = {$fdate}');
		}else if(empty($fdate) && !empty($tdate)){
			$this->db->where('apmdate = {$tdate}');
		}

		$res = $this->db->get();

		log_info($this->db->last_query());

		$res = $res->result_array();
		// $res1 = $res;
		// for ($i=0; $i < 6; $i++) { 
		// 	array_push($res,$res1[0]);
		// }

		echo json_encode(array(
			'success' => true
			,'row' => $res
		));
	}
}
