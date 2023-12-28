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
                        <input type="text" class="form-control name1" id="form-field-1" placeholder="Name" name="name" value="<?= set_value('name'); ?>" required="required" />
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
                            Url
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="text" class="form-control url" id="form-field-1" placeholder="url" name="url" value="<?= $row->url; ?>" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('url'); ?>
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
                        <input type="file" class="form-control" id="form-field-1" placeholder="image" name="image" />
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
            	<div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            Description
                        </label>
                    </div>
                    <div class="col-sm-10">
                        <textarea type="text" class="form-control" id="form-field-1" placeholder="Description" name="description" style="height:100px"><?= set_value('description'); ?></textarea>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('description'); ?>
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