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
            <div class="section-body mt-4">
                <div class="container-fluid">
                    
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-center">Admissions Summary</h5>
                                    <hr>
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Session</th>
                                                    <th>Admitted</th>
                                                    <th>Male</th>
                                                    <th>Female</th>
                                                    <th>UTME</th>
                                                    <th>MATRIC</th>
                                                    <th>DE</th>
                                                    <th>PG</th>
                                                    <th>Kebbi</th>
                                                    <th>Other States</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; foreach($adm_summary as $row){ ?>
                                                <tr>
                                                    <td><?php echo $i++;?></td>
                                                    <td><?php echo $row->session_admitted;?></td>
                                                    <td><?php echo number_format($row->total_admitted, 0, '.', ','); ?></td>
                                                    <td><?php echo '<b>'.number_format($row->total_male, 0, '.', ','). '</b><br>('.number_format((100*$row->total_male/$row->total_admitted), 1, '.', ',').'%)';?></td>
                                                    <td><?php echo '<b>'.number_format($row->total_female, 0, '.', ','). '</b><br>('.number_format((100*$row->total_female/$row->total_admitted), 1, '.', ',').'%)';?></td>
                                                    <td><?php echo '<b>'.number_format($row->total_utme, 0, '.', ','). '</b><br>('.number_format((100*$row->total_utme/$row->total_admitted), 1, '.', ',').'%)';?></td>
                                                    <td><?php echo '<b>'.number_format($row->total_matric, 0, '.', ','). '</b><br>('.number_format((100*$row->total_matric/$row->total_admitted), 1, '.', ',').'%)';?></td>
                                                    <td><?php echo '<b>'.number_format($row->total_de, 0, '.', ','). '</b><br>('.number_format((100*$row->total_de/$row->total_admitted), 1, '.', ',').'%)';?></td>
                                                    <td><?php echo '<b>'.number_format($row->total_pg, 0, '.', ','). '</b><br>('.number_format((100*$row->total_pg/$row->total_admitted), 1, '.', ',').'%)';?></td>
                                                    <td><?php echo '<b>'.number_format($row->total_kebbi, 0, '.', ','). '</b><br>('.number_format((100*$row->total_kebbi/$row->total_admitted), 1, '.', ',').'%)';?></td>
                                                    <td><?php echo '<b>'.number_format($row->total_other, 0, '.', ','). '</b><br>('.number_format((100*$row->total_other/$row->total_admitted), 1, '.', ',').'%)';?></td>
                                                    <td><a href="<?php echo site_url('registration/admissions/'.str_replace('/', '_', $row->session_admitted));?>" class="btn btn-info">
                                                        <i class="fa fa-user-shield"></i> 
                                                        </a></td>
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
</body>
</html>