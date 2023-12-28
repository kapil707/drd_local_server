
	<div class="row">
		<?php
		$t = 0;
		$query = $this->db->query("select * from tbl_livetv order by name asc")->result();
		//for($i=0;$i<$countx;$i++)
		foreach($query as $row)
		{
			?>
			<div class="col-sm-2 col-4 p-2 text-center">
			    <?php $url  = $row->url;?>
				<?php $name = ucwords(strtolower($row->name));?>
				<?php $description = $row->description;?>
				<a href="#" class="" data-toggle="modal" data-target="#myModal<?=$row->id;?>">
				<img src="<?= base_url(); ?>uploads/manage_livetv/photo/resize/<?=$row->image?>" class="img-fluid img-thumbnail rounded-circle">
				<div class="cut-text1"><?=$name?></div>
				</a>
			</div>
			
			<div class="modal" id="myModal<?=$row->id;?>">
				<div class="modal-dialog">
					<div class="modal-content">
						<!-- Modal Header -->
						<div class="modal-header">
						<h4 class="modal-title">Select Player</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>

						<!-- Modal body -->
						<div class="modal-body">
							<div class="row">
								<div class="col-sm-12 col-12 p-6 text-center">
									<button onclick="fun_default_m3u8('<?=$name?>','<?= $url; ?>','<?= $description; ?>')" class="kp<?=$row->id;?> btn btn-primary btn-lg btn-block" tabindex="<?=$t++?>">
										Default Player
									</button>
									
									<button onclick="fun_player_m3u8('<?=$name?>','<?= $url; ?>','<?= $description; ?>')" class="btn btn-primary btn-lg btn-block" tabindex="<?=$t++?>">
										Advanced Player
									</button>
								</div>
							</div>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal" tabindex="<?=$t++?>">Close</button>
						</div>
					</div>
				</div>
			</div>
			<Script>
			$('#myModal<?=$row->id;?>').on('shown.bs.modal', function () {
				$('.kp<?=$row->id;?>').focus();
			}) 
			</Script>
			<?php
		}
		?>
	</div>
</div>
<script type="text/javascript">
	 
    function fun_default_m3u8(name,url,description) {
        if(typeof android !== "undefined" && android !== null) {
            android.default_m3u8(name,url,description);
        } else {
            alert("Not viewing in webview");
        }
    }
	function fun_player_m3u8(name,url,description) {
        if(typeof android !== "undefined" && android !== null) {
            android.player_m3u8(name,url,description);
        } else {
            alert("Not viewing in webview");
        }
    }
</script>