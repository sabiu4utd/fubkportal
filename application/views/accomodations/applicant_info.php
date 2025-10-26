<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FUBK-PGS Applicantion Form Printout for <?php echo strtoupper($applicant_data->applicant->surname) . ' ' . ucwords(trim($applicant_data->applicant->firstname . ' ' .$applicant_data->applicant->middlename)) ?></title>
    <link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/dropify/css/dropify.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/summernote/dist/summernote.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.min.css" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/extra.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <style>
    
    
    html,body{
        height:350mm;
        width:210mm;
        padding:5px;
        margin-top:10px;
    }
    .page {
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        border: 1px solid #000;
        margin-top:25px;
        padding:10px;
        height:380mm;
        min-width:210mm;
    }
    
    @media print{
        .page {
            margin-top:20px;
            min-height:350mm;
            min-width:210mm;
            margin:auto;
            page-break-after:always;
        }
    }
    
    .colored, .colored tr th, .colored tr td, .colored hr{
        color:#000;
    }
    
    .colored tr th{
        font-weight: bolder;
    }
    
    .colored{
        border: .2px solid #000;
    }

    </style>
</head>

<body class="font-muli right_tb_toggle <?php echo " " . $_SESSION['theme_mode']; ?>">
    <div id="main_content">
        <div class="page">
            <div class="card" style="color: #000;">
                <div class="row px-4">
                    <div class="col-12 mx-auto" style="display:flex; flex-direction: column; justify-content: center;">
                        <img src="<?php echo base_url('assets/images/fubk-icon.png')?>" style="width: 100px; margin:auto; position:relative"/>
                        <div style="text-align: center;font-size:19px; font-weight:bold">School of Postgraduate Studies Application Form</div>
                    </div>
                    <div class="col-12 p-2"><hr></div>
                    <div class="col-12">
                        <table class="table table-bordered table-stripped colored" >
                            <tr>
                                <th colspan="6">PERSONAL INFORMATION</th>
                            </tr>
                            <tr>
                                <th>Full name</th>
                                <td colspan="5"><?php echo strtoupper($applicant_data->applicant->surname) . ' ' . ucwords(trim($applicant_data->applicant->firstname . ' ' .$applicant_data->applicant->middlename)) ?></td>
                                
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td colspan="5"><?php echo $applicant_data->applicant->email ?></td>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <td><?php echo $applicant_data->applicant->gender ?></td>
                                <th>Phone</th>
                                <td><?php echo $applicant_data->applicant->phone ?></td>
                                <th>Birth Date</th>
                                <td><?php echo $applicant_data->applicant->dob ?></td>
                            </tr>
                            <tr>
                                <th colspan="6">PROGRAMME APPLIED</th>
                            </tr>
                            <tr>
                                <th>Application ID</th>
                                <td colspan="3"><?php echo $applicant_data->form->application_number; ?></td>
                                <th>Session</th>
                                <td>2022/2023</td>
                            </tr>
                            <tr>
                                <th>Programme</th>
                                <td colspan="3"><?php echo $applicant_data->form->prog_abbr; ?></td>
                                <th>Level</th>
                                <td><?php echo substr($applicant_data->form->prog_abbr, 0, 5); ?></td>
                            </tr>
                            <tr>
                                <th>Department</th>
                                <td colspan="3"><?php echo substr($applicant_data->form->prog_abbr, 5); ?></td>
                                <th>Faculty</th>
                                <td><?php echo 'Science/Social Science' ?></td>
                                
                            </tr>
                            <tr>
                                <th>Remita RRR</th>
                                <td colspan="3"><?php echo $applicant_data->form->rrr;  ?></td>
                                <th>Status</th>
                                <td>PAID</td>
                            </tr>
                            <tr>
                                <th colspan="6">O'LEVEL INFORMATION</th>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <div class="row">
                                        <?php foreach ($applicant_data->olevels as $row) {
                                            echo "<div class='col'>" . $row->subject_short . ' (' . $row->grade . ')</div>';
                                        }?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="6">A'LEVEL INFORMATION</th>
                            </tr>
                            <tr>
                                <th colspan="3">Insititution</th>
                                <th>Year</th>
                                <th>Qualification</th>
                                <th>Result</th>
                            </tr>
                            <?php foreach ($applicant_data->alevels as $row) { ?>
                                <tr>
                                    <td colspan="3"><?php echo $row->institution_name; ?></td>
                                    <td><?php echo $row->graduation_year; ?></td>
                                    <td><?php echo $row->qualification; ?></td>
                                    <td><?php echo $row->grade; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="6">Documents Uploaded</th>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <div class="row">
                                        <?php foreach ($applicant_data->uploads as $row) {
                                            echo "<div class='col'>" . $row->file_type . ' (' . $row->year_obtained . ')</div>';
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th colspan="6">Referees Information</th>
                            </tr>
                            <tr>
                                <th colspan="3">Referee Name</th>
                                <th colspan="2">Email</th>
                                <th>Status</th>
                            </tr>
                            <?php foreach ($applicant_data->referees as $row) { ?>
                            <tr>
                                <td colspan="3"><?php echo $row->referee_title.' '. $row->referee_name?></td>
                                <td colspan="2"><?php echo $row->referee_email?></td>
                                <td>Submitted</td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>
                </div>
            </div>
            <div style="position:absolute;bottom:0; width:97%;margin-bottom:15px">
                <span style="text-align:left; float:left">
                Printed from the University Portal at <em><?php echo date('Y-m-d H:i:s'); ?></em><br>
                If you have any questions, please contact the PG school at <em>pgs@fubk.edu.ng</em><br>
                If you noticed any technical error, please contact the MIS at <em>mis.fubk.edu.ng</em>
                </span>
                <span style="text-align:right; float:right"><?php echo $applicant_data->form->application_number; ?><br><br>Page 1</span>
            </div>
        </div>
        <div class="page">
            <div class="card" style="color: #000;">
                <div class="row px-4">
                    <div class="col-12 mx-auto" style="display:flex; flex-direction: column; justify-content: center;">
                        <img src="<?php echo base_url('assets/images/fubk-icon.png')?>" style="width: 100px; margin:auto; position:relative"/>
                        <div style="text-align: center;font-size:19px; font-weight:bold">School of Postgraduate Studies Application Form</div>
                    </div>
                    <div class="col-12 p-2"><hr></div>
                    <div class="col-12">
                       
                        <table class="table table-bordered table-stripped colored" >
                            <tr>
                                <th>&nbsp;</th>
                                <th>Referee 1</th>
                                <th>Referee 2</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td><?php echo $applicant_data->referees[0]->referee_title." ".$applicant_data->referees[0]->referee_name; ?></td>
                                <td><?php echo $applicant_data->referees[1]->referee_title." ".$applicant_data->referees[1]->referee_name; ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?php echo $applicant_data->referees[0]->referee_email; ?></td>
                                <td><?php echo $applicant_data->referees[1]->referee_email; ?></td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td><?php echo $applicant_data->referees[0]->referee_phone; ?></td>
                                <td><?php echo $applicant_data->referees[1]->referee_phone; ?></td>
                            </tr>
                            <tr>
                                <th>Recommendation</th>
                                <td><?php echo $applicant_data->referees[0]->recommendation; ?></td>
                                <td><?php echo $applicant_data->referees[1]->recommendation; ?></td>
                            </tr>
                            <tr>
                                <th>Capacity Known</th>
                                <td><?php echo $applicant_data->referees[0]->Personal_assesment; ?></td>
                                <td><?php echo $applicant_data->referees[1]->Personal_assesment; ?></td>
                            </tr>
                            <tr>
                                <th>Personal Assesment</th>
                                <td><?php echo $applicant_data->referees[0]->did_you_know; ?></td>
                                <td><?php echo $applicant_data->referees[1]->did_you_know; ?></td>
                            </tr>
                            <tr>
                                <th>&nbsp;</th>
                                <td>
                                    <table style="border-collapse:collapse">
                                        <tr>
                                            <td>Preparations</td><td><?php echo $applicant_data->referees[0]->preparation_for_course?></td>
                                            <td>Experssion</td><td><?php echo $applicant_data->referees[0]->expression?></td>
                                        </tr>
                                        <tr>
                                            <td>Analytical Ability</td><td><?php echo $applicant_data->referees[0]->analtical_ability?></td>
                                            <td>Planning</td><td><?php echo $applicant_data->referees[0]->planning?></td>
                                        </tr>
                                        <tr>
                                            <td>Technical Competence</td><td><?php echo $applicant_data->referees[0]->technical_competence?></td>
                                            <td>Intellectual Promise</td><td><?php echo $applicant_data->referees[0]->intellectual_promise?></td>
                                        </tr>
                                    </table>
                                </td>
                                <td>
                                    <table style="border-collapse:collapse">
                                        <tr>
                                            <td>Preparations</td><td><?php echo $applicant_data->referees[1]->preparation_for_course?></td>
                                            <td>Experssion</td><td><?php echo $applicant_data->referees[1]->expression?></td>
                                        </tr>
                                        <tr>
                                            <td>Analytical Ability</td><td><?php echo $applicant_data->referees[1]->analtical_ability?></td>
                                            <td>Planning</td><td><?php echo $applicant_data->referees[1]->planning?></td>
                                        </tr>
                                        <tr>
                                            <td>Technical Competence</td><td><?php echo $applicant_data->referees[1]->technical_competence?></td>
                                            <td>Intellectual Promise</td><td><?php echo $applicant_data->referees[1]->intellectual_promise?></td>
                                        </tr>
                                    </table>
                                </td>
                                
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div style="position:absolute;bottom:0; width:97%;margin-bottom:15px">
                <span style="text-align:left; float:left">
                Printed from the University Portal at <em><?php echo date('Y-m-d H:i:s'); ?></em><br>
                If you have any questions, please contact the PG school at <em>pgs@fubk.edu.ng</em><br>
                If you noticed any technical error, please contact the MIS at <em>mis.fubk.edu.ng</em>
                </span>
                <span style="text-align:right; float:right"><?php echo $applicant_data->form->application_number; ?><br><br>Page 2</span>
            </div>
        </div>
        <?php $pageNum = 3; foreach ($applicant_data->uploads as $row) { ?>
        <div class="page">
            <div class="card" style="color: #000;">
                <?php 
                    if(pathinfo($row->file_url, PATHINFO_EXTENSION) == "pdf"){ 
                        $file = $row->file_url;
                        $filename = $row->file_url;
                        header('Content-type: application/pdf');
                        header('Content-Disposition: inline; filename="' . $filename . '"');
                        header('Content-Transfer-Encoding: binary');
                        header('Accept-Ranges: bytes');
                          
                        @readfile($file); 
                    
                    } else {
                        echo "<img src='".$row->file_url."'>"; 
                    }
                ?>
            </div>
            <div style="position:absolute;bottom:0; width:97%;margin-bottom:15px">
                <span style="text-align:left; float:left">
                Printed from the University Portal at <em><?php echo date('Y-m-d H:i:s'); ?></em><br>
                If you have any questions, please contact the PG school at <em>pgs@fubk.edu.ng</em><br>
                If you noticed any technical error, please contact the MIS at <em>mis.fubk.edu.ng</em>
                </span>
                <span style="text-align:right; float:right"><?php echo $applicant_data->form->application_number; ?><br><br>Page <?php echo $pageNum++;?></span>
            </div>
        </div>
        <?php } ?>
    </div>
    <!--<div class="page-loader-wrapper">
        <div class="loader"></div>
    </div>
    <div id="main_content">
        <div class="page">
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            
                            <div class="row clearfix">
                                <div class="col-xl-8 mx-auto">
                                    <div class="card p-4" style="color: #000;">
                                        <div class="row">
                                            
                                            <div class="col-12 mx-auto" style="display:flex; flex-direction: column; justify-content: center;">
                                                <img src="<?php echo base_url('assets/images/fubk-icon.png')?>" style="width: 100px; margin:auto; position:relative"/>
                                                <div style="text-align: center;">Federal University Birnin Kebbi</div>
                                                <div style="text-align: center;">School of Postgraduate Studies</div>
                                            </div>
                                        </div>
                                        <hr>
                                        <table class="table table-stripped table-bordered" style="color:black">
                                            <tr>
                                                <th colspan="8">PERSONAL INFORMATION</th>
                                            </tr>
                                            <tr>
                                                <th>Full name</th>
                                                <td colspan="5"><?php echo strtoupper($applicant_data->applicant->surname) . ' ' . ucwords(trim($applicant_data->applicant->firstname . ' ' .$applicant_data->applicant->middlename)) ?></td>
                                                <th>Gender</th>
                                                <td><?php echo $applicant_data->applicant->gender ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td colspan="3"><?php echo $applicant_data->applicant->email ?></td>
                                                <th>Phone</th>
                                                <td><?php echo $applicant_data->applicant->phone ?></td>
                                                <th>Date of Birth</th>
                                                <td><?php echo $applicant_data->applicant->dob ?></td>
                                            </tr>
                                        </table>
                                        <table class="table table-stripped table-bordered" style="color:black">
                                            <tr>
                                                <th colspan="4">PROGRAMME APPLIED</th>
                                                <?php //$activeForm = $_SESSION['activeForm'] ?>
                                            </tr>
                                            <tr>
                                                <th>Programme</th>
                                                <td><?php echo $applicant_data->form->prog_abbr; ?></td>
                                                <th>Department</th>
                                                <td><?php echo $applicant_data->form->prog_abbr; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Faculty</th>
                                                <td><?php echo 'Arts/Science/Social Science' ?></td>
                                                <th>Remita Reference</th>
                                                <td><?php echo $applicant_data->form->rrr;  ?></td>
                                            </tr>
                                        </table>
                                        <table class="table table-stripped table-bordered" style="color:black">
                                            <tr>
                                                <th colspan="6">O'LEVEL INFORMATION</th>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="row">
                                                        <?php foreach ($applicant_data->olevels as $row) {
                                                            echo "<div class='col'>" . $row->subject . ' (' . $row->grade . ')</div>';
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table table-stripped table-bordered" style="color:black">
                                            <tr>
                                                <th colspan="6">A'LEVEL INFORMATION</th>
                                            </tr>
                                            <tr>
                                                <th>Insititution</th>
                                                <th>Year</th>
                                                <th>Qualification</th>
                                                <th>Result</th>
                                            </tr>
                                            <?php foreach ($applicant_data->alevels as $row) { ?>
                                                <tr>
                                                    <td style="width: 45%; font-weight: 900;"><?php echo $row->institution_name; ?></td>
                                                    <td><?php echo $row->graduation_year; ?></td>
                                                    <td><?php echo $row->qualification; ?></td>
                                                    <td><?php echo $row->grade; ?></td>
                                                </tr>
                                            <?php } ?>
                                        </table>
                                        <table class="table table-stripped table-bordered" style="color:black">
                                            <tr>
                                                <th colspan="6">Documents Uploaded</th>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="row">
                                                        <?php foreach ($applicant_data->uploads as $row) {
                                                            echo "<div class='col'>" . $row->file_type . ' (' . $row->year_obtained . ')</div>';
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="table table-stripped table-bordered" style="color:black">
                                            <tr>
                                                <th colspan="6">Referees Information</th>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="row">
                                                        <?php foreach ($applicant_data->referees as $row) {
                                                            echo '<div class="col-4">'
                                                            .'<b>' . $row->referee_title.' '. $row->referee_name . '</b><br>'
                                                            . $row->referee_rank . '<br>'
                                                            . $row->referee_email . '<br>'
                                                            . $row->referee_phone . '<br>'
                                                            .'</div>';
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                             <tr>
                                                <td colspan="6">
                                                    <div class="row">
                                                       
                                                        <?php foreach ($applicant_data->uploads as $row) {
                                                            if(pathinfo($row->file_url, PATHINFO_EXTENSION) == "pdf"){?>
                                                                
                                                                <div class="page" style="">
                                                                     <div class="subpage">
                                                             <?php     // Store the file name into variable
                                                                $file = $row->file_url;
                                                                $filename = $row->file_url;
                                                                  
                                                                // Header content type
                                                                header('Content-type: application/pdf');
                                                                  
                                                                header('Content-Disposition: inline; filename="' . $filename . '"');
                                                                  
                                                                header('Content-Transfer-Encoding: binary');
                                                                  
                                                                header('Accept-Ranges: bytes');
                                                                  
                                                                // Read the file
                                                                @readfile($file); ?>
                                                                
                                                            </div>
                                                        </div>
                                                              

                                                               
                                                               
                                                          <?php  } else {?>
                                                                <div class="page">
                                                                     <div class="subpage">
                                                                        <?php  echo "<img src='$row->file_url'>"; ?>
                                                                    </div>
                                                                </div>
                                                         <?php   }
                                                           
                                                        }
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $this->load->view('incs/footer'); ?>
        </div>
    </div>-->
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