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
				<div class='col-xs-2 col-md-2'>
					<div class="form-group">
						<label>Invoice No.</label>						
						<input type="text" class="form-control" id="form-field-1" placeholder="Invoice No." name="invoice_no" value="<?= $_GET["invoice_no"]; ?>" />
					</div>
				</div>

				<div class='col-xs-2 col-md-2'>
					<div class="form-group">
						<label>Location</label>
						<input type="text" class="form-control" id="form-field-1" placeholder="Location" name="location" value="<?= $_GET["location"]; ?>" />
					</div>
				</div>
				
				<div class='col-xs-2 col-md-2'>
					<div class="form-group">
						<label>Customer</label>
						<input type="text" class="form-control" id="form-field-1" placeholder="Customer" name="customer" value="<?= $_GET["customer"]; ?>" />
					</div>
				</div>
				
				<div class='col-xs-2 col-md-2'>
					<div class="form-group">
						<label>Pickedby</label>
						<input type="text" class="form-control" id="form-field-1" placeholder="Pickedby" name="pickedby" value="<?= $_GET["pickedby"]; ?>" />
					</div>
				</div>
				
				<div class='col-xs-2 col-md-2'>
					<div class="form-group">
						<label>Deliverby</label>
						<input type="text" class="form-control" id="form-field-1" placeholder="Deliverby" name="deliverby" value="<?= $_GET["deliverby"]; ?>" />
					</div>
				</div>
				<div class='col-xs-2 col-md-2'>
					<div class="form-group">
						<label>&nbsp;</label>
						<button type="submit" name="submit" class="btn btn-primary btn-block site_main_btn31" onclick="call_page()">Search</button>
					</div>
				</div>
			</div>
		</form>
		<table id="example" class="display table table-striped table-bordered" aria-describedby>
			<thead>
				<tr>
					<th style="width:50px;" scope>
						S.No.
					</th>
					<th style="width:50px;" scope>
						Time
					</th>
					<th style="width:150px;" scope>
						Invoice No.
					</th>
					<th scope>
						Location
					</th>
					<th scope>
						Customer
					</th>
					<th scope>
						Pickedby
					</th>
					<th scope>
						Deliverby
					</th>
					<th scope>
						Dispatch Time
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				$result = $this->Drd_Invoice_Model->today_invoice_to_show($_GET,$value);
				foreach($result as $row)
				{ 
					$bg = "";
					if(trim($row->deliverby)=="")
					{
						$row->deliverby = "Deliverby Not defined";
						$bg = "color:#673ab7;";
					}
					if(trim($row->pickedby)=="")
					{
						$row->deliverby = "";
						$row->pickedby = "Pickedby not defined";
						$bg = "color:#ff5722;";
					}
					?>
					<tr style="<?= $bg?>">
						<td>
							<?= $i++ ?>
						</td>
						<td>
							<?= $row->mtime?>
						</td>
						<td>
							<?= $row->gstvno?>
						</td>
						<td>
							<?= $row->scode?>
						</td>
						<td>
							(<?= $row->altercode?>) <?= $row->name?>
							<br>
							<span style="color: #0a27f9;"><?= $row->personalmsg?></span>
						</td>
						<td>
							<?= $row->pickedby?>
						</td>
						<td>
							<?= $row->deliverby?>
						</td>
						<td>
							<?= $row->dispatchtime?>
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		</div>
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