<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','512M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv
class Corporate_Model extends CI_Model  
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
	
	function mssql_query_call_row($qry){
		return $this->mssql->query($qry)->row();
	}
	
	public function item_wise_report($division='',$compcode='',$from='',$to='')
	{
		$where =  " and itm.division='$division' ";
		if($division=='00')
		{
		  $where =  " and itm.Compcode='$compcode' ";
		}
		$query = $this->mssql->query("select sl.vtype,sl.vdt,sl.itemc,sl.qty,sl.fqty,sl.netamt,itm.name,itm.pack,cmp.name as company_full_name,acm.altercode,acm.name as c_name,acm.address,acm.mobile,itm.Clqty as batchqty from salepurchase2 as sl,acm,item as itm left join company as cmp on cmp.code = itm.compcode where sl.vdt>='$from' and sl.vdt<='$to' and (sl.vtype='sb' or sl.vtype='sr') and sl.itemc = itm.code and acm.code = sl.acno $where order by itm.name asc,acm.name asc")->result();
		return $query;
		/*$this->db->select('tbl_invoice_item.item_code,tbl_invoice_item.netamt,tbl_invoice.chemist_id,tbl_invoice.address,tbl_invoice.name,tbl_invoice.mobile,tbl_invoice_item.itemc,tbl_invoice_item.item_name,tbl_invoice_item.packing,tbl_invoice_item.vdt,tbl_invoice_item.qty,tbl_invoice_item.fqty');
		$this->db->from('tbl_invoice');
		$this->db->join('tbl_invoice_item','tbl_invoice.vno=tbl_invoice_item.vno');
		$this->db->where('tbl_invoice_item.division',$division);
		$this->db->where('tbl_invoice_item.compcode',$compcode);
		$this->db->where('tbl_invoice_item.vdt>=',$from);
		$this->db->where('tbl_invoice_item.vdt<=',$to);
		$this->db->order_by('tbl_invoice_item.item_name','asc');
		$query = $this->db->get();
		return $query->result();*/
	}
	
	public function chemist_wise_report($division='',$compcode='',$from='',$to='')
	{
		$where =  " and itm.division='$division' ";
		if($division=='00')
		{
		  $where =  " and itm.Compcode='$compcode' ";
		}
		$query = $this->mssql->query("select itm.division,sl.vtype,sl.vdt,sl.itemc,sl.qty,sl.fqty,sl.netamt,itm.name,itm.pack,cmp.name as company_full_name,acm.altercode,acm.name as c_name,acm.address,acm.mobile,itm.Clqty as batchqty from salepurchase2 as sl,acm,item as itm left join company as cmp on cmp.code = itm.compcode where sl.vdt>='$from' and sl.vdt<='$to' and (sl.vtype='sb' or sl.vtype='sr') and sl.itemc = itm.code and acm.code = sl.acno $where order by acm.name asc")->result();
		return $query;
		/*$this->db->select('tbl_invoice.acno,tbl_invoice_item.item_name,tbl_invoice_item.item_code,tbl_invoice_item.itemc,tbl_invoice_item.packing,tbl_invoice_item.qty,tbl_invoice_item.fqty,tbl_invoice_item.netamt,tbl_invoice_item.vdt,tbl_invoice.name,tbl_invoice.chemist_id,tbl_invoice.address,tbl_invoice.mobile');
		$this->db->from('tbl_invoice_item');
		$this->db->join('tbl_invoice','tbl_invoice.vno=tbl_invoice_item.vno');
		$this->db->where('tbl_invoice_item.division',$division);
		$this->db->where('tbl_invoice_item.compcode',$compcode);
		$this->db->where('tbl_invoice_item.vdt>=',$from);
		$this->db->where('tbl_invoice_item.vdt<=',$to);
		$this->db->order_by('acno','asc');
		$query=$this->db->get();
		return $query->result();*/
	}
	
	public function stock_and_sales_analysis($division='',$compcode='',$from='',$to=''){
		//use $this->mssql instead of $this->db
		$where =  " and item.division='$division' ";
		if($division=='00')
		{
		  $where =  " and item.Compcode='$compcode' ";
		}
		$query = $this->mssql->query("select item.division,Item.clqty,Item.opqty,costwfq,code,barcode,name,pack,status,Item.prate,Item.srate,item.costrate,ItemExtra.TempOpqty,ItemExtra.TempClqty,ItemExtra.TempAmt1,(SELECT sum(Qty) FROM StockMST where itemc=item.code and vdt>='$from' and vdt<='$to') as open_b,(SELECT sum(Qty) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='pb' and vdt>='$from' and vdt<='$to') as purchase,(SELECT sum(netamt) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='pb' and vdt>='$from' and vdt<='$to') as purchase1,(SELECT sum(Qty) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='PR' and vdt>='$from' and vdt<='$to') as purchase_return,(SELECT sum(Qty) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='sb' and vdt>='$from' and vdt<='$to') as sale,(SELECT sum(netamt) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='sb' and vdt>='$from' and vdt<='$to') as sale1,(SELECT sum(Qty) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='sr' and vdt>='$from' and vdt<='$to') as sale_return,(SELECT sum(netamt) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='sr' and vdt>='$from' and vdt<='$to') as sale_return1,(SELECT sum(Qty) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='sa' and vdt>='$from' and vdt<='$to') as other1,(SELECT sum(netamt) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='sa' and vdt>='$from' and vdt<='$to') as other1_1,(SELECT sum(Qty) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='ge' and vdt>='$from' and vdt<='$to') as other2,(SELECT sum(netamt) FROM Salepurchase2 WHERE Itemc = item.code and Vtype='ge' and vdt>='$from' and vdt<='$to') as other2_1 from item INNER JOIN ItemExtra ON ItemExtra.itemc = item.code where item.status!='*' $where order by item.division asc,item.name asc")->result();
	   return $query;
    }
	
	public function corporate_current_stack_report($compcode,$division)
	{
		$where =  " and item.division='$division' ";
		if($division=='00')
		{
		  $where =  " and item.Compcode='$compcode' ";
		}
		$query = $this->mssql->query("select item.code,item.name,item.clqty from item inner join itemextra on itemextra.itemc = item.code where item.status!='*' $where")->result();
		return $query;
	}
	
	
	public function corporate_sales_report($compcode,$division,$vdt)
	{
		$where =  " and item.division='$division' ";
		if($division=='00')
		{
		  $where =  " and item.compcode='$compcode' ";
		}
		$query = $this->mssql->query("select item.clqty,item.name,acm.name as a_name,acm.altercode,acm.mobile,acm.address,salepurchase2.qty,(select sum(qty) from salepurchase2 where itemc = item.code and vtype='sb' and vdt='$vdt') as total_sales from acm,item inner join itemextra on itemextra.itemc = item.code inner join salepurchase2 on salepurchase2.itemc = item.code where salepurchase2.vdt='$vdt' and acm.code = salepurchase2.acno and salepurchase2.vtype='sb' $where order by item.code ")->result();
		return $query;
	}
}  