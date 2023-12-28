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
        	<input type="hidden" name="old_photo" value="<?= $row->photo; ?>" />
            <input type="hidden" name="old_email" value="<?= $row->email; ?>" />
             <input type="hidden" name="old_password" value="<?= $row->password; ?>" />
            <div class="form-group">
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Name
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="form-field-1" placeholder="Name" name="name" value="<?= $row->name; ?>" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('name'); ?>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Email
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="form-field-1" placeholder="Email" name="email" value="<?= $row->email; ?>" required="required" disabled="disabled" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('email'); ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Photo
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="photo" name="photo" />
                    </div>
                    <div class="col-sm-2" id="imgchange">
                    	<img src="<?= $url_path ?><?= $row->image; ?>" class="img-responsive" />
                    	<?php if($row->image!="default.jpg") { ?>
                    	<Br /><a href="javascript:void(0)" onclick="delete_photo('<?= $row->id; ?>')"><i class="fa fa-remove"></i>Delete</a>
                        <?php } ?>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('photo'); ?>
                        </span>
                    </div>
              	</div>
          	</div>
            
            <div class="form-group">
           		<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Password
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" placeholder="Password" name="password" id="pwd-container3">
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('password'); ?>
                        </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Re-Password
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" placeholder="Re-Password" name="password1">
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('password1'); ?>
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
function delete_photo(id)
{
	if (confirm('Are you sure Delete?')) { 
	if(delete_rec1==0)
	{
		delete_rec1 = 1;
		$.ajax({
			type       : "POST",
			data       :  { id : id ,} ,
			url        : "<?= base_url()?>admin/dashboard/delete_photo",
			success    : function(data){
					if(data!="")
					{
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
</script>