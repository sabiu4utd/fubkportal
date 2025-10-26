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
                            <h1 class="page-title">Payments</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item"><a href="#">GST Results</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Library-all">
                            <div class="card">
                                <div class="card-body">
									<table
										class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
										<thead>
											<tr>
												<th>#</th>
												<th>Session</th>
												<th>Semester</th>
												<th>Course Code</th>
												<th>Course Title</th>
												<th>Grade</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; foreach($results as $row){ ?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row->session; ?></td>
												<td><?php echo $row->semester; ?></td>
												<td><?php echo $row->course_code ?></td>
												<td><?php echo $row->course_title; ?></td>
												<td><?php 
												    if($row->current_level % 100 == 0){
    												    $total = $row->ca + $row->exams; 
    												    $grade = "F";
    												    if($total >= 69.49){
    												        $grade = "A";
    												    }else if($total >= 59.49){
    												        $grade = "B";
    												    }else if($total >= 49.49){
    												        $grade = "C";
    												    }else if($total >= 44.49){
    												        $grade = "D";
    												    }else if($total >= 39.49){
    												        $grade = "E";
    												    }else {
    												        $grade = "F";
    												    }
    												    echo $grade;
												    }else{
												        echo "Please go to GST Dept";
												    }
												    
												?></td>
												<td><?php 
    												if($row->current_level % 100 == 0){
    												    echo $grade == "F" ? "FAIL" : "PASS"; 
    												}else{
    											        echo "Please go to GST Dept";
    											    }
												?></td>
											</tr>
											<?php } ?>
										</tbody>
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
