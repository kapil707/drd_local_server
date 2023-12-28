<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_website extends CI_Controller {

	var $Page_title = "Manage Website";
	var $Page_name  = "manage_website";
	var $Page_view  = "manage_website";
	var $Page_menu  = "manage_website";
	var $page_controllers = "manage_website";
	var $Page_tbl   = "tbl_website";
	public function index()
	{
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
	}
	public function add($page_type="")
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
		
		$Page_menu  = $page_type;
		
		$data['title1'] = $Page_title." || Add";
		$data['title2'] = "Add";
		$data['Page_name'] = $Page_name;
		$data['Page_menu'] = $Page_menu;		
		$this->breadcrumbs->push("Admin","admin/");
		$this->breadcrumbs->push("$Page_title","admin/$page_controllers/");
		$this->breadcrumbs->push("Add","admin/$page_controllers/add");
		
		$tbl = $Page_tbl;
		
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";
		
		$data["type"] = "text";
		if($page_type=="title")
		{
			$data["titlepg"] = "Website Title";
			$data["placeholderpg"] = "Website Title";
			$data["pagetextpg"] = "";
		}
		if($page_type=="logo")
		{
			$data["type"] = "image";
			$data["titlepg"] = "Website Logo";
			$data["placeholderpg"] = "Website Logo";
			$data["pagetextpg"] = "height : 50px & width : 150px";
		}
		if($page_type=="icon")
		{
			$data["type"] = "image";
			$data["titlepg"] = "Website Icon";
			$data["placeholderpg"] = "Website Icon";
			$data["pagetextpg"] = "";
		}
		if($page_type=="topphone")
		{
			$data["titlepg"] = "Website Top Phone";
			$data["placeholderpg"] = "Website Top Phone";
			$data["pagetextpg"] = "";
		}
		if($page_type=="topemail")
		{
			$data["titlepg"] = "Website Top Email";
			$data["placeholderpg"] = "Website Top Email";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="footeraboutus")
		{
			$data["titlepg"] = "Website Footer About Us";
			$data["placeholderpg"] = "Website Footer About Us";
			$data["pagetextpg"] = "";
		}
		
		
		if($page_type=="footeraddress")
		{
			$data["titlepg"] = "Website Footer Address";
			$data["placeholderpg"] = "Website Footer Address";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="footeremail")
		{
			$data["titlepg"] = "Website Footer Email";
			$data["placeholderpg"] = "Website Footer Email";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="footerphone")
		{
			$data["titlepg"] = "Website Footer Phone";
			$data["placeholderpg"] = "Website Footer Phone";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="footerstayintouch")
		{
			$data["titlepg"] = "Website Footer Stay In Touch";
			$data["placeholderpg"] = "Website Footer Stay In Touch";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="facebook")
		{
			$data["titlepg"] = "Website Facebook Link";
			$data["placeholderpg"] = "Website Facebook Link";;
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="twitter")
		{
			$data["titlepg"] = "Website Twitter Link";
			$data["placeholderpg"] = "Website Twitter Link";;
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="googleplus")
		{
			$data["titlepg"] = "Website Google + Link";
			$data["placeholderpg"] = "Website Google + Link";;
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="instagram")
		{
			$data["titlepg"] = "Website Instagram Link";
			$data["placeholderpg"] = "Website Instagram Link";;
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="watermarkimage")
		{
			$data["type"] = "image";
			$data["titlepg"] = "Water Mark Image";
			$data["placeholderpg"] = "Water Mark Image";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="footerimage")
		{
			$data["type"] = "image";
			$data["titlepg"] = "Website Footer Image";
			$data["placeholderpg"] = "Website Footer Image";
			$data["pagetextpg"] = "height : 50px & width : 150px";
		}
		
		if($page_type=="skype")
		{
			$data["titlepg"] = "Website skype";
			$data["placeholderpg"] = "Website skype";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="footercopyright")
		{
			$data["titlepg"] = "Website Footer Copy Right";
			$data["placeholderpg"] = "Website Footer Copy Right";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="meta_title")
		{
			$data["titlepg"] = "Website Meta Title";
			$data["placeholderpg"] = "Website Meta Title";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="meta_keywords")
		{
			$data["titlepg"] = "Website Meta Keywords";
			$data["placeholderpg"] = "Website Meta Keywords";
			$data["pagetextpg"] = "";
		}
		
		if($page_type=="meta_discription")
		{
			$data["titlepg"] = "Website Meta Discription";
			$data["placeholderpg"] = "Website Meta Discription";
			$data["pagetextpg"] = "";
		}
		
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			if($type=="image")
			{
				if (!empty($_FILES["image"]["name"]))
				{
					$x = $_FILES["image"]['name'];
					$y = $_FILES["image"]['tmp_name'];
					$mydata = $this->Scheme_Model->photo_up("photo",$x,$y,$upload_path);	
				}
				else
				{
					$mydata = $old_mydata;
				}
			}
			$mydata = base64_encode($mydata);
			
			$time = time();
			$date = date("Y-m-d",$time);
			
			$result = "";
			$dt = array('mydata'=>$mydata,'page_type'=>$page_type,'update_date'=>$date,'update_time'=>$time,);
			
			$change_text = "";
			if($old_mydata!=$mydata)
			{
				if($data["type"]=="text")
				{
					$change_text = $data["titlepg"]." - ($old_mydata to ".base64_decode($mydata).")";
				}
				if($data["type"]=="image")
				{
					$change_text = $data["titlepg"]." - (Upload) ";											
					$url_path = "./uploads/$page_controllers/photo/";					
					$query = $this->db->query("select * from $tbl where page_type='$page_type'");
					$row11 = $query->row();
					$filename = $url_path.base64_decode($row11->mydata);
					unlink($filename);
				}
			}
			
			$query = $this->db->query("select * from $tbl where page_type='$page_type'");
			$row = $query->row();
			if(empty($row->id))
			{
				$result = $this->Scheme_Model->insert_fun($tbl,$dt);
			}
			else
			{
				$where = array('page_type'=>$page_type);
				$result = $this->Scheme_Model->edit_fun($tbl,$dt,$where);
			}
			if($result)
			{
				$message_db = "$change_text - Set Successfully.";
				$message = "Set Successfully.";
				$this->session->set_flashdata("message_type","success");
			}
			else
			{
				$message_db = "$change_text - Not Set.";
				$message = "Not Set.";
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
		$data["mydata"] = "";
		$query = $this->db->query("select * from $tbl where page_type='$page_type'");
		$row = $query->row();
		if(!empty($row->id))
		{
			$data["mydata"] = base64_decode($row->mydata);
		}
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/add",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
}