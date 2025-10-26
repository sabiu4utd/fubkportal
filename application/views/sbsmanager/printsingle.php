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
        #viewres td, #viewres th{
            padding-left: 5px;;
        }
        #viewres th, .res_summary th{
            text-align: center;
        }
    </style>

</head>

<body class="font-muli right_tb_toggle" style="margin-left:2px; color:#000">
    <div id="main_content">

        <div class="page" style="width: 84%; margin-left:-220px; color:#000">

            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Library-all">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-2 mx-auto">
                                            <img src="<?php echo base_url() ?>assets/images/fubk-icon.png" style="width:132px; height:120px;" />
                                        </div>
                                        <div class="col-8 text-center">
                                            <h4 style="font-weight: bolder;">FEDERAL UNIVERSITY BIRNIN KEBBI</h4>
                                            <h4 style="font-weight: bolder;">Student's Result Sheet</h4>
                                            <h5 style="font-weight: bolder;">
                                                <?php echo $info['semester_name']." Semester, ".$info['session_name']." Session"; ?></h5>
                                        </div>
                                        <div class="col-2">
                                            <img src="https://mis.fubk.edu.ng/assets/passport/<?php echo $detail->passport; ?>" style="width:110px; height:120px; float:right" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="user-info-list">
                                                <table style="font-weight: bolder; width:100%; color:#000; font-size:16px;">
                                                    <tr>
                                                        <td>FULL NAME</td>
                                                        <td><?php echo strtoupper($detail->surname) . " " . ucwords(strtolower($detail->firstname . " " .  $detail->othernames)); ?></td>
                                                        <td>ADMISSION NO</td>
                                                        <td><?php echo $detail->pnumber; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <td>FACULTY</td>
                                                        <td><?php echo $detail->division_name; ?></td>
                                                        <td>DEPARTMENT</td>
                                                        <td><?php echo $detail->dept_name; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PROGRAM</td>
                                                        <td><?php echo $detail->prog_abbr; ?></td>
                                                        <td>LEVEL</td>
                                                        <td>
                                                            <?php
                                                            if ($info['level'] < 6) {
                                                                echo $info['level'] . "00";
                                                            } else if ($info['level'] == 9) {
                                                                echo "Spill Over I";
                                                            } else if ($info['level'] == 10) {
                                                                echo "Spill Over II";
                                                            }
                                                            ?>
                                                        </td>

                                                    </tr>

                                                </table>

                                                <hr>
                                                <table style="width: 100%; color:#000; font-size:16px; border-collapse:collapse" border="1" id="viewres">
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>CODE</th>
                                                        <th>COURSE TITLE</th>
                                                        <th>UNITS</th>
                                                        <th>GRADE</th>
                                                        <th>STATUS</th>
                                                    </tr>
                                                    <?php
                                                    $i = 1;
                                                    $total = 0;
                                                    $total_units = 0;
                                                    foreach ($result as $row) {
                                                        $grade = "F";

                                                        if (is_numeric($row->ca) && is_numeric($row->exams)) {
                                                            $total = round($row->ca + $row->exams);
                                                        } elseif ($row->ca == "ABS" && $row->exams == "ABS") {
                                                            $total = "ABS";
                                                        } else {
                                                            $total = "-";
                                                        }
                                                        $status = "PASS";
                                                        if ($total == "ABS" || $total == "-") {
                                                            $grade = "F";
                                                            $status = "FAIL";
                                                        } else {
                                                            if ($total >= 70) {
                                                                $grade = 'A';
                                                            } elseif ($total >= 60) {
                                                                $grade = 'B';
                                                            } elseif ($total >= 50) {
                                                                $grade = 'C';
                                                            } elseif ($total >= 45) {
                                                                $grade = 'D';
                                                            } elseif ($total >= 40) {
                                                                $grade = 'E';
                                                            } elseif ($total >= 0) {
                                                                $grade = 'F';
                                                                $status = "FAIL";
                                                            }
                                                        }

                                                        $total_units += $row->credit_unit;
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i; ?></td>
                                                            <td><?php echo $row->course_code; ?></td>
                                                            <td><?php echo $row->course_title; ?></td>
                                                            <td style="text-align:center"><?php echo $row->credit_unit; ?></td>
                                                            <td style="text-align:center"><?php echo $grade; ?></td>
                                                            <td><?php echo $status; ?></td>

                                                        </tr>
                                                    <?php $i++;
                                                    } ?>
                                                    <tr style="font-weight: bold;">
                                                        <td colspan="6">RESULT SUMMARY</td>
                                                    </tr>
                                                </table>
                                                <table class="res_summary" style="width: 100%; color:#000; font-size:16px; border-collapse:collapse" border="1">
                                                    <tr>
                                                        <th style="text-align: left;">KEY</th>
                                                        <th>Units</th>
                                                        <th>Gradepoint</th>
                                                        <th>GPA</th>
                                                        <th style="width:50%">REMARKS</th>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left">Previous</td>
                                                        <td style="text-align:center"><?php echo $result_info['ls']['cu']; ?></td>
                                                        <td style="text-align:center"><?php echo $result_info['ls']['gp']; ?></td>
                                                        <td style="text-align:center"><?php echo $result_info['ls']['gpa']; ?></td>
                                                        <td rowspan="3" style="padding:7px; vertical-align:top; text-align:left">
                                                            <?php
                                                            if (count($carryovers) == 0) {
                                                                echo "<b>PASSED</b>";
                                                            } else {
                                                                foreach ($carryovers as $row) {
                                                                    echo substr($row, 0, 6).", ";
                                                                }
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th style="text-align:left">Current</th>
                                                        <th style="text-align:center"><?php echo $result_info['ts']['cu']; ?></th>
                                                        <th style="text-align:center"><?php echo $result_info['ts']['gp']; ?></th>
                                                        <th style="text-align:center"><?php echo $result_info['ts']['gpa']; ?></th>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align:left">Cummulative</td>
                                                        <td style="text-align:center"><?php echo $result_info['td']['cu']; ?></td>
                                                        <td style="text-align:center"><?php echo $result_info['td']['gp']; ?></td>
                                                        <td style="text-align:center"><?php echo $result_info['td']['gpa']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">
                                                            <a href="#" onclick="window.print()" class="float-left">
                                                                <i class="fa fa-print"></i>
                                                            </a>
                                                            <span class="float-right"><?php echo "Printed " . date("D d, M Y H:i:s") ?></span>
                                                        </td>
                                                    </tr>
                                                </table>
                                                <br>
                                                <div style="color:red; font-weight:bold; text-align:center">
                                                    This is NOT a Transcript. Result is subject to Senate Approval
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
    </div>

    </div>
    </div>
    <?php //$this->load->view('panels/footer'); 
    ?>
    <!--  END CONTENT AREA  -->
    </div>
    <!-- END MAIN CONTAINER -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    
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