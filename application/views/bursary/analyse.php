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
                                        <?php echo $analysis[0]->item.' analysis in '.$analysis[0]->session; ?>
                                        <span style="float:right;">
                                            <a href="<?php echo site_url('bursary/analysis')?>" class="btn btn-success"><i class="fa fa-arrow-circle-left"></i> Go Back</a>
                                        </span>
                                    </h5>
                                    <hr>
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Program</th>
                                                    <th>100L</th>
                                                    <th>200L</th>
                                                    <th>300L</th>
                                                    <th>400L</th>
                                                    <th>410L</th>
                                                    <th>420L</th>
                                                    <th>500L</th>
                                                    <th>510L</th>
                                                    <th>520L</th>
                                                    <th style="font-weight:bold">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    $i = 1; $total = 0;
                                                    $total100L = $total200L = $total300L = $total400L = $total410L = $total420L = $total500L = $total510L = $total520L = 0;
                                                    foreach ($analysis as $row) {
                                                        $total100L += $row->L100;
                                                        $total200L += $row->L200;
                                                        $total300L += $row->L300;
                                                        $total400L += $row->L400;
                                                        $total410L += $row->L410;
                                                        $total420L += $row->L420;
                                                        $total500L += $row->L500;
                                                        $total510L += $row->L510;
                                                        $total520L += $row->L520;
                                                        
                                                        $subtotal = $row->L100;
                                                        $subtotal += $row->L200;
                                                        $subtotal += $row->L300;
                                                        $subtotal += $row->L400;
                                                        $subtotal += $row->L410;
                                                        $subtotal += $row->L420;
                                                        $subtotal += $row->L500;
                                                        $subtotal += $row->L510;
                                                        $subtotal += $row->L520;
                                                        
                                                        $total += $subtotal;
                                                ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $row->prog_abbr; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($row->L100) ? number_format($row->L100,2,'.',','): $row->L100; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($row->L200) ? number_format($row->L200,2,'.',','): $row->L200; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($row->L300) ? number_format($row->L300,2,'.',','): $row->L300; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($row->L400) ? number_format($row->L400,2,'.',','): $row->L400; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($row->L410) ? number_format($row->L410,2,'.',','): $row->L410; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($row->L420) ? number_format($row->L420,2,'.',','): $row->L420; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($row->L500) ? number_format($row->L500,2,'.',','): $row->L500; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($row->L510) ? number_format($row->L510,2,'.',','): $row->L510; ?></td>
                                                        <td>&#8358;<?php echo is_numeric($row->L520) ? number_format($row->L520,2,'.',','): $row->L520; ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo is_numeric($subtotal) ? number_format($subtotal,2,'.',','): $subtotal; ?></td>
                                                    </tr>
                                                <?php } ?>
                                                    <tr>
                                                        <td colspan="2" style="font-weight:bold">Grand Total</td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total100L,2,'.',','); ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total200L,2,'.',','); ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total300L,2,'.',','); ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total400L,2,'.',','); ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total410L,2,'.',','); ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total420L,2,'.',','); ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total500L,2,'.',','); ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total510L,2,'.',','); ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total520L,2,'.',','); ?></td>
                                                        <td style="font-weight:bold">&#8358;<?php echo number_format($total,2,'.',','); ?></td>
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
    <script>
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>

</html>