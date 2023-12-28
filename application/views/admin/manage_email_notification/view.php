<div class="row">
    <?php /*
	<div class="col-xs-12" style="margin-bottom:5px;">
		<a href="add">
            <button type="submit" class="btn btn-info">
                Add
            </button>
        </a>
   	</div> */ ?>
    <div class="col-xs-12">
         <div class="table-responsive">
			Total Records : <?php echo $count_records ?> / <?= count($result) + ($_GET["pg"]) ?>
			<table class="table table-striped table-bordered table-hover dataTables-example">
                <thead>
                    <tr>
                    	<th>
                        	Sno.
                        </th>
						<th>
							Email
						</th>
						<th>
							Subject
						</th>
						<th>
							Type
						</th>
						<th>
							Date
						</th>
						<th>
							View
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
							<?= ($row->user_email_id); ?>
                        </td>
						<td>
							<?= ($row->subject); ?>
                        </td>
						<td>
							<?php
							if($row->email_function=="invoice")
							{
								echo "Invoice Report";
							}
							
							if($row->email_function=="corporate_report")
							{
								echo "Corporate Report";
							}
							
							if($row->email_function=="pendingorder")
							{
								echo "Pending Order Report";
							}
							?>
                        </td>
						<td>
							<?= $row->date; ?>
							<?= $row->time; ?>
                        </td>
						<td>
							<a href="#" data-toggle="modal" data-target="#myModal_<?php echo $row->id ?>">View</a>
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
<?php
$i=1;
foreach ($result as $row)
{
	?>
<div id="myModal_<?php echo $row->id ?>" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title text-center"><?= ($row->subject); ?></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>				
			</div>
			<div class="modal-body">
				<?= ($row->message); ?>
				
				<?php
				if($row->file_name1!=""){ ?>
				<a href="<?= base_url(); ?><?= ($row->file_name1); ?>">
					<?= ($row->file_name_1); ?>
				</a>
				<?php } ?>
				
				<?php
				if($row->file_name2!=""){ ?>
				<a href="<?= base_url(); ?><?= ($row->file_name2); ?>">
					<?= ($row->file_name_2); ?>
				</a>
				<?php } ?>
				
				<?php
				if($row->file_name3!=""){ ?>
				<a href="<?= base_url(); ?><?= ($row->file_name3); ?>">
					<?= ($row->file_name_3); ?>
				</a>
				<?php } ?>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<?php
}
?>