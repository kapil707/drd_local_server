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
                            Select File
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
				<div class="col-sm-6">
					<div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Select Theme
                        </label>
                    </div>
                    <div class="col-sm-8">
						<select name="theme" id="theme" data-placeholder="Select Status" class="chosen-select" required="required">
							<option value="">
								Select Theme
							</option>
							<?php 
							$query = $this->db->query("select * from tbl_fonts_properties order by id asc")->result();
							foreach($query as $row) { ?>
							<option value="<?= $row->id; ?>">
								(<?= $row->id; ?>) <?= ($row->theme_name); ?>
							</option>
							<?php } ?>
						</select>
                       
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('theme'); ?>
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
							<input type="text" class="form-control" id="startdate" name="startdate" data-date-format="dd-MM-yyyy" autocomplete="off" value="<?= substr($row->start_date,0,-6); ?>" placeholder="Start Date">
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
							<input type="text" name="starttime" class="form-control" autocomplete="off" value="<?= substr($row->start_date,-5); ?>" placeholder="Start Time">
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
							<input type="text" class="form-control" id="enddate" name="enddate" data-date-format="dd-MM-yyyy" autocomplete="off" value="<?= substr($row->end_date,0,-6); ?>" placeholder="End Date">
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
							<input type="text" name="endtime" class="form-control" autocomplete="off" value="<?= substr($row->end_date,-5); ?>" placeholder="End Time">
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
			
			<div class="form-group">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Display
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="display" name="display" checked value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('display'); ?>
                        </span>
                    </div>
				</div>
				
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Show In Sec.
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" id="form-field-1" placeholder="Show In Sec." name="time_to_show" value="30" required="required" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('time_to_show'); ?>
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