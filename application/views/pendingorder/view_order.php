<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
		Dr. Distributor || Pending orders
    </title>
    <meta charset utf="8">
	<meta name="theme-color" content="#f7625b">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	

	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
	
	<style>
		body{
			font-size:13px;
		}
	</style>
</head>

	<body>
		<div class="container-fluid">
			<div class='row'>
				<div class='col-xs-2 col-md-2'>
					<button type="button" class="btn btn-success btn-block site_main_btn31" data-toggle="modal" data-target="#myModal_shortage">
						Add Shortage
					</button>
				</div>
				<div class='col-xs-2 col-md-2'>
					<button type="button" class="btn btn-primary btn-block site_main_btn31" data-toggle="modal" data-target="#myModal_pending_order">
						Add Pending Order
					</button>
				</div>
				<div class='col-xs-2 col-md-2'>
					<form method="post" onsubmit="return confirm('Are you sure to synchronization medicines?');">
						<button type="submit" name="synchronization_fun_submit" class="btn btn-warning btn-block site_main_btn31">Synchronization</button>
					</form>
				</div>
				
				<div class='col-xs-2 col-md-2'>
					<button type="submit" name="synchronization_fun_submit" class="btn btn-danger btn-block site_main_btn31" onclick="delete_stock_items()">Delete Stock Items</button>
				</div>
				
				<?php
				$row1 = $this->db->query("select id from tbl_pending_order where status=1")->row();
				if($row1->id==""){
				?>
				<div class='col-xs-2 col-md-2'>
					<form method="post" onsubmit="return confirm('Are you sure to start email?');">
						<button type="submit" name="start_email_fun_submit" class="btn btn-info btn-block site_main_btn31">Start Email</button>
					</form>
				</div>
				<?php } else { ?>
				<div class='col-xs-2 col-md-2'>
					<form method="post" onsubmit="return confirm('Are you sure to stop email?');">
						<button type="submit" name="stop_email_fun_submit" class="btn btn-danger btn-block site_main_btn31">Stop Email</button>
					</form>
				</div>
				<?php } ?>
				<div class='col-xs-2 col-md-2'>
					<form method="post" onsubmit="return confirm('Are you sure to delete all medicines?');">
						<button type="submit" name="delete_all_fun_submit" class="btn btn-danger btn-block site_main_btn31">Delete All</button>
					</form>
				</div>
			</div>
			<br>
			<br>
			<form method="post" onsubmit="return confirm('Are you sure to delete by company / supplier?');">
				<div class='row'>
					<div class='col-xs-2 col-md-2'>
						<label>Delete by company / Supplier</label>
					</div>
					<div class='col-xs-2 col-md-2'>
						<select name="dropdown_id" id="status" data-placeholder="Select Status" class="chosen-select form-control">
							<?php 
							$result = $this->db->query("SELECT DISTINCT `compcode`,`uname` FROM `tbl_pending_order` order by uname asc")->result();
							foreach($result as $row) { ?>
							<option value="<?php echo $row->compcode ?>">
								<?php echo $row->uname ?>
							</option>
							<?php } ?>
						</select>
					</div>	
					<div class='col-xs-2 col-md-2'>
						<button type="submit" name="deleteAll_dropdown" class="btn btn-danger btn-block site_main_btn31">Delete All</button>
					</div>
				</div>
			</form>
			<br>
		<form method="post">
		<table id="example" class="display table table-striped table-bordered" aria-describedby>
			<thead>
				<tr>
					<th style="width:30px;" scope>
						S.No.
					</th>
					<th style="width:50px;" scope>
						Type
					</th>
					<th style="width:50px;" scope>
						Ord.No.
					</th>
					<th style="width:50px;" scope>
						Code
					</th>
					<th scope>
						Name
					</th>
					<th style="width:30px;" scope>
						Mrp
					</th>
					<th style="width:30px;" scope>
						Qty
					</th>
					<th style="width:50px;" scope>
						Total
					</th>
					<th style="" scope>
						Date
					</th>
					<th scope>
						User Id
					</th>
					<th scope>
						Supplier
					</th>
					<th scope>
						Delete
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				//$result = $this->Drd_Pendingorder_Model->view_order_query();
				$result = $this->db->query("select distinct barcode,max(qty) as qty,type,ordno,name,vdt,uid,uname,id,mrp,clqty from tbl_pending_order GROUP BY barcode HAVING COUNT(barcode) > 1 order by acno")->result();
				/*$result = $this->db->query("select barcode,qty,type,ordno,name,vdt,uid,uname,id,mrp,clqty from tbl_pending_order order by acno")->result();*/
				foreach($result as $row)
				{ 
					?>
					<tr class="row_<?= $row->id?>">
						<td>
							<?= $i++ ?>
						</td>
						<td>
							<?= $row->type?>
						</td>
						<td>
							<?= $row->ordno?>
						</td>
						<td>
							<?= $row->barcode?>
						</td>
						<td>
							<?= $row->name?>
							<br>
							<?php
							//$row1 = $this->Drd_Pendingorder_Model->mssql_query_call_row("select name,clqty from item where barcode='$row->barcode'");
							if(round($row->clqty)==0){
								?>
								<span style="color:red">
								<?php
							}
							else{
								?>
								<span style="color:green">
								<?php
							}
							?>
							(Stock :  <?= round($row->clqty); ?>)
							</span>
						</td>
						<td>
							<?= $row->mrp?>
						</td>
						<td>
							<div style="display:none"><?= $row->qty?></div>
							<input type="number" min="10" max="2000" class="qty_update_<?= $row->id?>" value="<?= $row->qty?>" onChange="qty_update(<?= $row->id?>)">
						</td>
						<td>
							<?= $row->mrp * $row->qty?>
						</td>
						<td>
							<?= $row->vdt?>
						</td>
						<td>
							<?= $row->uid?>
						</td>
						<td>
							<?= $row->uname?>
						</td>
						<td width="200px;">
							<div style="float:left;margin-right:10px;">
								<input type="checkbox" style="width:25px;height:25px;" value="<?= $row->id?>" name="delete_by_checkbox[]">
							</div>
							<a href="#" class="btn btn-danger" onClick="delete_row(<?= $row->id?>)">Delete</a>
						</td>
					</tr>
				<?php
					$total_mrp = $total_mrp + $row->mrp;
					$total_qty = $total_qty + $row->qty;
					$total_value = $total_value + ($row->mrp * $row->qty);
				}
				?>
				
			</tbody>
			<tfoot>
				<tr>
					<td>Total</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td><?= $total_mrp;?></td>
					<td><?= $total_qty;?></td>
					<td><?= $total_value;?></td>
					<td></td>
					<td></td>
					<td></td>
					<td><input type="submit" name="deleteAll_bycheckbox" value="Delete All" class="btn btn-danger"></td>
				</tr>
			</tfoot>
		</table>
		</form>
	</body>
</html>
<Script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"pageLength": 25,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
</Script>
<!-- The Modal -->
<div class="modal" id="myModal_shortage">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Shortage</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
			<form method="post">
			<div class='row'>
				<div class='col-xs-6 col-md-4'>
					<div class="form-group">
						<label>Select date from</label>
						<div class='input-group date' id='datetimepicker1' style="width: 100%">
							<input type='text' class="form-control formdate" id="from" name="start_date" value="" placeholder="Select date from" data-date-format="DD-MMM-YYYY" required>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>

				<div class='col-xs-6 col-md-4'>
					<div class="form-group">
						<label>Select date to</label>
						<div class='input-group date' id='datetimepicker2' style="width: 100%">
							<input type='text' class="form-control todate" id="to" name="end_date" value="" placeholder="Select date to" data-date-format="DD-MMM-YYYY" required>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
				<div class='col-xs-6 col-md-4'>
					<div class="form-group">
						<label>&nbsp;</label>
						<button type="submit" name="add_shortage_submit" class="btn btn-primary btn-block site_main_btn31">Add Shortage</button>
					</div>
				</div>
			</div>
		</form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="myModal_pending_order">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Pending Order</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
			<form method="post">
			<div class='row'>
				<div class='col-xs-12 col-md-12'>
					<div class="form-group">
						<label>Add Order No.</label>
						<input type="text" class="form-control" id="form-field-1" placeholder="Add Order No." name="order_no" value="" required="required" />
					</div>
				</div>
			</div>
			<div class='row'>
				<div class='col-xs-6 col-md-4'>
					<div class="form-group">
						<label>Select date from</label>
						<div class='input-group date' id='datetimepicker1' style="width: 100%">
							<input type='text' class="form-control formdate" id="from1" name="start_date" value="" placeholder="Select date from" data-date-format="DD-MMM-YYYY" required>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>

				<div class='col-xs-6 col-md-4'>
					<div class="form-group">
						<label>Select date to</label>
						<div class='input-group date' id='datetimepicker2' style="width: 100%">
							<input type='text' class="form-control todate" id="to1" name="end_date" value="" placeholder="Select date to" data-date-format="DD-MMM-YYYY" required>
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
				<div class='col-xs-6 col-md-4'>
					<div class="form-group">
						<label>&nbsp;</label>
						<button type="submit" name="add_pending_order_submit" class="btn btn-primary btn-block site_main_btn31">Add Order</button>
					</div>
				</div>
			</div>
		</form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<script>
$('#from').datetimepicker({format: 'DD-MMM-YYYY'});
$('#to').datetimepicker({format: 'DD-MMM-YYYY'});
$('#month').datetimepicker({format: 'MMM'});

$('#from1').datetimepicker({format: 'DD-MMM-YYYY'});
$('#to1').datetimepicker({format: 'DD-MMM-YYYY'});
$('#month1').datetimepicker({format: 'MMM'});
</script>
<script>
function qty_update(id)
{
	var qty = $(".qty_update_"+id).val();
	$.ajax({
		type       : "POST",
		data       :  {qty:qty,id:id} ,
		url        : "<?php echo constant('api_url2'); ?>drd_pendingorder/qty_update",
		cache	   : false,
		error: function(){
			alert('Error');
		},
		success    : function(data){
			alert('Updated Successfully');
		}
	});
}
function delete_row(id)
{
	var result = window.confirm('Are you sure?');
	if (result == true) {
		$.ajax({
			type       : "POST",
			data       :  {id:id} ,
			url        : "<?php echo constant('api_url2'); ?>drd_pendingorder/delete_row",
			cache	   : false,
			error: function(){
				alert('Error');
			},
			success    : function(data){
				$(".row_"+id).hide();
				alert('Deleted Successfully');
			}
		});
	}
}
function delete_stock_items()
{
	id = "";
	var result = window.confirm('Are you sure?');
	if (result == true) {
		location.href = "<?php echo constant('api_url2'); ?>drd_pendingorder/delete_stock_items"
		/*$.ajax({
			type       : "POST",
			data       :  {id:id} ,
			url        : "<?php echo constant('api_url2'); ?>drd_pendingorder/delete_stock_items",
			cache	   : false,
			error: function(){
				location.reload();
			},
			success    : function(data){
				//$(".row_"+id).hide();
				alert('Deleted Successfully');
				location.reload();
			}
		});*/
	}
}
</script>