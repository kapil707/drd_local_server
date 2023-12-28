<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
		Dr. Distributor || Invoices
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
		<form method="get">
			<div class='row'>
				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<label>Select date from</label>
						<div class='input-group date' id='datetimepicker1' style="width: 100%">
							<input type='text' class="form-control formdate" id="from" name="from" placeholder="Select date from" data-date-format="DD-MMM-YYYY" value="<?= $_GET["from"]; ?>" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>

				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<label>Select date to</label>
						<div class='input-group date' id='datetimepicker2' style="width: 100%">
							<input type='text' class="form-control todate" id="to" name="to" placeholder="Select date to" data-date-format="DD-MMM-YYYY" value="<?= $_GET["to"]; ?>" />
							<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<label>&nbsp;</label>
						<button type="submit" name="submit" class="btn btn-primary btn-block site_main_btn31" onclick="call_page()">Search</button>
					</div>
				</div>
			</div>
		</form>
		<div class='row'>
			<div class='col-xs-12 col-md-12 col-sm-12'>
				<table id="example" class="display table table-striped table-bordered" aria-describedby>
					<thead>
						<tr>
							<th style="width:50px;" scope>
								S.No.
							</th>
							<th scope>
								Deliverby
							</th>
							<th scope>
								Dispatch Date
							</th>
							<th scope>
								Dispatch Time
							</th>
							<th scope>
								TagNo
							</th>
							<th scope>
								View
							</th>					
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						$mytagno = "";
						$result = $result = $this->Drd_Invoice_Model->delivery_report($_GET);
						foreach($result as $row)
						{ 
							if($mytagno!=$row->tagno)
							{
								$mytagno=$row->tagno;
							?>
							<tr style="">
								<td>
									<?= $i++ ?>
								</td>						
								<td>
									<?= $row->deliverby?>
								</td>
								<td>
									<?= $row->vdt?>
								</td>
								<td>
									<?= $row->dispatchtime?>
								</td>
								<td>
									<?= $row->tagno?>							
								</td>
								<td>
									<a href="#" data-toggle="modal" data-target="#myModal_<?= $row->tagno?>">View
									</a>
								</td>
							</tr>
							<?php
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	$mytagno = "";
	foreach($result as $row)
	{ 
		if($mytagno!=$row->tagno)
		{
			$mytagno=$row->tagno;
	?>
	<div class="modal" id="myModal_<?= $row->tagno?>">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
				<h4 class="modal-title">View <?= $row->tagno?></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<table class="display table table-striped table-bordered">
						<thead>
							<tr>
								<th style="width:50px;" scope>
								S.No.
								</th>
								<th scope>
								Invoice
								</th>
								<th scope>
								Name
								</th>
								<th scope>
								Amount
								</th>
								<th scope>
								Comment
								</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$j = 1;
						$result1 = $this->Drd_Invoice_Model->delivery_report_view($row->tagno,$row->vdt);
						foreach($result1 as $row1)
						{
							?>
							<td>
							<?= $j++; ?>
							</td>
							<td>
							<?= $row1->gstvno; ?>
							</td>
							<td>
							(<?= $row1->altercode; ?>) <?= $row1->name; ?>
							</td>
							<td>
							<?= $row1->amt; ?>
							</td>
							<td>
							<?= $row1->personalmsg; ?>
							</td>					
						</tr>
						<?php
						}
						?>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	<?php 
		}
	}?>
</body>
</html>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<script>
$('#from').datetimepicker({format: 'DD-MMM-YYYY'});
$('#to').datetimepicker({format: 'DD-MMM-YYYY'});
$('#month').datetimepicker({format: 'MMM'});
</script>
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