<?php //header("Content-type: application/json; charset=utf-8");
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_track extends CI_Controller {
	public function index()
	{
		echo "asdffd";
	}
	public function update_live_track_user($page_type)
	{
		error_reporting(0);
		if($page_type=="get")
		{
			$submit			= $_GET['submit'];
			$user_name1 	= $_GET['user_name1'];
			$user_phone1 	= $_GET['user_phone1'];
			$device_id 		= $_GET['device_id'];
			$firebase_token	= $_GET['firebase_token'];
			$latitude		= $_GET['latitude'];
			$longitude		= $_GET['longitude'];
		}
		if($page_type=="post")
		{
			$submit			= $_POST['submit'];
			$user_name1 	= $_POST['user_name1'];
			$user_phone1 	= $_POST['user_phone1'];
			$device_id 		= $_POST['device_id'];
			$firebase_token	= $_POST['firebase_token'];
			$latitude		= $_POST['latitude'];
			$longitude		= $_POST['longitude'];
		}
		$submit1 = md5("my_sweet_login");
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		$submit1 = md5($submit1);
		$submit1 = sha1($submit1);
		if($submit==$submit1)
		{
			$time = time();
			$date = date("Y-m-d",$time);
			$datetime = time();
			$timei = date("i",$time);
			$time = date("H:i",$time);
			$row = $this->db->query("select id from tbl_tracking where device_id='$device_id' order by id desc")->row();
			if($row->id=="")
			{
				$this->db->query("insert into tbl_tracking set device_id='$device_id',user_name1='$user_name1',user_phone1='$user_phone1',firebase_token='$firebase_token'");
			}
			else
			{
				$this->db->query("update tbl_tracking set latitude='$latitude',longitude='$longitude',date='$date',time='$time',datetime='$datetime',datetime='$datetime',user_name1='$user_name1',firebase_token='$firebase_token' where device_id='$device_id'");
			}
			/*$treak_time = $this->Scheme_Model->get_website_data("treak_time");
			if($timei%$treak_time==0){
				$row = $this->db->query("select id from tbl_tracking1 where time='$time' and date='$date' and user_id='$user_session' order by id desc")->row();
				if($row->id=="")
				{
					$this->db->query("insert into tbl_tracking1 set latitude='$latitude',longitude='$longitude',user_id='$user_session',date='$date',time='$time',datetime='$datetime'");
				}
			}*/
			
			/*
			$toast_msg = "Update Your Info :- ".$time;*/
		}
$items .= <<<EOD
{"toast_msg":"{$toast_msg}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
[<?= $items;?>]
<?php
	}
}