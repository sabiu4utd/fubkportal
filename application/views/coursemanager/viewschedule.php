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
            <?php $this->load->view('incs/pageheader');  ?>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <a href="<?php echo site_url('course/changecourseschedulestatus')?>" style="float:left" class="btn btn-outline-primary">
                                        <i class="fa fa-recycle text-primary"></i> Update Course Schedule Status
                                    </a>
                                </div>
                                <div class="fw-bold text-center col alert alert-<?php echo $courseInfo[0]->approval_status == 'approved'? 'success': 'danger'; ?>">
                                    CURRENT STATUS: <?php echo strtoupper($courseInfo[0]->approval_status); ?>
                                </div>
                                <div class="col">
                                    <a href="<?php echo site_url('course/deptcoursescheule')?>" style="float:right; "><i class="fa fa-arrow-left text-primary"></i> Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <p>
                                    <h3 style="text-center">
                                        Course schedule
                                        
                                        <a href="<?php echo site_url()?>" class="text-primary float-right btn btn-outline-success" style="font-size:14px">
                                            <i class="fa fa-plus"></i> Add New Course
                                        </a>
                                    </h3>
                                </p>
                                <p class="text-muted m-b-0">
                                    <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5" style="border: 1px solid gray">
                                        <tr>
                                            <th style="text-align: left; color:black">Programme</th><td><?php echo $progInfo->prog_abbr; ?></td>
                                            <th style="text-align: left; color:black">Level</th><td><?php echo $courseInfo[0]->level; ?></td>
                                            <th style="text-align: left; color:black">Session</th><td><?php echo $courseInfo[0]->session; ?></td>
                                            <th style="text-align: left; color:black">Department</th><td><?php echo $progInfo->dept_name; ?></td>
                                        </tr>
                                        
                                    </table>
                                    <div class="table-responsive">
                                    <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                        <thead>
                                            <tr>
                                                <th style="text-align: left;">#</th>
                                                <th style="text-align: left;">Course Code</th>
                                                <th style="text-align: left;">Course Title</th>
                                                <th style="text-align: left;">Units</th>
                                                <th style="text-align: left;">Semester</th>
                                                <th style="text-align: left;">Type</th>
                                                <th style="text-align: left;">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; $totalUnits = 0; foreach ($courseInfo as $row) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo strtoupper($row->course_code) ?></td>
                                                    <td><?php echo $row->course_title ?></td>
                                                    <td><?php 
                                                        echo $row->credit_unit; 
                                                        $totalUnits += $row->credit_unit;
                                                    ?></td>
                                                    <td><?php echo ucwords($row->semester) ?></td>
                                                    <td><?php echo ucwords($row->type) ?></td>
                                                    <td>
                                                        <a href="<?php echo site_url('course/removefromschedule') ?>" class="text-danger">
                                                            <i class="fa fa-trash"></i> Remove
                                                        </a>
                                                    </td>
                                                    
                                                </tr>
                                            <?php } ?>
                                                <tr>
                                                    <td colspan="3" style="text-align:right; font-weight:900">Total Credit Units</td>
                                                    <td style="text-align:left; font-weight:900"><?php 
                                                        echo  $totalUnits;
                                                    ?></td>
                                                    <td>&nbsp;</td>
                                                    
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