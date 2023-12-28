<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Scheme_Model extends CI_Model  
{
	function insert_fun($tbl,$dt)
	{
		if($this->db->insert($tbl,$dt))
		{
			return $this->db->insert_id();				
		}
		else
		{
			return false;
		}
	}
	
	function select_all_result($tbl,$where,$orderby='',$asc_desc='')
	{
		if($where!="")
		{
			$this->db->where($where);
		}
		if($orderby!="")
		{
			$this->db->order_by($orderby,$asc_desc);
		}
		return $this->db->get($tbl)->result();	
	}
	
	function select_row($tbl,$where)
	{
		if($where!="")
		{
			$this->db->where($where);
		}
		return $this->db->get($tbl)->row();	
	}
	
	function select_all_fun($tbl,$where)
	{
		if($where!="")
		{
			$this->db->where($where);
		}
		return $this->db->get($tbl)->result_array();	
	}
	function select_all_fun_order_by($tbl,$where,$orderby)
	{	
		if($where!="")
		{
			$this->db->where($where);
		}	
		if($orderby!="")
		{
			$this->db->order_by($orderby);
		}
		return $this->db->get($tbl)->result_array();	
	}
	function edit_fun($tbl,$dt,$where)
	{
		if($this->db->update($tbl,$dt,$where))
		{
			return true;				
		}
		else
		{
			return false;
		}
	}
	function delete_fun($tbl,$where)
	{
		if($this->db->delete($tbl,$where))
		{
			return true;				
		}
		else
		{
			return false;
		}
	}
	function time_conveter($display_time_H,$display_time_i)
	{		
		if($display_time_H == "00")
		{
			$display_time = "12:$display_time_i AM";
		}
		if($display_time_H == "01")
		{
			$display_time = "01:$display_time_i AM";
		}
		if($display_time_H == "02")
		{
			$display_time = "02:$display_time_i AM";
		}
		if($display_time_H == "03")
		{
			$display_time = "03:$display_time_i AM";
		}
		if($display_time_H == "04")
		{
			$display_time = "04:$display_time_i AM";
		}
		if($display_time_H == "05")
		{
			$display_time = "05:$display_time_i AM";
		}
		if($display_time_H == "06")
		{
			$display_time = "06:$display_time_i AM";
		}
		if($display_time_H == "07")
		{
			$display_time = "07:$display_time_i AM";
		}
		if($display_time_H == "08")
		{
			$display_time = "08:$display_time_i AM";
		}
		if($display_time_H == "09")
		{
			$display_time = "09:$display_time_i AM";
		}
		if($display_time_H == "10")
		{
			$display_time = "10:$display_time_i AM";
		}
		if($display_time_H == "11")
		{
			$display_time = "11:$display_time_i AM";
		}
		if($display_time_H == "12")
		{
			$display_time = "12:$display_time_i PM";
		}
		if($display_time_H == "13")
		{
			$display_time = "01:$display_time_i PM";
		}
		if($display_time_H == "14")
		{
			$display_time = "02:$display_time_i PM";
		}
		if($display_time_H == "15")
		{
			$display_time = "03:$display_time_i PM";
		}
		if($display_time_H == "16")
		{
			$display_time = "04:$display_time_i PM";
		}
		if($display_time_H == "17")
		{
			$display_time = "05:$display_time_i PM";
		}
		if($display_time_H == "18")
		{
			$display_time = "06:$display_time_i PM";
		}
		if($display_time_H == "19")
		{
			$display_time = "07:$display_time_i PM";
		}
		if($display_time_H == "20")
		{
			$display_time = "08:$display_time_i PM";
		}
		if($display_time_H == "21")
		{
			$display_time = "09:$display_time_i PM";
		}
		if($display_time_H == "22")
		{
			$display_time = "10:$display_time_i PM";
		}
		if($display_time_H == "23")
		{
			$display_time = "11:$display_time_i PM";
		}
		return $display_time;
	}
	
	public function Under_User($under_id)
	{ 
		$where = array('id'=>$under_id);
		$result = $this->select_all_fun("tbl_admin",$where);
		foreach ($result as $row)
		{
			return $row["name"]." (".$row["user_type"].")";
		}
	}
	public function record_count($tbl) {
		return $this->db->count_all($tbl);
	}
	public function youtube_video_url($video_url)
	{
		$video_url = str_replace("https://www.youtube.com/watch?v=","",$video_url);
		$video_url = str_replace("http://www.youtube.com/watch?v=","",$video_url);
		$video_url = str_replace("https://youtu.be/","",$video_url);
		$video_url = str_replace("http://youtu.be/","",$video_url);
		return $video_url;
	}
	public function photo_up($name,$x,$y,$upload_path)
	{
		$name = $name."_".time().".png";
		move_uploaded_file($y,$upload_path.$name);
		return $name;
	}
	public function img_resize($tmpname,$size,$save_dir,$save_name,$maxisheight=0)
	{
		$save_dir	.= ( substr($save_dir,-1) != "/") ? "/" : "";
		$gis		 = getimagesize($tmpname);
		$type        = $gis[2];
		
		switch($type)
		{
			case "1": $imorig = imagecreatefromgif($tmpname); break;
			case "2": $imorig = imagecreatefromjpeg($tmpname);break;
			case "3": $imorig = imagecreatefrompng($tmpname); break;
			default:  $imorig = imagecreatefromjpeg($tmpname);
		}
		$x = imagesx($imorig);
		$y = imagesy($imorig);
		$woh = (!$maxisheight)? $gis[0] : $gis[1] ;   
		if($woh <= $size)
		{
			$aw = $x;
			$ah = $y;
		}
		else
		{
			if(!$maxisheight)
			{
				$aw = $size;
				$ah = $size * $y / $x;
			} 
			else
			{
				$aw = $size * $x / $y;
				$ah = $size;
			}
		}
		$im = imagecreatetruecolor($aw,$ah);
    	if (imagecopyresampled($im,$imorig , 0,0,0,0,$aw,$ah,$x,$y))
		if (imagejpeg($im, $save_dir.$save_name))
		{
            return true;
		}
		else
		{
			return false;
		}
	}
	
	public function get_website_data($page_type)
	{
		$query = $this->db->query("select * from tbl_website where page_type='$page_type'")->row();
		if($query->mydata=="")
		{
			$query->mydata = base64_encode("");
		}
		return base64_decode($query->mydata);
	}
	
	public function watermark_image($oldimage_name,$new_image_name,$image_path)
	{
		list($owidth,$oheight) = getimagesize($oldimage_name);
		$width = 770;
		$height = 430;    
		$im = imagecreatetruecolor($width, $height);
		$img_src = imagecreatefromjpeg($oldimage_name);
		imagecopyresampled($im, $img_src, 0, 0, 0, 0, $width, $height, $owidth, $oheight);
		$watermark = imagecreatefrompng($image_path);
		list($w_width, $w_height) = getimagesize($image_path);    
		$pos_x = $width - $w_width; 
		$pos_y = $height - $w_height;
		imagecopy($im, $watermark, 210, 200, 0, 0, $w_width, $w_height);
		imagejpeg($im, $new_image_name, 100);
		imagedestroy($im);
		unlink($oldimage_name);
		return true;
	}
	
	public function get_seleced_theme()
	{
		$query = $this->db->query("select * from tbl_theme where selected_theme='1'");
		$row = $query->row();
		return $row->id;
	}
	
	public function get_product_category_range_low($category_id,$catname)
	{
		$query = $this->db->query("select tbl_variations1_variations2_join.price1 from tbl_product_category,tbl_variations1_variations2_join where ($catname) and tbl_variations1_variations2_join.product_id=tbl_product_category.product_id and tbl_variations1_variations2_join.price1!='0' order by tbl_variations1_variations2_join.price1 asc")->row();
		$x = $query->price1;
		
		return $x;
	}
	
	public function get_product_category_range_high($category_id,$catname)
	{
		$query = $this->db->query("select tbl_variations1_variations2_join.price1 from tbl_product_category,tbl_variations1_variations2_join where ($catname) and tbl_variations1_variations2_join.product_id=tbl_product_category.product_id and tbl_variations1_variations2_join.price1!='0' order by tbl_variations1_variations2_join.price1 desc")->row();
		$x1 = $query->price1;
		if($x<=$x1)
		{
			$x = $x1;
		}
		
		return $x;
	}
	public function get_price_today()
	{
		$query = $this->db->query("select * from tbl_website where page_type='price_today'")->row();
		$x = base64_decode($query->mydata);
		if($x=="" || $x=="0")
		{
			$x = "1";
		}
		return $x;
	}
	
	public function get_product_price($id)
	{
		error_reporting(0);
		$query = $this->db->query("select * from tbl_product where id='$id'")->row();
		
		if($query->product_type=="3")
		{
			$combo_product = $query->combo_product;
			$combo_product2 = explode(",",$combo_product);
			$xy = 0;
			foreach($combo_product2 as $pid)
			{
				// yha wo ha jo bik gaya ha
				$query1n = $this->db->query("select * from tbl_variations1_variations2_join where id='$pid'")->row();
				$get_available1 = $this->Scheme_Model->get_available($product_id,$query1n->variations1,$query1n->variations2);
				
				$get_available2[$xy] = $query1n->quantity - $get_available1;
				$xy++;
			}
			sort($get_available2);
		}
		
		if($query->product_type==1 || $query->product_type==3)
		{
			$query1 = $this->db->query("select * from tbl_variations1_variations2_join where product_id='$id' and variations1='0' and variations2='0' order by price1 asc")->row();
		}
		if($query->product_type==2)
		{
			$query1 = $this->db->query("select * from tbl_variations1_variations2_join where product_id='$id' and variations1!='0' and variations2!='0' order by price1 asc")->row();
		}
		
		$get_available = $this->Scheme_Model->get_available($id,$query1->variations1,$query1->variations2);
		
		if($query1->discount=="" || $query1->discount=="0")
		{
			$query1->discount = "";
		}		
		$price = $query1->price;
		//$x[0] = $price + ($price * $query->product_gst / 100);
		$x[0] = $price;
		if($query1->discount == "")
		{
			$x[1] = $price;
		}
		else
		{
			$x[1] = $query1->discount;
		}
		//$x[1] =	$x[1] + ($x[1] * $query->product_gst / 100);
		$x[1] =	$x[1];
		$x[2] = $query1->discount;
		if($x[2]!="")
		{
			$x[2] = $price - $query1->discount;
			$x[2] = ($x[2] / $price) * 100;
			$x[2] = round($x[2])."% off";
		}		
		if($query->product_type=="3")
		{
			$x[3] = $get_available2[0];
		}
		else
		{
			$x[3] = $query1->quantity - $get_available;
			if($x[3]==0 || $x[3]=="")
			{
				$x[2] = "0";
			}
		}
		
		$today_date = date("Ymd");
		$sale_end_date = date("Ymd",strtotime($query1->sale_end_date));
		if($query1->discount!="")
		{
			if($sale_end_date=="19700101")
			{
				$sale_end_date=$today_date;
			}
			if($today_date<=$sale_end_date)
			{
			}
			else
			{
				$x[1] = $x[0];
				$query1->discount = $x[2] = "";
			}
		}
		$x[4] = $query->button_type;
		if($x[4]=="0")
		{
			$variations1 	= $query1->id;
			$product_id 	= $query->id;
			if($query->product_type==1 || $query->product_type==3)
			{
				if($x[3]!=0)
				{
					$query2 = $this->db->query("select * from tbl_variations1_variations2_join where product_id='$product_id' and id='$variations1' and variations1='0' and variations2='0'")->row();
					
					$variations1_id = $query2->variations1;
					$variations2_id = $query2->variations2;
					
					$temp_id = $_SESSION['temp_id'];
					$query3 = $this->db->query("select * from add_to_cart where product_id='$product_id' and temp_id='$temp_id' and variations1_id='$variations1_id' and variations2_id='$variations2_id'")->row();
					if($query3->id!="")
					{
						$cid= $query3->id;
						$my = "<div class='mobile_col_off col-sm-6 col-6 new_add_to_cart_css new_add_to_cart_".$product_id."'><a title='Remove From cart' class='btn btn-danger full_width_btn mybtn_remove_from_cart_color' onclick='new_remove_to_cart(".$cid.",".$product_id.",".$variations1.")' href='JavaScript:Void(0);' style='width:100%'><i class='fa fa-shopping-bag mr-1'></i>Remove</a></div>
						
						<div class='mobile_div_show col-sm-12 col-12 new_add_to_cart_css new_add_to_cart_".$product_id."'><a title='Remove From cart' class='btn btn-danger full_width_btn1 mybtn_remove_from_cart_color' onclick='new_remove_to_cart(".$cid.",".$product_id.",".$variations1.")' href='JavaScript:Void(0);' style='width:100%'><i class='fa fa-shopping-bag mr-1'></i>Remove</a></div>";
					}
					else
					{
						$my = "<div class='mobile_col_off col-sm-6 col-6 new_add_to_cart_css new_add_to_cart_".$product_id."'><a title='Add To Cart' class='btn btn-primary full_width_btn mybtn_add_to_cart_color' onclick='new_add_to_cart(".$product_id.",".$variations1.")' href='JavaScript:Void(0);'><i class='fa fa-shopping-bag mr-1'></i>Add to Cart</a></div>
						
						<div class='mobile_div_show col-sm-12 col-12 new_add_to_cart_css new_add_to_cart_".$product_id."'><a title='Add To Cart' class='btn btn-primary full_width_btn1 mybtn_add_to_cart_color' onclick='new_add_to_cart(".$product_id.",".$variations1.")' href='JavaScript:Void(0);'><i class='fa fa-shopping-bag mr-1'></i>Add to Cart</a></div>
						";
					}
					$x[5] = $my."<div class='mobile_col_off col-sm-6 col-6 new_buy_now_div_css new_buy_now_div_".$product_id."'><a title='Buy Now' class='btn btn-warning full_width_btn mybtn_buy_now_cart_color' onclick='new_buy_now(".$product_id.",".$variations1.")' href='JavaScript:Void(0);'><i class='fa fa-check-circle' aria-hidden='true'></i>Buy Now</a></div>";
				}
				else
				{
					$x[5] = "<div class='col-sm-12'><a class='btn btn-danger full_width_btn1 mybtn_out_of_stock_cart_color' href='#'>Out Of Stock</a></div>";
				}
			}
			if($query->product_type==2)
			{
				$x[5] = "<div class='col-sm-12'><a title='Options' href='".base_url()."product/".$query->url.".html' class='btn btn-primary full_width_btn1 mybtn_options_cart_color'><i class='fa fa-shopping-bag mr-1'></i>Options</a></div>";
			}
		}
		if($x[4]=="1")
		{
			$x[5] = "<div class='col-12'><a title='View Product' href='".base_url()."product/".$query->url.".html' class='btn btn-primary full_width_btn1 mybtn_view_product_cart_color'><i class='fa fa-shopping-bag mr-1'></i>View Product</a></div>";
		}
		return $x;
	}
	
	public function get_product_price_var($id)
	{
		$query1 = $this->db->query("select * from tbl_variations1_variations2_join where id='$id'")->row();		
		
		$product_id = $query1->product_id;
		$get_available = $this->Scheme_Model->get_available($product_id,$query1->variations1,$query1->variations2);
		
		$query = $this->db->query("select * from tbl_product where id='$product_id'")->row();		
		
		if($query->product_type=="3")
		{
			$combo_product = $query->combo_product;
			$combo_product2 = explode(",",$combo_product);
			$xy = 0;
			foreach($combo_product2 as $pid)
			{
				// yha wo ha jo bik gaya ha
				$query1n = $this->db->query("select * from tbl_variations1_variations2_join where id='$pid'")->row();
				$get_available1 = $this->Scheme_Model->get_available($product_id,$query1n->variations1,$query1n->variations2);
				
				$get_available2[$xy] = $query1n->quantity - $get_available1;
				$xy++;
			}
			sort($get_available2);
		}
		
		if($query1->discount=="" || $query1->discount=="0")
		{
			$query1->discount = "";
		}
		$price = $query1->price;
		//$x[0] = $price + ($price * $query->product_gst / 100);
		$x[0] = $price;
		if($query1->discount == "")
		{
			$x[1] = $price;
		}
		else
		{
			$x[1] = $query1->discount;
		}
		//$x[1] =	$x[1] + ($x[1] * $query->product_gst / 100);
		$x[2] = $query1->discount;
		if($x[2]!="")
		{
			$x[2] = $price - $query1->discount;
			$x[2] = ($x[2] / $price) * 100;
			$x[2] = round($x[2])."% off";
		}
		if($query->product_type=="3")
		{
			$x[3] = $get_available2[0];
		}
		else
		{
			$x[3] = $query1->quantity - $get_available;
			if($x[3]==0 || $x[3]=="")
			{
				$x[2] = "0";
			}
		}
		$today_date = date("Ymd");
		$sale_end_date = date("Ymd",strtotime($query1->sale_end_date));
		if($query1->discount!="")
		{
			if($sale_end_date=="19700101")
			{
				$sale_end_date=$today_date;
			}
			if($today_date<=$sale_end_date)
			{
			}
			else
			{
				$x[1] = $x[0];
				$query1->discount = $x[2] = "";
			}
		}
		
		return $x;
	}
	
	public function product_variations1_name_to_id($id)
	{
		$query = $this->db->query("select * from tbl_variations1 where id='$id' ")->row();
		$x = $query->variations1_name;
		return $x;
	}
	
	public function product_variations2_name_to_id($id)
	{
		$query = $this->db->query("select * from tbl_variations2 where id='$id' ")->row();
		$x = $query->variations2_name;
		return $x;
	}
	
	public function product_search_variations1($get,$pid)
	{
		$xx = "0";
		if($get["price1"]=="")
		{
			$xx = "1";
		}
		$q1 = $this->db->query("select DISTINCT tbl_variations1.variations1_name from tbl_product,tbl_variations1 where  tbl_product.id=$pid and  tbl_variations1.product_id=tbl_product.id and tbl_product.status='1' ")->result();
		foreach($q1 as $row123)
		{
			$x = ucwords(base64_decode($row123->variations1_name));
			if($get[$x]=="on")
			{
				$xx = "1";
			}
		}
		return $xx;
	}
	
	public function product_search_variations2($get,$pid)
	{
		$xx = "0";
		if($get["price1"]=="")
		{
			$xx = "1";
		}
		$q1 = $this->db->query("select DISTINCT tbl_variations2.variations2_name from tbl_product,tbl_variations2 where  tbl_product.id=$pid and  tbl_variations2.product_id=tbl_product.id and tbl_product.status='1' ")->result();
		foreach($q1 as $row123)
		{
			$x = ucwords(base64_decode($row123->variations2_name));
			if($get[$x]=="on")
			{
				$xx = "1";
			}
		}
		return $xx;
	}
	
	public function get_selected_product_price($id)
	{
		$temp_id = $_SESSION["temp_id"];
		$query = $this->db->query("select * from add_to_cart where id='$id' and temp_id='$temp_id'")->row();
		if($query->id)
		{
			$x[0] = $query->price;
			$discount = $query->discount;
			if($discount=="" || $discount==0)
			{
			}
			else
			{
				$x[0] = $discount;
			}
			$x[1] = $query->product_quantity;
			//$x[2] = $x[0] * $query->gst / 100;
			$x[3] = ($x[0] + $x[2]) * $x[1];
		}
		return $x;
	}
	
	function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth)
	{
		if($ext=="jpg" || $ext=="jpeg")
		{
			$src = imagecreatefromjpeg($uploadedfile);
		}
		else if($ext=="png")
		{
			$src = imagecreatefrompng($uploadedfile);
		}
		else if($ext=="gif")
		{
			$src = imagecreatefromgif($uploadedfile);
		}
		else
		{
			$src = imagecreatefrombmp($uploadedfile);
		}
																		
		list($width,$height)=getimagesize($uploadedfile);
		$newheight=($height/$width)*$newwidth;
		$tmp=imagecreatetruecolor($newwidth,$newheight);
		imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
		$filename = $path.$newwidth.'_'.$actual_image_name;
		imagejpeg($tmp,$filename,100);
		imagedestroy($tmp);
		$filename = $actual_image_name;
		return $filename;
	}
	function getExtension($str) 
	{
		$i = strrpos($str,".");
		if (!$i) { return ""; } 
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		return $ext;
	}
	
	public function get_product_default_image($id,$css)
	{
		$query = $this->db->query("select * from tbl_multiple_image where product_id='$id' order by img_no asc")->row();
		if($query->id)
		{
			?>
			<div class="img_hover_css">
			<?php
			$myic = 1;
			$query1 = $this->db->query("select * from tbl_multiple_image where product_id='$id' order by img_no asc limit 2")->result();
			foreach($query1 as $row1){
			?>
			<img src="<?= base_url()?>/uploads/manage_product/photo/500_<?php echo$row1->image; ?>" class="<?= $css ?> img_hover_css<?= $myic ?>">
			<?php
			$myic++;
			}
			if($myic=="2")
			{
				?>
				<img src="<?= base_url()?>/uploads/manage_product/photo/500_<?php echo$row1->image; ?>" class="<?= $css ?> img_hover_css<?= $myic ?>">
				<?php
			}
			?>
			</div>
			<?php
		}
		else
		{
			?>
			<img src="<?= base_url()?>/uploads/manage_product/photo/notfound.png" class="<?= $css ?>">
			<?php
		}
		return $x;
	}

	public function mycartpagedata()
	{
		$price_icon = $this->Scheme_Model->get_website_data("price_icon");
		$total = 0;
		$gst = 0;
		$temp_id = $_SESSION['temp_id'];
		$result = $this->db->query("select * from add_to_cart where temp_id='$temp_id'")->result();
		foreach($result as $row)
		{
			$row->price = $row->price;
			$discount = $row->discount;
			if($discount=="" || $discount==0)
			{
			}
			else
			{
				$row->price = $discount;
			}
			//$total+= (($row->price - $row->price * $row->gst / 100 )* $row->product_quantity);
			//$gst+= $row->price * $row->gst / 100;
			$gst+= $row->price - ($row->price * (100 / (100 + $row->gst)));
			$gstme = $row->price - ($row->price * (100 / (100 + $row->gst)));
			$total+= ($row->price - $gstme )* $row->product_quantity;
		}
		?>
		<?php $invoice_country = $this->Scheme_Model->get_website_data("invoice_country") ;?>
		<?php $invoice_state = $this->Scheme_Model->get_website_data("invoice_state") ;
		$shipping_free = $this->Scheme_Model->get_website_data("shipping_free") ;
		?>
		<?php $_SESSION["gst"] = $gst ?>
		<h4 class="heading-primary">Cart Totals</h4>
		<table class="cart-totals">
			<tbody>
				<tr class="cart-subtotal">
					<th>
						<strong>Subtotal</strong>
					</th>
					<td width="60%" class="text-right">
						<strong>
							<span class="amount">
								<?php $_SESSION["total_price"] = $total?> 
								<?= $price_icon ?>
								<?= number_format($total,2); ?>
							</span>
						</strong>
					</td>
				</tr>
				<tr class="shipping">
					<th>
						Shipping
					</th>
					<td class="text-right">
						<?php  
						if($_SESSION["shipping"]==""){
							$_SESSION["shipping"] = $shipping = $this->Scheme_Model->get_website_data("shipping");
						} 
						$shipping = $_SESSION["shipping"] + $_SESSION["other_shipping"];
						if($shipping_free<=$_SESSION["total_price"])
						{
							$shipping = $_SESSION["shipping"] = $_SESSION["other_shipping"] = 0;
						}
						?>
						<strong>
						<?= $price_icon ?>
						<?= number_format($shipping,2); ?>
						</strong>
					</td>
				</tr>
				<?php 
				$tbl_website_type1 = $this->db->query("select * from tbl_website_type1 where selected_theme='1'")->row();
				if($tbl_website_type1->id==1)
				{
					if($_SESSION["state_id"]==$invoice_state)
					{
						$_SESSION["gst_type"] = "2";
						?>
						<tr class="shipping">
							<th>
								SGST
							</th>
							<td class="text-right">
								<strong>
								<?= $price_icon ?>
								<?= number_format($gst/2,2); ?>
								</strong>
							</td>
						</tr>
						<tr class="shipping">
							<th>
								CGST
							</th>
							<td class="text-right">
								<strong>
								<?= $price_icon ?>
								<?= number_format($gst/2,2); ?>
								</strong>
							</td>
						</tr>
						<?php
					}
					else
					{
						?>
						<tr class="shipping">
							<th>
								IGST
							</th>
							<td class="text-right">
								<strong>
								<?= $price_icon ?>
								<?= number_format($gst,2); ?>
								</strong>
							</td>
						</tr>
						<?php 
					} 
				}
				if($tbl_website_type1->id==2)
				{
					?>
					<tr class="shipping">
						<th>
							Tax Amount
						</th>
						<td class="text-right">
							<strong>
							<?= $price_icon ?>
							<?= number_format($gst,2); ?>
							</strong>
						</td>
					</tr>
					<?php 
				}
				?>
				<tr class="shipping">
					<th>
						Discount
					</th>
					<td class="text-right">
						<?php  
						$coupon_code_discount = $_SESSION["coupon_code_discount"];
						if($coupon_code_discount=="")
						{
							$_SESSION["coupon_code_discount"] = $coupon_code_discount = 0;
						}
						?>
						<strong>
						- <?= $price_icon ?>
						<?= number_format($coupon_code_discount,2); ?>
						</strong>
					</td>
				</tr>
				<tr class="shipping">
					<th>
						<strong>Grand Total</strong>
					</th>
					<td class="text-right">
						<strong>
						<span class="amount">
							<?= $price_icon ?>
							<?= number_format($total+$gst+$shipping-$coupon_code_discount,2); ?>
						</span>
						</strong>
						<?php
						$_SESSION["grand_total"] = $total+$gst+$shipping-$coupon_code_discount;					
						?>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}
	
	public function newcart_show_me()
	{
		$price_icon = $this->Scheme_Model->get_website_data("price_icon");
		?>
		<table class="cart" width="100%">
			<tbody class="">
				<?php
				$cart_count = 0;
				$total_price = 0;
				$temp_id = $_SESSION['temp_id'];
				$result2 = $this->db->query("select * from add_to_cart where temp_id='$temp_id'")->result();
				foreach($result2 as $row2)
				{
					$cart_count++;
					$product_id = $row2->product_id;
					$row11 = $this->db->query("select * from tbl_product where id='$product_id'")->row();
					?>
					
					<tr class="cart_item_<?= $row2->id ?>">
						<td class="product-thumbnail" style="width:15%">
							<a href="<?= base_url(); ?>product/<?= $row11->url; ?>.html?v1=<?= $row2->variations1_name?>&v2=<?= $row2->variations2_name?>">
								<?php echo $this->Scheme_Model->get_product_default_image($row11->id,"img-fluid small_cart_width img-thumbnail"); ?>
							</a>
						</td>
						<td>
						&nbsp;
						</td>
						<td class="product-name" valign="top">
							<a href="<?= base_url(); ?>product/<?= $row11->url; ?>.html?v1=<?= $row2->variations1_name?>&v2=<?= $row2->variations2_name?>">
							<b><?= base64_decode($row2->product_name)?></b>
							</a>
							<?php
							if($row11->variations1_title!="")
							{?>
								<br>
								<?= base64_decode($row11->variations1_title); ?>:
								<span>
								<?= base64_decode($row2->variations1_name); ?></span>
								<?php
							}?><?php
							if($row11->variations2_title!="")
							{?>
								<br>
								<?= base64_decode($row11->variations2_title); ?>:
								<span>
								<?= base64_decode($row2->variations2_name); ?></span>
								<?php
							}
							?>
							</b>
							<span>						
							<?php 
							$pro = $this->Scheme_Model->get_selected_product_price($row2->id); ?>
							<br>Qty: <?= $row2->product_quantity;?>
							<?php $total_price = $total_price + ($pro[3]); ?>
							<br>
							<span>
								<?php echo $price_icon ?>
								<?= number_format($pro[3]);?>
							</span>
						</td>
						<td class="product-actions">
							<a title="Remove this item" class="remove" href="#" onclick="remove_to_cart_in_cart_page('<?php echo $row2->id ?>')">
								<i class="fas fa-times"></i>
							</a>
						</td>
					</tr>
					<tr>
						<td class="actions" colspan="4">
							&nbsp;
						</td>
					</tr>
				<?php 
				} 
				if($cart_count!=0)
				{
				?>
				<tr>
					<td class="actions" colspan="4">
						<div class="actions-continue">
							<a href="<?= base_url(); ?>cart" class="btn btn-light float-left">
							View Cart
							</a>
							<a href="<?= base_url(); ?>cart/Checkout" class="btn btn-light float-right">
							Proceed to Checkout 
							</a>
						</div>
					</td>
				</tr>
				<?php
				}
				if($cart_count==0 || $cart_count=="")
				{
					?>
					<tr>
						<td class="actions" colspan="4">
							Cart Empty
						</td>
					</tr>
					<?php
				}
				?>															
			</tbody>
		</table>
		<?php
		$_SESSION["new_cart_count"] = $cart_count;
	}
	
	public function register_email($id)
	{
		$row = $this->db->query("select * from tbl_client where id='$id'")->row();
		?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">		
		<?php
		$invoice_name = "RegisterAccount";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";
		$headers .= "From: \"$invoice_name\" <$invoice_name>\r\n";
		$subject = "Register Account";
		
		$img_url = base_url()."/uploads/manage_website/photo/".$this->Scheme_Model->get_website_data("invoice_logo");
		$invoice_country = $this->Scheme_Model->get_website_data("invoice_country");
		$invoice_state = $this->Scheme_Model->get_website_data("invoice_state");
		$invoice_state = $this->db->query("select * from tbl_state where id=
		'$invoice_state'")->row();
		$invoice_state = $invoice_state->name;
		
		$invoice_country = $this->db->query("select * from tbl_country where id='$invoice_country'")->row();
		$invoice_country = $invoice_country->name;
		
		$invoice_address = $this->Scheme_Model->get_website_data("invoice_address").",".$invoice_state.",".$invoice_country;
		$invoice_footer = $this->Scheme_Model->get_website_data("invoice_footer");
		
		$mailbody = "<table cellpadding='5' bgcolor='#eee' cellspacing='5' style='max-width: 600px;margin: auto; padding: 30px; border: 1px solid #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px;line-height: 24px;  font-family: Arial; background:#ffffff; color: #2e2e2e;'>
		<tr class='information'>
		<td colspan='2'>
			<table style='width: 600px; line-height: inherit; text-align: left;'>
				<tr>
					<td>
						<table style='width: 600px; line-height: inherit; text-align: left;'>
							<tr>
								<td style='padding-bottom: 20px;padding-top: 18px;text-align:center; width:35%;' width='35%'>
									<img src='".$img_url."' width='90%'>
								</td>
								<td style='padding-bottom: 20px;padding-top: 20px;text-align:right;'>
									".$invoice_address."
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style='border-bottom-style: solid;  border-bottom-color: #dbc180;border-bottom-width: 2px;'></td>
				</tr>
				<tr>
					<td style='padding-bottom: 40px; text-align: center; padding-bottom: 20px;'>
						<h3>".$title_me."</h3>
					</td>
				</tr>
				<tr>
					<td>
				Dear ".base64_decode($row->fname).",<br><br> Thanks to Register your account<br><br> Your Login Details<br><br> Email: $row->email <br><br> Password: your password<br><br>
					</td>
				</tr>
			</table>";
		
		$email = $row->email;
		
		$to	= $email.",".$this->Scheme_Model->get_website_data("invoice_email");
		mail($to, $subject, $mailbody, $headers ."X-Mailer: PHP/" . phpversion());
	}
	
	public function enquiry_email_for_user($id)
	{
		$row = $this->db->query("select * from tbl_enquiry where id='$id'")->row();
		$invoice_name = "Enquiry";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";
		$headers .= "From: \"$invoice_name\" <$invoice_name>\r\n";
		$subject = "Register Account";
		
		$img_url = base_url()."/uploads/manage_website/photo/".$this->Scheme_Model->get_website_data("invoice_logo");
		$invoice_country = $this->Scheme_Model->get_website_data("invoice_country");
		$invoice_state = $this->Scheme_Model->get_website_data("invoice_state");
		$invoice_state = $this->db->query("select * from tbl_state where id=
		'$invoice_state'")->row();
		$invoice_state = $invoice_state->name;
		
		$invoice_country = $this->db->query("select * from tbl_country where id='$invoice_country'")->row();
		$invoice_country = $invoice_country->name;
		
		$invoice_address = $this->Scheme_Model->get_website_data("invoice_address").",".$invoice_state.",".$invoice_country;
		$invoice_footer = $this->Scheme_Model->get_website_data("invoice_footer");
		
		$mailbody = "<table cellpadding='5' bgcolor='#eee' cellspacing='5' style='max-width: 600px;margin: auto; padding: 30px; border: 1px solid #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px;line-height: 24px;  font-family: Arial; background:#ffffff; color: #2e2e2e;'>
		<tr class='information'>
		<td colspan='2'>
			<table style='width: 600px; line-height: inherit; text-align: left;'>
				<tr>
					<td>
						<table style='width: 600px; line-height: inherit; text-align: left;'>
							<tr>
								<td style='padding-bottom: 20px;padding-top: 18px;text-align:center; width:35%;' width='35%'>
									<img src='".$img_url."' width='90%'>
								</td>
								<td style='padding-bottom: 20px;padding-top: 20px;text-align:right;'>
									".$invoice_address."
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style='border-bottom-style: solid;  border-bottom-color: #dbc180;border-bottom-width: 2px;'></td>
				</tr>
				<tr>
					<td style='padding-bottom: 40px; text-align: center; padding-bottom: 20px;'>
						<h3>".$title_me."</h3>
					</td>
				</tr>
				<tr>
					<td>
					Dear ".($row->full_name).",<br><br> Thank to send enquiry contact you soon as possible<br><br>
					</td>
				</tr>
			</table>";
		
		$email = $row->email;
		
		$to	= $email;
		mail($to, $subject, $mailbody, $headers ."X-Mailer: PHP/" . phpversion());
	}
	
	public function enquiry_email_for_admin($id)
	{
		$row = $this->db->query("select * from tbl_enquiry where id='$id'")->row();
		
		$invoice_name = "Enquiry";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html; charset=UTF-8" . "\r\n";
		$headers .= "From: \"$invoice_name\" <$invoice_name>\r\n";
		$subject = "Register Account";
		
		$img_url = base_url()."/uploads/manage_website/photo/".$this->Scheme_Model->get_website_data("invoice_logo");
		$invoice_country = $this->Scheme_Model->get_website_data("invoice_country");
		$invoice_state = $this->Scheme_Model->get_website_data("invoice_state");
		$invoice_state = $this->db->query("select * from tbl_state where id=
		'$invoice_state'")->row();
		$invoice_state = $invoice_state->name;
		
		$invoice_country = $this->db->query("select * from tbl_country where id='$invoice_country'")->row();
		$invoice_country = $invoice_country->name;
		
		$invoice_address = $this->Scheme_Model->get_website_data("invoice_address").",".$invoice_state.",".$invoice_country;
		$invoice_footer = $this->Scheme_Model->get_website_data("invoice_footer");
		
		$product_name = base64_decode($row->product_name);
		if($row->variations1_name!="")
		{
			$product_name.= ",".base64_decode($row->variations1_name);
		}
		if($row->variations2_name!="")
		{
			$product_name.= ",".base64_decode($row->variations2_name);
		}
		$tbl_product = $this->db->query("select * from tbl_product where id='$row->product_id'")->row();
		$siteurl = base_url()."product/".$tbl_product->url.".html?v1=".$row->variations1_name."&$v2=".$row->variations2_name;
		$adminurl = base_url()."admin/manage_product/edit/".$row->product_id;
		
		$mailbody = "<table cellpadding='5' bgcolor='#eee' cellspacing='5' style='max-width: 600px;margin: auto; padding: 30px; border: 1px solid #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px;line-height: 24px;  font-family: Arial; background:#ffffff; color: #2e2e2e;'>
		<tr class='information'>
		<td colspan='2'>
			<table style='width: 600px; line-height: inherit; text-align: left;'>
				<tr>
					<td>
						<table style='width: 600px; line-height: inherit; text-align: left;'>
							<tr>
								<td style='padding-bottom: 20px;padding-top: 18px;text-align:center; width:35%;' width='35%'>
									<img src='".$img_url."' width='90%'>
								</td>
								<td style='padding-bottom: 20px;padding-top: 20px;text-align:right;'>
									".$invoice_address."
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style='border-bottom-style: solid;  border-bottom-color: #dbc180;border-bottom-width: 2px;'></td>
				</tr>
				<tr>
					<td style='padding-bottom: 40px; text-align: center; padding-bottom: 20px;'>
						<h3>".$title_me."</h3>
					</td>
				</tr>
				<tr>
					<td>
						Name:- ".$row->full_name."<br>
						Email:- ".$row->email."<br>
						MobileNo:- ".$row->mobile_no."<br>
						Enquiry:- ".base64_decode($row->enquiry)."<br>
						Product:- ".$product_name."<br>
						Product SiteUrl:- ".$siteurl."<br>
						Product AdminUrl:- ".$adminurl."<br>
					</td>
				</tr>
			</table>";
		
		$to	= $this->Scheme_Model->get_website_data("invoice_email");
		mail($to, $subject, $mailbody, $headers ."X-Mailer: PHP/" . phpversion());
	}
	
	public function emailsend_function($id,$title_me,$paymeny_type)
	{
		$price_icon = $this->Scheme_Model->get_website_data("price_icon");
		$row = $this->db->query("select * from check_out_tbl where id='$id'")->row();
		$order_id = $row->order_id;
		$date = date("d-M-Y",strtotime($row->date));
		$companyname = base64_decode($row->companyname);
		$fname = base64_decode($row->fname);
		$lname = base64_decode($row->lname);
		$email = $row->email;
		$mobile = $row->mobile;
		$country_id = $row->country_id;
		$state_id = base64_decode($row->state);
		$towncity = base64_decode($row->towncity);
		$postcode = base64_decode($row->postcode);
		$country = $this->db->query("select * from tbl_country where id='$country_id'")->row();
		
		$state = $this->db->query("select * from tbl_state where id=
		'$state_id'")->row();
		$state_id = $state->name;
		
		$city = $this->db->query("select * from tbl_city where id=
		'$towncity'")->row();
		$city_id = $city->name;
		
		$address2 = $city_id.",".$state_id.",".$country->name."($postcode) <br>".base64_decode($row->address);
		$total_price = number_format($row->total_price,2);
		$gst = $row->gst;
		$gst_type = number_format($row->gst_type,2);
		$shipping = number_format($row->shipping,2);
		$coupon_code_discount = number_format($row->coupon_code_discount,2);
		$grand_total = number_format($row->grand_total,2);
		
		$temp_id = $row->temp_id;
		$result1 = $this->db->query("select * from add_to_cart where temp_id='$temp_id'")->result();
		foreach ($result1 as $row1)
		{
			$product_id = $row1->product_id;
			$row2 = $this->db->query("select * from tbl_product where id='$product_id'")->row();
			
			$tbl_website_type1 = $this->db->query("select * from tbl_website_type1 where selected_theme='1'")->row();
			
			$product_quantity = $row1->product_quantity;
			if($row1->discount=="" || $row1->discount==0)
			{
			  	$price = $row1->price - ($row1->price * $row2->product_gst / 100);$price1 = $row1->price;			 				
			}
			else
			{
			    $price = $row1->discount - ($row1->discount * $row2->product_gst / 100);
				$price1 = $row1->discount;
			}
		
			$total = number_format($price * $row1->product_quantity,2);
			$price = round($price);
			$myproductdata.='<tr><td style="font-size: 17px;padding: 6px;">
				'.base64_decode($row2->name).'
			</td>
			<td style="font-size: 17px;text-align:right;padding: 6px;">
				'.$product_quantity.'
			</td>
			<td style="font-size: 17px;text-align:right;padding: 6px;">
				'.$price_icon.' '.$price.'/-
			</td>
			<td style="font-size: 17px;text-align:right;padding: 6px;">
				'.$row2->product_gst.'
			</td>
			<td style="font-size: 17px;text-align:right;padding: 6px;">
				'.$price_icon.' '.$price1.'/-		
			</td></tr>';
		}
		
		$tax = $gst;
		if($gst_type==1)
		{			
			$gst = '<tr>
						<td style=" border-top: 1px solid #eee;font-size: 14px; font-weight: bold;text-align: right; padding: 8px;">
						   Total GST: '.$price_icon.' '.number_format($gst,2).'/-
						</td>
					</tr>';
		}
		else
		{
			$gst = '<tr>
						<td style=" border-top: 1px solid #eee;font-size: 14px; font-weight: bold;text-align: right; padding: 8px;">
						   Total SGST: '.$price_icon.' '.number_format($gst/2,2).'/-
						</td>
					</tr>
					<tr>
						<td style=" border-top: 1px solid #eee;font-size: 14px; font-weight: bold;text-align: right; padding: 8px;">
						   Total CGST: '.$price_icon.' '.number_format($gst/2,2).'/-
						</td>
					</tr>';
		}
		
		$title_of_tax = "GST";
		if($tbl_website_type1->title=="tax")
		{
			$title_of_tax = "Tax";
			$gst = '<tr>
						<td style=" border-top: 1px solid #eee;font-size: 14px; font-weight: bold;text-align: right; padding: 8px;">
						   Total Tax: '.$price_icon.' '.number_format($tax,2).'/-
						</td>
					</tr>';
		}
		
		$img_url = base_url()."/uploads/manage_website/photo/".$this->Scheme_Model->get_website_data("invoice_logo");
		$invoice_country = $this->Scheme_Model->get_website_data("invoice_country");
		$invoice_state = $this->Scheme_Model->get_website_data("invoice_state");
		$invoice_state = $this->db->query("select * from tbl_state where id=
		'$invoice_state'")->row();
		$invoice_state = $invoice_state->name;
		
		$invoice_country = $this->db->query("select * from tbl_country where id='$invoice_country'")->row();
		$invoice_country = $invoice_country->name;
		
		$invoice_address = $this->Scheme_Model->get_website_data("invoice_address").",".$invoice_state.",".$invoice_country;
		$invoice_footer = $this->Scheme_Model->get_website_data("invoice_footer");
		
		$mailbody = "<table cellpadding='5' bgcolor='#eee' cellspacing='5' style='max-width: 600px;margin: auto; padding: 30px; border: 1px solid #ffffff; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px;line-height: 24px;  font-family: Arial; background:#ffffff; color: #2e2e2e;'>
   <tr class='information'>
		<td colspan='2'>
			<table style='width: 600px; line-height: inherit; text-align: left;'>
				<tr>
					<td colspan='2'>
						<table style='width: 600px; line-height: inherit; text-align: left;'>
							<tr>
								<td style='padding-bottom: 20px;padding-top: 18px;text-align:center; width:35%;' width='35%'>
									<img src='".$img_url."' width='90%'>
								</td>
								<td style='padding-bottom: 20px;padding-top: 20px;text-align:right;'>
									".$invoice_address."
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style='border-bottom-style: solid;  border-bottom-color: #dbc180;border-bottom-width: 2px;' colspan='2'></td>
				</tr>
				<tr>
					<td style='padding-bottom: 40px; text-align: center; padding-bottom: 20px;' colspan='2'>
						<h3>".$title_me."</h3>
					</td>
				</tr>
				<tr>
					<td width='55%' style='padding-bottom: 40px; text-align: left; padding-bottom: 20px;width:55%'>				
						<span style='font-size: 17px;'>".$companyname."</span><br>
						<p style='margin:0;font-size: 17px;'>".$fname." ".$lname."</p>
						<p style='margin:0;font-size: 17px;'>".$email."</p><p style='margin:0;font-size: 17px;'>".$mobile."</p>
					</td>
					<td width='45%' style='padding-bottom: 40px; text-align: right; padding-bottom: 20px;' valign='top'>
						<span style='font-size: 17px;'>Invoice #: ".$order_id."</span><br>
						<p style='margin:0;font-size: 17px;'>Created: ".$date."</p>
						<p style='margin:0;font-size: 17px;'>Payment Type: ".$paymeny_type."</p>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<p style='margin:0;font-size: 17px;'>".$address2."</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table bgcolor='#fff' style='width: 600px; background: #fff; line-height: inherit; text-align: left;'>
				<tr class='heading'>
					<td>
						<table style='width: 600px; line-height: inherit; text-align: left;' border='1' cellpadding='0' cellspacing='0'>
							<tr>
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;padding: 6px;font-size: 17px;color:#2e2e2e;'>
									Product Name
								</td>
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;font-size: 17px;padding: 6px;width: 5%;color:#2e2e2e;text-align:center;'>Qty</td>		
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;font-size: 17px;padding: 6px;color:#2e2e2e;width: 20%;text-align:center;'>
									Price
								</td>
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;font-size: 17px;padding: 6px;color:#2e2e2e;width: 20%;text-align:center;'>
									".$title_of_tax."(%)
								</td>
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;font-size: 17px;padding: 6px;width: 20%;color:#2e2e2e;text-align:center;'>
									Total
								</td>
							</tr>
							".$myproductdata."
					  </table>
					</td>   
				</tr>							
				<tr class='total'>
				   <td>
						<table style='width: 600px; line-height: inherit; text-align: left;'>
							<tr>
								<td style=' border-top: 1px solid #eee;font-size: 14px; font-weight: bold;text-align: right; padding: 8px;'>
								   Total Price: ".$price_icon." ".$total_price."/-
								</td>
							</tr>
							<tr>
								<td style=' border-top: 1px solid #eee;font-size: 14px; font-weight: bold;text-align: right; padding: 8px;'>
								   Shipping: ".$price_icon." ".$shipping."/-
								</td>
							</tr>
							".$gst."
							<tr>
								<td style=' border-top: 1px solid #eee;font-size: 14px; font-weight: bold;text-align: right; padding: 8px;'>
								   Coupon Code Discount: ".$price_icon." ".$coupon_code_discount."/-
								</td>
							</tr>
							<tr>
								<td style=' border-top: 1px solid #eee;font-size: 14px; font-weight: bold;text-align: right; padding: 8px;'>
								   Grand Total: ".$price_icon." ".$grand_total."/-
								</td>
							</tr>
						</table>
				   </td> 
				</tr>
				<tr class='information'>
					<td>
						<table style='width: 600px; line-height: inherit; text-align:left; margin-top: 30px;'>
							<tr>
								<td style='padding-bottom: 40px;text-align: center;'>
								   ".$invoice_footer."
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>";
		return $mailbody;
	}
	
	public function order_to_send_mail($id,$mymsg)
	{
		$price_icon = $this->Scheme_Model->get_website_data("price_icon");
		$row = $this->db->query("select * from check_out_tbl where id='$id'")->row();
		
		$corrier_data = "";
		$corrier_no = $row->corrier_no;
		$corrier_name = $row->corrier_name;
		if($corrier_no!="" && $corrier_name!="")
		{
			$corrier_name = $this->db->query("select * from tbl_corrier where id='$corrier_name'")->row();
			$corrier_name = base64_decode($corrier_name->name);
			$corrier_data = "Corrier No : $corrier_no <br> Corrier Name : $corrier_name";
		}
		
		$order_id = $row->order_id;
		$date = date("d-M-Y",strtotime($row->date));
		$companyname = base64_decode($row->companyname);
		$fname = base64_decode($row->fname);
		$lname = base64_decode($row->lname);
		$email = $row->email;
		$mobile = $row->mobile;
		$country_id = $row->country_id;
		$state_id = base64_decode($row->state);
		$country = $this->db->query("select * from tbl_country where id='$country_id'")->row();
		if($country_id=="101")
		{
			$state = $this->db->query("select * from tbl_state where id=
			'$state_id'")->row();
			$state_id = $state->name;
		}
		
		$address2 = base64_decode($row->address).",".$state_id.",".$country->name;
		$total_price = number_format($row->total_price,2);
		$gst = $row->gst;
		$gst_type = number_format($row->gst_type,2);
		$shipping = number_format($row->shipping,2);
		$coupon_code_discount = number_format($row->coupon_code_discount,2);
		$grand_total = number_format($row->grand_total,2);
		
		$temp_id = $row->temp_id;
		$result1 = $this->db->query("select * from add_to_cart where temp_id='$temp_id'")->result();
		foreach ($result1 as $row1)
		{
			$product_id = $row1->product_id;
			$row2 = $this->db->query("select * from tbl_product where id='$product_id'")->row();
			
			$product_quantity = $row1->product_quantity;
			$price = $row1->price - ($row1->price * $row1->discount / 100);
			$total = number_format($price * $row1->product_quantity,2);
			$price = number_format($price,2);
			$myproductdata.='<tr><td style="font-size: 17px;padding: 6px;">
				'.base64_decode($row2->name).'
			</td>
			<td style="font-size: 17px;text-align:right;padding: 6px;">
				'.$product_quantity.'
			</td>
			<td style="font-size: 17px;text-align:right;padding: 6px;">
				'.$price_icon.' '.$price.'/-
			</td>
			<td style="font-size: 17px;text-align:right;padding: 6px;">
				'.$row2->product_gst.'
			</td>
			<td style="font-size: 17px;text-align:right;padding: 6px;">
				'.$price_icon.' '.$total.'/-		
			</td></tr>';
		}
		
		if($gst_type==1)
		{			
			$gst = '<tr>
						<td style=" border-top: 1px solid #eee;font-size: 15px; font-weight: bold;text-align: right; padding: 8px;">
						   Total GST: '.$price_icon.' '.number_format($gst,2).'/-
						</td>
					</tr>';
		}
		else
		{
			$gst = '<tr>
						<td style=" border-top: 1px solid #eee;font-size: 15px; font-weight: bold;text-align: right; padding: 8px;">
						   Total SGST: '.$price_icon.' '.number_format($gst/2,2).'/-
						</td>
					</tr>
					<tr>
						<td style=" border-top: 1px solid #eee;font-size: 15px; font-weight: bold;text-align: right; padding: 8px;">
						   Total CGST: '.$price_icon.' '.number_format($gst/2,2).'/-
						</td>
					</tr>';
		}

		
		$img_url = base_url()."/uploads/manage_website/photo/".$this->Scheme_Model->get_website_data("invoice_logo");
		$invoice_country = $this->Scheme_Model->get_website_data("invoice_country");
		$invoice_state = $this->Scheme_Model->get_website_data("invoice_state");
		
		if($invoice_country=="101")
		{
			$invoice_state = $this->db->query("select * from tbl_state where id=
			'$invoice_state'")->row();
			$invoice_state = $invoice_state->name;
		}
		$invoice_country = $this->db->query("select * from tbl_country where id='$invoice_country'")->row();
		$invoice_country = $invoice_country->name;
		
		$invoice_address = $this->Scheme_Model->get_website_data("invoice_address").",".$invoice_state.",".$invoice_country;
		$invoice_footer = $this->Scheme_Model->get_website_data("invoice_footer");
		
		$mailbody = "<table cellpadding='0' bgcolor='#eee' cellspacing='0' style='max-width: 600px;margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, .15); font-size: 16px;line-height: 24px;  font-family: Arial; background:#eee; color: #2e2e2e;'>
   <tr class='information'>
		<td colspan='2'>
			<table style='width: 600px; line-height: inherit; text-align: left;'>
				<tr>
					<td colspan='2'>
						<table style='width: 600px; line-height: inherit; text-align: left;'>
							<tr>
								<td style='padding-bottom: 20px;padding-top: 18px;text-align:center; width:35%;' width='35%'>
									<img src='".$img_url."' width='90%'>
								</td>
								<td style='padding-bottom: 20px;padding-top: 20px;text-align:right;'>
									".$invoice_address."
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td style='border-bottom-style: solid;  border-bottom-color: #dbc180;border-bottom-width: 2px;' colspan='2'></td>
				</tr>
				<tr>
					<td style='padding-bottom: 40px; text-align: center; padding-bottom: 20px;' colspan='2'>
						<h3>Order Status : ".$mymsg."</h3>
						<br>".$corrier_data."
					</td>
				</tr>
				<tr>
					<td style='padding-bottom: 40px; text-align: center; padding-bottom: 20px;' colspan='2'>
						<h3>Shipping Details</h3>
					</td>
				</tr>
				<tr>
					<td style='padding-bottom: 40px; text-align: left; padding-bottom: 20px;width:55%'>				
						<span style='font-size: 17px;'>".$companyname."</span><br>
						<p style='margin:0;font-size: 17px;'>".$fname." ".$lname."</p>
						<p style='margin:0;font-size: 17px;'>".$email."</p><p style='margin:0;font-size: 17px;'>".$mobile."</p>
						<p style='margin:0;font-size: 17px;'>".$address2."</p>
					</td>
					<td style='padding-bottom: 40px; text-align: right; padding-bottom: 20px;' valign='top'>
						<span style='font-size: 17px;'>Invoice #: ".$order_id."</span><br>
						<p style='margin:0;font-size: 17px;'>Created: ".$date."</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table bgcolor='#fff' style='width: 600px; background: #fff; line-height: inherit; text-align: left;'>
				<tr class='heading'>
					<td>
						<table style='width: 600px; line-height: inherit; text-align: left;' border='1' cellpadding='0' cellspacing='0'>
							<tr>
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;padding: 6px;font-size: 17px;color:#2e2e2e;'>
									Product Name
								</td>
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;font-size: 17px;padding: 6px;width: 5%;color:#2e2e2e;text-align:center;'>Qty</td>		
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;font-size: 17px;padding: 6px;color:#2e2e2e;width: 20%;text-align:center;'>
									Price
								</td>
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;font-size: 17px;padding: 6px;color:#2e2e2e;width: 20%;text-align:center;'>
									GST(%)
								</td>
								<td style='background: #eee;border-bottom: 1px solid #ddd;font-weight: bold;font-size: 17px;padding: 6px;width: 20%;color:#2e2e2e;text-align:center;'>
									Total
								</td>
							</tr>
							".$myproductdata."
					  </table>
					</td>   
				</tr>							
				<tr class='total'>
				   <td>
						<table style='width: 600px; line-height: inherit; text-align: left;'>
							<tr>
								<td style=' border-top: 1px solid #eee;font-size: 15px; font-weight: bold;text-align: right; padding: 8px;'>
								   Total Price: ".$price_icon." ".$total_price."/-
								</td>
							</tr>
							<tr>
								<td style=' border-top: 1px solid #eee;font-size: 15px; font-weight: bold;text-align: right; padding: 8px;'>
								   Shipping: ".$price_icon." ".$shipping."/-
								</td>
							</tr>
							".$gst."
							<tr>
								<td style=' border-top: 1px solid #eee;font-size: 15px; font-weight: bold;text-align: right; padding: 8px;'>
								   Coupon Code Discount: ".$price_icon." ".$coupon_code_discount."/-
								</td>
							</tr>
							<tr>
								<td style=' border-top: 1px solid #eee;font-size: 15px; font-weight: bold;text-align: right; padding: 8px;'>
								   Grand Total: ".$price_icon." ".$grand_total."/-
								</td>
							</tr>
						</table>
				   </td> 
				</tr>
				<tr class='information'>
					<td>
						<table style='width: 600px; line-height: inherit; text-align:left; margin-top: 30px;'>
							<tr>
								<td style='padding-bottom: 40px;text-align: center;'>
								   ".$invoice_footer."
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>";
		return $mailbody;
	}
	
	public function cart_page_show_cart()
	{	
		$price_icon = $this->Scheme_Model->get_website_data("price_icon");
		?>
		<?php
		$i = 1;
		$temp_id = $_SESSION['temp_id'];
		$result = $this->db->query("select * from add_to_cart where temp_id='$temp_id'")->result();
		foreach($result as $row)
		{
			$row_id = $row->id;
			$product_id = $row->product_id;
			$row1 = $this->db->query("select * from tbl_product where id='$product_id'")->row();
			$pro = $this->Scheme_Model->get_selected_product_price($row->id); ?>
			<tr class="cart_table_item cart_item_<?php echo $row_id ?>">
				<td class="product-thumbnail">
					<a href="<?= base_url(); ?>product/<?= $row1->url; ?>.html?v1=<?= $row->variations1_name?>&v2=<?= $row->variations2_name?>">
						<?php echo $this->Scheme_Model->get_product_default_image($row1->id,"image_cart_pg"); ?>
					</a>
				</td>
				<td class="product-name">
					<a href="<?= base_url(); ?>product/<?= $row1->url; ?>.html?v1=<?= $row->variations1_name?>&v2=<?= $row->variations2_name?>">
						<?= base64_decode($row->product_name)?>
					</a>
					<?php
					if($row1->variations1_title!="")
					{
						?>
						<br>
						<?= base64_decode($row1->variations1_title); ?>:
						<span>
						<?= base64_decode($row->variations1_name); ?>
						</span>
						<?php
					}
					?>
					<?php
					if($row1->variations2_title!="")
					{
						?>
						<br>
						<?= base64_decode($row1->variations2_title); ?>:
						<?php 
						if($row->variations2_name!="0") { ?>
						<span>
						<?= base64_decode($row->variations2_name); ?>
						</span>
						<?php
						}
					}
					?>
				</td>
				<td class="product-price">
					<span class="amount">
						<?= $price_icon ?>
						<?= number_format($pro[0] + $pro[2]);?>
					</span>
				</td>
				<td class="product-quantity">
					<div class="quantity">
						<input type="button" class="minus" value="-" onclick="qty_down('<?php echo $row_id ?>')">
						<input type="text" class="input-text qty text total_qty_<?php echo $row_id ?>" title="Qty" value="<?= $pro[1];?>" name="quantity" min="1" step="1">
						<input type="button" class="plus" value="+" onclick="qty_up('<?php echo $row_id ?>')">
					</div>
				</td>
				<td class="product-subtotal">
					<span class="amount">
						<?= $price_icon ?>
						<?= number_format($pro[3]);?>
					</span>
				</td>			
				<td class="product-remove">
					<a title="Remove this item" class="remove" href="JavaScript:Void(0);" onclick="remove_to_cart_in_cart_page1('<?php echo $row->id ?>')">
						<i class="fas fa-times"></i>
					</a>
				</td>
			</tr>
		<?php } ?>										
		<?php 
	}
	public function reviews_count($product_id)
	{
		$count = 0;
		$star = 0;
		$result = $this->db->query("select id,star from tbl_review where product_id='$product_id' order by id asc")->result();
		foreach($result as $row){
			$count++;
			$star = $star + $row->star;
		}
		$x[0] = $count;
		$x[1] = number_format($star / $count,1);
		if($x[0]=="0")
		{
			$x[1] = "0";
		}
		if($x[0]=="0")
		{
			$x[2] = '<i class="fa fa-star-o theme-star"></i>
			<i class="fa fa-star-o theme-star"></i>
			<i class="fa fa-star-o theme-star"></i>
			<i class="fa fa-star-o theme-star"></i>
			<i class="fa fa-star-o theme-star"></i>';
		}
		else
		{
			if($x[1]>=0.0 && $x[1]<=0.9)
			{
				$x[2] = '				
				<i class="fa fa-star-half-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>';
			}
			if($x[1]>=0.9 && $x[1]<=1.0)
			{
				$x[2] = '				
				<i class="fa fa-star-half-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>';
			}
			if($x[1]>=1.1 && $x[1]<=1.9)
			{
				$x[2] = '				
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star-half-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>';
			}
			if($x[1]>=1.9 && $x[1]<=2.0)
			{
				$x[2] = '				
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>';
			}
			if($x[1]>=2.1 && $x[1]<=2.9)
			{
				$x[2] = '				
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star-half-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>';
			}
			if($x[1]>=2.9 && $x[1]<=3.0)
			{
				$x[2] = '				
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>';
			}
			if($x[1]>=3.1 && $x[1]<=3.9)
			{
				$x[2] = '				
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star-half-o theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>';
			}
			if($x[1]>=3.9 && $x[1]<=4.0)
			{
				$x[2] = '				
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star-o theme-star"></i>';
			}
			if($x[1]>=4.1 && $x[1]<=4.9)
			{
				$x[2] = '				
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star-half-o theme-star"></i>';
			}
			if($x[1]>=4.9 && $x[1]<=5.0)
			{
				$x[2] = '				
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>
				<i class="fa fa-star theme-star"></i>';
			}
		}
		
		$x[2] = "<span title='Rating ".$x[1]."'>".$x[2]."</span>";
		return $x;
	}
	public function show_review($product_id)
	{
		$result = $this->db->query("select * from tbl_review where product_id='$product_id' order by id asc")->result();
		foreach($result as $row){
		?>
		<li>
			<div class="comment">
				<div class="img-thumbnail d-block">
					<img class="avatar" alt="" src="<?= base_url(); ?>assets/website/default/img/avatars/avatar-2.jpg">
				</div>
				<div class="comment-block">
					<div class="comment-arrow"></div>
					<span class="comment-by">
						<strong>
							<?php echo $row->full_name; ?>
						</strong>
						<span>						
							<?php echo date("d M y",$row->time) ?>,
							<?php echo date("h:i a",$row->time) ?>
						</span>
						<span class="float-right">
							<i class="fa fa-star" <?php if($row->star>=1) { ?> style="color:blue" <?php } ?>></i>
							<i class="fa fa-star" <?php if($row->star>=2) { ?> style="color:blue" <?php } ?>></i>
							<i class="fa fa-star" <?php if($row->star>=3) { ?> style="color:blue" <?php } ?>></i>
							<i class="fa fa-star" <?php if($row->star>=4) { ?> style="color:blue" <?php } ?>></i>
							<i class="fa fa-star" <?php if($row->star>=5) { ?> style="color:blue" <?php } ?>></i>
							<span>(<?php echo $row->star; ?>)</span>
						</span>
					</span>
					<?php echo base64_decode($row->message); ?>
				</div>
			</div>
		</li>
		<div class="sin-rattings">
			<div class="star-author-all">
				<div class="ratting-star f-left">
					
				</div>

				<div class="ratting-author f-right">
					<h3></h3>
					
				</div>
			</div>
			<p></p>
		</div>
		<?php
		}
	}
	public function get_available($product_id,$variations1_id,$variations2_id)
	{
		$get_available = 0;
		$add_to_cart = $this->db->query("select * from add_to_cart where product_id='$product_id' and variations1_id='$variations1_id' and variations2_id='$variations2_id'")->result();
		foreach($add_to_cart as $row1)
		{
			$check_out_tbl = $this->db->query("select * from check_out_tbl where temp_id='$row1->temp_id'")->row();
		
			if($check_out_tbl->status!=0 && $check_out_tbl->status!=3){
				$get_available = $get_available + $row1->product_quantity;
			}
		}
		return $get_available;
	}
	
	public function get_combo_qty($id)
	{
		$query1 = $this->db->query("select * from tbl_variations1_variations2_join where id='$id'")->row();		
		
		$product_id = $query1->product_id;		
		$query = $this->db->query("select * from tbl_product where id='$product_id'")->row();
		if($query->product_type=="3")
		{
			$combo_product = $query->combo_product;
			$combo_product2 = explode(",",$combo_product);
			$xy = 0;
			foreach($combo_product2 as $pid)
			{
				// yha wo ha jo bik gaya ha
				$query1n = $this->db->query("select * from tbl_variations1_variations2_join where id='$pid'")->row();
				$get_available1 = $this->Scheme_Model->get_available($product_id,$query1n->variations1,$query1n->variations2);
				
				$get_available2[$xy] = $query1n->quantity - $get_available1;
				$xy++;
			}
			sort($get_available2);
		}
		return $get_available2[0];
	}
	
	public function count_total_pruct_in_mainpg($category_id)
	{
		$count = 0;
		$query = $this->db->query("select id from tbl_product_category where category_id='$category_id'")->result();
		foreach($query as $row)
		{
			$count++;
		}
		return $count;
	}
	
	
	public function download_gst_report($from,$to)
	{
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		error_reporting(0);
		ob_clean();
		
		date_default_timezone_set('Asia/Calcutta');
		$from1 = date("d-M-Y",strtotime($from));
		$to1 = date("d-M-Y",strtotime($to));

		$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A1','order id')
		->setCellValue('B1','first name')
		->setCellValue('C1','last name')
		->setCellValue('D1','company')
		->setCellValue('E1','adress')
		->setCellValue('F1','mobile')
		->setCellValue('G1','email')
		->setCellValue('H1','gst')
		->setCellValue('I1','price')
		->setCellValue('J1','date');
		
		/*$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(24);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(24);
		
		
		$sheet = $objPHPExcel->getActiveSheet();		
		$BStyle = array(
		  'borders' => array(
			'allborders' => array(
			  'style' => PHPExcel_Style_Border::BORDER_THIN
			)
		  )
		);
		$objPHPExcel->getActiveSheet()->getStyle('A1:J6')->applyFromArray($BStyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('A6:J6')->applyFromArray(array('font' => array('size' => 10,'bold' => TRUE,'name'  => 'Calibri')));	
		
		//$query = $this->db->query("select * from check_out_tbl where date >= '$from' and date <= '$to' order by acno desc")->result();*/
		/*$query = $this->db->query("select * from check_out_tbl")->result();
		$rowCount = 1;
		$total = 0;
		foreach($query as $value)
		{
			/*$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->applyFromArray($BStyle);
			
			$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => false,'color' => array('rgb' => '000000'),'name'  => 'Calibri')));*/
			
			/*$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,$value->order_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount,$value->order_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount,$value->order_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount,$value->order_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount,$value->order_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount,$value->order_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount,$value->order_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount,number_format($value->gst,2));
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount,$value->order_id);
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount,date("d/m/Y",strtotime($value->date)));
			
			$total = $total + $value->grand_total;
			$rowCount++;*/
		//}
		
		/*$objPHPExcel->getActiveSheet()
        ->getStyle('A'.$rowCount.':N'.$rowCount)
        ->getFill()
        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
        ->getStartColor()
        ->setRGB('FFFF00');
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':N'.$rowCount)->applyFromArray($BStyle);
		
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':N'.$rowCount)->applyFromArray(array('font' => array('size' => 9,'bold' => true,'color' => array('rgb' => '000000'),'name'  => 'Calibri')));
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount,"Total");
		$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount,round($total,2));
		$rowCount++;
		$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':J'.$rowCount)->applyFromArray($BStyle);
		*/
		
		if($mytype=="")
		{
			$file_name = "report.xls";
			
			$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
			//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel5');
			/*$objWriter->save('uploads_sales/kapilkifile.xls');*/
			
			header('Content-type: application/vnd.ms-excel');
			header('Content-Disposition: attachment; filename='.$file_name);
			header('Cache-Control: max-age=0');
			ob_start();
			$objWriter->save('php://output');
			$data = ob_get_contents();
		}
	}
	public function imagechangetob64image($url)
	{
		$b64image = base64_encode(file_get_contents($url));
		return $b64image;
	}
	
	public function encryptIt($q) {
		$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		$qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
		return( $qEncoded );
	}

	public function decryptIt($q) {
		$cryptKey  = 'qJB0rGtIn5UB1xG03efyCp';
		$qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
		return($qDecoded );
	}
	
	public function get_join_tbl_date($category_id,$page_type) {
		$row = $this->db->query("select * from tbl_join_category where category_id='$category_id' and page_type='$page_type'")->row();
		return $row->display;
	}
	
	public function update_join_tbl_date($category_id,$page_type,$display) {
		if($display=="")
		{
			$display = 0;
		}
		$row = $this->db->query("select * from tbl_join_category where category_id='$category_id' and page_type='$page_type'")->row();
		if($row->id=="")
		{
			$this->db->query("insert into tbl_category set display='$display',category_id='$category_id',page_type='$page_type'");
		}
		else
		{			
			$this->db->query("update tbl_join_category set display='$display' where category_id='$category_id' and page_type='$page_type'");
		}
	}
	
	public function update_random_play() {
		$this->db->query("update tbl_category set random_play=0");
	}
	
	public function get_anywhere_live($category_id) {
		if($status=="")
		{
			$status = 0;
		}
		$row = $this->db->query("select * from tbl_anywhere_live where category_id='$category_id'")->row();
		if($row->id!=""){
			$status = "1";
		}
		return $status;
	}
	
	public function update_anywhere_live($category_id) {
		$this->db->query("update tbl_anywhere_live set category_id='$category_id',status='0'");
	}
	
	public function check_anywhere_live($id) {
		$row = $this->db->query("select * from tbl_anywhere_live where category_id='$id'")->row();
		return $row->status;
	}
}  