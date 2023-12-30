<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');
ini_set('max_execution_time', 36000);
require_once APPPATH."/third_party/PHPExcel.php";
class Cronjob_page extends CI_Controller 
{
	public function tt()
	{
		$title = "hi";
		$message = "hi";
		$altercode = "hi";
		$this->Message_Model->insert_notification("5",$title,$message,$altercode,"chemist");
	}
	public function insert_message_on_server(){
		$this->Message_Model->insert_message_on_server();// this is the server email
		echo "done";
	}
	public function all_message_send_by()
	{
		$this->Message_Model->send_whatsapp_message();
		$this->Message_Model->send_whatsapp_group_message();	

		$this->Message_Model->insert_message_on_server();// this is the server email
		$this->Message_Model->send_email_message(); // this is the local email
		
		$time  = time();
		$th = date('H',$time);
		$ti = date('i',$time);
		
		if($th=="10" && $ti=="01")
		{
			$this->delete_old_rec();
		}
		if($th==11)
		{
			$this->create_new_staff();
		}
		if($th==12)
		{
			$this->check_order_sahi_insert_hoa_kya_nahi();
		}
	}
	
	public function test_email()
	{
		$this->load->library('phpmailer_lib');
		$email = $this->phpmailer_lib->load();
		
		$subject = "drd local test ok";
		$message = "drd local test ok";
		
		$addreplyto 		= "application@drdistributor.com";
		$addreplyto_name 	= "Vipul DRD";
		$server_email 		= "application@drdistributor.com";
		//$server_email 	= "send@drdindia.com";
		$server_email_name 	= "DRD TEST";
		$email1 			= "kapil707sharma@gmail.com";
		
		$email->AddReplyTo($addreplyto,$addreplyto_name);
		$email->SetFrom($server_email,$server_email_name);
		$email->AddAddress($email1);
		
		$email->Subject   	= $subject;
		$email->Body 		= $message;

		$email->IsHTML(true);

		// SMTP configuration
		$email->isSMTP();
		$email->SMTPAuth   = 3; 
		$email->SMTPSecure = "tls";  //tls
		$email->Host     = "smtp.gmail.com";
		$email->Username   = "application2@drdindia.com";
		$email->Password   = "drd@june2023";
		$email->Port     = 587;

		if($email->send()){
            echo 'Message has been sent';
        }else{
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $email->ErrorInfo;
        }
		echo "<pre>";
		print_r($email);
	}
	
	public function test_corporate()
	{
		//$this->load->view('corporate/header');
		$this->load->view("home/test_corporate");
	}
	
	public function test_corporate1()
	{
		//$this->load->view('corporate/header');
		$this->load->view("home/test_corporate1");
	}
	
	
	public function pendingorder_email(){
		
		$query = $this->db->query("select DISTINCT barcode,MAX(qty) as qty,itemc,name,pack,division,company_full_name,uname,uemail,umobile,acno,id from tbl_pending_order where acno=(SELECT acno FROM `tbl_pending_order` WHERE status=1 and uemail!='' order by acno limit 1) group by barcode order by division asc");
		$result = $query->result();
		$row = $query->row();
		if($row->id!="")
		{
			$file_name_1 = "DRD-New-Order.xls";
			$file_name1  = $this->Excel_Model->pendingorder_excel($result,"cronjob_download");
			
			if($file_name1!="")
			{
				$subject = "New Order From D.R. Distributors Pvt. Ltd.";
				$message = "Hello ".ucwords(strtolower($row->uname)). ",<br><br>Please find attached herewith order form for D R Distributors Pvt Ltd in excel format.<br><br>Vipul Gupta <br>Moblie : +919899133989<br>Email : vipul@drdindia.com<br>Address : F2/6 , Okhla Industrial Area Phase 1<br>New Delhi 110020<br><br><b>D.R. Distributors Private Limited.</b>";
				//$message.= $row->uemail;
				
				/*$subject = base64_encode($subject);
				$message = base64_encode($message);*/
				
				
				//$user_email_id 	= "kapil7071@gmail.com";
				$user_email_id 	= $row->uemail;
				if($user_email_id=="")
				{
					$user_email_id = "drdwebmail@gmail.com"; //"drdwebmail1@gmail.com";
				}
				$email_other_bcc 	= "vipul@drdindia.com"; //"drdwebmail@gmail.com";
				
				$email_function = "pendingorder";
				
				$date = date('Y-m-d');
				$time = date('H:i');

				$dt = array(
				'user_email_id'=>$user_email_id,
				'subject'=>$subject,
				'message'=>$message,
				'file_name1'=>$file_name1,
				'file_name_1'=>$file_name_1,
				'email_other_bcc'=>$email_other_bcc,
				'email_function'=>$email_function,
				'date'=>$date,
				'time'=>$time,
				);
				$this->Scheme_Model->insert_fun("tbl_email_send",$dt);
			}
			
			$this->db->query("delete from tbl_pending_order where uemail='$row->uemail'");
		}
	}
	
	public function order_download_error()
	{
		$i = 1;
		$order_id = "";
		
		$result = $this->db->query("SELECT DISTINCT order_id,chemist_id FROM `tbl_order` WHERE `order_status`='0'")->result();
		foreach($result as $row)
		{
			$order_id.="$i. Order No.: $row->order_id ($row->chemist_id)\\n";
			$i++;
		}
		
		$result = $this->db->query("SELECT DISTINCT order_id,chemist_id FROM `tbl_order` WHERE `order_status`='1'")->result();
		foreach($result as $row)
		{
			$order_id.="$i. Order No.: $row->order_id ($row->chemist_id)\\n";
			$i++;
		}		
		
		if($order_id)
		{
			$msg1 = "Hello team\\n\\nThis order no problem to download\\n\\n";
			$datetime = date("d-M-Y H:i");
			$group2_message = "*Error Order Download Report* ($datetime)\\n\\n".$msg1.$order_id;
			
			$whatsapp_group2 = "919899333989-1628519476@g.us";
			$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
		}
	}
	
	public function create_new_staff()
	{
		$result = $this->db->query("select * from tbl_staffdetail")->result();
		foreach($result as $row)
		{
			$row1 = $this->db->query("select * from tbl_staffdetail_other where code='$row->code'")->row();
			if($row1->id=="")
			{
				$code = $row->code;
			}
		}
		echo $code;
		if($code!="")
		{
			header('Content-Type: application/json');
			$json_url = constant('base_url2')."exe01/exe01/create_new_staff/".$code;
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
	public function delete_old_rec()
	{
		$time = time();
		$day5 = date("Y-m-d", strtotime("-5 days", $time));
		$day7 = date("Y-m-d", strtotime("-7 days", $time));
		$day  = date("Y-m-d");
		
		$this->db->query("delete FROM `tbl_staffdetail_other` WHERE `daily_date`<'$day' ");
		
		//echo "delete FROM `tbl_order_download` WHERE `date`<'$day5'";die;
		
		$this->db->query("delete FROM `tbl_order_download` WHERE `date`<'$day5'");
		$this->db->query("delete FROM `tbl_invoice` WHERE `date`<'$day5'");
		
		//$this->db->query("delete FROM `tbl_email_send` WHERE `date`<'$day7'");
		
		$result = $this->db->query("SELECT * FROM `tbl_email_send`  WHERE `date`<'$day7'")->result();
		foreach($result as $row)
		{
			$id = $row->id;
			$file_name1 = $row->file_name1;
			if($file_name1)
			{
				unlink($file_name1);
			}
			$file_name2 = $row->file_name2;
			if($file_name2)
			{
				unlink($file_name2);
			}
			$file_name3 = $row->file_name3;
			if($file_name3)
			{
				unlink($file_name3);
			}
			$this->db->query("DELETE FROM `tbl_email_send` WHERE id='$id'");
		}
		
		/*
		$result = $this->db->query("select * from tbl_staffdetail_other")->result();
		foreach($result as $row)
		{
			$row1 = $this->db->query("select * from tbl_staffdetail where code='$row->code'")->row();
			if($row1->id=="")
			{
				$code = $row->code;
				$this->db->query("delete from tbl_staffdetail_other where code='$code'");
			}
		}*/
	}
	
	public function check_order_sahi_insert_hoa_kya_nahi()
	{
		$this->Drd_Invoice_Model->check_order_sahi_insert_hoa_kya_nahi();
	}
	
	public function drd_report_not_pickedby_whatsapp()
	{
		$this->order_download_error();
		$datetime = date("d-M-Y H:i");
		$res = "";
		$i = 1;
		$result = $this->Drd_Invoice_Model->drd_report_not_pickedby_whatsapp();
		foreach($result as $row)
		{
			$res.= $i.". ".$row->gstvno." | ".$row->altercode." | ".$row->mtime." | Rs.".round($row->amt)."\\n";
			$i++;
		}
		if($res!=""){
			$res = "*Pickedby Report* ($datetime)\\n\\n".$res;
			$group2_message = ($res);
			
			$whatsapp_group2 = "120363040276835738@g.us";
			$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
		}
		
		$res = "";
		$i = 1;
		$result = $this->Drd_Invoice_Model->drd_report_not_deliverby_whatsapp();
		foreach($result as $row)
		{
			$res.= $i.". ".$row->gstvno." | ".$row->altercode." | ".$row->mtime." | Rs.".round($row->amt)."\\n";
			$i++;
		}
		if($res!=""){
			$res = "*Deliverby Report* ($datetime)\\n\\n".$res;
			$group2_message = ($res);
			
			$whatsapp_group2 = "120363040276835738@g.us";
			$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2,$group2_message);
		}
	}
	
	public function invoice_job1()
	{
		$this->Drd_Invoice_Model->invoice_copy_db_to_db();
		$this->Drd_Invoice_Model->invoice_check_pickedby_checkedby();
	    $this->Drd_Invoice_Model->invoice_whatsapp_or_excel_create();
		$this->Drd_Invoice_Model->invoice_out_for_delivery();
		
		// new add on 2023-12-09 out for delivery or old ko band karna ha jaldi
		
		$this->Drd_master_Model->insert_delivery();
	}	
	
	public function upload_invoice_on_server()
	{
		$this->Drd_Invoice_Model->upload_invoice_on_server();
		
		// new add on 2023-12-09 out for delivery or old ko band karna ha jaldi
		
		$this->Drd_master_Model->upload_delivery_order();
	}
	
	
	public function Corporate_report()
	{
		$from_1 = date('d');
		if($from_1=="01")
		{
			$this->Corporate_monthly_report();
		}
		else
		{
			$this->Corporate_daily_report();
		}
		$this->pendingorder_email();
		$this->corporate_whatsapp_report();
	}
	
	public function Corporate_daily_report()
	{
		$from 	= date('Y-m-01');
		//$to 	= date('Y-m-t');
		$to 	= date('Y-m-d');
		
		$time  = time();
		$from1 	= date('Y-m-d', strtotime("-1 days", $time));
		$to1 	= date('Y-m-d', strtotime("-1 days", $time));
		
		$daily_date = date('Y-m-d');		
		$today_date = date('d-M-Y');
		$daily_date1  = date("Y-m-d", strtotime("+1 days", $time));
		
		$hourly1  = date("H", strtotime("+60 minutes", $time));


		$row = $this->db->query("select tbl_staffdetail.memail,stock_and_sales_analysis_daily_email,item_wise_report_daily_email,chemist_wise_report_daily_email,tbl_staffdetail_other.status,tbl_staffdetail.`compcode`,tbl_staffdetail.`company_full_name`,tbl_staffdetail.`division`,tbl_staffdetail.`id`,tbl_staffdetail_other.`id` as id1,tbl_staffdetail.`code` from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.code=tbl_staffdetail_other.code and tbl_staffdetail_other.daily_date='$daily_date' and tbl_staffdetail_other.status2=0 limit 1")->row();		
		if($row->id!="")
		{			
			$user_session  = $row->id;
			$user_division = $row->division;
			$user_compcode = $row->compcode;
			$company_full_name = $row->company_full_name;
			
			$id1  = $row->id1;	
			
			$file_name1 = $file_name2 = $file_name3 = "";
			$file_name_1 = $file_name_2 = $file_name_3 = "";
			if($row->stock_and_sales_analysis_daily_email=="1")
			{
				$file_name1  = $this->Excel_Model->staff_download_stock_and_sales_analysis($user_session,$user_division,$user_compcode,$from,$to,"cronjob_download");
				$file_name_1 = "DRD-Sales-and-stock-report.xls";
			}
			
			if($row->item_wise_report_daily_email=="1")
			{
				$file_name2  = $this->Excel_Model->staff_download_item_wise_report($user_session,$user_division,$user_compcode,$from1,$to1,"cronjob_download");
				$file_name_2 = "DRD-Item-wise-report.xls";
			}
			
			if($row->chemist_wise_report_daily_email=="1")
			{
				$file_name3  = $this->Excel_Model->staff_download_chemist_wise_report($user_session,$user_division,$user_compcode,$from1,$to1,"cronjob_download");
				$file_name_3 = "DRD-Chemist-wise-report.xls";
			}
			if($file_name1!="" || $file_name2!="" || $file_name3!="")
			{
				$url1 = $url2 = $url3 = "";
				$folder_dt = date('Y-m-d');
				if($file_name1){
					$file_name1_n = str_replace("email_files","corporate_report/".$folder_dt,$file_name1);
					$url1 = "https://drdweb.co.in/".$file_name1_n;
					$url1 = "<a href='".$url1."'>".$file_name_1."</a><br><br>";
				}
				if($file_name2){
					$file_name2_n = str_replace("email_files","corporate_report/".$folder_dt,$file_name2);
					$url2 = "https://drdweb.co.in/".$file_name2_n;
					$url2 = "<a href='".$url2."'>".$file_name_2."</a><br><br>";
				}
				if($file_name3){
					$file_name3_n = str_replace("email_files","corporate_report/".$folder_dt,$file_name3);
					$url3 = "https://drdweb.co.in/".$file_name3_n;
					$url3 = "<a href='".$url3."'>".$file_name_3."</a><br><br>";
				}
				$subject = "Daily Report (".$today_date.") ".ucwords(strtolower($company_full_name))." (".$user_division.")";
				$message = "Sir<br>It is the sales data as you have sought<br>";
				$message.= $url1;
				$message.= $url2;
				$message.= $url3;
				$message.= "Please download the file as in the links above for your reference.<br>Thanks and regards<br><br>D.R. Distributors Pvt Ltd<br>Notice & Disclaimer - This email and any files transmitted with it contain Proprietary, privileged and confidential information and/or information protected by intellectual property rights and is only for the use of the intended recipient of this message. If you are not the intended recipient, please delete or destroy this and all copies of this message along with the attachments immediately. You are hereby notified and directed that (1) if you are not the named and intended addressee you shall not disseminate, distribute or copy this e-mail, and (2) any offer for product/service shall be subject to a final evaluation of relevant patent status. Company cannot guarantee that e-mail communications are secure or error-free, as information could be intercepted, corrupted, amended, lost, destroyed, arrive late or incomplete, or may contain viruses. Company does not accept responsibility for any loss or damage arising from the use of this email or attachments.";
				//$message.= $row->memail;
				$email_id = $row->memail;
				
				
				/*$subject = base64_encode($subject);
				$message = base64_encode($message);	*/			
				
				$user_email_id 		= $email_id;
				$email_other_bcc 	= "";
				if($email_id=="")
				{
					$user_email_id 		= "application_OCT_2021@drdindia.com"; 
					//$email_other_bcc 	= "kapil707sharma@gmail.com";
				}
				
				/*$user_email_id 	 = "vipul@drdindia.com";
				$email_other_bcc = $email_id.",kapil707sharma@gmail.com"; 
				if($email_id=="")
				{
					$email_other_bcc 	= "kapil707sharma@gmail.com"; 
				}*/
				
				
				$email_function = "corporate_report";

				$date = date('Y-m-d');
				$time = date('H:i');
				
				$dt = array(
				'user_email_id'=>$user_email_id,
				'subject'=>$subject,
				'message'=>$message,
				'file_name1'=>$file_name1,
				'file_name_1'=>$file_name_1,
				'file_name2'=>$file_name2,
				'file_name_2'=>$file_name_2,
				'file_name3'=>$file_name3,
				'file_name_3'=>$file_name_3,
				'email_other_bcc'=>$email_other_bcc,
				'email_function'=>$email_function,
				'date'=>$date,
				'time'=>$time,
				);
				$this->Scheme_Model->insert_fun("tbl_email_send",$dt);
			}
			
			$this->db->query("update tbl_staffdetail_other set hourly='$hourly1',status2=1 where id='$id1'");
		}
	}
	
	public function Corporate_monthly_report_test($id=""){
		echo $this->Excel_Model->staff_download_stock_and_sales_analysis_month_html("080","00",$id,"2023-11-01","2023-11-30");
	}

	public function Corporate_monthly_report_test_download($id=""){
		echo $this->Excel_Model->staff_download_stock_and_sales_analysis_month("080","00",$id,"2023-05-01","2023-05-31","direct_download");
	}
	
	public function Corporate_monthly_report()
	{
		$time   = time();
		$hh 	= date("H",$time);
		$date 	= date();
		
		$yy 	= date('Y', strtotime("-1 days", $time));
		$mm 	= date('m', strtotime("-1 days", $time));
		$mm1 	= date('M', strtotime("-1 days", $time));
		$last 	= date('t', strtotime("-1 days", $time));
		$from 	= "$yy-$mm-01";
		$to 	= "$yy-$mm-$last";
		
		/***************************
		$from 	= "2023-06-01";
		$to 	= "2023-06-30";
		/***************************/
	
		$from1 	= $from;
		$to1 	= $to;
		
		$monthly_date = date('Y-m-d');		
		$today_date = "01 to $last-$mm1-$yy";
		/***************************
		$today_date = "01 to 30-Jun-2023";
		/***************************/
		$hourly1  = date("H", strtotime("+60 minutes", $time));
		$daily_date1  = date("Y-m-d", strtotime("+1 days", $time));

		$row = $this->db->query("select tbl_staffdetail.memail,stock_and_sales_analysis_daily_email,item_wise_report_monthly_email,chemist_wise_report_monthly_email,tbl_staffdetail_other.status,tbl_staffdetail.`compcode`,tbl_staffdetail.`company_full_name`,tbl_staffdetail.`division`,tbl_staffdetail.`id`,tbl_staffdetail_other.`id` as id1,tbl_staffdetail.`code` from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.code=tbl_staffdetail_other.code and tbl_staffdetail_other.daily_date='$monthly_date' and tbl_staffdetail_other.status2=0 limit 1")->row();		
		if($row->id!="")
		{			
			$user_session  = $row->id;
			$user_division = $row->division;
			$user_compcode = $row->compcode;
			$company_full_name = $row->company_full_name;
			
			$id1  = $row->id1;
			
			$file_name1 = $file_name2 = $file_name3 = "";
			$file_name_1 = $file_name_2 = $file_name_3 = "";
			if($row->stock_and_sales_analysis_daily_email=="1")
			{
				$file_name1  = $this->Excel_Model->staff_download_stock_and_sales_analysis_month($user_session,$user_division,$user_compcode,$from,$to,"cronjob_download");
				$file_name_1 = "DRD-Sales-and-stock-report.xls";
			}
			
			if($row->item_wise_report_monthly_email=="1")
			{
				$file_name2  = $this->Excel_Model->staff_download_item_wise_report($user_session,$user_division,$user_compcode,$from1,$to1,"cronjob_download");
				$file_name_2 = "DRD-Item-wise-report.xls";
			}
			
			if($row->chemist_wise_report_monthly_email=="1")
			{
				$file_name3  = $this->Excel_Model->staff_download_chemist_wise_report($user_session,$user_division,$user_compcode,$from1,$to1,"cronjob_download");
				$file_name_3 = "DRD-Chemist-wise-report.xls";
			}
			
			if($file_name1!="" || $file_name2!="" || $file_name3!="")
			{
				$url1 = $url2 = $url3 = "";
				$folder_dt = date('Y-m-d');
				if($file_name1){
					$file_name1_n = str_replace("email_files","corporate_report/".$folder_dt,$file_name1);
					$url1 = "https://drdweb.co.in/".$file_name1_n;
					$url1 = "<a href='".$url1."'>".$file_name_1."</a><br><br>";
				}
				if($file_name2){
					$file_name2_n = str_replace("email_files","corporate_report/".$folder_dt,$file_name2);
					$url2 = "https://drdweb.co.in/".$file_name2_n;
					$url2 = "<a href='".$url2."'>".$file_name_2."</a><br><br>";
				}
				if($file_name3){
					$file_name3_n = str_replace("email_files","corporate_report/".$folder_dt,$file_name3);
					$url3 = "https://drdweb.co.in/".$file_name3_n;
					$url3 = "<a href='".$url3."'>".$file_name_3."</a><br><br>";
				}
				$subject = "Monthly Report (".$today_date.") ".ucwords(strtolower($company_full_name))." (".$user_division.")";
				$message = "Sir<br>It is the sales data as you have sought<br>";
				$message.= $url1;
				$message.= $url2;
				$message.= $url3;
				$message.= "Please download the file as in the links above for your reference.<br>Thanks and regards<br><br>D.R. Distributors Pvt Ltd<br>Notice & Disclaimer - This email and any files transmitted with it contain Proprietary, privileged and confidential information and/or information protected by intellectual property rights and is only for the use of the intended recipient of this message. If you are not the intended recipient, please delete or destroy this and all copies of this message along with the attachments immediately. You are hereby notified and directed that (1) if you are not the named and intended addressee you shall not disseminate, distribute or copy this e-mail, and (2) any offer for product/service shall be subject to a final evaluation of relevant patent status. Company cannot guarantee that e-mail communications are secure or error-free, as information could be intercepted, corrupted, amended, lost, destroyed, arrive late or incomplete, or may contain viruses. Company does not accept responsibility for any loss or damage arising from the use of this email or attachments.";
				//$message.=$message_body;
				//$message.= $row->memail;
				$email_id = $row->memail;
				
				/*$subject = base64_encode($subject);
				$message = base64_encode($message);	*/			
				
				$user_email_id 		= $email_id;
				$email_other_bcc 	= "";
				if($email_id=="")
				{
					$user_email_id 		= "application_OCT_2021@drdindia.com"; 
					//$email_other_bcc 	= "kapil707sharma@gmail.com";
				}
				
				/*$user_email_id 	 = "vipul@drdindia.com";
				$email_other_bcc = $email_id.",kapil707sharma@gmail.com"; 
				if($email_id=="")
				{
					$email_other_bcc 	= "kapil707sharma@gmail.com"; 
				}*/
				
				$email_function = "corporate_report";

				$date = date('Y-m-d');
				$time = date('H:i');				
				
				$dt = array(
				'user_email_id'=>$user_email_id,
				'subject'=>$subject,
				'message'=>$message,
				'file_name1'=>$file_name1,
				'file_name_1'=>$file_name_1,
				'file_name2'=>$file_name2,
				'file_name_2'=>$file_name_2,
				'file_name3'=>$file_name3,
				'file_name_3'=>$file_name_3,
				'email_other_bcc'=>$email_other_bcc,
				'email_function'=>$email_function,
				'date'=>$date,
				'time'=>$time,
				);
				$this->Scheme_Model->insert_fun("tbl_email_send",$dt);
			}
			
			$this->db->query("update tbl_staffdetail_other set hourly='$hourly1',status2=1 where id='$id1'");
		}
	}
	
	public function corporate_whatsapp_report()
	{
		$time  	 	= time();
		$today_time = date("H:i",$time);
		
		$hourly   = date("H",$time);
		$hourly1  = date("H", strtotime("+60 minutes", $time));
		
		$today_date = date('Y-m-d');
		
		$result = $this->db->query("select tbl_staffdetail_other.whatsapp_message,tbl_staffdetail.staffname,tbl_staffdetail.mobilenumber,tbl_staffdetail_other.status,tbl_staffdetail.`compcode`,tbl_staffdetail.`company_full_name`,tbl_staffdetail.`division`,tbl_staffdetail.`id`,tbl_staffdetail_other.`id` as id1,tbl_staffdetail.`code` from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.code=tbl_staffdetail_other.code and tbl_staffdetail_other.hourly='$hourly' and tbl_staffdetail_other.whatsapp_message='1' limit 10")->result();
		foreach($result as $row)
		{
			$staffname= ucwords(strtolower($row->staffname));
			$compcode = $row->compcode;
			$division = $row->division;
			
			$mobile  		= "+91".$row->mobilenumber;
			$user_session  	= $row->id;
			$user_division 	= $row->division;
			$user_compcode 	= $row->compcode;
			$company_full_name = $row->company_full_name;
			
			$id1  = $row->id1;
			
			$result1 = $this->Corporate_Model->corporate_sales_report($compcode,$division,$today_date);
			$corporate_sales_report = "";
			$i =  1 ;
			$med_name = "";
			foreach($result1 as $row1)
			{
				if($med_name!=$row1->name)
				{
					$i =  1;
					$med_name=$row1->name;
					$corporate_sales_report.= "*".ucwords(strtolower($row1->name))."* Stock (".round($row1->clqty)."),Total Sales (".round($row1->total_sales).")\\n";
				}
				$corporate_sales_report.= $i++.". ".$row1->a_name." (".$row1->altercode.") (Sales : ".round($row1->qty).") \\nAddress :- $row1->address \\nMobile :- $row1->mobile \\n\\n";
			}
			
			$subject = "Hourly Sales Report (".$today_time.")";
			$whatsapp_message = "Hello $staffname\\n*".ucwords(strtolower($company_full_name))." (".$user_division.")*<br> ------------------------------------------------------ \\n$subject\\n ------------------------------------------------------ \\n$corporate_sales_report";
					
			//$mobile = "+919530005050";
			if($mobile == "+91")
			{
				$mobile = "+919530005050";
			}
			
			if($corporate_sales_report!="")
			{
				//$mobile = "+919530005050";
				$altercode = "";
				//$whatsapp_message = base64_encode($whatsapp_message);
				$this->Message_Model->insert_whatsapp_message($mobile,$whatsapp_message,$altercode);
			}
		
			$this->db->query("update tbl_staffdetail_other set hourly='$hourly1' where id='$id1'");
		}
	}
}