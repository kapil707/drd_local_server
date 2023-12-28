<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link href="<?= base_url(); ?>assets/website/css/style<?= constant('site_v') ?>.css" rel="stylesheet" type="text/css"/>
<style>
body{
	margin-top:0px;
}
</style>
<div class="container">
	<div class="row">
		<div class="col-sm-3"></div>
		<div class="col-sm-7 col-12">
			<span class="search_medicine_result searchpagescrolling2"></span>
		</div>
	</div>
</div>
	<div class="row">
		<div class="col-sm-12 col-12">
			<table class="table table-striped table-bordered" aria-describedby>
				<thead>
					<tr>
						<th style="width:50px;" scope>
							S.No.
						</th>
						<th scope>
							Item Information
						</th>
					</tr>
				</thead>
				<tbody class="tbody_row">
			<?php
			$lastcount=0;
			$j = 0;
			foreach($result as $row)
			{
				$item_name 	= ucwords(strtolower($row->item_name));
				if(!empty($item_name))
				{
					$item_qty 	= $row->quantity;
					$item_mrp 	= $row->itemprice;
					$i          = $row->id; 
					$j++?>
					<tr class="remove_css_<?= $i ?>">
						<td>
							<?= $j ?>
							<input type="hidden" value="<?= $item_name ?>" class="your_item_name_<?= $i ?>">
							<input type="hidden" value="<?= $item_mrp ?>" class="your_item_mrp_<?= $i ?>">
							<input type="hidden" value="<?= $item_qty ?>" class="your_item_qty_<?= $i ?>">
						</td>
						<td class="import_order_td_<?= $i ?>">
							<div class="row">
								<div class="col-sm-1">
									Old Image
									<img src="<?=base_url(); ?>img_v<?= constant('site_v') ?>/logo2.png" width="64px;" style="margin-top: 5px;" class="image_css_<?= $i ?>" alt="">
								</div>
								<div class="col-sm-1">
									New Image
									<img src="<?=base_url(); ?>new_pix/<?php echo $row->image1 ?>" width="64px;" style="margin-top: 5px;" class="new_image_css_<?= $i ?>" alt=""><br>
								</div>
								<div class="col-sm-10">
									<div class="row">
										<div class="col-sm-12">
											<span style="float:left;">
												File : 
												<span class="import_order_title_1">
												<?= $item_name; ?> | <b>Price : <?= number_format($item_mrp,2) ?></b>
												</span>
											</span>
											<span style="float:left; margin-left:10px;margin-right:10px;" class="import_order_mrp">
											|
											</span>
											<span style="float:left;"><a href="javascript:void(0)" onclick="remove_row('<?= $i; ?>')" title="Delete medicine" class="delete_all delete_all_btn_<?= $i ?>">
											<img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete medicine"> Delete medicine </a> </span> | <span class="selected_SearchAnotherMedicine_<?= $i ?>" style="display:none"><a href="javascript:Search_Another_Medicine_js('<?= $i ?>')" class="delete_all" title="Change medicine"><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" alt="Change Medicine"> Change medicine</a></span>
										</div>
										<div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div>
									</div>
									<div class="row select_product_<?= $i ?>" style="display:none">
										<div class="col-sm-12">
											DRD : 
											<span class="import_order_title selected_item_name_<?= $i ?>"></span>
											<span class="import_order_packing">
											(<span class="selected_packing_<?= $i ?>"></span> Packing) </span> | <span class="import_order_mrp"> MRP. : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_mrp_<?= $i ?>">0.00</span>/- </span> | <span class="import_order_ptr"> PTR. : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_sale_rate_<?= $i ?>">0.00</span>/-</span> | <span class="import_order_landing_price"><b>
											~ Price : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_final_price_<?= $i ?>">0.00</span>/-</b></span>
										</div>
										<div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div>
										<div class="col-sm-12">
											<span class="import_order_company">
											By : <span class="selected_company_full_name_<?= $i ?>"></span></span> | <span class="selected_msg_<?= $i ?>"> Loading.... </span><span class="selected_suggest_<?= $i ?>" style="display:none"> | <a href="javascript:delete_suggest('<?= $i ?>')" title="Delete suggested medicine" class="delete_all"><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete suggested medicine">Delete suggested medicine</a> </span> | <a href="javascript:show_big_img_div(<?= $i ?>)"
											title="Delete suggested medicine" class="delete_all"><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" alt="Edit Image"> Edit Image </a> | <a href="javascript:show_big_des_div(<?= $i ?>)"
											title="Delete suggested medicine" class="delete_all"><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" alt="Edit Description"> Edit Description</a>
											
											<input type="hidden" class="css_old_img_01_<?= $i ?>">
											<input type="hidden" class="css_old_img_02_<?= $i ?>">
											<input type="hidden" class="css_old_img_03_<?= $i ?>">
											<input type="hidden" class="css_old_img_04_<?= $i ?>">
											
											<input type="hidden" class="css_new_img_01_<?= $i ?>" value="new_pix/<?php echo $row->image1 ?>">
											<input type="hidden" class="css_new_img_02_<?= $i ?>" value="new_pix/<?php echo $row->image2 ?>">
											<input type="hidden" class="css_new_img_03_<?= $i ?>" value="new_pix/<?php echo $row->image3 ?>">
											<input type="hidden" class="css_new_img_04_<?= $i ?>" value="new_pix/<?php echo $row->image4 ?>">
											
											<textarea class="css_new_description1_<?= $i ?>" style="display:none"><?= $row->itemintro1 ?></textarea>
											<textarea class="css_new_description2_<?= $i ?>" style="display:none"><?= $row->itemintro2 ?></textarea>
											
											<textarea class="css_old_description1_<?= $i ?>" style="display:none"></textarea>
											<textarea class="css_old_description2_<?= $i ?>" style="display:none"></textarea>
										</div>
									</div>
								</div>
							</div>
							<?php /***main result show hear*/ ?>
							<span class="import_order_dropdownbox_<?= $i ?>"></span>
						</td>
					</tr>
					<script>
					$(document).ready(function(){
						setTimeout("import_order_dropdownbox('<?= $i ?>')",500);
					});
					</script>
				<?php
				$lastcount++;
				}
			}
			?>
				</tbody>
			</table>
		</div>
		<div class="col-sm-6 col-6 text-left">
		</div>
		<div class="col-sm-6 col-6 text-right">
			<a href="<?= base_url(); ?>admin/manage_medicine_info2">
				<button type="submit" class="btn btn-primary next_btn site_main_btn31" name="submit" value="submit" style="width:20%">Next</button>
			</a>
		</div>		
	</div>
<input type="hidden" class="_import_order_i">
<div class="background_blur" onclick="clear_search_box()" style="display:none"></div>
<div class="script_css"></div>
<input type="hidden" value="<?php echo $chemist_id; ?>" class="chemist_id" id="chemist_id">
<input type="hidden" value="<?php echo time(); ?>" class="mytime">

<input type="hidden" value="" class="new_import_page_item_name">
<input type="hidden" value="" class="new_import_page_item_mrp">

<script>
function change_item_qty(cssid)
{
	item_qty = $(".item_qty_"+cssid).val();
	$(".your_item_qty_"+cssid).val(item_qty);
	$.ajax({
		type       : "POST",
		data       :  {item_qty:item_qty,cssid:cssid,chemist_id:'<?= $chemist_id ?>',order_id:'<?php echo $order_id ?>'} ,
		url        : "<?= base_url(); ?>import_order/change_item_qty",
		cache	   : false,
		error: function(){
			swal("Order quantity not updated");
		},
		success    : function(data){
			$.each(data.items, function(i,item){	
				if (item)
				{
					if(item.response=="1")
					{
						swal("Order quantity updated successfully");
					}
					else{
						swal("Order quantity not updated");
					}
				} 
			});
		},
		timeout: 10000
	});
}

function import_order_dropdownbox(cssid)
{
	item_name = $(".your_item_name_"+cssid).val();
	item_mrp  = $(".your_item_mrp_"+cssid).val();
	item_qty  = $(".your_item_qty_"+cssid).val();

	mytime = $(".mytime").val();
	$.ajax({
		type       : "POST",
		data       :  {item_name:item_name,item_mrp:item_mrp,item_qty:item_qty,mytime:mytime,cssid:cssid,chemist_id:'<?= $chemist_id ?>',order_id:'<?php echo $order_id ?>'} ,
		url        : "<?= base_url(); ?>admin/manage_medicine_info2/import_order_dropdownbox",
		cache	   : true,
		error: function(){
			$(".selected_msg_"+cssid).html("Server not Responding, Please try Again");
		},
		success    : function(data){
			$(".import_order_dropdownbox_"+cssid).html(data);
		}
	});
}

function remove_row(cssid)
{
	item_name = $(".your_item_name_"+cssid).val();
	swal({
		title: "Are you sure to delete medicine?",
		/*text: "Once deleted, you will not be able to recover this imaginary file!",*/
		icon: "warning",
		buttons: ["No", "Yes"],
		dangerMode: true,
	}).then(function(result) {
		if (result) {
			$.ajax({
				type       : "POST",
				data       :  {cssid:cssid,item_name:item_name,chemist_id:'<?= $chemist_id ?>',order_id:'<?php echo $order_id ?>',} ,
				url        : "<?= base_url(); ?>admin/manage_medicine_info2/remove_row",
				cache	   : false,
				error: function(){
					swal("Medicine not deleted");
				},
				success    : function(data){
					$.each(data.items, function(i,item){	
						if (item)
						{
							if(item.response=="1")
							{
								$(".remove_css_"+cssid).html('');
								swal("Medicine deleted successfully", {
									icon: "success",
								});
							}
							else{
								swal("Medicine not deleted");
							}
						} 
					});
				},
				timeout: 10000
			});
		} else {
			swal("Medicine not deleted");
		}
	});
}

function delete_suggest(cssid)
{
	item_name = $(".your_item_name_"+cssid).val();
	item_mrp  = $(".your_item_mrp_"+cssid).val();
	item_qty  = $(".your_item_qty_"+cssid).val();
	swal({
		title: "Are you sure to delete suggested medicine?",
		/*text: "Once deleted, you will not be able to recover this imaginary file!",*/
		icon: "warning",
		buttons: ["No", "Yes"],
		dangerMode: true,
	}).then(function(result) {
		if (result) {
			$.ajax({
				url: "<?php echo base_url(); ?>admin/manage_medicine_info2/delete_suggest",
				type:"POST",
				/*dataType: 'html',*/
				data: {item_name:item_name},
				error: function(){
					swal("Suggested medicine not deleted");
				},
				success: function(data){
					$.each(data.items, function(i,item){	
						if (item)
						{
							if(item.response=="1")
							{
								swal("Suggested Medicine deleted successfully", {
									icon: "success",
								});
								$('.selected_suggest_'+cssid).hide();
								import_order_dropdownbox(cssid)
							}
							else{
								swal("Suggested medicine not deleted");
							}
						} 
					});
				},
				timeout: 10000
			});
		} else {
			swal("Suggested medicine not deleted");
		}
	});
}
/*************************************/

function Search_Another_Medicine_js(cssid)
{
	item_name = $(".your_item_name_"+cssid).val();
	$(".select_chemist").hide();
	$(".select_medicine").focus();
	$(".select_medicine").val('');
	$(".background_blur").show();
	/*$(window).scrollTop(0); 
	$('html, body').css({
		overflow: 'hidden',
		height: '100%'
	});*/
	$("._import_order_i").val(cssid);
	//$('.select_medicine').val(item_name);
	setTimeout($('.select_medicine').val(item_name),500);
	setTimeout(search_medicine(),1000);
}

function clear_search_box()
{
	$(".clear_search_box").hide();
	$(".select_medicine").val('');
	$(".background_blur").hide();
	i = $("._import_order_i").val();
	$(".item_qty_"+i).focus();
	$(".search_medicine_result").hide();
	/*$('html, body').css({
		overflow: 'auto',
		height: '100%'
	});*/
}

$(document).ready(function(){	
	$(".SearchMedicine_search_box").keyup(function() { 
		var keyword = $(".SearchMedicine_search_box").val();
		if(keyword!="")
		{
			if(keyword.length<3)
			{
				$('.SearchMedicine_search_box').focus();
				$(".search_medicine_result").html("");
			}
			search_medicine()
		}
		else{
			//clear_search_box();
		}
	});
	$(".SearchMedicine_search_box").change(function() { 
	});
	$(".SearchMedicine_search_box").on("search", function() { 
	});
	
    $(".SearchMedicine_search_box").keydown(function(event) {
    	if(event.key=="ArrowDown")
    	{
			page_up_down_arrow("1");
    		$('.hover_1').attr("tabindex",-1).focus();
			return false;
    	}
    });
	//setTimeout('page_load();',100);
	
	document.onkeydown = function(evt) {
		evt = evt || window.event;
		if (evt.keyCode == 27) {
			//clear_search_box();
		}
	};
});

function search_medicine()
{
	new_i = 0;
	$(".clear_search_box").show();
	var keyword = $(".SearchMedicine_search_box").val();
	if(keyword!="")
	{
		if(keyword=="#")
		{
			keyword = "k1k2k12k";
		}
		if(keyword.length>2)
		{
			$(".background_blur").show();
			$(".search_medicine_result").show();
			$(".search_medicine_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/loading.gif" width="100px"></h1><h1>Loading....</h1></div></div>');
			$.ajax({
			type       : "POST",
			data       :  { keyword : keyword} ,
			url        : "<?php echo base_url(); ?>Chemist_medicine/search_medicine_api",
			error: function(){
				$(".search_medicine_result").html('<h1><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/something_went_wrong.png" width="100%"></h1>');
			},
			cache	   : false,
			success    : function(data){
				if(data.items=="")
				{
					$(".search_medicine_result").html('<div class="row p-2" style="background:white;"><div class="col-sm-12 text-center"><h1><img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/no_record_found.png" width="100%"></h1></div></div>');
				}
				else
				{
					$(".search_medicine_result").html("");
				}
				$.each(data.items, function(i,item){
						if (item)
						{
							//new_i				= parseInt(item.i);
							date_time			= item.date_time;
							i_code				= item.i_code;			
							item_name 			= item.item_name;
							company_full_name 	= item.company_full_name;
							image1 				= item.image1;
							image2 				= item.image2;
							image3 				= item.image3;
							image4 				= item.image4;
							description1 		= item.description1;
							description2 		= item.description2;
							batchqty 			= item.batchqty;
							sale_rate 			= item.sale_rate;
							mrp 				= item.mrp;
							final_price 		= item.final_price;
							batch_no 			= item.batch_no;
							packing 			= item.packing;
							expiry 				= item.expiry;
							scheme 				= item.scheme;
							margin 				= item.margin;
							featured 			= item.featured;
							gstper 				= item.gstper;
							discount          	= item.discount;
							misc_settings      	= item.misc_settings;
							itemjoinid         	= item.itemjoinid;
							items1				= item.items1;
							
							item_name_1 = item_name.charAt(0);
							
							if(item_name_1==".")
							{
							}
							else
							{
								new_i = parseInt(new_i) + 1;
								smilerproduct = '';
								if(itemjoinid!="")
								{
									arr = itemjoinid.split(',');
									smilerproductcount  = arr.length;
									
									smilerproduct_i_code   	= items1[0].i_code;
									smilerproduct_data 		= items1[0].item_name+" | MRP. "+items1[0].mrp+" | "+items1[0].margin+" % Margin";
									
									smilerproduct ='<div class="row" style="border-top: 1px solid #1084a1;margin-top: -1px;font-size: 13px;padding:5px;"><div class="col-sm-12 col-12">'+smilerproduct_data+'</div><div class="col-sm-12 col-12"><a href="#" onClick=javascript:open_model_smilerproduct('+smilerproduct_i_code+');><div class="spansmilerproduct">View All '+smilerproductcount+' Similar Items<img src="<?= base_url(); ?>/img_v<?= constant('site_v') ?>/next1.png" width=16px></div></a></div></div>';
								}
								
								outofstockicon = '';
								if(batchqty=="0"){
									batchqty1 = '<span class="main_search_out_of_stock">Out Of Stock</span>';
									outofstockicon = '<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/outofstockicon.png" class="main_search_outofstockiconcss">';
								} else {
									batchqty1 = '<span class="main_search_stock">Stock: '+batchqty+'</span>';
								}
								
								featuredicon = '';
								if(featured=="1" && batchqty!="0"){
									featuredicon = '<img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/featuredicon.png" class="main_search_featurediconcss">';
								}
								
								li_css = "";
								if(new_i%2==0) 
								{ 
									li_css = "search_page_gray"; 
								} 
								else 
								{  
									li_css = "search_page_gray1"; 
								}
								
								csshover1 = 'hover_'+new_i;
								
								your_order_qty = "";
								
								item_name_m 		= btoa(item_name);
								company_full_name_m = btoa(company_full_name);
								image_m1 	 		= btoa(image1);
								image_m2 	 		= btoa(image2);
								image_m3 	 		= btoa(image3);
								image_m4 	 		= btoa(image4);
								description1_m 	 	= btoa(description1);
								description2_m 	 	= btoa(description2);
								packing_m 			= btoa(packing);
								expiry_m  			= btoa(expiry);
								batch_no_m			= btoa(batch_no);
								scheme_m  			= btoa(scheme);
								date_time_m  		= btoa(date_time);
								items1				= JSON.stringify(items1);
								items1 	 			= btoa(items1);
								
								li_start = '<li class="search_page_hover '+li_css+' '+csshover1+'"><a href="#" onClick=select_medicine_in_search_box("'+item_name_m+'","'+mrp+'","'+i_code+'"),clear_search_box(); class="search_page_hover_a get_single_medicine_info_'+new_i+'">';
								
								image_ = '<img src="'+image1+'" style="width: 100%;" class="border rounded">'+featuredicon+outofstockicon;
								
								scheme_show_hide = "";
								if(scheme=="0+0")
								{
									scheme =  'No scheme';
									scheme_show_hide = "display:none"
								}
								else
								{
									scheme =  'Scheme : '+scheme;
								}
								
								scheme_or_margin =  '<div class="row"><div class="col-sm-6 col-6"><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/scheme.png" class="main_search_scheme_icon" style="'+scheme_show_hide+'"><span class="main_search_scheme" style="'+scheme_show_hide+'">'+scheme+'</span></div><div class="col-sm-6 col-6 text-right"><span class="main_search_margin">'+margin+'% Margin</span><img src="<?= base_url() ?>/img_v<?= constant('site_v') ?>/ribbonicon.png" class="main_search_margin_icon"></div></div>';
								
								rete_div =  '<span class="cart_ptr">PTR: <i class="fa fa-inr" aria-hidden="true"></i> '+sale_rate+'/- </span> | <span class="cart_ptr">MRP: <i class="fa fa-inr" aria-hidden="true"></i> '+mrp+'/- </span> | <span class="cart_landing_price"> ~ <span class="mobile_off">Landing</span> Price: <i class="fa fa-inr" aria-hidden="true"></i> '+final_price+'/- </span>';
								
								sale_rate 	= parseFloat(sale_rate).toFixed(2);
								mrp 		= parseFloat(mrp).toFixed(2);
								final_price = parseFloat(final_price).toFixed(2);
								
								$(".search_medicine_result").append(li_start+'<div class="row"><div class="col-sm-3 col-4">'+image_+'</div><div class="col-sm-9 col-8"><div class="cart_title">'+item_name+'<span class="cart_packing"> ('+packing+' Packing)</span> </div><div class="cart_expiry">Expiry: '+expiry+'</div><span class="cart_description1">'+description1+'</span><div class="cart_company">By '+company_full_name+'</div><div class="cart_stock">'+batchqty1+'</div><div class="mobile_off">'+scheme_or_margin+'</div><div class="mobile_off">'+rete_div+'</div></div><div class="mobile_show col-sm-12 col-12">'+scheme_or_margin+'</div><div class="mobile_show col-sm-12 col-12">'+rete_div+'</div></div></li>'+smilerproduct);
							}						
						}
					});
				},
				timeout: 3000
			});
		}
		else{
			$(".clear_search_box").hide();
			$(".search_medicine_result").html("");
		}
	}
}

function page_up_down_arrow(new_i)
{
	$('.hover_'+new_i).keypress(function (e) {
		 if (e.which == 13) {
			$('.get_single_medicine_info_'+new_i).click();
		 } 						 
	 });
	$('.hover_'+new_i).keydown(function(event) {
		if(event.key=="ArrowDown")
		{
			new_i = parseInt(new_i) + 1;
			page_up_down_arrow(new_i);
			$('.hover_'+new_i).attr("tabindex",-1).focus();
			return false;
		}
		if(event.key=="ArrowUp")
		{
			if(parseInt(new_i)==1)
			{
				$('.SearchMedicine_search_box').focus();
			}
			else
			{
				new_i = parseInt(new_i) - 1;
				page_up_down_arrow(new_i);
				$('.hover_'+new_i).attr("tabindex",-1).focus();
			}
			return false;
		}
	});
}

function add_new_medicine()
{
	clear_search_box();
	$(".select_medicine").focus();
	$(".background_blur").show();
	$(".clear_search_box").show();
}

function select_medicine_in_search_box(item_name,mrp,new_i_code)
{	
	new_i = $("._import_order_i").val();
	var your_item_name = $(".your_item_name_"+new_i).val();
	var your_item_mrp  = $(".your_item_mrp_"+new_i).val();
	var your_item_qty  = $(".your_item_qty_"+new_i).val();
	if(new_i!="")
	{
		item_name = atob(item_name); // ok check me 2021-05-18

		$.ajax({
			url: "<?= base_url(); ?>admin/manage_medicine_info2/select_medicine_in_search_box",
			type:"POST",
			/*dataType: 'html',*/
			data: {item_name:item_name,new_i_code:new_i_code,your_item_name:your_item_name},
			error: function(){
				swal("Medicine not changed");
			},
			success: function(data){
					$.each(data.items, function(i,item){	
					if (item)
					{
						if(item.response=="1")
						{
							setTimeout("import_order_dropdownbox('"+new_i+"')",200);
							$("._import_order_i").val('');
							swal("Medicine changed successfully", {
								icon: "success",
							});
						}
						else{
							swal("Medicine not changed");
						}
					} 
				});
			},
			timeout: 10000
		});
	}
	else{
		$(".new_import_page_item_name").val(item_name);
		$(".new_import_page_item_mrp").val(mrp);
		get_single_medicine_info(new_i_code);
	}
}

var js_i = "";
var js_j = "";
function add_new_row_import_order_page(item_name,mrp,item_qty)
{
	item_name = atob(item_name); // ok check me 2021-05-18
	mrp1 = parseFloat(mrp).toFixed(2);
	if(js_i=="")
	{
		js_i = parseInt("<?= $i; ?>");
		js_j = parseInt("<?= $j; ?>");
	}
	
	js_i++;
	js_j++;
	
	js1 = "javascript:Search_Another_Medicine_js('"+js_i+"')";
	js2 = "javascript:delete_suggest('"+js_i+"')";

	$(".tbody_row").append('<tr class="remove_css_'+js_i+'"><td>'+js_j+'<input type="hidden" value="'+item_name+'" class="your_item_name_'+js_i+'"><input type="hidden" value="'+mrp+'" class="your_item_mrp_'+js_i+'"><input type="hidden" value="'+item_qty+'" class="your_item_qty_'+js_i+'"></td><td class="import_order_td_'+js_i+'"><div class="row"><div class="col-sm-1"><img src="<?=base_url(); ?>img_v<?= constant('site_v') ?>/logo2.png" width="60px;" style="margin-top: 5px;" class="image_css_'+js_i+'" alt=""></div><div class="col-sm-11"><div class="row"><div class="col-sm-8"><span style="float:left;"><?= $myname;?> : <span class="import_order_title_1"> '+item_name+'</span> </span> <span style="float:left; margin-left:10px;margin-right:10px;" class="import_order_mrp"> | </span> <span style="float:left;"><a href="javascript:void(0)" onclick="remove_row('+js_i+')" title="Delete medicine" class="delete_all"> <img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete medicine"> Delete medicine</a> </span> </div> <div class="col-sm-4 text-right"> <span style="float:right;"> <div class="import_order_mrp">MRP. : <i class="fa fa-inr" aria-hidden="true"></i> '+mrp1+'/-</div> </span> <span style="float:right; margin-left:10px;margin-right:10px;" class="import_order_mrp"> | </span> <span style="float:right;"> <input type="number" name="item_qty[]" value="'+item_qty+'" class="form-control item_qty_'+js_i+'" style="width: 50px;height: 30px;font-size: 12px;padding: 3px;" onchange="change_item_qty('+js_i+')" min="1" max="1000" /> </span> <span style="float:right;margin-right:5px;" class="import_order_mrp"> Order quantity : </span> </div> <div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div> </div> <div class="row select_product_'+js_i+'" style="display:none"> <div class="col-sm-8"> DRD :  <span class="import_order_title selected_item_name_'+js_i+'"></span> <span class="import_order_packing"> (<span class="selected_packing_'+js_i+'"></span> Packing) </span> - <span class="import_order_expiry expiry_css_'+js_i+'"> Expiry : <span class="selected_expiry_'+js_i+'"></span></span> </div> <div class="col-sm-4 text-right"> <span class="import_order_stock"> Stock : <span class="selected_batchqty_'+js_i+'"></span></span> | <span class="import_order_mrp"> MRP. : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_mrp_'+js_i+'">0.00</span>/- </span> </div>	<div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div> <div class="col-sm-7"> <span class="import_order_company"> By : <span class="selected_company_full_name_'+js_i+'"></span></span> |  <span class="import_order_batch_no"> Batch No : <span class="selected_batch_no_'+js_i+'"></span></span> <span class="select_product_'+js_i+' selected_scheme_span_'+js_i+'"> |  <span class="import_order_scheme selected_scheme_'+js_i+'"></span> </span> </div> <div class="col-sm-5 text-right"> <span class="import_order_ptr"> PTR : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_sale_rate_'+js_i+'">0.00</span>/-</span> | <span class="import_order_landing_price"> ~ Landing price : <i class="fa fa-inr" aria-hidden="true"></i> <span class="selected_final_price_'+js_i+'">0.00</span>/-</span> </div> </div> </div> <div class="col-sm-12" style=" border-top-style: solid;border-top-color: #dee2e6;border-top-width: 1px;"></div> <div class="col-sm-12"> <span class="selected_msg_'+js_i+'"> Loading.... </span> <span class="selected_SearchAnotherMedicine_'+js_i+'" style="display:none">  | <a href="'+js1+'" class="delete_all" title="Change medicine"> <img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/edit_icon.png" width="18px;" alt="Change medicine"> Change medicine </a> </span> <span class="selected_suggest_'+js_i+'" style="display:none"> | <a href="'+js2+'" title="Delete Suggest Medicine" class="delete_all"><img src="<?= base_url(); ?>img_v<?= constant('site_v') ?>/delete_icon.png" width="18px;" alt="Delete Suggest Medicine">Delete Suggest Medicine</a> </span> </div> </div> <span class="import_order_dropdownbox_'+js_i+'"></span> </td> </tr>');

	setTimeout("import_order_dropdownbox('"+js_i+"','"+item_name+"','"+mrp+"','"+item_qty+"')",1000);
}
function show_big_img_div(id) {
	$(".save_id").val(id)
	
	css_old_img_01 = "<?=constant('img_url_site')?>"+$(".css_old_img_01_"+id).val()
	css_old_img_02 = "<?=constant('img_url_site')?>"+$(".css_old_img_02_"+id).val()
	css_old_img_03 = "<?=constant('img_url_site')?>"+$(".css_old_img_03_"+id).val()
	css_old_img_04 = "<?=constant('img_url_site')?>"+$(".css_old_img_04_"+id).val()
	
	$(".big_img_m").attr("src",css_old_img_01)
	$(".old_img_01").attr("src",css_old_img_01)
	$(".old_img_02").attr("src",css_old_img_02)
	$(".old_img_03").attr("src",css_old_img_03)
	$(".old_img_04").attr("src",css_old_img_04)
	
	css_new_img_01 = "<?=constant('img_url_site')?>"+$(".css_new_img_01_"+id).val()
	css_new_img_02 = "<?=constant('img_url_site')?>"+$(".css_new_img_02_"+id).val()
	css_new_img_03 = "<?=constant('img_url_site')?>"+$(".css_new_img_03_"+id).val()
	css_new_img_04 = "<?=constant('img_url_site')?>"+$(".css_new_img_04_"+id).val()
	
	$(".new_img_01").attr("src",css_new_img_01)
	$(".new_img_02").attr("src",css_new_img_02)
	$(".new_img_03").attr("src",css_new_img_03)
	$(".new_img_04").attr("src",css_new_img_04)
	
	$(".big_img_div").show()
}
function bigImg(x) {
  $(".big_img_m").attr("src",x.src)
}	
function close_big_img_div() {
  $(".big_img_div").hide()
}

function copy_old_image() {
  $(".big_img_div").hide()
  
  id = $(".save_id").val()
  css_new_img_01 = $(".css_old_img_01_"+id).val()
  css_new_img_02 = $(".css_old_img_02_"+id).val()
  css_new_img_03 = $(".css_old_img_03_"+id).val()
  css_new_img_04 = $(".css_old_img_04_"+id).val()
  
  
  $(".new_image_css_"+id).attr("src","<?=constant('img_url_site')?>"+css_new_img_01)
  
  css_new_img_01 = css_new_img_01.replace("<?=constant('img_url_site')?>", "");
  css_new_img_02 = css_new_img_02.replace("<?=constant('img_url_site')?>", "");
  css_new_img_03 = css_new_img_03.replace("<?=constant('img_url_site')?>", "");
  css_new_img_04 = css_new_img_04.replace("<?=constant('img_url_site')?>", "");
  $(".css_new_img_01_"+id).val(css_new_img_01)
  $(".css_new_img_02_"+id).val(css_new_img_02)
  $(".css_new_img_03_"+id).val(css_new_img_03)
  $(".css_new_img_04_"+id).val(css_new_img_04)
  
  $.ajax({
		url: "<?= base_url(); ?>admin/manage_medicine_info2/update_copy_old_image",
		type:"POST",
		/*dataType: 'html',*/
		data: {id:id,css_new_img_01:css_new_img_01,css_new_img_02:css_new_img_02,css_new_img_03:css_new_img_03,css_new_img_04:css_new_img_04},
		error: function(){
			swal("Medicine image not changed");
		},
		success: function(data){
				$.each(data.items, function(i,item){	
				if (item)
				{
					if(item.response=="1")
					{
						swal("Medicine image changed successfully", {
							icon: "success",
						});
					}
					else{
						swal("Medicine image not changed");
					}
				} 
			});
		},
		timeout: 10000
	});
}

function show_big_des_div(id) {
  $(".big_des_div").show()
  
  old_description1 = $(".css_old_description1_"+id).val()
  old_description2 = $(".css_old_description2_"+id).val()
  $(".old_description1").val(old_description1)
  $(".old_description2").val(old_description2)
  
  new_description1 = $(".css_new_description1_"+id).val()
  new_description2 = $(".css_new_description2_"+id).val()
  $(".new_description1").val(new_description1)
  $(".new_description2").val(new_description2)
  
  $(".save_id").val(id)
}

function copy_old_description() {
  
  old_description1 = $(".old_description1").val()
  old_description2 = $(".old_description2").val()
  
  $(".new_description1").val(old_description1)
  $(".new_description2").val(old_description2)
}

function close_big_des_div() {
  $(".big_des_div").hide()
}

function save_big_des_div() {
  $(".big_des_div").hide()
  
  id = $(".save_id").val()
  new_description1 = $(".new_description1").val()
  new_description2 = $(".new_description2").val()
  
  $(".css_new_description1_"+id).val(new_description1)
  $(".css_new_description2_"+id).val(new_description2)
  $.ajax({
		url: "<?= base_url(); ?>admin/manage_medicine_info2/update_description",
		type:"POST",
		/*dataType: 'html',*/
		data: {id:id,new_description1:new_description1,new_description2:new_description2},
		error: function(){
			swal("Medicine description not changed");
		},
		success: function(data){
				$.each(data.items, function(i,item){	
				if (item)
				{
					if(item.response=="1")
					{
						swal("Medicine description changed successfully", {
							icon: "success",
						});
					}
					else{
						swal("Medicine description not changed");
					}
				} 
			});
		},
		timeout: 10000
	});
}
</script>
<div class="row">
	<div class="col-sm-12 col-12">
<!-- The Modal -->
<div class="big_img_div" style="width: 600px;position: fixed;z-index: 1;top: 20px;display:none;background: white;">
<img src="" class="big_img_m" style="width:300px" />
<br>
Old Image
<br>
<img src="" class="old_img_01" onclick="bigImg(this)" style="width:50px" />
<img src="" class="old_img_02" onclick="bigImg(this)" style="width:50px" />
<img src="" class="old_img_03" onclick="bigImg(this)" style="width:50px" />
<img src="" class="old_img_04" onclick="bigImg(this)" style="width:50px" />
<br>
New Image
<br>
<img src="" class="new_img_01" onclick="bigImg(this)" style="width:50px" />
<img src="" class="new_img_02" onclick="bigImg(this)" style="width:50px" />
<img src="" class="new_img_03" onclick="bigImg(this)" style="width:50px" />
<img src="" class="new_img_04" onclick="bigImg(this)" style="width:50px" />
<a href="javascript:void(0)" onclick="copy_old_image()" style="float: left;width: 100%;height: 30px;background: white;text-align: center;">Copy old Image</a>
<a href="javascript:void(0)" onclick="close_big_img_div()" style="float: left;width: 100%;height: 30px;background: white;text-align: center;">Close</a>
</div>

<div class="big_des_div" style="width: 500px;position: fixed;z-index: 1;top: 20px;display:none;background: white;"><br><br>
Old Description<br>
<textarea class="old_description1" style="float: left;width: 100%;height: 30px;background: white;"></textarea>
<br><br>
<textarea class="old_description2" style="float: left;width: 100%;height: 70px;background: white;"></textarea><br><br>
New Description<br>
<textarea class="new_description1" style="float: left;width: 100%;height: 30px;background: white;"></textarea>
<br><br>
<textarea class="new_description2" style="float: left;width: 100%;height: 70px;background: white;"></textarea>
<input type="hidden" class="save_id">
<br><br>
<a href="javascript:void(0)" onclick="copy_old_description()" style="float: left;width: 100%;height: 30px;background: white;text-align: center;">Copy old description</a>
<a href="javascript:void(0)" onclick="save_big_des_div()" style="float: left;width: 100%;height: 30px;background: white;text-align: center;">Save exit</a>
<a href="javascript:void(0)" onclick="close_big_des_div()" style="float: left;width: 100%;height: 30px;background: white;text-align: center;">Exit</a>
</div></div></div>
<script src="<?= base_url(); ?>assets/website/select_css/chosen.jquery.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/website/select_css/init.js" type="text/javascript" charset="utf-8"></script>