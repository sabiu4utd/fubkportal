  <?php //var_dump($session_courses); ?>
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
                                <li class="breadcrumb-item"><a href="#">Course Registration History</a></li>
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
                                    <div class="alert alert-info">
                                        <b>NOTE:</b>
                                        <ul>
                                            <li>To drop a course you have registered already, click on Add/Drop</li>
                                            <li>You MUST Update your bio data and upload photo to do course registration</li>
                                        </ul>
                                    </div>
                                    
									<table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
										<thead>
											<tr>
												<th>#</th>
												<th>Session</th>
												<th>Level</th>
												<th>Total Units</th>
												<th>Status</th>
												<th>Add/Drop</th>
												<th>Manage</th>
											</tr>
										</thead>
										<tbody>
										    <?php  $i = 1;
										        if ($_SESSION['tuition_payment_status'] == "Pending"){
										            echo "<tr><td colspan='7' class='alert alert-warning text-center'>Tuition Fees for ".$_SESSION['active_session']." session NOT PAID</td></tr>";
										        }else{
										            if(!$student){
										                $this->session->set_flashdata('msg', "Something wrong with your account. Contact MIS immediately"); 
										                redirect('student/index', 'refresh');
										            }
										            //echo $student->passport. " - ".(file_exists('./passport/'.$student->passport));
										            if($student->passport == "default.jpg" or !file_exists('./passport/'.$student->passport)){
										                echo "<tr><td colspan='7' class='alert alert-warning text-center'>Please update your biodata and upload your photo</td></tr>";
										            }else{
										            if (!$active_session_history){?>
            											<tr>
            												<td><?php echo $i++; ?></td>
            												<td><?php echo $_SESSION["active_session"] ?></td>
            												<td><?php echo $_SESSION["current_level"] ?></td>
            												<td>0 Unit(s)</td>
            												<td> <?php 
            												    if($_SESSION['activeSettingsManager']['COURSE_REGISTRATION_STATUS']['value'] == "Open"){
                                                                    echo "Open"; //"<span class='badge badge-primary p-2'>Course Registration Open</span>";
                                                                }else{
                                                                    echo "<span class='badge badge-dark p-2'>Course Registration Closed</span>";
                                                            } ?></td>
                                                            <td> <?php 
            												    if($_SESSION['activeSettingsManager']['ADD_DROP_STATUS']['value'] == "Open"){
                                                                    echo "Closed";//<span class='badge badge-primary p-2'>Add/Drop closed</span>";
                                                                }else{
                                                                    echo "Cloed";// "<span class='badge badge-dark p-2'>Add/Drop Closed</span>";
                                                            } ?></td>
                                                            <td> <?php 
            												    if($_SESSION['activeSettingsManager']['COURSE_REGISTRATION_STATUS']['value'] == "Open"){ 
            												        if($_SESSION["current_level"] != 1000) { ?>
            												            <a href="<?php echo site_url('course/register/'.md5(time().rand()).'/'.$_SESSION["active_session"])?>">
                                                                         <span class='badge badge-primary p-2'>
                                                                         <i class="fa fa-plus"> Register</i> 
                                                                         </span>
                                                                      
                                                                      <?php } else{  echo 'CLOSED'; } ?>
                                                                    </a>
            												       
                												        
                                                                        <!--a href="<?php echo site_url('course/register/'.md5(time().rand()).'/'.$_SESSION["active_session"])?>">
                                                                             <i class="fa fa-plus"></i --> 
                                                                          <?php } else{  echo 'CLOSED'; } ?>
                                                                        </a>
                                                                    <?php }else{
                                                                    echo "<span class='badge badge-dark p-2'>Course Registration open</span>";
                                                            } ?></td>
                                                            
            											</tr>
											<?php }}
						
										            
										        
											foreach($course_reg_history as $row){ ?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row->value ?></td>
												<td><?php echo $row->level; ?></td>
												<td><?php echo $row->units ?> Units</td>
												<td>
                                                    <?php 
                                                        if($_SESSION['activeSettingsManager']['SESSION']['value'] == $row->value){
                                                            if(!$authorisedstatus->course_reg_submitted){ 
                                                                echo "<span class='badge badge-primary p-2'>Course Registration Opened</span>";
                                                            }else{
                                                                if($authorisedstatus->course_reg_approved){ 
                                                                    echo "<span class='badge badge-success p-2'>Course Registration Approved</span>";
                                                                }else{ 
                                                                    echo "<span class='badge badge-info p-2'>LC's Approval Pending</span>";
                                                                }
                                                            }
                                                        }else{
                                                            echo "<span class='badge badge-secondary p-2'>Previous Course Registration</span>";
                                                        }
                                                    ?>
                                                </td>
                                                <td class="text-warning">
													<span>
													    <?php 
													        if($_SESSION['activeSettingsManager']['SESSION']['value'] == $row->value){
													            //var_dump($_SESSION['activeSettingsManager']);
													            if($_SESSION['activeSettingsManager']['ADD_DROP_STATUS']['value'] == "Open"){
													    ?>
                                                            <a href="<?php echo site_url('course/ammend/'.md5(time().rand()).'/'.$row->id)?>"  class="text-info">
                                                                <i class="fa fa-plus-square"></i> Add/Drop 
                                                            </a>
                                                        <?php }else{echo "<span class='badge badge-dark p-2'>Add/Drop Closed</span>";}}else{echo "<span class='badge badge-secondary p-2'>Previous Add/Drop</span>";} ?>
													</span>
												</td>
                                                <td class="text-info">
													<span>
												        <a href="<?php echo site_url('course/print/'.md5(time().rand()).'/'.$row->id)?>" target="_blank">
                                                            <i class="fa fa-print"></i> Print
                                                        </a>
													</span>
												</td>
												
											</tr>
											<?php }  ?>
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
