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
	
</head>

	<body>
	<div class="container-fluid">
		<table id="example" class="display table table-striped table-bordered" aria-describedby>
			<thead>
				<tr>
					<th width="220px;">Item</th>
					<th width="60px;">Pack</th>
					<th>Opening</th>
					<th>Purchase</th>
					<th>Sale</th>
					<th>Sale return</th>
					<th>Others</th>
					<th>Closing</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$i = 1;
				$from = "2021-09-02";
				$to = "2021-09-02";
				$compcode = "8550";
				$division = "00";
				$result = $this->Corporate_Model->stock_and_sales_analysis($division,$compcode,$from,$to);
				
				//$this->Excel_Model->staff_download_stock_and_sales_analysis("",$division,$compcode,$from,$to,"direct_download");
				$mydivision = "";
				$dbchange = "0";
				foreach($result as $row)
				{ 					
					if($row->division!=$mydivision)
					{
						if($mydivision!="")
						{
							?>
							<tr>
								<td colspan='2' style="background: #ffc107;">Total Value (<?= $mydivision ?>) : </td>
								<td style="background: #ffc107;"><?= round($total_opening1,2) ?></td>
								<td style="background: #ffc107;"><?= round($total_purchase1,2) ?></td>
								<td style="background: #ffc107;"><?= round($total_sale1,2) ?></td>
								<td style="background: #ffc107;"><?= round($total_sale_return1,2) ?></td>
								<td style="background: #ffc107;"><?= round($total_other1,2) ?></td>
								<td style="background: #ffc107;"><?= round($total_closing1,2) ?></td>
							</tr>
							<?php	
						}
						?>
						<tr>
							<td colspan='8' style="background: #f7625b;">Division : <?= $row->division ?></td>
						</tr>
						<?php
						$mydivision = $row->division;
						
						$total_opening1 = $total_purchase1 = $total_sale1 = $total_sale_return1 = $total_other1 = $total_closing1 = 0;
					}
					$opening		= round($row->TempOpqty);
					$closing1		= round($row->clqty);
					$closing1_x		= round($row->TempClqty);
					if($closing1_x>$closing1)
					{
						$closing1 = $closing1_x;
					}
					
					$purchase 		= round($row->purchase);
					$sale 			= round($row->sale);	
					$sale_return 	= round($row->sale_return);
					$other1			= round($row->other1);
					$other2 		= round($row->other2);
					
					$total_other = 0;
					if($row->other1_1=="")
					{
						$row->other1_1 = 0;
					}
					
					if($row->other2_1=="")
					{
						$row->other2_1 = 0;
					}
					
					$other = 0;			
					if($other2!=0)
					{		
						$other 			= $other1 - $other2;
						$total_other 	= $row->other1_1;
					}
					else{
						$other 			= 0 - $other1;
						$total_other 	= 0 - $row->other1_1;
					}
					if($row->purchase1=="")
					{
						$row->purchase1 = 0;
					}
					$total_purchase = ($row->purchase1);	
					
					if($row->sale1=="")
					{
						$row->sale1 = 0;
					}
					$total_sale = ($row->sale1);
					
					if($row->sale_return1=="")
					{
						$row->sale_return1 = 0;
					}
					$total_sale_return = ($row->sale_return1);
					
					if($purchase=="")
					{
						$purchase = 0;
					}
					
					if($dbchange=="0")
					{
						$closing 		= $closing1;
						$opening 		= ($closing1  + $sale);
						$opening 		= ($opening  - $purchase);
						$opening 		= ($opening  - $sale_return);
						$opening 		= ($opening  - $other);
					}
					
					if($dbchange=="1")
					{
						/* only for ek trik */
						$closing 		= $opening + $purchase + $sale_return;
						$closing 		= $closing - $sale;
						$closing 		= $closing + $other;
						/*****************/
					}
					if($closing1=="0")
					{
						$closing 	= 0;
					}
					
					$total_opening = $opening * $row->costrate;
					$total_closing = $closing * $row->costrate;
					?>
					<tr>
						<td class="cart_title">
							<?= $row->name?>
						</td>
						<td class="cart_packing">
							<?= $row->pack?>
						</td>
						<td class="cart_stock">
							<?= $opening?>
						</td>
						<td class="cart_stock">
							<?= $purchase?>
						</td>
						<td class="">
							<?= $sale?>
						</td>
						<td class="">
							<?= $sale_return?>
						</td>
						<td class="">
							<?= $other?>
						</td>
						<td class="">
							<?= $closing?>
						</td>
					</tr>
				<?php
					
					$total_opening1 	= $total_opening1 	+ $total_opening;
					$total_purchase1 	= $total_purchase1 	+ $total_purchase;
					$total_sale1 		= $total_sale1 		+ $total_sale;
					$total_sale_return1 = $total_sale_return1+ $total_sale_return;
					$total_other1 		= $total_other1 	+ $total_other;
					$total_closing1 	= $total_closing1 	+ $total_closing;
					
					/**************full total*******************************/
					$total_opening1_f 		= $total_opening1_f 	+ $total_opening;
					$total_purchase1_f		= $total_purchase1_f 	+ $total_purchase;
					$total_sale1_f			= $total_sale1_f 		+ $total_sale;
					$total_sale_return1_f 	= $total_sale_return1_f	+ $total_sale_return;
					$total_other1_f 		= $total_other1_f 		+ $total_other;
					$total_closing1_f 		= $total_closing1_f 	+ $total_closing;
				}
				?>
				<tr>
					<td colspan='2' style="background: #ffc107;">Total Value (<?= $mydivision ?>) : </td>
					<td style="background: #ffc107;"><?= round($total_opening1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_purchase1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_sale1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_sale_return1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_other1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_closing1,2) ?></td>
				</tr>
				<tr>
					<td colspan='2' style="background: #28a745;">Total : </td>
					<td style="background: #28a745;"><?= round($total_opening1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_purchase1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_sale1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_sale_return1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_other1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_closing1_f,2) ?></td>
				</tr>
			</tbody>
		</table>
		</div>
	</body>
</html>
<Script>
/*$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
		"pageLength": 25,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );*/
</Script>