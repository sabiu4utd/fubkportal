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


            <div class="section-body mt-4">
                <div class="container-fluid">
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="text-center"><?php echo strtoupper($students[0]->level." LEVEL STUDENTS OF ".$students[0]->prog_abbr.", ". $students[0]->session); ?></h4>
                                    <hr>
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <table
										class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                        <thead>
                                            <tr>
                                                <th style="text-align: left; width:50px;">#</th>
                                                <th style="text-align: left;">Student ID</th>
                                                <th style="text-align: left;">Student Name</th>
                                                <th style="text-align: left;">Gender</th>
                                                <th style="text-align: left;">Program</th>
                                                <th style="text-align: left;">Code</th>
                                                <th style="text-align: left;">Reassign</th>
                                                <th style="text-align: left;">Course Form</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($students as $row) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php 
                                                        echo $row->pnumber; 
                                                        if(!$row->course_reg_submitted){
                                                            echo " <i class='fa fa-circle text-danger sm'></i>";
                                                        }else{
                                                            if($row->course_reg_submitted and !$row->course_reg_approved){
                                                                echo " <i class='fa fa-circle text-primary sm'></i>";
                                                            }else{
                                                                echo " <i class='fa fa-circle text-success sm'></i>";
                                                            }
                                                        }
                                                    ?> </td>
                                                    <td><?php echo strtoupper($row->surname).", ".ucwords($row->firstname." ".$row->othername) ?></td>
                                                    <td><?php  echo $row->gender; ?> </td>
                                                    <td><?php echo $row->prog_abbr ?></td>
                                                    <td><b><?php echo $row->code_assigned ?></b></td>
                                                    <td>
                                                        <a href="<?php echo site_url('levelmanager/codeassign/'.hash('sha512', time()).'/'.$row->id.'/'.$row->programid.'/'.$row->level.'/'.$row->session_id.'/'.hash('sha512', time()))?>">
                                                            <i class="fa fa-undo"></i> Refresh Code
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo site_url('levelmanager/coursereg/'.hash('sha512', time()).'/'.$row->pnumber.'/'.$row->session_id.'/'.hash('sha512', time()))?>" target="_blank">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        
                                    </table>
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


    <script src="<?php echo base_url()?>assets/bundles/lib.vendor.bundle.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>

    <script src="<?php echo base_url()?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/bundles/dataTables.bundle.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/plugins/sweetalert/sweetalert.min.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>

    <script src="<?php echo base_url()?>assets/js/core.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/js/page/dialogs.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url()?>assets/js/table/datatable.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url()?>assets/js/rocket-loader.min.js" data-cf-settings="60cf6dc1a00fc0dbf92d681a-|49"
        defer=""></script>
</body>

</html>
