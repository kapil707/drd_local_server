<?php
ini_set('memory_limit','-1');
ini_set('post_max_size','100M');
ini_set('upload_max_filesize','100M');
ini_set('max_execution_time',36000);
defined('BASEPATH') OR exit('No direct script access allowed');
class Corporate extends CI_Controller {

	//http://3450c2488e62.ngrok.io/drd_local_server/corporate_api/item_wise_report_api?user_session=1&user_division=s1&user_compcode=8518&formdate=2021-03-10&todate=2021-03-22
	public function __construct(){
		parent::__construct();
		error_reporting(0);
		/*if($this->session->userdata('user_session')==""){
			redirect(base_url()."user/login");			
		}*/
	}
	
	public function index(){
		error_reporting(0);
		$this->load->view('corporate/header', $data);		
		$this->load->view('corporate/home', $data);
		$this->load->view('corporate/footer', $data);
	}
	
	public function item_wise_report($user_session='',$user_division='',$user_compcode='')
	{	
		$data["user_session"]	=	$user_session;
		$data["user_division"]	=	$user_division;
		$data["user_compcode"]	=	$user_compcode;
		
		
		$this->load->view('corporate/header', $data);
		$this->load->view('corporate/item_wise_report',$data);
	}
	
	public function item_wise_report_month($user_session='',$user_division='',$user_compcode='')
	{	
		$data["user_session"]	=	$user_session;
		$data["user_division"]	=	$user_division;
		$data["user_compcode"]	=	$user_compcode;
		
		$this->load->view('corporate/header', $data);
		$this->load->view('corporate/item_wise_report_month',$data);
	}
	
	public function chemist_wise_report($user_session='',$user_division='',$user_compcode='')
	{	
		$data["user_session"]	=	$user_session;
		$data["user_division"]	=	$user_division;
		$data["user_compcode"]	=	$user_compcode;
		
		$this->load->view('corporate/header', $data);
		$this->load->view('corporate/chemist_wise_report',$data);
	}
	
	public function chemist_wise_report_month($user_session='',$user_division='',$user_compcode='')
	{	
		$data["user_session"]	=	$user_session;
		$data["user_division"]	=	$user_division;
		$data["user_compcode"]	=	$user_compcode;
		
		$this->load->view('corporate/header', $data);
		$this->load->view('corporate/chemist_wise_report_month',$data);
	}
	
	public function stock_and_sales_analysis($user_session='',$user_division='',$user_compcode='')
	{	
		$data["user_session"]	=	$user_session;
		$data["user_division"]	=	$user_division;
		$data["user_compcode"]	=	$user_compcode;
		
		$this->load->view('corporate/header', $data);
		$this->load->view('corporate/stock_and_sales_analysis',$data);
	}
	
	public function stock_and_sales_analysis_by_email($user_session='',$user_division='',$user_compcode='')
	{	
		$data["user_session"]	=	base64_encode($user_session);
		$data["user_division"]	=	base64_encode($user_division);
		$data["user_compcode"]	=	base64_encode($user_compcode);
		
		$this->load->view('corporate/header', $data);
		$this->load->view('corporate/stock_and_sales_analysis',$data);
	}
	
	/********************************************/
	public function item_wise_report_api()
	{
		error_reporting(0);
		$user_session	=	$_POST["user_session"];
		$user_division	=	$_POST["user_division"];
		$user_compcode	=	$_POST["user_compcode"];
		$formdate		= 	$_POST["formdate"];
		$todate	 		= 	$_POST["todate"];
		$monthdate	 	= 	$_POST["monthdate"];
		
		header('Content-Type: application/json');
		$json_url = constant('api_url')."item_wise_report_api?formdate=$formdate&todate=$todate&monthdate=$monthdate&user_division=$user_division&user_compcode=$user_compcode&user_session=$user_session";
		$ch = curl_init($json_url);
		$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json'),
		);
		curl_setopt_array($ch,$options);
		$result = curl_exec($ch);
		print_r($result);
	}
	
	public function chemist_wise_report_api()
	{
		error_reporting(0);
		$user_session	=	$_POST["user_session"];
		$user_division	=	$_POST["user_division"];
		$user_compcode	=	$_POST["user_compcode"];
		$formdate		= 	$_POST["formdate"];
		$todate	 		= 	$_POST["todate"];
		$monthdate	 	= 	$_POST["monthdate"];
		
		header('Content-Type: application/json');
		$json_url = constant('api_url')."chemist_wise_report_api?formdate=$formdate&todate=$todate&monthdate=$monthdate&user_division=$user_division&user_compcode=$user_compcode&user_session=$user_session";
		$ch = curl_init($json_url);
		$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json'),
		);
		curl_setopt_array($ch,$options);
		$result = curl_exec($ch);
		print_r($result);
	}
	
	public function stock_and_sales_analysis_api(){
		error_reporting(0);
		$user_session	=	$_POST["user_session"];
		$user_division	=	$_POST["user_division"];
		$user_compcode	=	$_POST["user_compcode"];
		
		header('Content-Type: application/json');
		$json_url = constant('api_url')."stock_and_sales_analysis_api?user_division=$user_division&user_compcode=$user_compcode&user_session=$user_session";
		$ch = curl_init($json_url);
		$options = array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => array('Content-type: application/json'),
		);
		curl_setopt_array($ch,$options);
		$result = curl_exec($ch);
		print_r($result);
	}
}
?>