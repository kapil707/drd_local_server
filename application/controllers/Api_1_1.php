<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_1_1 extends CI_Controller {
	public function livetv()
	{ 
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$items = "";
		$Search_text = $_POST["Search_text"];
		if($Search_text=="")
		{
			$query1 = $this->db->query("select * from tbl_livetv_new order by name asc")->result();
		}
		else
		{
			$query1 = $this->db->query("select * from tbl_livetv_new where name like '$Search_text%'")->result();
		}
		foreach ($query1 as $row1)
		{
			$name= $row1->name;
			//$image= base_url()."uploads/manage_livetv/photo/resize/".$row1->image;
			$image= $row1->image;
			$description= $row1->description;
			$url=  ("tukutahakuta".base64_encode("tukaminahakamin".$row1->url."tukaminahakamin"));
			$id= $row1->id;
			$mytype = "livetv";
$items .= <<<EOD
{"id":"{$id}","name":"{$name}","image":"{$image}","description":"{$description}","url":"{$url}","mytype":"{$mytype}"},
EOD;
		}
if ($items != '') {
$items = substr($items, 0, -1);
}header('Content-type: application/json');
$x = "terimaki[$items]terimaki";
echo "teribhanki".base64_encode($x)."teribhanki";
	}
	
	public function marquee()
	{ 
		header("Content-type: application/json; charset=utf-8");
		error_reporting(0);
		$query1 = $this->db->query("select * from tbl_marquee where page_type='Marquee1'")->row();
		if($query1->id!=""){
			$marqee_text = base64_decode($query1->marqee_text);
$items .= <<<EOD
{"marqee_text":"{$marqee_text}"},
EOD;
		}
if ($items != '') {
	$items = substr($items, 0, -1);
}
?>
{"items":[<?= $items;?>]}
<?php
	}
}