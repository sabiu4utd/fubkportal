<!doctype html>
<?php 
$option = "";
    foreach($result as $r){
       $option .="<option value=".$r->deptid.">".$r->prog_abbr."</option>"; 
    }
    //var_dump($result);
?>
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
        <?php 
            $this->load->view('incs/header');
            $this->load->view('incs/lside');
        ?>

        <div class="page">

            <?php $this->load->view('incs/pageheader');?>

            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action">
                            <h1 class="page-title">Payments</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item"><a href="#">Courses</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Library-all">
                            
                                <a href="<?php echo site_url('payment/schedule');?>" class="float-right p-4"> <i class="fa fa-arrow-left"></i> View Schedules</a>
                            <div class="card">
                                <div class="card-body">
								
								<form method="POST" action="<?php echo site_url('course/save_course'); ?>">
								    <div class="row">
								        <div class="col-md-1">
    								        <select class="form-control align-middle" name="session" required> 
        								        <option value="<?php echo $this->session->userdata('active_session_id'); ?>">
        								            <?php echo $this->session->userdata("active_session"); ?>
        								        </option>
        								       
        								    </select>
    								    </div>
    								    <div class="col-md-2">
    								         <input type="text" name="course_title" class="form-control align-middle" required placeholder="Course Title">
    								    </div>
    								    <div class="col-md-2">
    								         <input type="text" name="course_code" class="form-control align-middle" required placeholder="Course Code">
    								    </div>
    								    <div class="col-md-1">
    								         <input type="number" name="credit_unit" class="form-control align-middle" required placeholder="Unit">
    								    </div>
    								    <div class="col-md-1">
    								          <select class="form-control  align-middle" name="semester" required>
        								        <option selected disabled>Choose Semester</option>
        								        <option value="<?php echo $this->session->userdata('active_session_id')+1; ?>">First</option>
        								        <option value="<?php echo $this->session->userdata('active_session_id')+2; ?>">Second</option>
        								      
        								    </select>
    								    </div>
    								    <div class="col-md-1">
    								         <select class="form-control  align-middle" name="level" required>
        								        <option selected disabled>Level</option>
        								        <option value="700">PGD</option>
        								        <option value="800">MSC</option>
        								        <option value="900">PHD</option>
        								    </select>
    								    </div>
    								    <div class="col-md-2">
    								         <select class="form-control  align-middle" name="deptid" required>
        								        <option selected disabled>Department</option>
        								        <?php echo $option; ?>
        								    </select>
    								    </div>
    								   <div class="col-md-2">
    								       <input type="submit" class="btn btn-primary align-middle" value="Save Course" />
    								   </div>
								    </div>
								   
								</form>
								<br><hr>
								</div>
								<div class="card-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>SN</th>
                                        <th>Program</th>
                                        <th>View</th>
                                        <th>Drop</th>
                                    </tr>
                                    <?php $i=1; foreach($result as $r){
                                        $level = 900;
                                        if(substr($r->prog_abbr, 0,1)=="M"){$level = 800;}
                                        if(substr($r->prog_abbr, 0,3)=="PGD"){$level = 700; }
                                    ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $r->prog_abbr; ?></td>
                                            <td><a href="<?php echo site_url("course/load_course/".$level."/".$r->deptid) ?>">View</a></td>
                                            <td><a href="<?php echo site_url("course/drop_courses/".$level."/".$r->deptid) ?>">Drop</a></td>
                                        </tr>
                                        
                                    <?php } ?>
                                    
                                   
                                </table>

                                </div>
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
  $( function() {
    
    
    
    $("#openPayslips" ).button().on( "click", function() {
        dialog = $( "#prepare-payslip" ).dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
        });
        dialog.dialog("open");
    });
  });
  </script> 

</body>

</html>
