<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_webservices extends CI_Controller {

	var $Page_title = "Manage Webservices";
	var $Page_name  = "manage_webservices";
	var $Page_view  = "manage_webservices";
	var $Page_menu  = "manage_webservices";
	var $page_controllers = "manage_webservices";
	var $Page_tbl   = "tbl_webservices";
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
		
		$data['url_path'] = base_url()."uploads/$page_controllers/photo/";
		$upload_path = "./uploads/$page_controllers/photo/";
		
		$system_ip = $this->input->ip_address();
		$url = $property_category = $show_in_menu = $theme = $title_show = $show_in_footer_menu = $show_in_home_banner = $show_in_cat_page = $title_color = "";
		extract($_POST);
		if(isset($Submit))
		{
			$message_db = "";
			$this->form_validation->set_rules('name','Name',"required");
			//$this->form_validation->set_rules('sort_order','Sort Order','required|trim|callback_sort_order_check|numeric|greater_than[0]');
			if ($this->form_validation->run() == FALSE)
			{
				$message = "Check Validation.";
				$this->session->set_flashdata("message_type","warning");
			}
			else
			{
				$time = time();
				$date = date("Y-m-d",$time);
				
				if (!empty($_FILES["image"]["name"]))
				{
					$name1 = "photo";
					$imagename = $_FILES["image"]['name'];
					$uploadedfile = $_FILES["image"]['tmp_name'];
					$image = "";
					
					$valid_formats = array("jpg", "png", "gif", "bmp","jpeg","PNG","JPG","JPEG","GIF","BMP");
					$ext = strtolower($this->Scheme_Model->getExtension($imagename));
					if(in_array($ext,$valid_formats))
					{
						//$ext = "jpg";
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
					$image = "";
				}
				
				//$name = ucwords(strtolower($name));
				
				$result = "";
				$dt = array(
				'url'=>$url,
				'name'=>$name,
				'image'=>$image,
				'description'=>$description,
				'status'=>$status,
				'date'=>$date,
				'time'=>$time,
				'update_date'=>$date,
				'update_time'=>$time,
				'system_ip'=>$system_ip,
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
				
		$query = $this->db->query("select * from $tbl order by id desc");
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

				if (!empty($_FILES["image"]["name"]))
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
				}
				
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
	
	public function status_change()
	{
		extract($_POST);
		
		$Page_title = $this->Page_title;
		$tbl = $this->Page_tbl;
		$where = array('id'=>$id);					
		$dt = array('status'=>$status);
		$result = $this->Scheme_Model->edit_fun($tbl,$dt,$where);
		if($result)
		{
			$message = "Status Change Successfully.";
		}
		$message = $Page_title." - ".$message;
		$this->Admin_Model->Add_Activity_log($message);
		echo "ok";
	}
	public function state_change()
	{
		$state = $_POST["state"];
		?>
        <select name="district" required="required" data-placeholder="Select District" class="chosen-select" id="district">
            <option value="">
                Select District                 	
            </option>
            <?php
            $query = $this->db->query("select * from tbl_cities where state_id='$state'");
            $result1 = $query->result();
            foreach($result1 as $row1)
            {
                ?>
                <option value="<?= $row1->id; ?>"
                <?php if($state == $row1->id) { ?> selected="selected" <?php } ?>>
                    <?= $row1->name; ?>               	
                </option>
                <?php
            }
            ?>
        </select>
		<script>
        $(document).ready(function(){
        	$('.chosen-select').chosen({width: "100%"});
        });
        </script>
        <?php
	}
	
	public function change_url()
	{
		error_reporting(0);
		$id = $_POST["id"];
		$url = $_POST["url1"];		
		$query = $this->db->query("select * from tbl_livetv where url='$url' and id!='$id'")->row();
		if($query->id)
		{
			echo "Error";
		}
		else
		{
			echo "ok";
		}
	}
	
	public function map()
	{
		$Page_view 	= $this->Page_view;
		$data = "";
		//$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/map",$data);
		//$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function map_view()
	{
		$Page_view 	= $this->Page_view;
		$data = "";
		//$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/map_view",$data);
		//$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function set_latitude_longitude()
	{
		session_start();
		$_SESSION["latitude"] = $_POST["latitude"];
		$_SESSION["longitude"] = $_POST["longitude"];
		$_SESSION["new"] = 1;
		echo "ok";
	}
	
	public function get_latitude_longitude()
	{
		//session_start();
		error_reporting(0);
		if($_SESSION["new"]==1){
			$_SESSION["new"] = 0;
			?>
<input name="latitude" type="hidden" class="latitude" value="<?php echo $latitude = $_SESSION["latitude"] ?>">
<input name="longitude" type="hidden" class="longitude" value="<?php echo$longitude = $_SESSION["longitude"] ?>">
<iframe src="<?= base_url()?>/admin/manage_property/map_view?latitude=<?= $latitude?>&longitude=<?= $longitude?>" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
			<?php
		}
	}
	
	public function delete_rec()
	{
		$id = $_POST["id"];
		$Page_title = $this->Page_title;
		$Page_tbl = $this->Page_tbl;
		$result = $this->db->query("delete from $Page_tbl where id='$id'");
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