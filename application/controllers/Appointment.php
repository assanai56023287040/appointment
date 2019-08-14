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
			,'isseldct' => $this->input->post('isseldct')
			,'apmdct' => $this->input->post('apmdct')
			,'lcttype' => $this->input->post('lcttype')
			,'apmlct' => $this->input->post('apmlct')
			,'lctname' => $this->input->post('lctname')
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

	function loadchat(){
		$apmid = $this->input->get('apmid');
		$offset = $this->input->get('offset');
		$nowside = $this->input->get('nowside');

		$sql = "
			SELECT * 
			FROM (
				SELECT a.msgid
					,a.msgtxt
					,a.fromside AS side
					,a.msgdate
					,a.msgtime
				FROM apmchat a 
				WHERE a.apmid = {$apmid}
				ORDER BY a.msgid DESC
				LIMIT {$offset} ,30
			) AS s
			ORDER BY s.msgid ASC
		";

		$res = $this->db->query($sql);

		$this->db->set('msgst','r')
				->where('apmid',$apmid)
				->where('toside',$nowside)
				->where('msgst','u')
				->update('apmchat');

		$this->db->where('apmid',$apmid)
				->where('toside',$nowside)
				->delete('newchat');

		if($res->num_rows() > 0){
			echo json_encode(array(
					'success' => true,
					'cnt' => $res->num_rows(),
					'msg' => $res->result_array(),
			));
		}else{
			echo json_encode(array(
					'success' => true,
					'cnt' => 0,
					'msg' => [],
			));
		}
	}

	function inquirychat(){
		$apmid = $this->input->get('apmid');
		$nowside = $this->input->get('nowside');

		$this->db->where('apmid',$apmid)
				->where('toside',$nowside)
				->select("
					msgid
					,msgtxt
					,fromside AS side
					,msgdate
					,msgtime
					",false);
		$res = $this->db->get('newchat');

		$this->db->where('apmid',$apmid)
				->where('toside',$nowside)
				->delete('newchat');

		if($res->num_rows() > 0){
			echo json_encode(array(
					'success' => true,
					'cnt' => $res->num_rows(),
					'msg' => $res->result_array(),
			));
		}else{
			echo json_encode(array(
					'success' => true,
					'cnt' => 0,
					'msg' => [],
			));
		}

	}

	function lctload(){
		
		$response = Requests::get(TUH_API.'Department?cliniclct=' ,array());

		$res = json_decode($response->body);
		$r = json_decode($res->Result);

		if($res->MessageCode == 200){
			echo json_encode(array(
					'success' => true
					,'code' => 'pass'
					,'row' => $r
				));
		}else{
			echo json_encode(array(
					'success' => false
					,'code' => 'notPass'
				));
		}

	}
}
