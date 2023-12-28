<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
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
							<input type="text" name="endtime" class="form-control" autocomplete="off" value="<?= substr($row->end_date,-5); ?>"   placeholder="End Time" data-mask="99:99">
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
				<div class="col-sm-4">
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
				
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Shuduling Display
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="shuduling_display" name="shuduling_display" value="1" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('shuduling_display'); ?>
                        </span>
                    </div>
				</div>
				
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Sunday
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="week1" name="week1" checked />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('week1'); ?>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="form-group">	
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Monday
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="week2" name="week2" checked />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('week2'); ?>
                        </span>
                    </div>
				</div>
				
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Tuesday
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="week2" name="week2" checked />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('week2'); ?>
                        </span>
                    </div>
				</div>
				
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Wednesday
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="week2" name="week2" checked />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('week2'); ?>
                        </span>
                    </div>
				</div>
			</div>
			
			<div class="form-group">	
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Thursday
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="week2" name="week2" checked />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('week2'); ?>
                        </span>
                    </div>
				</div>
				
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Friday
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="week2" name="week2" checked />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('week2'); ?>
                        </span>
                    </div>
				</div>
				
				<div class="col-sm-4">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Saturday
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="checkbox" class="form-control" id="form-field-1" placeholder="week2" name="week2" checked />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('week2'); ?>
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
	<div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                    <tr>
                    	<th>
                        	Sno.
                        </th>
                        <th>
                        	Start Date / Time
                        </th>
						<th>
                        	End Date / Time
                        </th>
                        <th>
                        	Action
                        </th>
                    </tr>
                </thead>

                <tbody>
                <?php
				$i=1;
                foreach ($result as $row)
                {
					?>
                    <tr id="row_<?= $row->id; ?>">
                    	<td>
                        	<?= $i++; ?>
                        </td>
                        <td>
                        	<?= ($row->start_date); ?>
							<?= ($row->start_time); ?>
                        </td>
 						<td>
                        	<?= ($row->end_date); ?>
							<?= ($row->end_time); ?>
                        </td>
						<td class="text-right">
							<div class="btn-group">
								<?php if($count==0 && $count1==0) { ?>
								<a href="javascript:void(0)" onclick="delete_new_rec('<?= $row->id; ?>')" class="btn-white btn btn-xs">Delete</i> </a>
								<?php } ?>
							</div>
                        </td> 
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
var delete_rec1 = 0;
function delete_new_rec(id)
{
	if (confirm('Are you sure Delete?')) { 
	if(delete_rec1==0)
	{
		delete_rec1 = 1;
		$.ajax({
			type       : "POST",
			data       :  { id : id ,} ,
			url        : "<?= base_url()?>admin/<?= $Page_name; ?>/delete_new_rec",
			success    : function(data){
					if(data!="")
					{
						java_alert_function("success","Delete Successfully");
						$("#row_"+id).hide("500");
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