<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Message_Model extends CI_Model
{
	public function tbl_whatsapp_email_fail($number,$message,$altercode)
	{
		$where = array('altercode'=>$altercode);
		$row = $this->Scheme_Model->select_row("tbl_whatsapp_email_fail",$where,'','');
		if($row->id=="")
		{
			$this->db->query("insert into tbl_whatsapp_email_fail set altercode='$altercode',mobile='$number',message='$message'");
		}
	}
	
	public function insert_whatsapp_message($mobile,$message,$altercode,$media="")
	{
		$time = time();
		$date = date("Y-m-d",$time);

		$dt = array(
		'mobile'=>$mobile,
		/*'message'=>base64_encode($message),*/
		'message'=>($message),
		'chemist_id'=>$altercode,
		'time'=>$time,
		'date'=>$date,
		'media'=>$media,
		);
		$this->Scheme_Model->insert_fun("tbl_whatsapp_message",$dt);
	}
	
	public function send_whatsapp_message()
	{		
		$whatsapp_key = "531fe5caf0e132bdb6000bf01ed66d8cfb75b53606cc8f6eed32509d99d74752f47f288db155557e";
		
		$this->db->limit(50);
		//$this->db->where('status','1');
		$query = $this->db->get("tbl_whatsapp_message")->result();
		foreach($query as $row)
		{
			$mid 			= $row->id;
			$mobile 		= $row->mobile;
			$media 			= $row->media;
			/*$message 		= base64_decode($row->message);*/
			$message 		= ($row->message);
			$message 		= str_replace("<br>","\\n",$message);
			$message 		= str_replace("<b>","*",$message);
			$message 		= str_replace("</b>","*",$message);
			
			$chemist_id 	= $row->chemist_id;
			$this->db->query("DELETE FROM `tbl_whatsapp_message` WHERE id='$mid'");
		
			if($media!="")
			{
				$parmiter = '{"phone": "'.$mobile.'","message": "'.$message.'","media": { "file": "'.$media.'" }}';
			}
			if($media=="")
			{
				$parmiter = "{\"phone\":\"$mobile\",\"message\":\"$message\"}";
			}

			$curl = curl_init();
			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.wassi.chat/v1/messages",
			CURLOPT_RETURNTRANSFER=>true,
			CURLOPT_ENCODING =>"",
			CURLOPT_MAXREDIRS =>10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION =>CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS =>$parmiter,
			CURLOPT_HTTPHEADER =>array("content-type: application/json","token:$whatsapp_key"),));
			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				echo "cURL Error #:" . $err;
				$err = "Number stored is : $mobile";
				$this->Message_Model->tbl_whatsapp_email_fail($mobile,$err,$altercode);
			} else {
				//echo $response;
				$someArray = json_decode($response,true);
				if($someArray["status"]=="400"||$someArray["status"]=="401"||$someArray["status"]=="409"||$someArray["status"]=="500"||$someArray["status"]=="501"||$someArray["status"]=="503")
				{
					$err = "Number stored is : $mobile";
					$this->Message_Model->tbl_whatsapp_email_fail($mobile,$err,$altercode);
				}
			}
		}
	}
	
	public function send_whatsapp_group_message()
	{
		$whatsapp_key = "531fe5caf0e132bdb6000bf01ed66d8cfb75b53606cc8f6eed32509d99d74752f47f288db155557e";
		
		$this->db->limit(50);
		//$this->db->where('status','1');
		$query = $this->db->get("tbl_whatsapp_group_message")->result();
		foreach($query as $row)
		{
			$mid 			= $row->id;
			$mobile 		= $row->mobile;
			/*$message 		= base64_decode($row->message);*/
			$message 		= ($row->message);
			$message 		= str_replace("<br>","\\n",$message);
			$message 		= str_replace("<b>","*",$message);
			$message 		= str_replace("</b>","*",$message);
			
			$this->db->query("DELETE FROM `tbl_whatsapp_group_message` WHERE id='$mid'");
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.wassi.chat/v1/messages",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\"group\":\"$mobile\",\"priority\":\"high\",\"message\":\"$message\"}",
			CURLOPT_HTTPHEADER => array(
			"content-type: application/json","token:$whatsapp_key"),));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if ($err) {
				echo "cURL Error #:" . $err;
				//$this->Email_Model->tbl_whatsapp_email_fail($number,$err,$altercode);
			} else {
				//echo $response;
				$someArray = json_decode($response,true);
				if($someArray["status"]=="400"||$someArray["status"]=="401"||$someArray["status"]=="409"||$someArray["status"]=="500"||$someArray["status"]=="501"||$someArray["status"]=="503")
				{
				}
			}
		}
	}

	function send_email_message()
	{
		$time  = time();
		$mytime_min 	= date("i",$time);
		$mytime_ganta 	= date("H",$time);
		
		//error_reporting(0);
		$this->db->limit(1);
		$this->db->where('status','0');
		//$this->db->where('email_function','pendingorder');
		$this->db->where('email_function!=','invoice');
		$this->db->order_by('id','asc');
		$query = $this->db->get("tbl_email_send")->result();
		
		$this->load->library('phpmailer_lib');
		$email = $this->phpmailer_lib->load();
		//print_r($query);
		foreach($query as $row)
		{
			$id 			= $row->id;
			$user_email_id 	= $row->user_email_id;
			$subject 		= ($row->subject);
			$message 		= ($row->message);
			$file_name1 	= $row->file_name1;
			$file_name2 	= $row->file_name2;
			$file_name3 	= $row->file_name3;
			$file_name_1 	= $row->file_name_1;
			$file_name_2 	= $row->file_name_2;
			$file_name_3 	= $row->file_name_3;
			$mail_server 	= $row->mail_server;
			$email_other_bcc= $row->email_other_bcc;
			$email_function= $row->email_function;
			if($row->email_other_bcc=="")
			{
				$email_other_bcc="";
			}
			
			$addreplyto 		= "vipul@drdindia.com";
			$addreplyto_name 	= "Vipul DRD";
			$server_email 		= "vipul@drdindia.com";
			//$server_email 	= "send@drdistributors.co.in";
			$server_email_name 	= "DRD Mail";
			
			if($email_function=="invoice")
			{
				$server_email_name 	= "DRD Invoice";
			}
			if($email_function=="corporate_report")
			{
				$server_email_name 	= "DRD Report";
			}
			
			if($email_function=="pendingorder")
			{
				$server_email_name 	= "DRD New Order";
			}
			
			$email->AddReplyTo($addreplyto,$addreplyto_name);
			$email->SetFrom($server_email,$server_email_name);
			
			$email->Subject   	= $subject;
			$email->Body 		= $message;		
			
			$email->IsHTML(true);
			
			if($mytime_min=="00" && $mytime_ganta%2==0){
			    $email_bcc = "kapildrd@gmail.com";
			}
			
			$live_or_demo = "";
			if($live_or_demo=="Demo")
			{
				$email->AddAddress($user_email_id);
				/*$email_other_bcc = explode (",", $email_other_bcc);
				foreach($email_other_bcc as $bcc)
				{
					$email->addBcc($bcc);
				}*/
			}
			else
			{
				$email->AddAddress($user_email_id);
				$email_bcc = explode (",",$email_bcc);
				foreach($email_bcc as $bcc)
				{
					$email->addBcc($bcc);
				}
				/*$email->addBcc($mail_server);
				$email_other_bcc = explode (",", $email_other_bcc);
				foreach($email_other_bcc as $bcc)
				{
					$email->addBcc($bcc);
				}*/
			}
			
			/*****************************************/
			if($email_function=="pendingorder"){
				$email->AddAddress("infiniteloop1008@gmail.com");
			}
			/*****************************************/
			
			if($file_name1)
			{
				if($file_name_1)
				{
					$email->addAttachment($file_name1,$file_name_1);
				}
				else
				{
					$email->addAttachment($file_name1);
				}
			}
			if($file_name2)
			{
				if($file_name_2)
				{
					$email->addAttachment($file_name2,$file_name_2);
				}
				else
				{
					$email->addAttachment($file_name2);
				}
			}
			if($file_name3)
			{
				if($file_name_3)
				{
					$email->addAttachment($file_name3,$file_name_3);
				}
				else
				{
					$email->addAttachment($file_name3);
				}
			}
			
			/************************************************/
			$this->db->query("delete from tbl_email_send where id='$id'");
			/************************************************/
			//$email->AddAddress("kapil707sharma@gmail.com");
			/************************************************
			$this->db->query("update tbl_email_send set status='1' where id='$id'");
			/************************************************/
			
			/*$email->IsSMTP();
			$email->SMTPAuth   = 3; 
			$email->SMTPSecure = "tls";  //tls
			$email->Host       = "smtpout.secureserver.net";
			$email->Port       = 587;
			$email->Username   = "application@drdistributor.com";
			$email->Password   = "Application123";
			
			/*$email->IsSMTP();
			$email->SMTPAuth   = 3; 
			$email->SMTPSecure = "tls";  //tls
			$email->Host       = "mail.smtp2go.com";
			$email->Port       = 587;
			$email->Username   = "application@drdindia.com";
			$email->Password   = "medical@2023";*/
			

			$email->IsSMTP();
			$email->SMTPAuth   = 3; 
			$email->SMTPSecure = "ssl";  //tls
			$email->Host       = "smtp.gmail.com";
			$email->Port       = 465;
			
			if($email_function=="pendingorder") {
				$email->Username   = "application@drdindia.com";
				$email->Password   = "medical@2023";
			}
			
			if($email_function=="corporate_report") {
				if($mytime_ganta%2==0){
					$email->Username   = "application2@drdindia.com";
					$email->Password   = "drd@oct23";
				}else{
					$email->Username   = "application@drdindia.com";
					$email->Password   = "medical@2023";
				}
			}


			/*$email->IsSMTP();
			$email->SMTPAuth   = true; 
			$email->SMTPSecure = "tls";  //tls
			$email->Host       = "smtpcorp.com";
			$email->Port       = 2525;
			$email->Username   = "send@drdindia.com";
			$email->Password   = "DRD#123";
			
			/*$email->IsSMTP();
			$email->SMTPAuth   = true; 
			$email->SMTPSecure = "tls";  //tls
			$email->Host       = "smtp.rediffmailpro.com";
			$email->Port       = 587;
			$email->Username   = "send@drdistributors.co.in";
			$email->Password   = "DRD#123";*/
			if($email->Send()){
				echo "Mail Sent";
			}
			else{
				echo "Mail Failed";
			}
			if($file_name1)
			{
				unlink($file_name1);
			}
			if($file_name2)
			{
				unlink($file_name2);
			}
			if($file_name3)
			{
				unlink($file_name3);
			}
			echo "<pre>";
			print_r($email);
		}
	}
	
	public function insert_whatsapp_group_message($mobile,$message)
	{		
		$date = date("Y-m-d");
		$time = date("H:i",time());

		$dt = array(
		'mobile'=>$mobile,
		'message'=>($message),
		'time'=>$time,
		'date'=>$date,
		);
		$this->Scheme_Model->insert_fun("tbl_whatsapp_group_message",$dt);
	}

	public function insert_message_on_server()
	{		
		$qry	= "";
		$items 	= "";
		/*$this->db->limit(50);
		$this->db->where('status','0');
		$query = $this->db->get("tbl_whatsapp_message")->result();
		foreach($query as $row)
		{
			$mid		= $row->id;
			$mobile 	= $row->mobile;
			$message 	= base64_encode($row->message);
			
			$altercode  = $row->chemist_id;

			$items.='{"type_of_message":"whatsapp_message","mobile": "'.$mobile.'","message": "'.$message.'","altercode": "'.$altercode.'"},';
			$qry.= "delete from `tbl_whatsapp_message` WHERE id='$mid';";
		}
		if(empty($items)){
			$this->db->limit(50);
			$this->db->where('status','0');
			$query = $this->db->get("tbl_whatsapp_group_message")->result();
			foreach($query as $row)
			{
				$mid		= $row->id;
				$mobile 	= $row->mobile;
				$message 	= base64_encode($row->message);
				
				$altercode  = "";
				$items.='{"type_of_message":"whatsapp_group","mobile": "'.$mobile.'","message": "'.$message.'","altercode": "'.$altercode.'"},';
				$qry.= "delete from `tbl_whatsapp_group_message` WHERE id='$mid';";
			}
		}*/
		
		if(empty($items)){
			$this->db->limit(100);
			$this->db->where('status','0');
			//$this->db->where('email_function!=','pendingorder');
			$this->db->where('email_function','invoice');
			$query = $this->db->get("tbl_email_send")->result();
			//print_r($query);
			foreach($query as $row)
			{
				$mid		= $row->id;
				
				$user_email_id 	= $row->user_email_id;
				$subject 	= base64_encode($row->subject);
				$message 	= base64_encode($row->message);
				$file_name1 = $row->file_name1;
				$file_name2 = $row->file_name2;
				$file_name3 = $row->file_name3;
				$file_name_1 = $row->file_name_1;
				$file_name_2 = $row->file_name_2;
				$file_name_3 = $row->file_name_3;
				$mail_server 	= $row->mail_server;
				$email_function = $row->email_function;
				$email_other_bcc = base64_encode($row->email_other_bcc);
				
				$items.='{"type_of_message":"email_message","user_email_id": "'.$user_email_id.'","subject": "'.$subject.'","message": "'.$message.'","file_name1": "'.$file_name1.'","file_name2": "'.$file_name2.'","file_name3": "'.$file_name3.'","file_name_1": "'.$file_name_1.'","file_name_2": "'.$file_name_2.'","file_name_3": "'.$file_name_3.'","mail_server": "'.$mail_server.'","email_function": "'.$email_function.'","email_other_bcc": "'.$email_other_bcc.'"},';
				$qry.= "delete from `tbl_email_send` WHERE id='$mid';";
			}
		}
		
		if(empty($items)){
			$this->db->limit(100);
			$this->db->where('status','0');
			$query = $this->db->get("tbl_notification")->result();
			foreach($query as $row)
			{
				$mid		= $row->id;
				$title 		= $row->title;
				$message 	= base64_encode($row->message);
				$altercode 	= $row->chemist_id;
				$funtype 	= $row->funtype;
				
				$items.='{"type_of_message":"notification_message","title": "'.$title.'","message": "'.$message.'","altercode": "'.$altercode.'","funtype": "'.$funtype.'"},';
				$qry.= "delete from `tbl_notification` WHERE id='$mid';";
			}
		}
		if(!empty($items)){

			if ($items != '') {
				$items = substr($items, 0, -1);
			}

			$parmiter = '{"items": ['.$items.']}';

			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://drdweb.co.in/exe01/exe02/insert_message_on_server',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>$parmiter,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
			),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			echo $response;
			if($response=="done")
			{
				$arr = explode(";",$qry);
				foreach($arr as $row_q){
					if($row_q!=""){
						$this->db->query("$row_q");
					}
				}
			}
		}
	}

	public function insert_notification($funtype,$title,$message,$chemist_id,$user_type)
	{
		$date = date('Y-m-d');
		$time = date("H:i",time());
		
		$itemid = $compid = $status = $firebase_status = "0";
		$division = $image = $respose = "";
		$dt = array(
			'title'=>$title,
			'message'=>$message,
			'user_type'=>$user_type,
			'chemist_id'=>$chemist_id,
			'funtype'=>$funtype,
			'itemid'=>$itemid,
			'compid'=>$compid,
			'division'=>$division,
			'image'=>$image,
			'date'=>$date,
			'time'=>$time,
			'status'=>$status,
			'firebase_status'=>$firebase_status,
			'respose'=>$respose,);
		
		$this->Scheme_Model->insert_fun("tbl_notification",$dt);
	}
}