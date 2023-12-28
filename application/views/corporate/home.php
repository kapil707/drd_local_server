<style>
.menubtn2
{
	display:none;
}
.headertitle
{
    margin-top: 5px !important;
}
</style>
<?php
$top_flash = $this->Chemist_Model->top_flash();
$top_flash = json_decode("[$top_flash]", true);
$top_flash2 = $this->Chemist_Model->top_flash2();
$top_flash2 = json_decode("[$top_flash2]", true);
?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12 col-12">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-12" style="width: 100%;">
					<script src="<?= base_url(); ?>assets/js/jssor.slider-28.0.0.min.js" type="text/javascript"></script>
					<script type="text/javascript">
					window.jssor_1_slider_init = function() {

						var jssor_1_options = {
						  $AutoPlay: 1,
						  $SlideWidth: 700,
						  $ArrowNavigatorOptions: {
							$Class: $JssorArrowNavigator$
						  },
						  $BulletNavigatorOptions: {
							$Class: $JssorBulletNavigator$
						  }
						};

						var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

						/*#region responsive code begin*/

						var MAX_WIDTH = 1366;

						function ScaleSlider() {
							var containerElement = jssor_1_slider.$Elmt.parentNode;
							var containerWidth = containerElement.clientWidth;

							if (containerWidth) {

								var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

								jssor_1_slider.$ScaleWidth(expectedWidth);
							}
							else {
								window.setTimeout(ScaleSlider, 30);
							}
						}

						ScaleSlider();

						$Jssor$.$AddEvent(window, "load", ScaleSlider);
						$Jssor$.$AddEvent(window, "resize", ScaleSlider);
						$Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
						/*#endregion responsive code end*/
					};
					</script>
					<style>
						/*jssor slider loading skin spin css*/
						.jssorl-009-spin img {
							animation-name: jssorl-009-spin;
							animation-duration: 1.6s;
							animation-iteration-count: infinite;
							animation-timing-function: linear;
						}

						@keyframes jssorl-009-spin {
							from { transform: rotate(0deg); }
							to { transform: rotate(360deg); }
						}

						/*jssor slider bullet skin 051 css*/
						.jssorb051 .i {position:absolute;cursor:pointer;}
						.jssorb051 .i .b {fill:#fff;fill-opacity:0.5;}
						.jssorb051 .i:hover .b {fill-opacity:.7;}
						.jssorb051 .iav .b {fill-opacity: 1;}
						.jssorb051 .i.idn {opacity:.3;}

						/*jssor slider arrow skin 051 css*/
						.jssora051 {display:block;position:absolute;cursor:pointer;}
						.jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
						.jssora051:hover {opacity:.8;}
						.jssora051.jssora051dn {opacity:.5;}
						.jssora051.jssora051ds {opacity:.3;pointer-events:none;}
						.img_css_forslider
						{
							margin-left: 10px;
							margin-right: 10px;
							border-radius: 15px;
							width: 98% !important;
						}
					</style>
					<div id="jssor_1">
					<!-- Loading Screen -->
						<div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
							<img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="img/spin.svg" alt>
						</div>
						<div data-u="slides" class="top_flash_div">
							<?php
							foreach($top_flash as $row)
							{
								if($row["division"]==""){
									$row["division"]="not";
								}
								?>
								<div>
									<a href="#">
										<img src="<?= $row["image"] ?>" data-u="image" class="img_css_forslider" alt>
									</a>
								</div>
							<?php 
							} ?>
						</div>
						<!-- Bullet Navigator -->
						<div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
							<div data-u="prototype" class="i" style="width:16px;height:16px;">
								<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
									<circle class="b" cx="8000" cy="8000" r="5800"></circle>
								</svg>
							</div>
						</div>
						<!-- Arrow Navigator -->
						<div data-u="arrowleft" class="jssora051" style="width:65px;height:65px;top:0px;left:35px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
							<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
								<polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
							</svg>
						</div>
						<div data-u="arrowright" class="jssora051" style="width:65px;height:65px;top:0px;right:35px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
							<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
								<polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
							</svg>
						</div>
					</div>
					<script type="text/javascript">jssor_1_slider_init();</script>
				</div>		
			</div>

			<div class="row home_page_big_div2">
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('corporate/item_wise_report')?>" style="color:black" title="Item wise report">
							<div class="text-center">
								<img src="<?= base_url()?>images/new/item_wise_report.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Item wise report</div><br>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('corporate/item_wise_report_month')?>" style="color:black" title="Item wise report monthly">
							<div class="text-center">
								<img src="<?= base_url()?>images/new/item_wise_report.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Item wise report monthly</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('corporate/chemist_wise_report')?>" style="color:black">
							<div class="text-center">
								<img src="<?= base_url()?>images/new/chemist_wise_report.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Chemist wise Report</div><br>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('corporate/chemist_wise_report_month')?>" style="color:black">
							<div class="text-center">
								<img src="<?= base_url()?>images/new/chemist_wise_report.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Chemist wise Report Monthly</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('corporate/stock_and_sales_analysis')?>" style="color:black">
							<div class="text-center">
								<img src="<?= base_url()?>images/new/stock_and_sales_analysis.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Stock And Sales Analysis</div>
							</div>
						</a>
					</div>
				</div>
				
				<div class="col-xs-2 col-sm-2 col-4 p-1">
					<div class="" style="background:#ffffff;border-radius: 10px;padding:10px;">
						<a href="<?= base_url('corporate/notification')?>" style="color:black">
							<div class="text-center">
								<img src="<?= base_url()?>images/new/new_notification.png" class="img-fluid img-responsive" alt>
								<div class="home_pg_btn">Notification <span class="notificationdiv">(0)</span></div><br>
							</div>
						</a>
					</div>
				</div>
			</div>	

			<div class="row">
				<div class="col-sm-12 home_page_big_div">
					<div id="flash2" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
						<?php
						foreach($top_flash2 as $row)
						{
							if($row["division"]==""){
									$row["division"]="not";
								}
							?>
							<div class="carousel-item <?= $row["id"] ?>">
								<a href="javascript:callandroidfun('<?= $row["funtype"] ?>','<?= $row["itemid"] ?>','<?= base64_encode($row["compname"])?>','<?= $row["image"] ?>','<?= $row["division"] ?>');">
									<img src="<?= $row["image"] ?>" data-u="image" class="img_css_forslider1" alt>
								</a>
							</div>
							<?php
						}
						?>
						</div>
						<a class="carousel-control-prev" href="#flash2" data-slide="prev">
							<span class="carousel-control-prev-icon"></span>
						</a>
						<a class="carousel-control-next" href="#flash2" data-slide="next">
							<span class="carousel-control-next-icon"></span>
						</a>
					</div>
				</div>
			</div>
		</div>		
	</div> 
</div>