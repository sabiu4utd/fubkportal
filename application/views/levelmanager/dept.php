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
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/sweetalert/sweetalert.css">
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
                    <div class="row clearfix">
                        <div class="col-xl-12">
                            <div class="row clearfix row-deck">
                                <div class="col-md-2 col-sm-6 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('levelmanager/allocatecoordinator') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-user-secret"></i>
                                                <span>Assign Level Coordinator</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-md-2 col-sm-6 raise">-->
                                <!--    <div class="card">-->
                                <!--        <div class="card-body">-->
                                <!--            <a href="<?php echo site_url('course/courselist') ?>" class="my_sort_cut text-muted">-->
                                <!--                <i class="fa fa-user-secret"></i>-->
                                <!--                <span>Lecturer Allocation</span>-->
                                <!--            </a>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="col-md-2 col-sm-6 raise">-->
                                <!--    <div class="card">-->
                                <!--        <div class="card-body">-->
                                <!--            <a href="<?php echo site_url('payslip') ?>" class="my_sort_cut text-muted">-->
                                <!--                <i class="fa fa-tools"></i>-->
                                <!--                <span>Payslips Manager</span>-->
                                <!--            </a>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="col-md-2 col-sm-6 raise">-->
                                <!--    <div class="card">-->
                                <!--        <div class="card-body">-->
                                <!--            <a href="#<?php echo site_url('') ?>" class="my_sort_cut text-muted" onclick="alert('feature coming soon')">-->
                                <!--                <i class="fa fa-file-export"></i>-->
                                <!--                <span>Reports</span>-->
                                <!--            </a>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                        <thead>
                                            <tr>
                                                <th style="text-align: left; width:50px;">#</th>
                                                <th style="text-align: left;">SP Number</th>
                                                <th style="text-align: left;">Lecturer Name</th>
                                                <th style="text-align: left;">Programme</th>
                                                <th style="text-align: left;">Session</th>
                                                <th style="text-align: left;">Level</th>
                                                <th style="text-align: left;">View</th>
                                                <th style="text-align: left;">Assign Codes</th>
                                                <th style="text-align: left;">Remove</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($levels as $row) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo ucwords($row->registry_file_no) ?></td>
                                                    <td><?php echo ucwords($row->surname).", ".$row->firstname." ".$row->othername ?></td>
                                                    <td><?php echo ucwords($row->prog_abbr) ?></td>
                                                    <td><?php  echo $row->session; ?> </td>
                                                    <td><?php echo $row->level ?></td>
                                                    <td>
                                                        <a href="<?php echo site_url('levelmanager/deptview/'.hash('sha512', time()).'/'.$row->program_id.'/'.$row->level.'/'.$row->session_id.'/'.hash('sha512', time()))?>">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <button type="button" 
                                                            class="btn btn-icon btn-sm js-sweetalert text-primary" 
                                                            title="Delete" 
                                                            data-type="refresh-creg-codes"
                                                            data-programid="<?php echo $row->program_id?>" 
                                                            data-level="<?php echo $row->level?>" 
                                                            data-sessionid="<?php echo $row->session_id?>" >
                                                            <i class="fa fa-undo"></i> Refresh Codes
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo site_url('levelmanager/remove/'.hash('sha512', time()).'/'.$row->staff_level_cordinator_id.'/'.hash('sha512', time()))?>">
                                                            <i class="fa fa-trash text-danger"></i> Remove
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
    <script src="<?php echo base_url()?>assets/plugins/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <script>
        $(function () {
            $('.js-sweetalert').on('click', function () {
                event.preventDefault();
                var type = $(this).data('type');
                if (type === 'refresh-creg-codes') {
                    var programid = $(this).data('programid');
                    var level = $(this).data('level');
                    var sessionid = $(this).data('sessionid');
                    swal({
                        title: "Are you sure?",
                        text: "You are about to reset the code of all students!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#dc3545",
                        confirmButtonText: "Proceed!",
                        cancelButtonText: "Go Back!",
                        closeOnConfirm: false,
                        closeOnCancel: true
                    }, function (isConfirm) {
                        if (isConfirm) {
                            $.post("<?php echo site_url('levelmanager/assign/')?>",
                              {
                                programid: programid,
                                level: level,
                                sessionid: sessionid,
                              },
                              function(data, status){
                                  console.log(data);
                                  swal("Codes Refreshed!", "Code Registarion Codes have been refreshed.", "success");
                              });
                        } 
                    });
                }
            })
        });
    </script>
</body>

</html>
