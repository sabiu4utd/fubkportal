<!doctype html>
<html lang="en" dir="ltr">
<?php //var_dump($authorizedStatus); exit; ?>
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
                                            <h2 style="text-align:center; font-size:22px">COURSE REGISTRATION FORM</h2>
                                            <?php if(isset($authorizedStatus) and $authorizedStatus->course_reg_approved){
                                                echo '<h3 style="text-align:center; font-size:20px; font-weight:bolder" class="text-success"><em>COURSE REGISTRATION FORM APROVED BY LEVEL COORDINATOR</em></h3>';
                                            }else{
                                                echo '<h3 style="text-align:center; font-size:20px; font-weight:bolder" class="text-danger"><em>COURSE REGISTRATION FORM NOT APROVED BY LEVEL COORDINATOR</em></h3>';
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 p-10">
                                            <HR>
                                            <table style=" width:100%; color:#000; font-size:19px " class="table-stripped">
                                                <tr>
                                                    <th style="width: 18%;">ADMISSION NO</th>
                                                    <td style="width: 62%;"><?php echo $student->pnumber; ?></td>
                                                    <th style="width: 10%;vertical-align:top">LEVEL</th>
                                                    <td style="vertical-align:top">
                                                        <?php
                                                            $level =  $courses[0]->level; 
                                                            if (($level % 100) == 10) echo "SPILL OVER I";
                                                            else if (($level % 100) == 20) echo "SPILL OVER II";
                                                            else echo $level;
                                                    ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="width: 18%;">FULL NAME</th>
                                                    <td style="width: 62%;"><?php echo strtoupper($student->surname) . " " . ucwords(strtolower($student->firstname . " " . $student->othername)); ?></td>
                                                    <th style="width: 10%;vertical-align:top">SESSION</th>
                                                    <td style="vertical-align:top"><?php echo $courses[0]->session ?></td>
                                                </tr>
                                                <tr>
                                                    <th>PROGRAM</th>
                                                    <td><?php echo $student->prog_abbr; ?></td>
                                                    <th>APPROVED</th>
                                                    <td><?php echo (isset($authorizedStatus) and $authorizedStatus->course_reg_approved) ? "YES": "PENDING"; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <br>
                                            <table class="table" style="color:#000">
                                                <tr style="color:#000">
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Code</th>
                                                    <th style="color:#000; font-weight:bolder" colspan="2">Course Title</th>
                                                    <th style="color:#000; font-weight:bolder;text-align: center;">Units</th>
                                                    <th style="color:#000; font-weight:bolder">Semester</th>
                                                </tr>

                                                <?php
                                                $i = 1;
                                                $total = 0;
                                                foreach ($courses as $row) {
                                                    $total += $row->credit_unit;
                                                ?>
                                                    <tr>
                                                        <td style="vertical-align: center;"><?php echo $i++; ?></td>
                                                        <td><?php echo $row->own_by == "NUC" ? "FUBK_".$row->course_code :$row->course_code; ?></td>
                                                        <td colspan="2"><?php echo $row->course_title; ?></td>
                                                        <td style="text-align: center;">
                                                            <?php echo $row->credit_unit ?>
                                                        </td>
                                                        <td><?php echo $row->value ?></td>
                                                    </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th colspan="4" class="text-right" style="color:#000">Total Credit Units Registered</th>
                                                    <th style="font-weight:bolder; color:#000; text-align:center"><?php echo $total; ?></th>
                                                    <th colspan="1">&nbsp;</th>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="text-left" style="color:#000">
                                                        <br><br>
                                                        ______________________________<br>
                                                        Student's Signature &amp; Date
                                                    </td>
                                                    <td colspan="3" class="text-right" style="color:#000">
                                                        <br><br>
                                                        __________________________________________<br>
                                                        Level Coordinator's Signature &amp; Date
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" style="font-weight:bolder; color:red">
                                                        Printed <?php echo date("D d-m-Y H:i:s"); ?>
                                                        <span class="float-right">
                                                            valid only when approved, signed &amp; Dated by the Level Coordinator
                                                        </span>
                                                        
                                                        
                                                    </th>
                                                </tr>
                                                <?php if(isset($is_lc) and $is_lc) { ?>
                                                <tr>
                                                    <td colspan="3">
                                                        <a href="<?php echo site_url('levelmanager/update/'.md5(time()).'/0/'.$courses[0]->session_id.'/'.$student->programid.'/'.$courses[0]->level.'/'.$student->userid.'/'.$student->pnumber.'/'.md5(rand()))?>" class="btn btn-danger">Reject Course Form</a>
                                                    </td>
                                                    <td colspan="3">
                                                        <a href="<?php echo site_url('levelmanager/update/'.md5(time()).'/1/'.$courses[0]->session_id.'/'.$student->programid.'/'.$courses[0]->level.'/'.$student->userid.'/'.$student->pnumber.'/'.md5(rand()))?>" class="btn btn-success float-right">Approve Course Form</a>
                                                    </td>
                                                </tr>
                                                <?php } ?>
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