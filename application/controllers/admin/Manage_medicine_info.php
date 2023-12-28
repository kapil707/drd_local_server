<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_medicine_info extends CI_Controller {

	var $Page_title = "Manage Medicine Info";
	var $Page_name  = "manage_medicine_info";
	var $Page_view  = "manage_medicine_info";
	var $Page_menu  = "manage_medicine_info";
	var $page_controllers = "manage_medicine_info";
	var $Page_tbl   = "tbl_med_info";
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
		
		$data['url_path'] 	= base_url()."uploads/$page_controllers/photo/resize/";
		$upload_path 		= "./uploads/$page_controllers/photo/main/";
		$upload_resize 		= "./uploads/$page_controllers/photo/resize/";
		
		$system_ip = $this->input->ip_address();
		extract($_POST);
		if(isset($Submit))
		{
			$itemid = $i_code;
			$message_db = "";
			$time = time();
			$date = date("Y-m-d",$time);
			
			if (!empty($_FILES["image"]["name"]))
			{
				$this->Image_Model->uploadTo = $upload_path;
				$image = $this->Image_Model->upload($_FILES['image']);
				$image = str_replace($upload_path,"",$image);
				
				$this->Image_Model->newPath = $upload_resize;
				$this->Image_Model->newWidth = 512;
				$this->Image_Model->newHeight = 512;
				$this->Image_Model->resize();
			}		
			else
			{
				$image = "";
			}

			if (!empty($_FILES["image2"]["name"]))
			{
				$this->Image_Model->uploadTo = $upload_path;
				$image2 = $this->Image_Model->upload($_FILES['image2']);
				$image2 = str_replace($upload_path,"",$image2);
				
				$this->Image_Model->newPath = $upload_resize;
				$this->Image_Model->newWidth = 512;
				$this->Image_Model->newHeight = 512;
				$this->Image_Model->resize();
			}		
			else
			{
				$image2 = "";
			}

			if (!empty($_FILES["image3"]["name"]))
			{
				$this->Image_Model->uploadTo = $upload_path;
				$image3 = $this->Image_Model->upload($_FILES['image3']);
				$image3 = str_replace($upload_path,"",$image3);
				
				$this->Image_Model->newPath = $upload_resize;
				$this->Image_Model->newWidth = 512;
				$this->Image_Model->newHeight = 512;
				$this->Image_Model->resize();
			}		
			else
			{
				$image3 = "";
			}

			if (!empty($_FILES["image4"]["name"]))
			{
				$this->Image_Model->uploadTo = $upload_path;
				$image4 = $this->Image_Model->upload($_FILES['image4']);
				$image4 = str_replace($upload_path,"",$image4);
				
				$this->Image_Model->newPath = $upload_resize;
				$this->Image_Model->newWidth = 512;
				$this->Image_Model->newHeight = 512;
				$this->Image_Model->resize();
			}		
			else
			{
				$image4 = "";
			}
			//$description = base64_encode($description);
			$result = "";
			$dt = array(
				'itemid'=>$itemid,
				'featured'=>$featured,
				'image'=>$image,
				'image2'=>$image2,
				'image3'=>$image3,
				'image4'=>$image4,
				'description'=>$description,
				'status'=>$status,
				'date'=>$date,
				'time'=>$time,
			);
			$result = $this->Scheme_Model->insert_fun($tbl,$dt);
			$property_title = base64_decode($property_title);
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
		
		$data['url_path'] 	= base_url()."uploads/$page_controllers/photo/resize/";
		$upload_path 		= "./uploads/$page_controllers/photo/main/";
		$upload_resize 		= "./uploads/$page_controllers/photo/resize/";
		
		extract($_POST);
		if(isset($Delete))
		{	
			$where = array('id'=>$delete_id,'status'=>"5",'school_id'=>$school_id);
			$this->Scheme_Model->delete_fun($tbl,$where);
			
			$where = array('id'=>$delete_id,'school_id'=>$school_id);					
			$dt = array('status'=>"5");
			$this->Scheme_Model->edit_fun($tbl,$dt,$where);			
		}
		$tbl = "a_med";
		if($_GET["table_name"])
		{
			$tbl = $_GET["table_name"];
		}
		$data["table_name"] = $tbl;
		
		
		$result = $this->db->query("select * from $tbl order by id desc")->result();
		
		$config['total_rows'] = count($result);
		$data["count_records"] = count($result);
        $config['per_page'] = 100;

        if($num!=""){
           $config['per_page'] = $num;
        }
        $config['full_tag_open']="<ul class='pagination'>";
        $config['full_tag_close']="</ul>";
        $config['first_tag_open']='<li>';
        $config['first_tag_close']='</li>';
        $config['last_tag_open']='<li>';
        $config['last_tag_close']='</li>';
        $config['next_tag_open']='<li>';
        $config['next_tag_close']='</li>';
        $config['prev_tag_open']='<li>';
        $config['prev_tag_close']='</li>';
        $config['num_tag_open']='<li>';
        $config['num_tag_close']='</li>';
        $config['cur_tag_open']="<li class='active'><a>";
        $config['cur_tag_close']='</a></li>';
        $config['num_links'] = 100;    
        $config['page_query_string'] = TRUE;
		$per_page=$_GET["pg"];
		if($per_page=="")
		{
			$per_page = 0;
		}


		$data['per_page']=$per_page;
		
		$data['user_id'] = $user_id;

		$query = $this->db->query("select * from $tbl order by id desc LIMIT $per_page,100");
  		$data["result"] = $query->result();
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/view",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	public function edit($id)
	{
		$data["id"] = $id;
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
		
		$data['url_path'] 	= base_url()."uploads/manage_medicine_image/photo/resize/";
		$upload_path 		= "./uploads/manage_medicine_image/photo/main/";
		$upload_resize 		= "./uploads/manage_medicine_image/photo/resize/";
		
		extract($_POST);
		if(isset($Submit))
		{
			$itemid = $i_code;
			$message_db = "";
			$time = time();
			$date = date("Y-m-d",$time);
			$where = array('id'=>$id);

			if (!empty($_FILES["image"]["name"]))
			{
				$this->Image_Model->uploadTo = $upload_path;
				$image = $this->Image_Model->upload($_FILES['image']);
				$image = str_replace($upload_path,"",$image);
				
				$this->Image_Model->newPath = $upload_resize;
				$this->Image_Model->newWidth = 512;
				$this->Image_Model->newHeight = 512;
				$this->Image_Model->resize();
				$update_url = 1;
			}		
			else
			{
				$image = $old_image1;
			}

			if (!empty($_FILES["image2"]["name"]))
			{
				$this->Image_Model->uploadTo = $upload_path;
				$image2 = $this->Image_Model->upload($_FILES['image2']);
				$image2 = str_replace($upload_path,"",$image2);
				
				$this->Image_Model->newPath = $upload_resize;
				$this->Image_Model->newWidth = 512;
				$this->Image_Model->newHeight = 512;
				$this->Image_Model->resize();
				$update_url = 1;
			}		
			else
			{
				$image2 = $old_image2;
			}

			if (!empty($_FILES["image3"]["name"]))
			{
				$this->Image_Model->uploadTo = $upload_path;
				$image3 = $this->Image_Model->upload($_FILES['image3']);
				$image3 = str_replace($upload_path,"",$image3);
				
				$this->Image_Model->newPath = $upload_resize;
				$this->Image_Model->newWidth = 512;
				$this->Image_Model->newHeight = 512;
				$this->Image_Model->resize();
				$update_url = 1;
			}		
			else
			{
				$image3 = $old_image3;
			}

			if (!empty($_FILES["image4"]["name"]))
			{
				$this->Image_Model->uploadTo = $upload_path;
				$image4 = $this->Image_Model->upload($_FILES['image4']);
				$image4 = str_replace($upload_path,"",$image4);
				
				$this->Image_Model->newPath = $upload_resize;
				$this->Image_Model->newWidth = 512;
				$this->Image_Model->newHeight = 512;
				$this->Image_Model->resize();
				$update_url = 1;
			}		
			else
			{
				$image4 = $old_image4;
			}
			
			$result = "";
			$dt = array(
				'img1'=>$image,
				'img2'=>$image2,
				'img3'=>$image3,
				'img4'=>$image4,
				'a1'=>$a1,
				'a5'=>$a5,
				'update_url'=>$update_url,
				'featured'=>$featured,
			);
			$result = $this->Scheme_Model->edit_fun($tbl,$dt,$where);
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
			if($message_db!="")
			{
				$message = $Page_title." - ".$message;
				$message_db = $Page_title." - ".$message_db;
				$this->session->set_flashdata("message_footer","yes");
				$this->session->set_flashdata("full_message",$message);
				$this->Admin_Model->Add_Activity_log($message_db);
				if($result)
				{
					//redirect(current_url());
					redirect(base_url()."admin/$page_controllers/edit/".$id."?table_name=".$_GET["table_name"]."&pg=".$_GET["pg"]);
				}
			}
		}

		$query = $this->db->query("select * from $tbl where id='$id'");
  		$data["result"] = $query->result();
		$row     =   $query->row();
		$data["id1"]   = $row->tbl_id;
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/edit",$data);
		$this->load->view("admin/header_footer/footer",$data);
	}
	
	
	public function delete_rec()
	{
		$id = $_POST["id"];
		$Page_title = $this->Page_title;
		$Page_tbl = $this->Page_tbl;
		
		$page_controllers 	= $this->page_controllers;
		$upload_path 		= "./uploads/$page_controllers/photo/main/";
		$upload_resize 		= "./uploads/$page_controllers/photo/resize/";
		
		/*$row = $this->db->query("select * from $Page_tbl where id='$id'")->row();
		if($row->id!="")
		{
			unlink($upload_path.$row->image);
			unlink($upload_resize.$row->image);
		}*/
		
		$this->db->query("delete from $Page_tbl where id='$id'");
		echo "ok";
	}
	
	public function delete_photo()
	{
		$id 		= $_POST["id"];
		$Page_title = $this->Page_title;
		$Page_tbl 	= $this->Page_tbl;
		
		$page_controllers 	= $this->page_controllers;
		$upload_path 		= "./uploads/$page_controllers/photo/main/";
		$upload_resize 		= "./uploads/$page_controllers/photo/resize/";
		
		$row = $this->db->query("select * from $Page_tbl where id='$id'")->row();
		if($row->id!="")
		{
			$message = "Delete Photo Successfully.";
			unlink($upload_path.$row->image);
			unlink($upload_resize.$row->image);
		}
		else
		{
			$message = "Photo Not Update.";
		}
		$message = $Page_title." - ".$message;
		$this->Admin_Model->Add_Activity_log($message);
		echo "ok";
	}
	
	public function call_search_item()
	{		
		error_reporting(0);
		?><ul style="margin: 0px;padding: 0px;"><?php
		$row_id 	= $this->input->post('row_id');
		$item_name 	= $this->input->post('item_name');
		$result =  $this->db->query ("select id,i_code,item_name,item_code from tbl_medicine where item_name Like '$item_name%' or item_name Like '%$item_name' limit 50")->result();
		foreach($result as $row)
		{
			$i_code 	= $row->i_code;
			$item_name 	= ($row->item_name);
			$item_code 	= ($row->item_code);
			$item_name1 = base64_encode("$row->item_name");
			?>
			<li style="list-style: none;margin: 5px;"><a href="javascript:additem(<?= $i_code ?>,<?= $row_id ?>,'<?= $item_name1 ?>')"><?= $item_name ?> (<?= $item_code ?>)</a></li>
			<?php
		}
		?></ul><?php
	}

	public function additem_set()
	{
		$i_code 	= $this->input->post('i_code');
		$tbl_id 	= $this->input->post('row_id');
		$table_name = $this->input->post('table_name');

		$img1 = $img2 = $img3 = $img4 = $a1 = $a5 = "";
		$row = $this->db->query("select * from $table_name where id='$tbl_id'")->row();
		if($row->id!="")
		{
			$img1 	= $row->img1;
			$img2 	= $row->img2;
			$img3 	= $row->img3;
			$img4 	= $row->img4;
			$a1 	= $row->a1;
			$a5 	= $row->a5;
		}

		$row1 = $this->db->query("select id from tbl_med_info where table_name='$table_name' and tbl_id='$tbl_id'")->row();
		if($row1->id=="")
		{
			$this->db->query("insert into tbl_med_info set i_code='$i_code',img1='$img1',img2='$img2',img3='$img3',img4='$img4',a1='$a1',a5='$a5',table_name='$table_name',tbl_id='$tbl_id'");
		}
		else
		{
			$this->db->query("update tbl_med_info set i_code='$i_code',img1='$img1',img2='$img2',img3='$img3',img4='$img4',a1='$a1',a5='$a5' where table_name='$table_name' and tbl_id='$tbl_id'");
		}

		$row1 = $this->db->query("select id from tbl_med_info where table_name='$table_name' and tbl_id='$tbl_id'")->row();
		echo $row1->id;
	}
}