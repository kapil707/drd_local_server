<div class="row">
	<div class="col-xs-12">
        <a href="<?php echo base_url(); ?>admin/<?= $Page_name ?>/view?pg=<?= $_GET["pg"]; ?>#row_<?=$id ?>">
		<button type="button" class="btn btn-w-m btn-info"><< Back</button>
		</a>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
        <?php
        foreach ($result as $row)
        { ?>
			<input type="hidden" id="old_image" name="old_image" value="<?= $row->image?>"/>
            <input type="hidden" id="old_image2" name="old_image2" value="<?= $row->image2?>"/>
            <input type="hidden" id="old_image3" name="old_image3" value="<?= $row->image3?>"/>
            <input type="hidden" id="old_image4" name="old_image4" value="<?= $row->image4?>"/>
           	<div class="form-group">				
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Select Item
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <input type="hidden" id="i_code" name="i_code" value="<?= $i_code = $row->itemid?>"/>
						<?php 
						$row1 =  $this->db->query ("select item_name,item_code from tbl_medicine where i_code='$i_code'")->row();
						?>
						<input type="text" class="form-control" id="item_name" name="item_name"tabindex="1" onkeydown="call_search_item()" onkeyup="call_search_item()" placeholder="Select Item" autocomplete="off" value="<?= $row1->item_name?> (<?= $row1->item_code?>)" />
						<div class="call_search_item_result" style="position: absolute;z-index: 1;background: white;width: 300px;"></div>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">
                            <?= form_error('itemid'); ?>
                        </span>
                    </div>
                </div>	
            </div>   
            <div class="form-group">
                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Title
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" id="form-field-1" placeholder="Title" name="title" value=""><?= $row->title?></textarea>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('title'); ?>
                        </span>
                    </div>
              	</div>

                <div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Description
                        </label>
                    </div>
                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" id="form-field-1" placeholder="Description" name="description" value=""><?= $row->description?></textarea>
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
                    	<img src="<?= $url_path ?><?= $row->image; ?>" class="img-responsive" alt />
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
                    	<img src="<?= $url_path ?><?= $row->image2; ?>" class="img-responsive" alt />
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
                    	<img src="<?= $url_path ?><?= $row->image3; ?>" class="img-responsive" alt />
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
                    	<img src="<?= $url_path ?><?= $row->image4; ?>" class="img-responsive" alt />
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('image4'); ?>
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
							<option value="1" <?php if(set_value('featured')==1) { ?> selected <?php } ?>>
								Yes
							</option>
							<option value="0" <?php if(set_value('featured')==0) { ?> selected <?php } ?>>
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
				<div class="col-sm-6">
                    <div class="col-sm-4 text-right">
                        <label class="control-label" for="form-field-1">
                            Status
                        </label>
                    </div>
                    <div class="col-sm-8">
                        <select name="status" id="status" class="form-control">
							<option value="1" <?php if($row->status==1) { ?> selected <?php } ?>>
								Active
							</option>
							<option value="0" <?php if($row->status==0) { ?> selected <?php } ?>>
								Inactive
							</option>
						</select>
                    </div>
                    <div class="help-inline col-sm-12 has-error">
                        <span class="help-block reset middle">  
                            <?= form_error('status'); ?>
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