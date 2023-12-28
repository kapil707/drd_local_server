<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <!-- /.row -->
        <div class="row">
            <!-- /.col -->
            <div class="col-xs-12">
                <?= $this->session->flashdata('message'); ?>
            </div>
            <?php
			if($this->session->userdata('user_type')!="") { ?>
            <div class="col-xs-12">
                <div class="col-lg-3">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-check fa-4x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span>All Product</span>
                                <h2 class="font-bold"><?php echo $total_product ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget style1 lazur-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-thumbs-up fa-4x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span>Sold Product</span>
                                <h2 class="font-bold"><?php echo $total_sold_product ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget style1 yellow-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-bell fa-4x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span>Active Product</span>
                                <h2 class="font-bold"><?php echo $total_active_product ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget style1 btn-danger m-r-sm">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-warning fa-4x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span>Inactive Product</span>
                                <h2 class="font-bold"><?php echo $total_inactive_product ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-xs-4">
                                <i class="fa fa-rss fa-4x"></i>
                            </div>
                            <div class="col-xs-8 text-right">
                                <span>Email Subscription</span>
                                <h2 class="font-bold"><?php echo $total_email ?></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div><!-- /.row -->
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div><!-- /.row -->
			