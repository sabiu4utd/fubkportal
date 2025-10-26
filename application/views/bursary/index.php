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
    </style>


</head>


<body class="font-muli right_tb_toggle <?php echo " " . $_SESSION['theme_mode']; ?>">

    <!--<div class="page-loader-wrapper">-->
    <!--    <div class="loader"></div>-->
    <!--</div>-->
    <div id="main_content">
        <?php
        $this->load->view('incs/header');
        $this->load->view('incs/lside');
        ?>
        <div class="page">

            <?php $this->load->view('incs/pageheader'); ?>


            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-xl-12">
                            <div class="row clearfix row-deck">

                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <div>
                                                <b>Current Session: </b>
                                                <span class="float-right"><?php echo $_SESSION['active_session']; ?></span>
                                            </div>
                                            <hr>
                                            <div >
                                                <b>Current Semester: </b>
                                                <span class="float-right"><?php echo $_SESSION['active_semester_value']; ?> Semester</span>
                                            </div>
                                                
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('bursary/list') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-file-pdf"></i>
                                                <span>Payments List</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('bursary/analysis') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-chart-line"></i>
                                                <span>Payment Analysis</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('payment/schedule') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-list"></i>
                                                <span>Payment Schedule</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('payslip') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-money-check"></i>
                                                <span>Payslips Manager</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('payment/nelfund') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-file-export"></i>
                                                <span>Nelfund</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-xl-12">
                            <form method="post" action="<?php echo site_url('bursary/search')?>">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row clearfix row-deck">
                                            <div class="col-9">
                                                <input type="search" minlength="10" maxlength="10" required name="student_no" placeholder="Enter Student Admission Number" class="form-control"/>
                                            </div>
                                            <div class="col-3">
                                                <input type="submit" value="Search Student" class="btn btn-primary" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-center">
                                        Payment Summary by programme for <?php echo $summary[0]->session.' as at '.date('D d-m-Y'); ?>
                                    </h5>
                                    <hr>
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Program</th>
                                                    <th>Total Invoices</th>
                                                    <th>Total Invoices Paid</th>
                                                    <th>Total Invoices Unpaid</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; $totalInv = 0; $totalPaid = 0;
                                                foreach ($summary as $row) { ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo strtoupper($row->prog_abbr) ?></td>
                                                        <td><?php 
                                                            $totalInv += ($row->paid + $row->unpaid);
                                                            echo number_format(($row->paid + $row->unpaid), 0, ".", ","); 
                                                        ?></td>
                                                        <td><?php 
                                                            $totalPaid += $row->paid;
                                                            echo number_format($row->paid, 0, ".", ","). ' ('.number_format(100 * ($row->paid / ($row->paid + $row->unpaid)), 0, ".", ",").'%)'; 
                                                        ?></td>
                                                        <td><?php echo number_format($row->unpaid, 0, ".", ","). ' ('.number_format(100 * ($row->unpaid / ($row->paid + $row->unpaid)), 0, ".", ",").'%)'; ?></td>
                                                        
                                                        <td>
                                                            <a class="btn btn-info" href="<?php echo site_url('bursary/program/' . md5(time() . rand()) . '/' . $row->programid); ?>">
                                                                <i class="fa fa-user-shield"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th colspan="2">Summaries</th>
                                                    <th><?php  echo number_format($totalInv, 0, ".", ","); ?></th>
                                                    <th><?php  echo number_format($totalPaid, 0, ".", ","). ' ('.number_format(100 * ($totalPaid / $totalInv), 0, ".", ",").'%)'; ?></th>
                                                    <th><?php  echo number_format(($totalInv - $totalPaid), 0, ".", ","). ' ('.number_format(100 * (($totalInv - $totalPaid) / $totalInv), 0, ".", ",").'%)'; ?></th>
                                                    <th>&nbsp;</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    </p>

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