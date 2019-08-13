<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Appointment extends CI_Controller {

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

	function newapm(){

		$this->db->insert('apmpt',array(
			'header' => $this->input->post('header')
			,'apmdate' =>$this->input->post('apmdate')
			,'apmtime' =>$this->input->post('apmtime')
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
						,a.apmtime
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
		$this->db->order_by('apmdate','desc');

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

	function apmload(){
		$apmid = $this->input->get('apmid');

		$this->db->where('apmid',$apmid)
				->where('active <>','I');
		$res = $this->db->get('apmpt');

		echo json_encode(array(
			'success' => true
			,'row' => $res->result_array()
		));
	}

	function createmsg(){
		$msgdata = array(
			'apmid' => $this->input->post('apmid'), 
			'msgtxt' => $this->input->post('msgtxt'), 
			'fromside' => ($this->input->post('side') == 'p'? 'p':'a'),
			'toside' => ($this->input->post('side') == 'p'? 'a':'p'),
			'msgdate' => $this->input->post('msgdate'),
			'msgtime' => $this->input->post('msgtime'),
			'credt' => date("Y-m-d H:i:s"),
		);

		$this->db->insert('apmchat',$msgdata);
		$id = $this->db->insert_id();

		$this->db->set('msgid',$id);
		$this->db->insert('newchat',$msgdata);

		echo json_encode(array(
			'success' => true,
			'msgid' => $id,
		));
	}
}
