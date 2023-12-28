<?php
ini_set('memory_limit','-1');
ini_set('post_max_size','500M');
ini_set('upload_max_filesize','500M');
ini_set('max_execution_time',36000);
defined('BASEPATH') OR exit('No direct script access allowed');
class Drd_pendingorder extends CI_Controller {

	//http://3450c2488e62.ngrok.io/drd_local_server/corporate_api/item_wise_report_api?user_session=1&user_division=s1&user_compcode=8518&formdate=2021-03-10&todate=2021-03-22
	public function __construct(){
		parent::__construct();
		error_reporting(0);
		/*if($this->session->userdata('user_session')==""){
			redirect(base_url()."user/login");			
		}*/
	}
	public function index(){
		extract($_POST);
		if(isset($add_shortage_submit))
		{
			if($start_date!="" && $end_date!="")
			{
				$this->Drd_Pendingorder_Model->copy_shortage_order($start_date,$end_date);
				redirect(constant('api_url2')."pendingorder_report");
			}
		}
		
		if(isset($add_pending_order_submit))
		{
			if($order_no!="" && $start_date!="" && $end_date!="")
			{
				$this->Drd_Pendingorder_Model->copy_pending_order($order_no,$start_date,$end_date);
				redirect(constant('api_url2')."pendingorder_report");
			}
		}
		
		if(isset($synchronization_fun_submit))
		{
			$this->Drd_Pendingorder_Model->synchronization_fun();
			redirect(constant('api_url2')."pendingorder_report");
		}
		
		if(isset($start_email_fun_submit))
		{
			$this->Drd_Pendingorder_Model->synchronization_fun();
			$this->Drd_Pendingorder_Model->start_email_fun();
			redirect(constant('api_url2')."pendingorder_report");
		}
		
		if(isset($stop_email_fun_submit))
		{
			$this->Drd_Pendingorder_Model->stop_email_fun();
			redirect(constant('api_url2')."pendingorder_report");
		}
		
		if(isset($delete_all_fun_submit))
		{
			$this->Drd_Pendingorder_Model->delete_all_fun();
			redirect(constant('api_url2')."pendingorder_report");
		}
		
		if(isset($deleteAll_bycheckbox))
		{
			foreach($delete_by_checkbox as $row1){
				$id  = $row1;
				$row = $this->db->query("select * from tbl_pending_order where id='$id'")->row();
				if($row->id!="")
				{	
					$this->db->query("delete from tbl_pending_order where itemc='$row->itemc'");
				}
			}
			//print_r($delete_by_checkbox);
		}
		
		if(isset($deleteAll_dropdown))
		{
			$this->db->query("delete from tbl_pending_order where compcode='$dropdown_id'");
		}
		$data = "";
		$this->load->view('pendingorder/view_order', $data);
	}
	
	public function qty_update()
	{
		echo "ok";
		$id  = $_POST["id"];
		$qty = $_POST["qty"];
		$this->db->query("update tbl_pending_order set qty='$qty' where id='$id'");
	}
	
	public function delete_row()
	{
		echo "ok";
		$id  = $_POST["id"];
		$row = $this->db->query("select * from tbl_pending_order where id='$id'")->row();
		if($row->id!="")
		{	
			$this->db->query("delete from tbl_pending_order where itemc='$row->itemc'");
		}
	}
	
	public function delete_stock_items()
	{
		$this->Drd_Pendingorder_Model->delete_stock_items();
		echo "ok";
		redirect(constant('api_url2')."pendingorder_report");
	}
}
?>