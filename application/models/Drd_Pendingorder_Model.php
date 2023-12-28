<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','512M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv
class Drd_Pendingorder_Model extends CI_Model  
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

	function mssql_query_call_row($qry){
		return $this->mssql->query($qry)->row();
	}
	
    function get_some_mysql_rows(){
       //use  $this->db for default 
       $query = $this->db->query('select * from mysql_table');
       //...
    }
	
	public function view_order_query(){
		return $this->db->query("select distinct barcode,max(qty) as qty,type,ordno,name,vdt,uid,uname,id,mrp from tbl_pending_order group by barcode order by acno")->result();
	}
	
	public function copy_shortage_order($start_date='',$end_date=''){
		
		$result = $this->mssql->query("select shortage.uid,shortage.vdt,shortage.itemc,item.barcode,item.name,item.pack,item.mrp,item.division,item.compcode,cmp.name as company_full_name,(select top 1 acno from complist,acm where acm.code = (select top 1 acno from fifo where itemc=item.code order by vdt desc) and complist.acno = acm.code and email!='') as acno,(select top 1 name from acm where code = (select top 1 acno from complist,acm where acm.code = (select top 1 acno from fifo where itemc=item.code order by vdt desc) and complist.acno = acm.code and email!='')) as uname,(select top 1 email from acm where code = (select top 1 acno from complist,acm where acm.code = (select top 1 acno from fifo where itemc=item.code order by vdt desc) and complist.acno = acm.code and email!='')) as uemail,(select top 1 mobile from acm where code = (select top 1 acno from complist,acm where acm.code = (select top 1 acno from fifo where itemc=item.code order by vdt desc) and complist.acno = acm.code and email!='')) as umobile from shortage inner join item on item.code = shortage.itemc inner join company as cmp on cmp.code = item.compcode where shortage.vdt>='$start_date' and shortage.vdt<='$end_date'")->result();
		foreach($result as $row)
		{
			$uid = $row->uid;
			$vdt = $row->vdt;
			$itemc = $row->itemc;
			$barcode = $row->barcode;
			$name = trim($row->name);
			$pack = trim($row->pack);
			$mrp = $row->mrp;
			$division = $row->division;
			$compcode = $row->compcode;
			$company_full_name = trim($row->company_full_name);
			$acno = $row->acno;
			$uname = trim($row->uname);
			$uemail = $row->uemail;
			$umobile = $row->umobile;
			$qty = "10";
			
			$row1 = $this->mssql->query("select top 1 qty from SalePurchase2 where itemc='$itemc' and vtype='pb' order by vdt desc")->row();
			if($row1->qty!="")
			{
				$qty = $row1->qty;
			}
			$qty = round($qty);
			
			$clqty = 0;
			$row1 = $this->mssql->query("select clqty from item where barcode='$barcode'")->row();
			if($row1->clqty!="")
			{
				$clqty = $row1->clqty;
			}
			$clqty = round($clqty);
			
			$ordno = "0";
			$date = date("Y-m-d");
			$type = "Shortage";
			
			$insert_query = "insert into tbl_pending_order (uid,vdt,itemc,barcode,name,pack,mrp,division,compcode,company_full_name,acno,uname,uemail,umobile,qty,clqty,ordno,date,type) values ('$uid','$vdt','$itemc','$barcode','$name','$pack','$mrp','$division','$compcode','$company_full_name','$acno','$uname','$uemail','$umobile','$qty','$clqty','$ordno','$date','$type')";
			
			$this->db->query($insert_query);
			/*$row1 = $this->db->query("select id from tbl_pending_order where itemc='$itemc'")->row();
			if($row1->id=="")
			{
				
			}*/				
		}
	}
	
	public function copy_pending_order($order_no='',$start_date='',$end_date=''){
		
		$result = $this->mssql->query("select pordersl.uid,pordersl.odt,pordersl.itemc,item.barcode,item.name,item.pack,item.mrp,item.division,item.compcode,cmp.name as company_full_name,(select top 1 acno from complist,acm where acm.code = (select top 1 acno from fifo where itemc=item.code order by vdt desc) and complist.acno = acm.code and email!='') as acno,(select top 1 name from acm where code = (select top 1 acno from complist,acm where acm.code = (select top 1 acno from fifo where itemc=item.code order by vdt desc) and complist.acno = acm.code and email!='')) as uname,(select top 1 email from acm where code = (select top 1 acno from complist,acm where acm.code = (select top 1 acno from fifo where itemc=item.code order by vdt desc) and complist.acno = acm.code and email!='')) as uemail,(select top 1 mobile from acm where code = (select top 1 acno from complist,acm where acm.code = (select top 1 acno from fifo where itemc=item.code order by vdt desc) and complist.acno = acm.code and email!='')) as umobile,pordersl.qty,pordersl.ordno from pordersl inner join item on item.code = pordersl.itemc inner join company as cmp on cmp.code = item.compcode where pordersl.ordno='$order_no' and pordersl.odt>='$start_date' and pordersl.odt<='$end_date'")->result();
		foreach($result as $row)
		{
			$uid = $row->uid;
			$vdt = $row->odt;
			$itemc = $row->itemc;
			$barcode = $row->barcode;
			$name = trim($row->name);
			$pack = trim($row->pack);
			$mrp = $row->mrp;
			$division = $row->division;
			$compcode = $row->compcode;
			$company_full_name = trim($row->company_full_name);
			$acno = $row->acno;
			$uname = trim($row->uname);
			$uemail = $row->uemail;
			$umobile = $row->umobile;
			
			$row1 = $this->mssql->query("select top 1 qty from SalePurchase2 where itemc='$itemc' and vtype='pb' order by vdt desc")->row();
			if($row1->qty!="")
			{
				$row->qty = $row1->qty;
			}
			
			$qty = round($row->qty);
			$qty = round($qty / 10) * 10;
			if($qty==0)
			{
				$qty = "10";
			}
			$ordno = $row->ordno;
			$date = date("Y-m-d");
			$type = "Order";
			
			$insert_query = "insert into tbl_pending_order (uid,vdt,itemc,barcode,name,pack,mrp,division,compcode,company_full_name,acno,uname,uemail,umobile,qty,ordno,date,type) values ('$uid','$vdt','$itemc','$barcode','$name','$pack','$mrp','$division','$compcode','$company_full_name','$acno','$uname','$uemail','$umobile','$qty','$ordno','$date','$type')";
			
			$this->db->query($insert_query);
			
		}
	}

	
	public function synchronization_fun(){
		
		$result = $this->db->query("select * from tbl_pending_order")->result();
		foreach($result as $row)
		{
			$_id  = $row->id;
			$name = $row->name;
			if (substr($name,0,1)==".")
			{
				$insert_query = "delete from tbl_pending_order where id=$_id";
			
				$this->db->query($insert_query);
			}
			
			if ($row->uemail=="")
			{
				$insert_query = "delete from tbl_pending_order where id=$_id";
			
				$this->db->query($insert_query);
			}
		}
	}
	
	public function start_email_fun(){
		$this->db->query("update tbl_pending_order set status=1");
	}
	
	public function stop_email_fun(){
		$this->db->query("update tbl_pending_order set status=0");
	}
	
	public function delete_all_fun(){
		$this->db->query("truncate tbl_pending_order");
	}
	
	public function delete_stock_items()
	{		
		$val = "";
		$result = $this->db->query("SELECT barcode,itemc,COUNT(barcode) FROM tbl_pending_order GROUP BY barcode HAVING COUNT(barcode) > 1")->result();
		foreach($result as $row)
		{
			$row1 = $this->mssql->query("select clqty from item where barcode='$row->barcode' and clqty!='0'")->row();
			if(round($row1->clqty)!=0){
				$val.=" itemc='$row->itemc' or";
			}
		}
		if($val!="")
		{
			$val = substr($val, 0, -2);
			$this->db->query("delete from tbl_pending_order where $val");			
		}
	}
}  