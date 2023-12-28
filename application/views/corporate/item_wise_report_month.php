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
.total_bg
{
	background: #03a9f4;
}
</style>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class='row'>
				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<label>Select month</label>
						<div class='input-group date' id='datetimepicker1' style="width: 100%">
							 <input type='text' class="form-control monthdate" id="month" name="month" value="" placeholder="Select month" />
							<span class="input-group-addon d-xs-none d-md-block">
								<span class="glyphicon glyphicon-calendar"></span>
							</span>
						</div>
					</div>
				</div>
				
				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<br>
						<button type="submit" name="submit" class="btn btn-primary btn-block site_main_btn31" onclick="call_page()">Submit</button>
					</div>
				</div>
				<div class='col-xs-6 col-md-3'>
					<div class="form-group">
						<br>
						<button type="submit" name="submit" class="btn btn-primary btn-block site_main_btn31 downloadbtn" onclick="call_download()" style="display:none;">Download</button>
					</div>
				</div>
			</div>
			<table class="table table-striped table-bordered fixTableHead" aria-describedby style="background:white">
				<thead>
					<tr>
						<th style="width:50px;" scope>

						</th>
						<th style="width:50px;" scope>
							Code
						</th>
						<th style="width:100px;" scope>
							Customer
						</th>
						<th style="width:50px;" scope>
							Qty
						</th>
						<th style="width:50px;" scope>
							Free
						</th>
						<th style="width:50px;" scope>
							Amount
						</th>
						<th style="width:200px;" scope>
							Address
						</th>
						<th style="width:50px;" scope>
							Mobile
						</th>
					</tr>
				</thead>
				<tbody class="load_page">
					
				</tbody>
				<tfoot class="load_page_tfoot">
					
				</tfoot>
			</table>
			<div class="load_page_loading">
				
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
<script>
$('#from').datetimepicker({format: 'DD-MMM-YYYY'});
$('#to').datetimepicker({format: 'DD-MMM-YYYY'});
$('#month').datetimepicker({format: 'MMM'});
</script>    
<script>
function call_page()
{
	user_session	=	'<?=$user_session?>';
	user_division	=	'<?=$user_division?>';
	user_compcode	=	'<?=$user_compcode?>';
	
	$(".downloadbtn").hide();
	monthdate   = $("#month").val();
	if(monthdate=="")
	{
		alert("Select month")
		return false;
	}
	$(".load_more").hide();
	$(".load_page").html("");
	$(".load_page_tfoot").html("");
	$(".load_page_loading").html('<h1><center><img src="<?= constant('base_url2'); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></center></h1><h1><center>Loading....</center></h1>');
	$.ajax({
		type       : "POST",
		data       :  {user_session:user_session,user_division:user_division,user_compcode:user_compcode,monthdate:monthdate} ,
			url        : "<?php echo base_url(); ?>corporate/item_wise_report_api",
		cache	   : false,
		error: function(){
			$(".load_page_loading").html('<h1><img src="<?= constant('base_url2'); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
		},
		success    : function(data){
			if(data!="")
			{
				$(".load_page_loading").html("");
			}
			var itc1 = "";
			var itc2 = "";
			var int_i = 0;
			total_qty = total_fqty = total_netamt = 0;
			total_qty_f = total_fqty_f = total_netamt_f = 0;
			$.each(data.items, function(i,item){	
				if (item){
					if(item.itemc=="xxxx")
					{
						$(".load_page").append('<tr><td colspan="8">'+item.permission+'</td></tr>');
					}
					else
					{
						int_i++;
						$(".downloadbtn").show();
						itc1 = item.itemc;
						if(itc1!=itc2)
						{
							itc2 = itc1;
							if(int_i!=1)
							{
								$(".load_page").append('<tr style="background: #ffc107;"><td>Total</td><td></td><td></td><td>'+total_qty+'</td><td>'+total_fqty+'</td><td>'+total_netamt.toFixed(2)+'</td><td></td><td></td></tr>');
								total_qty = total_fqty = total_netamt = 0;
							}
							$(".load_page").append('<tr><td class="cart_title" colspan="8">'+atob(item.name)+' <span class="cart_packing">('+atob(item.pack)+' Packing)</span> <span class="cart_stock">Current Stock : ('+(item.stock)+')</span></td></tr>');					
						}
						total_qty 		= total_qty + parseInt(item.qty);
						total_fqty 		= total_fqty + parseInt(item.fqty);
						total_netamt 	= total_netamt + parseFloat(item.netamt);
						
						total_qty_f		= total_qty_f    + parseInt(item.qty);
						total_fqty_f 	= total_fqty_f   + parseInt(item.fqty);
						total_netamt_f 	= total_netamt_f + parseFloat(item.netamt);
						
						$(".load_page").append('<tr><td></td><td class="cart_chemist_code">'+item.c_id+'</td><td class="cart_chemist_name">'+atob(item.c_name)+'</td><td class="cart_stock">'+item.qty+'</td><td class="cart_stock_free">'+item.fqty+'</td><td>'+item.netamt+'</td><td class="cart_chemist_phone">'+atob(item.c_address)+'</td><td class="cart_chemist_phone"><a href="tel:'+atob(item.c_mobile)+'">'+atob(item.c_mobile)+'</a></td></tr>');
						
						$(".load_page_tfoot").html('<tr style="background: #ffc107;"><td>Total</td><td></td><td></td><td>'+total_qty+'</td><td>'+total_fqty+'</td><td>'+total_netamt.toFixed(2)+'</td><td></td><td></td></tr><tr style="background: #28a745;"><td>Grand Total</td><td></td><td></td><td>'+total_qty_f+'</td><td>'+total_fqty_f+'</td><td>'+total_netamt_f.toFixed(2)+'</td><td></td><td></td></tr>');
					}
				}
			});	
		}
	});
}
function call_download()
{
	$(".downloadbtn").hide();
	monthdate   = $(".monthdate").val();
	if(monthdate=="")
	{
		alert("Select Month")
		return false;
	}
	window.location.href = "<?= constant('api_url') ?>staff_download_item_wise_report_month/<?= ($user_session); ?>/<?= ($user_division); ?>/<?= ($user_compcode); ?>/"+monthdate;
	setTimeout('$(".downloadbtn").show();',5000);
}
</script>