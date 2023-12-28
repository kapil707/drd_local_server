<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_movies extends CI_Controller {

	var $Page_title = "Manage movies";
	var $Page_name  = "manage_movies";
	var $Page_view  = "manage_movies";
	var $Page_menu  = "manage_movies";
	var $page_controllers = "manage_movies";
	var $Page_tbl   = "tbl_songs_movies";
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
		
		$data['dir'] = $dir = 'G:/sky/news/';		
		$display = 1;
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			
			$title = $path;
			$title = pathinfo($title, PATHINFO_FILENAME); 
			$path = $dir.$path;
			$page_type = "Movies";
			
			$title = base64_encode($title);
			$path  = base64_encode($path);
			
			$result = "";
			$dt = array(
			'category_id'=>$category_id,
			'page_type'=>$page_type,
			'title'=>$title,
			'path'=>$path,
			'display'=>$display,
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
				
		$query = $this->db->query("select * from $tbl where page_type='Movies' order by id desc");
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
	
	public function settime($id)
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
		
		$data['url_path'] 	= base_url()."uploads/$page_controllers/photo/resize/";
		$upload_path 		= "./uploads/$page_controllers/photo/main/";
		$upload_resize 		= "./uploads/$page_controllers/photo/resize/";
		
		$display = $week1 = $week2 = $week3 = $week4 = $week5 = $week6 = $week7 = "1";
		$shuduling_display = "0";
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			$time = time();
			$date = date("Y-m-d",$time);			
			
			$query = $this->db->query("select * from $tbl where id='$id'")->row();
			$page_type = $query->page_type;
			$category_id = $query->category_id;
			$full_time = $query->full_time;
			
			
			$startdate   = DateTime::createFromFormat("d-M-Y", $startdate);
			$start_date  = $startdate->format('d-F-y');
			$start_date1 = $startdate->format('ymd');
			
			$starttime1 = $starttime3 = substr($starttime,0,2);
			$starttime2 = substr($starttime,3,2);
			
			$start_time1= "$starttime1$starttime2";
			
			$ampm = "PM";
			if($starttime1<12)
			{
				$ampm = "AM";
			}
			
			$starttime1 = $this->change_time_formet($starttime1);		
			$start_time= "$starttime1:$starttime2 $ampm";
			
			/**************ending time set here ********************/			
			$start_date2 = $startdate->format('y-m-d');
			$minutes_to_add = $full_time;

			$time = new DateTime("$start_date2 $start_time1");
			$time->add(new DateInterval('PT' . $minutes_to_add . 'S'));
			$end_date = $time->format('d-F-y');
			$end_date1 = $time->format('ymd');
			
			$end_time = $time->format('h:i A');
			$end_time1 = $time->format('Hi');
			
			/*********************************************/
			
			$video_start_time 	= "$start_date1$start_time1";
			$video_end_time 	= $time->format('ymdHi');
			/*****************************************************/
			
			/*********************************************/
			
			$duration_date = $startdate->format('d-m-Y');
			$duration_time = "$starttime3:$starttime2:00";
			$duration_date_end = $time->format('d-m-Y');
			$duration_time_end 	= $time->format('H:i').":00";
			/*****************************************************/
			
			
			$result = "";
			$dt = array(
			'category_id'=>$category_id,
			'video_id'=>$id,
			'page_type'=>$page_type,
			'start_time'=>$start_time,
			'start_time1'=>$start_time1,
			'end_time'=>$end_time,
			'end_time1'=>$end_time1,
			'start_date'=>$start_date,
			'start_date1'=>$start_date1,
			'end_date'=>$end_date,
			'end_date1'=>$end_date1,
			'display'=>$display,
			'shuduling_display'=>$shuduling_display,
			'week1'=>$week1,
			'week2'=>$week2,
			'week3'=>$week3,
			'week4'=>$week4,
			'week5'=>$week5,
			'week6'=>$week6,
			'week7'=>$week7,
			'video_start_time'=>$video_start_time,
			'video_end_time'=>$video_end_time,
			'duration_date'=>$duration_date,
			'duration_time'=>$duration_time,
			'duration_date_end'=>$duration_date_end,
			'duration_time_end'=>$duration_time_end,
			);
			$result = $this->Scheme_Model->insert_fun("tbl_schedule_time",$dt);
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
		
		$query = $this->db->query("select * from tbl_schedule_time where video_id='$id'");
  		$data["result"] = $query->result();
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/settime",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function delete_new_rec()
	{
		$id = $_POST["id"];
		$Page_title = $this->Page_title;
		$Page_tbl = $this->Page_tbl;
		$result = $this->db->query("delete from tbl_schedule_time where id='$id'");
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
	
	public function change_time_formet($time)
	{
		if($time=="13")
		{
			$time = "01";
		}
		if($time=="14")
		{
			$time = "02";
		}
		if($time=="15")
		{
			$time = "03";
		}
		if($time=="16")
		{
			$time = "04";
		}
		if($time=="17")
		{
			$time = "05";
		}
		if($time=="18")
		{
			$time = "06";
		}
		if($time=="19")
		{
			$time = "07";
		}
		if($time=="20")
		{
			$time = "08";
		}
		if($time=="21")
		{
			$time = "09";
		}
		if($time=="22")
		{
			$time = "10";
		}
		if($time=="23")
		{
			$time = "11";
		}
		if($time=="00")
		{
			$time = "12";
		}
		return $time;
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
	
	public function delete_photo()
	{
		$path = $_POST["path"];
		$type_me = $_POST["type_me"];
		
		$Page_title = $this->Page_title;
		$Page_name 	= $this->Page_name;
		$Page_view 	= $this->Page_view;
		$Page_menu 	= $this->Page_menu;
		$Page_tbl 	= $this->Page_tbl;
		$page_controllers 	= $this->page_controllers;
				
		$upload_path = "./uploads/$page_controllers/photo/";
		$result = $this->db->query("update $Page_tbl set $type_me='' where $type_me='$path'");
		if($result!="")
		{
			$filename = $upload_path.$path;
			$message = "Delete Photo Successfully.";
			if (file_exists($filename)) 
			{
    			unlink($filename);
			}
		}
		else
		{
			$message = "Photo Not Update.";
		}
		$message = $Page_title." - ".$message;
		$this->Admin_Model->Add_Activity_log($message);
		echo "ok";
	}
	
	public function sort_order_check($str)
	{		
		$sort_order = $this->input->post('sort_order');
		
		$Page_tbl 	= $this->Page_tbl;
		
		$query =  $this->db->query ("select id from $Page_tbl where sort_order='$sort_order'");
		$count	=  $query->num_rows();
		if ($count > 0) 
		{
			 $this->form_validation->set_message('sort_order_check','This field already used in database Please try different!');
			return FALSE;
		} 
		else
		{
			return TRUE;
		}
	}
}