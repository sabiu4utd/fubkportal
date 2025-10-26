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
            <?php
                $this->load->view('incs/pageheader'); 
                $totals = $staffdist[0]->total + $staffdist[1]->total + $staffdist[2]->total + $staffdist[3]->total;
            ?>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="card">
                        <div class="row">
                            <div class="col-lg-2">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span class="float-left">
                                                <b>Total Staff</b>
                                                <div class="num"><?php echo number_format($totals, 0, ".", ","); ?></div>
                                                <div class="per">100%</div>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span class="float-left">
                                            <b><?php echo $staffdist[0]->gender; ?> Staff</b>
                                            <div class="num"><?php echo number_format($staffdist[0]->total + $staffdist[1]->total, 0, ".", ","); ?></div>
                                            <div class="per"><?php echo number_format(100 * ($staffdist[0]->total + $staffdist[1]->total) / $totals, 2, ".", ","); ?>%</div>
                                        </span>
                                        <span class="float-right">
                                            <b><?php echo $staffdist[2]->gender; ?> Staff</b>
                                            <div class="num"><?php echo number_format($staffdist[2]->total + $staffdist[3]->total, 0, ".", ","); ?></div>
                                            <div class="per"><?php echo number_format(100 * ($staffdist[2]->total + $staffdist[3]->total) / $totals, 2, ".", ","); ?>%</div>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-3 card-body">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <span class="float-left">
                                            <b><?php echo $staffdist[0]->employee_type; ?></b>
                                            <div class="num"><?php echo number_format($staffdist[0]->total + $staffdist[2]->total, 0, ".", ","); ?></div>
                                            <div class="per"><?php echo number_format(100 * ($staffdist[0]->total + $staffdist[2]->total) / $totals, 2, ".", ","); ?>%</div>
                                        </span>
                                        <span class="float-right">
                                            <b><?php echo $staffdist[1]->employee_type; ?></b>
                                            <div class="num"><?php echo number_format($staffdist[1]->total + $staffdist[3]->total, 0, ".", ","); ?></div>
                                            <div class="per"><?php echo number_format(100 * ($staffdist[1]->total + $staffdist[3]->total) / $totals, 2, ".", ","); ?>%</div>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4">
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <span class="float-left">
                                                <b>Teaching Staff</b>
                                                <div class="num">-</div>
                                                <div class="per">-</div>
                                            </span>
                                            <span class="float-right">
                                                <b>Non-Teaching Staff</b>
                                                <div class="num">-</div>
                                                <div class="per">-</div>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a href="<?php echo site_url('staff/list')?>" class="btn btn-primary float-right">View Staff List</a>
                                                    <p class="text-muted m-b-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align: left;">Faculty Name</th>
                                                                    <th>Total</th>
                                                                    <th>Male</th>
                                                                    <th>Female</th>
                                                                    <th>Junior</th>
                                                                    <th>Senior</th>
                                                                    <th>Tenure</th>
                                                                    <th>Visiting</th>
                                                                    <th>Sabbatical</th>
                                                                    <th>Contract</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $i = 1;$tmale=0;$tfemale=0;$tjunior=0; $tsenior=0; $ttenure=0; $tvisiting=0; $tsabbatical=0; $tcontract=0;$ttotal = 0;
                                                                foreach ($facultydist as $row) { 
                                                                    $ftotal = $row->male + $row->female;
                                                                    $ttotal = $row->male + $row->female;
                                                                    $tmale +=$row->male; 
                                                                    $tfemale += $row->female; 
                                                                    $tjunior += $row->junior;
                                                                    $tsenior += $row->senior;
                                                                    $ttenure += $row->tenure;
                                                                    $tvisiting += $row->visiting;
                                                                    $tsabbatical += $row->sabbatical;
                                                                    $tcontract += $row->contract;
                                                                ?>
                                                                    <tr>
                                                                        <td><?php echo ucwords($row->division_name) ?></td>
                                                                        <td class="text-right"><?php echo number_format($ftotal, 0, ".", ","). '<br>('.number_format(100*$ftotal/$totals, 2, ".", ",").'%)' ?></td>
                                                                        <td class="text-right"><?php echo number_format($row->male, 0, ".", ","). '<br>('.number_format(100*$row->male/$ftotal, 2, ".", ",").'%)' ?></td>
                                                                        <td class="text-right"><?php echo number_format($row->female, 0, ".", ","). '<br>('.number_format(100*$row->female/$ftotal, 2, ".", ",").'%)' ?></td>
                                                                        <td class="text-right"><?php echo number_format($row->junior, 0, ".", ","). '<br>('.number_format(100*$row->junior/$ftotal, 2, ".", ",").'%)' ?></td>
                                                                        <td class="text-right"><?php echo number_format($row->senior, 0, ".", ","). '<br>('.number_format(100*$row->senior/$ftotal, 2, ".", ",").'%)' ?></td>
                                                                        <td class="text-right"><?php echo number_format($row->tenure, 0, ".", ","). '<br>('.number_format(100*$row->tenure/$ftotal, 2, ".", ",").'%)' ?></td>
                                                                        <td class="text-right"><?php echo number_format($row->visiting, 0, ".", ","). '<br>('.number_format(100*$row->visiting/$ftotal, 2, ".", ",").'%)' ?></td>
                                                                        <td class="text-right"><?php echo number_format($row->sabbatical, 0, ".", ","). '<br>('.number_format(100*$row->sabbatical/$ftotal, 2, ".", ",").'%)' ?></td>
                                                                        <td class="text-right"><?php echo number_format($row->contract, 0, ".", ","). '<br>('.number_format(100*$row->contract/$ftotal, 2, ".", ",").'%)' ?></td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>Totals</th>
                                                                    <th><?php echo $ttotal?></th>
                                                                    <th><?php echo $tmale?></th>
                                                                    <th><?php echo $tfemale?></th>
                                                                    <th><?php echo $tjunior?></th>
                                                                    <th><?php echo $tsenior?></th>
                                                                    <th><?php echo $ttenure?></th>
                                                                    <th><?php echo $tvisiting?></th>
                                                                    <th><?php echo $tsabbatical?></th>
                                                                    <th><?php echo $tcontract?></th>
                                                                </tr>
                                                            </tfoot>
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