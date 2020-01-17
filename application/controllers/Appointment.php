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
			,'lcttype' => $this->input->post('lcttype')
			,'apmlct' => $this->input->post('apmlct')
			,'lctname' => $this->input->post('lctname')
			,'isseldct' => $this->input->post('isseldct')
			,'apmdct' => $this->input->post('apmdct')
			,'dctname' => $this->input->post('dctname')
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


	function editapm(){
		$apmid = $this->input->post('apmid');

		$this->db->where('apmid',$apmid)
				->where('active <>','I')
				->where('stid <>','03');

		$this->db->update('apmpt',array(
			'header' => $this->input->post('header')
			,'apmdate' =>$this->input->post('apmdate')
			,'apmtime' =>$this->input->post('apmtime')
			,'sicktxt' => $this->input->post('sicktxt')
			,'tel' => $this->input->post('tel')
			,'lcttype' => $this->input->post('lcttype')
			,'apmlct' => $this->input->post('apmlct')
			,'lctname' => $this->input->post('lctname')
			,'isseldct' => $this->input->post('isseldct')
			,'apmdct' => $this->input->post('apmdct')
			,'dctname' => $this->input->post('dctname')
			,'credt' => date("Y-m-d H:i:s")
		));

		echo json_encode(array(
			'success' => true
			,'apmid' => $apmid
		));
	}
	function listload(){

		$ptid = $this->input->get('ptid');
		$keyword = $this->input->get('keyword');
		$fdate = $this->input->get('fdate');
		$tdate = $this->input->get('tdate');

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
						,0 AS firecnt
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
			$this->db->where('apmdate',$fdate);
		}else if(empty($fdate) && !empty($tdate)){
			$this->db->where('apmdate' ,$tdate);
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
			,'row' => $res->first_row()
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
			'creby' => $this->input->post('creby'),
			'msgcl' => $this->input->post('msgcl'),
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

		if($nowside == 'a'){
			$this->setadminread($apmid);
		}

		$sql = "
			SELECT * 
			FROM (
				SELECT a.msgid
					,a.msgtxt
					,a.fromside AS side
					,a.msgdate
					,a.msgtime
					,a.creby
					,u.staffname AS crebyname
					,a.msgcl
				FROM apmchat a 
				LEFT JOIN user u ON a.creby = u.staffcode
				WHERE a.apmid = {$apmid}
				ORDER BY a.msgid DESC
				
			) AS s
			ORDER BY s.msgid ASC
		";
		// LIMIT {$offset} ,30

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

		$this->db->where('a.apmid',$apmid)
				->where('a.toside',$nowside)
				->select("
					a.msgid
					,a.msgtxt
					,a.fromside AS side
					,a.msgdate
					,a.msgtime
					,a.creby
					,u.staffname AS crebyname
					,a.msgcl
					",false)
				->from('newchat a')
				->join('user u','a.creby = u.staffcode','left');
		$res = $this->db->get();

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

	function lctupdate(){
		$response = Requests::get(TUH_API.'Department?cliniclct=' ,array());

		$res = json_decode($response->body);
		$r = json_decode($res->Result);

		$this->db->where('lctcode <>','')->delete('lct');

		foreach ($r as $k => $v) {
			$this->db->insert('lct', array(
				'lctcode' => $v->UNIT_CODE, 
				'lctname' => $v->UNIT_NAME, 
			));
		}

	}

	function lctload(){
		$date = date("Y-m-d");
		$ex = $this->db->query("
					SELECT CASE WHEN date(l.dt) = date('{$date}') 
								THEN 1
								ELSE 0 END AS exist
					FROM lct l
					LIMIT 1
			");

		if($ex->row()->exist == 0){
			$this->lctupdate();
		}

		$lct = $this->db->order_by('lctcode','asc')->get('lct');

		if($lct->num_rows() > 0){ //$res->MessageCode == 200
			echo json_encode(array(
					'success' => true
					,'code' => 'pass'
					,'row' => $lct->result_array()
				));
		}else{
			echo json_encode(array(
					'success' => false
					,'code' => 'notPass'
				));
		}

	}

	function apmsload(){
		$kw = $this->input->get('kw');
		$st = $this->input->get('st');
		$fdate = $this->input->get('fdate');
		$tdate = $this->input->get('tdate');

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
						,0 AS firecnt
					",false)
				->from('apmpt a')
				->join('pt p','a.ptid = p.ptid','left')
				->join('st s','s.stid = a.stid','left')
				// ->where('a.ptid',$ptid)
				->where('a.active <> ','I');

		if(!empty($kw)){
			$this->db->where("CONCAT(IFNULL(a.header,'')
								,IFNULL(a.sicktxt,'')
								,IFNULL(p.hn,'')
								,IFNULL(p.fname,'')
								,IFNULL(p.lname,'')
								,IFNULL(s.stname,'')
								,IFNULL(a.tel,'')
							) LIKE '%{$kw}%'");
		}

		if(!empty($fdate) && !empty($tdate)){
			$this->db->where("apmdate BETWEEN '{$fdate}' AND '{$tdate}'");
		}else if(!empty($fdate) && empty($tdate)){
			$this->db->where('apmdate',$fdate);
		}else if(empty($fdate) && !empty($tdate)){
			$this->db->where('apmdate',$tdate);
		}

		if(!empty($st)){
			$this->db->where('a.stid',$st);
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

	function statusload(){

		$st = $this->db->order_by('stid','asc')->get('st');

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

	function setadminread($apmid){
		$apm = $this->db->get_where('apmpt',array('apmid' => $apmid));
		if($apm->row()->stid == '01'){
			$this->db->where('apmid',$apmid)
					->where('stid','01')
					->set('stid','02')
					->update('apmpt');
		}
		
	}

	function loadoapplist(){
		$hn = $this->input->get('hn');

		$client = new SoapClient(TUH_SW_API,TUH_SW_API_OPTION);

	    $params = array('hn' => $hn);

	    $data = $client->dtApmLoadByHN($params)->dtApmLoadByHNResult;

	    $res = json_decode($data);

	    if(count($res) > 0){
	    	$arr = $this->oappfilter($hn ,$res);
	    	if(count($arr) > 0){
				echo json_encode(array(
		    		'success' => true
		    		,'row' => $arr
		    		,'data' => $res
		    	));
	    	}else{
	    		echo json_encode(array(
		    		'success' => false
		    	));
	    	}
	    	
	    }else{
	    	echo json_encode(array(
	    		'success' => false
	    	));
	    }
	}

	function confirmapm(){
		$hn = $this->input->post('hn');
		$oappdate = $this->input->post('oappdate');
		$oapptime = $this->input->post('oapptime');
		$itemno = $this->input->post('itemno');
		$apmid = $this->input->post('apmid');
		$cfdate = $this->input->post('cfdate');
		$cftime = $this->input->post('cftime');
		$cfby = $this->input->post('cfby');

		$oappdate = substr($oappdate ,0 ,10);

		$client = new SoapClient(TUH_SW_API,TUH_SW_API_OPTION);

	    $params = array('hn' => $hn
    					,'oappdate' => $oappdate
    					,'oapptime' => $oapptime
    					,'itemno' => $itemno
					);

	    $data = $client->dtApmLoadDetail($params)->dtApmLoadDetailResult;

	    $res = json_decode($data);

	    if(count($res) > 0){
	    	//update apmpt for change status
			$this->db->where('apmid',$apmid)
	    		->where('active <>','I')
	    		->set('stid','03')
	    		->set('cfby',$cfby)
	    		->set('cfdate',$cfdate)
	    		->set('cftime',$cftime)
	    		->update('apmpt');


	    	$this->db->set('apmid',$apmid);
	    	$this->db->insert('oapp',$res[0]);

	    	echo json_encode(array(
    			'success' => true,
    			'data' => $res
	    	));
	    }else{
	    	echo json_encode(array(
    			'success' => false,
	    	));
	    }  
	}

	function oappfilter($hn , $arr){
		$i = 0;
		$unset = array();
		foreach ($arr as $k) {
			$r = $this->db->get_where('oapp',array('hn' => $hn
												,'oappdate' => $k->OAPPDATE
												,'oapptime' => $k->OAPPTIME
												,'itemno' => $k->ITEMNO
										));
			if($r->num_rows() > 0){
				array_push($unset, $i);	
			}
			$i++;
		}

		foreach ($unset as $k => $v) {
			unset($arr[$v]);
		}

		return $arr;
	}

	function loadlctbydct(){
		$dct = $this->input->get('dct');

		$client = new SoapClient(TUH_SW_API,TUH_SW_API_OPTION);

	    $params = array('dct' => $dct);

	    $data = $client->dtLCTScheduleByDCT($params)->dtLCTScheduleByDCTResult;

		// $data = '[ { "LCT": 200, "NAME": "ศัลยกรรม" }, { "LCT": 2800, "NAME": "พิเศษเฉพาะทาง" }, { "LCT": 5040, "NAME": "ส่องกล้อง" } ]';
	    $res = json_decode($data);

	    if(count($res) > 0){
			echo json_encode(array(
	    		'success' => true
	    		,'row' => $res
	    	));
	    }else{
	    	echo json_encode(array(
	    		'success' => false
	    	));
	    }

	}

	function loaddctbylct(){
		$client = new SoapClient(TUH_SW_API,TUH_SW_API_OPTION);

	    $params = array('lct' => $this->input->get('lct'));

	    $data = $client->dtDCTScheduleByLCT($params)->dtDCTScheduleByLCTResult;

	    $res = json_decode($data);

		if(count($res) > 0){
			echo json_encode(array(
	    		'success' => true
	    		,'row' => $res
	    	));
	    }else{
	    	echo json_encode(array(
	    		'success' => false
	    	));
	    }

	}

	function dctupdate(){
		$client = new SoapClient(TUH_SW_API,TUH_SW_API_OPTION);

	    $data = $client->dtDCTinSchedule()->dtDCTinScheduleResult;

	    $res = json_decode($data);

		$this->db->where('dctcode <>','')->delete('dct');

		foreach ($res as $k => $v) {
			$this->db->insert('dct', array(
				'dctcode' => $v->DCT,
				'dctname' => $v->NAME,
			));
		}

	}

	function dctload(){
		$client = new SoapClient(TUH_SW_API,TUH_SW_API_OPTION);

	    $data = $client->dtDCTinSchedule()->dtDCTinScheduleResult;

	    $res = json_decode($data);

		
		if(count($res) > 0){ //$res->MessageCode == 200
			echo json_encode(array(
					'success' => true
					,'code' => 'pass'
					,'row' => $res
				));
		}else{
			echo json_encode(array(
					'success' => false
					,'code' => 'notPass'
				));
		}

	}

	function loadscheduledct(){
		$client = new SoapClient(TUH_SW_API,TUH_SW_API_OPTION);

		$params = array(
						'lct' => $this->input->get('lct')
						,'dct' => $this->input->get('dct')
						,'stdate' => $this->input->get('std')
						,'endate' => $this->input->get('end')
					);

	    $data = $client->dtDCTScheduleDetail($params)->dtDCTScheduleDetailResult;

	    $res = json_decode($data);

	    if(count($res) > 0){ //$res->MessageCode == 200
			echo json_encode(array(
					'success' => true
					,'code' => 'pass'
					,'row' => $res
				));
		}else{
			echo json_encode(array(
					'success' => false
					,'code' => 'notPass'
				));
		}
	}

}
