<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['pageTitle']; ?></title>

    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/x-icon" />


    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet"
        href="<?php echo base_url()?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url()?>assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url()?>assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">

    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
        
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    

</head>

<body class="font-muli right_tb_toggle <?php echo " ".$_SESSION['theme_mode']; ?>">

    <div class="page-loader-wrapper">
        <div class="loader">
        </div>
    </div>
    <div id="main_content">
        <?php $this->load->view('incs/header');?>
        <?php //$this->load->view('incs/rside');?>
        <?php $this->load->view('incs/lside');?>

        <div class="page">

            <?php $this->load->view('incs/pageheader');?>

            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action">
                            <h1 class="page-title">Timetabling</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item"><a href="#">Timetable</a></li>
                                <li class="breadcrumb-item"><a href="#">Course Schedule</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card p-4">
                                <h6 style="margin:auto; text-decoration:underline; padding-top:10px; padding-bottom:10px">Course View</h6>
                                <form action="<?php echo site_url('timetabling/update')?>" method="post">
                                <table class="table table-bordered table-hover table-sm mx-auto" style='color:#000; border-color:#000; width:700px'>
                                    <tr><th>Course Code</th><td><?php echo $schedule->course_code; ?></td></tr>
                                    <tr><th>Course Title</th><td><?php echo $schedule->course_title; ?></td></tr>
                                    <tr><th>Credit Unit</th><td><?php echo $schedule->credit_unit; ?> unit(s)</td></tr>
                                    <tr><th>Semester</th><td><?php echo $schedule->value.' semester, '.$schedule->session; ?></td></tr>
                                    <tr><th>Scheduled type</th><td><?php echo $schedule->type; ?></td></tr>
                                    <tr><th>Scheduled Date</th><td><input type="date" value="<?php echo $schedule->tt_date; ?>" name="tt_date" class="form-control" required/></td></tr>
                                    <tr><th>Scheduled Start Time</th><td><input type="time" value="<?php echo $schedule->start_time; ?>" name="start_time" class="form-control" required/></td></tr>
                                    <tr><th>Scheduled End Time</th><td><input type="time" value="<?php echo $schedule->end_time; ?>" name="end_time" class="form-control" required/></td></tr>
                                    <tr><th>Scheduled Venue</th><td><textarea rows="2" name="venue" class="form-control"><?php echo $schedule->venue; ?></textarea></td></tr>
                                    <tr>
                                        <td>
                                            <a href="<?php echo site_url('timetabling/remove/'.$schedule->id)?>" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                        </td>
                                        <td>
                                            <input type="hidden" name="tt_id" value="<?php echo $schedule->id;?>" />
                                            <input type="submit" class="btn btn-success float-right" value="Save Changes">
                                        </td>
                                    </tr>
                                </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php $this->load->view('incs/footer');?>
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
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  
  </script> 

</body>

</html>
