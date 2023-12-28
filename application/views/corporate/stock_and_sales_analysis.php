<style>
body
{
	margin:0px;
	padding:0px;
}
.fixTableHead {
	overflow-y: auto;
	height: 50px;
}
.fixTableHead thead th {
  position: sticky;
  top: 0;
}
table {
  border-collapse: collapse;
  width: 100%;
}
th {
  background: #ffffff;
}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-sm-8 col-12">
					From : 
					<?php
					$time 	= time();
					$d1 	= "01".date("-M-y",$time);
					$d2 	= date("d-M-y",$time);
					?>
					<?= $d1?> To: <?= $d2?>
					<br>
					<?php
					$user_session1 = base64_decode($user_session);
					$user_division1 = base64_decode($user_division);
					$user_compcode1 = base64_decode($user_compcode);
					$tbl_staffdetail = $this->db->query("select company_full_name,comp_altercode from tbl_staffdetail where compcode='$user_compcode1'")->row();
					?>
					Company : <?=  $tbl_staffdetail->comp_altercode; ?> [<?= $tbl_staffdetail->company_full_name; ?>] 
				</div>
				<div class="col-sm-4 col-12">
					<button type="submit" name="submit" class="btn btn-success btn-block site_main_btn31 downloadbtn" onclick="call_download()" style="display:none;">Download</button>
				</div>
			</div>
			<div class="">
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
				$monthdate = date('m');
				$date 	= date('Y-m');
				$year  	= date('Y');
				$date 	= "$year-{$monthdate}";
				$ts 	= strtotime($date);
				$from 	= date('Y-m-01',$ts);
				$to 	= date('Y-m-t',$ts);
				$result = $this->Corporate_Model->stock_and_sales_analysis($user_division1,$user_compcode1,$from,$to);
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
							<td colspan='8' style="background: #03a9f4;">Division : <?= $row->division ?></td>
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
					
					?>
					<script>
					$(".downloadbtn").show();
					</script>
					<?php
				}
				?>
				<tr>
					<td colspan='2' style="background: #ffc107;">Total Value (<?= $mydivision ?>)</td>
					<td style="background: #ffc107;"><?= round($total_opening1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_purchase1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_sale1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_sale_return1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_other1,2) ?></td>
					<td style="background: #ffc107;"><?= round($total_closing1,2) ?></td>
				</tr>
				<tr>
					<td colspan='2' style="background: #28a745;">Grand Total</td>
					<td style="background: #28a745;"><?= round($total_opening1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_purchase1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_sale1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_sale_return1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_other1_f,2) ?></td>
					<td style="background: #28a745;"><?= round($total_closing1_f,2) ?></td>
				</tr>
			</tbody>
		</table>
				<div class="load_page_loading">
					
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
  
<script>
$(document).ready(function(){
	//call_page();
});
function call_page()
{
	user_session	=	'<?=$user_session?>';
	user_division	=	'<?=$user_division?>';
	user_compcode	=	'<?=$user_compcode?>';
	
	$(".load_more").hide();
	$(".load_page").html("");
	$(".load_page_loading").html('<h1><center><img src="<?= constant('base_url2'); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       :  {user_session:user_session,user_division:user_division,user_compcode:user_compcode,} ,
		url        : "<?php echo base_url(); ?>corporate/stock_and_sales_analysis_api",
		cache	   : false,
		error: function(){
			$(".load_page_loading").html('<h1><img src="<?= constant('base_url2'); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
		},
		success    : function(data){
			if(data!="")
			{
				$(".load_page_loading").html("");
			}
			var total_opening = 0;
			var total_purchase = 0;
			var total_sale = 0;
			var total_sale_return = 0;
			var total_other = 0;
			var total_closing = 0;
			$.each(data.items, function(i,item){	
				if (item){
					if(item.permission!="")
					{
						$(".load_page").append('<center>'+item.permission+'</center>');
					}
					else
					{
						total_opening	= total_opening + parseFloat(item.total_opening)
						total_purchase 	= total_purchase + parseFloat(item.total_purchase)
						total_sale 		= total_sale + parseFloat(item.total_sale)
						total_sale_return= total_sale_return + parseFloat(item.total_sale_return)
						total_other		= total_other + parseFloat(item.total_other)
						total_closing	= total_closing + parseFloat(item.total_closing)
						$(".downloadbtn").show();
						$(".load_page").append('<tr><td class="cart_title">'+atob(item.item_name)+'</td><td class="cart_packing">'+atob(item.packing)+'</td><td class="cart_stock">'+(item.opening)+'</td><td>'+(item.purchase)+'</td><td>'+(item.sale)+'</td><td>'+(item.sale_return)+'</td><td>'+(item.other)+'</td><td>'+(item.closing)+'</td></tr>');
						
						$(".load_page_tfoot").html('<tr><td>Total</td><td></td><td>'+(total_opening).toFixed(2)+'</td><td>'+(total_purchase).toFixed(2)+'</td><td>'+(total_sale).toFixed(2)+'</td><td>'+(total_sale_return).toFixed(2)+'</td><td>'+(total_other).toFixed(2)+'</td><td>'+(total_closing).toFixed(2)+'</td></tr>');
					}
				}
			});			
		}
	});
}
function call_download()
{
	$(".downloadbtn").hide();
	formdate = $(".formdate").val();
	todate   = $(".todate").val();
	if(formdate=="")
	{
		alert("Select Date from")
		return false;
	}
	if(todate=="")
	{
		alert("Select Date to")
		return false;
	}
	window.location.href = "<?php echo constant('api_url'); ?>staff_download_stock_and_sales_analysis/<?= $user_session; ?>/<?= $user_division; ?>/<?= $user_compcode; ?>";
	setTimeout('$(".downloadbtn").show();',5000);
}
</script>