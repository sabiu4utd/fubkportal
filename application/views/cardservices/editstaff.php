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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css" />
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
    <div class="page-loader-wrapper">
        <div class="loader"></div>
    </div>
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-center p-4">
                                        <span style="float:left;">
                                            <a href="<?php echo site_url('card/stafflist')?>" class="btn btn-primary"> <i class="fa fa-arrow-left"> </i> Go Back</a>
                                        </span>
                                        Card Services >> Edit Staff Information
                                        <?php //var_dump($staff);var_dump($appts);?>
                                        
                                    </h5>
                                    <hr>
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <form action="<?php echo site_url('card/saveedit');?>" method="post">
                                        <table class="table table-hover js-basic-example table-striped table_custom border-style spacing5" id="">
                                            <tbody>
                                            
                                                <tr>
                                                    <th>Staff No</th>
                                                    <td><?php echo $staff->registry_file_no; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Surname</th>
                                                    <td>
                                                        <input type="text" value="<?php echo $staff->surname; ?>" class="form-control" name="surname" required />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Firstname</th>
                                                    <td>
                                                        <input type="text" value="<?php echo $staff->firstname; ?>" class="form-control" name="firstname" required />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Othername(s)</th>
                                                    <td>
                                                        <input type="text" value="<?php echo $staff->othername;?>" class="form-control" name="othername" selected />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Designation</th>
                                                    <td>
                                                        <select class="form-control" name="designation_id" required>
                                                            <?php 
                                                            foreach($designations as $row){
                                                                echo "<option ".($staff->designation_id == $row->id ? 'selected': '')." value='".$row->id."'>".$row->designation."</option>";
                                                            }?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Department</th>
                                                    <td>
                                                        <select class="form-control" name="dept_id" required>
                                                            <?php 
                                                            foreach($departments as $row){
                                                                echo "<option ".($staff->dept_id == $row->id ? 'selected': '')." value='".$row->id."'>".$row->dept_name."</option>";
                                                            }?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Appointment Type</th>
                                                    <td>
                                                        <select class="form-control" name="appt_type" required>
                                                            <?php 
                                                            foreach($appts as $row){
                                                                echo "<option ".($staff->appt_id == $row->id ? 'selected': '')." value='".$row->id."'>".$row->appointment_type."</option>";
                                                            }?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <input type="hidden" name="user_id" value="<?php echo $staff->user_id?>"/>
                                                        <button class="btn btn-primary display-block">
                                                            <i class="fa fa-save"></i> Save Update
                                                        </button>
                                                    </td>
                                                </tr>
                                            
                                            </tbody>
                                        </table>
                                        </form>
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
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script>
        $(document).ready( function () {
            $('#myTable1').DataTable({
                'dom': 'Bfrtip',
                'buttons': [
                    'excel', 'pdf', 'colvis'
                ]
            });
        });
    </script>
</body>
</html>