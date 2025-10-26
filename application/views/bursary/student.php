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

    <div id="main_content">
        <?php
        $this->load->view('incs/header');
        $this->load->view('incs/lside');
        ?>
        <div class="page">

            <?php $this->load->view('incs/pageheader'); ?>


            <div class="section-body mt-4 mb-2">
                <div class="container-fluid">
                        
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-center">
                                        Payment History for <?php echo $history[0]->surname.", ".$history[0]->firstname." ".$history[0]->othername." - (". $history[0]->pnumber.')'; ?>
                                        <span class="float-right">
                                            <a href="<?php echo site_url('bursary');?>"><i class="fa fa-arrow-left"></i> Go Back</a>
                                        </span>
                                    </h5>
                                    <hr>
                                    <p class="text-muted m-b-0 row">
                                    <div class="table-responsive col-md-5 col-sm-12">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                            <thead>
                                                <tr>
                                                    <th>Admission Number</th><td><?php echo $history[0]->pnumber; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Full name</th><td><?php echo $history[0]->surname.", ".$history[0]->firstname." ".$history[0]->othername; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Program</th><td><?php echo $history[0]->prog_abbr; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Level</th><td><?php echo $history[0]->current_level; ?> Level</td>
                                                </tr>
                                                <tr>
                                                    <th>Gender/ Entry Mode</th><td><?php echo $history[0]->gender.'/ '.$history[0]->entrymode; ?></td>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="table-responsive col-md-8 col-sm-12">
                                        <hr>
                                        Payment History
                                        <hr>
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Session</th>
                                                    <th>Level</th>
                                                    <th>Type</th>
                                                    <th>Amount</th>
                                                    <th>RRR</th>
                                                    <th>Status</th>
                                                    <th>Receipt</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $i = 1; 
                                                    foreach ($history as $row) {
                                                        $rrr = str_replace("-", "", $row->rrr);
                                                        $_rrr = substr($rrr, 0, 4)."-".substr($rrr, 4, 4)."-".substr($rrr, 8);
                                                        $amount = str_replace(".", "", $row->amount);
                                                        $amount = str_replace(",", "", $amount);
                                                        
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $row->session; ?></td>
                                                        <td><?php echo $row->level; ?></td>
                                                        <td><?php echo $row->type; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($amount) ? number_format($amount,2,'.',','): $amount; ?></td>
                                                        <td><?php echo $_rrr; ?></td>
                                                        <td><?php echo $row->status; ?></td>
                                                        <td>
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
    <script>
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>

</html>