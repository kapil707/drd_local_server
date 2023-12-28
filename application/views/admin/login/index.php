<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?= $this->Scheme_Model->get_website_data("title") ;?> | Login</title>
        
        <link rel="shortcut icon" href="<?= base_url()?>/uploads/manage_website/photo/<?= $this->Scheme_Model->get_website_data("icon") ;?>" type="image/x-icon">
        <link rel="icon" href="<?= base_url()?>/uploads/manage_website/photo/<?= $this->Scheme_Model->get_website_data("icon") ;?>" type="image/x-icon">
        
        <link href="<?= base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url()?>assets/font-awesome/css/font-awesome.css" rel="stylesheet">
        
        <link href="<?= base_url()?>assets/css/animate.css" rel="stylesheet">
        <link href="<?= base_url()?>assets/css/style.css" rel="stylesheet">
	</head>

	<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h4 class="logo-name1">LOGIN PANEL</h4>

            </div>
            <p>Website administration area public are prohibited!.
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <form class="m-t" role="form" method="post">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Username" required name="username" value="<?= set_value('username'); ?>">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" required name="password">
                </div>
                <div class="form-group">
					<?=  $this->session->flashdata('message1'); ?>
              	</div>
                <button type="submit" class="btn btn-primary block full-width m-b" name="Submit" value="Submit">Login</button>

                <a data-toggle="modal" href="#" data-target="#myModal4"><small>Forgot password?</small></a>
                    
                <?php /*<p class="text-muted text-center"><small>Do not have an account?</small></p> 
                <a class="btn btn-sm btn-white btn-block" href="admin/register">Create an account</a> */ ?>
            </form>
        </div>
    </div>
    <div class="row" style="background: none repeat scroll 0 0 white;border-top: 1px solid #e7eaec;bottom: 0;left: 0;padding: 10px 20px;position: fixed;right: 0;">
        <div class="pull-right">
            Powered by Wevkings&nbsp; &nbsp; &nbsp; &nbsp; 
        </div>
        <div>
            All rights are reserved  &copy; <?php echo date("Y") ?>
        </div>
    </div>
    <script src="<?= base_url()?>assets/js/jquery-3.1.1.min.js"></script>
    <script src="<?= base_url()?>assets/js/bootstrap.min.js"></script>
    
    <div class="modal inmodal" id="myModal4" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
            	<form class="m-t" role="form" method="post">
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Forgot password?</h4>
                </div>
                <div class="modal-body">
                	<div class="form-group">
                        <div class="col-sm-8">
                        <input type="text" class="form-control" placeholder="Email / Username" required name="email">
                        </div>
                        <div class="col-sm-4">
                        	<button type="submit" class="btn btn-primary block full-width m-b" name="Forget" value="Forget">Forget</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
