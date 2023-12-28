<?php
header('Content-Type: application/json');
defined('BASEPATH') OR exit('No direct script access allowed');
class Chemist_medicine extends CI_Controller
{
	public function search_chemist_api()
	{
		//error_reporting(0);
		$items = "";
		$keyword = $_REQUEST["keyword"];
		if($keyword!="")
		{
			$items = $this->Chemist_Model->search_chemist($keyword);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function search_medicine_api()
	{
		//error_reporting(0);
		$items = "";
		$keyword		= $_REQUEST['keyword'];
		if($keyword!="")
		{			
			$items = $this->Chemist_Model->search_medicine($keyword);
		}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function get_single_medicine_info()
	{
		//error_reporting(0);		
		$user_type 		= $_SESSION['user_type'];
		$chemist_id		= $_REQUEST["chemist_id"];
		$i_code			= $_REQUEST["i_code"];
		
		$selesman_id = "";
		if($user_type=="sales")
		{
			$selesman_id = $_SESSION['user_altercode'];
		}
		else{
			$chemist_id	 = $_SESSION['user_altercode'];
		}
		
		$items = $this->Chemist_Model->get_single_medicine_info($i_code,$chemist_id,$selesman_id,$user_type);
?>
{"items":[<?= $items;?>]}<?php
	}
}
?>