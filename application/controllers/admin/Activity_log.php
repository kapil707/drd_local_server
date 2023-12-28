<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_log extends CI_Controller {

	var $Page_title = "Activity Log";
	var $Page_name  = "activity_log";
	var $Page_view  = "activity_log";
	var $Page_menu  = "activity_log";
	var $Page_tbl   = "tbl_activity_log";
	var $page_controllers = "activity_log";
	public function index()
	{
		$page_controllers = $this->page_controllers;
		redirect("admin/$page_controllers/view");
	}
	public function view()
	{
		error_reporting(0);
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
		
		$data['title1'] = $Page_title." || view";
		$data['title2'] = "view";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("view","admin/$page_controllers/add");
		
		$tbl = $Page_tbl;
		
		extract($_POST);
		if(isset($Submit))
		{
			$result = "";
			$this->session->set_flashdata("user_type1",$user_type);
			foreach($page_type as $page_type1)
			{
				$this->db->query("delete from $tbl where user_type='$user_type' and page_type='$page_type1'");
				$dt = array('user_type'=>$user_type,'page_type'=>$page_type1,);
				$result = $this->Scheme_Model->insert_fun($tbl,$dt);
			}
			if($result)
			{
				$this->session->set_flashdata("message_footer","yes");
				$this->session->set_flashdata("message_type","success");
				$this->session->set_flashdata("full_message","Permission Set Successfully.");
			}
			else
			{
				$this->session->set_flashdata("message_footer","yes");
				$this->session->set_flashdata("message_type","error");
				$this->session->set_flashdata("full_message","Permission Not Set.");
			}
			redirect(current_url());
		}
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function history()
	{
		error_reporting(0);
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
		
		$data['title1'] = $Page_title." || History";
		$data['title2'] = "History";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("History","admin/$page_controllers/add");
		
		$tbl = $Page_tbl;
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/history",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
}