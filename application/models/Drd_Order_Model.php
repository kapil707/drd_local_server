<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('memory_limit','512M'); // This also needs to be increased in some cases. Can be changed to a higher value as per need)
ini_set('sqlsrv.ClientBufferMaxKBSize','524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size','524288'); // Setting to 512M - for pdo_sqlsrv
class Drd_Order_Model extends CI_Model  
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
	
    function get_PorderCount_ordno()
    {
        $row = $this->mssql->query("select top 1 ordno from PorderCount order by OrdNo desc")->row();
        return $row->ordno + 1;
    }

    function get_order_PorderCount($uid)
    {
        $row = $this->mssql->query("select top 1 ordno from PorderCount where uid='$uid'")->row();
        return $row->ordno;
    }
	
	function get_order_Porder($uid)
    {
        $row = $this->mssql->query("select top 1 ordno from Porder where uid='$uid'")->row();
        return $row->ordno;
    }
	
	function get_order_acm($altercode)
    {
        $row = $this->mssql->query("select code,slcd from Acm where altercode='$altercode'")->row();
		$x["acno"] = $row->code;
		$x["slcd"] = $row->slcd;
        return $x;
    }

	function insert_order_PorderCount($order_no,$uid,$odt,$acno,$ordtype,$mtime,$downloaddate,$dayenddate,$remarks)
	{
        $sql = "insert into PorderCount (ordno,uid,odt,acno,ordtype,mtime,downloaddate,dayenddate,tag,remarks) values ('$order_no','$uid','$odt','$acno','$ordtype','$mtime','$downloaddate','$dayenddate','N','$remarks')";
        $result = $this->mssql->query($sql);
	}

    function insert_order_Porder($slcd,$acno,$odt,$itemc,$qty,$ordno,$uid,$mtime,$mrp, $remarks)
	{
        $sql = "insert into Porder (slcd,acno,odt,itemc,qty,ordno,Uid,mtime,mrp,tag,remarks) values ('$slcd','$acno','$odt','$itemc','$qty','$ordno','$uid','$mtime','$mrp','N','$remarks')";
        $result = $this->mssql->query($sql);
	}

    function insert_shortage($vdt,$acno,$slcd,$itemc,$uid)
	{
        $sql = "INSERT INTO Shortage (vdt,acno,slcd,itemc,Uid) VALUES ('$vdt','$acno','$slcd','$itemc','$uid')";
		$result = $this->mssql->query($sql);
	}

    function get_gstvno_in_pordercount($ordno)
	{
        $sql = "select tag,purvtype,purvno,purvdt from pordercount where OrdType='DRD' and (Tag='Y' or Tag='D') and ordno='$ordno'";
		$result = $this->mssql->query($sql)->result();
        return $result;
	}

    function get_gstvno_in_salepurchase($ordno_new, $purvtype,$purvno,$purvdt)
	{
        $sql = "select gstvno from Salepurchase1 where Vtyp='$purvtype' and vno='$purvno' and vdt='$purvdt'";
		$result = $this->mssql->query($sql)->result();
		return $result;
	}
	
	function get_thisid_for_upload($checktype)
	{
		$sql = "select thisid from tbl_id where checktype='$checktype' order by id desc limit 1";
		$row = $this->db->query($sql)->row();
		return $row->thisid;
	}
	
	public function get_medicine($topi)
	{
		//$topi 	= "1";//$this->get_thisid_for_upload("medicine_copy");
		$mycode = $this->get_thisid_for_upload("update_medicine_test");
		
		$sql = "select top ".$topi." i.code,I.BArcode AS item_code,I.Name as item_name,i.pack as packing,(SELECT TOP 1 fi.Expiry FROM fifo as fi WHERE fi.Itemc = i.code  and BQty!=0 order by BQty asc) as Expiry,(SELECT TOP 1 fi.Batch FROM fifo as fi WHERE fi.Itemc = i.code  and BQty!=0 order by BQty asc) as Batch,i.Clqty as batchqty,(SELECT TOP 1 fi.scm1 FROM fifo as fi WHERE fi.Itemc = i.code  and BQty!=0 order by BQty asc) as salescm1,(SELECT TOP 1 fi.scm2 FROM fifo as fi WHERE fi.Itemc = i.code  and BQty!=0 order by BQty asc) as salescm2,(SELECT TOP 1 fi.Srate FROM fifo as fi WHERE fi.Itemc = i.code  and BQty!=0 order by BQty asc) as sale_rate,(SELECT TOP 1 fi.mrp FROM fifo as fi WHERE fi.Itemc = i.code and BQty!=0 order by BQty asc) as mrp,(SELECT TOP 1 fi.Prate FROM fifo as fi WHERE fi.Itemc = i.code  and BQty!=0 order by BQty asc) as Costrate,i.compcode,cmp.altercode as company_alter,i.Compname as company_name,cmp.name as company_full_name,I.DIVISION AS division,i.QScm,i.Hscm,i.MiscSettings as MiscSettings,i.Vdt,i.ItemCat,i.IGST,i.NoteBook,i.TrimName from Item as i LEFT JOIN Company as cmp ON cmp.code = i.compcode where i.code>'$mycode' order by i.code asc";
		$result = $this->mssql->query($sql)->result();
		return $result;
	}
	
	public function get_chemist($topi)
	{
		//$topi 	= "1";//$this->get_thisid_for_upload("medicine_copy");
		$mycode = $this->get_thisid_for_upload("update_chemist_test");
		
		$sql = "select top ".$topi." code,altercode,groupcode,name,type,trimname,address,address1,address2,address3,telephone,telephone1,mobile,email,gstno,status,statecode,invexport,slcd from acm where code>'$mycode' order by code asc";
		
		$result = $this->mssql->query($sql)->result();
		return $result;
	}
}  