<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Manage_corporate extends CI_Controller {
	var $Page_title = "Manage corporate";
	var $Page_name  = "manage_corporate";
	var $Page_view  = "manage_corporate";
	var $Page_menu  = "manage_corporate";
	var $page_controllers = "manage_corporate";
	var $Page_tbl   = "tbl_staffdetail";
	public function index()
	{
		$page_controllers = $this->page_controllers;
		redirect("admin/$page_controllers/view");
	}	public function view()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/		
		$_SESSION["latitude"] = 
		$_SESSION["longitude"] = "";		
		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;		
		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);		
		$data['title1'] = $Page_title." || View";
		$data['title2'] = "View";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;			$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");	
		$tbl = $Page_tbl;	
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";
		
		$query = $this->db->query("select tbl_staffdetail.id,tbl_staffdetail.staffname as name,tbl_staffdetail.memail  as email,tbl_staffdetail.mobilenumber as mobile,tbl_staffdetail.company_full_name,tbl_staffdetail.division,tbl_staffdetail_other.status,tbl_staffdetail_other.exp_date from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.code=tbl_staffdetail_other.code order by tbl_staffdetail.id desc");
  		$data["result"] = $query->result();
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}	public function search_user($page_type)	{		error_reporting(0);		header('Content-Type: application/json');		if($page_type=="get")		{			$search	= $_GET["search"];		}		if($page_type=="post")		{			$search	= $_POST["search"];		}		$query = $this->db->query("select tbl_staffdetail.id,tbl_staffdetail.staffname,tbl_staffdetail.memail,tbl_staffdetail.mobilenumber,tbl_staffdetail.company_full_name,tbl_staffdetail.division,tbl_staffdetail_other.status,tbl_staffdetail_other.exp_date from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.code=tbl_staffdetail_other.code and (tbl_staffdetail.staffname like '%$search%' or tbl_staffdetail.memail like '%$search%' ) order by tbl_staffdetail.id desc limit 10")->result();		foreach($query as $row)		{			$name = $row->staffname;			$email = $row->memail;			$mobile = $row->mobilenumber;			$company_full_name = $row->company_full_name;			$division = $row->division;			$exp_date = date("d-F-Y", strtotime($row->exp_date));			$status = $row->status;						$id = $row->id;$items.= <<<EOD{"id":"{$id}","name":"{$name}","email":"{$email}","mobile":"{$mobile}","company_full_name":"{$company_full_name}","division":"{$division}","exp_date":"{$exp_date}"},EOD;		}if ($items != '') {	$items = substr($items, 0, -1);}?>{"items":[<?= $items;?>]}		<?php	}
	public function edit($id)
	{		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/		
		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;		
		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);		
		$data['title1'] = $Page_title." || Edit";
		$data['title2'] = "Edit";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Edit","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Edit","admin/$page_controllers/edit");		
		$tbl = $Page_tbl;	
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";
		$upload_thumbs_path = "./uploads/$page_controllers/photo/thumbs/";		
		$system_ip = $this->input->ip_address();		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			$this->form_validation->set_rules('exp_date', 'exp date', 'trim|required');
			if ($this->form_validation->run() == FALSE)
			{
				$message = "Check Validation.";
				$this->session->set_flashdata("message_type","warning");
			}
			else
			{
				$time = time();
				$date = date("Y-m-d",$time);			
				$query = $this->db->query("select * from tbl_staffdetail where id='$id'")->row();
				$code = $query->code;
				$where = array('code'=>$code);				
				$exp_date = date("Y-m-d", strtotime($exp_date));
				$result = "";
				$dt = array(
				'status'=>$status,
				'item_wise_report'=>$item_wise_report,
				'chemist_wise_report'=>$chemist_wise_report,
				'stock_and_sales_analysis'=>$stock_and_sales_analysis,
				'item_wise_report_daily_email'=>$item_wise_report_daily_email,
				'chemist_wise_report_daily_email'=>$chemist_wise_report_daily_email,
				'stock_and_sales_analysis_daily_email'=>$stock_and_sales_analysis_daily_email,
				'item_wise_report_monthly_email'=>$item_wise_report_monthly_email,
				'chemist_wise_report_monthly_email'=>$chemist_wise_report_monthly_email,
				'stock_and_sales_analysis_monthly_email'=>$stock_and_sales_analysis_monthly_email,
				'whatsapp_message'=>$whatsapp_message,				
				);
				$result = $this->Scheme_Model->edit_fun("tbl_staffdetail_other",$dt,$where);			
				if($result)
				{
					$message_db = "$change_text - Edit Successfully.";
					$message = "Edit Successfully.";
					$this->session->set_flashdata("message_type","success");
				}
				else
				{
					$message_db = "$change_text - Not Add.";
					$message = "Not Add.";
					$this->session->set_flashdata("message_type","error");
				}
			}
			if($message_db!="")
			{
				$message = $Page_title." - ".$message;
				$message_db = $Page_title." - ".$message_db;
				$this->session->set_flashdata("message_footer","yes");
				$this->session->set_flashdata("full_message",$message);
				$this->Admin_Model->Add_Activity_log($message_db);
				if($result)
				{
					redirect(current_url());
					//redirect(base_url()."admin/$page_controllers/view");
				}
			}
		}	
		$query = $this->db->query("select tbl_staffdetail.id,tbl_staffdetail.code,tbl_staffdetail_other.status,tbl_staffdetail_other.exp_date,tbl_staffdetail_other.whatsapp_message,tbl_staffdetail_other.item_wise_report,tbl_staffdetail_other.chemist_wise_report,tbl_staffdetail_other.stock_and_sales_analysis,tbl_staffdetail_other.item_wise_report_daily_email,tbl_staffdetail_other.chemist_wise_report_daily_email,tbl_staffdetail_other.stock_and_sales_analysis_daily_email,tbl_staffdetail_other.item_wise_report_monthly_email,tbl_staffdetail_other.chemist_wise_report_monthly_email,tbl_staffdetail_other.stock_and_sales_analysis_monthly_email from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.code=tbl_staffdetail_other.code and tbl_staffdetail.id='$id' order by tbl_staffdetail.id desc");
  		$data["result"] = $query->result();		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/edit",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function send_email_for_password_create($code,$password)
	{
		$q = $this->db->query("select code,memail as email,mobilenumber as mobile,staffname as name from tbl_staffdetail where code='$code' ")->row();		if($q->code!="")		{			$name		= $q->name;			$email_id 	= $q->email;			$altercode 	= $q->email;			$number 	= $q->mobile;
			if($q->mobile!="")
			{
				/*$msg = "Hello $q->name Your New Login Details is $q->altercode Password is $randompassword";
				$q->mobile = "9530005050";
				//$q->mobile = "7303229909";
				$this->auth_model->send_sms_fun($q->mobile,$msg);*/
			}			else			{				$err = "$name this user can not have any mobile number";				$this->Email_Model->tbl_whatsapp_email_fail($number,$err,$altercode);			}			if($q->email!="")			{				$this->Email_Model->send_email_for_password_create($name,$email_id,$altercode,$password);			}			else			{				$err = "$name this user can not have any email address";				$this->Email_Model->tbl_whatsapp_email_fail($email_id,$err,$altercode);			}					}
	}
	public function password_create1() {
		error_reporting(0);
		$id = $_POST["id"];
		$password = strtolower($_POST["password"]);	
		$row = $this->db->query("select tbl_staffdetail.code from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.code=tbl_staffdetail_other.code and tbl_staffdetail.id='$id' order by tbl_staffdetail.id desc")->row();
		$code = $row->code;
		//$this->send_email_for_password_create($code,$password);
		$password = md5($password);
		$this->db->query("update tbl_staffdetail_other set password='$password' where code='$code'");
		echo "ok";
	}
	public function password_create2() {
		error_reporting(0);
		$id = $_POST["id"];
		$password = strtolower($this->randomPassword());	
		$row = $this->db->query("select tbl_staffdetail.code from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.code=tbl_staffdetail_other.code and tbl_staffdetail.id='$id' order by tbl_staffdetail.id desc")->row();
		$code = $row->code;
		//$this->send_email_for_password_create($code,$password);
		$password = md5($password);
		$this->db->query("update tbl_staffdetail_other set password='$password' where code='$code'");
		echo "ok";
	}
	public function randomPassword() {
		$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}}