<style>
.menubtn1
{
	display:none;
}
</style>
<script>
$(".headertitle").html("Change Password");
</script>
<div class="container" style="margin-top:20px;">
	<div class="row">
		<div class="col-sm-2"></div>
		<div class="col-sm-8 col-12">
			<div class="row">
				<div class="col-sm-12 m-2">
					<input type="password" id="password" name="oldpassword" class="form-control" placeholder="Old-Password" required style="width:100%;" onchange="check_old_password()">
					<span class="check_old_password_div"></span>
				</div>
				<div class="col-sm-12 m-2">
					<input type="password" id="password1" name="password" class="form-control" placeholder="Password" required style="width:100%;" onchange="check_password1()">
					<span class="check_password1_div"></span>
				</div>
				<div class="col-sm-12 m-2">
					<input type="password" id="password2" name="password1" class="form-control" placeholder="Re-Password" required style="width:100%;" onchange="check_password2()">
					<span class="check_password2_div"></span>
				</div>
				<div class="col-sm-12 m-2">
					<input type="submit" class="btn btn-default" value="Change Password" name="Submit" style="display:none" id="submit" onclick="submit()">
				</div>
				<div class="col-sm-12 m-2">
					<span class="submit_div"></span>
				</div>
			</div> 
		</div>
	</div>
</div>
  
<script>
var pass1 = 0;
var pass2 = 0;
var pass3 = 0;
function check_old_password()
{
	pass1 = 0;
	password = $("#password").val();
	$(".check_old_password_div").html("Loading....");
	$.ajax({
	type       : "POST",
	data       :  {password:password} ,
	url        : "<?php echo base_url(); ?>read_json/staff_password_check_api",
	cache	   : false,
	success    : function(data){
			$.each(data.items, function(i,item){	
				if (item){
					$(".check_old_password_div").html(item.query1);
					if(item.submit=="1")
					{
						pass1 = 1;
						submit_btn();
					}
					else{
						pass1 = 0;
						submit_btn();
					}
				}
			});	
		}
	});
}
function check_password1()
{
	$(".check_password1_div").html("Loading....");
	password1 = $("#password1").val();
	if(password1.length < 8)
	{
		$(".check_password1_div").html("Password should be more than 8 characters");
		pass2 = 0;
		submit_btn();
	}
	else
	{
		$(".check_password1_div").html("");
		pass2 = 1;
		submit_btn();
	}
}
function check_password2()
{
	$(".check_password2_div").html("Loading....");
	password1 = $("#password1").val();
	password2 = $("#password2").val();
	if(password1.length < 8)
	{
		$(".check_password1_div").html("Password should be more than 8 characters");
		pass2 = 0;
		submit_btn();
	}
	else
	{
		$(".check_password1_div").html("");
		pass2 = 1;
		submit_btn();
	}
	if(password1!=password2)
	{
		$(".check_password2_div").html("Password Not Match");
		pass3 = 0;
		submit_btn();
	}
	else
	{
		$(".check_password2_div").html("");
		pass3 = 1;
		submit_btn();
	}
}
function submit_btn()
{
	$("#submit").hide()
	if(pass1=="1" && pass2=="1" && pass3=="1")
	{
		$("#submit").show()
	}
}
function submit()
{
	password = $("#password1").val();
	$(".submit_div").html("Loading....");
	$.ajax({
	type       : "POST",
	data       :  {password:password} ,
	url        : "<?php echo base_url(); ?>read_json/staff_password_set_api",
	cache	   : false,
	success    : function(data){
			$.each(data.items, function(i,item){	
				if (item){
					$(".submit_div").html(item.query1);
				}
			});	
		}
	});
}
</script>