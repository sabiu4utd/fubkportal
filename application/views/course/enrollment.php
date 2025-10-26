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
                                            <h2 style="text-align:center; font-size:25px; font-weight:900">ATTENDANCE REGISTER</h2>
                                            <h2 style="text-align:center; font-size:25px"><?php echo $courseinfo->course_code. " - ".$courseinfo->course_title; ?></h2>
                                            <h2 style="text-align:center; font-size:21px"><?php echo $courseinfo->level." Level - ".$courseinfo->value." SEMESTER, ".$courseinfo->session ?></h2>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <br>
                                            <table class="table" style="color:#000">
                                                <tr style="color:#000">
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Student ID</th>
                                                    <th style="color:#000; font-weight:bolder">Student Name</th>
                                                    <th style="color:#000; font-weight:bolder;">Program</th>
                                                    <th style="color:#000; font-weight:bolder">Student's Signature</th>
                                                </tr>

                                                <?php $i = 1;  foreach ($coursemarks as $row) { ?>
                                                <tr>
                                                    <td style="vertical-align: center;"><?php echo $i++; ?></td>
                                                    <td><?php echo $row->pnumber ?></td>
                                                    <td><?php echo strtoupper($row->surname) . " " . ucwords(strtolower($row->firstname . " " . $row->othername)); ?></td>
                                                    <td style=""><?php echo $row->prog_abbr ?></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td class="text-left" style="color:#000" colspan="4">
                                                        <br><br>
                                                        _________________________________<br>
                                                        Lecturer's Signature &amp; Date
                                                    </td>
                                                    <td style="font-weight:bolder; color:red">
                                                        Printed <?php echo date("D d-m-Y H:i:s"); ?>
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