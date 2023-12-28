<style>
.menubtn1
{
	display:none;
}
.med_gray1:hover {
    background: #ffffff;
    color: #000000;
}
</style>
<script>
$(".headertitle").html("Notification");
</script>
<div class="container" style="margin-top:20px;">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8 col-12">
			<div class="row">
				<div class="col-sm-12 col-12 load_page">
					
				</div>
				<div class="col-sm-12 load_page_loading" style="margin-top:10px;">
				
				</div>
				<div class="col-sm-12" style="margin-top:10px;">
					<button onclick="call_page_by_last_id()" class="load_more btn btn-success btn-block">Load More</button>
				</div>
			</div>
		</div>
		<div class="col-sm-2"></div>
	</div>     
</div>
<input type="hidden" class="lastid1">
<script>
$(document).ready(function(){
	call_page("kapil");
});
function call_page_by_last_id()
{
	lastid1=$(".lastid1").val();
	call_page(lastid1)
}
function call_page(lastid1)
{
	$(".load_more").hide();
	$(".load_page_loading").html("<center>Loading....</center>");
	id		= "<?php echo $id; ?>";
	$.ajax({
	type       : "POST",
	data       :  { id:id} ,
	url        : "<?php echo base_url(); ?>read_json/notification_view_api",
	cache	   : false,
	success    : function(data){
		if(data!="")
		{
			$(".load_page_loading").html("");
		}
		$.each(data.items, function(i,item){	
			if (item){
				$(".load_page").append('<div class="row mynewrow '+item.css+' border" style="margin-top:5px;"><div class="col-sm-6 col-6">Notification</div><div class="col-sm-6 col-6 text-right">'+item.date_time+'</div><div class="col-sm-12 col-12">'+item.title+'</div><div class="col-sm-12 col-12 cut-text1">'+atob(item.message)+'</div></div>');
				$(".lastid1").val(item.lastid1);
				if(item.css!="")
				{
					//$(".load_more").show();
				}
			}
		});
		}
	});
}
</script>