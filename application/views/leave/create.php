<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['pageTitle']; ?></title>

    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/dropify/css/dropify.min.css">

    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body class="font-muli right_tb_toggle <?php echo " ".$_SESSION['theme_mode']; ?>">

    <div class="page-loader-wrapper">
        <div class="loader"></div>
    </div>
    <div id="main_content">
        <?php $this->load->view('incs/header');?>
        <?php //$this->load->view('incs/rside');?>
        <?php $this->load->view('incs/lside');?>

        <div class="page">

            <?php $this->load->view('incs/pageheader');?>

            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action">
                            <h1 class="page-title">Leave Application</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item active" aria-current="page"><a
                                        href="<?php echo site_url('leave/myleave')?>">My Leave</a></li>
                                <li class="breadcrumb-item active" aria-current="page">New Application</li>
                            </ol>
                        </div>
                        <a href="<?php echo site_url('leave/myleave');?>" class="btn btn-success btn-sm">My Leave
                            Application</a>
                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active show" id="Company_Settings">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Create New Leave Application</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" action="<?php echo site_url('leave/add');?>">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Type of Leave<span class="text-danger">*</span></label>
                                                    <select class="form-control" required name="type">
                                                        <option>Annual Leave</option>
                                                        <option>Sick Leave</option>
                                                        <option>Maternity Leave</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Start Date <span class="text-danger">*</span></label>
                                                    <input class="form-control" required type="date" name="start_date" value="Enter Start Date">
                                                </div>
                                            </div>
											<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>End Date <span class="text-danger">*</span></label>
                                                    <input class="form-control" required type="date" name="end_date" value="Enter Start Date">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <label>Leave Reason</label>
                                                    <textarea rows="10" required class="form-control" required name="reason"></textarea>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 text-right m-t-20">
                                                <button type="submit" class="btn btn-primary">SAVE</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php $this->load->view('incs/footer');?>
        </div>
    </div>

    <script src="<?php echo base_url()?>assets/bundles/lib.vendor.bundle.js"
        type="75560d4ce0e5dd10f50ac65a-text/javascript"></script>

    <script src="<?php echo base_url()?>assets/plugins/dropify/js/dropify.min.js"
        type="75560d4ce0e5dd10f50ac65a-text/javascript"></script>

    <script src="<?php echo base_url()?>assets/js/core.js" type="75560d4ce0e5dd10f50ac65a-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/js/form/dropify.js" type="75560d4ce0e5dd10f50ac65a-text/javascript">
    </script>
    <script src="<?php echo base_url()?>assets/js//rocket-loader.min.js" data-cf-settings="75560d4ce0e5dd10f50ac65a-|49"
        defer=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>
