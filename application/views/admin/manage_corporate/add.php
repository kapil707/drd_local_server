<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
			<div class="form-group">			
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Name
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="form-field-1" placeholder="Name" name="name" value="<?= set_value('name'); ?>" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('name'); ?>
                        </span>
                    </div>
                </div>
          	</div>               
            
			<div class="form-group">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Status
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="status" id="status" data-placeholder="Select Status" class="chosen-select" >
							<option value="1" <?php if(set_value('status')==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if(set_value('status')==0) { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('status'); ?>
                        </span>
                    </div>
                </div>
			</div>
             
            <div class="space-4"></div>
            <br /><br />
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info submit_button" name="Submit">
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
        </form>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
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