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
                            <a href="<?php echo site_url('levelmanager/dept')?>" style="float:right; "><i class="fa fa-arrow-left text-primary"></i> Back</a>
                            <br>
                            <div class="card-body">
                                <p><h3 style="text-center">Allocate Departmental Course Lecturer</h3></p>
                                <p><h6 style="text-center text-danger">If you want to allocate more than 1 Letcurer on a course, allocate only the course lead.<br>The course lead should email mis@fubk.edu.ng with the list of the teaching team for update </h6></p>
                                <p class="text-muted m-b-0">
                                   
                                    <div class="table-responsive row">
                                        <div class="col-md-5">
                                            <form action="<?php echo site_url('course/processallocate')?>" method="post">
                                            <table border=1 class="table js-basic-example dataTable table-striped table_custom border-style spacing5" style="border:1px solid #000; border-collapse:collapse">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: left;">Session</th>
                                                        <td><?php echo $course->session; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: left;">Semester</th>
                                                        <td><?php echo $course->semester; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: left;">Course Code</th>
                                                        <td><?php echo $course->course_code; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: left;">Course Title</th>
                                                        <td><?php echo $course->course_title; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: left;">Credit Unit</th>
                                                        <td><?php echo $course->credit_unit; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: left;">Level</th>
                                                        <td><?php echo $course->level; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align: left;">Lecturer Allocated</th>
                                                        <td>
                                                            <select class="form-control" name="lecturer_id" required>
                                                                <?php  foreach($staff as $row){
                                                                    echo "<option value='".$row->user_id."'>[".strtoupper($row->registry_file_no)."] - ".strtoupper($row->surname).", ".$row->firstname." ".$row->othername."</option>";
                                                                } ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="mx-auto;" colspan="2">
                                                            <hr>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th class="mx-auto;" colspan="2">
                                                            <input type="hidden" value="<?php echo $course->id?>" name="csid"/>

                                                            <input type="submit" value="Save Allocation" class="form-control btn btn-primary" />
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                
                                            </table>
                                        </form>
                                    </div>
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