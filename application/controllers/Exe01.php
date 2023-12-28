<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');
ini_set('max_execution_time', 36000);
require_once APPPATH."/third_party/PHPExcel.php";
class Exe01 extends CI_Controller 
{
	function new_clean($string)
	{
		$k = str_replace('\n', '<br>', $string);
		$k = preg_replace('/[^A-Za-z0-9\#]/', ' ', $k);
		return $k;
		//return preg_replace('/[^A-Za-z0-9\#]/', '', $string); // Removes special chars.
	}
	
	function remove_backslash($str)
	{
		$str = preg_replace('/\\\\/i', '/', $str);
		$str = str_replace('/\/', '/', $str);
		$str = str_replace('\\', '/', $str);
		return $str;
	}
	
	public function download_query_for_local_server()
	{
		$isdone	= "";
		$data 	= json_decode(file_get_contents('php://input'), true);
        $items 	= $data["items"];
		foreach ($items as $row) {
			if (!empty($row["query_type"])) {
				
				if ($row["query_type"] == "company_discount") {
					
					$compcode 		= $row["compcode"];
					$division 		= $row["division"];
					$discount 		= $row["discount"];
					$status 		= $row["status"];
					
					$dt = array(
						'compcode'=>$compcode,
						'division'=>$division,
						'discount'=>$discount,
						'status'=>$status,
					);
					$row1 = $this->db->query("select compcode from tbl_company_discount where compcode='" . $compcode . "' order by id desc")->row();
					if (empty($row1->compcode)) {
						$this->Scheme_Model->insert_fun("tbl_company_discount", $dt);
					} else {
						$where = array('compcode' => $compcode);
						$this->Scheme_Model->edit_fun("tbl_company_discount", $dt, $where);
					}
					$isdone = "yes";
				}

				if ($row["query_type"] == "order_download") {

					$online_id 		= $row["online_id"];
					$order_id 		= $row["order_id"];
					$i_code			= $row["i_code"];
					$item_code 		= $row["item_code"];
					$quantity 		= $row["quantity"];
					$user_type 		= $row["user_type"];
					$chemist_id 	= $row["chemist_id"];
					$salesman_id 	= $row["salesman_id"];
					$acno 			= $row["acno"];
					$slcd 			= $row["slcd"];
					$sale_rate 		= $row["sale_rate"];
					$remarks 		= base64_decode($row["remarks"]);
					$date 			= $row["date"];
					$time 			= $row["time"];
					$total_line 	= $row["total_line"];
					$temp_rec 		= $row["temp_rec"];
					$new_temp_rec 	= $row["new_temp_rec"];
					$order_status 	= $row["order_status"];

					$dt = array(
						'online_id'=>$online_id,
						'order_id'=>$order_id,
						'i_code'=>$i_code,
						'item_code'=>$item_code,
						'quantity'=>$quantity,
						'sale_rate'=>$sale_rate,
						'user_type'=>$user_type,
						'chemist_id'=>$chemist_id,
						'salesman_id'=>$salesman_id,
						'acno'=>$acno,
						'slcd'=>$slcd,
						'remarks'=>$remarks,
						'date'=>$date,
						'time'=>$time,
						'total_line'=>$total_line,
						'temp_rec'=>$temp_rec,
						'new_temp_rec'=>$new_temp_rec,
						'order_status'=>$order_status,
						'gstvno'=>'',
					);
					$row1 = $this->db->query("select online_id from tbl_order_download where online_id='" . $online_id . "' order by id desc")->row();
					if (empty($row1->online_id)) {
						$this->Scheme_Model->insert_fun("tbl_order_download", $dt);
					} else {
						$where = array('online_id' => $online_id);
						$this->Scheme_Model->edit_fun("tbl_order_download", $dt, $where);
					}
					$isdone = "yes";
				}

				if ($row["query_type"] == "medicine_image") {
					$itemid 	= $row["itemid"];
					$featured 	= $row["featured"];
					$image 		= $row["image"];
					$image2 	= $row["image2"];
					$image3 	= $row["image3"];
					$image4 	= $row["image4"];
					$title 		= $row["title"];
					$description= $row["description"];
					$status 	= $row["status"];
					$date 		= $row["date"];
					$time 		= $row["time"];

					$title = base64_decode($title);
					$description = base64_decode($description);

					$dt = array(
						'itemid'=>$itemid,
						'featured'=>$featured,
						'image'=>$image,
						'image2'=>$image2,
						'image3'=>$image3,
						'image4'=>$image4,
						'title'=>$title,
						'description'=>$description,
						'status'=>$status,
						'date'=>$date,
						'time'=>$time,
					);

					if (!empty($itemid)) {
						$row1 = $this->db->query("select itemid from tbl_medicine_image where itemid='" . $itemid . "' order by id desc")->row();
						if (empty($row1->itemid)) {
							$this->Scheme_Model->insert_fun("tbl_medicine_image", $dt);
						} else {
							$where = array('itemid' => $itemid);
							$this->Scheme_Model->edit_fun("tbl_medicine_image", $dt, $where);
						}
						$isdone = "yes";
					}
				}

				if ($row["query_type"] == "acm_other") {

					$code 			= $row["code"];
					$status 		= $row["status"];
					$exp_date 		= $row["exp_date"];
					$password 		= $row["password"];
					$broadcast 		= $row["broadcast"];
					$block 			= $row["block"];
					$image 			= $row["image"];
					$user_phone 	= $row["user_phone"];
					$user_email 	= $row["user_email"];
					$user_address 	= $row["user_address"];
					$user_update 	= $row["user_update"];
					$order_limit 	= $row["order_limit"];
					$new_request 	= $row["new_request"];
					$website_limit 	= $row["website_limit"];
					$android_limit 	= $row["android_limit"];

					$user_address 	= base64_decode($user_address);

					$dt = array(
						'code'=>$code,
						'status'=>$status,
						'exp_date'=>$exp_date,
						'password'=>$password,
						'broadcast'=>$broadcast,
						'image'=>$image,
						'block'=>$block,
						'user_phone'=>$user_phone,
						'user_email'=>$user_email,
						'user_address'=>$user_address,
						'user_update'=>$user_update,
						'order_limit'=>$order_limit,
						'new_request'=>$new_request,
						'website_limit'=>$website_limit,
						'android_limit'=>$android_limit,
					);

					if (!empty($row["code"])) {
						$row1 = $this->db->query("select code from tbl_acm_other where code='" . $code . "' order by id desc")->row();
						if (empty($row1->code)) {
							$this->Scheme_Model->insert_fun("tbl_acm_other", $dt);
						} else {
							$where = array('code'=>$code);
							$this->Scheme_Model->edit_fun("tbl_acm_other", $dt, $where);
						}
						$isdone = "yes";
					}
				}

				if ($row["query_type"] == "staffdetail_other") {

					$code 				= $row["code"];
					$status 			= $row["status"];
					$password 			= $row["password"];
					$daily_date 		= $row["daily_date"];
					$monthly 			= $row["monthly"];
					$whatsapp_message 	= $row["whatsapp_message"];
					$item_wise_report 	= $row["item_wise_report"];
					$chemist_wise_report= $row["chemist_wise_report"];
					$stock_and_sales_analysis = $row["stock_and_sales_analysis"];
					$item_wise_report_daily_email = $row["item_wise_report_daily_email"];
					$chemist_wise_report_daily_email = $row["chemist_wise_report_daily_email"];
					$stock_and_sales_analysis_daily_email = $row["stock_and_sales_analysis_daily_email"];
					$item_wise_report_monthly_email = $row["item_wise_report_monthly_email"];
					$chemist_wise_report_monthly_email = $row["chemist_wise_report_monthly_email"];

					$dt = array(
						'code'=>$code,
						'status'=>$status,
						'password'=>$password,
						'daily_date'=>$daily_date,
						'monthly'=>$monthly,
						'whatsapp_message'=>$whatsapp_message,
						'item_wise_report'=>$item_wise_report,
						'chemist_wise_report'=>$chemist_wise_report,
						'stock_and_sales_analysis'=>$stock_and_sales_analysis,
						'item_wise_report_daily_email'=>$item_wise_report_daily_email,	'chemist_wise_report_daily_email'=>$chemist_wise_report_daily_email,
						'stock_and_sales_analysis_daily_email'=>$stock_and_sales_analysis_daily_email,
						'item_wise_report_monthly_email'=>$item_wise_report_monthly_email,
						'chemist_wise_report_monthly_email'=>$chemist_wise_report_monthly_email,
						'status2'=>1,
					);

					if (!empty($row["code"])) {
						$row1 = $this->db->query("select code from tbl_staffdetail_other where code='" . $code . "' order by id desc")->row();
						if (empty($row1->code)) {
							$this->Scheme_Model->insert_fun("tbl_staffdetail_other", $dt);
						} else {
							$where = array('code'=>$code);
							$this->Scheme_Model->edit_fun("tbl_staffdetail_other", $dt, $where);
						}
						$isdone = "yes";
					}
				}
				
				if ($row["query_type"] == "staffdetail_other_update") {

					$code 				= $row["code"];
					$status2 			= $row["status2"];
					
					$dt = array(
						'code'=>$code,
						'status2'=>0,
					);
					
					$where = array('code'=>$code);
					$this->Scheme_Model->edit_fun("tbl_staffdetail_other", $dt, $where);
					$isdone = "yes";
				}

				if ($row["query_type"] == "low_stock_alert") {

					$vdt 	= $row["vdt"];
					$acno 	= $row["acno"];
					$slcd 	= $row["slcd"];
					$itemc 	= $row["itemc"];
					$uid 	= $row["uid"];

					$this->Drd_Order_Model->insert_shortage($vdt, $acno, $slcd, $itemc, $uid);
					$isdone = "yes";
				}
			}
		}

		if($isdone=="yes")
		{
			echo "done";
		}
	}

	/*************order download*************/
	public function download_order_in_sever()
	{		
		$parmiter = '';

		$curl = curl_init();

		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL =>'https://drdweb.co.in/exe01/exe02/download_order_in_sever',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 0,
				CURLOPT_TIMEOUT => 300,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $parmiter,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
				),
			)
		);

		$response = curl_exec($curl);
		curl_close($curl);
		$response1 = json_decode($response);
		foreach($response1->items as $items){
			$order_id 		= $items->order_id;
			$chemist_id 	= $items->chemist_id;
			$salesman_id 	= $items->salesman_id;
			$acno 			= $items->acno;
			$slcd 			= $items->slcd;
			$user_type 		= $items->user_type;
			$remarks 		= $items->remarks;
			$date 			= $items->date;
			$time 			= $items->time;
			$total_line 	= $items->total_line;
			$temp_rec 		= $items->temp_rec;
			$new_temp_rec 	= $items->new_temp_rec;
			$order_status 	= $items->order_status;
		}
		//print_r($response1->items_lines);
		foreach($response1->items_lines as $items_lines){
			$online_id 	= $items_lines->online_id;
			$i_code 	= $items_lines->i_code;
			$item_code 	= $items_lines->item_code;
			$quantity 	= $items_lines->quantity;
			$sale_rate 	= $items_lines->sale_rate;
			
			$dt = array(
				'order_id'=>$order_id,
				'chemist_id'=>$chemist_id,
				'salesman_id'=>$salesman_id,
				'user_type'=>$user_type,
				'acno'=>$acno,
				'slcd'=>$slcd,
				'remarks'=>$remarks,
				'date'=>$date,
				'time'=>$time,
				'total_line'=>$total_line,
				'temp_rec'=>$temp_rec,
				'new_temp_rec'=>$new_temp_rec,
				'order_status'=>$order_status,
				
				'online_id'=>$online_id,
				'i_code'=>$i_code,
				'item_code'=>$item_code,
				'quantity'=>$quantity,
				'sale_rate'=>$sale_rate,
				
				
				'gstvno'=>'',
			);
			$row1 = $this->db->query("select online_id from tbl_order_download where online_id='" . $online_id . "' order by id desc")->row();
			if (empty($row1->online_id)) {
				$this->Scheme_Model->insert_fun("tbl_order_download", $dt);
			} else {
				$where = array('online_id' => $online_id);
				$this->Scheme_Model->edit_fun("tbl_order_download", $dt, $where);
			}
		}
		if(!empty($order_id)){
			echo $items ='{"order_id":"'.$order_id.'"}';

			$curl1 = curl_init();
			$parmiter = '{"items": ['.$items.']}';
			curl_setopt_array(
			$curl1,
				array(
					CURLOPT_URL => 'https://drdweb.co.in/exe01/exe02/download_order_status_update',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 0,
					CURLOPT_TIMEOUT => 300,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $parmiter,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json',
					),
				)
			);

			$response = curl_exec($curl1);
			print_r($response);
			curl_close($curl1);
		}
	}
	public function order_process()
	{
		$this->insert_order_to_eseysol();
		$this->check_order_to_gstvno_update();
		$this->upload_order_to_gstvno(); 
	}
	
	public function order_error_download()
	{
		$curl = curl_init();
		$parmiter = '';
		curl_setopt_array(
		$curl,
			array(
				CURLOPT_URL => 'https://drdweb.co.in/exe01/exe02/order_error_download',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 0,
				CURLOPT_TIMEOUT => 120,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $parmiter,
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
				),
			)
		);

		$response = curl_exec($curl);
		curl_close($curl);
		
		$response1 = json_decode($response);
		foreach($response1 as $row){
			if (trim($row->order_id) != "") {
				$order_id = trim($row->order_id);
				$dt = array(
						'order_id'=>$order_id,
						);
				$this->Scheme_Model->insert_fun("tbl_order_error", $dt);
			}
		}
	}
	
	public function order_error_delete(){
		$this->db->query("TRUNCATE TABLE tbl_order_error");
	}
	
	public function redownload_order_reset(){
		$this->db->query("update tbl_order_error set status=0");
	}
	
	public function redownload_order(){
		
		$row = $this->db->query("select DISTINCT(order_id) from tbl_order_error where status='0' order by id asc limit 1")->row();
		if (!empty($row->order_id)) {
			$order_id = $row->order_id;
			
			//---------------------------------------------
			$message = "Re-download Order No. *".$order_id;
			//---------------------------------------------
			
			$row1 = $this->db->query("SELECT * FROM `tbl_order_download` WHERE `order_id`='$order_id'")->row();
			if (empty($row1->order_id)) {
				$uid = "DRD-".$row->order_id;
				echo $PorderCount_yes_no = $this->Drd_Order_Model->get_order_PorderCount($uid);
				echo "--";
				echo $Porder_yes_no = $this->Drd_Order_Model->get_order_Porder($uid);
				echo "<br>";
				if (empty($PorderCount_yes_no) && empty($Porder_yes_no))
				{
					
					//---------------------------------------------
										
					$group_message = $group2_message = $message;

					$whatsapp_group = "919899333989-1567708298@g.us";
					$this->Message_Model->insert_whatsapp_group_message($whatsapp_group, $group_message);

					$whatsapp_group2 = "919899333989-1628519476@g.us";
					$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2, $group2_message);

					$items ='{"order_id":"'.$order_id.'"}';

					$curl = curl_init();
					$parmiter = '{"items": ['.$items.']}';
					curl_setopt_array(
					$curl,
						array(
							CURLOPT_URL => 'https://drdweb.co.in/exe01/exe02/download_order_again',
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_ENCODING => '',
							CURLOPT_MAXREDIRS => 0,
							CURLOPT_TIMEOUT => 120,
							CURLOPT_FOLLOWLOCATION => true,
							CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
							CURLOPT_CUSTOMREQUEST => 'POST',
							CURLOPT_POSTFIELDS => $parmiter,
							CURLOPT_HTTPHEADER => array(
								'Content-Type: application/json',
							),
						)
					);

					$response = curl_exec($curl);

					curl_close($curl);
					echo $response;
					
					if($response==$order_id)
					{
						$this->db->query("update tbl_order_error set status='1' where order_id='$order_id'");
					}
				}else{
					$this->db->query("update tbl_order_error set status='1' where order_id='$order_id'");
				}
			} else {
				//$this->db->query("delete from tbl_order_error where status='1 and order_id='$order_id'");
				$this->db->query("update tbl_order_error set status='1' where order_id='$order_id'");
			}
		}
	}
	
	public function insert_order_to_eseysol()
	{
		echo "work--- ";
		$row0 = $this->db->query("select DISTINCT(temp_rec) from tbl_order_download where order_status=0 order by id asc limit 1")->row();
		if (!empty($row0->temp_rec)) {
			$temp_rec = $row0->temp_rec;
		}
		if (!empty($temp_rec)) {
			$row = $this->db->query("select total_line,count(id) as ct,order_id from tbl_order_download where temp_rec='$temp_rec'")->row();
			if ($row->ct == $row->total_line) {				
				$this->insert_order_to_eseysol_with_id($temp_rec);
			}else{
			
					$order_id = $row->order_id;
					$this->db->query("delete from tbl_order_download where order_id='$order_id'");
					
					$dt = array(
							'order_id'=>$order_id,
							);
					$this->Scheme_Model->insert_fun("tbl_order_error", $dt);
				/*

				if ($row->total_line>$row->ct) {
					$message = "Process order again ".$order_id;
					$group_message = $group2_message = $message;

					$whatsapp_group = "919899333989-1567708298@g.us";
					$this->Message_Model->insert_whatsapp_group_message($whatsapp_group, $group_message);

					$whatsapp_group2 = "919899333989-1628519476@g.us";
					$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2, $group2_message);
				} */
			}
		}
	}

	public function insert_order_to_eseysol_with_id($temp_rec='') {
		
		$row = $this->db->query("select order_id,new_temp_rec,date,time,chemist_id,remarks,acno,slcd from tbl_order_download where temp_rec='".$temp_rec."' limit 1")->row();
		
		$order_id 		= $row->order_id;
		$uid 			= "DRD-".$order_id;
		$PorderCount_yes_no = $this->Drd_Order_Model->get_order_PorderCount($uid);
		if (empty($PorderCount_yes_no)) {
			if (!empty($order_id)) {
					
				/*************************************/
				$order_no = $this->Drd_Order_Model->get_PorderCount_ordno();
				/*************************************/

				/********************************* */
				echo $message = "This Order No. *" . $order_id . "* downloaded and inserted to easysol properly. Easysol Order No. *" . $order_no . "*";

				if (!empty($remarks)) {
					$message = $message . " Remarks : " . $remarks;
				}

				$group_message = $group2_message = $message;

				$whatsapp_group = "919899333989-1567708298@g.us";
				$this->Message_Model->insert_whatsapp_group_message($whatsapp_group, $group_message);

				$whatsapp_group2 = "919899333989-1628519476@g.us";
				$this->Message_Model->insert_whatsapp_group_message($whatsapp_group2, $group2_message);

				/****************************************************** */

				$date	 	= $row->date;
				$time 		= $row->time;
				$remarks 	= $row->remarks;
				$acno 		= $row->acno;
				$slcd 		= $row->slcd;
				
				if(empty($acno)){
					$v = $this->Drd_Order_Model->get_order_acm($row->chemist_id);
					$acno = $v["acno"];
					$slcd = $v["slcd"];
				}

				$ordtype 	= "DRD";
				$odt 		= $date; //get_today_date();
				$mtime 		= $time; //get_now_time();
				$downloaddate = $date; //get_today_date();
				$dayenddate = $date; //get_today_date();

				/********************************************/
				$this->Drd_Order_Model->insert_order_PorderCount($order_no, $uid, $odt, $acno, $ordtype, $mtime, $downloaddate, $dayenddate, $remarks);
				/********************************************/

			}
		} else {
			$order_no = $PorderCount_yes_no; // order no ata ha jab dubara order add honay lagta ha to oss time
		}
		$Porder_yes_no = $this->Drd_Order_Model->get_order_Porder($uid);
		if (empty($Porder_yes_no)) {
			if (!empty($order_id)) {
				$result = $this->db->query("select * from tbl_order_download where order_id='$order_id'")->result();
				foreach ($result as $row) {
					
					$date = $row->date;
					$time = $row->time;
					
					$odt 		= $date; //get_today_date();
					$mtime 		= $time; //get_now_time();
					$downloaddate = $date; //get_today_date();
					$dayenddate = $date; //get_today_date();
					
					$itemc 		= $row->i_code;
					$qty 		= $row->quantity;
					$mrp 		= $row->sale_rate;
					$id 		= $row->id;
					$acno 		= $row->acno;
					$slcd 		= $row->slcd;
					$remarks 	= $row->remarks;
					
					if(empty($acno)){
						$v = $this->Drd_Order_Model->get_order_acm($row->chemist_id);
						$acno = $v["acno"];
						$slcd = $v["slcd"];
					}

					/********************************************/
					$this->Drd_Order_Model->insert_order_Porder($slcd, $acno, $odt, $itemc, $qty, $order_no, $uid, $mtime, $mrp, $remarks);
					/********************************************/

					/********************************************/
					$this->db->query("update tbl_order_download set order_status='1',ordno_new='$order_no' where order_status='0' and id='$id'");
					/********************************************/
				}
			}
		}
		if (!empty($PorderCount_yes_no) && !empty($Porder_yes_no)) {
			
			/********************************************/
			$this->db->query("update tbl_order_download set order_status='1',ordno_new='$order_no' where order_status='0' and order_id='$order_id'");
			/********************************************/
			
			$dt = array(
						'order_id'=>$order_id,
						);
			$this->Scheme_Model->insert_fun("tbl_order_error", $dt);
		}
	}

	public function check_order_to_gstvno_update()
	{
		$result = $this->db->query("SELECT DISTINCT ordno_new from tbl_order_download where order_status='1' and gstvno='' ORDER BY RAND() limit 200")->result();
		foreach($result as $row){
			$ordno_new 	= $row->ordno_new;
			$result1 	= $this->Drd_Order_Model->get_gstvno_in_pordercount($ordno_new);
			if(!empty($result1)){
				foreach($result1 as $row1){
					echo $tag 		= $row1->tag;
					$purvtype 	= $row1->purvtype;
					$purvno 	= $row1->purvno;
					$purvdt 	= $row1->purvdt;
					echo "<Br>";
					if ($tag == "Y") {
						$result2 = $this->Drd_Order_Model->get_gstvno_in_salepurchase($ordno_new, $purvtype,$purvno,$purvdt);
						foreach($result2 as $row2) {
							echo $gstvno 	= $row2->gstvno;
							echo "<br>";
							$this->db->query("update tbl_order_download set order_status='2',gstvno='$gstvno' where order_status='1' and ordno_new='$ordno_new'");
						}
					}elseif ($tag == "D") {
						//jab order nahi insert to hua esey sol me but delete kar diya to yha chalay ge
						echo $gstvno = "0000";
						echo "<br>";
						$this->db->query("update tbl_order_download set order_status='2',gstvno='$gstvno' where order_status='1' and ordno_new='$ordno_new'");
					}
				}
			}
			/*else {
				echo $gstvno = "000000";
				echo "<br>";
				$this->db->query("update tbl_order_download set order_status='2',gstvno='$gstvno' where order_status='1' and ordno_new='$ordno_new'");
			}*/			
		}
	}
	
	public function upload_order_to_gstvno()
	{
		$items = "";
		$qry   = "";
		$result = $this->db->query("SELECT DISTINCT ordno_new,order_id from tbl_order_download where order_status='2' and gstvno!='' group by ordno_new,order_id ORDER BY id limit 10")->result();
		foreach($result as $row){
			$gstvno 	= $row->ordno_new;
			$order_id 	= $row->order_id;
			
			$items .= '{"gstvno":"'.$gstvno.'","order_id":"'.$order_id.'"},';
	
			$qry.= "update tbl_order_download set order_status=3 where order_id='$order_id';";
		}
		
		if (!empty($items)) {

			if ($items != '') {
				$items = substr($items, 0, -1);
			}
			echo $parmiter = '{"items": [' . $items . ']}';

			$curl = curl_init();

			curl_setopt_array(
				$curl,
				array(
					CURLOPT_URL =>'https://drdweb.co.in/exe01/exe02/upload_order_to_gstvno',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 0,
					CURLOPT_TIMEOUT => 120,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $parmiter,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json',
					),
				)
			);

			$response = curl_exec($curl);
			curl_close($curl);
			echo $response;
			if ($response == "done") {
				$arr = explode(";", $qry);
				foreach ($arr as $row_q) {
					if ($row_q != "") {
						//echo $row_q;
						$this->db->query("$row_q");
					}
				}
			}
		}
	}
	
	public function upload_medicine($topi=250)
	{
		//header("Content-type: application/json; charset=utf-8");
		$items 	= "";
		$result = $this->Drd_Order_Model->get_medicine($topi);
		foreach($result as $row) {
			
			//$thisid = $row->code;
			$i_code = $row->code;
			$item_code = $row->item_code;
			$item_name = $this->remove_backslash(htmlspecialchars(trim($row->item_name)));
			$title = $this->remove_backslash(htmlspecialchars(trim($row->TrimName)));
			$packing = htmlspecialchars($row->packing);
			$expiry = $row->Expiry;
			if ($expiry == "NULL")
			{
				$expiry = "";
			}
			$batch_no = $row->Batch; //RemoveSpecialChars(sdr.GetValue(5).ToString());
			if ($batch_no == "NULL" || $batch_no == "")
			{
				$batch_no = "";
			}
			
			$batchqty = $row->batchqty; //(sdr.GetValue(6).ToString());
			if ($batchqty == "NULL" || $batchqty == "")
			{
				$batchqty = "0.000";
			}
			$salescm1 = $row->salescm1; //(sdr.GetValue(7).ToString());
			if ($salescm1 == "NULL" || $salescm1 == "")
			{
				$salescm1 = "0";
			}
			$salescm2 = $row->salescm2; //(sdr.GetValue(8).ToString());
			if ($salescm2 == "NULL" || $salescm2 == "")
			{
				$salescm2 = "0";
			}
			$sale_rate = $row->sale_rate; //(sdr.GetValue(9).ToString());
			if ($sale_rate == "NULL" || $sale_rate == "")
			{
				$sale_rate = "0";
			}
			$mrp = $row->mrp; //(sdr.GetValue(10).ToString());
			if ($mrp == "NULL" || $mrp == "")
			{
				$mrp = "0";
			}
			$costrate1 = $row->Costrate; //(sdr.GetValue(11).ToString());
			if ($costrate1 == "NULL" || $costrate1 == "")
			{
				$costrate1 = "0";
			}
			$costrate = floatval($costrate1);//float.Parse(costrate1.ToString());

			$compcode = $row->compcode; //(sdr.GetValue(12).ToString());
			$comp_altercode = $row->company_alter; //(sdr.GetValue(13).ToString());
			$company_name = $row->company_name; //(sdr.GetValue(14).ToString());
			$company_full_name = $row->company_full_name; //(sdr.GetValue(15).ToString());
			$division = $row->division; //(sdr.GetValue(16).ToString());

			$qscm = $row->QScm; //(sdr.GetValue(17).ToString());
			$hscm = $row->Hscm; //(sdr.GetValue(18).ToString());
			$misc_settings = $row->MiscSettings; //(sdr.GetValue(19).ToString());

			$item_date = $row->Vdt; //(sdr.GetValue(20).ToString());
			//$item_date = ParseDateTime(item_date);
			$itemcat = $row->ItemCat; //int.Parse(sdr.GetValue(21).ToString());
			$gstper = $row->IGST; //decimal.Parse(sdr.GetValue(22).ToString());
			$itemjoinid = $row->NoteBook; //(sdr.GetValue(23).ToString());
			//itemjoinid = itemjoinid.Trim();

			if ($row->salescm1 == "")
			{
				$s1 = "0";
			}
			else
			{
				$s1 = $row->salescm1;
			}
			if ($row->salescm2 == "")
			{
				$s2 = "0";
			}
			else
			{
				$s1 = $row->salescm2;
			}
			
			$present = ($s1) / ($s2) * 100;
			if ($present=="")
			{
				$present = 0;
			}


			/************new code by 2021-06-22*******/
			$row1 = $this->db->query("select discount from tbl_company_discount where compcode='$compcode' and status='1'")->row();
			if(empty($row1->discount))
			{
				$discount = "4.5";
			}else{
				$discount = $row1->discount;
			}
			
			$sale_rate0 = ($sale_rate);
			$final_price0 = $sale_rate0 * $discount / 100;
			$final_price0 = $sale_rate0 - $final_price0;
			$gstper0 = $gstper;
			$final_price = $final_price0 * $gstper0 / 100;
			$final_price = $final_price0 + $final_price;
			

			$mrp0 = ($mrp);
			$margin = $mrp0 - $final_price;
			$margin = $margin / $mrp0;
			$margin = $margin * 100;

			/******************************************/
			$medicine_image = $this->get_medicine_image($i_code);
			if($medicine_image[0]=="0"){
				$featured = 0;
			}else{
				$featured = $medicine_image[0];
			}
			$image1 = $medicine_image[1];
			$image2 = $medicine_image[2];
			$image3 = $medicine_image[3];
			$image4 = $medicine_image[4];
			$title2 = $medicine_image[5];
			$description = $medicine_image[6];
			/******************************************/
			
			
			$time = date("h:m t");
			$index1 = substr($item_name, 0, 1);
			if ($index1 == ".")
			{
				$status = "0";
			}
			else
			{
				$status = "1";
			}
			$itemjoinid = $this->remove_backslash(htmlspecialchars(trim($itemjoinid)));
			$title2 = $this->remove_backslash(htmlspecialchars(trim($title2)));
			$description = $this->remove_backslash(htmlspecialchars(trim($description)));
			
			$itemjoinid = base64_encode($itemjoinid);
			$title2 = base64_encode($title2);
			$description = base64_encode($description);
			
			$items .= '{"i_code":"'.$i_code.'","item_code":"'.$item_code.'","item_name":"'.$item_name.'","title":"'.$title.'","packing":"'.$packing.'","expiry":"'.$expiry.'","batch_no":"'.$batch_no.'","batchqty":"'.$batchqty.'","salescm1":"'.$salescm1.'","salescm2":"'.$salescm2.'","sale_rate":"'.$sale_rate.'","mrp":"'.$mrp.'","final_price":"'.$final_price.'","costrate":"'.$costrate.'","margin":"'.$margin.'","compcode":"'.$compcode.'","comp_altercode":"'.$comp_altercode.'","company_name":"'.$company_name.'","company_full_name":"'.$company_full_name.'","division":"'.$division.'","qscm":"'.$qscm.'","hscm":"'.$hscm.'","misc_settings":"'.$misc_settings.'","item_date":"'.$item_date.'","itemcat":"'.$itemcat.'","gstper":"'.$gstper.'","itemjoinid":"'.$itemjoinid.'","present":"'.$present.'","featured":"'.$featured.'","discount":"'.$discount.'","image1":"'.$image1.'","image2":"'.$image2.'","image3":"'.$image3.'","image4":"'.$image4.'","title2":"'.$title2.'","description":"'.$description.'","time":"'.$time.'","status":"'.$status.'"},';
		}	

		if (!empty($items)) {

			if ($items != '') {
				$items = substr($items, 0, -1);
			}
			echo $parmiter = '{"items": [' . $items . ']}';

			$curl = curl_init();

			curl_setopt_array(
				$curl,
				array(
					CURLOPT_URL =>'https://drdweb.co.in/exe01/exe02/upload_medicine',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 0,
					CURLOPT_TIMEOUT => 180,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $parmiter,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json',
					),
				)
			);

			$response = curl_exec($curl);
			curl_close($curl);
			$response1 = json_decode($response);
			print_r($response1);
			if (trim($response1->isdone) == "done") {
				$i_code = trim($response1->i_code);
				echo $qry = "update tbl_id set thisid='$i_code' where checktype='update_medicine_test'";
				$this->db->query($qry);
			}
		}
	}
	
	function get_medicine_image($i_code)
	{
		$row = $this->db->query("select * from tbl_med_info where i_code='$i_code' order by id desc")->row();
		if(!empty($row))
		{
			$medicine_image[0] = "0";
			$medicine_image[1] = "medicine_images/".$row->table_name."/".$row->img1;
			$medicine_image[2] = "medicine_images/".$row->table_name."/".$row->img2;
			$medicine_image[3] = "medicine_images/".$row->table_name."/".$row->img3;
			$medicine_image[4] = "medicine_images/".$row->table_name."/".$row->img4;
			if (empty($row->img1))
			{
				$medicine_image[1] = "";
			}
			if (empty($row->img2))
			{
				$medicine_image[2] = "";
			}
			if (empty($row->img3))
			{
				$medicine_image[3] = "";
			}
			if (empty($row->img4))
			{
				$medicine_image[4] = "";
			}
			$medicine_image[5] = $row->a1;
			$medicine_image[6] = $row->a5;
		}
		
		//------------------------------------------------------------
		$row = $this->db->query("select * from tbl_medicine_image_scraping where i_code='$i_code' order by id desc")->row();
		if(!empty($row))
		{
			$medicine_image[0] = $row->featured;
			$medicine_image[1] = $row->image1;
			if ($row->update_image1==1)
			{
				$medicine_image[1] = "uploads/manage_image_scraping/photo/resize/".$row->image1;
			}
			$medicine_image[2] = $row->image2;
			if ($row->update_image2==1)
			{
				$medicine_image[2] = "uploads/manage_image_scraping/photo/resize/".$row->image2;
			}
			$medicine_image[3] = $row->image3;
			if ($row->update_image3==1)
			{
				$medicine_image[3] = "uploads/manage_image_scraping/photo/resize/".$row->image3;
			}
			$medicine_image[4] = $row->image4;
			if ($row->update_image4==1)
			{
				$medicine_image[4] = "uploads/manage_image_scraping/photo/resize/".$row->image4;
			}

			if ($row->image1 == "new_pix/")
			{
				$medicine_image[1] = "";
			}
			if ($row->image2 == "new_pix/")
			{
				$medicine_image[2] = "";
			}
			if ($row->image3 == "new_pix/")
			{
				$medicine_image[3] = "";
			}
			if ($row->image4 == "new_pix/")
			{
				$medicine_image[4] = "";
			}
			$medicine_image[5] = $row->itemintro1;
			$medicine_image[6] = $row->itemintro2;
		}
		
		//------------------------------------------------------------
		$row = $this->db->query("select * from tbl_medicine_image where itemid='$i_code' and status='1' order by id desc")->row();
		if(!empty($row))
		{
			$medicine_image[0] = $row->featured;
            $medicine_image[1] = "uploads/manage_medicine_image/photo/resize/".$row->image;
            $medicine_image[2] = "uploads/manage_medicine_image/photo/resize/".$row->image2;
            $medicine_image[3] = "uploads/manage_medicine_image/photo/resize/".$row->image3;
            $medicine_image[4] = "uploads/manage_medicine_image/photo/resize/".$row->image4;
			if (empty($row->image))
			{
				$medicine_image[1] = "";
			}
			if (empty($row->image2))
			{
				$medicine_image[2] = "";
			}
			if (empty($row->image3))
			{
				$medicine_image[3] = "";
			}
			if (empty($row->image4))
			{
				$medicine_image[4] = "";
			}
			$medicine_image[5] = $row->title;
			$medicine_image[6] = $row->description;
		}
		
		return $medicine_image;
	}
	
	public function upload_chemist($topi=100)
	{
		$items 	= "";
		$result = $this->Drd_Order_Model->get_chemist($topi);
		foreach($result as $row) {
		
			$code 		= trim($row->code);
            $altercode 	= trim($row->altercode);
            $groupcode 	= trim($row->groupcode);
            $name 		= $this->remove_backslash(htmlspecialchars(trim($row->name)));
            $type 		= trim($row->type);
            $trimname	= $this->remove_backslash(htmlspecialchars(trim($row->trimname)));
			$address 	= $this->remove_backslash(htmlspecialchars(trim($row->address)));
			$address1 	= $this->remove_backslash(htmlspecialchars(trim($row->address1)));
			$address2 	= $this->remove_backslash(htmlspecialchars(trim($row->address2)));
			$address3 	= $this->remove_backslash(htmlspecialchars(trim($row->address3)));
			$telephone 	= $this->remove_backslash(htmlspecialchars(trim($row->telephone)));
			$telephone1 = $this->remove_backslash(htmlspecialchars(trim($row->telephone1)));

			$mobile 	= $this->remove_backslash(htmlspecialchars(trim($row->mobile)));
			$email 		= $this->remove_backslash(htmlspecialchars(trim($row->email)));
			$gstno 		= $this->remove_backslash(htmlspecialchars(trim($row->gstno)));
			$status 	= trim($row->status);
			$statecode 	= trim($row->statecode);

            $invexport 	= trim($row->invexport);
            $slcd 		= trim($row->slcd);
			
			$items .= '{"code":"'.$code.'","altercode":"'.$altercode.'","groupcode":"'.$groupcode.'","name":"'.$name.'","type":"'.$type.'","trimname":"'.$trimname.'","address":"'.$address.'","address1":"'.$address1.'","address2":"'.$address2.'","address3":"'.$address3.'","telephone":"'.$telephone.'","telephone1":"'.$telephone1.'","mobile":"'.$mobile.'","email":"'.$email.'","gstno":"'.$gstno.'","status":"'.$status.'","statecode":"'.$statecode.'","invexport":"'.$invexport.'","slcd":"'.$slcd.'"},';
		}	

		if (!empty($items)) {

			if ($items != '') {
				$items = substr($items, 0, -1);
			}
			echo $parmiter = '{"items": [' . $items . ']}';
			
			$curl = curl_init();

			curl_setopt_array(
				$curl,
				array(
					CURLOPT_URL =>'https://drdweb.co.in/exe01/exe02/upload_chemist',
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_ENCODING => '',
					CURLOPT_MAXREDIRS => 0,
					CURLOPT_TIMEOUT => 180,
					CURLOPT_FOLLOWLOCATION => true,
					CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
					CURLOPT_CUSTOMREQUEST => 'POST',
					CURLOPT_POSTFIELDS => $parmiter,
					CURLOPT_HTTPHEADER => array(
						'Content-Type: application/json',
					),
				)
			);

			$response = curl_exec($curl);
			curl_close($curl);
			$response1 = json_decode($response);
			print_r($response1);
			if (trim($response1->isdone) == "done") {
				$code = trim($response1->code);
				echo $qry = "update tbl_id set thisid='$code' where checktype='update_chemist_test'";
				$this->db->query($qry);
			}
		}
	}
}