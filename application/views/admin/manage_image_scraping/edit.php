<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link href="<?= constant('img_url_site'); ?>assets/website/css/style<?= constant('site_v') ?>.css" rel="stylesheet" type="text/css"/>

<div class="row">
	<div class="col-xs-12">
        <a href="<?php echo base_url(); ?>admin/<?= $Page_name ?>/view?table_name=<?= $_GET["table_name"]; ?>&pg=<?= $_GET["pg"]; ?>#row_<?=$id1 ?>">
		<button type="button" class="btn btn-w-m btn-info"><< Back</button>
		</a>
	</div>
    <div class="col-xs-12">
		<div class="row">
			<div class="col-sm-3">Search Another</div>
			<div class="col-sm-7 col-12">
				<input type="text" class="form-control SearchMedicine_search_box form-control" placeholder="<?= $msg_show?>" tabindex="1" placeholder="Search" style="border:1px solid #000000;">
			</div>
			<div class="col-sm-3"></div>
			<div class="col-sm-7 col-12">
				<div class="search_medicine_result searchpagescrolling2" style="margin-top:60px;"></div>
			</div>
		</div>
		<hr>
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php
        foreach ($result as $row)
        {
            ?>
            <input type="hidden" name="old_image1" value="<?= $row->image1?>"/>
            <input type="hidden" name="old_image2" value="<?= $row->image2?>"/>
            <input type="hidden" name="old_image3" value="<?= $row->image3?>"/>
            <input type="hidden" name="old_image4" value="<?= $row->image4?>"/>
			<input type="hidden" name="old_update_image1" value="<?= $row->update_image1?>"/>
            <input type="hidden" name="old_update_image2" value="<?= $row->update_image2?>"/>
            <input type="hidden" name="old_update_image3" value="<?= $row->update_image3?>"/>
            <input type="hidden" name="old_update_image4" value="<?= $row->update_image4?>"/>
            <?php
			$url = constant('img_url_site').$row->image1;
			$img1 = $url;
			if($row->update_image1==1)
			{
				$img1 = $url_path.$row->image1;
			}
			
			$url = constant('img_url_site').$row->image2;
			$img2 = $url;
			if($row->update_image2==1)
			{
				$img2 = $url_path.$row->image2;
			}
			
			$url = constant('img_url_site').$row->image3;
			$img3 = $url;
			if($row->update_image3==1)
			{
				$img3 = $url_path.$row->image3;
			}
			
			$url = constant('img_url_site').$row->image4;
			$img4 = $url;
			if($row->update_image4==1)
			{
				$img4 = $url_path.$row->image4;
			}			
			?>
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                        Medicine Name
                        <br>
                        Essysol Name
                        </label>
                    </div>
                    <div class="col-sm-6">
                       <?= ($row->selected_item_name); ?>
						<br>
						<?= ($row->item_name); ?>
				</div>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Title
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="itemintro1" name="itemintro1" placeholder="Title" value="<?= $row->itemintro1; ?>" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('itemintro1'); ?>
                        </span>
                    </div>
              	</div>
            </div>
           	<div class="form-group">
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="image" name="image" />
                    </div>
                    <div class="col-sm-2 img_id_image">
                    	<img src="<?= $img1; ?>" class="img-responsive" alt />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('image'); ?>
                        </span>
                    </div>
              	</div>
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image2
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="Image2" name="image2" />
                    </div>
                    <div class="col-sm-2 img_id_image">
                    	<img src="<?= $img2; ?>" class="img-responsive" alt />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('image2'); ?>
                        </span>
                    </div>
              	</div>
			</div>
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image3
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="Image3" name="image3" />
                    </div>
                    <div class="col-sm-2 img_id_image">
                    	<img src="<?= $img3; ?>" class="img-responsive" alt />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('imag3'); ?>
                        </span>
                    </div>
              	</div>
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image4
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="Image4" name="image4" />
                    </div>
                    <div class="col-sm-2 img_id_image">
                    	<img src="<?= $img4; ?>" class="img-responsive" alt />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('image4'); ?>
                        </span>
                    </div>
              	</div>                
			</div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            Description
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control" id="form-field-1" placeholder="Description" name="itemintro2" value=""><?= $row->itemintro2; ?></textarea>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('itemintro2'); ?>
                        </span>
                    </div>
                </div>            
			</div>
            <div class="form-group">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Featured
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="featured" id="featured" class="form-control">
							<option value="1" <?php if($row->featured==1) { ?> selected <?php } ?>>
								Yes
							</option>
							<option value="0" <?php if($row->featured==0) { ?> selected <?php } ?>>
								No
							</option>
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('featured'); ?>
                        </span>
                    </div>
                </div>
			</div>
            
            <div class="space-4"></div>
            <br /><br />
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info" name="Submit">
                        <em class="ace-icon fa fa-check bigger-110"></em>
                        Submit
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <em class="ace-icon fa fa-undo bigger-110"></em>
                        Reset
                    </button>
                </div>
            </div>
            <?php } ?>
        </form>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
<input type="hidden" class="_import_order_i">
<div class="background_blur" onclick="clear_search_box()" style="display:none"></div>
<div class="script_css"></div>
<script>
var delete_rec1 = 0;
function delete_photo(id)
{
	if (confirm('Are you sure Delete?')) { 
	if(delete_rec1==0)
	{
		delete_rec1 = 1;
		$.ajax({
			type       : "POST",
			data       :  { id : id ,} ,
			url        : "<?= base_url()?>admin/<?= $Page_name; ?>/delete_photo",
			success    : function(data){
					if(data!="")
					{
						java_alert_function("success","Delete Successfully");
						$("#row_"+id).hide("500");
					}					
					else
					{
						java_alert_function("error","Something Wrong")
					}
					delete_rec1 = 0;
				}
			});
		}
	}
}
</script>
<script>
function call_search_item()
{	
	item_name = $("#item_name").val();
	$(".call_search_item_result").html("Loading....");
	if(item_name=="")
	{
		$(".call_search_item_result").html("");
	}
	else
	{
		$.ajax({
		type       : "POST",
		data       :  {item_name:item_name},
		url        : "<?= base_url()?>admin/<?= $Page_name?>/call_search_item",
		cache	   : false,
		success    : function(data){
			$(".call_search_item_result").html(data);
			}
		});
	}
}
function additem(i_code,name)
{
	name = atob(name);
	$("#i_code").val(i_code);
	$("#item_name").val(name);
	$(".call_search_item_result").html("");
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

function select_medicine_in_search_box(item_name,mrp,new_i_code)
{	
	id = '<?php echo $id; ?>'
	if(id!="")
	{
		item_name = atob(item_name); // ok check me 2021-05-18

		$.ajax({
			url: "<?= base_url(); ?>admin/manage_image_scraping/select_medicine_in_search_box1",
			type:"POST",
			/*dataType: 'html',*/
			data: {item_name:item_name,new_i_code:new_i_code,id:id},
			error: function(){
				swal("Medicine not changed");
			},
			success: function(data){
					$.each(data.items, function(i,item){	
					if (item)
					{
						if(item.response=="1")
						{
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

</script>