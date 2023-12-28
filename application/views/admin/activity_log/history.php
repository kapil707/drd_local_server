<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
   	</div>
    <div class="col-xs-12 text-center">
    	<?php
		$start_date = $_GET["start_date"];
		$start_date = date("Y-m-d", strtotime($start_date));
		$end_date = $_GET["end_date"];
		$end_date = date("Y-m-d", strtotime($end_date));
		$user_id = $_GET["user_id"]; 
		?>
        <b>All Activities From <?php echo date("d-M-Y",strtotime($start_date));?> To <?php echo date("d-M-Y",strtotime($end_date));?></b>
   	</div>
    <div class="col-xs-12">
    	<?php
		$query = $this->db->query("select * from tbl_activity_log where date BETWEEN '$start_date' and '$end_date' and user_id='$user_id' order by id desc");
		$result = $query->result();
		foreach($result as $row)
		{
		?>
		 <div class="stream">
			<div class="stream-badge">
				<i class="fa fa-commenting-o"></i>
			</div>
			<div class="stream-panel">
				<div class="stream-info">
					<a href="#">
                    	<?php
						$user_id = $row->user_id;
						$query = $this->db->query("select * from tbl_user where id='$user_id'");
						$row1 = $query->row();
						?>
						<img alt="image" class="img-circle" src="<?= base_url()?>uploads/manage_profile/photo/<?= $row1->photo ?>" width="100" />
						<span>
                        <?php
						echo $row1->name;
						?>
                        </span>
						<span class="date">
						<?php echo date("d-M-Y",strtotime($row->date));?> at <?php echo date("H:i A",$row->time);?></span>
					</a>
				</div>
				Commented on "<?php echo base64_decode($row->message);?>"
			</div>
		</div>
        <?php
		}
		?>
    </div>
</div>