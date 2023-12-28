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
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Title
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control name1" id="form-field-1" placeholder="Title" name="title" value="<?= base64_decode($row->title); ?>" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('title'); ?>
                        </span>
                    </div>
					<div class="col-sm-4">
					</div>
                </div>
			</div>
			
			<div class="form-group">	
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Marqee Text
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control url" id="form-field-1" placeholder="Marqee Text" name="marqee_text" value="" required="required"><?= base64_decode($row->marqee_text); ?></textarea>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('marqee_text'); ?>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="form-group" id="data_5">
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Start Date
                        </label>
                    </div>
                    <div class="col-sm-8">
						<div class="input-daterange input-group" id="datepicker">
							<input type="text" class="form-control" id="startdate" name="startdate" data-date-format="dd-MM-yyyy" autocomplete="off" value="<?= substr($row->start_date,0,-6); ?>" placeholder="Start Date" data-mask="<?= date("d-F-Y"); ?>">
						</div>
					</div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('startdate'); ?>
                        </span>
                    </div>
					<div class="col-sm-4">
					</div>
                </div>
				
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Start Time
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group clockpicker" data-autoclose="true">
							<input type="text" name="starttime" class="form-control" autocomplete="off" value="<?= substr($row->start_date,-5); ?>" placeholder="Start Time" data-mask="99:99">
							<span class="input-group-addon">
								<span class="fa fa-clock-o"></span>
							</span>
						</div>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('title'); ?>
                        </span>
                    </div>
					<div class="col-sm-4">
					</div>
                </div>
			</div>
			
			<div class="form-group" id="data_5">
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            End Date
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-daterange input-group" id="datepicker">
							<input type="text" class="form-control" id="enddate" name="enddate" data-date-format="dd-MM-yyyy" autocomplete="off" value="<?= substr($row->end_date,0,-6); ?>" placeholder="End Date" data-mask="<?= date("d-F-Y"); ?>">
						</div>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('enddate'); ?>
                        </span>
                    </div>
					<div class="col-sm-4">
					</div>
                </div>
				
				<div class="col-sm-6" id="data_5">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            End Time
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <div class="input-group clockpicker" data-autoclose="true">
							<input type="text" name="endtime" class="form-control" autocomplete="off" value="<?= substr($row->end_date,-5); ?>" placeholder="End Time" data-mask="99:99">
							<span class="input-group-addon">
								<span class="fa fa-clock-o"></span>
							</span>
						</div>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('endtime'); ?>
                        </span>
                    </div>
					<div class="col-sm-4">
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