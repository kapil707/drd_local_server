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
                            Select Category
                        </label>
                    </div>
                    <div class="col-sm-8">
						<select name="category_id" id="category_id" data-placeholder="Select Status" class="chosen-select">
							<option value="0">
								Select All
							</option>
							<?php 
							$query = $this->db->query("select * from tbl_category order by id asc")->result();
							foreach($query as $row) { ?>
							<option value="<?= $row->id; ?>">
								<?= base64_decode($row->category); ?>
							</option>
							<?php } ?>
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
                        	Category
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
                        	<?php 
							if($row->category_id=="0") 
							{ 
								echo "Select All";
							} else { 
								$query = $this->db->query("select * from tbl_category where id='$row->category_id'")->row();
								echo base64_decode($query->category);
							} ?>
                        </td>
						<td class="text-right">
							<div class="btn-group">
								<a href="javascript:void(0)" onclick="delete_category_copy_rec('<?= $row->id; ?>')" class="btn-white btn btn-xs">Delete</i> </a>
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
function delete_category_copy_rec(id)
{
	if (confirm('Are you sure Delete?')) { 
	if(delete_rec1==0)
	{
		delete_rec1 = 1;
		$.ajax({
			type       : "POST",
			data       :  { id : id ,} ,
			url        : "<?= base_url()?>admin/<?= $Page_name; ?>/delete_category_copy_rec",
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