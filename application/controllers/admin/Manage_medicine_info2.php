<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_medicine_info2 extends CI_Controller {

	var $Page_title = "Manage Medicine Info";
	var $Page_name  = "manage_medicine_info2";
	var $Page_view  = "manage_medicine_info2";
	var $Page_menu  = "manage_medicine_info2";
	var $page_controllers = "manage_medicine_info2";
	var $Page_tbl   = "tbl_medicine_image_scraping";
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
		
		$where = array('id'=>"1");
		$row = $this->Scheme_Model->select_row("tbl_medicine_excel_file",$where);
		$data["headername"] = $data["itemname"] = $data["itemprice"] = $data["itemintro1"] = $data["itemintro2"] = $data["image1"] = $data["image2"] = $data["image3"] = $data["image4"] = "";
		if(!empty($row->headername))
		{
			$data["headername"] = $row->headername;
			$data["itemname"] 	= $row->itemname;
			$data["itemprice"] 	= $row->itemprice;
			$data["itemintro1"] = $row->itemintro1;
			$data["itemintro2"] = $row->itemintro2;
			$data["image1"] = $row->image1;
			$data["image2"] = $row->image2;
			$data["image3"] = $row->image3;
			$data["image4"] = $row->image4;
		}
		
		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/add",$data);
		//$this->load->view("admin/header_footer/footer",$data);
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
		
		
		$result = $this->db->query("select * from tbl_medicine_image_scraping order by id desc")->result();
		
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

		$query = $this->db->query("select * from tbl_medicine_image_scraping order by id desc LIMIT $per_page,100");
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
	
	public function upload_import_file(){
		//error_reporting(0);
		header('Content-Type: application/json');
		$items = "";
		$headername	= strtoupper($_GET['headername']);
		$itemname 	= strtoupper($_GET['itemname']);
		$itemprice	= strtoupper($_GET['itemprice']);
		
		$itemintro1 	= strtoupper($_GET['itemintro1']);
		$itemintro1    	= str_replace(",","",$itemintro1);
		$itemintro1    	= str_replace(".","",$itemintro1);

		$itemintro2 	= strtoupper($_GET['itemintro2']);
		$itemintro2    	= str_replace(",","",$itemintro2);
		$itemintro2    	= str_replace(".","",$itemintro2);
		
		$image1 	= strtoupper($_GET['image1']);
		$image1    	= str_replace(",","",$image1);
		$image1    	= str_replace(".","",$image1);
		
		$image2 	= strtoupper($_GET['image2']);
		$image2    	= str_replace(",","",$image2);
		$image2    	= str_replace(".","",$image2);
		
		$image3 	= strtoupper($_GET['image3']);
		$image3    	= str_replace(",","",$image3);
		$image3    	= str_replace(".","",$image3);
		
		$image4 	= strtoupper($_GET['image4']);
		$image4    	= str_replace(",","",$image4);
		$image4    	= str_replace(".","",$image4);
		
		$where = array('id'=>'1');
		$row = $this->Scheme_Model->select_row("tbl_medicine_excel_file",$where);
		if($row->id=="")
		{
			$this->db->query("insert into tbl_medicine_excel_file set headername='$headername',itemname='$itemname',itemprice='$itemprice',itemintro1='$itemintro1',itemintro2='$itemintro2',image1='$image1',image2='$image2',image3='$image3',image4='$image4'");
		}
		else
		{
			$this->db->query("update tbl_medicine_excel_file set headername='$headername',itemname='$itemname',itemprice='$itemprice',itemintro1='$itemintro1',itemintro2='$itemintro2',image1='$image1',image2='$image2',image3='$image3',image4='$image4' where id='1'");
		}
		$filename = time().$_FILES['file']['name'];
		$uploadedfile = $_FILES['file']['tmp_name'];
		$upload_path = "./temp_files/";
		if(move_uploaded_file($uploadedfile, $upload_path.$filename))
		{
			/*****************************/
			$order_id = 1;
			$row = $this->db->query("select order_id from tbl_medicine_excel_file2 order by id desc limit 1")->row();
			if(!empty($row->order_id)){
				$order_id = $row->order_id + 1;
			}
			/*****************************/
			
			$excelFile = $upload_path.$filename;
			if(file_exists($excelFile))
			{
				$this->load->library('excel');
				$objPHPExcel = PHPExcel_IOFactory::load($excelFile);
				foreach ($objPHPExcel->getWorksheetIterator() as $worksheet)
				{
					$highestRow = $worksheet->getHighestRow();
					for ($row=$headername; $row<=$highestRow; $row++)
					{
						$item_name 	= $worksheet->getCell($itemname.$row)->getValue();
						if($item_name!="")
						{
							$itemprice_dt	= $worksheet->getCell($itemprice.$row)->getValue();
							$itemintro1_dt 	= $worksheet->getCell($itemintro1.$row)->getValue();
							$itemintro2_dt 	= $worksheet->getCell($itemintro2.$row)->getValue();
							$image1_dt 	= $worksheet->getCell($image1.$row)->getValue();
							$image2_dt 	= $worksheet->getCell($image2.$row)->getValue();
							$image3_dt 	= $worksheet->getCell($image3.$row)->getValue();
							$image4_dt 	= $worksheet->getCell($image4.$row)->getValue();
							
							$itemintro1_dt = htmlentities($itemintro1_dt);
							$itemintro2_dt = htmlentities($itemintro2_dt);
							$image1_dt = htmlentities($image1_dt);
							$image2_dt = htmlentities($image2_dt);
							$image3_dt = htmlentities($image3_dt);
							$image4_dt = htmlentities($image4_dt);
							
							$dt = array(
							'item_name'=>$item_name,
							'itemprice'=>$itemprice_dt,
							'itemintro1'=>$itemintro1_dt,
							'itemintro2'=>$itemintro2_dt,
							'image1'=>$image1_dt,
							'image2'=>$image2_dt,
							'image3'=>$image3_dt,
							'image4'=>$image4_dt,
							'order_id'=>$order_id,
							);
							$this->Scheme_Model->insert_fun("tbl_medicine_excel_file2",$dt);
						}
					}
				}
				unlink($excelFile);
			}
			$order_id  = base64_encode($order_id);
			$url = base_url()."admin/manage_medicine_info2/search/$order_id";
		}
		else{
			$url = base_url()."admin/manage_medicine_info2";
		}
$items.= <<<EOD
{"url":"{$url}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function search($order_id='')
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
		
		$data["order_id"]	= $order_id = base64_decode($order_id);
		$data["myname"] 	= $user_altercode;

		$where = array('order_id'=>$order_id,'status'=>'0');
		$result = $this->Scheme_Model->select_all_result("tbl_medicine_excel_file2",$where,"id","asc");
		$data["result"] 	= $result;
		if(empty($result))
		{
			redirect(base_url()."manage_medicine_info2");
		}

		$this->load->view("admin/header_footer/header",$data);
		$this->load->view("admin/$Page_view/search",$data);
		//$this->load->view("admin/header_footer/footer",$data);
	}
	
	public function import_order_dropdownbox()
	{
		header('Content-Type: application/html');
		
		error_reporting(0);
		$order_id			= $_POST["order_id"];
		$mytime				= $_POST["mytime"];
		$order_quantity		= $_POST["item_qty"];
		$excel_number		= $_POST["cssid"];
		$chemist_id			= "";//($_POST["chemist_id"]);
		$item_mrp 			= ($_POST["item_mrp"]);
		$order_item_name	= $keyword 	= $this->clean1($_POST["item_name"]);
		
		/******************************************/
		$suggest_i_code = "";
		$suggest = 0;
		$where = array('your_item_name'=>$order_item_name);
		$row = $this->Scheme_Model->select_row("drd_import_orders_suggest",$where);
		if(!empty($row->id))
		{
			$suggest = 1;
			$order_item_name	= $keyword = $row->item_name;
			$suggest_i_code 	= $row->i_code;
			$suggest_altercode 	= $row->user_altercode;
		}
		$type_ = 1;
		if(!empty($suggest_i_code))
		{
			$type_ = "1";
			$i_code = $suggest_i_code;
			$where = array('i_code'=>$i_code);
		}
		else{			
			/******************************************/
			$items=$this->Chemist_Model->import_order_dropdownbox($keyword,$item_mrp,"admin");
			/*****************************************/		
			$type_ = $items["type"];
			$i_code = $items["i_code"];
			$where = array('i_code'=>$i_code);
		}	
		
		$this->db->select("m.*,(SELECT DISTINCT featured from tbl_medicine_image where itemid=m.i_code) as featured,(SELECT DISTINCT discount from tbl_company_discount where compcode=m.compcode and tbl_company_discount.status='1') as discount");
		$this->db->where($where);
		$this->db->limit(1);
		$this->db->order_by('m.item_name','asc');
		$row = $this->db->get("tbl_medicine as m")->row();	
		$get_medicine_image	= 	$this->Chemist_Model->get_medicine_image($i_code);
		$image1 = $get_medicine_image[0];
		if(empty($image1))
		{
			$image1 = "http://drdmail.xyz/uploads/newok.jpg";
		}
		$old_image1 = $get_medicine_image[0];
		$old_image2 = $get_medicine_image[1];
		$old_image3 = $get_medicine_image[2];
		$old_image4 = $get_medicine_image[3];
		
		$url = constant('img_url_site');
		$old_image1 = str_replace($url,"",$old_image1);
		$old_image2 = str_replace($url,"",$old_image2);
		$old_image3 = str_replace($url,"",$old_image3);
		$old_image4 = str_replace($url,"",$old_image4);
		
		$discount = $sale_rate = $gstper = 0;
		$selected_item_name = $selected_packing = $selected_company_full_name = "";
		$selected_mrp = $selected_sale_rate = $selected_final_price = 0;
		if(!empty($row)) {
			$compcode 	=	$row->compcode;
			$discount 	= 	$row->discount;
			$gstper		=	$row->gstper;
			$sale_rate	=	$row->sale_rate;
			
			$selected_item_name = ucwords(strtolower($row->item_name));
			$selected_packing = $row->packing;
			$selected_company_full_name = ucwords(strtolower($row->company_full_name));

			/*********************yha decount karta h**************/
			$final_price0=  $sale_rate * $discount / 100;
			$final_price0=	$sale_rate - $final_price0;
			
			/*********************yha gst add karta h**************/
			$final_price=   $final_price0 * $gstper / 100;
			$final_price=	$final_price0 + $final_price;
			
			$final_price= 	round($final_price,2);
			/***************************************/
			
			$selected_mrp = $row->mrp;
			$selected_sale_rate = $row->sale_rate;
			$selected_final_price = $final_price;
			
			
			$selected_mrp 			= number_format($selected_mrp,2);
			$selected_sale_rate 	= number_format($selected_sale_rate,2);
			$selected_final_price 	= number_format($selected_final_price,2);
			
			/******************************************/
			$this->add_excelFile_temp_tbl($excel_number,$order_id,$i_code,$selected_item_name);
			/******************************************/
			
			$old_description1 = $get_medicine_image[4];
			$old_description2 = trim($get_medicine_image[5]);
		}
		?>
		<script>
		$('.selected_SearchAnotherMedicine_<?= $excel_number ?>').show();
		$('.select_product_<?= $excel_number ?>').show();
		</script>
		<?php 
		$selected_msg = "";
		if($type_==1)
		{
			$selected_msg = "Find medicine (By DRD server) |";
			?>
			<style>
			.remove_css_<?= $excel_number ?>{
				background:#13ffb33b !important;
			}
			</style>
			<?php
		}
		if($type_==0)
		{
			$selected_msg = "Find medicine but difference name (By DRD server) | ";
			?>
			<style>
			.remove_css_<?= $excel_number ?>{
				background:#1713ff2e !important;
			}
			</style>
			<?php
		}
		
		if($selected_item_name=="")
		{
			$selected_msg = "<span style=color:red>(Not found any medicine)</span> | ";
			?>
			<script>
			$('.select_product_<?= $excel_number ?>').hide();
			//$('.selected_SearchAnotherMedicine_<?= $excel_number ?>').show();
			</script>
			<style>
			.remove_css_<?= $excel_number ?>{
				background:#ffe494 !important;
			}
			</style>
			<?php
		}
		
		if($suggest==1)
		{
			$selected_msg = "Related results found (Suggest set by $suggest_altercode) | ";
			?>
			<style>
			.remove_css_<?= $excel_number ?>{
				background:#97dcd6 !important;
			}
			</style>
			<script>
				$('.selected_suggest_<?= $excel_number ?>').show();
			</script>
			<?php
		}
		?>
		<script>		
		$('.delete_all_btn_<?= $excel_number ?>').focus();		
		$('.chosen-select_<?= $excel_number ?>').chosen({width: "100%"});
		
		$('.selected_msg_<?= $excel_number ?>').html('<?php echo $selected_msg; ?>');
		$('.selected_item_name_<?= $excel_number ?>').html('<?php echo $selected_item_name; ?>');
		$('.image_css_<?= $excel_number ?>').attr("src","<?php echo $image1 ?>");
		$('.selected_packing_<?= $excel_number ?>').html('<?php echo $selected_packing ?>');
		$('.selected_mrp_<?= $excel_number ?>').html('<?php echo $selected_mrp; ?>');
		$('.selected_sale_rate_<?= $excel_number ?>').html('<?php echo $selected_sale_rate ?>');
		$('.selected_final_price_<?= $excel_number ?>').html('<?php echo $selected_final_price; ?>');
		$('.selected_company_full_name_<?= $excel_number ?>').html('<?php echo $selected_company_full_name; ?>');
		$('.css_old_img_01_<?= $excel_number ?>').val("<?php echo $old_image1 ?>");
		$('.css_old_img_02_<?= $excel_number ?>').val("<?php echo $old_image2 ?>");
		$('.css_old_img_03_<?= $excel_number ?>').val("<?php echo $old_image3 ?>");
		$('.css_old_img_04_<?= $excel_number ?>').val("<?php echo $old_image4 ?>");
		$('.css_old_description1_<?= $excel_number ?>').val('<?php echo $old_description1; ?>');
		$('.css_old_description2_<?= $excel_number ?>').val('<?php echo $old_description2; ?>');
		</script>
		<?php
	}
	
	public function add_excelFile_temp_tbl($excel_number,$order_id,$i_code,$selected_item_name)
	{		
		$return_status = 0;
				
		$where = array('id'=>$excel_number,'order_id'=>$order_id);
		$this->db->select("*");
		$this->db->where($where);
		$this->db->limit(1);
		$row = $this->db->get("tbl_medicine_excel_file2")->row();
		if(!empty($row->id))
		{
			$item_name_dt  = $row->item_name;
			$itemintro1_dt = $row->itemintro1;
			$itemintro2_dt = $row->itemintro2;
			$image1_dt = "new_pix/".$row->image1;
			$image2_dt = "new_pix/".$row->image2;
			$image3_dt = "new_pix/".$row->image3;
			$image4_dt = "new_pix/".$row->image4;
			
			$this->db->query("delete from tbl_medicine_image_scraping where i_code='$i_code'");
			
			$dt = array(
			'i_code'=>$i_code,
			'selected_item_name'=>$selected_item_name,
			'excel_number'=>$excel_number,
			'order_id'=>$order_id,
			'item_name'=>$item_name_dt,
			'itemintro1'=>$itemintro1_dt,
			'itemintro2'=>$itemintro2_dt,
			'image1'=>$image1_dt,
			'image2'=>$image2_dt,
			'image3'=>$image3_dt,
			'image4'=>$image4_dt,
			);
			$this->Scheme_Model->insert_fun("tbl_medicine_image_scraping",$dt);
			
			$this->db->query("update tbl_medicine_excel_file2 set status=1 where id='$excel_number' and order_id='$order_id'");
			
			$return_status = 1;
		}
		return $return_status;
	}

	
	function clean1($string) {
		$string = str_replace('"', "'", $string);
		$string = str_replace('\'', '', $string);
		return $string;
	}
	
	public function remove_row()
	{
		//error_reporting(0);
		header('Content-Type: application/json');
		$items = "";
		$excel_number	= $_POST["cssid"];
		$order_id 		= $_POST["order_id"];
		$item_name 		= $_POST["item_name"];
		if($excel_number!="")
		{
			/***yha to cart me say delete karna h rec ko */
			$this->db->query("delete from tbl_medicine_image_scraping where excel_number='$excel_number' and order_id='$order_id' ");

			/***yha delete item me add krta haa */
			$this->db->query("update tbl_medicine_excel_file2 set status='0' where id='".$excel_number."' and order_id='$order_id'");
		}
		$response = "1";
$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	/*21-01-2020*/
	public function select_medicine_in_search_box()
	{
		//error_reporting(0);
		header('Content-Type: application/json');
		$items = "";
		

		$your_item_name = $this->clean1($_POST["your_item_name"]);
		$item_name		= $this->clean1($_POST["item_name"]);
		$i_code			= ($_POST["new_i_code"]);
		$user_altercode	= "Admin";
		
		$this->db->where('your_item_name',$your_item_name);
		$row = $this->db->get("drd_import_orders_suggest")->row();
		if(!empty($row->id))
		{
			$where = array('your_item_name'=>$your_item_name);
			$this->Scheme_Model->delete_fun("drd_import_orders_suggest",$where);
		}
		$date = date('Y-m-d');
		$time = time();
		$datetime = date("d-M-y H:i",$time);
		
		$dt = array(
			'your_item_name'=>$your_item_name,
			'item_name'=>$item_name,
			'i_code'=>$i_code,
			'user_altercode'=>$user_altercode,
			'date'=>$date,
			'time'=>$time,
			'datetime'=>$datetime,
			);
		$response = $this->Scheme_Model->insert_fun("drd_import_orders_suggest",$dt);
		if(!empty($response))
		{
			$response = 1;
		}

$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function delete_suggest()
	{
		//error_reporting(0);
		header('Content-Type: application/json');
		$items = "";

		$your_item_name = $this->clean1($_POST["item_name"]);
		$where = array('your_item_name'=>$your_item_name);
		$this->Scheme_Model->delete_fun("drd_import_orders_suggest",$where);

		$response = "1";
		
$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function update_description()
	{
		//error_reporting(0);
		header('Content-Type: application/json');
		$items = "";
		$id = $_POST["id"];
		$new_description1 = $_POST["new_description1"];
		$new_description2 = $_POST["new_description2"];
		
		$itemintro1_dt = htmlentities($new_description1);
		$itemintro2_dt = htmlentities($new_description2);

		$where = array('excel_number'=>$id);
		$dt = array(
			'itemintro1'=>$itemintro1_dt,'itemintro2'=>$itemintro2_dt,);
		$result = $this->Scheme_Model->edit_fun("tbl_medicine_image_scraping",$dt,$where);

		$response = "1";
		
$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
	
	public function update_copy_old_image()
	{
		//error_reporting(0);
		header('Content-Type: application/json');
		$items = "";
		$id = $_POST["id"];
		$css_new_img_01 = $_POST["css_new_img_01"];
		$css_new_img_02 = $_POST["css_new_img_02"];
		$css_new_img_03 = $_POST["css_new_img_03"];
		$css_new_img_04 = $_POST["css_new_img_04"];

		$where = array('excel_number'=>$id);
		$dt = array(
			'image1'=>$css_new_img_01,'image2'=>$css_new_img_02,'image3'=>$css_new_img_03,'image4'=>$css_new_img_04,);
		$result = $this->Scheme_Model->edit_fun("tbl_medicine_image_scraping",$dt,$where);

		$response = "1";
		
$items.= <<<EOD
{"response":"{$response}"},
EOD;
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}<?php
	}
}