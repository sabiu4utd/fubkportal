<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/x-icon" />
    <title><?php echo $_SESSION['pageTitle']; ?></title>

    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body class="font-muli theme-cyan gradient">
	<form method="post" action="<?php echo site_url('auth/changepass');?>" autocomplete="off">
    <div class="auth option2">
        <div class="auth_left" style="width:500px;">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <a class="header-brand" href="#">
                            <div class="card-title mt-3"><img src="<?php echo base_url();?>assets/images/university-logo.png" /></div>
                            <div class="card-title mt-2">University Portal<br>Reset Password</div>
                        </a>
                        <?php if($this->session->flashdata('msg')){ ?>
                        <p class="alert alert-warning text-center" style="font-size:14px">
                            <?php echo $this->session->flashdata('msg') ?>
                        </p>
                        <?php } ?>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control text-center" placeholder="Enter New Password" required name="password" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control text-center" placeholder="Re-enter Password" required name="cpassword" autocomplete="off">
                    </div>
                    <div class="text-center">
                         <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                        <br>
                        <div class="text-muted mt-1"><a href="<?php echo site_url('auth/index')?>">Go Back</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	</form>
   
    <script src="<?php echo base_url()?>assets/bundles/lib.vendor.bundle.js"
        type="e4a7806aed088581f862dd92-text/javascript"></script>

    <script src="<?php echo base_url()?>assets/js/core.js" type="e4a7806aed088581f862dd92-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/js/rocket-loader.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>
