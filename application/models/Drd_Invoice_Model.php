<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','512M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv
class Drd_Invoice_Model extends CI_Model  
{
	var $mssql;
    function __construct()
    {
        parent::__construct();
        $this->mssql = $this->load->database ( 'my_mssql', TRUE );
    }

    public function test_ck(){
       //use $this->mssql instead of $this->db
       $query = $this->mssql->query('select * from acm')->row();
	   return $query;
       //...
    }

    function get_some_mysql_rows(){
       //use  $this->db for default 
       $query = $this->db->query('select * from mysql_table');
       //...
    }
	
	function test000021()
	{
		$result = $this->mssql->query("select top 500 acm.name,Salepurchase1.adjinv,Salepurchase1.Vtyp,Salepurchase1.vno,Salepurchase1.amt,Salepurchase1.vdt,Salepurchase1.gstvno,Salepurchase1.acno from Salepurchase1 join acm on acm.code = Salepurchase1.Acno where Salepurchase1.Vtyp ='pb' and Salepurchase1.vdt>='2021-04-01'  and Salepurchase1.vdt<'2022-04-01' order by Salepurchase1.vno")->result();
		?><table border='1'><?php
		foreach($result as $row)
		{
			?><tr>
			<td>
			<?= $row->name;?>
			</td>
			<td>
			<?= $row->Vtyp;?> / <?= $row->vno;?>
			</td>
			<td>
			<?= $row->gstvno;?>
			</td>
			<td>
			<?= $row->vdt;?>
			</td>
			<td>
			<?= $row->amt;?>
			</td>
			<?php
			$result1 = $this->mssql->query("select * from RcptPymt where acno='$row->acno' and RcptPymt.AdjInv like '%$row->gstvno%'")->result();
			foreach($result1 as $row1)
			{
				?>
				<td>
				<?= $row1->vtype;?> / 
				<?= $row1->vno;?>
				</td>
				<td>
				<?= $row1->chqno;?>
				</td>
				<td>
				<?= $row1->vdt;?>
				</td>
				
				<td>
				<?= $row1->Amt;?>
				</td>
				<?php
			}
			?>
			</tr>
			<?php
		}
		?>
		</table>
		<?php
	}
	public function test_invoice(){
		$this->create_invoice_excle("554355","email_yes");
	}
	
	public function invoice_copy_db_to_db(){
		
		$mycode = 0;
		$row = $this->db->query("select vno from tbl_invoice order by id desc limit 1")->row();
		if($row->vno!="")
		{
			$mycode = $row->vno;
		}
		
		$vdt_ck = date("Y-m-d");
		$where = "sle.vdt='$vdt_ck'";
		if ($mycode != 0)
		{
			$newdtd = date("Y") - 1 ."-04-01";
			if(date("m")>=4){
				$newdtd = date("Y")."-04-01";
			}
			$where = "sle.vno>'$mycode' and sle.vdt>='$newdtd'";
		}
		
		$result = $this->mssql->query("select top 100 sle.vdt,sle.vno,sle.pickedby,sle.checkedby,sle.deliverby,sle.vtype,sl.acno,sl.amt,sl.gstvno,a.name,a.email,a.altercode,a.mobile,sl.taxamt,a.address from Salepurchase1Extra as sle, Salepurchase1 as sl,acm as a where $where and (sle.Vtype='SB' or sle.Vtype='SR') and a.code=sl.acno and sl.Vno=sle.Vno and sl.vdt=sle.vdt order by sle.vno")->result();
		foreach($result as $row)
		{
			$vdt = $row->vdt;
			$vno = $row->vno;
			$pickedby = "";// $row->pickedby;
			$checkedby = ""; // $row->checkedby;
			$deliverby = ""; // yha other query say add hota ha
			$vtype = $row->vtype;
			$date = date("Y-m-d");
			$acno = $row->acno;
			$amt = $row->amt;
			$gstvno = $row->gstvno;
			$name = $row->name;
			$email_id = $row->email;
			$chemist_id = $row->altercode;
			$mobile = $row->mobile;
			$taxamt = $row->taxamt;
			$address = $row->address;			
			
			$insert_query = "insert into tbl_invoice (vdt,vno,pickedby,checkedby,deliverby,vtype,date,acno,amt,gstvno,name,email_id,chemist_id,mobile,taxamt,address) values ('$vdt','$vno','$pickedby','$checkedby','$deliverby','$vtype','$date','$acno','$amt','$gstvno','$name','$email_id','$chemist_id','$mobile','$taxamt','$address')";
			
			$this->db->query($insert_query);
		}
	}
	
	public function invoice_check_pickedby_checkedby(){
	
		$date = date("Y-m-d");
		$vno_ck = "";
		$result = $this->db->query("SELECT vno FROM `tbl_invoice` WHERE pickedby='' and checkedby='' and deliverby='' and status=0 ORDER BY RAND() limit 100")->result();
		foreach($result as $row)
		{
			if(!empty($row->vno)){
				$vno = $row->vno;
				$vno_ck.= " sl.vno='$vno' or";
			}
		}
		if($vno_ck!="")
		{
			$vno_ck = substr($vno_ck, 0, -2);
				
			$result = $this->mssql->query("select sl.vdt,sl.vno,pickedby,checkedby,deliverby,vtype,s2.gstvno,a.altercode,a.name,a.mobile,s2.acno,s2.amt from salepurchase1extra as sl,salepurchase1 as s2,acm as a where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and sl.vdt='$date' and ($vno_ck)")->result();
			foreach($result as $row)
			{
				echo $pickedby 	= $row->pickedby;
				$checkedby 	= $row->checkedby;
				$deliverby 	= $row->deliverby;
				$gstvno 	= $row->gstvno;
				$vno        = $row->vno;
				$altercode 	= $row->altercode;
				$acno 		= $row->acno;
				$name 		= $row->name;
				$amt 		= round($row->amt,2);
				$mobile 	= "+91".$row->mobile;
				if($pickedby!="" && $checkedby!="")
				{
					$this->db->query("update tbl_invoice set pickedby='$pickedby',checkedby='$checkedby',amt='$amt' where gstvno='$gstvno' and vno='$vno'");
				}
			}
		}
	}
	
	public function invoice_whatsapp_or_excel_create(){
		
		$date = date("Y-m-d");
		/*$date = "2021-07-30";
		$vno = "177937";*/
		//"SELECT * FROM `tbl_invoice_test` WHERE vno = '$vno' ORDER BY id asc limit 1"
		$row = $this->db->query("SELECT * FROM `tbl_invoice` WHERE `date`='$date' and `status`=0 and  pickedby!='' and checkedby!='' ORDER BY id asc limit 1")->row();
		if($row->vdt!="")
		{
			$vdt 		= $row->vdt;
			$vno 		= $row->vno;
			$gstvno 	= $row->gstvno;
			$u_name 	= $row->name;
			$chemist_id = $row->chemist_id;
			$mobile 	= "+91".$row->mobile;
			$amt 		= round($row->amt,2);
			$email_id 	= $row->email_id;
			$newdate 	= strtotime($row->vdt);
			$newdate 	= date('d-M-Y',$newdate);

			$this->db->query("update tbl_invoice set `status`=1 where id='$row->id'");
				
			$whatsapp_message_delete = $this->create_invoice_excle($row->id,"email_no");	
			

			/***************************whtsapp message *************************/	
			$link = "https://www.drdistributor.com/invoice/$chemist_id/$gstvno";
			$download_link = "https://www.drdistributor.com/user/download_invoice1/$chemist_id/$gstvno";
			$android_link = "https://play.google.com/store/apps/details?id=com.drdistributor.dr";
			$website_link = "https://www.drdistributor.com";
			$android_img  = "https://www.drdistributor.com/img_v50/google_play.png";			
			
			$whatsapp_message = "Hello <br>$u_name ($chemist_id), <br><br>Invoice No. *$gstvno* for order dated $newdate of the value around *Rs.$amt/-* has been generated by *D.R. Distributors Pvt. Ltd.*. <br>$whatsapp_message_delete <br><br>You can check your invoice by clicking on <br>$link<br><br>You can download your invoice by clicking on <br>$download_link <br><br>On laptop or pc you can visit following link to start placing orders : <br> $website_link <br><br>Please download our app from Google play store : <br><br><a href='$android_link'><img src='$android_img' width='150px' height='50px'/></a><br><br>";
			
			$message = $whatsapp_message;
			$title   = "Invoice No. ".$gstvno." has been generated";
			$this->Message_Model->insert_notification("5",$title,$message,$chemist_id,"chemist");
			//$mobile = "+919530005050";
			if($mobile != "+91")
			{
				$altercode = $chemist_id;
				//$whatsapp_message = base64_encode($whatsapp_message);
				$this->Message_Model->insert_whatsapp_message($mobile,$whatsapp_message,$altercode);
			}			
		}
	}	
	
	public function create_invoice_excle($id="",$email_send="")
	{
		$row = $this->db->query("SELECT * FROM `tbl_invoice` WHERE `id`='$id' ORDER BY id asc limit 1")->row();
		if($row->vdt!="")
		{
			$vdt 		= $row->vdt;
			$vno 		= $row->vno;
			$gstvno 	= $row->gstvno;
			$u_name 	= $row->name;
			$chemist_id = $row->chemist_id;
			$mobile 	= "+91".$row->mobile;
			$amt 		= $row->amt;
			$email_id 	= $row->email_id;
			$newdate 	= strtotime($row->vdt);
			$newdate 	= date('d-M-Y',$newdate);
		
			$file_name1  	= $file_name2  	= $file_name3  	= "";
			$file_name_1  	= $file_name_2  = $file_name_3  = "";
			
			$whatsapp_message_delete = "<br>All items in your order have been billed *without any shortage*";
			$delete_message = "<br>All items in your order have been billed <b>without any shortage</b>";
			$delete_query = $this->create_delete_invoice_query($vdt,$vno);
			$delete_query2 = $this->create_delete_invoice_query2($vdt,$vno);
			if(!empty($delete_query) || !empty($delete_query2))
			{
				$this->db->query("update tbl_invoice set `delete_status`=1 where id='$row->id'");
				
				$dt = $this->Excel_Model->create_delete_invoice_excle($gstvno,$delete_query,$delete_query2,"cronjob_download");
				if($dt[1]){
					$delete_message = $dt[1];
					$whatsapp_message_delete = $dt[2];
				}
				
				$file_name2  = $dt[0];
				$file_name_2 = "delete_".$gstvno.".xls";
			}
				
			$file_name_dt  = $this->Excel_Model->create_invoice_excle($vdt,$vno,$gstvno,$u_name,$chemist_id,"cronjob_download");
			$file_name1 = $file_name_dt[0];
			$file_name_1 = $gstvno.".xls";
			$invoice_message_body = $file_name_dt[1]; 
			if($file_name_dt!="")
			{
				$link = "https://www.drdistributor.com/invoice/$chemist_id/$gstvno";
				$download_link = "https://www.drdistributor.com/user/download_invoice1/$chemist_id/$gstvno";
				$android_link = "https://play.google.com/store/apps/details?id=com.drdistributor.dr";
				$website_link = "https://www.drdistributor.com";
				$android_img  = "https://www.drdistributor.com/img_v50/google_play.png";
				
				$subject = "Invoice No. $gstvno From D.R. Distributors Pvt. Ltd.";
				$message = "Hi $u_name ($chemist_id),<br><br>Invoice No. <b>$gstvno</b> for Order dated $newdate of the value around <b>Rs.$amt/-</b> has been generated by <b>D.R. Distributors Pvt. Ltd.</b>.<br><br>Please find the list of Items processed.<br><br>$invoice_message_body.$delete_message <br><br>You can check your invoice by clicking on <a href='$link'>$link</a><br><br>You can download your invoice by clicking on <a href='$download_link'>$download_link</a><br><br>On laptop or pc you can visit following link to start placing orders : $website_link <br><br>Please download our app from Google play store : <br><br><a href='$android_link'><img src='$android_img' width='150px' height='50px'/></a><br><br>Please find the attatchment with this email.";
				//$message.= $row->memail;
				
				/*$subject = base64_encode($subject);
				$message = base64_encode($message);*/
				
				$user_email_id 		= $email_id;
				$email_other_bcc 	= "";
				if($email_id=="")
				{
					$user_email_id 		= "application_OCT_2021@drdindia.com"; 
					//$email_other_bcc 	= "kapil707sharma@gmail.com";
				}
				
				if($email_send=="email_yes"){
				
					$email_function = "invoice";

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
				return $whatsapp_message_delete;
			}
		}
	}
	
	public function invoice_out_for_delivery(){
		
		//status 2 exe say update hota ha jab invoice upload ho jati ha to
		$date = date("Y-m-d");
		$vno_ck = "";
		$result = $this->db->query("SELECT vno,deliverby FROM `tbl_invoice` WHERE pickedby!='' and checkedby!='' and deliverby='' and status=2 ORDER BY RAND() limit 100")->result();
		foreach($result as $row)
		{
			if(!empty($row->vno)){
				$vno = $row->vno;
				$vno_ck.= " sl.vno='$vno' or";
			}
		}
		if($vno_ck!="")
		{
			$vno_ck = substr($vno_ck, 0, -2);
						
			$result = $this->mssql->query("select sl.vdt,sl.vno,pickedby,checkedby,deliverby,vtype,s2.gstvno,a.altercode,a.name,a.mobile,s2.acno,s2.amt from salepurchase1extra as sl,salepurchase1 as s2,acm as a where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and sl.vdt='$date' and ($vno_ck)")->result();
			foreach($result as $row)
			{
				$pickedby 	= $row->pickedby;
				$checkedby 	= $row->checkedby;
				$deliverby 	= $row->deliverby;
				$gstvno 	= $row->gstvno;
				$vno        = $row->vno;
				$altercode 	= $row->altercode;
				$acno 		= $row->acno;
				$name 		= $row->name;
				$amt 		= round($row->amt,2);
				$mobile 	= "+91".$row->mobile;
				if($deliverby!="")
				{	
					$vdt 		= strtotime($row->vdt);
					$newdate 	= date('d-M-Y',$vdt);
					$newdate1 	= date('Y-m-d',$vdt);
					$time_o   	= date('d-M-Y H:i');
					
					$row1 = $this->db->query("SELECT * from tbl_deliverby where vdt='$newdate1' and gstvno='$gstvno' and vno='$vno'")->row();
					if(empty($row1->id))
					{
						$this->db->query("update tbl_invoice set pickedby='$pickedby',checkedby='$checkedby',deliverby='$deliverby',out_for_delivery='$time_o',out_for_delivery_status='1',amt='$amt' where gstvno='$gstvno' and vno='$vno'");
					
					
						//upload_invoice yha dubara invoice upload karwata ha 
						$this->db->query("update tbl_invoice set status=3 where gstvno='$gstvno' and vno='$vno'");
						
						$row2 = $this->db->query("select id from tbl_invoice where status=3 and gstvno='$gstvno' and vno='$vno'")->row();
						if($row2){
							$this->create_invoice_excle($row2->id,"email_yes");
						}
					
						$this->db->query("insert into tbl_deliverby (gstvno,vdt,deliverby,vno,acno,chemist_id,deliverby_altercode,amt) values ('$gstvno','$newdate1','$deliverby','$vno','$acno','$altercode','$deliverby','$amt')");

						$url_link = "https://drdistributor.com/invoice/".$altercode."/".$gstvno;
						$download_link = "https://drdistributor.com/user/download_invoice1/".$altercode."/".$gstvno;
						$android_link = "https://rb.gy/xo2qlk";
						$website_link = "https://drdistributor.com";

						$whatsapp_message = "Hello $name ($altercode)<br><br>Invoice No. *$gstvno*  for your Order Placed on $newdate of the value around $amt/- has been generated and the packet is *out for delivery* with one of our delivery executives.<br><br>The order will reach you soon.<br>Regards <br>*D.R. Distributors Pvt. Ltd.*<br><br>You can check your invoice by clicking on $url_link<br><br>You can download your invoice by clicking on $download_link <br><br>On laptop or pc you can visit following link to start placing orders : $website_link <br><br>Please download our app from Google play store : $android_link";
						$message = $whatsapp_message;
						$title   = "Invoice No. ".$gstvno." out for delivery";
						$this->Message_Model->insert_notification("5",$title,$message,$altercode,"chemist");
						//$mobile = "+919782664507";
						if($mobile != "+91")
						{
							$media = "6569e5b3de7b8a7661b77cad";
							//$whatsapp_message = base64_encode($whatsapp_message);
							$this->Message_Model->insert_whatsapp_message($mobile,$whatsapp_message,$altercode,$media);
						}
					}
				}
			}
		}
	}
	
	public function create_invoice_query($vdt='',$vno=''){
		if($vdt!='' && $vno!='')
		{
			$result = $this->mssql->query("select sl.vno,sl.vdt,sl.psrlno,sl.itemc,sl.batch,sl.qty,sl.fqty,sl.ntrate,sl.ftrate,sl.taxamt,sl.dis,sl.disamt,sl.netamt,sl.halfp,sl.mrp,sl.hsncode,sl.expiry,sl.scm1,sl.scm2,sl.scmper,sl.localcent,sl.excise,sl.cgst,sl.sgst,sl.igst,sl.adnlvat,sl.gdn,itm.compcode,itm.division,itm.name as item_name,itm.barcode as item_code,itm.pack as packing,itm.escode,sl.vtype,cmp.name as company_full_name from salepurchase2 as sl,item as itm left join company as cmp on cmp.code = itm.compcode where sl.vdt='$vdt' and sl.vno='$vno' and (sl.vtype='sb' or sl.vtype='sr') and sl.itemc = itm.code order by srlno asc")->result();
			return $result;
		}
	}
	
	public function create_delete_invoice_query($vdt='',$vno=''){
		if($vdt!='' && $vno!='')
		{
			$result = $this->mssql->query("select itemc,item.name as item_name,sp.vno,sp.vdt,slcd,amt,namt,remarks,descp from spalter as sp ,item where sp.vdt='$vdt' and vno='$vno' and (vtype='sb' or vtype='sr') and (descp='qty.change' or descp='item delete') and item.code=sp.itemc")->result();
			return $result;
		}
	}
	
	public function create_delete_invoice_query2($vdt='',$vno=''){
		if($vdt!='' && $vno!='')
		{
			$result = $this->mssql->query("select pordercount.odt as vdt,pordercount.purvno as vno,porder.itemc,item.name as item_name,porder.slcd,porder.qty as amt from pordercount,porder,item where pordercount.odt='$vdt' and pordercount.purvno='$vno' and pordercount.ordno = porder.ordno and porder.purvno='0' and item.code=porder.itemc")->result();
			return $result;
		}
	}
	
	public function total_invoice($value=''){
		$date = date("Y-m-d");
		if($value=="pickedby")
		{
			$value = "and pickedby=''";
		}
		if($value=="!pickedby")
		{
			$value = "and pickedby!=''";
		}
		if($value=="deliverby")
		{
			$value = "and deliverby='' and pickedby!=''";
		}
		if($value=="!deliverby")
		{
			$value = "and deliverby!='' and pickedby!=''";
		}
		$row = $this->mssql->query("select count(vdt) as total from salepurchase1extra where vdt='$date' $value")->row();
		return $row->total;
	}
	
	public function today_invoice_to_show($get,$value=""){
		$date = date("Y-m-d");
		if($value=="pickedby")
		{
			$value = "and pickedby=''";
		}
		if($value=="deliverby")
		{
			$value = "and deliverby='' and pickedby!=''";
		}
		
		if($get["invoice_no"]!="")
		{
			$value.= " and s2.gstvno='".$get["invoice_no"]."'";
		}
		
		if($get["location"]!="")
		{
			$value.= " and ms.altercode='".$get["location"]."'";
		}
		
		if($get["customer"]!="")
		{
			$value.= " and (a.altercode='".$get["customer"]."' or a.name like '%".$get["customer"]."%')";
		}
		
		if($get["pickedby"]!="")
		{
			$value.= " and pickedby like '%".$get["pickedby"]."%'";
		}
		
		if($get["deliverby"]!="")
		{
			$value.= " and deliverby like '%".$get["deliverby"]."%'";
		}
		
		$result = $this->mssql->query("select s2.personalmsg,mtime,ms.altercode as scode,sl.vdt,sl.vno,pickedby,checkedby,deliverby,vtype,s2.gstvno,a.altercode,a.name,a.mobile,dispatchtime from salepurchase1extra as sl,salepurchase1 as s2,acm as a,master as ms where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and ms.code=a.mstate and ms.slcd='st'and sl.vdt='$date' $value order by ms.altercode asc")->result();
		return $result;
	}
	
	public function check_order_sahi_insert_hoa_kya_nahi(){
		$row = $this->db->query("select distinct order_id,ordno_new from `tbl_order` where gstvno='' and ordno_new!='' ORDER BY RAND()")->row();
		if($row->order_id!="")
		{
			$uid = "drd-".$row->order_id;
			$ordno = $row->ordno_new;
			$row1 = $this->mssql->query("select ordno from pordercount where uid='$uid' and ordno='$ordno'")->row();
			if($row1->ordno=="")
			{
				echo $uid;
				echo "<br>";
				echo $row1->ordno;
				
				$json_url = constant('base_url2')."exe01/exe01/download_order_reset2/".$row->order_id;
				$ch = curl_init($json_url);
				$options = array(
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_HTTPHEADER => array('Content-type: application/json'),
				);
				curl_setopt_array($ch,$options);
				$result = curl_exec($ch);
				//print_r($result);
				if($result=="ok")
				{
					$this->db->query("delete from tbl_order where order_id=$row->order_id");
				}
			}
		}
	}
	
	public function delivery_report($get){
		$date = date("Y-m-d");
		$where = "and sl.vdt='$date' ";
		if($get["from"]!="")
		{
			$date  = $get["from"];
			$where = "and sl.vdt>='$date' ";
		}
		if($get["to"]!="")
		{
			$date  = $get["to"];
			$where.= "and sl.vdt<='$date' ";
		}
		$result = $this->mssql->query("select sl.tagno,s2.amt,s2.personalmsg,mtime,ms.altercode as scode,sl.vdt,sl.vno,pickedby,checkedby,deliverby,vtype,s2.gstvno,a.altercode,a.name,a.mobile,dispatchtime from salepurchase1extra as sl,salepurchase1 as s2,acm as a,master as ms where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and ms.code=a.mstate and ms.slcd='st' $where order by sl.tagno asc")->result();
		return $result;
	}
	
	public function delivery_report_view($tagno="",$date=""){
		//$date = date("Y-m-d");
		$result = $this->mssql->query("select sl.tagno,s2.amt,s2.personalmsg,mtime,ms.altercode as scode,sl.vdt,sl.vno,pickedby,checkedby,deliverby,vtype,s2.gstvno,a.altercode,a.name,a.mobile,dispatchtime from salepurchase1extra as sl,salepurchase1 as s2,acm as a,master as ms where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and ms.code=a.mstate and ms.slcd='st'and sl.vdt='$date' and sl.tagno='$tagno' order by sl.tagno asc")->result();
		return $result;
	}
	
	public function drd_live_report($elements){
		
		$date = date("Y-m-d");
		/*$result = $this->mssql->query("select sl.tagno,s2.amt,s2.personalmsg,mtime,ms.altercode as scode,sl.vdt,sl.vno,pickedby,checkedby,deliverby,vtype,s2.gstvno,a.altercode,a.name,a.mobile,dispatchtime from salepurchase1extra as sl,salepurchase1 as s2,acm as a,master as ms where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and ms.code=a.mstate and ms.slcd='st'and sl.vdt='$date' and ms.altercode like '$elements%' order by ms.altercode asc")->result();*/
		
		$result = $this->mssql->query("select DISTINCT(ms.altercode) as scode from salepurchase1extra as sl,salepurchase1 as s2,acm as a,master as ms where sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and ms.code=a.mstate and ms.slcd='st'and sl.vdt='$date' order by ms.altercode asc")->result();
		return $result;
	}
	
	public function drd_live_report2($altercode,$value){
		
		$value = "$value ='' ";
		
		$date = date("Y-m-d");
		$result = $this->mssql->query("select sl.tagno,s2.amt,s2.personalmsg,mtime,ms.altercode as scode,sl.vdt,sl.vno,pickedby,checkedby,deliverby,vtype,s2.gstvno,a.altercode,a.name,a.mobile,dispatchtime from salepurchase1extra as sl,salepurchase1 as s2,acm as a,master as ms where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and ms.code=a.mstate and ms.slcd='st'and sl.vdt='$date' and ms.altercode = '$altercode' and $value order by s2.gstvno asc,altercode asc")->result();
		return $result;
	}
	
	public function drd_report_not_pickedby_whatsapp(){
		
		$date = date("Y-m-d");
		$result = $this->mssql->query("select top 25 mtime,s2.gstvno,a.altercode,s2.amt from salepurchase1extra as sl,salepurchase1 as s2,acm as a,master as ms where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and ms.code=a.mstate and ms.slcd='st' and sl.vdt='$date' and pickedby='' order by s2.gstvno asc")->result();
		return $result;
	}
	
	public function drd_report_not_deliverby_whatsapp(){
		
		$date = date("Y-m-d");
		$result = $this->mssql->query("select top 25 mtime,s2.gstvno,a.altercode,s2.amt from salepurchase1extra as sl,salepurchase1 as s2,acm as a,master as ms where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and ms.code=a.mstate and ms.slcd='st' and sl.vdt='$date' and deliverby='' order by s2.gstvno asc")->result();
		return $result;
	}
	
	public function upload_invoice_on_server(){
		
		echo "ok";
		if(empty($items)){
			$this->db->limit(10);
			$this->db->where('status','1');
			$query = $this->db->get("tbl_invoice")->result();
			foreach($query as $row)
			{
				$id			= $row->id;
				$date 		= $row->date;
				$acno 		= $row->acno;
				$amt 		= $row->amt;
				$taxamt 	= $row->taxamt;
				$gstvno 	= $row->gstvno;
				$name 		= base64_encode($row->name);
				$email 		= base64_encode($row->email_id);
				$altercode 	= $row->chemist_id;
				$mobile 	= $row->mobile;
				$delete_status 	= $row->delete_status;
				$out_for_delivery = $row->out_for_delivery;
				
				$items.='{"id":"'.$id.'","date": "'.$date.'","acno": "'.$acno.'","amt": "'.$amt.'","taxamt": "'.$taxamt.'","gstvno": "'.$gstvno.'","name": "'.$name.'","email": "'.$email.'","altercode": "'.$altercode.'","mobile": "'.$mobile.'","delete_status": "'.$delete_status.'","out_for_delivery": "'.$out_for_delivery.'"},';
				$qry.= "update tbl_invoice set status='2' where id='$id';";
			}
		}
		if(empty($items)){
			$this->db->limit(10);
			$where = array('out_for_delivery_status'=>'1');
			$this->db->where($where);
			$query = $this->db->get("tbl_invoice")->result();
			foreach($query as $row)
			{
				$id			= $row->id;
				$date 		= $row->date;
				$acno 		= $row->acno;
				$amt 		= $row->amt;
				$taxamt 	= $row->taxamt;
				$gstvno 	= $row->gstvno;
				$name 		= base64_encode($row->name);
				$email 		= base64_encode($row->email_id);
				$altercode 	= $row->chemist_id;
				$mobile 	= $row->mobile;
				$delete_status 	= $row->delete_status;
				$out_for_delivery = $row->out_for_delivery;
				
				$items.='{"id":"'.$id.'","date": "'.$date.'","acno": "'.$acno.'","amt": "'.$amt.'","taxamt": "'.$taxamt.'","gstvno": "'.$gstvno.'","name": "'.$name.'","email": "'.$email.'","altercode": "'.$altercode.'","mobile": "'.$mobile.'","delete_status": "'.$delete_status.'","out_for_delivery": "'.$out_for_delivery.'"},';
				$qry.= "update tbl_invoice set out_for_delivery_status=2 where id='$id';";
			}
		}
		if(!empty($items)){

			if ($items != '') {
				$items = substr($items, 0, -1);
			}

			$parmiter = '{"items": ['.$items.']}';

			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://drdweb.co.in/exe01/exe02/upload_invoice_on_server',
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
}  