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
            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action">
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <a href="<?php echo site_url('registration/admissions/' . str_replace("/", "_", $_SESSION['adm_session'])) ?>" class="btn btn-info float-left" style="margin-right:25px">
                                        <i class="fa fa-chevron-circle-left fa-lg"></i>
                                    </a>
                                    <?php $this->load->view('incs/student_header') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body mt-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                <?php $this->load->view('incs/student_media');?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted m-b-0">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Title</div>
                                            <div><?php echo $student_info->title; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Surname</div>
                                            <div><?php echo $student_info->surname; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Firstname</div>
                                            <div><?php echo $student_info->firstname; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Othername</div>
                                            <div><?php echo $student_info->othername; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Admission Number</div>
                                            <div><?php echo $student_info->pnumber; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">JAMB Number</div>
                                            <div><?php echo $student_info->jamb_no; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Current Level</div>
                                            <div><?php echo strtoupper($student_info->current_level); ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Date of Birth</div>
                                            <div><?php echo strtoupper($student_info->dob); ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Program</div>
                                            <div><?php echo $student_info->prog_abbr; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Department</div>
                                            <div><?php echo $student_info->dept_name; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Faculty</div>
                                            <div><?php echo $student_info->division_name; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Gender</div>
                                            <div><?php echo $student_info->gender; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Session Admitted</div>
                                            <div><?php echo $student_info->session_admitted; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Entry Mode</div>
                                            <div><?php echo $student_info->entrymode; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Confirmation Status</div>
                                            <div><?php echo $student_info->confirm_status; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">University Email</div>
                                            <div><?php echo $student_info->username; ?></div>
                                        </div>
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                    </div>
                                    </p>
                                    <p class="text-muted m-b-0">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Contact Phone</div>
                                            <div><?php echo $contact_info ? $contact_info->phone : "N/A"; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Contact Email</div>
                                            <div><?php echo $contact_info ? $contact_info->email : "N/A"; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Town</div>
                                            <div><?php echo $contact_info ? $contact_info->town: "N/A"; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">LGA</div>
                                            <div><?php echo $contact_info ? $contact_info->lga_name : "N/A"; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">State</div>
                                            <div><?php echo $contact_info ? $contact_info->state_name: "N/A"; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Nationality</div>
                                            <div><?php echo $contact_info ? $contact_info->nationality: "N/A"; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Contact Address</div>
                                            <div><?php echo $contact_info ? $contact_info->caddress: "N/A"; ?></div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                            <div class="font-18 font-weight-bold">Permanent Address</div>
                                            <div><?php echo $contact_info ? $contact_info->haddress: "N/A"; ?></div>
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