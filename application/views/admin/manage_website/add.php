<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        	<input type="hidden" name="old_mydata" value="<?php echo $mydata; ?>">
        	<input type="hidden" name="type" value="<?php echo $type; ?>">
           	<div class="form-group">
           		<div class="col-sm-12">
                    <div class="col-sm-3 text-right">
                        <label class="control-label" for="form-field-1">
                            <?php echo $titlepg ?>
                        </label>
                    </div>
                    	<?php
						if($type=="text") { ?>
                        <div class="col-sm-9">
                        <textarea type="text" class="form-control" id="form-field-1" placeholder="<?php echo $titlepg ?>" name="mydata" required="required"><?php echo $mydata; ?></textarea>
                        </div>
                        <?php } 
						if($type=="image") { ?>
                        
                        <div class="col-sm-5">
                            <div class="fileinput fileinput-new input-group" data-provides="fileinput">
                                <div class="form-control" data-trigger="fileinput">
                                    <i class="glyphicon glyphicon-file fileinput-exists"></i>
                                <span class="fileinput-filename"></span>
                                </div>
                                <span class="input-group-addon btn btn-default btn-file">
                                    <span class="fileinput-new">Select file</span>
                                    <span class="fileinput-exists">Change</span>
                                    <input type="file" name="image" required="required" />
                                </span>
                                <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                        <div class="col-sm-4">
                        	<?php
							if($mydata!="")
							{
								?>
                        			<img src="<?= $url_path?><?= $mydata?>" class="img-responsive" />
                         		<?php 
							}
							?>
                        </div>
						<?php
                        }?>
                        <div class="col-sm-12">
                        	<div class="col-sm-3">
                            </div>
                            <div class="col-sm-9">
                                <label class="control-label" for="form-field-1">
                                    <?php echo $pagetextpg ?>
                                </label>
                            </div>
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
        </form>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->