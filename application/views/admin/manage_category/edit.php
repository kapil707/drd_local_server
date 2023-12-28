<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php
        foreach ($result as $row)
        { ?>
            <input type="hidden" class="old_image" name="old_image" value="<?= $row->image; ?>" />
			<div class="form-group">
           		<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Category
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control name1" id="form-field-1" placeholder="Category" name="category" value="<?= base64_decode($row->category); ?>" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('title'); ?>
                        </span>
                    </div>
					<div class="col-sm-4">
					</div>
                </div>
				
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Display
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="display" name="display" <?php if($row->display=="1") { ?> checked <?php } ?> />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('display'); ?>
                        </span>
                    </div>
				</div>
				
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Random Play
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="random_play" name="random_play" <?php if($row->random_play=="1") { ?> checked <?php } ?> />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('random_play'); ?>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Logo1
                        </label>
                    </div>
                    <div class="col-sm-8">
						<?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"Logo1"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="Logo1" name="Logo1" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('Logo1'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Logo2
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"Logo2"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="Logo2" name="Logo2" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('Logo2'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Logo3
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"Logo3"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="Logo3" name="Logo3" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('Logo3'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Logo4
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"Logo4"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="Logo4" name="Logo4" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('Logo4'); ?>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Logo5
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"Logo5"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="Logo5" name="Logo5" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('Logo5'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            DateTime
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"DateTime"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="DateTime" name="DateTime" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('DateTime'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Marquee1
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"Marquee1"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="Marquee1" name="Marquee1" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('Marquee1'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Marquee2
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"Marquee2"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="Marquee2" name="Marquee2" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('Marquee2'); ?>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            PlayingTime
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"PlayingTime"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="PlayingTime" name="PlayingTime" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('PlayingTime'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            PlayingTitle
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"PlayingTitle"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="PlayingTitle" name="PlayingTitle" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('PlayingTitle'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            FixText
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"FixText"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="FixText" name="FixText" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('FixText'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            VideoAds
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"VideoAds"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="VideoAds" name="VideoAds" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('VideoAds'); ?>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            ScrollingAds
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"ScrollingAds"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="ScrollingAds" name="ScrollingAds" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('ScrollingAds'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            LShapAds
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"LShapAds"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="LShapAds" name="LShapAds" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('LShapAds'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            CustomAds
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"CustomAds"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="CustomAds" name="CustomAds" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('CustomAds'); ?>
                        </span>
                    </div>
				</div>
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            BreakingNews
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"BreakingNews"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="BreakingNews" name="BreakingNews" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('BreakingNews'); ?>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-3">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            SchedulingVideo
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <?php $ok = $this->Scheme_Model->get_join_tbl_date($row->id,"SchedulingVideo"); ?>
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="SchedulingVideo" name="SchedulingVideo" <?php if($ok=="1") { ?> checked <?php } ?> value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('SchedulingVideo'); ?>
                        </span>
                    </div>
				</div>
			</div>
            
            <div class="space-4"></div>
            <br /><br />
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info" name="Submit">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <i class="ace-icon fa fa-undo bigger-110"></i>
                        Reset
                    </button>
                </div>
            </div>
            <?php } ?>
        </form>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
var delete_rec1 = 0;
function delete_photo(path,type_me)
{
	if (confirm('Are you sure Delete?')) { 
	if(delete_rec1==0)
	{
		delete_rec1 = 1;
		$.ajax({
			type       : "POST",
			data       :  { path : path , type_me : type_me ,} ,
			url        : "<?= base_url()?>admin/<?= $Page_name; ?>/delete_photo",
			success    : function(data){
					if(data!="")
					{
						$(".img_id_"+type_me).hide();
						$(".old_"+type_me).val('');
						java_alert_function("success","Photo Deleted");
						$('.url_error').html("Photo Deleted");
						
						java_alert_function("success","Delete Successfully");
						$("#imgchange").html('<img src="<?= $url_path ?>default.jpg" class="img-responsive" />');
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

//setTimeout('url_change()',1000);
function url_change()
{
	name = $(".name1").val();
	name = name.replace(/&/g,'and');
	name = name.trim(name).replace(/ /g,'-');
	name = encodeURI(name).replace(/[!\/\\#,+()$~%.'":*?<>{}]/g,'');
	$(".url1").html(name)
	$(".url").val(name)
	a_href_change(name)
}
function a_href_change(name)
{
	document.getElementById("url1").href= "<?= base_url(); ?>products/"+name+".html"; 
}

var error2 = 1;
function change_url()
{
	error2 = 0;
	disabled_submit_button();
	$('.url_error').html("");
	url1 = $('.url').val();
	
	name = url1;
	name = name.replace(/&/g,'and');
	name = name.trim(name).replace(/ /g,'-');
	name = encodeURI(name).replace(/[!\/\\#,+()$~%.'":*?<>{}]/g,'');
	$(".url1").html(name)
	$(".url").val(name)
	a_href_change(name)
	
	$.ajax({
	type       : "POST",
	data       :  { url1 : url1,id : '<?= $row->id; ?>',} ,
	url        : "<?= base_url()?>admin/<?= $Page_name?>/change_url",
	success    : function(data){
			if(data!="")
			{
				//java_alert_function("success","Delete Successfully");
				//$('.product_code_error').html("This Product SKU Already Taken");
				if(data=="Error")
				{
					java_alert_function("error","This Product Url Already Taken")
					$('.url_error').html("This Product Url Already Taken");
				}
				if(data=="ok")
				{
					java_alert_function("success","Product Url Ok");
					$('.url_error').html("Product Url Ok");
					error2 = 1;
					disabled_submit_button();
				}
			}					
			else
			{
				java_alert_function("error","Something Wrong")
				$('.url_error').html("Something Wrong");
			}
		}
	});
}

function disabled_submit_button()
{
	if(error2==1)
	{
		$(".submit_button").prop('disabled', false);
	}
	else
	{
		$(".submit_button").prop("disabled", true);
	}
}
</script>