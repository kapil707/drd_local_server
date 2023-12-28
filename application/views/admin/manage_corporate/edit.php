<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">		<?php
        foreach ($result as $row)
        { ?>
        	<input type="hidden" name="old_exp_date" value="<?= $row->exp_date; ?>" />
            <div class="form-group" id="data_5">
           		<div class="col-sm-4">
                    <div class="col-sm-12">
                        <label class="control-label" for="form-field-1">
                            Login Expired
                        </label>
                    </div>
                    <div class="col-sm-12">
						<div class="input-daterange input-group" id="datepicker">
                        <input type="text" class="form-control" id="exp_date" name="exp_date" value="<?= date("d-F-Y", strtotime($row->exp_date)); ?>" data-date-format="dd-MM-yyyy" />
						</div>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('exp_date'); ?>
                        </span>
                    </div>
					<div class="col-sm-4">
					</div>
                </div>

				<div class="col-sm-4">
                    <div class="col-sm-12">
                        <label class="control-label" for="form-field-1">
                            Status
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <select name="status" id="status" data-placeholder="Select Status" class="chosen-select">
							<option value="1" <?php if($row->status==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->status==0) { ?> selected <?php } ?>>
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

				<div class="col-sm-4">
                    <div class="col-sm-12">
                        <label class="control-label" for="form-field-1">
                            Whatsapp Message
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <select name="whatsapp_message" id="whatsapp_message" data-placeholder="Select Whatsapp Message" class="chosen-select">
							<option value="1" <?php if($row->whatsapp_message==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->whatsapp_message==0) { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle"> 
                            <?= form_error('whatsapp_message'); ?>
                        </span>
                    </div>
                </div>
          	</div>						<div class="form-group">				<div class="col-sm-4">                    <div class="col-sm-12">                        <label class="control-label" for="form-field-1">                            Item Wise Report                        </label>                    </div>                    <div class="col-sm-12">                        <select name="item_wise_report" id="item_wise_report" data-placeholder="Select Item Wise Report" class="chosen-select">							<option value="1" <?php if($row->item_wise_report==1) { ?> selected <?php } ?>>								Active							</option>							<option value="0" <?php if($row->item_wise_report==0) { ?> selected <?php } ?>>								Inactive							</option>						</select>                    </div>                    <div class="help-inline col-sm-12 has-error">                        <span class="help-block reset middle">                             <?= form_error('item_wise_report'); ?>                        </span>                    </div>                </div>
								<div class="col-sm-4">                    <div class="col-sm-12">                        <label class="control-label" for="form-field-1">                            Chemist Wise Report                        </label>                    </div>                    <div class="col-sm-12">                        <select name="chemist_wise_report" id="chemist_wise_report" data-placeholder="Select Chemist Wise Report" class="chosen-select">							<option value="1" <?php if($row->chemist_wise_report==1) { ?> selected <?php } ?>>								Active							</option>							<option value="0" <?php if($row->chemist_wise_report==0) { ?> selected <?php } ?>>								Inactive							</option>						</select>                    </div>                    <div class="help-inline col-sm-12 has-error">                        <span class="help-block reset middle">                             <?= form_error('chemist_wise_report'); ?>                        </span>                    </div>                </div>	
				
				<div class="col-sm-4">
                    <div class="col-sm-12">
                        <label class="control-label" for="form-field-1">
                            Stock And Sales Analysis
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <select name="stock_and_sales_analysis" id="stock_and_sales_analysis" data-placeholder="Select Stock And Sales Analysis" class="chosen-select">
							<option value="1" <?php if($row->stock_and_sales_analysis==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->stock_and_sales_analysis==0) { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle"> 
                            <?= form_error('stock_and_sales_analysis'); ?>
                        </span>
                    </div>
                </div>	
			</div>

			<div class="form-group">
				<div class="col-sm-4">
                    <div class="col-sm-12">
                        <label class="control-label" for="form-field-1">
                            Item Wise Report Daily Email
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <select name="item_wise_report_daily_email" id="item_wise_report_daily_email" data-placeholder="Select Item Wise Report Daily Email" class="chosen-select">
							<option value="1" <?php if($row->item_wise_report_daily_email==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->item_wise_report_daily_email==0) { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>

                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('item_wise_report_daily_email'); ?>
                        </span>
                    </div>
                </div>								<div class="col-sm-4">                    <div class="col-sm-12">                        <label class="control-label" for="form-field-1">                            Chemist Wise Report Daily Email                        </label>                    </div>                    <div class="col-sm-12">                        <select name="chemist_wise_report_daily_email" id="chemist_wise_report_daily_email" data-placeholder="Select Chemist Wise Report Daily Email" class="chosen-select">							<option value="1" <?php if($row->chemist_wise_report_daily_email==1) { ?> selected <?php } ?>>								Active							</option>							<option value="0" <?php if($row->chemist_wise_report_daily_email==0) { ?> selected <?php } ?>>								Inactive							</option>						</select>                    </div>                    <div class="help-inline col-sm-12 has-error">                        <span class="help-block reset middle">                              <?= form_error('chemist_wise_report_daily_email'); ?>                        </span>                    </div>                </div>
								<div class="col-sm-4">                    <div class="col-sm-12">                        <label class="control-label" for="form-field-1">                            Stock And Sales Analysis Daily Email                        </label>                    </div>                    <div class="col-sm-12">                        <select name="stock_and_sales_analysis_daily_email" id="stock_and_sales_analysis_daily_email" data-placeholder="Select Stock And Sales Analysis Daily Email" class="chosen-select">							<option value="1" <?php if($row->stock_and_sales_analysis_daily_email==1) { ?> selected <?php } ?>>								Active							</option>							<option value="0" <?php if($row->stock_and_sales_analysis_daily_email==0) { ?> selected <?php } ?>>								Inactive							</option>						</select>                    </div>                    <div class="help-inline col-sm-12 has-error">                        <span class="help-block reset middle">                              <?= form_error('stock_and_sales_analysis_daily_email'); ?>                        </span>                    </div>                </div>			</div>
			
			<div class="form-group">
				<div class="col-sm-4">
                    <div class="col-sm-12">
                        <label class="control-label" for="form-field-1">
                            Item Wise Report Monthly Email
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <select name="item_wise_report_monthly_email" id="item_wise_report_monthly_email" data-placeholder="Select Item Wise Report Monthly Email" class="chosen-select">
							<option value="1" <?php if($row->item_wise_report_monthly_email==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->item_wise_report_monthly_email==0) { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>

                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('item_wise_report_monthly_email'); ?>
                        </span>
                    </div>
                </div>				

				<div class="col-sm-4">
                    <div class="col-sm-12">
                        <label class="control-label" for="form-field-1">
                            Chemist Wise Report Monthly Email
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <select name="chemist_wise_report_monthly_email" id="chemist_wise_report_monthly_email" data-placeholder="Select Chemist Wise Report Monthly Email" class="chosen-select">
							<option value="1" <?php if($row->chemist_wise_report_monthly_email==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->chemist_wise_report_monthly_email==0) { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>

                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('chemist_wise_report_monthly_email'); ?>
                        </span>
                    </div>
                </div>
				
				<div class="col-sm-4">
                    <div class="col-sm-12">
                        <label class="control-label" for="form-field-1">
                            Stock And Sales Analysis Monthly Email
                        </label>
                    </div>
                    <div class="col-sm-12">
                        <select name="stock_and_sales_analysis_monthly_email" id="stock_and_sales_analysis_monthly_email" data-placeholder="Select Stock And Sales Analysis Monthly Email" class="chosen-select">
							<option value="1" <?php if($row->stock_and_sales_analysis_monthly_email==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->stock_and_sales_analysis_monthly_email==0) { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>

                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('stock_and_sales_analysis_monthly_email'); ?>
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
</div>