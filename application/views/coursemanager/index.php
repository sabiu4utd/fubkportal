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
                                            <a href="<?php echo site_url('course/manager') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-file-pdf"></i>
                                                <span>Course Schedule</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('course/courselist') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-file"></i>
                                                <span>Attendance List</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('course/courselist') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-user-secret"></i>
                                                <span>Lecturer Allocation</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('course/load_courses') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-tools"></i>
                                                <span>Create Course Schedule</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="#<?php echo site_url('') ?>" class="my_sort_cut text-muted" onclick="alert('feature coming soon')">
                                                <i class="fa fa-file-export"></i>
                                                <span>Reports</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-center">Course Manager</h4>
                                    <hr>
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                        <thead>
                                            <tr>
                                                <th style="text-align: left;">#</th>
                                                <th style="text-align: left;">Programme</th>
                                                <th style="text-align: left;">Level</th>
                                                <th style="text-align: left;">Credit Units</th>
                                                <th style="text-align: left;">Session</th>
                                                <th style="text-align: left;">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($course_dist as $row) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo ucwords($row->prog_abbr) ?></td>
                                                    <td><?php  echo $row->level; ?> </td>
                                                    <td><?php echo number_format($row->credit_units, 0, ".", ",") ?></td>
                                                    <td><?php echo $row->session ?></td>
                                                    <td><a href="<?php echo site_url('course/course_schedule/'.hash('sha512', time()).'/'.$row->sessionid.'/'.$row->programid.'/'.$row->level.'/'.hash('sha512', time()))?>"><i class="fa fa-eye"></i> View</a></td>
                                                    
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
                            <select name="current_session" style="float:right; width: 200px" class="form-control">
                                <option>2022/2023</option>
                            </select>
                            <br>
                            <div class="card-body">
                                <p class="text-muted m-b-0">
                                <div class="table-responsive">
                                    <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                        <thead>
                                            <tr>
                                                <th style="text-align: left;">#</th>
                                                <th style="text-align: left;">Programme</th>
                                                <th style="text-align: left;">Level</th>
                                                <th style="text-align: left;">Credit Units</th>
                                                <th style="text-align: left;">Session</th>
                                                <th style="text-align: left;">Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($course_dist as $row) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo ucwords($row->prog_abbr) ?></td>
                                                    <td><?php  echo $row->level.'00'; ?> </td>
                                                    <td><?php echo number_format($row->credit_units, 0, ".", ",") ?></td>
                                                    <td><?php echo $row->session ?></td>
                                                    <td><a href="<?php echo site_url('course/course_schedule/'.hash('sha512', time()).'/'.$row->sessionid.'/'.$row->programid.'/'.$row->level.'/'.hash('sha512', time()))?>"><i class="fa fa-eye"></i> View</a></td>
                                                    
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