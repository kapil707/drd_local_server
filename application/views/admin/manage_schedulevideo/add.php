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
                            Select Cetegory
                        </label>
                    </div>
                    <div class="col-sm-8">
						<select name="category_id" id="category_id" data-placeholder="Select Status" class="chosen-select" required="required">
							<option value="">
								Select Cetegory
							</option>
							<?php 
							$query = $this->db->query("select * from tbl_category where page_type='Movies' order by id desc")->result();
							foreach($query as $row) { ?>
							<option value="<?= $row->id; ?>">
								<?= base64_decode($row->category); ?>
							</option>
							<?php } ?>
						</select>
                       
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
                            Get File
                        </label>
                    </div>
                    <div class="col-sm-8">
						<select name="path" id="path" data-placeholder="Select Status" class="chosen-select" required="required">
							<?php
								//$dir    = 'D:/mov/';
								//$files1 = scandir($dir);
								$files1 = scandir($dir, 1);
								//print_r($files1);
							?>
							<option value="">
								Select File
							</option>
							<?php foreach($files1 as $row) { ?>
							<option value="<?= $row; ?>" <?php if(set_value('status')==1) { ?> selected <?php } ?>>
								<?= $row; ?>
							</option>
							<?php } ?>
						</select>
                       
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('name'); ?>
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