<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['pageTitle']; ?></title>

    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/summernote/dist/summernote.css" />
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
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="header-action">
                            <h1 class="page-title">Dashboard</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo site_url('regsitrar')?>">Registrar</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="admin-Dashboard" role="tabpanel">
                            <div class="row clearfix">
                                <div class="col-sm-12 col-md-5 col-lg-3 col-xl-3">
                                    <div class="row clearfix">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Distribution by Gender</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div id="staff-by-gender"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Distribution by Cadre</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div id="staff-by-cadre"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-7 col-lg-9 col-xl-9">
                                    <div class="row clearfix">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Distribution by Designation</h3>
                                                </div>
                                                <div class="card-body">
                                                    <div id="staff-by-designation"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        type="ac287540f1c670014beeb87c-text/javascript"></script>

    <script src="<?php echo base_url()?>assets/bundles/counterup.bundle.js"
        type="ac287540f1c670014beeb87c-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/bundles/apexcharts.bundle.js"
        type="ac287540f1c670014beeb87c-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/bundles/summernote.bundle.js"
        type="ac287540f1c670014beeb87c-text/javascript"></script>

    <script src="<?php echo base_url()?>assets/js/core.js" type="ac287540f1c670014beeb87c-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/js/page/index.js" type="ac287540f1c670014beeb87c-text/javascript">
    </script>
    <script src="<?php echo base_url()?>assets/js/page/summernote.js" type="ac287540f1c670014beeb87c-text/javascript">
    </script>
    <script src="<?php echo base_url()?>assets/js/rocket-loader.min.js" data-cf-settings="ac287540f1c670014beeb87c-|49"
        defer=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="<?php echo base_url()?>assets/js/charted.js" data-cf-settings="ac287540f1c670014beeb87c-|49" defer="">
    </script>
</body>

</html>
<div
