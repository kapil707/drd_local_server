<div class="row">
	<div class="col-xs-12">
        <a href="<?php echo base_url(); ?>admin/<?= $Page_name ?>/view?table_name=<?= $_GET["table_name"]; ?>&pg=<?= $_GET["pg"]; ?>#row_<?=$id1 ?>">
		<button type="button" class="btn btn-w-m btn-info"><< Back</button>
		</a>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php
        foreach ($result as $row)
        {
            ?>
            <input type="hidden" name="old_image1" value="<?= $row->img1?>"/>
            <input type="hidden" name="old_image2" value="<?= $row->img2?>"/>
            <input type="hidden" name="old_image3" value="<?= $row->img3?>"/>
            <input type="hidden" name="old_image4" value="<?= $row->img4?>"/>
            <input type="hidden" name="update_url" value="<?= $row->update_url?>"/>
            <?php
            $table_name = $row->table_name;
            $url = base_url()."medicine_images/";
            if(file_exists("./uploads/manage_medicine_image/photo/main/".$row->img1))
            {
                $img1 = base_url()."uploads/manage_medicine_image/photo/main/".$row->img1;
            }
            else
            {
                $img1 = $url.$table_name."/".$row->img1;
            }
            if(file_exists("./uploads/manage_medicine_image/photo/main/".$row->img2))
            {
                $img2 = base_url()."uploads/manage_medicine_image/photo/main/".$row->img2;
            }
            else
            {
                $img2 = $url.$table_name."/".$row->img2;
            }
            if(file_exists("./uploads/manage_medicine_image/photo/main/".$row->img3))
            {
                $img3 = base_url()."uploads/manage_medicine_image/photo/main/".$row->img3;
            }
            else
            {
                $img3 = $url.$table_name."/".$row->img3;
            }
            if(file_exists("./uploads/manage_medicine_image/photo/main/".$row->img4))
            {
                $img4 = base_url()."uploads/manage_medicine_image/photo/main/".$row->img4;
            }
            else
            {
                $img4 = $url.$table_name."/".$row->img4;
            }
            ?>
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                        Medicine Name
                        <br>
                        Essysol Name
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        $row1 = $this->db->query("select tbl_med_info.id,tbl_medicine.item_name from tbl_med_info,tbl_medicine where tbl_med_info.table_name='$table_name' and tbl_med_info.tbl_id='$row->tbl_id' and tbl_med_info.i_code=tbl_medicine.i_code")->row();
                        ?>
                        <?php
                        $row2 = $this->db->query("select itemname from $table_name where id='$row->tbl_id'")->row();
                        ?>
                        <?= $row2->itemname ?>
                        <br>
                        <?= $row1->item_name ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Title
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="item_name" name="a1" placeholder="Title" value="<?= $row->a1; ?>" />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('description'); ?>
                        </span>
                    </div>
              	</div>
            </div>
           	<div class="form-group">
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="image" name="image" />
                    </div>
                    <div class="col-sm-2 img_id_image">
                    	<img src="<?= $img1; ?>" class="img-responsive" alt />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('image'); ?>
                        </span>
                    </div>
              	</div>
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image2
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="Image2" name="image2" />
                    </div>
                    <div class="col-sm-2 img_id_image">
                    	<img src="<?= $img2; ?>" class="img-responsive" alt />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('image2'); ?>
                        </span>
                    </div>
              	</div>
			</div>
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image3
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="Image3" name="image3" />
                    </div>
                    <div class="col-sm-2 img_id_image">
                    	<img src="<?= $img3; ?>" class="img-responsive" alt />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('imag3'); ?>
                        </span>
                    </div>
              	</div>
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Image4
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" id="form-field-1" placeholder="Image4" name="image4" />
                    </div>
                    <div class="col-sm-2 img_id_image">
                    	<img src="<?= $img4; ?>" class="img-responsive" alt />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('image4'); ?>
                        </span>
                    </div>
              	</div>                
			</div>
            <div class="form-group">
                <div class="col-sm-12">
                    <div class="col-sm-2 text-right">
                        <label class="control-label" for="form-field-1">
                            Description
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <textarea type="text" class="form-control" id="form-field-1" placeholder="Description" name="a5" value=""><?= $row->a5; ?></textarea>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('description'); ?>
                        </span>
                    </div>
                </div>            
			</div>
            <div class="form-group">
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Featured
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="featured" id="featured" class="form-control">
							<option value="1" <?php if($row->featured==1) { ?> selected <?php } ?>>
								Yes
							</option>
							<option value="0" <?php if($row->featured==0) { ?> selected <?php } ?>>
								No
							</option>
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('featured'); ?>
                        </span>
                    </div>
                </div>
			</div>
            
            <div class="space-4"></div>
            <br /><br />
            <div class="clearfix form-actions">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn btn-info" name="Submit">
                        <em class="ace-icon fa fa-check bigger-110"></em>
                        Submit
                    </button>

                    &nbsp; &nbsp; &nbsp;
                    <button class="btn" type="reset">
                        <em class="ace-icon fa fa-undo bigger-110"></em>
                        Reset
                    </button>
                </div>
            </div>
            <?php } ?>
        </form>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script>
var delete_rec1 = 0;
function delete_photo(id)
{
	if (confirm('Are you sure Delete?')) { 
	if(delete_rec1==0)
	{
		delete_rec1 = 1;
		$.ajax({
			type       : "POST",
			data       :  { id : id ,} ,
			url        : "<?= base_url()?>admin/<?= $Page_name; ?>/delete_photo",
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
<script>
function call_search_item()
{	
	item_name = $("#item_name").val();
	$(".call_search_item_result").html("Loading....");
	if(item_name=="")
	{
		$(".call_search_item_result").html("");
	}
	else
	{
		$.ajax({
		type       : "POST",
		data       :  {item_name:item_name},
		url        : "<?= base_url()?>admin/<?= $Page_name?>/call_search_item",
		cache	   : false,
		success    : function(data){
			$(".call_search_item_result").html(data);
			}
		});
	}
}
function additem(i_code,name)
{
	name = atob(name);
	$("#i_code").val(i_code);
	$("#item_name").val(name);
	$(".call_search_item_result").html("");
}
</script>