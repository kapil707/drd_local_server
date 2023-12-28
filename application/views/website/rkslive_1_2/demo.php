
	<div class="row">
		<?php
		$query = $this->db->query("select * from tbl_livetv where id='1' or id='2' order by name asc")->result();
		//for($i=0;$i<$countx;$i++)
		foreach($query as $row)
		{
			?>
			<div class="col-sm-2 col-4 p-2 text-center">
			    <?php $url  = $row->url;?>
				<?php $name = ucwords(strtolower($row->name));?>
				<?php $description = $row->description;?>
				<a href="javascript:fun_default_m3u8('<?=$name?>','<?= $url; ?>','<?= $description; ?>')">
				<img src="<?= base_url(); ?>uploads/manage_livetv/photo/<?=$row->image?>" class="img-fluid img-thumbnail rounded-circle">
				<div class="cut-text1"><?=$name?></div>
				</a>
			</div>
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