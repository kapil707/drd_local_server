<div class="row">
    <div class="col-xs-12" style="margin-bottom:5px;">
    	<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>            
        </a>
   	</div>
    <div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                    <tr>
                    	<th>
                        	Sno.
                        </th>
						<th>
                        	Name
                        </th>
                        <th>
                        	File Path
                        </th>
                        <th>
                        	Time
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
                        	<?= base64_decode($row->title); ?>
                        </td>
                        <td>
                        	<?= base64_decode($row->path); ?>
                        </td>
                        <td>
							<?= gmdate("H:i:s",$row->full_time); ?>
                        </td>
						<td class="text-right">
							<div class="btn-group">
								<a href="settime/<?= $row->id; ?>" class="btn-white btn btn-xs">Set Time
								</a>
								<?php if($count==0 && $count1==0) { ?>
								<a href="javascript:void(0)" onclick="delete_rec('<?= $row->id; ?>')" class="btn-white btn btn-xs">Delete</i> </a>
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
function delete_rec(id)
{
	if (confirm('Are you sure Delete?')) { 
	if(delete_rec1==0)
	{
		delete_rec1 = 1;
		$.ajax({
			type       : "POST",
			data       :  { id : id ,} ,
			url        : "<?= base_url()?>admin/<?= $Page_name; ?>/delete_rec",
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