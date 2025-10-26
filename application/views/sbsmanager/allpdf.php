<?php
session_start();
//require_once("conn/connection.php");
//require_once("conn/functions.php");
error_reporting(1);

//$pdo = prepareConnection(); //make Connection

$deptid = 1; //$_POST['department'];
$session = 64; //$_POST['session'];
$semester = 65; //$_POST['semester'];
$level = 1; //$_POST['level'];
//$semester = $_POST['semester'];
$usertype = 'student';



//get users under the selected department
$sql = "SELECT distinct(studentid) as pnumber, session_admitted, surname, firstname, othername, userid, entrymode, course_registration.level, user_profile.current_level as crlevel, session, department, prog_abbr, faculty FROM course_registration join courses join user_profile join department join faculty join program on courses.id = csid and course_registration.studentid = user_profile.pnumber and user_profile.deptid = department.id and user_profile.facultyid = faculty.id and program.id = user_profile.programid where (course_registration.level = ? and courses.semester = ?) and user_profile.programid = ? and usertype = ? order by studentid asc";
$data = [$level, $semester, $deptid, $usertype];
$users = $this->db->query($sql, $data)->result();
var_dump($users); die;

//get the credit units for the selected session and level
$sql = "SELECT * FROM cunit_threshold join settings on settings.id = cunit_threshold.session where deptid = :deptid and cunit_threshold.session = :session and level = :level";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':deptid', $deptid);
$stmt->bindParam(':level', $level);
$stmt->bindParam(':session', $session);
$stmt->execute();
$cu_thresh_ts = $stmt->fetchAll(PDO::FETCH_ASSOC);
$cu_thresh_ts = $cu_thresh_ts[0];
//var_dump($cu_thresh_ts);

//get the credit units to date
$sql = "SELECT DISTINCT (level), SESSION , max_units, min_units, SUM( max_units ) as max , SUM( min_units ) as min FROM cunit_threshold WHERE deptid =:deptid and session <= :session and level <= :level GROUP BY SESSION ORDER BY  min DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':deptid', $deptid);
$stmt->bindParam(':level', $level);
$stmt->bindParam(':session', $session);
$stmt->execute();
$cu_thresh_td = 0;
if ($stmt->rowCount() > 0) {
    $cu_thresh_td = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $cu_thresh_td = $cu_thresh_td[0];
}

//var_dump($cu_thresh_td);

$index = 1;
$su_ts = ""; //shortest of units this session
$su_td = ""; //shortest of unit to date

$k = 1;

$sql = "SELECT * from settings where id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $semester);
$stmt->execute();
$settings = $stmt->fetchAll(PDO::FETCH_ASSOC);

$passed_summary = array("WITHDRAWN" => 0, "PROBATION" => 0, "PASS" => 0);
$total_summary = 0;
$total_percent = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>Student Welcome .::. Student Portal, Federal University Birnin Kebbi</title>
    <link rel="icon" type="image/x-icon" href="https://mis.fubk.edu.ng//assets/img/favicon.ico" />

    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
    <link href="https://mis.fubk.edu.ng/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="https://mis.fubk.edu.ng/assets/css/plugins.css" rel="stylesheet" type="text/css" />


    <link href="https://mis.fubk.edu.ng/assets/css/users/user-profile.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://mis.fubk.edu.ng/assets/plugins/font-icons/fontawesome/css/regular.css">
    <link rel="stylesheet" href="https://mis.fubk.edu.ng/assets/plugins/font-icons/fontawesome/css/fontawesome.css">
    <link href="https://mis.fubk.edu.ng/assets/plugins/animate/animate.css" rel="stylesheet" type="text/css" />
    <script src="https://mis.fubk.edu.ng/assets/plugins/sweetalerts/promise-polyfill.js"></script>
    <link href="https://mis.fubk.edu.ng/assets/plugins/sweetalerts/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link href="https://mis.fubk.edu.ng/assets/plugins/sweetalerts/sweetalert.css" rel="stylesheet" type="text/css" />
    <link href="https://mis.fubk.edu.ng/assets/css/components/custom-sweetalert.css" rel="stylesheet" type="text/css" />

    <style>
        .btn-warning {
            color: #000 !important;
        }

        td,
        th {
            padding: 3px;
        }

        .res_summary td {
            text-align: center;
        }
    </style>
</head>

<body class="sidebar-noneoverflow">
    <div class="main-container" id="container">
        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--Header is finished Here-->
        <?php

        foreach ($users as $user) {


            $pnumber = $user['pnumber'];
            $completed = 'yes';
            $year_admitted = substr($user['session_admitted'], 0, 4);
            $entrymode = $user['entrymode'];


            //********************************************************************************************************//
            //*****************************BEGIN OF PREVIOUS SEMESTERS' GPA COMPUTATION*************************************//
            //********************************************************************************************************//
            //students previous failed courses

            $pco = array();
            if ($year_admitted > 2017 and $entrymode != 'DE') {
                $sql_co = "select * from course_registration join courses on csid = courses.id where studentid = :pnumber and (ca+exams) < 40 and semester < :semester order by course_code asc";
            } else {
                $sql_co = "select * from course_registration join courses on csid = courses.id where studentid = :pnumber and (ca+exams) < 44.45 and semester < :semester order by course_code asc";
            }
            $stmt = $pdo->prepare($sql_co);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':semester', $semester);
            $stmt->execute();
            $result_co = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result_co as $result) {
                $ccode = $result['course_code'];
                $pco[] = $ccode . "*" . $result['credit_unit'];
            }

            //students passed failed courses
            $ppo = array();
            if ($year_admitted > 2017 and $entrymode != 'DE') {
                $sql_co = "select * from course_registration join courses on csid = courses.id where studentid = :pnumber and (ca+exams) >= 40 and semester < :semester order by course_code asc";
            } else {
                $sql_co = "select * from course_registration join courses on csid = courses.id where studentid = :pnumber and (ca+exams) >= 44.45 and semester < :semester order by course_code asc";
            }
            $stmt = $pdo->prepare($sql_co);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':semester', $semester);
            $stmt->execute();
            $result_pc = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result_pc as $result) {
                $ccode = $result['course_code'];
                if (in_array($ccode . "*" . $result['credit_unit'], $pco)) {
                    $ppo[] = $ccode . "*" . $result['credit_unit'];
                }
            } //var_dump($pco);
            $pco = array_diff($pco, $ppo);
            //echo "******************************************************************************\n";

            //var_dump($pco);
            //students grade previous semesters
            $sql_ts = "select * from course_registration join courses on csid = courses.id where course_registration.studentid = :pnumber and courses.semester < :semester ";
            $stmt = $pdo->prepare($sql_ts);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':semester', $semester);
            $stmt->execute();
            $result_ls = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $cu_ls = 0;
            $gp_ls = 0;
            foreach ($result_ls as $result) {
                $cu = $result['credit_unit'];
                $cu_ls += $cu;
                $total = $result['ca'] + $result['exams'];

                //$gradeval = calculateGradeValue(calculateGrade($total));
                if ($year_admitted > 2017) {
                    $gradeval = calculateGradeValue2(calculateGrade2($total));
                } else {
                    $gradeval = calculateGradeValue(calculateGrade($total));
                }
                $gp_ls += $gradeval * $cu;
            }
            $freq = array_count_values($pco);
            //var_dump($freq);
            foreach ($freq as $key => $value) {
                if ($value > 1) {
                    $cu_ls -= substr($key, 7);
                }
            }

            foreach ($ppo as $p) {
                $cu_ls -= substr($p, 7);
            }

            //Compute GPA Last Session
            $gpa_ls = '-';
            //echo "********************GP LS:".$gp_ls." - ".$cu_ls;
            if ($cu_ls != 0 or $gp_ls != 0) {
                $gpa_ls = $gp_ls / $cu_ls;
            }
            //********************************************************************************************************//
            //********************************END OF PREVIOUS SEMESTERS' GPA COMPUTATION*************************************//
            //********************************************************************************************************//

            //********************************************************************************************************//
            //**************************BEGIN OF CURRENT SEMESTER GPA COMPUTATION*************************************//
            //********************************************************************************************************//

            //students grade in this session
            $cur_c = array(); //Courses registered this Session. This is used for checking Carry Over NOT Registered
            $sql_ts = "select * from course_registration join courses on csid = courses.id where course_registration.studentid = :pnumber  and courses.semester = :semester order by courses.level asc, course_code asc";
            $stmt = $pdo->prepare($sql_ts);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':semester', $semester);
            $stmt->execute();
            $result_ts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $cu_ts = 0;
            $gp_ts = 0;

            foreach ($result_ts as $result) {
                $cu = $result['credit_unit'];
                $cur_c[] = $result['course_code'] . "*" . $result['credit_unit'];;
                $cu_ts += $cu;
                $co_ts1 = $cu;
                $total = $result['ca'] + $result['exams'];
                if ($result['ca'] == '-' or $result['exams'] == '-') {
                    $completed = 'no';
                }
                //$gradeval = calculateGradeValue(calculateGrade($total));

                if ($year_admitted > 2017) {
                    $gradeval = calculateGradeValue2(calculateGrade2($total));
                } else {
                    $gradeval = calculateGradeValue(calculateGrade($total));
                }

                $gp_ts += $gradeval * $cu;
            }
            $gpa_ts = $gp_ts / $cu_ts;

            //********************************************************************************************************//
            //**************************END OF CURRENT SEMESTER GPA COMPUTATION*************************************//
            //********************************************************************************************************//

            //********************************************************************************************************//
            //**************************BEGIN OF SEMESTER TO DATE GPA COMPUTATION*************************************//
            //********************************************************************************************************//

            //WE COMPUTE UNITS TO DATE AND GP TO DATE.

            //students carry overs from previous semesters that were taken this semester 
            $sql_co_ts = "select * from course_registration join courses on csid = courses.id where studentid = :pnumber and course_registration.level > courses.level and courses.semester = :semester";
            $stmt = $pdo->prepare($sql_co_ts);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':semester', $semester);
            $stmt->execute();
            $result_co_ts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $co_ts = 0;
            foreach ($result_co_ts as $result) {
                if (in_array($result['course_code'] . "*" . $result['credit_unit'], $pco)) {
                    $co_ts += $cu = $result['credit_unit'];
                }
            }

            //CURRENT UNITS = LAST CREDIT UNIT + CURRENT CREDIT UNIT - PREVIOUS CARRYOVER CREDIT UNIT
            $cu_td = ($cu_ls + $cu_ts) - $co_ts;
            //var_dump($cu_td);

            //students grade to date
            $sql_td = "select * from course_registration join courses on csid = courses.id where studentid = :pnumber and course_registration.level <= :level and courses.semester <= :semester";
            $stmt = $pdo->prepare($sql_td);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':level', $level);
            $stmt->bindParam(':semester', $semester);
            $stmt->execute();
            $result_td = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $gp_td = 0;
            foreach ($result_td as $result) {
                $cu = $result['credit_unit'];
                $total = $result['ca'] + $result['exams'];

                //$gradeval = calculateGradeValue(calculateGrade($total));

                if ($year_admitted > 2017) {
                    $gradeval = calculateGradeValue2(calculateGrade2($total));
                } else {
                    $gradeval = calculateGradeValue(calculateGrade($total));
                }

                $gp_td += $gradeval * $cu;
            }

            $gpa_td = $gp_td / $cu_td;

            //********************************************************************************************************//
            //**************************BEGIN OF SEMESTER TO DATE GPA COMPUTATION*************************************//
            //********************************************************************************************************//

            //********************************************************************************************************//
            //**************************BEGIN OF CARRY OVER COMPUTATION*************************************//
            //********************************************************************************************************//


            //students overall failed courses
            $sql_co = "select course_code, credit_unit, courses.level as clevel, course_registration.level as crlevel, ca, exams, upload_status from course_registration join courses on csid = courses.id where studentid = :pnumber and (ca+exams) < 44.45 and semester = :semester order by course_code asc";
            $stmt = $pdo->prepare($sql_co);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':semester', $semester);
            $stmt->execute();
            $result_co = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $co = array();
            foreach ($result_co as $result) {
                $co[] = $result['course_code'] . "*" . $result['credit_unit'];
            }

            //students passed courses
            if ($year_admitted > 2017 and $entrymode != 'DE') {
                $sql_ps = "select * from course_registration join courses on csid = courses.id where studentid = :pnumber and (ca+exams) >= 40 and semester <= :semester   order by course_code asc";
            } else {
                $sql_ps = "select * from course_registration join courses on csid = courses.id where studentid = :pnumber and (ca+exams) >= 44.45 and semester <= :semester   order by course_code asc";
            }
            $stmt = $pdo->prepare($sql_ps);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':semester', $semester);
            $stmt->execute();
            $result_ps = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $ps = array();
            foreach ($result_ps as $result) {
                $ccode = $result['course_code'] . "*" . $result['credit_unit'];
                if (in_array($ccode, $co)) { //removes the carryover if it is passed
                    $co = array_diff($co, array($ccode));
                }
            }

            //carry over not registered

            //********************************************************************************************************//
            //**************************END OF CARRY OVER COMPUTATION*************************************//
            //********************************************************************************************************//

            //********************************************************************************************************//
            //**************************EXTRA CASES AND SHORTAGES COMPUTATION*************************************//
            //********************************************************************************************************//

            //students extra cases
            $sql_ps = "select * from extra_cases where level <= :level and studentid = :pnumber";
            $stmt = $pdo->prepare($sql_ps);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':level', $level);
            $stmt->execute();
            $extras = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $specialcases = '';
            $case = 'no';
            foreach ($extras as $extra) {
                if (substr_compare_startswith(($extra['extracase']), 'Withdraw')) {
                    $case = 'yes';
                }
                $specialcases .= $extra['extracase'] . " @ " . $extra['level'] . " Level " . $extra['session'] . "<br>";
            }

            //Computing Shortages

            $shortages = '';
            $y = $level;
            //for($y = $level; $y >= 100; $y -= 100){
            $sql_w = "select studentid, sum(credit_unit) as total_reg, courses.level, course_registration.level as clevel, courses.session from course_registration join courses on csid = courses.id where studentid = :pnumber and courses.level = :level and course_registration.level = :level order by course_code asc";
            $stmt = $pdo->prepare($sql_w);
            $stmt->bindParam(':pnumber', $pnumber);
            $stmt->bindParam(':level', $y);
            $stmt->execute();
            $result_w = $stmt->fetchAll(PDO::FETCH_ASSOC);
            //var_dump($result_w);
            $xsession = $result_w[0]['session'];
            $sql_x = "select * from cunit_threshold where deptid = '$deptid' and level = '$y' and session = '$xsession'";
            $stmt = $pdo->prepare($sql_x);
            $stmt->execute();
            $result_x = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $short = $result_x[0]['min_units'] - $result_w[0]['total_reg'];
            if ($short > 0) {
                $shortages .= "<br>" . $short . " Unit(s) @ " . $y . " Level";
            }
            //}

        ?>
            <p style="page-break-before: always">
            <div id="content" class="main-content" style="margin-top: -70px; width:85%">
                <div class="layout-px-spacing">
                    <div class="row layout-spacing">
                        <div class="col-12  layout-top-spacing">
                            <div class="user-profile layout-spacing">
                                <div class="user-info-list">
                                    <div class="">
                                        <div class="form-group row mb-4">
                                            <div class="col-12" style="padding-top:40px;">
                                                <div class="user-profile layout-spacing">
                                                    <div class="widget-content widget-content-area">
                                                        <div class="row">
                                                            <div class="col-2">
                                                                <img src="https://mis.fubk.edu.ng//assets/img/logo.png" style="margin-left:auto; margin-right:auto; width:100px" />
                                                            </div>
                                                            <div class="col-8">
                                                                <h2 style="text-align:center; font-size:22px">FEDERAL UNIVERSITY BIRNIN KEBBI</h2>
                                                                <h2 style="text-align:center; font-size:22px">Student's Result Sheet</h2>
                                                                <h2 style="text-align:center; font-size:22px"><?php echo $settings[0]['value'] . " Semester, " . $cu_thresh_ts['value'] . " Session"; ?></h2>
                                                            </div>
                                                            <div class="col-2">
                                                                <img src="https://mis.fubk.edu.ng/assets/passport/<?php echo $user['passport']; ?>" style="margin-left:auto; margin-right:auto; width:100px; height:115px" />
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
                                                                            <td><?php echo strtoupper($user['surname']) . " " . ucwords(strtolower($user['firstname'] . " " . $user['othername'])); ?></td>
                                                                            <td>ADMISSION NO</td>
                                                                            <td><?php echo $pnumber; ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>FACULTY</td>
                                                                            <td><?php echo strtoupper($users[0]['faculty']); ?></td>
                                                                            <td>DEPARTMENT</td>
                                                                            <td><?php echo strtoupper($users[0]['department']); ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>PROGRAM</td>
                                                                            <td><?php echo strtoupper($users[0]['prog_abbr']); ?></td>
                                                                            <td>LEVEL</td>
                                                                            <td><?php echo $level; ?></td>

                                                                        </tr>
                                                                    </table>
                                                                    <hr>
                                                                    <table style="width: 100%; color:#000; font-size:16px; border-collapse:collapse" border="1">
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
                                                                        foreach ($result_ts as $result) {
                                                                            $total = $result['ca'] + $result['exams'];
                                                                            $rgrade = $year_admitted > 2017 ? calculateGrade2($total) : calculateGrade($total);
                                                                            $is_co = in_array($result['course_code'] . "*" . $result['credit_unit'], $pco) ? "*" : "";
                                                                            $status = $rgrade == "F" ? "FAIL" : "PASS";

                                                                            echo "<tr>";
                                                                            echo "<td>" . ($i++) . "</td>";
                                                                            echo "<td>" . $result['course_code'] . $is_co . "</td>";
                                                                            echo "<td>" . $result['course_title'] . "</td>";
                                                                            echo "<td style='text-align:center'>" . $result['credit_unit'] . "</td>";
                                                                            echo "<td style='text-align:center'>" . $rgrade . "</td>";
                                                                            echo "<td>" . $status . "</td>";
                                                                            echo "</tr>";
                                                                        }
                                                                        ?>
                                                                        <tr style="font-weight: bold;">
                                                                            <td colspan="6">RESULT SUMMARY</td>
                                                                        </tr>
                                                                    </table>
                                                                    <table class="res_summary" style="width: 100%; color:#000; font-size:16px; border-collapse:collapse" border="1">
                                                                        <tr>
                                                                            <th>KEY</th>
                                                                            <th>Units</th>
                                                                            <th>Gradepoint</th>
                                                                            <th>GPA</th>
                                                                            <th style="width:50%">REMARKS</th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align:left">Previous</td>
                                                                            <td><?php echo $cu_ls; ?></td>
                                                                            <td><?php echo $gp_ls; ?></td>
                                                                            <td><?php if ($gpa_ls == 0) {
                                                                                    echo "-";
                                                                                } else {
                                                                                    echo number_format($gpa_ls, 2, '.', ',');
                                                                                } ?></td>
                                                                            <td rowspan="3" style="padding:7px; vertical-align:top; text-align:left">
                                                                                <?php
                                                                                $co = array_unique($co);
                                                                                if ($completed == 'no' and $cu_ts != 0) {
                                                                                    echo '<strong>INCOMPLETE RESULTS:</strong><br>';
                                                                                } else {
                                                                                    if (count($co) == 0 && $gp_ts != 0 and $shortages == '') {
                                                                                        echo "PASS";
                                                                                    } else if (count($co) > 0) { //if carryover array is not empty
                                                                                        $myco = '<strong>REPEAT:</strong><br>';

                                                                                        foreach ($co as $c) {
                                                                                            if (in_array($c, $pco) and !in_array($c, $cur_c)) { // Carry Over NOT Registered
                                                                                                //$myco .= "(".substr($c,0,6)."), ";
                                                                                            } else {
                                                                                                $myco .= substr($c, 0, 6) . ", ";
                                                                                            }
                                                                                        }
                                                                                        echo substr($myco, 0, strlen($myco) - 2);
                                                                                    }
                                                                                    if ($shortages != "") {
                                                                                        echo "<br><strong>SHORTAGE:</strong>" . $shortages . "<br>(Speak with your Level Coordinator for shortages)";
                                                                                    }
                                                                                } ?>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th style="text-align:left">Current</th>
                                                                            <th style="text-align:center">
                                                                                <?php
                                                                                echo $cu_ts;
                                                                                $su_td = '';
                                                                                if (($cu_thresh_ts['min_units'] + $cu_thresh_td['min']) > $cu_td and $user['entrymode'] != 'DE') {
                                                                                    $su_td = ($cu_thresh_ts['min_units'] + $cu_thresh_td['min']) - $cu_td;
                                                                                }
                                                                                if (($cu_thresh_ts['min_units'] + $cu_thresh_td['min']) > $cu_td and $user['entrymode'] == 'DE') {
                                                                                    $su_td = ($cu_thresh_ts['min_units']) - $cu_td;
                                                                                }

                                                                                ?>
                                                                            </th>
                                                                            <th style="text-align:center"><?php echo $gp_ts; ?></th>
                                                                            <th style="text-align:center"><?php echo number_format(($gp_ts / $cu_ts), 2, '.', ',');; ?></th>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="text-align:left">Cummulative</td>
                                                                            <td><?php echo $cu_td; ?></td>
                                                                            <td><?php echo $gp_td; ?></td>
                                                                            <td><?php if ($completed == 'yes') {
                                                                                    echo number_format($gpa_td, 2, '.', ',');
                                                                                } else {
                                                                                    echo '-';
                                                                                } ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5">
                                                                                <a href="#" onclick="window.print()" class="float-left">
                                                                                    <img src="https://mis.fubk.edu.ng/assets/img/printer_icon.jpg" style="width:25px; " />
                                                                                </a>
                                                                                <span class="float-right">Printed Wed 24, Nov 2021 14:37:08</span>
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
        <?php }  ?>
    </div>
</body>

</html>