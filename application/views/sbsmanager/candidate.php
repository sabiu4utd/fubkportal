<!doctype html>
<html lang="en" dir="ltr">
    <?php //var_dump($acceptanceFee); exit; ?>
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
    <!--<div class="page-loader-wrapper">
        <div class="loader"></div>
    </div>-->
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
                                    <a href="<?php echo site_url('sbsmanager/admission/' . str_replace("/", "_", $_SESSION['sbs_session'])) ?>" class="btn btn-info float-left" style="margin-right:25px">
                                        <i class="fa fa-chevron-circle-left fa-lg"></i>
                                    </a>
                                    <?php $this->load->view('incs/sbs_student_header')?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body mt-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 p-10">
                                            <?php 
                                                   echo "<a href='#".site_url('sbsmanager/reset_password/'.md5(rand()).'/'.$student_info->userid.'/'.md5(time()))."' class='btn btn-danger form-control'><i class='fa fa-lock' style='font-size: 15px'></i> Reset Password</a>" ; 
                                                ?>
                                        </div>
                                        <div class="col-12 p-10">
                                            <table class="table table-stripped table-bordered">
                                                <tr>
                                                    <th>Currrent Session</th>
                                                    <td><?php echo strtoupper($_SESSION['active_session']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Account Status</th>
                                                    <td><?php echo strtoupper($student_info->status); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Admission Acceptance</th>
                                                    <td>
                                                        <?php 
                                                            if($student_info->session_admitted == "2023/2024"){
                                                                $_SESSION['active_session'] = "2023/2024";
                                                            }
                                                            if($student_info->session_admitted == $_SESSION['active_session'] and $student_info->confirm_status != "Confirmed"){
                                                                if(!$acceptanceFee){
                                                                    echo "<a href='".site_url('sbsmanager/generateAcceptanceRemita/'.$student_info->user_id)."'><i class='fa fa-person-booth text-info'></i> Generate Invoice</a>";
                                                                }else{
                                                                    echo "<a target='_blank' href='https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/".$acceptanceFee->rrr."/printinvoiceRequest.pdf'><i class='fa fa-print'></i> ".$acceptanceFee->rrr." (&#8358;".$acceptanceFee->amount.")</a><br>";
                                                                    if($acceptanceFee->status == "Pending"){
                                                                        echo "<br><a href='".site_url('sbsmanager/checkPaymentStatus/'.$student_info->user_id.'/'.$acceptanceFee->rrr)."'><i class='fa fa-person-booth text-info'></i> Confirm Payment</a>";
                                                                    }else{
                                                                        echo "<br><i class='fa fa-person-booth text-success'></i> PAID";
                                                                    }
                                                                }
                                                            }else if($student_info->confirm_status == "Confirmed"){
                                                                echo "Accepted in ". $student_info->session_admitted;
                                                            }else{
                                                                echo "-";
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Confirm Admission</th>
                                                    <td>
                                                        <?php 
                                                            if($student_info->confirm_status == "Confirmed"){
                                                                echo "Confirmed in ". $student_info->session_admitted;
                                                            }else{
                                                            if(isset($acceptanceFee) && $acceptanceFee->status == "Paid"){
                                                                if($student_info->confirm_status == "Pending"){
                                                                    echo "<a href='".site_url('sbsmanager/confirm_admission/'.md5(rand()).'/'.$student_info->userid.'/'.md5(time()))."' class='text-danger'> <i class='fa fa-question'></i> Verify &amp; Confirm Admission</a>";
                                                                }else{
                                                                    echo "<i class='fa fa-check text-success'></i> Admission is now ".strtoupper($student_info->confirm_status);
                                                                }
                                                                echo "<br>";
                                                            }else{
                                                                if(isset($acceptanceFee->rrr)){
                                                                    echo "<a href='".site_url('sbsmanager/checkPaymentStatus/'.$student_info->user_id.'/'.$acceptanceFee->rrr)."'><i class='fa fa-person-booth text-info'></i> Confirm Payment</a>";
                                                                }
                                                                echo "<i class='fa fa-times text-danger'></i> Acceptance Pending";
                                                            }}
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>School Fees</th>
                                                    <td>
                                                        <?php
                                                            if($student_info->confirm_status == "Pending"){
                                                                    echo "<i class='fa fa-times text-danger'></i> Admission not Confirmed";
                                                            }else{
                                                                if(!$tuitionFee){
                                                                    if($student_info->entrymode == "PG"){
                                                                        echo "<a href='".site_url('sbsmanager/generateTuitionRemita/'.$student_info->user_id)."'><i class='fa fa-bank text-info'></i> Pay Full (100%) Tuition<br></a><br>";
                                                                        echo "<a href='".site_url('sbsmanager/generateTuitionRemita/'.$student_info->user_id.'/1')."'><i class='fa fa-bank text-info'></i> Pay Partial (60%) Tuition</a>";
                                                                    }else{
                                                                        echo "<a href='".site_url('sbsmanager/generateTuitionRemita/'.$student_info->user_id)."'><i class='fa fa-bank text-info'></i> Generate Tuition Invoice<br></a>";
                                                                    }
                                                                }else{
                                                                    echo "<a target='_blank' href='https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/".$tuitionFee->rrr."/printinvoiceRequest.pdf'><i class='fa fa-print'></i> ".$tuitionFee->rrr." (&#8358;".number_format($tuitionFee->amount,2,'.', ',').")</a><br>";
                                                                    if($tuitionFee->status != "Paid"){
                                                                        echo "<br><a href='".site_url('sbsmanager/checkPaymentStatus/'.$student_info->user_id.'/'.$tuitionFee->rrr)."'><i class='fa fa-person-booth text-info'></i> Confirm Payment</a>";
                                                                    }else{
                                                                        echo "<br><i class='fa fa-person-booth text-success'></i> PAID";
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Admission Letter</th>
                                                    <td>
                                                        <?php
                                                            if($tuitionFee && $tuitionFee->status == "Paid"){
                                                                if($student_info->pnumber == "Unassigned"){
                                                                    echo "<a href='".site_url('sbsmanager/assignadmission_no/'.$student_info->user_id)."'><i class='fa fa-user'></i> Assign Admission No</a>";
                                                                }else{
                                                                    echo $student_info->pnumber;
                                                                    echo "<br><br><a target='_blank' href='".site_url('sbsmanager/printAdmissionLetter/'.$student_info->user_id)."'><i class='fa fa-print'></i> Print Admission Letter</a>";
                                                                }
                                                            }else{
                                                                echo "<br><i class='fa fa-times text-danger'></i> Confirm School Fees";
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted m-b-0">
                                    <div class="row">
                                        <div class="col-12 text-center p-10 alert alert-<?php echo $student_info->entrymode == "PG"? "danger": "info"?>" style="font-weight:800">
                                            <?php echo $student_info->entrymode == "PG" ? "Postgraduate Student Account": "Undergraduate Student Account"?>
                                        </div>
                                        <div class="col-6 p-10">
                                            <div class="font-18 font-weight-bold">Student Name</div>
                                            <div><?php echo strtoupper($student_info->surname). ", ".ucwords($student_info->firstname. " ".$student_info->othername); ?></div>
                                        </div>
                                        <div class="col-6 p-10">
                                            <div class="font-18 font-weight-bold">Program Admitted</div>
                                            <div><?php echo $student_info->program; ?></div>
                                        </div>
                                        <div class="col-md-6 p-10">
                                            <div class="font-18 font-weight-bold">Department</div>
                                            <div><?php echo $student_info->dept_name; ?></div>
                                        </div>
                                        <div class="col-md-6 p-10">
                                            <div class="font-18 font-weight-bold">Faculty</div>
                                            <div><?php echo $student_info->division_name; ?></div>
                                        </div>
                                        <div class="col-md-6 p-10">
                                            <div class="font-18 font-weight-bold">Admission No</div>
                                            <div><?php echo !$student_info->pnumber ? "Unassigned" : $student_info->pnumber; ?></div>
                                        </div>
                                        <div class="col-md-6 p-10">
                                            <div class="font-18 font-weight-bold">Applicant Number</div>
                                            <div><?php echo $student_info->jamb_no; ?></div>
                                        </div>
                                        <div class="col-md-6 p-10">
                                            <div class="font-18 font-weight-bold">Current Level</div>
                                            <div><?php echo strtoupper($student_info->current_level); ?></div>
                                        </div>
                                        <div class="col-md-6 p-10">
                                            <div class="font-18 font-weight-bold">Entry Mode</div>
                                            <div><?php echo strtoupper($student_info->entrymode); ?></div>
                                        </div>
                                        <div class="col-md-6 p-10">
                                            <div class="font-18 font-weight-bold">Gender</div>
                                            <div><?php echo $student_info->gender; ?></div>
                                        </div>
                                        <div class="col-md-6 p-10">
                                            <div class="font-18 font-weight-bold">Session Admitted</div>
                                            <div><?php echo $student_info->session_admitted; ?></div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Email Address</div>
                                            <div><?php echo $student_info->pnumber == $student_info->jamb_no ? "Unassigned" : $student_info->username; ?></div>
                                        </div>
                                    </div>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                <?php $this->load->view('incs/student_media');?>
                                </div>
                                <form action="<?php echo site_url('sbsmanager/uploadPassport')?>" method="post" enctype="multipart/form-data" style="padding:20px">
                                    <input type="file" name="file" required class="form-control"/><br>
                                    <input type="hidden" name="user_id" required class="form-control" value="<?php echo $student_info->user_id?>"/>
                                    <input type="submit" class="form-control btn btn-success"/>
                                </form>
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