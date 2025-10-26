<!doctype html>
<html lang="en" dir="ltr">
<?php //var_dump($staff); die;?>
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

        .raise:hover,
        .raise:focus {
            box-shadow: 0 0.1em 0.1em -0.1em;
            transform: translateY(-0.45em);
            border-color: #ffa260;
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
        ?>s
        <div class="page">
            <?php $this->load->view('incs/pageheader'); ?>
            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action"></div>
                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row">
                        
                        <?php 
                        // if(isset($_SESSION['msg2'])) {
                        //     echo '<div class="col-12 alert alert-danger"><h5 class="text-center" style="font-weight:900">'.$_SESSION['msg2'].'</h5>';
                        //     echo '<ul>
                        //         <li>Your account risks de-activation for security reasons.</li>
                        //         <li>You MUST NOT share your credentials with ANYONE, even MIS/ICT Staff.</li>
                        //         <li>Ensure that you always logout of your account when leaving.</li>
                        //         </ul>';
                        //     echo '</div>';
                        // } 
                        ?>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <p style="text-align:center; font-weight:700"><?php echo strtoupper($_SESSION['uniqueID']) ?></p>
                                    <img src="<?php echo base_url('passport/' . ($staff->passport ?? 'default.jpg')); ?>" alt="<?php echo $staff->uniqueID; ?>" style="display:block;width:350px; margin:auto">
                                    <div class="wid-u-info">
                                        <h5 class="text-center">
                                            <?php echo strtoupper($staff->surname) . ' ' . ucwords(strtolower($staff->firstname . ' ' . $staff->othername)); ?>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card">
                                <div class="card-header">
                                    <a data-analyticshub-event="Quick Apps" data-analyticshub-event-type="anchor" href="#" class="card-options-collapse" data-toggle="card-collapse">
                                        <h3 class="card-title" style="min-width: 100%;"> Quick Apps </h3>
                                    </a>
                                    <div class="card-options"> <i class="fa fa-toggle-on text-primary fa-lg"></i> </div>
                                </div>
                                <div class="card-body">
                                    <div class="row clearfix row-deck">
                                        <div class="col-sm-12  raise">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a data-analyticshub-event="My Payslips" data-analyticshub-event-type="anchor" href="<?php echo site_url('payslip/myslips') ?>" class="my_sort_cut text-muted">
                                                        <i class="fa" style="font-size:39px">&#8358;</i> <span>My Payslips</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row clearfix">
                                <?php if( in_array($staff->ACL_ID, [7, 8, 20, 21])) { ?>
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                                                <h3 class="card-title" style="min-width: 100%;">
                                                    Central Registration
                                                </h3>
                                            </a>
                                            <div class="card-options">
                                                <i class="fa fa-toggle-on text-primary fa-lg"></i>
                                            </div>
                                        </div>
                                        <form action="<?php echo site_url('registration/search') ?>" method="post">
                                            <div class="card-body">
                                                <div class="row clearfix row-deck">
                                                    <div class="col-10  raise">
                                                        <input type="search" name="search" placeholder="Enter JAMB/Admission Number to search" required class="form-control" minlength="10" maxlength="15" style="text-transform:uppercase" />
                                                    </div>
                                                    <div class="col-1  raise">
                                                        <button class="btn btn-info" type="submit" data-analyticshub-event="Search Registration" data-analyticshub-event-type="button" ><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php } if( in_array($staff->ACL_ID, [4, 20, 21, 23])) { ?>
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                                                <h3 class="card-title" style="min-width: 100%;">
                                                    My Academic
                                                </h3>
                                            </a>
                                            <div class="card-options">
                                                <i class="fa fa-toggle-on text-primary fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row clearfix row-deck">
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="My Timetable" data-analyticshub-event-type="anchor" href="#<?php //echo site_url('courses/index')
                                                                        ?>" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-calendar-check"></i><span>My Timetable</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="My Courses" data-analyticshub-event-type="anchor" href="<?php echo site_url('course/mycourses') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-users-cog"></i><span>My Courses</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Course Evaluation" data-analyticshub-event-type="anchor" href="<?php echo site_url('levelmanager/mylevels') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-list"></i><span>Level Coordination</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Personal Tutees" data-analyticshub-event-type="anchor" href="#<?php //echo site_url('courses/index')
                                                                        ?>" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-users"></i><span>Personal Tutees</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Course Evaluation" data-analyticshub-event-type="anchor" href="#<?php //echo site_url('courses/index') ?>" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-comments"></i><span>Course Evaluation</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } if( $staff->ACL_ID >= 3) { ?>
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a href="#" class="card-options-collapse" data-toggle="card-collapse">
                                                <h3 class="card-title" style="min-width: 100%;">
                                                    My Employment
                                                </h3>
                                            </a>
                                            <div class="card-options">
                                                <i class="fa fa-toggle-on text-primary fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row clearfix row-deck">
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="My Information" data-analyticshub-event-type="anchor" href="<?php echo site_url('staff/view/'.$staff->userid) ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-user"></i>
                                                                <span>My Information</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="My Payslips" data-analyticshub-event-type="anchor" href="<?php echo site_url('payslip/myslips') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa" style="font-size:39px">&#8358;</i>
                                                                <span>My Payslips</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="My Promotion" data-analyticshub-event-type="anchor" href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-fast-forward"></i>
                                                                <span>My Promotion</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="My Development" data-analyticshub-event-type="anchor" href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-network-wired"></i>
                                                                <span>My Development</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="My Holidays" data-analyticshub-event-type="anchor" href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-map-signs"></i>
                                                                <span>My Holidays</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="My Appraisal" data-analyticshub-event-type="anchor" href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-spell-check"></i>
                                                                <span>My Appraisals</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="#" class="card-options-collapse" data-toggle="card-collapse">
                                                <h3 class="card-title" style="min-width: 100%;"> Administration </h3>
                                            </a>
                                            <div class="card-options"> <i class="fa fa-toggle-on text-primary fa-lg"></i> </div>
                                        </div>
                                        
                                        <?php  } if( in_array($staff->ACL_ID, [8, 9, 10, 15, 20, 21, 23])) { ?>
                                        <div class="card-body">
                                        <div class="row clearfix row-deck">
                                            <!--Card services  and MIS Staff-->
                                            <?php if(in_array($staff->ACL_ID, [8, 20,21])){ ?>
                                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('card/index') ?>" class="my_sort_cut text-muted">
                                                            <i class="fa fa-id-card"></i>
                                                            <span>Card Services</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- MIS Staff, Exams & Reg, EMC, HOD -->
                                            <?php } if(in_array($staff->ACL_ID, [9, 10, 15,20, 21, 23])){
                                                //<!-- HODs and EO -->
                                            if(in_array($staff->ACL_ID, [23])){
                                                if(in_array($staff->ACL_ID, [23])){ ?>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('levelmanager/dept') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-tasks"></i><span>Level Coordinator Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('course/deptcourses') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-chalkboard"></i><span>Course Allocation Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('course/deptcoursescheule') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-clipboard-list"></i><span>Course Schedule Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                           <?php  }
                                            }
                                            if(in_array($staff->ACL_ID, [20,21])){ ?>
                                                
                                            
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('settingmanager/') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-tools"></i>
                                                                <span>Settings Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('settingmanager/acl') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-universal-access"></i>
                                                                <span>Access Control List</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('staff/manager') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-briefcase"></i>
                                                                <span>Staff Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('student/studentmanager') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-user-graduate"></i>
                                                                <span>Students Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } if(in_array($staff->ACL_ID, [15,20,21])){ ?>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('timetabling/index') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-calendar"></i>
                                                                <span>Timetable Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php }if(in_array($staff->ACL_ID, [20,21])){ ?>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-fast-forward"></i>
                                                                <span>Promotion Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-network-wired"></i>
                                                                <span>Training &amp; Development</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="#" class="my_sort_cut text-muted" onclick="coming_soon()">
                                                                <i class="fa fa-map-signs"></i>
                                                                <span>Leave Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('course/manager') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-chalkboard"></i>
                                                                <span>Course Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('result/index') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-mail-bulk"></i><span>Results Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('levelmanager/index') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-tasks"></i><span>Level Coordinator Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('pgs/index') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-book"></i><span>PGS Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('accomodations/index') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-bed"></i><span>Hostels Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Bursar and MIS Staff-->
                                                <?php } if(in_array($staff->ACL_ID, [9, 20, 21])){ ?>
                                                
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('bursary') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa" style="font-size:39px">&#8358;</i>
                                                                <span>Bursary Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } if(in_array($staff->ACL_ID, [ 10, 20, 21])){ ?>
                                                <!--SBS and MIS Staff-->
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('sbsmanager') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-school" style="font-size:39px"></i>
                                                                <span>SBS Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                 <?php } if(in_array($staff->ACL_ID, [21, 25])){ ?>
                                                <!--SBS and MIS Staff-->
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('parttimemanager') ?>" class="my_sort_cut text-muted">
                                                                <i class="fas fa-book-reader" style="font-size:39px"></i>
                                                                <span>Part-Time Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('Bursary/graduation_fees') ?>" class="my_sort_cut text-muted">
                                                                <i class="fas fa-book-reader" style="font-size:39px"></i>
                                                                <span>Graduation Fees</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                </div>
                                <?php   if( $staff->ACL_ID == 100) { ?>
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="#" class="card-options-collapse" data-toggle="card-collapse">
                                                <h3 class="card-title" style="min-width: 100%;">
                                                    PG Portal
                                                </h3>
                                            </a>
                                            <div class="card-options">
                                                <i class="fa fa-toggle-on text-primary fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row clearfix row-deck">
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('pgs/index') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-book"></i><span>PGS Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('course/pg_courses') ?>" class="my_sort_cut text-muted">
                                                                <i class="fa fa-users-cog"></i><span>PG Course Manager</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <?php }  if(in_array($staff->ACL_ID, [25, 21])) { ?>
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="#" class="card-options-collapse" data-toggle="card-collapse">
                                                <h3 class="card-title" style="min-width: 100%;">
                                                   Accomodation
                                                </h3>
                                            </a>
                                            <div class="card-options">
                                                <i class="fa fa-toggle-on text-primary fa-lg"></i>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-2  raise">
                                            <div class="card">
                                                <div class="card-body">
                                                    <a data-analyticshub-event="Admin" data-analyticshub-event-type="anchor" href="<?php echo site_url('accomodations/index') ?>" class="my_sort_cut text-muted">
                                                        <i class="fa fa-bed"></i><span>Hostels Manager</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
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