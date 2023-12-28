<div class="row">
	<div class="col-xs-12">
		<button type="button" class="btn btn-w-m btn-info" onclick="goBack();"><< Back</button>
	</div>
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="col-sm-12 col-12">
				<div class="form-group">
					<label for="file">Upload excel file</label>
					<div class="row">
						<div class="col-sm-10 col-10">
							<input id="sortpicture" type="file" name="sortpic" class="form-control" onchange="sortpicture_change()" />
						</div>
						<div class="col-sm-2 col-2">
							<input id="clearfile" type="submit" name="clearfile" class="btn clearfile" onclick="clearfile()" style="display:none" value="Clear" />
						</div>
					</div>
				</div>
				
				<div class="form-group">
					<label for="file">Header row number</label>
					<input type="text" name="headername"  class="form-control headername" placeholder="Header row number" value="<?= $headername ?>" />
				</div>	
				<div class="form-group">
					<label for="file">Item row name</label>
					<input type="text" name="itemname" class="form-control itemname" placeholder="Item row name" value="<?= $itemname ?>" />
				</div>	
				<div class="form-group">
					<label for="file">Item row price</label>
					<input type="text" name="itemprice" class="form-control itemprice" placeholder="Item row price" value="<?= $itemprice ?>" />
				</div>	
				<div class="form-group">
					<label for="file">Item row itemintro1</label>
					<input type="text" name="itemintro1" class="form-control itemintro1" placeholder="Item row itemintro1" value="<?= $itemintro1 ?>" />
				</div>
				<div class="form-group">
					<label for="file">Item row itemintro2</label>
					<input type="text" name="itemintro2" class="form-control itemintro2" placeholder="Item row itemintro2" value="<?= $itemintro2 ?>" />
				</div>
				<div class="form-group">
					<label for="file">Item row image1</label>
					<input type="text" name="image1" class="form-control image1" placeholder="Item row image1" value="<?= $image1 ?>" />
				</div>
				<div class="form-group">
					<label for="file">Item row image2</label>
					<input type="text" name="image2" class="form-control image2" placeholder="Item row image2" value="<?= $image2 ?>" />
				</div>
				<div class="form-group">
					<label for="file">Item row image3</label>
					<input type="text" name="image3" class="form-control image3" placeholder="Item row image3" value="<?= $image3 ?>" />
				</div>
				<div class="form-group">
					<label for="file">Item row image4</label>
					<input type="text" name="image4" class="form-control image4" placeholder="Item row image4" value="<?= $image4 ?>" />
				</div>
				<div class="form-group text-right">
					<span id="upload_import_file_loading" style="display:none">Uploading....</span>
					<button id="upload_import_file" onclick="upload_import_file()" class="btn btn-w-m btn-success site_main_btn31" style="width:20%">Upload</button>
				</div>
			</form>
		</div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
function sortpicture_change()
{  
	sortpicture1 = $("#sortpicture").val();	
	if(sortpicture1=="")
	{
		$(".clearfile").hide();
	}
	else
	{
		$(".clearfile").show();
	}
}
function clearfile()
{
	$("#sortpicture").val('');
	$(".clearfile").hide();
}
function upload_import_file()
{	
	headername 	= $(".headername").val();
	itemname 	= $(".itemname").val();
	itemprice	= $(".itemprice").val();
	itemintro1 	= $(".itemintro1").val();
	itemintro2 	= $(".itemintro2").val();
	image1		= $(".image1").val();
	image2		= $(".image2").val();
	image3		= $(".image3").val();
	image4		= $(".image4").val();
	sortpicture1 = $("#sortpicture").val();	
	if(sortpicture1=="")
	{
		alert("Select File")
		$("#sortpicture").focus();
		return;
	}
	if(headername=="")
	{
		$(".headername").focus();
		alert("Enter header row number")
		return;
	}
	if(itemname=="")
	{
		$(".itemname").focus();
		alert("Enter item row name")
		return;
	}	
	if(itemprice=="")
	{
		$(".itemprice").focus();
		alert("Enter item row price")
		return;
	}
	if(itemintro1=="")
	{
		$(".itemintro1").focus();
		alert("Enter item row intro1")
		return;
	}
	if(itemintro2=="")
	{
		$(".itemintro2").focus();
		alert("Enter item row intro2")
		return;
	}

	if(image1=="")
	{
		$(".image1").focus();
		alert("Enter item row image1")
		return;
	}
	if(image2=="")
	{
		$(".image2").focus();
		alert("Enter item row image2")
		return;
	}
	if(image3=="")
	{
		$(".image3").focus();
		alert("Enter item row image3")
		return;
	}
	if(image4=="")
	{
		$(".image4").focus();
		alert("Enter item row image4")
		return;
	}
	$("#upload_import_file_loading").show();
	$("#upload_import_file").hide();
	var file_data = $('#sortpicture').prop('files')[0];
	var form_data = new FormData();                  
    form_data.append('file',file_data);
    //alert(form_data);                             
    $.ajax({
		url: "<?= img_url_site?>admin/manage_medicine_info2/upload_import_file/?headername="+headername+"&itemname="+itemname+"&itemprice="+itemprice+"&itemintro1="+itemintro1+"&itemintro2="+itemintro2+"&image1="+image1+"&image2="+image2+"&image3="+image3+"&image4="+image4,
		//dataType: 'text',
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,                         
		type: 'post',
		error: function(){
		   	swal("Please compare the columns in the Excel file with those you have entered in the website.");
		   	$("#upload_import_file_loading").hide();
			$("#upload_import_file").show();
		},
		success: function(data){
			$.each(data.items, function(i,item){	
				if (item)
				{
					window.location.href = item.url;
				} 
			});
		},
		timeout: 10000
	});
}
</script>