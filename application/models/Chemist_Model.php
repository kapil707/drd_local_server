<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit', '-1');
ini_set('post_max_size', '100M');
ini_set('upload_max_filesize', '100M');
ini_set('max_execution_time', 36000);
require_once APPPATH."/third_party/PHPExcel.php";
class Chemist_Model extends CI_Model  
{ 	
	public function create_new($chemist_code,$phone_number)
	{
		$items = "";		
		$status1 = "0";
		$query = $this->db->query("select * from tbl_acm where altercode='$chemist_code' and slcd='CL' limit 1")->row();
		if (empty($query->id))
		{
			$status = "User account doesn't exist.";
		}
		else
		{
			$code = $query->code;
			$row1 = $this->db->query("select * from tbl_acm_other where code='$code'")->row();
			if(empty($row1->id))
			{
				$new_request = 1;
				$dt = array(
				'code'=>$code,
				'new_request'=>$new_request,
				'order_limit'=>"500",
				'user_phone'=>$phone_number,
				);
				$this->Scheme_Model->insert_fun("tbl_acm_other",$dt);

				$subject = "Request for New Account";
				$message = "Request for New Account <br><br>Chemist Code : $chemist_code <br><br>Phone Number : $phone_number";
				
				$subject = base64_encode($subject);
				$message = base64_encode($message);
				$email_function = "new_account";
				$mail_server = "";		
				$user_email_id = "vipul@drdindia.com";

				$dt = array(
				'user_email_id'=>$user_email_id,
				'subject'=>$subject,
				'message'=>$message,
				'email_function'=>$email_function,
				'mail_server'=>$mail_server,
				);
				$x = $this->Scheme_Model->insert_fun("tbl_email_send",$dt);
				if($x){
					$status1 = "1";
					$status = "Thank you for submitting your request we will get in touch with you shortly.";
				}
			}
			else{
				$status = "User account already exists.";
			}
		}
$items.= <<<EOD
{"status":"{$status}","status1":"{$status1}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function login($user_name1,$password1)
	{
		$user_session = $user_fname = $user_code = $user_altercode = $user_division = $user_compcode = $user_type = $user_image = "";
		$items = "";
		$defaultpassword= $this->Scheme_Model->get_website_data("defaultpassword");
		$user_return 	= 	"0";
		$user_alert 	= 	"Logic error.";
		if(!empty($user_name1) && !empty($password1))
		{
			$user_password = md5($password1);			

			$query = $this->db->query("select tbl_acm.id,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.address,tbl_acm.mobile,tbl_acm.invexport,tbl_acm.email,tbl_acm.status as status1,tbl_acm_other.status,tbl_acm_other.password as password,tbl_acm_other.exp_date,tbl_acm_other.block,tbl_acm_other.image from tbl_acm left join tbl_acm_other on tbl_acm.code = tbl_acm_other.code where tbl_acm.altercode='$user_name1' and tbl_acm.code=tbl_acm_other.code limit 1")->row();
			if (!empty($query->id))
			{
				if ($query->password == $user_password || $user_password==md5($defaultpassword))
				{
					if($query->block=="0" && $query->status=="1")
					{
						$user_session 	= 	$query->id;
						$user_fname		= 	ucwords(strtolower($query->name));
						$user_code	 	= 	$query->code;
						$user_altercode	= 	$query->altercode;
						$user_image 	= 	constant('img_url_site')."user_profile/".$query->image;
						if(empty($query->image))
						{
							$user_image = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
						}
						$user_type 		= 	"chemist";
						$user_return 	= 	"1";
						$user_alert 	= 	"Logged in successfully";
					}
					else
					{
						$user_alert = "Can't Login due to technical issues.";
					}
				}
				else
				{
					$user_alert = "Invalid password";
				}
			}
			else
			{
				$query = $this->db->query("select u.id,u.customer_code,u.customer_name,u.cust_addr1,u.cust_mobile,u.cust_email,u.is_active,u.user_role,u.login_expiry,u.divison,u.company_name,lu.password,lu.image	from tbl_users u left join tbl_users_other lu on lu.customer_code = u.customer_code where lu.customer_code='$user_name1' limit 1")->row();
				if (!empty($query->id))
				{
					if ($query->password == $user_password || $user_password==md5($defaultpassword))
					{
						$user_session 	= 	$query->id;
						$user_fname		= 	ucwords(strtolower($query->customer_name));
						$user_image 	= 	constant('img_url_site')."user_profile/".$query->image;
						if(empty($query->image))
						{
							$user_image = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
						}
						$user_code	 	= 	$query->customer_code;
						$user_altercode	= 	$query->customer_code;
						$user_type 		= 	"sales";
						$user_return 	= 	"1";
						$user_alert 	= 	"Logged in successfully";
					}
					else
					{
						$user_alert = "Invalid password";
					}
				}
				else
				{
					$query = $this->db->query("select tbl_staffdetail.compcode,tbl_staffdetail.division,tbl_staffdetail.id,tbl_staffdetail.code,tbl_staffdetail.degn as name, tbl_staffdetail.mobilenumber as mobile,tbl_staffdetail.memail as email,tbl_staffdetail_other.status,tbl_staffdetail_other.password from tbl_staffdetail left join tbl_staffdetail_other on tbl_staffdetail.code = tbl_staffdetail_other.code where tbl_staffdetail.memail='$user_name1' and tbl_staffdetail.code=tbl_staffdetail_other.code limit 1")->row();
					if (!empty($query->id))
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
								$user_alert 	= 	"Logged in successfully";
								$user_division	= 	$query->division;
								$user_compcode	= 	$query->compcode;
								$user_image = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
							}
							else
							{
								$user_alert = "Access denied";
							}
						}
						else
						{
							$user_alert = "Invalid password";
						}
					}
					else{
						$user_alert = "Invalid username & password";
					}
				}
			}
		}
		
$items.= <<<EOD
{"user_session":"{$user_session}","user_fname":"{$user_fname}","user_code":"{$user_code}","user_altercode":"{$user_altercode}","user_type":"{$user_type}","user_password":"{$user_password}","user_alert":"{$user_alert}","user_image":"{$user_image}","user_return":"{$user_return}","user_division":"{$user_division}","user_compcode":"{$user_compcode}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function insert_value_on_session($user_session='',$user_fname='',$user_code='',$user_altercode='',$user_type='',$user_password='',$user_division='',$user_compcode='',$user_image='') 
	{		
		$session_arr = array('user_session'=>$user_session,'user_fname'=>$user_fname,'user_code'=>$user_code,'user_altercode'=>$user_altercode,'user_type'=>$user_type,'user_password'=>$user_password,'user_division'=>$user_division,'user_compcode'=>$user_compcode,'user_image'=>$user_image);

		$this->session->set_userdata($session_arr);
		
		$login_time = time();
		$update_time = date("YmdHi", strtotime("+15 minutes", $login_time));
		$row = $this->db->query("select * from drd_login_time where user_altercode='$user_altercode' and user_type='$user_type'")->row();
		if($row->id=="")
		{
			$this->db->query("insert into drd_login_time set user_altercode='$user_altercode',user_type='$user_type',login_time='$login_time',update_time='$update_time'");
		}
		else
		{
			$this->db->query("update drd_login_time set login_time='$login_time',update_time='$update_time' where user_altercode='$user_altercode' and user_type='$user_type'");
		}
		
		return "1";
	}

	public function user_account($user_type,$user_altercode)
	{
		$items = "";
		if($user_type=="chemist")
		{
			$row = $this->db->query("select * from tbl_acm where altercode='$user_altercode' and slcd='CL'")->row();
			if(!empty($row->id))
			{
				$id			= ($row->id);
				$name 		= (ucwords(strtolower($row->name)));
				$altercode  = ($row->altercode);
				$mobile 	= ($row->mobile);
				$email 		= ($row->email);
				$address 	= ($row->address);
				$gstno 		= ($row->gstno);				
				$where= array('code'=>$row->code);
				$row1 = $this->Scheme_Model->select_row("tbl_acm_other",$where);

				$user_profile = constant('img_url_site')."user_profile/$row1->image";
				if(empty($row1->image))
				{
					$user_profile = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
				}
				$status		= ($row1->status);
				if($status)
				{
					$status = "Active";
				}
				else
				{
					$status = "Inactive";
				}
			}
		}
		
		if($user_type=="sales")
		{
			$row = $this->db->query("select * from tbl_users where customer_code='$user_altercode'")->row();
			if(!empty($row->id))
			{
				$id			= ($row->id);
				$name 		= (ucwords(strtolower($row->customer_name)));
				$altercode  = ($row->customer_code);
				$mobile 	= ($row->cust_mobile);
				$email 		= ($row->cust_email);
				$address 	= ($row->cust_addr1);
				$gstno 		= "";
				$status		= "1";

				$where= array('customer_code'=>$row->customer_code);
				$row1 = $this->Scheme_Model->select_row("tbl_users_other",$where);

				$user_profile = constant('img_url_site')."user_profile/$row1->image";
				if(empty($row1->image))
				{
					$user_profile = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
				}
				if($status=="1")
				{
					$status = "Active";
				}
			}
		}
$items.= <<<EOD
{"id":"{$id}","name":"{$name}","altercode":"{$altercode}","mobile":"{$mobile}","email":"{$email}","address":"{$address}","gstno":"{$gstno}","status":"{$status}","user_profile":"{$user_profile}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function check_user_account($user_type,$user_altercode)
	{
		$items = "";
		if($user_type=="chemist")
		{
			$row = $this->db->query("select * from tbl_acm where altercode='$user_altercode' and slcd='CL'")->row();
			if($row->id!="")
			{
				$id			= ($row->id);
				$row1 = $this->db->query("select * from tbl_acm_other where code='$row->code'")->row();
				$user_phone		= ($row1->user_phone);
				$user_email		= ($row1->user_email);
				$user_address	= ($row1->user_address);
				$user_update	= ($row1->user_update);
			}
		}
		
		if($user_type=="sales")
		{
			$row = $this->db->query("select * from tbl_users where customer_code='$user_altercode'")->row();
			if($row->id!="")
			{
				$user_phone		= ($row->user_phone);
				$user_email		= ($row->user_email);
				$user_address	= ($row->user_address);
				$user_update	= ($row->user_update);
			}
		}
$items .= <<<EOD
{"user_phone":"{$user_phone}","user_email":"{$user_email}","user_address":"{$user_address}","user_update":"{$user_update}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function update_user_account($user_type,$user_altercode,$user_phone,$user_email,$user_address)
	{
		$items = "";
		$status = $status1 = "";
		if($user_type=="chemist")
		{
			$row = $this->db->query("select * from tbl_acm where altercode='$user_altercode' and slcd='CL'")->row();
			if($row->id!="")
			{
				$code = ($row->code);
				$this->db->query("update tbl_acm_other set user_phone='$user_phone',user_email='$user_email',user_address='$user_address',user_update='1' where code='$code'");
				$status = "Request has been sent. Your account will update soon.";
				$status1 = "1";
			}
			else
			{
				$status = "Logic error.";
			}
		}
		
		if($user_type=="sales")
		{
			$status1 = "";
			$row = $this->db->query("select * from tbl_users where customer_code='$user_altercode' and slcd='CL'")->row();
			if($row->id!="")
			{
				$code = ($row->customer_code);
				$this->db->query("update tbl_users_other set user_phone='$user_phone',user_email='$user_email',user_address='$user_address',user_update='1' where customer_code='$code'");
				$status = "Request has been sent";
				$status1 = "1";
			}
			else
			{
				$status = "Logic error.";
			}
		}
$items .= <<<EOD
{"status":"{$status}","status1":"{$status1}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function check_old_password($user_type,$user_altercode,$user_password)
	{
		$user_password = md5($user_password);
		$items = "";
		$status = "Oldpassword doesn't match";
		$status1 = "0";
		if($user_type=="chemist")
		{
			$query = $this->db->query("select tbl_acm.id,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.address,tbl_acm.mobile,tbl_acm.invexport,tbl_acm.email,tbl_acm.status as status1,tbl_acm_other.status,tbl_acm_other.password as password,tbl_acm_other.exp_date,tbl_acm_other.block,tbl_acm_other.image from tbl_acm left join tbl_acm_other on tbl_acm.code = tbl_acm_other.code where tbl_acm.altercode='$user_altercode' and tbl_acm.code=tbl_acm_other.code limit 1")->row();
			if ($query->id!="")
			{
				if ($query->password == $user_password && $query->block=="0" && $query->status=="1")
				{
					$status = "Oldpassword doesn't match";
					$status1 = "1";
				}
			}
		}
		
		if($user_type=="sales")
		{
			$query = $this->db->query("select u.id,u.customer_code,u.customer_name,u.cust_addr1,u.cust_mobile,u.cust_email,u.is_active,u.user_role,u.login_expiry,u.divison,u.company_name,lu.password	from tbl_users u left join tbl_users_other lu on lu.customer_code = u.customer_code where lu.customer_code='$user_altercode' limit 1")->row();
			if ($query->id!="")
			{
				if ($query->password == $user_password)
				{
					$status = "Oldpassword doesn't match";
					$status1 = "1";
				}
			}
		}
$items .= <<<EOD
{"status":"{$status}","status1":"{$status1}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function change_password($user_type,$user_altercode,$user_password,$new_password)
	{
		$user_password = md5($user_password);
		$items = "";
		$status = "Oldpassword doesn't match";
		$status1 = "0";
		if($user_type=="chemist")
		{
			$query = $this->db->query("select tbl_acm.id,tbl_acm.code,tbl_acm.altercode,tbl_acm.name,tbl_acm.address,tbl_acm.mobile,tbl_acm.invexport,tbl_acm.email,tbl_acm.status as status1,tbl_acm_other.status,tbl_acm_other.password as password,tbl_acm_other.exp_date,tbl_acm_other.block,tbl_acm_other.image from tbl_acm left join tbl_acm_other on tbl_acm.code = tbl_acm_other.code where tbl_acm.altercode='$user_altercode' and tbl_acm.code=tbl_acm_other.code limit 1")->row();
			if ($query->id!="")
			{
				if ($query->password == $user_password && $query->block=="0" && $query->status=="1")
				{
					$code = $query->code;
					$new_password = md5($new_password);
					$this->db->query("update tbl_acm_other set password='$new_password' where code='$code'");
					$status = "Updated successfully";
					$status1 = "1";
				}
				else
				{
					$status = "Oldpassword doesn't match";
				}
			}
			else
			{
				$status = "Logic error.";
			}
		}
		
		if($user_type=="sales")
		{
			$query = $this->db->query("select u.id,u.customer_code,u.customer_name,u.cust_addr1,u.cust_mobile,u.cust_email,u.is_active,u.user_role,u.login_expiry,u.divison,u.company_name,lu.password	from tbl_users u left join tbl_users_other lu on lu.customer_code = u.customer_code where lu.customer_code='$user_altercode' limit 1")->row();
			if ($query->id!="")
			{
				if ($query->password == $user_password)
				{
					$code = $query->customer_code;
					$new_password = md5($new_password);
					$this->db->query("update tbl_users_other set password='$new_password' where customer_code='$code'");
					$status = "Password Change Successfully";
					$status1 = "1";
				}
				else
				{
					$status = "Oldpassword doesn't match";
				}
			}
			else
			{
				$status = "Logic error.";
			}
		}
$items.= <<<EOD
{"status":"{$status}","status1":"{$status1}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	public function top_flash()
	{
		$items = "";
		$i = 1;
		$this->db->where("status=1");
		$this->db->order_by('RAND()');
		$query = $this->db->get("tbl_slider")->result();
		foreach ($query as $row)
		{
			if($i==1)
			{
				$id	=	"active";
			}
			else{
				$id = "";
			}
			$i++;
			$compname="";
			if($row->funtype=="1"){ 				
			}
			if($row->funtype=="2" || $row->funtype=="3"){
				$row->itemid = $row->compid; 
				$row1 = $this->db->query("select company_full_name from tbl_medicine where compcode='$row->itemid'")->row();
				$compname = ($row1->company_full_name);
			}
			$funtype	=	$row->funtype;
			$itemid	    =	$row->itemid;
			$division	=	$row->division;
			$image 		= 	constant('img_url_site')."uploads/manage_slider/photo/resize/".$row->image;
			
$items.= <<<EOD
{"id":"{$id}","funtype":"{$funtype}","itemid":"{$itemid}","division":"{$division}","image":"{$image}","compname":"{$compname}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function top_flash2()
	{
		//error_reporting(0);
		$items = "";
		$i = 1;
		$this->db->where("status=1");
		$this->db->order_by('RAND()');
		$query = $this->db->get("tbl_slider2")->result();
		foreach ($query as $row)
		{
			if($i==1)
			{
				$id	=	"active";
			}
			else{
				$id = "";
			}
			$i++;
			$compname="";
			if($row->funtype=="1"){			
			}
			if($row->funtype=="2" || $row->funtype=="3"){
				$row->itemid = $row->compid; 
				$row1 =  $this->db->query("select company_full_name from tbl_medicine where compcode='$row->itemid'")->row();
				//$compname = base64_decode($row1->company_full_name);
				$compname = ($row1->company_full_name);
			}
			$funtype	=	$row->funtype;
			$itemid	    =	$row->itemid;
			$division	=	$row->division;
			$image 		= 	constant('img_url_site')."uploads/manage_slider2/photo/resize/".$row->image;
			
$items.= <<<EOD
{"id":"{$id}","funtype":"{$funtype}","itemid":"{$itemid}","division":"{$division}","image":"{$image}","compname":"{$compname}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function search_medicine($keyword)
	{
		//error_reporting(0);
		$sameid = "";
		$items = "";
		$count = 0;
		$date_time = date('d-M h:i A');
		$items = "";
		$keyword = str_replace("'","",$keyword);
		$keyword_title = str_replace("-","",$keyword);
		$keyword_title = str_replace(".","",$keyword_title);
		$keyword_title = str_replace("`","",$keyword_title);
		$keyword_title = str_replace("'","",$keyword_title);
		$keyword_title = str_replace("/","",$keyword_title);
		$keyword_title = str_replace("(","",$keyword_title);
		$keyword_title = str_replace(")","",$keyword_title);
		$keyword_title = str_replace("%","",$keyword_title);
		$keyword_title = str_replace(",","",$keyword_title);		
		$keyword_title = str_replace("%20","",$keyword_title);
		$keyword_title = str_replace(" ","",$keyword_title);
		
		$keyword_name = str_replace("%20"," ",$keyword);
		
		
		$this->db->select("m.*,(SELECT DISTINCT featured from tbl_medicine_image where itemid=m.i_code) as featured,(SELECT DISTINCT discount from tbl_company_discount where compcode=m.compcode and tbl_company_discount.status='1') as discount");
		//$this->db->select("m.*");
		$this->db->where("(title='$keyword_title' or title like '".$keyword_title."%' or item_name='$keyword_title' or item_name='$keyword_name' or item_name like '".$keyword_name."%' or company_full_name='$keyword_title' or company_full_name like '".$keyword_name."%')");
		$this->db->limit(20);
		$this->db->order_by('m.item_name','asc');
		$query = $this->db->get("tbl_medicine as m")->result();
		foreach ($query as $row)
		{
			$id		=	$row->id;
			$items.=$this->search_medicine_new($row,$id,$count,$date_time);
			
			$x = substr($row->item_name,0,1);
			if($x==".")
			{}else{
				$count++;
			}
			
			$sameid.= $id.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = "and m.id not in(".$sameid.")";
		}
		
		$this->db->select("m.*,(SELECT DISTINCT featured from tbl_medicine_image where itemid=m.i_code) as featured,(SELECT DISTINCT discount from tbl_company_discount where compcode=m.compcode and tbl_company_discount.status='1') as discount");
		$this->db->where("(title like '%".$keyword_title."%' or item_name like '%".$keyword_name."%' or company_full_name like '%".$keyword_name."%') ".$sameid);
		$this->db->limit(20);
		$this->db->order_by('m.item_name','asc');
		$query = $this->db->get("tbl_medicine as m")->result();
		foreach ($query as $row)
		{
			$id	= $row->id;
			$items.=$this->search_medicine_new($row,$id,$count,$date_time);
			
			$x = substr($row->item_name,0,1);
			if($x==".")
			{}else{
				$count++;
			}
		}
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function search_medicine_new($row,$id,$count,$date_time)
	{
		$i_code				=	$row->i_code;
		$item_code			=	$row->item_code;
		$title				=	$row->title;
		$item_name			=	ucwords(strtolower($row->item_name));
		$company_name		=	ucwords(strtolower($row->company_name));
		$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
		$batchqty			=	$row->batchqty;
		$batch_no			=	$row->batch_no;
		$packing			=	$row->packing;
		$sale_rate			=	$row->sale_rate;
		$mrp				=	$row->mrp;
		$scheme				=	$row->salescm1."+".$row->salescm2;
		$expiry				=	$row->expiry;				
		$compcode 			=   $row->compcode;				
		$item_date 			=   $row->item_date;
		$margin 			=   round($row->margin);				
		$misc_settings		=   $row->misc_settings;
		$gstper				=	$row->gstper;
		$itemjoinid			=	$row->itemjoinid;
		$featured 			= 	$row->featured;
		$discount 			= 	$row->discount;
		
		//$featured = $discount = "";
		if(empty($discount))
		{
			$discount = "4.5";
		}
		
		/*$description1 = "";
		$description2 = "";
		$image1 = constant('img_url_site')."uploads/default_img.jpg";
		$image2 = constant('img_url_site')."uploads/default_img.jpg";
		$image3 = constant('img_url_site')."uploads/default_img.jpg";
		$image4 = constant('img_url_site')."uploads/default_img.jpg";*/
		
		$get_medicine_image	= 	$this->get_medicine_image($i_code);
		
		$description1 = $get_medicine_image[4];
		$description2 = trim($get_medicine_image[5]);
		$description2 = preg_replace('/[^A-Za-z0-9\#]/',' ', $description2);
		$image1 = $get_medicine_image[0];
		if(!empty($image1))
		{
			$image2 = $get_medicine_image[1];
			$image3 = $get_medicine_image[2];
			$image4 = $get_medicine_image[3];
		}
		else{
			$image1 = constant('img_url_site')."uploads/default_img.jpg";
			$image2 = constant('img_url_site')."uploads/default_img.jpg";
			$image3 = constant('img_url_site')."uploads/default_img.jpg";
			$image4 = constant('img_url_site')."uploads/default_img.jpg";
		}
		
		/*********************yha decount karta h**************/
		$final_price0=  $sale_rate * $discount / 100;
		$final_price0=	$sale_rate - $final_price0;
		
		/*********************yha gst add karta h**************/
		$final_price=   $final_price0 * $gstper / 100;
		$final_price=	$final_price0 + $final_price;
		
		$final_price= 	round($final_price,2);
		/***************************************/
		$mrp_xx = $mrp;
		if($mrp==0)
		{
			$mrp_xx = 1;
		}
		$margin = $mrp - $final_price;
		$margin = $margin / $mrp_xx;
		$margin = $margin * 100;
		$margin = round($margin);
		/***************************************/
		
		$itemjoinid = "";
		$items1 = "";
		if($itemjoinid!="")
		{
			$itemjoinid1 = explode (",", $itemjoinid);
			foreach($itemjoinid1 as $item_code_n)
			{
				$items1.= $this->get_itemjoinid($item_code_n);
			}
			if (!empty($items1)) {
				$items1 = substr($items1, 0, -1);
			}
			
			if (!empty($items1)) {
				$items1 = ',"items1":['.$items1.']';
			} else{
				$itemjoinid = "";
				$items1 = ',"items1":""';
			}
		}
		else
		{
			$items1 = ',"items1":""';
		}
		/********************************************************/
		//$itemjoinid			=	base64_encode($row->itemjoinid);
		
		if($i_code==0 || $i_code==-1){ 
$items = "";
		} else {
$items= <<<EOD
{"count":"{$count}","i_code":"{$i_code}","item_code":"{$item_code}","date_time":"{$date_time}","title":"{$title}","item_name":"{$item_name}","company_name":"{$company_name}","company_full_name":"{$company_full_name}","image1":"{$image1}","image2":"{$image2}","image3":"{$image3}","image4":"{$image4}","description1":"{$description1}","description2":"{$description2}","batchqty":"{$batchqty}","sale_rate":"{$sale_rate}","mrp":"{$mrp}","final_price":"{$final_price}","batch_no":"{$batch_no}","packing":"{$packing}","expiry":"{$expiry}","scheme":"{$scheme}","margin":"{$margin}","featured":"{$featured}","gstper":"{$gstper}","discount":"{$discount}","misc_settings":"{$misc_settings}","itemjoinid":"{$itemjoinid}"$items1},
EOD;
		}
		return $items;
	}
	
	public function import_order_dropdownbox($keyword,$item_mrp,$u_type="site")
	{
		$items = "";
		
		$keyword_title = str_replace("-","",$keyword);
		$keyword_title = str_replace(".","",$keyword_title);
		$keyword_title = str_replace("`","",$keyword_title);
		$keyword_title = str_replace("'","",$keyword_title);
		$keyword_title = str_replace("/","",$keyword_title);
		$keyword_title = str_replace("(","",$keyword_title);
		$keyword_title = str_replace(")","",$keyword_title);
		$keyword_title = str_replace("%","",$keyword_title);
		$keyword_title = str_replace(","," ",$keyword_title);

		$just_title    = $keyword_title;
		$just_title = str_replace("%20",",",$just_title);
		$just_title = str_replace(" ",",",$just_title);

		$keyword_title = str_replace("%20","",$keyword_title);
		$keyword_title = str_replace(" ","",$keyword_title);
		
		$keyword_name = str_replace("%20"," ",$keyword);
		
		$candi_0 = $candi_1 = $candi_2 = $candi_3 = $candi_4 = $candi_5 = $candi_6 = $candi_7 = $candi_8 = $candi_9 = "";
		/*********************************************************/
		$this->db->select("i_code,mrp");
		$this->db->where("(title like '".$keyword_title."%') and status='1' and batchqty!='0'");
		$this->db->order_by('item_name','asc');
		$this->db->limit(1);
		$query = $this->db->get("tbl_medicine")->result();
		$candi_0 = $this->import_order_dropdownbox_dt($query,"not","0");
		if(!empty($candi_0["i_code"]))
		{
			$items = $candi_0;
			//echo "ok00";
		}

		/*********************************************************/
		if(empty($candi_0["i_code"]))
		{
			$this->db->select("i_code,mrp");
			$this->db->where("(title like '".$keyword_title."%') and status='1'");
			$this->db->order_by('item_name','asc');
			$this->db->limit(1);
			$query = $this->db->get("tbl_medicine")->result();
			$candi_1 = $this->import_order_dropdownbox_dt($query,$item_mrp,"1");
			if(!empty($candi_1["i_code"]))
			{
				$items = $candi_1;
				//echo "ok01";
			}
		}
		
		/*********************************************************/
		if(empty($candi_1["i_code"]))
		{
			$this->db->select("i_code,mrp");
			$this->db->where("(item_name like '".$keyword_name."%' or title like '%".$keyword_title."%' or company_full_name like '".$keyword_name."%') and status='1'");
			$this->db->order_by('item_name','asc');
			$this->db->limit(1);
			$query = $this->db->get("tbl_medicine")->result();
			$candi_2 = $this->import_order_dropdownbox_dt($query,$item_mrp,"1");
			if(!empty($candi_2["i_code"]))
			{
				$items = $candi_2;
				//echo "ok02";
			}
		}
		
		if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]))
		{
			$value3 = $keyword_name;
			for($i=0;$i<strlen($keyword_name);$i++)
			{
				if(empty($candi_3))
				{
					$candi_3 = $this->import_order_dropdownbox_dt1($value3,$item_mrp,"1");
					$value3 = substr($value3, 0, -1);
				}
			}
			//echo "ok03";
		}
		
		if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]))
		{
			$value4 = $keyword_name;
			for($i=0;$i<strlen($keyword_name);$i++)
			{
				if(empty($candi_4))
				{
					$candi_4 = $this->import_order_dropdownbox_dt2($value4,$item_mrp,"1");
					$value4 = substr($value4, 0, -1);
					if(strlen($value4)<6)
					{
						break;
					}
				}
			}
			//echo "ok04";
		}
		
		if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]))
		{
			$value5 = $keyword_title;
			for($i=0;$i<strlen($keyword_title);$i++)
			{
				if(empty($candi_5))
				{
					$candi_5 = $this->import_order_dropdownbox_dt2($value5,"not","0");
					$value5 = substr($value5, 0, -1);
					if(strlen($value5)<6)
					{
						break;
					}
				}
			}
			//echo "ok05";
		}
		
		if(!empty($candi_3["i_code"]))
		{
			$items = $candi_3;
		}
		
		if(!empty($candi_4["i_code"]))
		{
			$items = $candi_4;
		}
		if(!empty($candi_5["i_code"]))
		{
			$items = $candi_5;
		}
		/**** new crete by 26-03-2021****jab same name ki davi but def mrp h to*/
		if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]))
		{
			$this->db->select("i_code,mrp");
			$this->db->where("(item_name='".$keyword_name."') and status='1'");
			$this->db->order_by('item_name','asc');
			$this->db->limit(1);
			$query = $this->db->get("tbl_medicine")->result();
			$candi_6 = $this->import_order_dropdownbox_dt($query,"not","0");
			//echo "ok061";
		}
		if(!empty($candi_6["i_code"]))
		{
			$items = $candi_6;
		}
		
		if($u_type=="admin")
		{	
			/**** new crete by 14-05-2021****jab same name ki davi but def mrp h to*/
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]))
			{
				$value7 = $keyword_title;
				for($i=0;$i<strlen($keyword_title);$i++)
				{
					if(empty($candi_7["i_code"]))
					{
						$candi_7 = $this->import_order_dropdownbox_dt1($value7,"not","0");
						$value7 = substr($value7, 0, -1);
						if(strlen($value7)<10)
						{
							break;
						}
					}
				}
				//echo "ok07";
			}
			if(!empty($candi_7["i_code"]))
			{
				$items = $candi_7;
			}
			
			/**** new crete by 20-10-2021****jab same name ki davi but def mrp h to*/
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]) && empty($candi_7["i_code"]))
			{
				$value8 = $keyword_title;
				$value8 = str_replace("*","",$value8);
				for($i=0;$i<strlen($keyword_title);$i++)
				{
					if(empty($candi_8["i_code"]))
					{
						$candi_8 = $this->import_order_dropdownbox_dt1($value8,$item_mrp,"1");
						$value8 = substr($value8, 0, -1);
						if(strlen($value8)<9)
						{
							break;
						}
					}
				}
				//echo "ok08";
			}
			if(!empty($candi_8["i_code"]))
			{
				$items = $candi_8;
			}
		}
		
		if($u_type=="site")
		{
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]))
			{
				$value7 = $keyword_title;
				for($i=0;$i<strlen($keyword_title);$i++)
				{
					if(empty($candi_7["i_code"]))
					{
						$candi_7 = $this->import_order_dropdownbox_dt1($value7,"not","0");
						$value7 = substr($value7, 0, -1);
						if(strlen($value7)<4)
						{
							break;
						}
					}
				}
				//echo "ok07";
			}
			if(!empty($candi_7["i_code"]))
			{
				$items = $candi_7;
			}
			/**** new crete by 20-10-2021****jab same name ki davi but def mrp h to*/
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]) && empty($candi_7["i_code"]))
			{
				$value8 = $keyword_title;
				$value8 = str_replace("*","",$value8);
				for($i=0;$i<strlen($keyword_title);$i++)
				{
					if(empty($candi_8["i_code"]))
					{
						$candi_8 = $this->import_order_dropdownbox_dt2($value8,"not","0");
						if(strlen($value8)<4)
						{
							break;
						}
					}
				}
				//echo "ok08";
			}
			if(!empty($candi_8["i_code"]))
			{
				$items = $candi_8;
			}
			
			/**** new crete by 20-10-2021****jab same name ki davi but def mrp h to*/
			if(empty($candi_0["i_code"]) && empty($candi_1["i_code"]) && empty($candi_2["i_code"]) && empty($candi_3["i_code"]) && empty($candi_4["i_code"]) && empty($candi_5["i_code"]) && empty($candi_6["i_code"]) && empty($candi_7["i_code"]) && empty($candi_8["i_code"]))
			{
				$value9 = $keyword_title;
				$value9 = str_replace("*","",$value9);
				for($i=strlen($value9);$i>0;$i--)
				{
					if(empty($candi_9["i_code"]))
					{
						$x = $i - strlen($value9);
						$value9_ = substr($value9, 0, $x);
						$candi_9 = $this->import_order_dropdownbox_dt2($value9_,"not","0");
					}
				}
				//echo "ok09";
			}
			if(!empty($candi_9["i_code"]))
			{
				$items = $candi_9;
			}
		}
		return $items;
	}
	
	public function import_order_dropdownbox_dt1($keyword,$item_mrp,$type)
	{		
		/*********************************************************/
		$this->db->select("i_code,mrp");
		$this->db->where("(item_name like '".$keyword."%' or title like '%".$keyword."%' or company_full_name like '".$keyword."%' ) and status='1'");
		$this->db->order_by('item_name','asc');
		$this->db->limit(1);
		$query = $this->db->get("tbl_medicine")->result();
		return $this->import_order_dropdownbox_dt($query,$item_mrp,$type);
	}
	
	public function import_order_dropdownbox_dt2($keyword,$item_mrp,$type)
	{		
		/*********************************************************/
		$this->db->select("i_code,mrp");
		$this->db->where("(title like '".$keyword."%' or title like '%".$keyword."%' or title like '%".$keyword."') and status='1'");
		$this->db->order_by('item_name','asc');
		$this->db->limit(1);
		$query = $this->db->get("tbl_medicine")->result();
		return $this->import_order_dropdownbox_dt($query,$item_mrp,$type);
	}

	public function import_order_dropdownbox_dt3($keyword,$item_mrp,$type)
	{		
		/*********************************************************/
		$keyword = explode(",", $keyword);
		$keyword = shuffle($keyword);
		$keyword_other = "";
		$this->db->select("i_code,mrp");
		foreach($keyword as $row)
		{
			$keyword_other.= "title like '".$row."%' or ";
		}
		echo $keyword_other = substr($keyword_other, 0, -3);die;
		$this->db->where($keyword_other."and status='1'");
		$this->db->order_by('item_name','asc');
		$this->db->limit(1);
		$query = $this->db->get("tbl_medicine")->result();
		return $this->import_order_dropdownbox_dt($query,$item_mrp,$type);
	}
	
	public function import_order_dropdownbox_dt($query,$item_mrp,$type)
	{
		if(empty($type)){
			$type = 0;
		}
		$ret["i_code"] = "";
		$ret["mrp"]  = $item_mrp;
		$ret["type"] = $type;
		foreach ($query as $row)
		{
			if(round($item_mrp)==round($row->mrp) || $item_mrp=="not")
			{
				$i_code	=	$row->i_code;
				$mrp	=	$row->mrp;						
				if($i_code!=0 && $i_code!=-1)
				{
					$ret["i_code"] = $i_code;
					$ret["mrp"] = $mrp;
					$ret["type"] = $type;
				}
			}
		}
		return $ret;
	}
	
	public function get_medicine_image($i_code)
	{
		$img1 = $img2 =  $img3 =  $img4 = constant('img_url_site')."uploads/default_img.jpg";
		
		$where = array('i_code'=>$i_code);
		$this->db->where($where);
		$row = $this->db->get("tbl_med_info")->row();	
		if(!empty($row->id))
		{
			$img1_ck = constant('img_url_site')."medicine_images/".$row->table_name."/".$row->img1;
			if(!empty($row->img1))
			{
				$img1 = constant('img_url_site')."medicine_images/".$row->table_name."/".$row->img1;
				$img2 = constant('img_url_site')."medicine_images/".$row->table_name."/".$row->img2;
				$img3 = constant('img_url_site')."medicine_images/".$row->table_name."/".$row->img3;
				$img4 = constant('img_url_site')."medicine_images/".$row->table_name."/".$row->img4;
			}
			if($row->update_url=="1" && file_exists($row->img1)==1)
			{
				$img1 = $row->img1;
				$img2 = $row->img2;
				$img3 = $row->img3;
				$img4 = $row->img4;
			}
			$dis1 = $row->a1;
			$dis2 = $row->a5;
		}
		else
		{
			$old_image = constant('img_url_site')."uploads/manage_medicine_image/photo/resize/";
			$where = array('itemid'=>$i_code);
			$this->db->where($where);
			$row1 = $this->db->get("tbl_medicine_image")->row();
			if(!empty($row1->image))
			{
				$img1 = $img2 = $img3 = $img4 = $old_image.$row1->image;
				if(!empty($row1->image2))
				{
					$img2 = $img3 = $img4 = $old_image.$row1->image2;
				}

				if(!empty($row1->image3))
				{
					$img3 = $img4 = $old_image.$row1->image3;
				}

				if(!empty($row1->image4))
				{
					$img4 = $old_image.$row1->image4;
				}
			}
			if(!empty($row1->description))
			{
				$dis2 = ($row1->description);
			}
		}
			
		$dt[0] = $img1;
		$dt[1] = $img2;
		$dt[2] = $img3;
		$dt[3] = $img4;
		$dt[4] = "";
		$dt[5] = "";
		if(!empty($dis1))
		{
			$dt[4] = "*".$dis1;
		}
		if(!empty($dis2))
		{
			$dt[5] = "*".$dis2;
		}
		return $dt;
	}
	
	public function get_medicine_featured($i_code)
	{
		$featured = "";		
		$where = array('itemid'=>$i_code);
		$this->db->where($where);
		$row = $this->db->get("tbl_medicine_image")->row();
		if(!empty($row->featured))
		{
			$featured = $row->featured;
		}
		else
		{
			$featured = 0;
		}
		return $featured;
	}
	
	public function get_company_discount($compcode)
	{
		$discount	=	"4.5";		
		$where = array('compcode'=>$compcode,'status'=>'1',);
		$this->db->where($where);
		$row = $this->db->get("tbl_company_discount")->row();
		if(!empty($row->discount))
		{
			$discount	=	$row->discount;
		}
		return $discount;
	}
	
	public function get_itemjoinid($item_code)
	{
		//error_reporting(0);
		$items2 = "";
		$date_time = date('d-M h:i A');
		$this->db->select("m.*,(SELECT DISTINCT featured from tbl_medicine_image where itemid=m.i_code) as featured,(SELECT DISTINCT discount from tbl_company_discount where compcode=m.compcode and tbl_company_discount.status='1') as discount");
		$where = array('item_code'=>$item_code);
		$this->db->where($where);
		$row = $this->db->get("tbl_medicine as m")->row();
		if(!empty($row->id))
		{
			$i_code				=	$row->i_code;
			$item_code			=	$row->item_code;
			$title				=	$row->title;
			$item_name			=	ucwords(strtolower($row->item_name));
			$company_name		=	ucwords(strtolower($row->company_name));
			$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
			$batchqty			=	$row->batchqty;
			$batch_no			=	$row->batch_no;
			$packing			=	$row->packing;
			$sale_rate			=	$row->sale_rate;
			$mrp				=	$row->mrp;
			$scheme				=	$row->salescm1."+".$row->salescm2;
			$expiry				=	$row->expiry;				
			$compcode 			=   $row->compcode;				
			$item_date 			=   $row->item_date;
			$margin 			=   round($row->margin);				
			$misc_settings		=   $row->misc_settings;
			$gstper				=	$row->gstper;
			$itemjoinid			=	$row->itemjoinid;
			$featured 			= 	$row->featured;
			$discount 			= 	$row->discount;
			
			if(empty($discount))
			{
				$discount = "4.5";
			}
			
			$get_medicine_image	= 	$this->get_medicine_image($i_code);
			
			$image1 = $get_medicine_image[0];
			$image2 = $get_medicine_image[1];
			$image3 = $get_medicine_image[2];
			$image4 = $get_medicine_image[3];
			$description1 = $get_medicine_image[4];
			$description2 = trim($get_medicine_image[5]);
			$description2 = preg_replace('/[^A-Za-z0-9\#]/',' ', $description2);
			
			/*********************yha decount karta h**************/
			$final_price0=  $sale_rate * $discount / 100;
			$final_price0=	$sale_rate - $final_price0;
			
			/*********************yha gst add karta h**************/
			$final_price=   $final_price0 * $gstper / 100;
			$final_price=	$final_price0 + $final_price;
			
			$final_price= 	round($final_price,2);
			/***************************************/
			$mrp_xx = $mrp;
			if($mrp==0)
			{
				$mrp_xx = 1;
			}
			$margin = $mrp - $final_price;
			$margin = $margin / $mrp_xx;
			$margin = $margin * 100;
			$margin = round($margin);
			/***************************************/
			
$items2 .= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","date_time":"{$date_time}","title":"{$title}","item_name":"{$item_name}","company_name":"{$company_name}","company_full_name":"{$company_full_name}","image1":"{$image1}","image2":"{$image2}","image3":"{$image3}","image4":"{$image4}","description1":"{$description1}","description2":"{$description2}","batchqty":"{$batchqty}","sale_rate":"{$sale_rate}","mrp":"{$mrp}","final_price":"{$final_price}","batch_no":"{$batch_no}","packing":"{$packing}","expiry":"{$expiry}","scheme":"{$scheme}","margin":"{$margin}","featured":"{$featured}","gstper":"{$gstper}","discount":"{$discount}","misc_settings":"{$misc_settings}","itemjoinid":"{$itemjoinid}"},
EOD;
		}
		return $items2;
	}
	
	public function get_single_medicine_info($i_code,$chemist_id,$selesman_id,$user_type)
	{		
		$items = "";
		//error_reporting(0);
		$date_time = date('d-M h:i A');
		/*$where = array('i_code'=>$i_code);
		$row = $this->Scheme_Model->select_row("tbl_medicine",$where);*/
		
		$this->db->select("m.*,(SELECT DISTINCT featured from tbl_medicine_image where itemid=m.i_code) as featured,(SELECT DISTINCT discount from tbl_company_discount where compcode=m.compcode and tbl_company_discount.status='1') as discount");
		$where = array('i_code'=>$i_code);
		$this->db->where($where);
		$row = $this->db->get("tbl_medicine as m")->row();
		if(!empty($row->id))
		{
			$i_code				=	$row->i_code;
			$item_code			=	$row->item_code;
			$title				=	$row->title;
			$item_name			=	ucwords(strtolower($row->item_name));
			$company_name		=	ucwords(strtolower($row->company_name));
			$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
			$batchqty			=	$row->batchqty;
			$batch_no			=	$row->batch_no;
			$packing			=	$row->packing;
			$sale_rate			=	$row->sale_rate;
			$mrp				=	$row->mrp;
			$scheme				=	$row->salescm1."+".$row->salescm2;
			$expiry				=	$row->expiry;				
			$compcode 			=   $row->compcode;				
			$item_date 			=   $row->item_date;
			$margin 			=   round($row->margin);				
			$misc_settings		=   $row->misc_settings;
			$gstper				=	$row->gstper;
			$itemjoinid			=	$row->itemjoinid;
			
			$featured		=	$row->featured;
			$discount		=	$row->discount;
			
			//$featured		=  $discount = "";
			if(empty($discount))
			{
				$discount = "4.5";
			}
			
			$get_medicine_image	= 	$this->get_medicine_image($i_code);
			$description1 = $get_medicine_image[4];
			$description2 = trim($get_medicine_image[5]);
			$description2 = preg_replace('/[^A-Za-z0-9\#]/',' ', $description2);
			$image1 = $get_medicine_image[0];
			if(!empty($image1))
			{
				$image2 = $get_medicine_image[1];
				$image3 = $get_medicine_image[2];
				$image4 = $get_medicine_image[3];
			}
			else{
				$image1 = constant('img_url_site')."uploads/default_img.jpg";
				$image2 = constant('img_url_site')."uploads/default_img.jpg";
				$image3 = constant('img_url_site')."uploads/default_img.jpg";
				$image4 = constant('img_url_site')."uploads/default_img.jpg";
			}
			/*
			$description1 = "";
			$description2 = "";
			$image1 = constant('img_url_site')."uploads/default_img.jpg";
			$image2 = constant('img_url_site')."uploads/default_img.jpg";
			$image3 = constant('img_url_site')."uploads/default_img.jpg";
			$image4 = constant('img_url_site')."uploads/default_img.jpg";
			/*******************************************************/
			
			/*********************yha decount karta h**************/
			$final_price0=  $sale_rate * $discount / 100;
			$final_price0=	$sale_rate - $final_price0;
			
			/*********************yha gst add karta h**************/
			$final_price=   $final_price0 * $gstper / 100;
			$final_price=	$final_price0 + $final_price;
			
			$final_price= 	round($final_price,2);
			/***************************************/
			$mrp_xx = $mrp;
			if($mrp==0)
			{
				$mrp_xx = 1;
			}
			$margin = $mrp - $final_price;
			$margin = $margin / $mrp_xx;
			$margin = $margin * 100;
			$margin = round($margin);
			/***************************************/
			

			/********************************************************/
			$itemjoinid = "";
			$items1 = "";
			if($itemjoinid!="")
			{
				$itemjoinid1 = explode (",", $itemjoinid);
				foreach($itemjoinid1 as $item_code_n)
				{
					$items1.= $this->get_itemjoinid($item_code_n);
				}
				if ($items1 != '') {
					$items1 = substr($items1, 0, -1);
				}
				$items1 = ',"items1":['.$items1.']';
			}
			else
			{
				$items1 = ',"items1":""';
			}
			/****************************************/
			$hotdeals 			=   $row->hotdeals;
			$hotdeals_short 	=   $row->hotdeals_short;
			/************************************************/
			
$items .= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","date_time":"{$date_time}","title":"{$title}","item_name":"{$item_name}","company_name":"{$company_name}","company_full_name":"{$company_full_name}","image1":"{$image1}","image2":"{$image2}","image3":"{$image3}","image4":"{$image4}","description1":"{$description1}","description2":"{$description2}","batchqty":"{$batchqty}","sale_rate":"{$sale_rate}","mrp":"{$mrp}","final_price":"{$final_price}","batch_no":"{$batch_no}","packing":"{$packing}","expiry":"{$expiry}","scheme":"{$scheme}","margin":"{$margin}","featured":"{$featured}","gstper":"{$gstper}","discount":"{$discount}","misc_settings":"{$misc_settings}","itemjoinid":"{$itemjoinid}","hotdeals":"{$hotdeals}","hotdeals_short":"{$hotdeals_short}"$items1},
EOD;
	}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function search_chemist($keyword)
	{
		$items = "";
		$this->db->where("(name like '".$keyword."%' or altercode='$keyword' or altercode like '%".$keyword."' or altercode like '".$keyword."%' or altercode like '%".$keyword."%') and slcd='CL'");
		$this->db->limit(100);
		$query= $this->db->get("tbl_acm")->result();		
		foreach ($query as $row)
		{
			if(substr($row->name,0,1)==".")
			{
			}
			else
			{
				$id			=	$row->id;
				$user_name	=	$row->name;
				$chemist_id	=	$row->altercode;
				$code		=	$row->code;
				
				$where1 = array('code'=>$row->code);
				$row1   = $this->Scheme_Model->select_row("tbl_acm_other",$where1);
				
				$user_image = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
				if(!empty($row1->image))
				{
					$user_image = constant('img_url_site')."user_profile/".$row1->image;
				}					

$items .= <<<EOD
{"id":"{$id}","user_name":"{$user_name}","chemist_id":"{$chemist_id}","user_image":"{$user_image}","code":"{$code}"},
EOD;
			}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function hot_deals()
	{
		$where = array('hotdeals'=>1,'item_code!='=>'',);
		$this->db->where($where);
		$this->db->limit(50);
		$query = $this->db->get("tbl_medicine")->result();		
		foreach ($query as $row)
		{
			$i_code				=	$row->i_code;
			$item_code			=	$row->item_code;
			$title				=	$row->title;
			$item_name			=	ucwords(strtolower($row->item_name));
			$company_name		=	ucwords(strtolower($row->company_name));
			$company_full_name 	=  	ucwords(strtolower($row->company_full_name));
			$batchqty			=	$row->batchqty;
			$batch_no			=	$row->batch_no;
			$packing			=	$row->packing;
			$sale_rate			=	$row->sale_rate;
			$mrp				=	$row->mrp;
			$scheme				=	$row->salescm1."+".$row->salescm2;
			$expiry				=	$row->expiry;				
			$compcode 			=   $row->compcode;				
			$item_date 			=   $row->item_date;
			$margin 			=   round($row->margin);				
			$misc_settings		=   $row->misc_settings;
			$gstper				=	$row->gstper;
			$present			=	$row->present;
			$itemjoinid			=	$row->itemjoinid;
			
			$i_code		=	$row->i_code;
			$image 		= 	$this->Scheme_Model->get_medicine_image($i_code);
			$featured 	= 	$this->Scheme_Model->get_medicine_featured($i_code);
			$discount 	= 	$this->Scheme_Model->get_company_discount($compcode);
			
			/*********************yha decount karta h**************/
			$final_price0=  $sale_rate * $discount / 100;
			$final_price0=	$sale_rate - $final_price0;
			
			/*********************yha gst add karta h**************/
			$final_price=   $final_price0 * $gstper / 100;
			$final_price=	$final_price0 + $final_price;
			
			$final_price= 	round($final_price,2);
			
			/***************************************/
			$mrp_xx = $mrp;
			if($mrp==0)
			{
				$mrp_xx = 1;
			}
			$margin = $mrp - $final_price;
			$margin = $margin / $mrp_xx;
			$margin = $margin * 100;
			$margin = round($margin);
			/***************************************/

			/*****************************************
			if($itemjoinid!="")
			{
				$itemjoinid1 = explode (",", $itemjoinid);
				foreach($itemjoinid1 as $item_code_n)
				{
					$items1.= $this->get_itemjoinid($item_code_n);
				}
				if ($items1 != '') {
					$items1 = substr($items1, 0, -1);
				}
				$items1 = ',"items1":['.$items1.']';
			}
			else
			{
				$items1 = ',"items1":""';
			}
			/****************************************/				
			
			$hotdeals 			=   $row->hotdeals;
			$hotdeals_short 	=   $row->hotdeals_short;
			/************************************************/
			
			$i++;
			if($i%2==0) {
				$css = "search_page_gray"; 
			} else { 
				$css = "search_page_gray1";
			}
$items .= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","date_time":"{$date_time}","title":"{$title}","item_name":"{$item_name}","company_name":"{$company_name}","company_full_name":"{$company_full_name}","image":"{$image}","batchqty":"{$batchqty}","sale_rate":"{$sale_rate}","mrp":"{$mrp}","final_price":"{$final_price}","batch_no":"{$batch_no}","packing":"{$packing}","expiry":"{$expiry}","scheme":"{$scheme}","margin":"{$margin}","featured":"{$featured}","gstper":"{$gstper}","discount":"{$discount}","present":"{$present}","misc_settings":"{$misc_settings}","itemjoinid":"{$itemjoinid}","hotdeals":"{$hotdeals}","css":"{$css}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function my_orders($user_type='',$chemist_id='',$lastid1='')
	{
		$items = "";
		if($lastid1=="kapil")
		{
			if($user_type=="sales")
			{
				$this->db->distinct();
				$this->db->group_by('order_id');
				$this->db->where('selesman_id',$chemist_id);
				$this->db->order_by('id','desc');
				$this->db->limit(8);
				$query = $this->db->get("tbl_order")->result();
			}
			else
			{
				$this->db->distinct();
				$this->db->group_by('order_id');
				$this->db->where('chemist_id',$chemist_id);
				$this->db->order_by('id','desc');
				$this->db->limit(8);
				$query = $this->db->get("tbl_order")->result();
			}
		}
		if($lastid1!="kapil")
		{
			if($user_type=="sales")
			{
				$this->db->distinct();
				$this->db->group_by('order_id');
				$this->db->where('selesman_id',$chemist_id);
				$this->db->where('order_id<',$lastid1);
				$this->db->order_by('id','desc');
				$this->db->limit(8);
				$query = $this->db->get("tbl_order")->result();
			}
			else
			{
				$this->db->distinct();
				$this->db->group_by('order_id');
				$this->db->where('chemist_id',$chemist_id);
				$this->db->where('order_id<',$lastid1);
				$this->db->order_by('id','desc');
				$this->db->limit(8);
				$query = $this->db->get("tbl_order")->result();
			}
		}		

		$i = 1;
		foreach($query as $row)
		{
			$myval = 0;
			$order_id = $row->order_id;
			
			$where1 = array('order_id'=>$order_id,);
			$query1 = $this->Scheme_Model->select_all_result("tbl_order",$where1,"order_id","desc");
			foreach($query1 as $row1)
			{
				$myval = $myval + ($row1->sale_rate * $row1->quantity);
			}
			$total = round($myval,2);
			if($row1->gstvno=="")
			{
				$status = "Pending";
			}
			else
			{
				$status = "Generated";
			}
			$url 		= base64_encode($order_id);
			$gstvno 	= $row1->gstvno;
			$date_time 	= date("d-M-y h:i a",$row1->time);
			$i++;
			if($i%2==0) 
			{ 
				$css = "search_page_gray"; 
			} 
			else
			{
				$css = "search_page_gray1"; 
			}
			
			$where= array('altercode'=>$row1->chemist_id,);
			$row = $this->Scheme_Model->select_row("tbl_acm",$where);
			$where= array('code'=>$row->code);
			$row1 = $this->Scheme_Model->select_row("tbl_acm_other",$where);
			$user_image = constant('img_url_site')."user_profile/$row1->image";
			if(empty($row1->image))
			{
				$user_image = constant('img_url_site')."img_v".constant('site_v')."/logo.png";
			}
			$user_name = "";
			if($user_type=="sales")
			{
				$user_name 		= $row->name;
				$chemist_id 	= $row->altercode;				
			}			

$items.= <<<EOD
{"url":"{$url}","css":"{$css}","order_id":"{$order_id}","gstvno":"{$gstvno}","total":"{$total}","date_time":"{$date_time}","user_type":"{$user_type}","user_name":"{$user_name}","chemist_id":"{$chemist_id}","user_image":"{$user_image}","status":"{$status}"},
EOD;
		}
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function my_orders_view($user_type='',$chemist_id='',$order_id='')
	{
		$items = "";
		if($user_type=="sales")
		{
			$this->db->where('selesman_id',$chemist_id);
			$this->db->where('order_id',$order_id);
			$this->db->order_by('id','desc');
			$query = $this->db->get("tbl_order")->result();
		}
		else
		{
			$this->db->where('chemist_id',$chemist_id);
			$this->db->where('order_id',$order_id);
			$this->db->order_by('id','desc');
			$query = $this->db->get("tbl_order")->result();
		}
		$i = 1;
		foreach($query as $row)
		{
			$i++;
			if($i%2==0) 
			{ 
				$css = "search_page_gray"; 
			} 
			else
			{
				$css = "search_page_gray1"; 
			}
			$item_code 	= $row->item_code;			
			$i_code 	= $row->i_code;
			$ptr 		= $row->sale_rate;
			$qty 		= $row->quantity;
			$total		= round($row->quantity * $row->sale_rate,2);
			$date_time 	= date("d-M-y h:i a",$row->time);
			$acm_name 	= "";
			if($user_type=="sales")
			{
				$where1= array('altercode'=>$row->chemist_id,);
				$row1 = $this->Scheme_Model->select_row("tbl_acm",$where1);
				$acm_name 		= $row1->name;
				$chemist_id 	= $row1->altercode;
			}
			
			$where2 = array('i_code'=>$row->i_code,);
			$row2  = $this->Scheme_Model->select_row("tbl_medicine",$where2);
			$item_name 	= htmlentities(ucwords(strtolower($row2->item_name)));
			$packing 	= htmlentities($row2->packing);
			$expiry 	= htmlentities($row2->expiry);
			$company_full_name 	= htmlentities($row2->company_full_name);

			$get_medicine_image	= 	$this->get_medicine_image($i_code);
			$image = $get_medicine_image[0];
			if(empty($image))
			{
				$image = constant('img_url_site')."uploads/default_img.jpg";
			}

$items.= <<<EOD
{"css":"{$css}","order_id":"{$order_id}","i_code":"{$i_code}","item_code":"{$item_code}","item_name":"{$item_name}","packing":"{$packing}","expiry":"{$expiry}","company_full_name":"{$company_full_name}","image":"{$image}","ptr":"{$ptr}","qty":"{$qty}","total":"{$total}","date_time":"{$date_time}","user_type":"{$user_type}","acm_name":"{$acm_name}","chemist_id":"{$chemist_id}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function check_notification($user_type,$chemist_id)
	{
		/*****************notification message*******************
		/*$row = $this->db->query("select * from tbl_new_notification where chemist_id='$chemist_id' and status='0' order by id desc")->row();
		if($row->id!="")
		{
			$count=1;
			$notiid 	= $row->id;
			$notititle 	= $row->title;
			$notibody 	= $row->message;
			 $this->db->query("update tbl_new_notification set status='1' where id='$notiid'");
		}
		/*****************broadcast message*******************
		$row = $this->db->query("select * from tbl_broadcast where chemist_id='$chemist_id' and user_type='$user_type' and status='0' order by id desc")->row();
		if($row->id!="")
		{
			$broadcastid 		= $row->id;
			$broadcasttitle 	= $row->title;
			$broadcastmessage 	= $row->broadcast;
			$this->db->query("update tbl_broadcast set status='1' where id='$broadcastid'");
		}
		/*****************check block or not*******************
		$query = $this->db->query("select tbl_acm.id,tbl_acm_other.block,tbl_acm_other.status from tbl_acm,tbl_acm_other where altercode='$chemist_id' and tbl_acm.code = tbl_acm_other.code")->row();
		if ($query->id!="")
		{
			$status = "1";
			if($query->block=="1")
			{
				$status = "2";
			}
			if($query->status=="0")
			{
				$status = "0";
			}
		}
$items.= <<<EOD
{"count":"{$count}","status":"{$status}","notiid":"{$notiid}","notititle":"{$notititle}","notibody":"{$notibody}","notitime":"{$notitime}","broadcastid":"{$broadcastid}","broadcasttitle":"{$broadcasttitle}","broadcastmessage":"{$broadcastmessage}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}
		<?php*/
	}
	
	public function my_notification($user_type,$chemist_id,$lastid1)
	{
		$items = "";
		if($lastid1=="kapil")
		{
			$this->db->where('user_type',$user_type);
			$this->db->where('chemist_id',$chemist_id);
			$this->db->where('device_id','default');
			$this->db->order_by('id','desc');
			$this->db->limit(8);
			$query = $this->db->get("tbl_android_notification")->result();
		}
		if($lastid1!="kapil")
		{
			$this->db->where('user_type',$user_type);
			$this->db->where('chemist_id',$chemist_id);
			$this->db->where('device_id','default');
			$this->db->where('id<',$lastid1);
			$this->db->order_by('id','desc');
			$this->db->limit(8);
			$query = $this->db->get("tbl_android_notification")->result();
		}	
		$i = 1;
		foreach($query as $row)
		{
			if($row->status==1) {
				$css = "search_page_gray";
			} else { 
				$css = "search_page_gray1";
			}
			$id				=	$row->id;
			$chemist_id		=	$row->chemist_id;
			$user_type		=	$row->user_type;
			$title			=	($row->title);
			$message		=	($row->message);
			$date_time 		= 	date('d-M h:i A',$row->time);
			$lastid1 		= 	$row->id;
			$url			= 	base64_encode($row->id);
			$image			= 	constant('img_url_site')."img_v".constant('site_v')."/logo.png";
			
$items.= <<<EOD
{"lastid1":"{$lastid1}","id":"{$id}","user_type":"{$user_type}","chemist_id":"{$chemist_id}","title":"{$title}","message":"{$message}","date_time":"{$date_time}","css":"{$css}","url":"{$url}","image":"{$image}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function my_notification_view($notification_id)
	{
		$items = "";
		$this->db->query("update tbl_android_notification set status='1' where id='$notification_id'");
		//$this->db->where('user_type',$user_type);
		//$this->db->where('chemist_id',$chemist_id);
		$this->db->where('device_id','default');
		$this->db->where('id',$notification_id);
		$this->db->order_by('id','desc');
		$this->db->limit(8);
		$query = $this->db->get("tbl_android_notification")->result();
			
		/*$query = $this->db->query("select * from tbl_new_notification where id='$id' and device_id='default' order by id desc limit 1")->result();*/
		foreach($query as $row)
		{
			$id				=	$row->id;
			$user_type		=	$row->user_type;
			$chemist_id		=	$row->chemist_id;
			$title			=	$row->title;
			$message		=	$row->message;
			$date_time 		= 	date('d-M-y h:i A',$row->time);
			
			$funtype		= 	($row->funtype);
			$itemid			= 	($row->itemid);
			$division		= 	($row->division);
			$image1			= 	$row->image;
			$image = $company_full_name = "";
			if($funtype=="2")
			{
				$itemid =  $row->compid;
				$where1= array('compcode'=>$itemid,);
				$row1 = $this->Scheme_Model->select_row("tbl_medicine",$where1);
				/*$row1   =  $this->db->query("select company_full_name from tbl_medicine where compcode='$itemid'")->row();*/
				$company_full_name = ($row1->company_full_name);
				
				$where2= array('compcode'=>$itemid,);
				$row2 = $this->Scheme_Model->select_row("tbl_featured_brand",$where2);
				
				/*$row1  =  $this->db->query("select image from tbl_featured_brand where compcode='$itemid'")->row();*/
				if(!empty($row2->image)){
					$image =  constant('img_url_site')."uploads/manage_featured_brand/photo/resize/".$row2->image;
				}
				else{
					$image = constant('img_url_site')."uploads/manage_users/photo/photo_1562659909.png";
				}
			}
			if(!empty($image1))
			{
				$image =   constant('img_url_site')."uploads/manage_notification/photo/resize/".$image1;
			}
$items.= <<<EOD
{"id":"{$id}","user_type":"{$user_type}","chemist_id":"{$chemist_id}","title":"{$title}","message":"{$message}","date_time":"{$date_time}","image":"{$image}","funtype":"{$funtype}","itemid":"{$itemid}","division":"{$division}","company_full_name":"{$company_full_name}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function website_menu()
	{
		//error_reporting(0);
		$items = "";
		$i = 1;
		$image = "";
		$where = array('status'=>1,);
		$query = $this->Scheme_Model->select_all_result("tbl_medicine_category",$where,"short_order","asc");
		foreach ($query as $row)
		{
			$code		=	$row->code;
			$name		=	base64_encode(ucwords(strtolower($row->menu)));
			$image		=  constant('img_url_site')."uploads/manage_medicine_category/photo/resize/".$row->image;
			if (empty($row->image)){
				$image 			= constant('img_url_site')."uploads/default_img.jpg";
			}
			
$items.= <<<EOD
{"code":"{$code}","name":"{$name}","image":"{$image}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function featured_brand_json()
	{
		//error_reporting(0);
		$items = "";
		$image = "";
		$where = array('status'=>1,);
		$query = $this->Scheme_Model->select_all_result("tbl_featured_brand",$where,"id","RANDOM");
		foreach ($query as $row)
		{
			$id					=	$row->id;
			$compcode			=	($row->compcode);
			$company_full_name	=	base64_encode(ucwords(strtolower($row->company_full_name)));
			$division 			= "";
			$image				=   constant('img_url_site')."uploads/manage_featured_brand/photo/resize/".$row->image;
			if (empty($row->image)){
				$image 			= constant('img_url_site')."uploads/default_img.jpg";
			}
			
$items.= <<<EOD
{"id":"{$id}","compcode":"{$compcode}","company_full_name":"{$company_full_name}","division":"{$division}","image":"{$image}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}

	

	public function new_medicine_this_month()
	{
		//error_reporting(0);
		$items = "";
		$time  = time();
		$vdt60 = date("Y-m-d", strtotime("-60 days", $time));
		
		$this->db->select("m.*,(SELECT DISTINCT featured from tbl_medicine_image where itemid=m.i_code) as featured,(SELECT DISTINCT discount from tbl_company_discount where compcode=m.compcode and tbl_company_discount.status='1') as discount");
		$this->db->where('item_date>=',$vdt60);
		$this->db->order_by("RAND()");
		$this->db->limit('25');
		$query = $this->db->get("tbl_medicine as m")->result();
		foreach ($query as $row)
		{			
			$i_code			=	$row->i_code;
			$item_code		=	$row->item_code;
			$compcode		=	$row->compcode;
			
			$featured		=	$row->featured;
			$discount		=	$row->discount;
			
			//$featured		=  $discount = "";
			if(empty($discount))
			{
				$discount = "4.5";
			}
			$item_name		=	ucwords(strtolower($row->item_name));
			$company_full_name =ucwords(strtolower($row->company_full_name));
			
			$image = constant('img_url_site')."uploads/default_img.jpg";
			$get_medicine_image	= 	$this->get_medicine_image($i_code);
			$image = $get_medicine_image[0];
			if(empty($image))
			{
				$image = constant('img_url_site')."uploads/default_img.jpg";
			}
			
			$packing		=	$row->packing;
			$mrp			=	($row->mrp);
			$sale_rate		=	($row->sale_rate);
			$batchqty		=	$row->batchqty;
			$scheme			=	$row->salescm1."+".$row->salescm2;
			$batch_no		=	$row->batch_no;
			$expiry			=	$row->expiry;
			$gstper			=	$row->gstper;
			
			/*********************yha decount karta h**************/
			$final_price0=  $sale_rate * $discount / 100;
			$final_price0=	$sale_rate - $final_price0;

			/*********************yha gst add karta h**************/
			$final_price=   $final_price0 * $gstper / 100;
			$final_price=	$final_price0 + $final_price;
			$final_price= 	round($final_price,2);

			/***************************************/
			/***************************************/
			$mrp_xx = $mrp;
			if($mrp==0)
			{
				$mrp_xx = 1;
			}
			$margin = $mrp - $final_price;
			$margin = $margin / $mrp_xx;
			$margin = $margin * 100;
			$margin = round($margin);
			/***************************************/
			
			$mrp			=	number_format($row->mrp,2);
			$sale_rate		=	number_format($row->sale_rate,2);
			
$items.= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","image":"{$image}","featured":"{$featured}","packing":"{$packing}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","final_price":"{$final_price}","batchqty":"{$batchqty}","scheme":"{$scheme}","batch_no":"{$batch_no}","expiry":"{$expiry}","margin":"{$margin}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function hot_selling_today_json()
	{
		//error_reporting(0);
		$items = "";
		$query = $this->db->query("select m.*,(SELECT DISTINCT featured from tbl_medicine_image where itemid=m.i_code) as featured,(SELECT DISTINCT discount from tbl_company_discount where compcode=m.compcode and tbl_company_discount.status='1') as discount from tbl_hot_selling INNER JOIN tbl_medicine as m on tbl_hot_selling.item_code=m.i_code order by tbl_hot_selling.id desc,RAND() limit 25")->result();
		//$query = $this->db->query("select m.* from tbl_hot_selling INNER JOIN tbl_medicine as m on tbl_hot_selling.item_code=m.i_code order by tbl_hot_selling.id desc,RAND() limit 25")->result();
		foreach ($query as $row)
		{
			$item_code		=	$row->item_code;
			$item_name		=	ucwords(strtolower($row->item_name));
			$company_full_name =ucwords(strtolower($row->company_full_name));
			
			$featured		=	$row->featured;
			$discount		=	$row->discount;
			
			//$featured		=  $discount = "";			
			if(empty($discount))
			{
				$discount = "4.5";
			}
			
			$i_code			=	$row->i_code;
			$compcode		=	$row->compcode;
			
			$image = constant('img_url_site')."uploads/default_img.jpg";
			$get_medicine_image	= 	$this->get_medicine_image($i_code);
			$image = $get_medicine_image[0];
			if(empty($image))
			{
				$image = constant('img_url_site')."uploads/default_img.jpg";
			}
			
			$packing		=	$row->packing;
			$mrp			=	($row->mrp);
			$sale_rate		=	($row->sale_rate);
			$batchqty		=	$row->batchqty;
			$scheme			=	$row->salescm1."+".$row->salescm2;
			$batch_no		=	$row->batch_no;
			$expiry			=	$row->expiry;
			$gstper			=	$row->gstper;
			
			/*********************yha decount karta h**************/
			$final_price0=  $sale_rate * $discount / 100;
			$final_price0=	$sale_rate - $final_price0;

			/*********************yha gst add karta h**************/
			$final_price=   $final_price0 * $gstper / 100;
			$final_price=	$final_price0 + $final_price;

			$final_price= 	round($final_price,2);

			/***************************************/
			/***************************************/
			$mrp_xx = $mrp;
			if($mrp==0)
			{
				$mrp_xx = 1;
			}
			$margin = $mrp - $final_price;
			$margin = $margin / $mrp_xx;
			$margin = $margin * 100;
			$margin = round($margin);
			/***************************************/
			
			$mrp			=	number_format($row->mrp,2);
			$sale_rate		=	number_format($row->sale_rate,2);
			
$items.= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","image":"{$image}","featured":"{$featured}","packing":"{$packing}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","final_price":"{$final_price}","batchqty":"{$batchqty}","scheme":"{$scheme}","batch_no":"{$batch_no}","expiry":"{$expiry}","margin":"{$margin}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function must_buy_medicines_json()
	{
		//error_reporting(0);
		$items = "";
		$date = date("Y-m-d");
		
		$sameid = "";
		$query = $this->db->query("select DISTINCT i_code, COUNT(*) as `quantity` FROM tbl_order where date='$date' GROUP BY item_name HAVING COUNT(*) > 1 order by quantity desc,RAND() limit 25")->result();
		foreach ($query as $row)
		{
			$sameid.=$row->i_code.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = "m.i_code in(".$sameid.")";
		}
		
		if(!empty($sameid))
		{
			$this->db->select("m.*,(SELECT DISTINCT featured from tbl_medicine_image where itemid=m.i_code) as featured,(SELECT DISTINCT discount from tbl_company_discount where compcode=m.compcode and tbl_company_discount.status='1') as discount");
			//$this->db->select("m.*");
			$this->db->where($sameid);
			$this->db->order_by("RAND()");
			$this->db->limit('25');
			$query = $this->db->get("tbl_medicine as m")->result();
			foreach ($query as $row)
			{				
				$i_code			=	$row->i_code;
				$item_code		=	$row->item_code;
				$compcode		=	$row->compcode;
				
				$featured		=	$row->featured;
				$discount		=	$row->discount;
				
				//$featured		=  $discount = "";
				if(empty($discount))
				{
					$discount = "4.5";
				}
				
				$item_name		=	ucwords(strtolower($row->item_name));
				$company_full_name =ucwords(strtolower($row->company_full_name));
				
				$image = constant('img_url_site')."uploads/default_img.jpg";
				$get_medicine_image	= 	$this->get_medicine_image($i_code);
				$image = $get_medicine_image[0];
				if(empty($image))
				{
					$image = constant('img_url_site')."uploads/default_img.jpg";
				}
				
				$packing		=	$row->packing;
				$mrp			=	($row->mrp);
				$sale_rate		=	($row->sale_rate);
				$batchqty		=	$row->batchqty;
				$scheme			=	$row->salescm1."+".$row->salescm2;
				$batch_no		=	$row->batch_no;
				$expiry			=	$row->expiry;
				$gstper			=	$row->gstper;
				
				/*********************yha decount karta h**************/
				$final_price0=  $sale_rate * $discount / 100;
				$final_price0=	$sale_rate - $final_price0;

				/*********************yha gst add karta h**************/
				$final_price=   $final_price0 * $gstper / 100;
				$final_price=	$final_price0 + $final_price;

				$final_price= 	round($final_price,2);

				/***************************************/
				/***************************************/
				$mrp_xx = $mrp;
				if($mrp==0)
				{
					$mrp_xx = 1;
				}
				$margin = $mrp - $final_price;
				$margin = $margin / $mrp_xx;
				$margin = $margin * 100;
				$margin = round($margin);
				/***************************************/
				
				$mrp			=	number_format($row->mrp,2);
				$sale_rate		=	number_format($row->sale_rate,2);
			
$items.= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","image":"{$image}","featured":"{$featured}","packing":"{$packing}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","final_price":"{$final_price}","batchqty":"{$batchqty}","scheme":"{$scheme}","batch_no":"{$batch_no}","expiry":"{$expiry}","margin":"{$margin}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
	return $items;
	}

	public function frequently_use_medicines_json()
	{
		//error_reporting(0);
		$items = "";
		
		$sameid = "";
		$query = $this->db->query("select * from tbl_must_buy_medicines where status='1'")->result();
		foreach ($query as $row)
		{
			$sameid.=$row->itemid.",";
		}
		$sameid = substr($sameid,0,-1);
		if(!empty($sameid))
		{
			$sameid = "m.i_code in(".$sameid.")";
		}
		
		if(!empty($sameid))
		{
			$this->db->select("m.*,(SELECT DISTINCT featured from tbl_medicine_image where itemid=m.i_code) as featured,(SELECT DISTINCT discount from tbl_company_discount where compcode=m.compcode and tbl_company_discount.status='1') as discount");
			//$this->db->select("m.*");
			$this->db->where($sameid);
			$this->db->order_by("RAND()");
			$this->db->limit('25');
			$query = $this->db->get("tbl_medicine as m")->result();
			foreach ($query as $row)
			{				
				$i_code			=	$row->i_code;
				$item_code		=	$row->item_code;
				$compcode		=	$row->compcode;
				
				/*$featured		=	$row->featured;
				$discount		=	$row->discount;*/
				
				$featured		=  $discount = "";
				if(empty($discount))
				{
					$discount = "4.5";
				}
				
				
				$item_name		=	ucwords(strtolower($row->item_name));
				$company_full_name =ucwords(strtolower($row->company_full_name));
				
				$image = constant('img_url_site')."uploads/default_img.jpg";
				$get_medicine_image	= 	$this->get_medicine_image($i_code);
				$image = $get_medicine_image[0];
				if(empty($image))
				{
					$image = constant('img_url_site')."uploads/default_img.jpg";
				}
				
				$packing		=	$row->packing;
				$mrp			=	($row->mrp);
				$sale_rate		=	($row->sale_rate);
				$batchqty		=	$row->batchqty;
				$scheme			=	$row->salescm1."+".$row->salescm2;
				$batch_no		=	$row->batch_no;
				$expiry			=	$row->expiry;
				$gstper			=	$row->gstper;
				
				/*********************yha decount karta h**************/
				$final_price0=  $sale_rate * $discount / 100;
				$final_price0=	$sale_rate - $final_price0;

				/*********************yha gst add karta h**************/
				$final_price=   $final_price0 * $gstper / 100;
				$final_price=	$final_price0 + $final_price;

				$final_price= 	round($final_price,2);

				/***************************************/
				/***************************************/
				$mrp_xx = $mrp;
				if($mrp==0)
				{
					$mrp_xx = 1;
				}
				$margin = $mrp - $final_price;
				$margin = $margin / $mrp_xx;
				$margin = $margin * 100;
				$margin = round($margin);
				/***************************************/
				
				$mrp			=	number_format($row->mrp,2);
				$sale_rate		=	number_format($row->sale_rate,2);
			
$items.= <<<EOD
{"i_code":"{$i_code}","item_code":"{$item_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","image":"{$image}","featured":"{$featured}","packing":"{$packing}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","final_price":"{$final_price}","batchqty":"{$batchqty}","scheme":"{$scheme}","batch_no":"{$batch_no}","expiry":"{$expiry}","margin":"{$margin}"},
EOD;
			}
if ($items != '') {
	$items = substr($items, 0, -1);
}
		}
	return $items;
	}
	
	public function featured_brand($compcode,$division,$orderby)
	{
		//error_reporting(0);
		//$this->db->order_by('batchqty','desc');
		if($orderby=="not")
		{			
			if($division=="")
			{
				$this->db->order_by('item_name','asc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('item_name','asc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_price")
		{
			if($division=="")
			{
				$this->db->order_by('mrp','asc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('mrp','asc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_price1")
		{
			if($division=="")
			{
				$this->db->order_by('mrp','desc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('mrp','desc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_margin")
		{
			if($division=="")
			{
				$this->db->order_by('margin','asc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('margin','asc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_margin1")
		{
			if($division=="")
			{
				$this->db->order_by('margin','desc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('margin','desc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_atoz")
		{
			if($division=="")
			{
				$this->db->order_by('item_name','asc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{
				$this->db->order_by('item_name','asc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		if($orderby=="sort_ztoa")
		{
			if($division=="")
			{
				$this->db->order_by('item_name','desc');
				$this->db->where('compcode',$compcode);
				//$this->db->where('division',$division);
			}
			else
			{				
				$this->db->order_by('item_name','desc');
				$this->db->where('compcode',$compcode);
				$this->db->where('division',$division);
			}
		}
		$this->db->where('status','1');
		$query = $this->db->get("tbl_medicine")->result();
		$i = 0;
		$items = "";
		foreach ($query as $row)
		{
			if(substr($row->item_name,0,1)==".")
			{
			}
			else
			{
				if($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000")
				{					

				}
				else
				{
					if($row->sale_rate=="0" || $row->sale_rate=="0.0")
					{
					}
					else
					{						
						$id			=	$row->id;
						$compcode	=	$row->compcode;
						$i_code		=	$row->i_code;
						
						$get_medicine_image	= 	$this->get_medicine_image($i_code);
						$featured 	= 	$this->Chemist_Model->get_medicine_featured($i_code);
						$discount 	= 	$this->Chemist_Model->get_company_discount($compcode);
						
						$image = $get_medicine_image[0];
						if(empty($image))
						{
							$image = constant('img_url_site')."uploads/default_img.jpg";
						}
						if($featured=="1")
						{
							$i++;
							if($i<4)
							{								
								$sameid[$id]    =	$id;
								$item_name		=	ucwords(strtolower($row->item_name));						
								$company_full_name = ucwords(strtolower($row->company_full_name));
								$item_code		=	$row->item_code;
								$mrp			=	($row->mrp);
								$sale_rate		=	($row->sale_rate);
								$batchqty		=	$row->batchqty;
								$packing		=	$row->packing;
								$expiry			=	$row->expiry;
								$scheme			=	$row->salescm1."+".$row->salescm2;
								$gstper			=	$row->gstper;
								
								/*********************yha decount karta h**************/
								$final_price0=  $sale_rate * $discount / 100;
								$final_price0=	$sale_rate - $final_price0;
								
								/*********************yha gst add karta h**************/
								$final_price=   $final_price0 * $gstper / 100;
								$final_price=	$final_price0 + $final_price;
								
								$final_price= 	round($final_price,2);
								
								/***************************************/
								/***************************************/
								$mrp_xx = $mrp;
								if($mrp==0)
								{
									$mrp_xx = 1;
								}
								$margin = $mrp - $final_price;
								$margin = $margin / $mrp_xx;
								$margin = $margin * 100;
								$margin = round($margin);
								/***************************************/
								/***************************************/
								$mrp			=	number_format($row->mrp,2);
								$sale_rate		=	number_format($row->sale_rate,2);

$items .= <<<EOD
{"i_code":"{$i_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","batchqty":"{$batchqty}","packing":"{$packing}","expiry":"{$expiry}","image":"{$image}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","margin":"{$margin}","scheme":"{$scheme}","featured":"{$featured}","final_price":"{$final_price}"},
EOD;
							}
						}
					}
				}
			}
		}
		foreach ($query as $row)
		{
			if(substr($row->item_name,0,1)==".")
			{
			}
			else
			{
				if($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000")
				{					

				}
				else
				{
					if($row->sale_rate=="0" || $row->sale_rate=="0.0")
					{
					}
					else
					{						
						$id			=	$row->id;						
						$compcode	=	$row->compcode;
						$i_code		=	$row->i_code;
						$get_medicine_image	= 	$this->get_medicine_image($i_code);
						$featured 	= 	$this->Chemist_Model->get_medicine_featured($i_code);
						$discount 	= 	$this->Chemist_Model->get_company_discount($compcode);
						$image = $get_medicine_image[0];
						if(empty($image))
						{
							$image = constant('img_url_site')."uploads/default_img.jpg";
						}
						
						$item_name		=	ucwords(strtolower($row->item_name));						
						$company_full_name = ucwords(strtolower($row->company_full_name));
						$item_code		=	$row->item_code;
						$mrp			=	($row->mrp);
						$sale_rate		=	($row->sale_rate);
						$batchqty		=	$row->batchqty;
						$packing		=	$row->packing;
						$expiry			=	$row->expiry;
						$scheme			=	$row->salescm1."+".$row->salescm2;
						$gstper			=	$row->gstper;
						
						/*********************yha decount karta h**************/
						$final_price0=  $sale_rate * $discount / 100;
						$final_price0=	$sale_rate - $final_price0;
						
						/*********************yha gst add karta h**************/
						$final_price=   $final_price0 * $gstper / 100;
						$final_price=	$final_price0 + $final_price;
						
						$final_price= 	round($final_price,2);
						/***************************************/
						/***************************************/
						$mrp_xx = $mrp;
						if($mrp==0)
						{
							$mrp_xx = 1;
						}
						$margin = $mrp - $final_price;
						$margin = $margin / $mrp_xx;
						$margin = $margin * 100;
						$margin = round($margin);
						/***************************************/
						/***************************************/
						
						$mrp			=	number_format($row->mrp,2);
						$sale_rate		=	number_format($row->sale_rate,2);
						
						if(empty($sameid[$id]))
						{
$items .= <<<EOD
{"i_code":"{$i_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","batchqty":"{$batchqty}","packing":"{$packing}","expiry":"{$expiry}","image":"{$image}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","margin":"{$margin}","scheme":"{$scheme}","featured":"{$featured}","final_price":"{$final_price}"},
EOD;
						}
					}
				}
			}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function medicine_category($itemcat='',$orderby='')
	{
		//error_reporting(0);
		//$this->db->order_by('batchqty','desc');
		if($orderby=="not")
		{
			$this->db->order_by('item_name','asc');
		}
		if($orderby=="sort_price")
		{
			$this->db->order_by('mrp','asc');
		}
		if($orderby=="sort_price1")
		{
			$this->db->order_by('mrp','desc');
		}
		if($orderby=="sort_margin")
		{
			$this->db->order_by('margin','asc');
		}
		if($orderby=="sort_margin1")
		{
			$this->db->order_by('margin','desc');
		}
		if($orderby=="sort_atoz")
		{
			$this->db->order_by('item_name','asc');
		}
		if($orderby=="sort_ztoa")
		{
			$this->db->order_by('item_name','desc');
		}
		$this->db->where('itemcat',$itemcat);
		$this->db->where('status','1');
		$query = $this->db->get("tbl_medicine")->result();
		$i = 0;
		$items = "";
		foreach ($query as $row)
		{
			if(substr($row->item_name,0,1)==".")
			{
			}
			else
			{
				if($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000")
				{					

				}
				else
				{
					if($row->sale_rate=="0" || $row->sale_rate=="0.0")
					{
					}
					else
					{						
						$id			=	$row->id;
						$compcode	=	$row->compcode;
						$i_code		=	$row->i_code;
						$get_medicine_image	= 	$this->get_medicine_image($i_code);
						$featured 	= 	$this->Chemist_Model->get_medicine_featured($i_code);
						$discount 	= 	$this->Chemist_Model->get_company_discount($compcode);
						$image = $get_medicine_image[0];
						if(empty($image))
						{
							$image = constant('img_url_site')."uploads/default_img.jpg";
						}
						if($featured=="1")
						{
							$i++;
							if($i<4)
							{								
								$sameid[$id]    =	$id;
								$item_name		=	ucwords(strtolower($row->item_name));						
								$company_full_name = ucwords(strtolower($row->company_full_name));
								$item_code		=	$row->item_code;
								$mrp			=	($row->mrp);
								$sale_rate		=	($row->sale_rate);
								$batchqty		=	$row->batchqty;
								$packing		=	$row->packing;
								$expiry			=	$row->expiry;
								$scheme			=	$row->salescm1."+".$row->salescm2;
								$gstper			=	$row->gstper;
								
								/*********************yha decount karta h**************/
								$final_price0=  $sale_rate * $discount / 100;
								$final_price0=	$sale_rate - $final_price0;
								
								/*********************yha gst add karta h**************/
								$final_price=   $final_price0 * $gstper / 100;
								$final_price=	$final_price0 + $final_price;
								
								$final_price= 	round($final_price,2);
								
								/***************************************/
								/***************************************/
								$mrp_xx = $mrp;
								if($mrp==0)
								{
									$mrp_xx = 1;
								}
								$margin = $mrp - $final_price;
								$margin = $margin / $mrp_xx;
								$margin = $margin * 100;
								$margin = round($margin);
								/***************************************/
								/***************************************/
								$mrp			=	number_format($row->mrp,2);
								$sale_rate		=	number_format($row->sale_rate,2);

$items .= <<<EOD
{"i_code":"{$i_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","batchqty":"{$batchqty}","packing":"{$packing}","expiry":"{$expiry}","image":"{$image}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","margin":"{$margin}","scheme":"{$scheme}","featured":"{$featured}","final_price":"{$final_price}"},
EOD;
							}
						}
					}
				}
			}
		}
		foreach ($query as $row)
		{
			if(substr($row->item_name,0,1)==".")
			{
			}
			else
			{
				if($row->misc_settings=="#ITNOTE" && $row->batchqty=="0.000")
				{					

				}
				else
				{
					if($row->sale_rate=="0" || $row->sale_rate=="0.0")
					{
					}
					else
					{						
						$id			=	$row->id;						
						$compcode	=	$row->compcode;
						$i_code		=	$row->i_code;
						$get_medicine_image	= 	$this->get_medicine_image($i_code);
						$featured 	= 	$this->Chemist_Model->get_medicine_featured($i_code);
						$discount 	= 	$this->Chemist_Model->get_company_discount($compcode);
						$image = $get_medicine_image[0];
						if(empty($image))
						{
							$image = constant('img_url_site')."uploads/default_img.jpg";
						}
						
						$item_name		=	ucwords(strtolower($row->item_name));						
						$company_full_name = ucwords(strtolower($row->company_full_name));
						$item_code		=	$row->item_code;
						$mrp			=	($row->mrp);
						$sale_rate		=	($row->sale_rate);
						$batchqty		=	$row->batchqty;
						$packing		=	$row->packing;
						$expiry			=	$row->expiry;
						$scheme			=	$row->salescm1."+".$row->salescm2;
						$gstper			=	$row->gstper;
						
						/*********************yha decount karta h**************/
						$final_price0=  $sale_rate * $discount / 100;
						$final_price0=	$sale_rate - $final_price0;
						
						/*********************yha gst add karta h**************/
						$final_price=   $final_price0 * $gstper / 100;
						$final_price=	$final_price0 + $final_price;
						
						$final_price= 	round($final_price,2);
						/***************************************/
						/***************************************/
						$mrp_xx = $mrp;
						if($mrp==0)
						{
							$mrp_xx = 1;
						}
						$margin = $mrp - $final_price;
						$margin = $margin / $mrp_xx;
						$margin = $margin * 100;
						$margin = round($margin);
						/***************************************/
						/***************************************/
						
						$mrp			=	number_format($row->mrp,2);
						$sale_rate		=	number_format($row->sale_rate,2);
						
						if(empty($sameid[$id]))
						{
$items .= <<<EOD
{"i_code":"{$i_code}","item_name":"{$item_name}","company_full_name":"{$company_full_name}","batchqty":"{$batchqty}","packing":"{$packing}","expiry":"{$expiry}","image":"{$image}","mrp":"{$mrp}","sale_rate":"{$sale_rate}","margin":"{$margin}","scheme":"{$scheme}","featured":"{$featured}","final_price":"{$final_price}"},
EOD;
						}
					}
				}
			}
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function my_invoices($user_type,$chemist_id,$lastid1)
	{
		$items = "";
		if($lastid1=="kapil")
		{
			if($user_type=="sales")
			{
				
			}
			else
			{
				//$this->db->distinct();
				//$this->db->group_by('order_id');
				$this->db->where('altercode',$chemist_id);
				$this->db->order_by('id','desc');
				$this->db->limit(8);
				$query = $this->db->get("tbl_invoice")->result();
			}
		}
		if($lastid1!="kapil")
		{
			if($user_type=="sales")
			{
				
			}
			else
			{
				$this->db->where('altercode',$chemist_id);
				$this->db->where('id<',$lastid1);
				$this->db->order_by('id','desc');
				$this->db->limit(8);
				$query = $this->db->get("tbl_invoice")->result();
			}
		}		

		$i = 1;
		foreach($query as $row)
		{
			$id		= $row->id;
			$gstvno = $row->gstvno;
			$total 	= number_format($row->amt,2);
			$url 	= ($chemist_id)."/".($gstvno);
			$date_time 	= date("d-M-y",strtotime($row->date));
			$i++;
			if($i%2==0) 
			{ 
				$css = "search_page_gray"; 
			} 
			else
			{
				$css = "search_page_gray1"; 
			}		
			$status = "Generated";
$items.= <<<EOD
{"url":"{$url}","css":"{$css}","id":"{$id}","gstvno":"{$gstvno}","total":"{$total}","date_time":"{$date_time}","user_type":"{$user_type}","status":"{$status}"},
EOD;
		}
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function my_invoices_view($user_type,$chemist_id,$gstvno)
	{
		$items = "";
		$this->db->where('altercode',$chemist_id);
		$this->db->where('gstvno',$gstvno);
		$row = $this->db->get("tbl_invoice")->row();
		if($row->id!="")
		{
			$inv_type 	= "insert";
			$id			= $row->id;
			$gstvno 	= $row->gstvno;
			$date_time 	= date("d-M-y",strtotime($row->date));
			$total 		= number_format($row->amt,2);
			$excelFile 	= "./upload_invoice/".$gstvno.".xls";
			$excelFile_download = constant('main_site')."user/download_invoice/".$chemist_id."/".$gstvno;
			
			$excelFile_delete 	= "./upload_invoice/delete_".$gstvno.".xls";
			
			$name = substr($row->name,0,19);
			$file_name = "_D.R.DISTRIBUTORS PVT_".$name.".xls";
			
			$download_excel_url =  "<a href='".$excelFile_download."'><button type='button' class='btn btn-warning btn-block'>Download Excel</button></a>";
			$download_excel_url = base64_encode($download_excel_url);
			$status = "Generated";
				
			$item_name_r 	= "G";
			$batch_r 		= "I";
			$expiry_r 		= "J";
			$qty_r 			= "K";
			$fqty_r			= "L";
			$mrp_r 			= "U";
			$cgst_r 		= "AA";
			$sgst_r 		= "AB";
			$igst_r 		= "AC";
			
			$i = 1;
			$headername = 2;
			$this->load->library('excel');
			$objPHPExcel = PHPExcel_IOFactory::load($excelFile);
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
			{
				$highestRow = $worksheet->getHighestRow();
				for ($row=$headername; $row<=$highestRow; $row++)
				{
					$i++;
					if($i%2==0) 
					{ 
						$css = "search_page_gray"; 
					} 
					else
					{
						$css = "search_page_gray1"; 
					}
					
					$item_name 	= $worksheet->getCell($item_name_r.$row)->getValue();
					$batch 		= $worksheet->getCell($batch_r.$row)->getValue();
					$expiry 	= $worksheet->getCell($expiry_r.$row)->getValue();
					$qty 		= $worksheet->getCell($qty_r.$row)->getValue();
					$fqty 		= $worksheet->getCell($fqty_r.$row)->getValue();
					$mrp 		= $worksheet->getCell($mrp_r.$row)->getValue();
					$mrp1		= $mrp * 12 / 100;
					$mrp		= round($mrp + $mrp1,2);
					$item_name = base64_encode($item_name);
$items.= <<<EOD
{"css":"{$css}","download_excel_url":"{$download_excel_url}","gstvno":"{$gstvno}","date":"{$date_time}","total_price":"{$total}","status":"{$status}","inv_type":"{$inv_type}","item_name":"{$item_name}","batch":"{$batch}","expiry":"{$expiry}","qty":"{$qty}","fqty":"{$fqty}","mrp":"{$mrp}"},
EOD;
				}
			}
			
			if(file_exists($excelFile_delete)=="1")
			{
				$item_name_r 	  = "B";
				$delete_descp_r   = "I";
				$delete_amt_r 	  = "F";
				$delete_namt_r 	  = "G";
				$delete_remarks_r = "H";
				
				$i = 1;
				$headername = 2;
				$objPHPExcel = PHPExcel_IOFactory::load($excelFile_delete);
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$i++;
						if($i%2==0) 
						{ 
							$css = "search_page_gray"; 
						} 
						else
						{
							$css = "search_page_gray1"; 
						}
						
						$item_name 	  	= $worksheet->getCell($item_name_r.$row)->getValue();
						$delete_descp 	= $worksheet->getCell($delete_descp_r.$row)->getValue();
						$delete_amt   	= $worksheet->getCell($delete_amt_r.$row)->getValue();
						$delete_namt  	= $worksheet->getCell($delete_namt_r.$row)->getValue();
						$delete_remarks = $worksheet->getCell($delete_remarks_r.$row)->getValue();
						
						$item_name = base64_encode($item_name);
						$inv_type = "delete";
					
$items.= <<<EOD
{"inv_type":"{$inv_type}","css":"{$css}","item_name":"{$item_name}","delete_descp":"{$delete_descp}","delete_amt":"{$delete_amt}","delete_namt":"{$delete_namt}","delete_remarks":"{$delete_remarks}"},
EOD;
					}
				}
			}
		}
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}
	
	public function check_download_invoice($user_type,$chemist_id,$lastid1,$gstvno)
	{
		$download = "no";
		$this->db->where('altercode',$chemist_id);
		$this->db->where('gstvno',$gstvno);
		$row = $this->db->get("tbl_invoice")->row();	
		if($row->id!="")
		{
			$download = "yes";
		}
$items.= <<<EOD
{"download":"{$download}"},
EOD;
if ($items != ''){
	$items = substr($items, 0, -1);
}
	return $items;
	}
}