<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['pageTitle']; ?></title>

    <link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.ico" type="image/x-icon" />

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/dropify/css/dropify.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/summernote/dist/summernote.css" />

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <style>
        .blink_me {
            animation: blinker 3s linear infinite;
            font-weight: bolder;
            color: brown;
            text-decoration: underline;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }


        .raise:hover, .raise:focus {
            box-shadow: 0 0.1em 0.1em -0.1em;
            transform: translateY(-0.45em);
            border-color: #ffa260;
        }
    </style>


</head>


<body class="font-muli right_tb_toggle <?php echo " " . $_SESSION['theme_mode']; ?>">

    <div class="page-loader-wrapper">
        <div class="loader"></div>
    </div>
    <div id="main_content">
        <?php
            $this->load->view('incs/header');
            $this->load->view('incs/lside');
        ?>
        <div class="page">

            <?php $this->load->view('incs/pageheader'); ?>

            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action">

                        </div>

                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-9 col-sm-12">
                            <div class="row clearfix">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                                                <h3 class="card-title" style="min-width: 100%;">
                                                    Management Options
                                                </h3>
                                            </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="row clearfix">
                                                <div class="col-xl-12">
                                                    <div class="row clearfix row-deck">
                                                        <div class="col-6 col-md-2 raise">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <a href="<?php echo site_url('management/') ?>" class="my_sort_cut text-muted">
                                                                        <i class="fa fa-users"></i>
                                                                        <span>Student Information Center</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-2 raise">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <a href="<?php echo site_url('management') ?>" class="my_sort_cut text-muted">
                                                                        <i class="fa fa-user-secret"></i>
                                                                        <span>Staff Information Center</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-2 raise">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <a href="<?php echo site_url('management/') ?>" class="my_sort_cut text-muted">
                                                                        <i class="fa fa-chart-line"></i>
                                                                        <span>Business Intelligence</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-2 raise">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <a href="<?php echo site_url('') ?>" class="my_sort_cut text-muted">
                                                                        <i class="fa fa-vote-yea"></i>
                                                                        <span>Result Management</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-2 raise">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <a href="<?php echo site_url('') ?>" class="my_sort_cut text-muted">
                                                                        <i class="fa fa-file-export"></i>
                                                                        <span>University Reports</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-2 raise">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                    <a href="<?php echo site_url('') ?>" class="my_sort_cut text-muted">
                                                                        <i class="fa fa-sms"></i>
                                                                        <span>Notification</span>
                                                                    </a>
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
                            <div class="row clearfix">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                                                <h3 class="card-title" style="min-width: 100%;">
                                                    My Employment
                                                </h3>

                                            </a>
                                            <div class="card-options">
                                                <i class="fa fa-toggle-on text-primary fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row clearfix row-deck">
                                                <div class="col-6 col-md-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('staff/view') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-user-circle"></i>
                                                                <span>My Information</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('payslip/myslips') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-dollar"></i>
                                                                <span>My Payslips</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-fast-forward"></i>
                                                                <span>My Promotion</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-network-wired"></i>
                                                                <span>My Development</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-map-signs"></i>
                                                                <span>My Holidays</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-md-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-spell-check"></i>
                                                                <span>My Appraisals</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <img src="<?php echo base_url('assets/images/' . $staff->passport) ?>" alt="<?php echo $staff->passport; ?>">
                                    <hr>
                                    <div class="wid-u-info">
                                        <h5 class="text-center">
                                            <?php echo strtoupper($staff->uniqueID) ?>
                                            <hr>
                                            <?php echo strtoupper($staff->surname) . ' ' . ucwords(strtolower($staff->firstname . ' ' . $staff->othernames)); ?>
                                            <hr>
                                            <?php echo strtoupper($staff->designation) ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>


            </div>
            <?php $this->load->view('incs/footer'); ?>
        </div>

    </div>


    <script src="<?php echo base_url() ?>assets/bundles/lib.vendor.bundle.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>

    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/dropify/js/dropify.min.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/bundles/summernote.bundle.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>

    <script src="<?php echo base_url() ?>assets/js/core.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/form/dropify.js" type="e27f9daa9c2f25670b2c3761-text/javascript">
    </script>
    <script src="<?php echo base_url() ?>assets/js/page/summernote.js" type="e27f9daa9c2f25670b2c3761-text/javascript">
    </script>
    <script src="<?php echo base_url() ?>assets/js/rocket-loader.min.js" data-cf-settings="e27f9daa9c2f25670b2c3761-|49" defer=""></script>
</body>

</html>