<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','512M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv
class Drd_master_Model extends CI_Model  
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
	
	public function insert_delivery(){
		
		$date = date("Y-m-d");
		$time = date("h:i a");
		$current_time = date("H:i:s");
		$time = date("h:i a", strtotime($current_time . ' - 1 minute'));
		$where = "sl.vdt='$date' and sl.DispatchTime='$time'";
		
		$result1 = $this->mssql->query("select sl.TagNo from salepurchase1extra as sl,salepurchase1 as s2,acm as a where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and $where order by sl.Vdt desc,sl.DispatchTime desc")->result();
		foreach($result1 as $row1)
		{
			$result = $this->mssql->query("select sl.DispatchTime ,sl.TagNo,s2.mtime,sl.vdt,sl.vno,pickedby,checkedby,deliverby,vtype,s2.gstvno,a.altercode,a.name,a.mobile,s2.acno,s2.amt from salepurchase1extra as sl,salepurchase1 as s2,acm as a where a.code = s2.acno and sl.vdt = s2.vdt and sl.vno = s2.vno and (sl.vtype='sb' or sl.vtype='sr') and sl.TagNo='$row1->TagNo' order by sl.Vdt desc,sl.DispatchTime desc")->result();
			foreach($result as $row)
			{
				$dispatchtime = $row->DispatchTime;
				$tagno = $row->TagNo;
				$mtime = $row->mtime;
				$vdt = $row->vdt;
				$vno = $row->vno;
				$pickedby = $row->pickedby;
				$checkedby = $row->checkedby;
				$deliverby = $row->deliverby;
				$vtype = $row->vtype;
				$gstvno = $row->gstvno;
				$chemist_code = $row->altercode;
				$chemist_name = $row->name;
				$chemist_mobile = $row->mobile;
				$chemist_id = $row->acno;
				$amount = $row->amt;
				$user_altercode = $row->deliverby; //deliverby_altercode ko manay int diya hua ha to sirf yha user ka code add karay ga like 608
				
				$row1 = $this->db->query("select id from drd_master_tbl_delivery where vdt='$vdt' and vno='$vno'")->row();
				if(empty($row1)) {
					$items = $this->insert_delivery_add_items($vno,$vdt);
					
					$insert_query = "insert into drd_master_tbl_delivery (dispatchtime,tagno,mtime,vdt,vno,pickedby,checkedby,deliverby,vtype,gstvno,chemist_code,chemist_name,chemist_mobile,chemist_id,amount,user_altercode,items) values ('$dispatchtime','$tagno','$mtime','$vdt','$vno','$pickedby','$checkedby','$deliverby','$vtype','$gstvno','$chemist_code','$chemist_name','$chemist_mobile','$chemist_id','$amount','$user_altercode','$items')";
					
					$this->db->query($insert_query);
				}
			}
		}
	}
	
	public function insert_delivery_add_items($vno,$vdt){
		
		//echo "select item.code from Salepurchase2,item where Salepurchase2.vno='$vno' and Salepurchase2.vdt='$vdt' and Salepurchase2.Itemc = item.code and item.status='@A'";
		
		$itemc = "";
		$result = $this->mssql->query("select item.code from Salepurchase2,item where Salepurchase2.vno='$vno' and Salepurchase2.vdt='$vdt' and Salepurchase2.Itemc = item.code and (item.status='@A' or item.status='#NRX')")->result();
		foreach($result as $row) {
			$itemc.=$row->code.",";
		}
		if($itemc!=""){
			$itemc = rtrim($itemc, ',');
		}
		return $itemc;
	}
	
	public function upload_delivery_order(){
		
		echo "ok";
		if(empty($items)){
			$this->db->limit(100);
			$this->db->where('upload_status','0');
			$query = $this->db->get("drd_master_tbl_delivery")->result();
			foreach($query as $row)
			{
				$id				= $row->id;
				$dispatchtime 	= $row->dispatchtime;
				$tagno 			= $row->tagno;
				$mtime 			= $row->mtime;
				$vdt 			= $row->vdt;
				$vno 			= $row->vno;
				$pickedby 		= $row->pickedby;
				$checkedby 		= $row->checkedby;
				$deliverby 		= $row->deliverby;
				$vtype 			= $row->vtype;
				$gstvno 		= $row->gstvno;
				$chemist_code 	= $row->chemist_code;
				$chemist_name 	= $row->chemist_name;
				$chemist_mobile = $row->chemist_mobile;
				$chemist_id 	= $row->chemist_id;
				$amount 		= $row->amount;
				$user_altercode	= $row->user_altercode;
				$items_v 		= $row->items;
				
				$items.='{"id":"'.$id.'","dispatchtime": "'.$dispatchtime.'","tagno": "'.$tagno.'","mtime": "'.$mtime.'","vdt": "'.$vdt.'","vno": "'.$vno.'","pickedby": "'.$pickedby.'","checkedby": "'.$checkedby.'","deliverby": "'.$deliverby.'","vtype": "'.$vtype.'","gstvno": "'.$gstvno.'","chemist_code": "'.$chemist_code.'","chemist_name": "'.$chemist_name.'","chemist_mobile": "'.$chemist_mobile.'","chemist_id": "'.$chemist_id.'","amount": "'.$amount.'","user_altercode": "'.$user_altercode.'","items": "'.$items_v.'"},';
				$qry.= "update drd_master_tbl_delivery set upload_status='1' where id='$id';";
			}
		}
		if(!empty($items)){

			if ($items != '') {
				$items = substr($items, 0, -1);
			}

			$parmiter = '{"items": ['.$items.']}';

			$curl = curl_init();

			curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://drdweb.co.in/exe01/exe_drd_master/upload_delivery_order',
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
				echo $qry;
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