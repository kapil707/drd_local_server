<div class="website_footer1 mobile_off">
	<div class="container">
		<div class="row">
			<div class="col-sm-2">
				<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/drphone.png" class="img-fluid" style="margin-top: 5px;" alt>
			</div>
			<div class="col-sm-10 text-center download_app_div">
				Download the App for Free
				<div style="width:250px;margin:auto;margin-top:50px;">
					<div class="google_play">
						<a href="https://play.google.com/store/apps/details?id=com.drdistributor.dr&hl=en_IN" target="_blank">
						<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/playstrore.png" alt="Google Play" style="width:35px;"> Google Play
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="website_footer mobile_off">
	<div class="container">
		<div class="row">
			<?php /*
			<div class="col-sm-12">
				<div class="div_width_25par">
					<ul>
						<li class="footer_li_title">COMPANY</li>
						<li class="footer_li_text">Careers</li>
						<li class="footer_li_text">Blog</li>
						<li class="footer_li_text">Partner with DRD</li>
					<ul>
				</div>
				<div class="div_width_25par">
					<ul>
						<li class="footer_li_title">POLICY INFO</li>
						<li class="footer_li_text">Editorial Policy</li>
						<li class="footer_li_text">Privacy Policy</li>
						<li class="footer_li_text">Terms and condition</li>
					<ul>
				</div>
				<div class="div_width_25par">
					<ul>
						<li class="footer_li_title">NEED HELP?</li>
						<li class="footer_li_text">Browse All Medicines</li>
						<li class="footer_li_text">FAQs</li>
					<ul>
				</div>
				<div class="div_width_25par">
					<ul>
						<li class="footer_li_title">FOLLOW US</li>
						<li class="footer_li_left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/insta.svg"></li>
						<li class="footer_li_left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/fb.svg"></li>
						<li class="footer_li_left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/youtube.svg"></li>
						<li class="footer_li_left"><img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/twitter.svg"></li>
					<ul>
				</div>
			</div>*/ ?>
			<div class="col-sm-1"></div>
			<div class="col-sm-10 text-center footer_copy">
			<div class="text-center" style="margin-top:15px;">
					<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/logo2.png" class="img-fluid" style="margin-top: 5px;" alt width="100px;">
				</div>
				<div class="text-center" style="margin-top:15px;">
					<strong>D R Distributors Pvt Ltd</strong>
				</div>
				<div class="text-center" style="margin-top:5px;">
					Website version 31
				</div>
			</div>
			<div class="col-sm-1"></div>
		</div>
	</div>
</div>

<div class="fix_footer mobile_show">
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok text-center">
		<a href="<?= base_url('home/account')?>" style="color:white">
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/my_account.png" width="22px" alt>
			<div style="font-size: 11px;">Account</div>
		</a>
	</div>
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok_left text-center">
		<a href="<?= base_url('home/track_order')?>" style="color:white">
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/map.png" width="22px" alt>
			<div style="font-size: 11px;">Track</div>
		</a>
	</div>
	
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok_center text-center">
		<a href="<?= base_url('home/search_medicine')?>" style="color:white" alt>
			<div style="font-size: 27px;">+</div>
		</a>
	</div>
	
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok_right text-center">
		<a href="<?= base_url('home/my_notification')?>" style="color:white">
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/notification.png" width="22px" class="cssnotification" alt>
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/notification1.png" width="22px" style="display:none;" class="cssnotification1" alt>
			<div style="font-size: 11px;" class="mobile_off">Notifications <span class="notificationdiv"></span></div>
			<div style="font-size: 11px;" class="mobile_show">Notifications <span class="notificationdiv"></span></div>
		</a>
	</div>
	
	<div class="div_width_20par text_cut_or_dot mobile_footer_css_ok text-center"
	style="margin-right: -15px;">
		<a href="<?= base_url();?>/home" style="color:white">
			<img src="<?= base_url() ?>img_v<?= constant('site_v') ?>/reload1_w.png" width="22px" alt>
			<div style="font-size: 11px;">Reload</div>
		</a>
	</div>
</div>
<script>
function new_style_menu_show()
{
	$(".new_style_menu").show();
}
function new_style_menu_hide()
{
	$(".new_style_menu").hide();
}
</script>