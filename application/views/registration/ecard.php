<!DOCTYPE html>
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
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        table {
            border-spacing: 0px;
        }
        .table {
            margin-bottom: 0px;
            color: #000;
        }
        .table td,
        .table th {
            padding: 0.25rem;
            padding: 10px;
        }
        td{
            text-align: center;
        }
        @media all {
            .page-break {
                display: none;
            }
        }
        @media print {
            .page-break {
                display: block;
                page-break-before: always;
            }
        }
    
    </style>
</head>
<body class="font-muli right_tb_toggle" style="margin-left:2px; color:#000">
    <div id="main_content">
    
        <div class="page" style="width: 100%; margin-left:-280px; color:#000">
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Library-all">
                            <div class="card">
                                <div class="card-body"> 
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <img src="<?php echo base_url() ?>assets/images/fubk-icon.png" style="display:block; margin-left:auto; margin-right:auto; width:110px; padding-bottom: 5px;" />
                                            <h2 style="text-align:center; font-size:25px">FEDERAL UNIVERSITY BIRNIN KEBBI</h2>
                                            <h2 style="text-align:center; font-size:28px">STUDENT EXAMINATION CARD</h2>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-12 p-10">
                                            <?php if (!file_exists('./passport/'.$student->passport)){
                                                echo "<p class='alert alert-danger text-center'>Passport NOT Uploaded, DO NOT PRINT as this WILL NOT be ACCEPTED</p>";    
                                            } ?>
                                            <hr> <h2 class="text-left" style="font-size:27px;">Student Information</h2><hr>
                                            <table style=" width:100%; color:#000; font-size:19px">
                                                <tr>
                                                    <th style="width:27%; text-align:left">FULL NAME</th>
                                                    <td style="width:53%; text-align:left"><?php echo strtoupper($student->surname) . " " . ucwords(strtolower($student->firstname . " " . $student->othername)); ?></td>
                                                    <td rowspan="6"><img src="<?php echo base_url('passport/'.$student->passport);?>" style="margin-left:auto; margin-right:auto; width:210px;" /></td>
                                                </tr>
                                                <tr>
                                                    <th>ADMISSION NO</th><td style="text-align:left"><?php echo $student->pnumber; ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align:top; text-align:left">GENDER</th>
                                                    <td style="vertical-align:top; text-align:left"><?php echo $student->gender; ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align:top">LEVEL</th>
                                                    <td style="vertical-align:top; text-align:left">
                                                        <?php
                                                            $level =  $courses[0]->level; 
                                                            if (($level % 100) == 10) echo "SPILL OVER I";
                                                            else if (($level % 100) == 20) echo "SPILL OVER II";
                                                            else echo $level."Level";
                                                    ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>PROGRAM</th>
                                                    <td style="text-align:left"><?php echo $student->prog_abbr; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>SEMESTER &amp; SESSION</th>
                                                    <td style="text-align:left"><?php echo $courses[0]->value.' Semester, '.$courses[0]->session; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 p-10">
                                            <hr> <h2 class="text-left" style="font-size:27px;">Courses Registered for <?php echo $courses[0]->value.' Semester, '.$courses[0]->session; ?></h2><hr>
                                            <table style=" width:100%; color:#000; font-size:19px; border-collapse:collapse" border="1">
                                                <tr style="color:#000">
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Code</th>
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Code</th>
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Code</th>
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Code</th>
                                                </tr>
                                                <tbody>
                                                    <tr>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($courses as $row) {
                                                            $date = date_create(str_replace("/","-",$row->tt_date));
                                                            echo "<td style='vertical-align:top'>" . $i . "</td>";
                                                            echo "<td style='vertical-align:top'><b>" 
                                                                .$row->course_code."</b><br>"
                                                                .($row->tt_time ? $row->tt_time ."<br>" : "<br>")
                                                                .($row->tt_date ? date_format($date, 'D d-m-Y') : "N/A") ."<br/>"
                                                                //.str_replace(" ", ", ",trim(substr($row->venue, 1, strlen($row->venue)-2))) ."<br/>"
                                                                ."</td>";
                                                            echo ($i % 4 == 0) ? "</tr><tr>" : "";
                                                            $i++;
                                                        }
                                                        ?>
                                                    <tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 p-10">
                                            <hr>
                                            <br>
                                            <table style=" width:100%; color:#000; ">
                                                <tr style="color:#000">
                                                    <th style="vertical-align:top; width: 20%">
                                                        <img src="<?php echo base_url('assets/images/qrcode.png'); ?>" style="margin-left:auto; margin-right:auto; width:185px;" />
                                                    </th>
                                                    <th style="vertical-align:top">
                                                        <p style="text-align:justify">
                                                            <span style="font-size:14px;">This Examination Card is for the bearer alone, and to be used for the stated examinations ONLY. Any other use of this for any other purpose is considered a breach of University's policy and will be punishable according to the University's disciplinary procedures.</span>
                                                        </p>
                                                        <p class="text-center" style="color:red; font-weight:bolder">
                                                            Valid only after Signed &amp; Stamped by the EMC<br>
                                                            <span>See Overleaf (back) for Regulations<br>Please check with Departmental Timetable 24 hrs before each examination</span>
                                                        </p>
                                                    </th>
                                                    <th style="vertical-align:top; width: 20%; text-align:center">
                                                        <img src="<?php echo base_url('assets/images/signature.jpg'); ?>" style="margin-left:auto; margin-right:auto; width:175px;" />
                                                        <br>Chairman EMC<br>Sign &amp; Stamp
                                                    </th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="page" style="width: 100%; margin-left:-280px; color:#000">
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Library-all">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3" style="text-align:left">
                                            <?php echo  $student->pnumber; ?>
                                        </div>
                                        <div class="col-4" style="text-align:center">
                                            <?php echo strtoupper($student->surname) . ", " . ucwords(strtolower($student->firstname . " " . $student->othername)); ?>
                                        </div>
                                        <div class="col-3" style="text-align:right">
                                            Examination Card
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                        <div class="col-12 myheaderx font-weight-bolder">Examinations Rules and Regulations</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 p-10" style="font-size:22px;">
                                            <p>
                                            <ol>
                                                <li> Candidate should be within the vicinity of the examination hall at least 20 minutes before commencement of the examination for screening </li>
                                                <li> Candidate are required to sign the attendance slip
                                                <li>No candidate will be permitted to:
                                                    <ol style="list-style-type:alphabet">
                                                        <li>Enter examination room if he/she is more than 30 minutes late</li>
                                                        <li>Leave the examination room before 45 minutes after the commencement of the examinations</li>
                                                        <li>Leave the examination room during the last 15 minutes of the examinations</li>
                                                    </ol>
                                                <li>Candidate are not permitted to introduce into the examination hall paper/books/of any kind or hand bags</li>
                                                <li>Candidate must write only their admission numbers on answer booklet and additional sheets where necessary</li>
                                                <li>If you wish to attract the attention of the invigilator. You should raise your hand. Absolute silence must be maintained</li>
                                                <li>There should be no writing on this card and the question paper unless you are asked to do so</li>
                                                <li>Any student without Examinations and identity cards should not be allowed into Examination Hall</li>
                                                <li>Movement in or around examination premises is strictly prohibited </li>
                                                <li>Candidate are not allowed to enter examination hall with Mobile Phones</li>
                                                <li>Nursing mothers are not allowed to write examinations with thier babies</li>
                                                <li>Female student wearing face covering are required to be appropriately identified before they are admitted into examination hall and as may be required later for identification</li>
                                                <li>A candidate who arrive late should not be given extra time</li>
                                                <li>On entering the examination venue, it is the responsibility of the candidate to draw the attention of the invigilator to any paper or material on his/her seat, table or on the floor around him/her to ensure that such material are removed before the commencement of the examination.</li>
                                                <br>I hereby agree to abide by the regulations above.<br><br>
                                                Student's Signature:________________ Date:___________ 
                                            </ol>
                                            </p>
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
    <script src="<?php echo base_url() ?>assets/bundles/lib.vendor.bundle.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/bundles/dataTables.bundle.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/sweetalert/sweetalert.min.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url() ?>assets/js/core.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/page/dialogs.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url() ?>assets/js/table/datatable.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url() ?>assets/js/rocket-loader.min.js" data-cf-settings="60cf6dc1a00fc0dbf92d681a-|49" defer=""></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</body>
</html>
