start_date<div class="row">
	<div class="col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                    <tr>
						<th>
                        	Name
                        </th>
                        <th>
                        	Email
                        </th>
                         <th>
                        	User Type
                        </th>
                        <th>
                        	Select Date
                        </th>
                        <th>
                        	Search
                        </th>
                    </tr>
                </thead>

                <tbody>
                <?php
				$query = $this->db->query("select * from tbl_user order by id desc");
				$result = $query->result();
                foreach ($result as $row)
                {
						?>
                    <tr>
 						<td>
                        	<?= $row->name; ?>
                        </td>
                        <td>
                            <?= $row->email; ?>
                        </td>   
                        <td>
							<?php
							$user_type = $row->user_type;
                            $query = $this->db->query("select * from tbl_user_type where user_type='$user_type'");
                            $row1 = $query->row();
                            echo $row1->user_title; 
							?>
                        </td>            
                        <td>
                        	<div class="form-group" id="data_5">
                                <div class="input-daterange input-group" id="datepicker">
                                    <input type="text" class="input-sm form-control" id="start_date" value="<?= date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy" />
                                    <span class="input-group-addon">to</span>
                                    <input type="text" class="input-sm form-control" id="end_date" value="<?= date("d-m-Y"); ?>" data-date-format="dd-mm-yyyy" />
                                </div>
                            </div>
                        </td>
                        <td>
                        	<button type="button" class="btn btn-w-m btn-info" onclick="Activities('<?php echo $row->id; ?>');">Activities</button>
                        </td>
                    </tr>
                    </form>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>    
</div>
<script>
function Activities(id)
{
	var start_date = $("#start_date").val();
	var end_date = $("#end_date").val();
	window.location.href = "<?= base_url()?>admin/activity_log/history?start_date="+start_date+"&end_date="+end_date+"&user_id="+id+"";
}
</script>