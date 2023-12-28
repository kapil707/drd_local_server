<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends CI_Controller {
	var $Page_title = "Home";
	var $Page_name  = "home";
	var $Page_view  = "home";
	var $Page_menu  = "home";
	var $page_controllers = "home";
	var $Page_tbl   = "";
	public function index()
	{
		$this->load->view("welcome_message");
	}
	
	public function drd_live_report()
	{
		$this->load->view("home/drd_live_report");
	}
	
	public function drd_today_invoice()
	{
		$this->load->view("home/drd_today_invoice");
	}
	
	public function child_invoice($value="")
	{
		$data["value"] = $value;
		$this->load->view("home/child_invoice",$data);
	}
	
	public function delivery_report()
	{
		$this->load->view("home/delivery_report");
	}
}