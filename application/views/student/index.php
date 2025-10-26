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
            font-weight: bolder;
            color: brown;
            font-size: 15px;
            text-decoration: underline;
        }
        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
        .history-tl-container {
            font-family: "Roboto", sans-serif;
            width: 100%;
            margin: auto;
            display: block;
            position: relative;
        }
        .history-tl-container ul.tl {
            margin: 10px 0;
            padding: 0;
            display: inline-block;
        }
        .history-tl-container ul.tl li {
            list-style: none;
            margin: auto;
            margin-left: 200px;
            min-height: 25px;
            /*background: rgba(255,255,0,0.1);*/
            border-left: 1px dashed #86D6FF;
            padding: 0 0 30px 10px;
            position: relative;
        }
        .history-tl-container ul.tl li:last-child {
            border-left: 0;
        }
        .history-tl-container ul.tl li::before {
            position: absolute;
            left: -18px;
            top: -5px;
            content: " ";
            border: 8px solid rgba(255, 255, 255, 0.74);
            border-radius: 500%;
            background: #258CC7;
            height: 20px;
            width: 20px;
            transition: all 500ms ease-in-out;
        }
        .history-tl-container ul.tl li:hover::before {
            border-color: #258CC7;
            transition: all 1000ms ease-in-out;
        }
        ul.tl li .item-detail {
            color: rgba(0, 0, 0, 0.5);
            font-size: 12px;
        }
        ul.tl li .timestamp {
            color: #fff;
            position: absolute;
            width: 110px;
            left: -95%;
            text-align: center;
            font-size: 14px;
        }
        .timeline-container {
            line-height: 1.3em;
            min-width: 920px;
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
            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action">
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row">
                         <?php //if(isset($_SESSION['msg2'])) {
                        //     echo '<div class="col-12 alert alert-danger"><h5 class="text-center" style="font-weight:900">'.$_SESSION['msg2'].'</h5>';
                        //     echo '<ul>
                        //         <li>Your account risks de-activation for security reasons.</li>
                        //         <li>You MUST NOT share your credentials with ANYONE, even MIS/ICT Staff.</li>
                        //         <li>Ensure that you always logout of your account when leaving.</li>
                        //         </ul>';
                        //     echo '</div>';
                        //} ?>
                        <div class="col-sm-12 col-lg-4">
                            <div class="card">
                                <div class="card-body mx-auto">
                                    <div class="wid-u-info mx-auto mb-4 justify-content-center" style="justify-content:center">
                                        <h6 class="text-left" style="font-size:20px; font-weight:bolder">
                                            <?php echo $student->pnumber?>
                                            <span class="float-right badge badge-info"><?php 
                                                if($student->type == "PG"){
                                                    echo "PG Student";
                                                }else if ($student->type == "UG"){
                                                    echo "UG Student";
                                                }else if ($student->type == "SBS"){
                                                    echo "SBS Student";
                                                }
                                            ?></span>
                                        </h6>
                                        <hr>
                                    </div>
                                    <img src="<?php echo base_url('passport/'.$student->passport); ?>" alt="<?php echo $student->uniqueID; ?>" style="display:block; width:350px; height:360px; margin:auto">
                                    <div class="wid-u-info">
                                        
                                    <hr>
                                        <h6 class="text-center">
                                            <?php echo strtoupper($student->surname) . '<br>' . ucwords(strtolower($student->firstname . ' ' . $student->othername)); ?>
                                        </h6>
                                        <hr>
                                            <span class="p-3 mx-auto badge badge-<?php echo $student->pnumber == 'Unassigned' ? 'danger': 'info'?>" style="color:#fff; font-size:14px">
                                                <?php echo $student->pnumber != "Unassigned"? "<a href='".site_url('registration/printAdmissionLetter/'.$_SESSION['userid'].'/'.hash('sha512', time()))."' target='_blank' style='color:#fff'>Re-print Admission Letter</a>": "Not Registered";?>
                                            </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-8 ">
                            <div class="row clearfix">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                                                <h3 class="card-title">
                                                    My Academics
                                                </h3>
                                            </a>
                                            <div class="card-options">
                                                <i class="fa fa-toggle-on text-primary fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <?php if ($_SESSION['tuition_payment_status'] == "Pending"){ 
                                                echo '<div class="row clearfix row-deck">
                                                        <div class="col-12 alert alert-warning mt-4 mb-4" style="font-weight: 900; text-align:center">
                                                            Tuition Fees NOT PAID
                                                        </div>
                                                    </div>';
                                                }
                                                $per = 0;
                                                $stat = "PAID";
                                                if($student->entrymode == "PG"){
                                                foreach($payments as $row){
                                                    $per += $row->percentage_paid;
                                                    if($row->status != "PAID"){
                                                        $stat = "PENDING";
                                                    }
                                                }
                                                $_SESSION['total_percentage_paid'] = $per;
                                                $_SESSION['total_percentage_status'] = $stat;
                                                
                                                if($_SESSION['total_percentage_paid'] != 100){
                                                    echo '<div class="row clearfix row-deck">
                                                        <div class="col-12 alert alert-warning mt-4 mb-4" style="font-weight: 900; text-align:center">
                                                            Tuition Fees NOT FULLY PAID. Click <a href="'.site_url('payment/history').'">&nbsp;here &nbsp;</a> to generate invoice
                                                        </div>
                                                    </div>';
                                                }
                                                }
                                            ?>
                                            <div class="row clearfix row-deck">
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('student/view') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-user"></i>
                                                                <span>My Information</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('payment/history') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa" style="font-size:39px">&#8358;</i>
                                                                <span>My Payments</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('course/history') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-chalkboard-teacher"></i>
                                                                <span>My Courses</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('accomodations/history') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-house-user"></i>
                                                                <span>Accomodation</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('result/history') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-spell-check"></i>
                                                                <span>My Results</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#<?php echo site_url('result/gst') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-check-double"></i>
                                                                <span>GST Result</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('course/exams_card') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-id-card"></i>
                                                                <span>My Exams Card</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('form') ?>" class="my_sort_cut text-muted">
                                                                <i class="fab fa-wpforms"></i>
                                                                <span>Other Forms</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#" class="my_sort_cut text-muted"  onclick="coming_soon()">
                                                                <i class="fa fa-info-circle"></i>
                                                                <span>My Timetable</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#" class="my_sort_cut text-muted"  onclick="coming_soon()">
                                                                <i class="fa fa-graduation-cap"></i>
                                                                <span>e-Learning</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="<?php echo site_url('course/course_evaluation');?>" class="my_sort_cut text-muted" >
                                                                <i class="fa fa-comments"></i>
                                                                <span>Course Evaluation</span>
                                                            </a> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-network-wired"></i>
                                                                <span>My Development</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-hands-helping"></i>
                                                                <span>Personal Tutor</span>
                                                            </a>
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