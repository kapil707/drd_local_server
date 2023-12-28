<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
		Dr. Distributor
    </title>
    <meta charset utf="8">
	<link rel="stylesheet" href="<?= base_url(); ?>assets/website/css/font-awesome.min.css"> 
	<link href="<?= base_url(); ?>assets/website/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?= base_url(); ?>assets/website/css/style.css" rel="stylesheet" type="text/css"/>
	<script src="<?= base_url(); ?>assets/website/js/jquery-2.1.4.min.js"></script>
	<script src="<?= base_url(); ?>assets/website/js/bootstrap.min.js"></script>
	<script src="<?= base_url(); ?>assets/website/js/bigSlide.js"></script>
		<script>
			$(document).ready(function() {
			$('.menu-link').bigSlide();
		});
		</script>
	<!--script-->
	<script src="<?= base_url(); ?>assets/website/js/responsiveslides.min.js"></script>
	<script>
	$(function () {
		$("#slider").responsiveSlides({
		auto: true,
		nav: true,
		speed: 500,
		namespace: "callbacks",
		pager: true,
		});
	});
	</script>
	<!--script-->
	<script src="<?= base_url(); ?>assets/website/js/pie-chart.js" type="text/javascript"></script>
	<script type="text/javascript">

	$(document).ready(function () {
	   
		 $('#demo-pie-1').pieChart({
			barColor: '#68b828',
			trackColor: '#E4E2E2',
			lineCap: 'butt',
			lineWidth: 10,
			onStep: function (from, to, percent) {
				$(this.element).find('.pie-value').text(Math.round(percent) + '%');
			}
		});

		$('#demo-pie-2').pieChart({
			barColor: '#5bc0de',
			trackColor: '#E4E2E2',
			lineCap: 'butt',
			lineWidth: 10,
			onStep: function (from, to, percent) {
				$(this.element).find('.pie-value').text(Math.round(percent) + '%');
			}
		});

		$('#demo-pie-3').pieChart({
			barColor: '#d9534f',
			trackColor: '#E4E2E2',
			lineCap: 'square',
			lineWidth: 10,
			onStep: function (from, to, percent) {
				$(this.element).find('.pie-value').text(Math.round(percent) + '%');
			}
		});

	   
	});
    </script>
	<script>
		function goBack() {
			window.history.back();
		}
	</script>
<link href='//fonts.googleapis.com/css?family=Josefin+Sans:400,700italic,700,600italic,400italic,600,300italic,300,100italic,100' rel='stylesheet' type='text/css'>
</head>
<body onkeydown="return keyPressed();search_focus()">
	<div class="body-back">
		<div class="masthead pdng-stn1">
			<div id="menu" class="panel" role="navigation">
				<div class="wrap-content">
					<div class="header_title_logo_or_name">
						<img class="img-circle" src="<?= base_url();?>images/new/logo.png" width="50">
						<h6>Welcome 
						<?= $_SESSION['user_fname'] ?> (<?= $_SESSION['user_division'] ?>)</h6>
						<h6><?= base64_decode($_SESSION['user_compname']); ?></h6>
					</div> 
					<div class="profile-menu text-center">
						<div class="social-icon">
							<ul>
								<li>
									<a href="<?= base_url('staff/item_wise_report')?>">
										<img src="<?= base_url()?>images/item_wise.png" width="25px;">
										Item Report
									</a>
								</li>
								<li>
									<a href="<?= base_url('staff/item_wise_report_month')?>">
										<img src="<?= base_url()?>images/item_wise_month.png" width="25px;">
										Item Report Monthly
									</a>
								</li>
								<li>
									<a href="<?= base_url('staff/chemist_wise_report')?>">
										<img src="<?= base_url()?>images/item_wise.png" width="25px;">
										Chemist Report
									</a>
								</li>
								<li>
									<a href="<?= base_url('staff/chemist_wise_report_month')?>">
										<img src="<?= base_url()?>images/item_wise_month.png" width="25px;">
										Chemist Rep. Monthly
									</a>
								</li>
								<li>
									<a href="<?= base_url('staff/stock_and_sales_analysis')?>">
										<img src="<?= base_url()?>images/stock_and_sales_analysis.png" width="25px;">
										Stock And Sales
									</a>
								</li>
								<li>
									<a href="<?= base_url('staff/staff_password')?>">
										<i class="fa fa-user" aria-hidden="true" style="width:25px;margin-left: 40px; margin-right: 20px;"></i>
										Change Password
									</a>
								</li>
							</ul>
						</div>
						<hr>
						<div class="social-icon">
							<ul>
								<li>
									<a href="tel:+919899133989">
										<img src="<?= base_url()?>images/new/phone.png" width="25px;">
										Phone
									</a>
								</li>
								<li>
									<a href="https://wa.me/919899133989">
										<img src="<?= base_url()?>images/new/whatsapp.png" width="25px;">
										Whatsapp
									</a>
								</li>
								<li>
									<a href="mailto:vipul@drdindia.com">
										<img src="<?= base_url()?>images/new/email.png" width="25px;">
										Email
									</a>
								</li>
								<li>
									<a href="<?= base_url('privacy_policy')?>">
										<img src="<?= base_url()?>images/new/privacy_policy.png" width="25px;">
										Privacy Policy
									</a>
								</li>
								<li>
									<a href="https://play.google.com/store/apps/details?id=com.drdistributor.dr&hl=en" target="_black">
										<img src="<?= base_url()?>images/new/share.png" width="25px;">
										Share
									</a>
								</li>
								<li>
									<a href="<?= base_url('home/logout')?>">
										<img src="<?= base_url()?>images/new/logout.png" width="25px;">
										Logout
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="phone-box wrap push">
				<div class="menu-notify">
					<div class="container">
						<div class="row">
							<div class="col-sm-2"></div>
							<div class="col-sm-8 col-12">
								<div class="row">
									<div class="col-sm-1 col-2">
										<a href="#menu" class="menu-link menubtn1" style="color:white;">
											<i class="fa fa-bars"></i>
										</a>
										<a href="<?= base_url(); ?>corporate/home" class="menubtn2">
											<img src="<?= base_url(); ?>images/new/back_button.png" width="25px;">
										</a>
									</div>
									<div class="col-sm-9 col-7">
										<h6 class="pro-link headertitle" style="color:white;margin-top: 5px;">
										D R Distributors Pvt Ltd
										</h6>
									</div>
									<div class="col-sm-2 col-3 text-right">
										
									</div>
								</div>
							</div>
							<div class="col-sm-2"></div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
<script>
count_temp_rec();
function count_temp_rec()
{
	id = "";
	$.ajax({
	type       : "POST",
	data       : {id:id} ,
	url        : "<?php echo base_url(); ?>read_json/count_temp_rec",
	cache	   : false,
	success    : function(data){
			$(".mycartwalidiv").html("("+data+")");
		}
	});
}
</script>