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
                            <h1 class="page-title">Payslips</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item"><a href="#">Payslips</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-12">
                            <div class="card">
                                <h6 style="margin:auto; text-decoration:underline">Prepare New Payslips</h6>
                                <form class="card-body" action="<?php echo site_url('payslip/upload')?>" method="post"  enctype="multipart/form-data">
                                    <div class="form-group row">
                                        <label class="col-md-1 col-form-label">Month <span class="text-danger">*</span></label>
                                        <div class="col-md-2">
                                            <select name="month" class="form-control" required>
                                                <option>JANUARY</option>
                                                <option>FEBRUARY</option>
                                                <option>MARCH</option>
                                                <option>APRIL</option>
                                                <option>MAY</option>
                                                <option>JUNE</option>
                                                <option>JULY</option>
                                                <option>AUGUST</option>
                                                <option>SEPTEMBER</option>
                                                <option>OCTOBER</option>
                                                <option>NOVEMBER</option>
                                                <option>DECEMBER</option>
                                            </select>
                                        </div>
                                        <label class="col-md-1 col-form-label">Year <span class="text-danger">*</span></label>
                                        <div class="col-md-2">
                                            <select name="year" class="form-control" required>
                                                <?php for($i = date('Y'); $i >= 2020; $i--){?>
                                                <option><?php echo $i;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label class="col-md-1 col-form-label">Payslip File <span class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="file" class="form-control" name="file" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="submit" name="submit" value="Prepare Payslip" class="form-control btn btn-success block" style="width:100%" />
                                        </div>
                                    </div>
                                </form>
                            </div>
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
												<th>Reference</th>
												<th>Period</th>
												<th>View</th>
												<th>Status</th>
												<th>Notification</th>
												<th>Delete</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; foreach($payslips as $row){ ?>
											<tr>
												<td>
													<?php echo $i++; ?>
												</td>
												<td> 
													<?php echo $row->reference ?> 
												</td>
												<td>
													<?php echo $row->month." ".$row->year; ?> 
												</td>
												<td class="text-primary">
													<span>
													<a href="<?php echo site_url('payslip/slips/'.$row->hash);?>" > <i class="fa fa-eye"></i> View</a>
													</span>
												</td>
												<td>
													<span>
													<?php if($row->status == 1){ ?>
														<a class="text-success"> <i class="fa fa-check-circle"></i> Approved</a>
													<?php } else{ ?>
														<a class="badge badge-info" href="<?php echo site_url('payslip/approvepayslip/'.$row->hash)?>">Click to Approve</a>
													<?php } ?>
													</span>
												</td>
												<td class="text-left">
													<span>
													<?php if($row->status == 1){ ?>
														<a href="<?php echo site_url('payslip/notifyAll/'.$row->hash);?>"><i class="fa fa-envelope"></i> Email All</a>
													<?php } else{ ?>
														<a class="badge badge-danger" style="color:#fff">Not Approved</a>
													<?php } ?>
													</span>
												</td>
												<td class="text-left">
													<span>
													<?php if($row->status == 0){ ?>
														<a class="text-danger" href="<?php echo site_url('payslip/deletepayslip/'.$row->hash); ?>"> <i class="fa fa-trash"></i> Delete</a>
													<?php } else{ ?>
														<a class="badge badge-info" href="<?php echo site_url('payslip/disapprovepayslip/'.$row->hash)?>">Click to Disapprove</a>
													<?php } ?>
													</span>
												</td>
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
