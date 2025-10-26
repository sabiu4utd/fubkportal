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

        .num {
            font-size: 28px;
            font-weight: bolder;
            text-align: center;
        }

        .per {
            font-size: 18px;
            font-weight: bolder;
            text-align: center;
        }

        span b {
            text-transform: uppercase;
        }
        thead th, tfoot th{
            text-align: right;
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
            
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-7 col-sm-12">
                                <div class="card-title text-center pt-2" style="font-size:17px; font-weight:900">Quick Analytics</div>
                                <div class="row">
                                    <!--<div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span>
                                                        <div class="text-center" style="font-weight:900; padding-bottom:4px; font-size:17px">Total Forms Ordered</div>
                                                        <div class="num"><?php echo $stats->all_forms;?></div>
                                                        <div class="per">100%</div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span>
                                                        <div class="text-center" style="font-weight:900; padding-bottom:4px; font-size:17px">Submitted Forms</div>
                                                        <div class="num"><?php echo $stats->submitted;?></div>
                                                        <div class="per"><?php echo number_format(100*$stats->submitted/$stats->all_forms, 2, '.', ',');?>%</div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span>
                                                        <div class="text-center" style="font-weight:900; padding-bottom:4px; font-size:17px">Not Submitted Forms</div>
                                                        <div class="num"><?php echo $stats->not_submitted;?></div>
                                                        <div class="per"><?php echo number_format(100*$stats->not_submitted/$stats->all_forms, 2, '.', ',');?>%</div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span>
                                                        <div class="text-center" style="font-weight:900; padding-bottom:4px; font-size:17px">Male </div>
                                                        <div class="num"><?php echo $stats->male;?></div>
                                                        <div class="per"><?php echo number_format(100*$stats->male/$stats->submitted, 2, '.', ',');?>%</div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span>
                                                        <div class="text-center" style="font-weight:900; padding-bottom:4px; font-size:17px">Female </div>
                                                        <div class="num"><?php echo $stats->female;?></div>
                                                        <div class="per"><?php echo number_format(100*$stats->female/$stats->submitted, 2, '.', ',');?>%</div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>-->
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span>
                                                        <div class="text-center" style="font-weight:900; padding-bottom:4px; font-size:17px">Arts</div>
                                                        <div class="num"><?php echo $stats->Arts;?></div>
                                                        <div class="per"><?php echo number_format(100*$stats->Arts/$stats->submitted, 2, '.', ',');?>%</div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span>
                                                        <div class="text-center" style="font-weight:900; padding-bottom:4px; font-size:17px">Science</div>
                                                        <div class="num"><?php echo $stats->Science;?></div>
                                                        <div class="per"><?php echo number_format(100*$stats->Science/$stats->submitted, 2, '.', ',');?>%</div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6">
                                        <div class="card-body">
                                            <ul class="list-group">
                                                <li class="list-group-item">
                                                    <span>
                                                        <div class="text-center" style="font-weight:900; padding-bottom:4px; font-size:17px">Environmental</div>
                                                        <div class="num"><?php echo $stats->Environmental;?></div>
                                                        <div class="per"><?php echo number_format(100*$stats->Environmental/$stats->submitted, 2, '.', ',');?>%</div>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-12 pt-4">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <p class="text-muted m-b-0">
                                                <div class="table-responsive">
                                                    <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Form Name</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Status</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Manage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($forms as $row) {
                                                            if ($row->id == 3){?>
                                                                <tr>
                                                                    <td><?php echo ucwords($row->form_name) ?></td>
                                                                    <td><?php echo ucwords($row->status) ?></td>
                                                                    <td><?php echo '<a href="'.site_url('sbs/viewall') .'">View Forms</a>';?></td>
                                                                </tr>
                                                            <?php }} ?>
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