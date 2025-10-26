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
                                <li class="breadcrumb-item"><a href="#">Payment Items</a></li>
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
								
								<form method="POST" action="<?php echo site_url('payment/create_item'); ?>">
								    <div class="row">
								        <div class="col-md-2">
    								        <select class="form-control align-middle" name="session" required>
        								        <option disabled>2022/2023</option>
        								        <option selected>2023/2024</option>
        								        <option disabled>2024/2025</option>
        								        <option disabled>2025/2026</option>
        								        <option disabled>2026/2027</option>
        								    </select>
    								    </div>
    								    <div class="col-md-2">
    								         <input type="text" name="item" class="form-control align-middle" required placeholder="Enter Fee Item Name">
    								    </div>
    								    <div class="col-md-2">
    								         <input type="number" name="amount" class="form-control align-middle" required placeholder="Enter Fee Item Amount">
    								    </div>
    								    <div class="col-md-2">
    								         <select class="form-control  align-middle" name="type" required>
        								        <option selected disabled>Type</option>
        								        <option>UG</option>
        								        <option>PG</option>
        								    </select>
    								    </div>
    								   <div class="col-md-3">
    								       <input type="submit" class="btn btn-primary align-middle" value="Create Payment Item" />
    								   </div>
								    </div>
								   
								</form>
								<br><hr>
								</div>
								<div class="card-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>SN</th>
                                        <th>Item</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Session</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                    
                                    <?php $i = 1; $total=0; foreach($result as $r){
                                        $total += $r->amount;
                                    ?>
                                        <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $r->item; ?></td>
                                        <td style=""><?php echo number_format($r->amount, 2, '.', ','); ?></td>
                                        <td><?php echo $r->for; ?></td>
                                        <td><?php echo $r->session; ?></td>
                                        <td><a href="<?php echo site_url('payment/edit_item/'.$r->id)?>"><i class="text-primary fa fa-edit"></i></a></td>
                                        <td><a href="<?php echo site_url('payment/delete_item/'.$r->id)?>"><i class="text-danger fa fa-trash"></i></a></td>
                                            
                                        </tr>
                                      
                                    <?php } ?>
                                    <tr>
                                        <th colspan="2" style="text-align:right">Total Amount</th>
                                        <th style="font-weight:900; color:#000"><?php echo number_format($total, 2, '.', ','); ?></th>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
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
