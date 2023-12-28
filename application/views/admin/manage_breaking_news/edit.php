<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
		<button type="button" class="btn btn-w-m btn-danger" onclick="deleteall();">Clear 
		All</button>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php
        foreach ($result as $row)
        { ?>
            <div class="form-group">
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Sec Gap
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="form-field-1" placeholder="Sec Gap" name="sec" value="<?= ($row->sec); ?>" min="10" max="60" />
                    </div>
                </div>
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            How Much Time To Show
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="form-field-1" placeholder="How Much Time To Show" name="howmuch" value="<?= ($row->howmuch); ?>" min="1" max="10" />
                    </div>
                </div>
			</div>
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 1 A
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news1a" id="form-field-1" placeholder="News 1 A" name="bk1" value="<?= base64_decode($row->bk1); ?>" />
                    </div>
					<div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news1a')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 1 B
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news1b" id="form-field-1" placeholder="News 1 B" name="bk2" value="<?= base64_decode($row->bk2); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news1b')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 1 C
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news1c" id="form-field-1" placeholder="News 1 C" name="bk3" value="<?= base64_decode($row->bk3); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news1c')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 2 A
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news2a" id="form-field-1" placeholder="News 2 A" name="bk4" value="<?= base64_decode($row->bk4); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news2a')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                           News 2 B
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news2b" id="form-field-1" placeholder="News 2 B" name="bk5" value="<?= base64_decode($row->bk5); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news2b')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                           News 2 C
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news2c" id="form-field-1" placeholder="News 2 C" name="bk6" value="<?= base64_decode($row->bk6); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single(news2c)" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 3 A
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news3a" id="form-field-1" placeholder="News 3 A" name="bk7" value="<?= base64_decode($row->bk7); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news3a')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 3 B
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news3b" id="form-field-1" placeholder="News 3 B" name="bk8" value="<?= base64_decode($row->bk8); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news3b')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 3 C
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news3c" id="form-field-1" placeholder="News 3 C" name="bk9" value="<?= base64_decode($row->bk9); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news3c')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 4 A
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news4a" id="form-field-1" placeholder="News 4 A" name="bk10" value="<?= base64_decode($row->bk10); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news4a')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 4 B
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news4b" id="form-field-1" placeholder="News 4 B" name="bk11" value="<?= base64_decode($row->bk11); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news4b')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 4 C
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news4c" id="form-field-1" placeholder="News 4 C" name="bk12" value="<?= base64_decode($row->bk12); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news4c')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 5 A
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news5a" id="form-field-1" placeholder="News 5 A" name="bk13" value="<?= base64_decode($row->bk13); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news5a')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 5 B
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news5b" id="form-field-1" placeholder="News 5 B" name="bk14" value="<?= base64_decode($row->bk14); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news5b')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
                    </div>
                </div>
			</div>
			
			<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            News 5 C
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control allnews news5c" id="form-field-1" placeholder="News 5 C" name="bk15" value="<?= base64_decode($row->bk15); ?>" />
                    </div>
                    <div class="col-sm-2">
						<a href="javascript:void(0)" onclick="delete_single('news5c')" class="btn-white btn btn-xs">
						<i class="fa fa-trash" aria-hidden="true"></i>
						</a>
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
                    <button type="button" class="btn btn-w-m btn-danger" onclick="deleteall();">Clear All</button>
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
function deleteall()
{
	$(".allnews").val("")
}
function delete_single(cls)
{
	$("."+cls).val("")
}
</script>