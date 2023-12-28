<?php
header("Content-type: application/json; charset=utf-8");
defined('BASEPATH') OR exit('No direct script access allowed');
class Corporate_api extends CI_Controller {
	
	public function test_ck()
	{
		print_r($this->Corporate_Model->test_ck());
	}
	
	public function baseck()
	{
		echo base64_encode("1118");
	}
	
	public function login()
	{
		$data = json_decode(file_get_contents('php://input'),true);
		$items1 = $data["items"];
		foreach($items1 as $ks)
		{
			$user_name1 	= ($ks["user_name1"]);
			$user_password 	= ($ks["user_password"]);
			
			$query = $this->db->query("select tbl_staffdetail.compcode,tbl_staffdetail.division,tbl_staffdetail.id,tbl_staffdetail.code,tbl_staffdetail.degn as name, tbl_staffdetail.mobilenumber as mobile,tbl_staffdetail.memail as email,tbl_staffdetail_other.status,tbl_staffdetail_other.exp_date,tbl_staffdetail_other.password from tbl_staffdetail left join tbl_staffdetail_other on tbl_staffdetail.code = tbl_staffdetail_other.code where tbl_staffdetail.memail='$user_name1' and tbl_staffdetail.code=tbl_staffdetail_other.code limit 1")->row();
			if ($query->id!="")
			{
				if ($query->password == $user_password)
				{
					if($query->status==1)
					{
						$user_session 	= 	$query->id;
						$user_fname		= 	ucwords(strtolower($query->name));
						$user_code	 	= 	$query->code;
						$user_altercode	= 	$query->code;
						$user_type 		= 	"corporate";
						$user_return 	= 	"1";
						$user_alert 	= 	"Logged in Successfully";
						$user_division	= 	$query->division;
						$user_compcode	= 	$query->compcode;
						$user_compname	= 	"";
					}
					else
					{
						$user_alert = "Access Denied";
					}
				}
				else
				{
					$user_alert = "Incorrect Password";
				}
			}
$items .= <<<EOD
{"user_session":"{$user_session}","user_fname":"{$user_fname}","user_code":"{$user_code}","user_altercode":"{$user_altercode}","user_type":"{$user_type}","user_password":"{$user_password}","user_alert":"{$user_alert}","user_return":"{$user_return}","user_division":"{$user_division}","user_compcode":"{$user_compcode}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
?>{"items":[<?= $items;?>]}<?php
	}

	public function item_wise_report_api()
	{
		//http://49.205.182.192:7272/drd_local_server/corporate_api/item_wise_report_api?user_session=MQ==&user_division=UzE=&user_compcode=ODUxOA==&formdate=2021-06-01&todate=2021-07-01

		$from 	= date("Y-m-d",strtotime($_GET["formdate"]));
		$to 	= date("Y-m-d",strtotime($_GET["todate"]));

		if($_GET["monthdate"]!="")
		{
			$date 	= date('Y-m');
			$year  	= date('Y');
			$date 	= "$year-{$_GET["monthdate"]}";
			$ts 	= strtotime($date);
			$from 	= date('Y-m-01',$ts);
			$to 	= date('Y-m-t',$ts);
		}
		$session	= base64_decode($_GET['user_session']);
		$division 	= base64_decode($_GET['user_division']);
		$compcode 	= base64_decode($_GET['user_compcode']);
		
		$row = $this->db->query("select item_wise_report,tbl_staffdetail_other.status from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.division='$division' and tbl_staffdetail.compcode='$compcode' and tbl_staffdetail.code=tbl_staffdetail_other.code and tbl_staffdetail.id='$session'")->row();
		$item_wise_report = $row->item_wise_report;
		$status = $row->status;
		if($item_wise_report=="1" && $status=="1")
		{			
			$query = $this->Corporate_Model->item_wise_report($division,$compcode,$from,$to);
			$i = 0;
			foreach ($query as $row)
			{				
				if($row->vtype=="SR")
				{
					$row->qty 		= 0 - $row->qty;
					$row->netamt 	= 0 - $row->netamt;
				}
				
				$netamt 		= $row->netamt;
				$c_name 		= $row->c_name;
				$c_address 		= $row->address;
				$c_mobile 		= $row->mobile;
				$c_id 			= $row->altercode;
					
				$c_name 		= base64_encode($c_name);
				$c_address		= base64_encode($c_address);
				$c_mobile		= base64_encode($c_mobile);
				$qty 			= round($row->qty);
				$fqty 			= round($row->fqty);
				$date			= date("d-M-Y", strtotime($row->vdt));
				
				$itemc 			= $row->itemc;
				$itc1 = $itemc;
				if($itc1!=$itc2)
				{
					$itc2 = $itc1;
					$name 			= base64_encode($row->name);
					$pack   		= base64_encode($row->pack);
					$stock   		= round($row->batchqty);
					
$items.= <<<EOD
{"itemc":"{$itemc}","name":"{$name}","pack":"{$pack}","stock":"{$stock}","c_id":"{$c_id}","c_name":"{$c_name}","c_address":"{$c_address}","c_mobile":"{$c_mobile}","qty":"{$qty}","fqty":"{$fqty}","netamt":"{$netamt}","date":"{$date}"},
EOD;
				}
				else{
$items.= <<<EOD
{"itemc":"{$itemc}","c_id":"{$c_id}","c_name":"{$c_name}","c_address":"{$c_address}","c_mobile":"{$c_mobile}","qty":"{$qty}","fqty":"{$fqty}","netamt":"{$netamt}","date":"{$date}"},
EOD;
				}

			}
		}
		else
		{
			$permission = "Please contact Vipul on 9899133989 and request access for the particular report.";
			$itemc = "xxxx";
$items.= <<<EOD
{"itemc":"{$itemc}","permission":"{$permission}"},
EOD;
		}

if ($items != ''){
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}
		<?php
	}
	
	public function chemist_wise_report_api()
	{
		error_reporting(0);		
		date_default_timezone_set('Asia/Kolkata');
		$from 	= date("Y-m-d",strtotime($_GET["formdate"]));
		$to 	= date("Y-m-d",strtotime($_GET["todate"]));

		if($_GET["monthdate"]!="")
		{
			$date 	= date('Y-m');
			$year  	= date('Y');
			$date 	= "$year-{$_GET["monthdate"]}";
			$ts 	= strtotime($date);
			$from 	= date('Y-m-01',$ts);
			$to 	= date('Y-m-t',$ts);
		}
		$session	= base64_decode($_GET['user_session']);
		$division 	= base64_decode($_GET['user_division']);
		$compcode 	= base64_decode($_GET['user_compcode']);
		
		$row = $this->db->query("select chemist_wise_report,tbl_staffdetail_other.status from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.division='$division' and tbl_staffdetail.compcode='$compcode' and tbl_staffdetail.code=tbl_staffdetail_other.code and tbl_staffdetail.id='$session'")->row();
		$chemist_wise_report = $row->chemist_wise_report;
		$status = $row->status;
		if($chemist_wise_report=="1" && $status=="1")
		{			
			$query = $this->Corporate_Model->chemist_wise_report($division,$compcode,$from,$to);
			$i = 0;
			foreach ($query as $row)
			{
				if($row->vtype=="SR")
				{
					$row->qty 		= 0 - $row->qty;
					$row->netamt 	= 0 - $row->netamt;
				}
				
				$netamt 		= $row->netamt;
				$c_id 			= $row->altercode;
				if($c_id=="")
				{
					$c_id = 0;
				}
					
				$c_name 		= base64_encode($row->c_name);
				$c_address		= base64_encode($row->address);
				$c_mobile		= base64_encode($row->mobile);
				$qty 			= round($row->qty);
				$fqty 			= round($row->fqty);
				$date			= date("d-M-Y", strtotime($row->vdt));
				
				$itemc 			= $row->itemc;
				$name 			= base64_encode($row->name);
				$pack   		= base64_encode($row->pack);
				$stock   		= round($row->batchqty);
			
$items.= <<<EOD
{"itemc":"{$itemc}","name":"{$name}","pack":"{$pack}","stock":"{$stock}","c_id":"{$c_id}","c_name":"{$c_name}","c_address":"{$c_address}","c_mobile":"{$c_mobile}","qty":"{$qty}","fqty":"{$fqty}","netamt":"{$netamt}","date":"{$date}"},
EOD;
			}
		}
		else
		{
			$permission = "Please contact Vipul on 9899133989 and request access for the particular report.";
			$itemc = "xxxx";
$items.= <<<EOD
{"itemc":"{$itemc}","permission":"{$permission}"},
EOD;
		}

if ($items != ''){
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}
		<?php
	}
	
	public function stock_and_sales_analysis_api()
	{
		error_reporting(0);
		$time 	= time();
		$year 	= date("Y",$time);
		$month 	= date("m",$time);	
		$d1 	= "01".date("-M-Y",$time);
		$d2 	= date("d-M-Y",$time);
		$vdt1 	= date("Y-m-",$time)."01";
		$vdt2 	= date("Y-m-d",$time);		
		
		$user_session	= base64_decode($_GET['user_session']);
		$user_division 	= base64_decode($_GET['user_division']);
		$user_compcode 	= base64_decode($_GET['user_compcode']);
		
		$row = $this->db->query("select stock_and_sales_analysis,tbl_staffdetail_other.status from tbl_staffdetail,tbl_staffdetail_other where tbl_staffdetail.division='$user_division' and tbl_staffdetail.compcode='$user_compcode' and tbl_staffdetail.code=tbl_staffdetail_other.code and tbl_staffdetail.id='$user_session'")->row();
		$stock_and_sales_analysis = $row->stock_and_sales_analysis;
		$status = $row->status;
		
		$stock_and_sales_analysis = "1";
		$status = "1";
		if($stock_and_sales_analysis=="1" && $status=="1")
		{
			$query = $this->Corporate_Model->stock_and_sales_analysis($user_division,$user_compcode,$vdt1,$vdt2);
			$i = 0;
			foreach ($query as $row)
			{
				$item_name 		= $row->name;	
				$packing 		= $row->pack;	
				$itemc 			= $row->code;
				$item_name 		= base64_encode($item_name);
				$packing 		= base64_encode($packing);				
				
				$opening		= round($row->TempOpqty);
				$closing1		= round($row->clqty);
				/*$row12 = $this->db->query("select * from tbl_sales_and_stock where i_code='$itemc'")->row();
				$opening = 0;
				if(round($row12->stock)>0)
				{
					$opening = round($row12->stock);
					$closing1 = round($row12->closing_stock);
				}*/
				$purchase 		= round($row->purchase);
				$sale 			= round($row->sale);	
				$sale_return 	= round($row->sale_return);
				$other1			= round($row->other1);
				$other2 		= round($row->other2);
				
				$total_other = 0;
				if($row->other1_1=="")
				{
					$row->other1_1 = 0;
				}
				
				if($row->other2_1=="")
				{
					$row->other2_1 = 0;
				}
				
				$other = 0;			
				if($other2!=0)
				{		
					$other 			= $other1 - $other2;
					$total_other 	= $row->other1_1;
				}
				else{
					$other 			= 0 - $other1;
					$total_other 	= 0 - $row->other1_1;
				}
				if($row->purchase1=="")
				{
					$row->purchase1 = 0;
				}
				$total_purchase = ($row->purchase1);	
				
				if($row->sale1=="")
				{
					$row->sale1 = 0;
				}
				$total_sale = ($row->sale1);
				
				if($row->sale_return1=="")
				{
					$row->sale_return1 = 0;
				}
				$total_sale_return = ($row->sale_return1);
				
				if($purchase=="")
				{
					$purchase = 0;
				}
				
				$closing 		= $closing1;
				$opening 		= ($closing1  + $sale);
				$opening 		= ($opening  - $purchase);
				$opening 		= ($opening  - $sale_return);
				$opening 		= ($opening  - $other);
				
				/* only for ek trik *
				$closing 		= $opening + $purchase + $sale_return;
				$closing 		= $closing - $sale;
				$closing 		= $closing + $other;
				/*****************/
				if($closing1=="0")
				{
					$closing 	= 0;
				}
				
				$total_opening = $opening * $row->prate;
				$total_closing = $closing * $row->prate;
				
				$permission = "";
$items.= <<<EOD
{"item_name":"{$item_name}","packing":"{$packing}","opening":"{$opening}","purchase":"{$purchase}","sale":"{$sale}","sale_return":"{$sale_return}","other":"{$other}","closing":"{$closing}","total_opening":"{$total_opening}","total_purchase":"{$total_purchase}","total_sale":"{$total_sale}","total_sale_return":"{$total_sale_return}","total_other":"{$total_other}","total_closing":"{$total_closing}","permission":"{$permission}"},
EOD;
			}
		}
		else
		{
			$permission = "Please contact Vipul on 9899133989 and request access for the particular report.";
$items.= <<<EOD
{"permission":"{$permission}"},
EOD;
		}

if ($items != ''){
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}
		<?php
	}
	
	public function staff_download_item_wise_report($user_session,$user_division,$user_compcode,$formdate,$todate)
	{
		error_reporting(0);
		$user_session  = base64_decode($user_session);
		$user_division = base64_decode($user_division);
		$user_compcode = base64_decode($user_compcode);
		$from 	= date("Y-m-d",strtotime($formdate));
		$to 	= date("Y-m-d",strtotime($todate));		
		
		$this->Excel_Model->staff_download_item_wise_report($user_session,$user_division,$user_compcode,$from,$to,"direct_download");
	}
	
	public function staff_download_item_wise_report_month($user_session,$user_division,$user_compcode,$monthdate)
	{
		error_reporting(0);
		$user_session  = base64_decode($user_session);
		$user_division = base64_decode($user_division);
		$user_compcode = base64_decode($user_compcode);
		
		$date 	= date('Y-m');
		$year  	= date('Y');
		$date 	= "$year-{$monthdate}";
		$ts 	= strtotime($date);
		$from 	= date('Y-m-01',$ts);
		$to 	= date('Y-m-t',$ts);
		
		$this->Excel_Model->staff_download_item_wise_report($user_session,$user_division,$user_compcode,$from,$to,"direct_download");
	}
	
	public function staff_download_chemist_wise_report($user_session,$user_division,$user_compcode,$formdate,$todate)
	{
		error_reporting(0);
		$user_session  = base64_decode($user_session);
		$user_division = base64_decode($user_division);
		$user_compcode = base64_decode($user_compcode);
		$from 	= date("Y-m-d",strtotime($formdate));
		$to 	= date("Y-m-d",strtotime($todate));		
		
		$this->Excel_Model->staff_download_chemist_wise_report($user_session,$user_division,$user_compcode,$from,$to,"direct_download");
	}
	
	public function staff_download_chemist_wise_report_month($user_session,$user_division,$user_compcode,$monthdate)
	{
		error_reporting(0);
		$user_session  = base64_decode($user_session);
		$user_division = base64_decode($user_division);
		$user_compcode = base64_decode($user_compcode);
		
		$date 	= date('Y-m');
		$year  	= date('Y');
		$date 	= "$year-{$monthdate}";
		$ts 	= strtotime($date);
		$from 	= date('Y-m-01',$ts);
		$to 	= date('Y-m-t',$ts);		
		
		$this->Excel_Model->staff_download_chemist_wise_report($user_session,$user_division,$user_compcode,$from,$to,"direct_download");
	}
	
	public function staff_download_stock_and_sales_analysis($user_session,$user_division,$user_compcode)
	{
		error_reporting(0);
		$user_session  = base64_decode($user_session);
		$user_division = base64_decode($user_division);
		$user_compcode = base64_decode($user_compcode);		
		
		$monthdate = date('m');
		$date 	= date('Y-m');
		$year  	= date('Y');
		$date 	= "$year-{$monthdate}";
		$ts 	= strtotime($date);
		$from 	= date('Y-m-01',$ts);
		$to 	= date('Y-m-t',$ts);		
		
		$this->Excel_Model->staff_download_stock_and_sales_analysis($user_session,$user_division,$user_compcode,$from,$to,"direct_download");
	}
}