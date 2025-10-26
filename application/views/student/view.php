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

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/dataTables.bootstrap4.min.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">

    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <style>
        .nav-item .nav-link {
            font-weight: bolder;

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
                            <h1 class="page-title">Student</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item active" aria-current="page">View Student</li>
                            </ol>
                        </div>
                        <ul class="nav nav-tabs page-header-tab">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#biodata">Personal Data</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active" id="biodata">
                            <div class="card-footer text-left">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="font-18 font-weight-bolder uppercase">
                                            PERSONAL INFORMATION
                                            <a class="nav-link float-right p-10" href="<?php echo site_url('student/edit'); ?>"><i class="fa fa-edit"></i>Edit </a>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Full Name</div>

                                        <div><?php echo strtoupper($student->surname) . ' ' . ucwords(strtolower($student->firstname . ' ' . $student->othername)); ?></div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Gender</div>

                                        <div><?php echo $student->gender; ?></div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Date of Birth</div>

                                        <div><?php echo $student->dob; ?></div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Entry Mode</div>

                                        <div><?php echo $student->entrymode; ?></div>

                                    </div>
                                </div>

                                <div class="row">

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                    <div class="font-18 font-weight-bold">Current Level</div>

                                    <div><?php 
                                        if($student->current_level % 10 != 0){
                                            echo "Spill Over I";
                                        }elseif($student->current_level % 20 != 0){
                                            echo "Spill Over II";
                                        }else{
                                            echo $student->current_level;
                                        }
                                    ?></div>

                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                    <div class="font-18 font-weight-bold">Faculty</div>
                                    <div><?php echo $student->division_name; ?></div>
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                    <div class="font-18 font-weight-bold">Department</div>

                                    <div><?php echo $student->dept_name; ?></div>

                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                    <div class="font-18 font-weight-bold">Program of Study</div>

                                    <div><?php echo $student->prog_abbr; ?></div>

                                </div>

                                    

                                </div>

                                <div class="row">
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                    <div class="font-18 font-weight-bold">State of Origin</div>
                                    
                                    <div><?php echo $contact_info ? $contact_info->state_name : ""; ?></div>
                                    
                                </div>

                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                    <div class="font-18 font-weight-bold">LGA of Origin</div>

                                    <div><?php echo $contact_info ? $contact_info->lga_name : ""; ?></div>

                                </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Nationality</div>

                                        <div><?php echo $contact_info ? $contact_info->nationality : ""; ?></div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">University Email</div>

                                        <div><?php echo $student->username; ?></div>

                                    </div>

                                    
                                </div>

                                <div class="row">
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                <div class="font-18 font-weight-bold">Phone number</div>
                                
                                <div><?php echo $contact_info ? $contact_info->phone : ""; ?></div>
                                
                                </div>
                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                    <div class="font-18 font-weight-bold">Personal Email</div>

                                    <div><?php echo $contact_info ? $contact_info->email : ""; ?></div>

                                </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Postal Address</div>

                                        <div><?php echo $contact_info ? $contact_info->caddress : ""; ?></div>

                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Permanent Address</div>

                                        <div><?php echo $contact_info ? $contact_info->haddress : ""; ?></div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-12">

                                        <div class="font-18 font-weight-bolder uppercase">NEXT OF KIN INFORMATION</div>

                                        <hr>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Fullname</div>

                                        <div><?php echo $contact_info ? $contact_info->nok_name : ""; ?></div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Relationship</div>

                                        <div><?php echo $contact_info ? $contact_info->nok_relationship : ""; ?></div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Phone</div>

                                        <div><?php echo $contact_info ? $contact_info->nok_phone : ""; ?></div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">

                                        <div class="font-18 font-weight-bold">Email</div>

                                        <div><?php echo $contact_info ? $contact_info->nok_email : ""; ?></div>

                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-12 p-10">

                                        <div class="font-18 font-weight-bold">Contact Address</div>

                                        <div><?php echo $contact_info ? $contact_info->nok_address : ""; ?></div>

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



    <script src="<?php echo base_url() ?>assets/js/core.js" type="e27f9daa9c2f25670b2c3761-text/javascript">

    </script>

    <script src="<?php echo base_url() ?>assets/js/form/dropify.js" type="e27f9daa9c2f25670b2c3761-text/javascript">

    </script>

    <script src="<?php echo base_url() ?>assets/js/page/summernote.js" type="e27f9daa9c2f25670b2c3761-text/javascript">

    </script>

    <script src="<?php echo base_url() ?>assets/js/rocket-loader.min.js" data-cf-settings="e27f9daa9c2f25670b2c3761-|49" defer=""></script>



    <script src="<?php echo base_url() ?>assets/js/table/datatable.js" type="7ab396837eea337a09d7c15b-text/javascript"></script>

    <script src="<?php echo base_url() ?>assets/bundles/dataTables.bundle.js" type="7ab396837eea337a09d7c15b-text/javascript"></script>

</body>



</html>