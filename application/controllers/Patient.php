<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

require_once APPPATH."/third_party/jrs-php-client/autoload.dist.php";

use Jaspersoft\Client\Client;

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


	
	function patientpage(){
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
				,'lastdt' => date("Y-m-d H:i:s")
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
			,'logindt' => date("Y-m-d H:i:s")
		));

		// $params = array('ptid' => $id);

		// $this->load->view('patient/p1',$params);
		return $id;
	}

	function patientdata(){
		$hn = $this->input->get('hn');

		$pt = $this->db->get_where('pt',array('hn'=>$hn,'active <>' => 'I'));

		echo json_encode(array(
			'success' => true
			,'row' => $pt->first_row()
		));
	}

	function testjasperconn(){

		$c = new Client(
						"http://localhost:8080/jasperserver",
						"jasperadmin",
						"jasperadmin"
					);	

		$control = array('apmid' => 7);

		$report = $c->reportService()->runReport('/reports/tuh_report/oapp_sheet', 'pdf',null ,null ,$control);

		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename=jaspertest.xls');
		// header('Content-Disposition: inline; filename=jaspertest.pdf');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . strlen($report));
		header('Content-Type: application/ms-excel');
 
		echo $report;
	}
}
