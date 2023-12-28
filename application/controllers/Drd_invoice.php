<?php
ini_set('memory_limit','-1');
ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time',36000);
defined('BASEPATH') OR exit('No direct script access allowed');
class Drd_invoice extends CI_Controller {

	//http://3450c2488e62.ngrok.io/drd_local_server/corporate_api/item_wise_report_api?user_session=1&user_division=s1&user_compcode=8518&formdate=2021-03-10&todate=2021-03-22
	public function __construct(){
		parent::__construct();
		error_reporting(0);
		/*if($this->session->userdata('user_session')==""){
			redirect(base_url()."user/login");			
		}*/
	}
	
	public function test000021(){
		$this->Drd_Invoice_Model->test000021();
	}
	
	public function copy_invoice(){
		$this->Drd_Invoice_Model->copy_invoice();
	}
	
	public function invoice_out_for_delivery(){
		$this->Drd_Invoice_Model->invoice_out_for_delivery();
	}
	
	public function invoice_check_pickedby_checkedby(){
		$this->Drd_Invoice_Model->invoice_check_pickedby_checkedby();
	}
	
	public function create_invoice(){
		$this->Drd_Invoice_Model->invoice_whatsapp_or_excel_create();
	}
	
	public function test_invoice(){
		$this->Drd_Invoice_Model->test_invoice();
	}
}
?>