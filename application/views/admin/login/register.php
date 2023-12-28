<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $this->Scheme_Model->get_website_data("title") ;?> | Register</title>
        
        <link href="<?= base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        <link href="<?= base_url()?>assets/css/plugins/iCheck/custom.css" rel="stylesheet">
		 <!-- Text spinners style -->
		<link href="<?= base_url()?>assets/css/plugins/textSpinners/spinners.css" rel="stylesheet">
        <link href="<?= base_url()?>assets/css/animate.css" rel="stylesheet">
        <link href="<?= base_url()?>assets/css/style.css" rel="stylesheet">
	</head>
<body class="gray-bg">
    <div class="middle-box text-center loginscreen   animated fadeInDown">
        <div>
            <div>
            	<h1 class="logo-name"><img src="<?= base_url()?>uploads/logo1.jpeg"></h1>
            </div>
            <h3>Welcome to Register</h3>
            <p>Employees are only allowed to create an Account.Approval is required from authority.</p>
            <form class="m-t" role="form" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Name" required="" name="name" value="<?= set_value('name'); ?>" id="username">
                </div>
                <div class="form-group">
                	<?= form_error('name'); ?>
              	</div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email" required="" name="email" value="<?= set_value('email'); ?>">
                </div>
                <div class="form-group">
                	<?= form_error('email'); ?>
              	</div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required="" name="password" id="pwd-container3">
                </div>
                <div class="form-group">
                	<?= form_error('password'); ?>
              	</div>
				<div class="form-group">
					<div class="pwstrength_viewport_progress2"></div>
				</div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Re-Password" required="" name="password1">
                </div>
                <div class="form-group">
                	<?= form_error('password1'); ?>
              	</div>
                
				<div class="form-group">
					<?=  $this->session->flashdata('message2'); ?>
              	</div>
                <button type="submit" class="btn btn-primary block full-width m-b" name="Submit" value="Submit">Register</button>

                <?php /* <p class="text-muted text-center"><small>Already have an account?</small></p> */ ?>
                <a class="btn btn-sm btn-white btn-block" href="../admin">Login</a>
            </form>
        </div>
    </div>
	<div class="row" style="background: none repeat scroll 0 0 white;border-top: 1px solid #e7eaec;bottom: 0;left: 0;padding: 10px 20px;position: fixed;right: 0;">
        <div class="pull-right">
            Powered by comprudense Lcc &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        </div>
        <div>
            All rights are reserved  &copy; 2018-2019
        </div>
    </div>
     <!-- Mainly scripts -->
    <script src="<?= base_url()?>assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?= base_url()?>assets/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?= base_url()?>assets/js/plugins/iCheck/icheck.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
    </script>
	
	<!-- Custom and plugin javascript -->
    <script src="<?= base_url()?>assets/js/inspinia.js"></script>
    <script src="<?= base_url()?>assets/js/plugins/pace/pace.min.js"></script>
	
	<script src="<?= base_url()?>assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="<?= base_url()?>assets/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="<?= base_url()?>assets/js/inspinia.js"></script>
    <script src="<?= base_url()?>assets/js/plugins/pace/pace.min.js"></script>

    <!-- Password meter -->
    <script src="<?= base_url()?>assets/js/plugins/pwstrength/pwstrength-bootstrap.min.js"></script>
    <script src="<?= base_url()?>assets/js/plugins/pwstrength/zxcvbn.js"></script>
	
	 <script>
	 // Example 3
		 $(document).ready(function(){
            var options3 = {};
			options3.ui = {
				container: "#pwd-container3",
				showVerdictsInsideProgressBar: true,
				viewports: {
					progress: ".pwstrength_viewport_progress2"
				}
			};
			options3.common = {
				debug: true,
				usernameField: "#username"
			};
			$('.example3').pwstrength(options3);
		})
	 </script>
	</body>
</html>
