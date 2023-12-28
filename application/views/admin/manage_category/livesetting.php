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
				<div class="form-group">
					<div class="col-sm-6">
						<div class="col-sm-4 text-right">
							<label class="control-label" for="form-field-1">
								Type
							</label>
						</div>
					   <div class="col-sm-8">
							<select name="type" id="type" data-placeholder="Select Status" class="chosen-select" >
								<option value="1" <?php if($row->type==1) { ?> selected <?php } ?>>
									M3u8 / IP / RTSP - Networking
								</option>
								<option value="2" <?php if($row->type==2) { ?> selected <?php } ?>>
									M3u8 Online
								</option>
								<option value="3" <?php if($row->type==3) { ?> selected <?php } ?>>
									YouTube
								</option>
							</select>
						</div>
						<div class="help-inline col-sm-12 has-error">
							<span class="help-block reset middle">  
								<?= form_error('startdate'); ?>
							</span>
						</div>
						<div class="col-sm-4">
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="col-sm-4 text-right">
							<label class="control-label" for="form-field-1">
								Join To Direct Live
							</label>
						</div>
						<div class="col-sm-8">
							<?php $ok = $this->Scheme_Model->get_anywhere_live($row->category_id); ?>
							<input type="checkbox" class="form-control" id="form-field-1" placeholder="anywhere_live" name="anywhere_live" <?php if($ok=="1"){ ?> checked <?php } ?>value="1" />
						</div>
						<div class="help-inline col-sm-12 has-error">
							<span class="help-block reset middle">  
								<?= form_error('anywhere_live'); ?>
							</span>
						</div>
					</div>
				</div>
				
				<div class="form-group" id="data_5">
					<div class="col-sm-6">
						<div class="col-sm-4 text-right">
							<label class="control-label" for="form-field-1">
								IP Address
							</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="form-field-1" placeholder="IP Address" name="ip" value="<?= base64_decode($row->ip); ?>" required="required" />
						</div>
						<div class="help-inline col-sm-12 has-error">
							<span class="help-block reset middle">  
								<?= form_error('ip'); ?>
							</span>
						</div>
						<div class="col-sm-4">
						</div>
					</div>
					
					<div class="col-sm-6" id="data_5">
						<div class="col-sm-4 text-right">
							<label class="control-label" for="form-field-1">
								Ping IP
							</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="form-field-1" placeholder="IP Address" name="ping_ip" value="<?= base64_decode($row->ping_ip); ?>" />
						</div>
						<div class="help-inline col-sm-12 has-error">
							<span class="help-block reset middle">  
								<?= form_error('ping_ip'); ?>
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
			<?php } ?>
        </form>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div>