<div class="row">
    <div class="col-xs-4" style="margin-bottom:5px;">
		<form class="form-horizontal" role="form" method="get" enctype="multipart/form-data">
		    Select table name : 
			<select name="table_name" id="table_name" data-placeholder="Select Status" class="chosen-select" required="required" onchange='this.form.submit()'>
				<?php 
				foreach (range('a', 'z') as $alphabet) { ?>
				<option value="<?= $alphabet; ?>_med" <?php if($table_name==$alphabet."_med") { ?> selected <?php } ?>>
					<?= strtoupper($alphabet); ?>
				</option>
				<?php } ?>
			</select>
		</form>
   	</div>
    <div class="col-xs-12">
		<div class="table-responsive">
		    Total Records : <?php echo $count_records ?> / <?= count($result) + ($_GET["pg"]) ?>
			<table class="table table-striped">
                <thead>
                    <tr>
                    	<th id="" style="width:10px">
                        	SNo.
                        </th>
						<th id="" style="width:100px">
                        	Medicine Name
							<br>
                        	Essysol Name
                        </th>
						<th id="" style="width:100px">
							Title
                        </th>
                        <th id="" style="width:100px">
                        	Image
                        </th>
                        <th id="" style="width:50px">
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
                        	<?= ($row->itemname); ?>
							<br>
							<?php 
							$row1 = $this->db->query("select tbl_med_info.id,tbl_med_info.img1,tbl_med_info.img2,tbl_med_info.img3,tbl_med_info.img4,tbl_medicine.item_name from tbl_med_info,tbl_medicine where tbl_med_info.table_name='$table_name' and tbl_med_info.tbl_id='$row->id' and tbl_med_info.i_code=tbl_medicine.i_code")->row(); ?>

							<input type="text" class="form-control" id="item_name_<?= $row->id; ?>" name="item_name" tabindex="1" onkeydown="call_search_item('<?= $row->id; ?>')" onkeyup="call_search_item('<?= $row->id; ?>')" placeholder="Select Item" autocomplete="off" value="<?= $row1->item_name?>" />
						    
							<div class="call_search_item_result_<?= $row->id; ?>" style="position: absolute;z-index: 1;background: white;width: 300px;"></div>
                        </td>
						<td>
                        	<?= ($row->a1); ?>
                        </td>
                        <td>
							<?php
							if($row1->img1=="")
							{
								$row1->img1=1;
							}
							if($row1->img2=="")
							{
								$row1->img2=1;
							}
							if($row1->img3=="")
							{
								$row1->img3=1;
							}
							if($row1->img4=="")
							{
								$row1->img4=1;
							}
							$url = base_url()."medicine_images/";
							if(file_exists("./uploads/manage_medicine_image/photo/main/".$row1->img1))
							{
								$img1 = base_url()."uploads/manage_medicine_image/photo/main/".$row1->img1;
							}
							else
							{
								$img1 = $url.$table_name."/".$row->img1;
							}
							if(file_exists("./uploads/manage_medicine_image/photo/main/".$row1->img2))
							{
								$img2 = base_url()."uploads/manage_medicine_image/photo/main/".$row1->img2;
							}
							else
							{
								$img2 = $url.$table_name."/".$row->img2;
							}
							if(file_exists("./uploads/manage_medicine_image/photo/main/".$row1->img3))
							{
								$img3 = base_url()."uploads/manage_medicine_image/photo/main/".$row1->img3;
							}
							else
							{
								$img3 = $url.$table_name."/".$row->img3;
							}
							if(file_exists("./uploads/manage_medicine_image/photo/main/".$row1->img4))
							{
								$img4 = base_url()."uploads/manage_medicine_image/photo/main/".$row1->img4;
							}
							else
							{
								$img4 = $url.$table_name."/".$row->img4;
							}
							?>
							<img src="<?= ($img1); ?>" width="50" alt>
							<img src="<?= ($img2); ?>" width="50" alt>
							<img src="<?= ($img3); ?>" width="50" alt>
							<img src="<?= ($img4); ?>" width="50" alt>

							<input type="hidden" class="a1_<?= $row->id; ?>" value="<?= htmlentities($row->a1); ?>">
							<input type="hidden" class="a5_<?= $row->id; ?>" value="<?= htmlentities($row->a5); ?>">
							<input type="hidden" class="img1_<?= $row->id; ?>" value="<?= ($img1); ?>">
							<input type="hidden" class="img1_<?= $row->id; ?>" value="<?= ($img1); ?>">
							<input type="hidden" class="img2_<?= $row->id; ?>" value="<?= ($img2); ?>">
							<input type="hidden" class="img3_<?= $row->id; ?>" value="<?= ($img3); ?>">
							<input type="hidden" class="img4_<?= $row->id; ?>" value="<?= ($img4); ?>">
                        </td>
						<td class="text-right">
							<div class="btn-group edit_delete_btn_<?= $row->id; ?>" <?php if($row1->id==""){ ?> style="display:none;"<?php } ?>>
								<?php /* <a href="javascript:void(0)" onclick="edit_rec('<?= $row->id; ?>')" class="btn-white btn btn-xs">Edit</i> </a>*/ ?>

								<a href="edit/<?= $row1->id; ?>?table_name=<?= $table_name; ?>&pg=<?= $_GET["pg"]; ?>" class="btn-white btn btn-xs">Edit</i> </a>

								<a href="javascript:void(0)" onclick="delete_rec('<?= $row1->id; ?>','<?= $row->id; ?>')" class="btn-white btn btn-xs">Delete</i> </a>
							</div>
                        </td> 
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<ul class="pagination">
    <li class="startcss1 disabled"><span class="">First</span></li>
    <li class="startcss2 disabled"><span class="">Prev</span></li>
<?php
$endcss = "class='disabled'";
for($i=0;$i<($count_records);$i= 100 + $i){
	$showone = 0;
	if($i==0 && $per_page!=0){


		?>
		<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($i/100)*100 ?>" ><?php echo ceil($i/100)+1 ?></a></li>
		<script>
			$(".startcss1").removeClass("disabled");
			$(".startcss2").removeClass("disabled");

			$(".startcss1").html('<a rel="noopener" href="javascript:void(0)" class="fast" per_page="0">First</a>');
			$(".startcss2").html('<a rel="noopener" href="javascript:void(0)" class="previous" per_page="<?php echo $per_page - 100 ?>">Prev</a>');
		</script>
		<?php
		$showone = 1;
	}
	
	if($i==$per_page-100 && $showone == 0){
		?>
		<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($i/100)*100 ?>" ><?php echo $lastval = ceil($i/100)+1 ?></a></li>
		<?php
	}
	
	if($i==$per_page){
		?>
		<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($i/100)*100 ?>" ><?php echo $lastval1 = ceil($i/100)+1 ?></a></li>
		<?php
	}
	
	if($i==$per_page+100){
		$endcss = "";
		?>
		<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($i/100)*100 ?>" ><?php echo $lastval2 = ceil($i/100)+1 ?></a></li>
		<?php
	}
}

if(ceil($i/100)==$lastval || ceil($i/100)==$lastval1 || ceil($i/100)==$lastval2){}else{
	?>
	<li class="<?php if(ceil($per_page/100)==ceil($i/100)){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo ceil($i/100) ?>" per_page="<?php echo ceil($count_records/100)*100 - 100; ?>"><?php echo ceil($i/100)?></a></li>
	<?php
}
$last = $next = '';

if($endcss == ''){
	$last = 'last';
	$next = 'next';
}
       /*echo $per_page;
    for($i=0;$i<ceil($count_records/100);$i++){

  if($i<=ceil($per_page/100)+10&&$i>=ceil($per_page/100)){
       if($i==0){ ?>
      <li class="<?php if(ceil($per_page/100)==$i){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per" ford="<?php echo $i ?>" per_page="<?php echo "0"; ?>" ><?php echo "1" ?>xx</a></li>
      <?php  }else{ ?>
     <li class="<?php if(ceil($per_page/100)==$i){ echo "active";} ?>"><a rel="noopener" href="javascript:void(0);" class="for_per"  ford="<?php echo $i ?>" per_page="<?php echo $i*100; ?>" ><?php echo $i+1 ?>yy</a></li>
     <?php   }
    	?>
   
    
    <?php } ?>
    


    <?php }*/ ?>
    
    <li <?php /* class="<?php if($per_page >= $count_records){ echo 'disabled'; } ?>"*/ ?> <?=$endcss; ?>>
        <a rel="noopener" href="javascript:void(0);" class="<?= $next?>" per_page="<?php echo $per_page + 100; ?>">Next</a>
    </li>
    <li <?=$endcss; ?>><a rel="noopener" href="javascript:void(0)" class="<?= $last?>" per_page="<?php echo ceil($count_records/100)*100 - 100; ?>">Last</a></li>
</ul>
        </div>
    </div>
</div>
<button type="button" data-toggle="modal" data-target="#myModal" id="modal_open" style="display:none"></button>
<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							<label class="control-label" for="form-field-1">
								Image 1
							</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control model_img1" onchange="onchange_model_img1()">
						</div>
						<div class="col-sm-2">
							<img src="" width="100%" class="model_s_img1">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							<label class="control-label" for="form-field-1">
								Image 2
							</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control model_img2" onchange="onchange_model_img2()">
						</div>
						<div class="col-sm-2">
							<img src="" width="100%" class="model_s_img2">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							<label class="control-label" for="form-field-1">
								Image 3
							</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control model_img3" onchange="onchange_model_img3()">
						</div>
						<div class="col-sm-2">
							<img src="" width="100%" class="model_s_img3">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-2">
							<label class="control-label" for="form-field-1">
								Image 4
							</label>
						</div>
						<div class="col-sm-8">
							<input type="text" class="form-control model_img4" onchange="onchange_model_img4()">
						</div>
						<div class="col-sm-2">
							<img src="" width="100%" class="model_s_img4">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-3">
							<label class="control-label" for="form-field-1">
								Description 1
							</label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control model_a1">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-3">
							<label class="control-label" for="form-field-1">
								Description 2
							</label>
						</div>
						<div class="col-sm-9">
							<input type="text" class="form-control model_a5">
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-12">
							<input type="hidden" class="update_id">
							<button type="button" class="btn btn-primary btn-lg" onclick="update_rec()">Update</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-default close_model" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
var delete_rec1 = 0;
function delete_rec(id,row_id)
{
	if (confirm('Are you sure Delete?')) { 
	if(delete_rec1==0)
	{
		delete_rec1 = 1;
		$.ajax({
			type       : "POST",
			data       :  {id:id,},
			url        : "<?= base_url()?>admin/<?= $Page_name; ?>/delete_rec",
			success    : function(data){
					$("#item_name_"+row_id).val("");
					$(".edit_delete_btn_"+row_id).hide();
					if(data!="")
					{
						swal("Delete Successfully");
					}					
					else
					{
						swal("Something Wrong");
					}
					delete_rec1 = 0;
				}
			});
		}
	}
}
$(".for_per,.previous,.next,.last,.fast").click(function(){
	for_per=$(this).attr("ford");
	per_page=$(this).attr("per_page");
	table_name = '<?= $table_name ?>';
	url="<?php echo base_url() ?>admin/<?= $Page_name; ?>/view?table_name="+table_name+"&pg="+per_page;
	window.location.href=url;
  
  });
  $(".page_btn").click(function(){
  	//alert("ok");
 // per_page="<?php echo $per_page ?>";
// for_per=$(this).attr("ford");
  //per_page=$(this).attr("per_page");
 page_no=$('.page_no').val();

 bysearch=0;
 if(page_no!=""&&page_no!=0){
 	for_per=page_no-1;
  per_page=for_per*100;
  bysearch=1;
 }
 table_name = '<?= $table_name ?>';
 url="<?php echo base_url() ?>admin/<?= $Page_name; ?>/view?table_name="+table_name+"&pg="+per_page;
	window.location.href=url;
  });
</script>

<script>
function call_search_item(row_id)
{	
	item_name = $("#item_name_"+row_id).val();
	$(".call_search_item_result_"+row_id).html("Loading....");
	if(item_name=="")
	{
		$(".call_search_item_result_"+row_id).html("");
	}
	else
	{
		$.ajax({
		type       : "POST",
		data       :  {item_name:item_name,row_id:row_id},
		url        : "<?= base_url()?>admin/<?= $Page_name?>/call_search_item",
		cache	   : false,
		success    : function(data){
			$(".call_search_item_result_"+row_id).html(data);
			}
		});
	}
}
function additem(i_code,row_id,name)
{
	name = atob(name);
	$("#item_name_"+row_id).val(name);
	$(".call_search_item_result_"+row_id).html("");
	additem_set(i_code,row_id);
}

function additem_set(i_code,row_id)
{
	table_name = '<?= $table_name ?>';
	$.ajax({
		type       : "POST",
		data       :  {i_code:i_code,row_id:row_id,table_name:table_name},
		url        : "<?= base_url()?>admin/<?= $Page_name?>/additem_set",
		cache	   : false,
		success    : function(data){
			swal("Successfully added");
			$(".edit_delete_btn_"+row_id).show();
			$(".edit_delete_btn_"+row_id).html('<a href="edit/'+data+'?table_name='+table_name+'&pg=<?= $_GET["pg"]; ?>" class="btn-white btn btn-xs">Edit</i> </a><a href="javascript:void(0)" onclick="delete_rec('+data+','+row_id+')" class="btn-white btn btn-xs">Delete</i> </a>');
		}
	});
}
</script>