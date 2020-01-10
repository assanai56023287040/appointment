<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

require_once APPPATH."/third_party/jrs-php-client/autoload.dist.php";

use Jaspersoft\Client\Client;

class Report extends CI_Controller {

	function reportex($reponame ,$type ,$controls ,$resname){

		$c = new Client(JASPERSERVER ,JASPERUSERNAME ,JASPERPASSWORD);	

		$report = $c->reportService()->runReport('/reports/tuh_report/'.$reponame, $type ,null ,null ,$controls);
		// $report = $c->reportService()->runReport(oapp_sheet', 'pdf',null ,null ,$controls);

		if($type == 'pdf'){

			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Description: File Transfer');
			header('Content-Disposition: inline; filename='.$resname.'.pdf');
			header('Content-Transfer-Encoding: binary');
			header('Content-Length: ' . strlen($report));
			header('Content-Type: application/pdf');

		}else{ // excel

			// header('Cache-Control: must-revalidate');
			// header('Pragma: public');
			// header('Content-Description: File Transfer');
			// header('Content-Disposition: attachment; filename='.$reponame.'.xlsx');
			// header('Content-Transfer-Encoding: binary');
			// header('Content-Length: ' . strlen($report));
			// header('Content-Type: application/ms-excel');

		}
 
		echo $report;
	}

	function oapp_sheet_pdf(){
		$apmid = $this->input->get('apmid');

		if($apmid){
			$res = $this->db->from('apmpt a')
				->where('a.apmid',$apmid)
				->where('cfby is not null')
				->where('cfdate is not null')
				->where('cftime is not null')
				->get();

			if($res->num_rows() > 0){
				$res = $res->row();

				$controls = array('apmid' => $apmid);

				$this->reportex('oapp_sheet' ,'pdf' ,$controls ,'appointment_date'.$res->apmdate.'_for_hn_'.$res->hn);
			}else{

			}

		}

	}
}
