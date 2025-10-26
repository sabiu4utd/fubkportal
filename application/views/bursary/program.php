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

                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <?php if(count($summary) > 0){?>
                                <div class="card-body">
                                    <h5 class="text-center">
                                        Payment Summary for <?php echo $summary[0]->prog_abbr.' '.$summary[0]->session.' as at '.date('D d-m-Y'); ?>
                                        <span style="float:right;">
                                            <a href="<?php echo site_url('bursary')?>" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> Go Back</a>
                                        </span>
                                    </h5>
                                    <hr>
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Student ID</th>
                                                    <th>Full name</th>
                                                    <th>Level</th>
                                                    <th>Session</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>RRR</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; $totalInv = 0; $totalPaid = 0;
                                                foreach ($summary as $row) { 
                                                
                                                $rrr = str_replace("-", "", $row->rrr);
                                                $_rrr = substr($rrr, 0, 4)."-".substr($rrr, 4, 4)."-".substr($rrr, 8);
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td>
                                                            <a href="<?php echo site_url('bursary/search/'.$row->pnumber);?>">
                                                            <?php echo $row->pnumber ?>
                                                            </a>
                                                        </td>
                                                        <td><?php echo $row->fullname ?></td>
                                                        <td><?php echo strtoupper($row->level) ?></td>
                                                        <td><?php echo strtoupper($row->session) ?></td>
                                                        <td><?php echo $row->type ?></td>
                                                        <td><?php 
                                                            $amount = str_replace(".", "", $row->amount);
                                                            $amount = str_replace(",", "", $row->amount);
                                                            echo is_numeric($amount) ? number_format($amount, 2, ".", ",") : 0; 
                                                        ?></td>
                                                        <td><?php echo $_rrr; ?></td>
                                                        <td><?php echo strtoupper($row->payment_status); ?></td>
                                                        <td class="text-info">
        													<span>
                                                                <a href="https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/<?php echo $rrr;?>/printinvoiceRequest.pdf" target="_blank">
                                                                <i class="fa fa-print"></i> Receipt
                                                                </a>
        													</span>
        												</td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    </p>

                                </div>
                                <?php }else{
                                    echo "<p class='alert alert-warning'>No records found</p>";
                                } ?>

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