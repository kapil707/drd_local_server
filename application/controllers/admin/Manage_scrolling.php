<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_scrolling extends CI_Controller {

	var $Page_title = "Scrolling Ads";
	var $Page_name  = "manage_scrolling";
	var $Page_view  = "manage_scrolling";
	var $Page_menu  = "manage_scrolling";
	var $page_controllers = "manage_scrolling";
	var $Page_tbl   = "tbl_scrolling";
	public function index()
	{
		$page_controllers = $this->page_controllers;
		redirect("admin/$page_controllers/view");
	}	
	public function add()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/
		
		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;
		
		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);
		
		$data['title1'] = $Page_title." || Add";
		$data['title2'] = "Add";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;		
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Add","admin/$page_controllers/add");
		
		$tbl = $Page_tbl;
		
		$data['dir'] = $dir = 'G:/sky/scrollingads/';	
		$display = 1;
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			
			$title = $path;
			$title = pathinfo($title, PATHINFO_FILENAME); 
			$path = $dir.$path;
			$page_type = "ScrollingAds";
			
			$title = base64_encode($title);
			$path  = base64_encode($path);
			
			$start_date	= "$startdate $starttime";
			$end_date	= "$enddate $endtime";
			
			$startdate = DateTime::createFromFormat("d-M-Y", $startdate);
			$startdate = $startdate->format('Ymd');			
			
			$starttime1 = substr($starttime,0,2);
			$starttime2 = substr($starttime,3,2);
			
			$start_date1	= "$startdate$starttime1$starttime2";
			
			$enddate = DateTime::createFromFormat("d-M-Y", $enddate);
			$enddate = $enddate->format('Ymd');
			
			$endtime1 = substr($endtime,0,2);
			$endtime2 = substr($endtime,3,2);
			
			$end_date1	= "$enddate$endtime1$endtime2";
			
			$result = "";
			$dt = array(
			'title'=>$title,
			'path'=>$path,
			'theme'=>$theme,
			'page_type'=>$page_type,
			'display'=>$display,
			'start_date'=>$start_date,
			'end_date'=>$end_date,
			'start_date1'=>$start_date1,
			'end_date1'=>$end_date1,
			);
			$result = $this->Scheme_Model->insert_fun($tbl,$dt);
			if($result)
			{
				$message_db = "($property_title) -  Add Successfully.";
				$message = "Add Successfully.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message_db = "($property_title) - Not Add.";
				$message = "Not Add.";
				$this->session->set_flashdata("message_type","error");
			}
			if($message_db!="")
			{
				$message = $Page_title." - ".$message;
				$message_db = $Page_title." - ".$message_db;
				$this->session->set_flashdata("message_footer","yes");
				$this->session->set_flashdata("full_message",$message);
				$this->Admin_Model->Add_Activity_log($message_db);
				if($result)
				{
					redirect(base_url()."admin/$page_controllers/view");
				}
			}
		}
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/add",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	public function view()
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/
		
		$_SESSION["latitude"] = 
		$_SESSION["longitude"] = "";
		
		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;
		
		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);
		
		$data['title1'] = $Page_title." || View";
		$data['title2'] = "View";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;		
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");
		
		$tbl = $Page_tbl;
		
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";
		
		extract($_POST);
		if(isset($Delete))
		{	
			$where = array('id'=>$delete_id,'status'=>"5",'school_id'=>$school_id);
			$this->Scheme_Model->delete_fun($tbl,$where);
			
			$where = array('id'=>$delete_id,'school_id'=>$school_id);					
			$dt = array('status'=>"5");
			$this->Scheme_Model->edit_fun($tbl,$dt,$where);			
		}
				
		$query = $this->db->query("select * from $tbl where page_type='ScrollingAds' order by id desc");
  		$data["result"] = $query->result();
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	public function edit($id)
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/
		
		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;
		
		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);
		
		$data['title1'] = $Page_title." || Edit";
		$data['title2'] = "Edit";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;		
		$this->breadcrumbs->push("Edit","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Edit","admin/$page_controllers/edit");
		
		$tbl = $Page_tbl;
		
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";
		$upload_thumbs_path = "./uploads/$page_controllers/photo/thumbs/";
		
		$system_ip = $this->input->ip_address();
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			$this->form_validation->set_rules('name','Name',"required");			
			/*if($old_sort_order!=$sort_order)
			{
				$this->form_validation->set_rules('sort_order','Sort Order','required|trim|callback_sort_order_check|numeric|greater_than[0]');
			}*/
			if ($this->form_validation->run() == FALSE)
			{
				$message = "Check Validation.";
				$this->session->set_flashdata("message_type","warning");
			}
			else
			{
				$time = time();
				$date = date("Y-m-d",$time);
				$where = array('id'=>$id);

				/*if (!empty($_FILES["image"]["name"]))
				{
					$img = "image";			
					$url_path = "./uploads/$page_controllers/photo/";
					
					$query = $this->db->query("select * from $tbl where id='$id'");
					$row11 = $query->row();
					$filename = $url_path.$row11->$img;
					unlink($filename);
					
					$name1 = "photo";
					$imagename = $_FILES["image"]['name'];
					$uploadedfile = $_FILES["image"]['tmp_name'];
					$image = "";
					
					$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
					$ext = strtolower($this->Scheme_Model->getExtension($imagename));
					if(in_array($ext,$valid_formats))
					{
						//$ext = "jpeg";
						$actual_image_name = $name1."_".time().".".$ext;
						$widthArray = array(600);
						foreach($widthArray as $newwidth)
						{
							$image = $this->Scheme_Model->compressImage($ext,$uploadedfile,$upload_path,$actual_image_name,$newwidth);
							$image = $newwidth."_".$image; 
						}
					}
				}		
				else
				{
					$image = $old_image;
				}*/
				
				//$name = ucwords(strtolower($name));
				
				$result = "";
				$dt = array(
				'sort_order'=>$sort_order,
				'url'=>$url,
				'name'=>$name,
				'image'=>$image,
				'description'=>$description,
				'status'=>$status,
				'update_date'=>$date,
				'update_time'=>$time,
				'system_ip'=>$system_ip,
				);
				$result = $this->Scheme_Model->edit_fun($tbl,$dt,$where);
				
				$property_title = base64_decode($property_title);
				$address = base64_decode($address);
				$description = base64_decode($description);
				
				$old_property_title = base64_decode($old_property_title);
				$old_address = base64_decode($old_address);
				$old_description = base64_decode($old_description);
				
				$change_text = "";
				
				
				$change_text = $old_property_title." - ($change_text)";
				
				if($result)
				{
					$message_db = "$change_text - Edit Successfully.";
					$message = "Edit Successfully.";
					$this->session->set_flashdata("message_type","success");
				}
				else
				{
					$message_db = "$change_text - Not Add.";
					$message = "Not Add.";
					$this->session->set_flashdata("message_type","error");
				}
			}
			if($message_db!="")
			{
				$message = $Page_title." - ".$message;
				$message_db = $Page_title." - ".$message_db;
				$this->session->set_flashdata("message_footer","yes");
				$this->session->set_flashdata("full_message",$message);
				$this->Admin_Model->Add_Activity_log($message_db);
				if($result)
				{
					redirect(current_url());
					//redirect(base_url()."admin/$page_controllers/view");
				}
			}
		}
		
		$query = $this->db->query("select * from $tbl where id='$id'");
  		$data["result"] = $query->result();
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/edit",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function delete_rec()
	{
		$id = $_POST["id"];
		$Page_title = $this->Page_title;
		$Page_tbl = $this->Page_tbl;
		$result = $this->db->query("delete from $Page_tbl where id='$id'");
		$this->db->query("delete from tbl_schedule_time where video_id='$id'");
		if($result)
		{
			$message = "Delete Successfully.";
		}
		else
		{
			$message = "Not Delete.";
		}
		$message = $Page_title." - ".$message;
		$this->Admin_Model->Add_Activity_log($message);
		echo "ok";
	}
	
	public function setcopy($id="")
	{
		error_reporting(0);
		/******************session***********************/
		$user_id = $this->session->userdata("user_id");
		$user_type = $this->session->userdata("user_type");
		/******************session***********************/
		
		$_SESSION["latitude"] = 
		$_SESSION["longitude"] = "";
		
		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;
		
		$this->Admin_Model->permissions_check_or_set($Page_title,$Page_name,$user_type);
		
		$data['title1'] = $Page_title." || View";
		$data['title2'] = "View";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;		
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("View","admin/$page_controllers/view");
		
		$tbl = $Page_tbl;
		
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";
		
		extract($_POST);
		if(isset($Submit))
		{	
			$page_type = "ScrollingAds";
			
			$result = "";
			$dt = array(
			'category_id'=>$category_id,
			'page_type'=>$page_type,
			'copy_id'=>$id,
			);
			$result = $this->Scheme_Model->insert_fun("tbl_category_copy",$dt);
			if($result)
			{
				$message_db = "($property_title) -  Add Successfully.";
				$message = "Add Successfully.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message_db = "($property_title) - Not Add.";
				$message = "Not Add.";
				$this->session->set_flashdata("message_type","error");
			}
			if($message_db!="")
			{
				$message = $Page_title." - ".$message;
				$message_db = $Page_title." - ".$message_db;
				$this->session->set_flashdata("message_footer","yes");
				$this->session->set_flashdata("full_message",$message);
				$this->Admin_Model->Add_Activity_log($message_db);
				if($result)
				{
					redirect(current_url());
				}
			}
		}
				
		$query = $this->db->query("select * from tbl_category_copy where page_type='ScrollingAds' and copy_id='$id' order by id desc");
  		$data["result"] = $query->result();
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/setcopy",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function delete_category_copy_rec()
	{
		$id = $_POST["id"];
		$result = $this->db->query("delete from tbl_category_copy where id='$id'");
		if($result)
		{
			$message = "Delete Successfully.";
		}
		else
		{
			$message = "Not Delete.";
		}
		$message = $Page_title." - ".$message;
		$this->Admin_Model->Add_Activity_log($message);
		echo "ok";
	}
}