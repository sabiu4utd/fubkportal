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
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body row">
                                    <p class="text-muted m-b-0">
                                    <div class="col-md-6 col-sm-12 table-responsive">
                                        <h5 class="text-center">Allocate Course to Lecturer</h5> <hr>
                                        <form action="<?php echo site_url('course/makeallocation')?>" method="post">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                            <tr>
                                                <th style="width:200px">Course Code</th><td class="text-left"><?php echo $course->course_code; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Course title</th><td class="text-left"><?php echo $course->course_title; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Session</th><td class="text-left"><?php echo $course->session; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Semester</th><td class="text-left"><?php echo $course->value; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Assign Staff</th>
                                                <td class="text-left">
                                                    <input type="hidden" name="course_id" id="course_id" value="<?php echo $course->id?>" />
                                                    <input type="hidden" name="lecturer_id" id="lecturer_id" value="-1" />
                                                    <div id="users">
                                                        <div class="input-group mt-2 mb-2">
                                                            <input type="text" class="form-control search" placeholder="Search by Staff Name">
                                                        </div>
                                                        <ul class="right_chat list-unstyled list">
                                                        <?php foreach($staff as $row){ ?>
                                                            <li onclick="setStaffID(<?php echo $row->id;?>, this)" class="ouritem">
                                                                <a href="javascript:void(0);" class="media">
                                                                    <!--<img class="media-object" src="<?php echo base_url('/passport/'.$row->passport)?>" alt="">-->
                                                                    <div class="media-body">
                                                                        <span class="name"><?php echo $row->fullname; ?></span>
                                                                        <span class="message"><?php echo substr($row->registry_file_no, 7); ?></span>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr><th colspan="2"><hr></th></tr>
                                            <tr>
                                                <th>
                                                    <a class="btn btn-danger" href="<?php echo site_url('course/courselist')?>">Back</a> 
                                                </th>
                                                <th>
                                                    <input class="btn btn-primary form-controlk" type="submit" value="Assign Course to Lecturer" /> 
                                                </th>
                                            </tr>
                                        </table>
                                        </form>
                                    </div>
                                    <div class="col-md-6 col-sm-12 table-responsive">
                                        <h5 class="text-center">Current Staff on this Course</h5> <hr>
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                            <tr>
                                                <th>Name</th>
                                                <th style="width:220px">Date</th>
                                                <th style="width:40px">X</th>
                                            </tr>
                                            <?php foreach($allocated as $row){?>
                                                <tr>
                                                <td><?php echo "(".substr($row->registry_file_no, 7).") - ".$row->fullname; ?></td>
                                                <td><?php echo $row->date; ?></td>
                                                <td>
                                                    <?php 
                                                    if(in_array(substr($row->registry_file_no, 7), ["SP0228", "SP0403"])){
                                                        echo "-";
                                                    }else{ ?>
                                                    <a href="<?php echo site_url('course/removeallocation/'.$row->csid.'/'.$row->id); ?>">
                                                        <i class="fa fa-trash text-danger"></i>
                                                    </a>
                                                    <?php } ?>
                                                </td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                        </form>
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
    <script src="<?php echo base_url() ?>assets/js/form/dropify.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/page/summernote.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/rocket-loader.min.js" data-cf-settings="e27f9daa9c2f25670b2c3761-|49" defer=""></script>
    <script>
        function setStaffID(id, elem){
            document.getElementById("lecturer_id").value = id;
            //document.getElementsByTagName("li").removeProperty("backgroundColor");
            elem.style.backgroundColor  = "#64CCC5";
        }
    </script>


</body>
</html>