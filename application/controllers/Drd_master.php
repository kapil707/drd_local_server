<?php
ini_set('memory_limit','-1');
ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time',36000);
defined('BASEPATH') OR exit('No direct script access allowed');
class Drd_master extends CI_Controller {

	//http://3450c2488e62.ngrok.io/drd_local_server/corporate_api/item_wise_report_api?user_session=1&user_division=s1&user_compcode=8518&formdate=2021-03-10&todate=2021-03-22
	public function __construct(){
		parent::__construct();
		error_reporting(0);
		/*if($this->session->userdata('user_session')==""){
			redirect(base_url()."user/login");			
		}*/
	}
	
	public function insert_delivery(){
		$this->Drd_master_Model->insert_delivery();
	}
	
	public function insert_delivery_add_items($vno,$vdt){
		$this->Drd_master_Model->insert_delivery_add_items($vno,$vdt);
	}
	
	public function upload_delivery_order(){
		$this->Drd_master_Model->upload_delivery_order();
	}
}
?>