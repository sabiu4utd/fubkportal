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
                                <li class="breadcrumb-item"><a href="#">Other Forms</a></li>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select id="form_name" name="form_name" class="form-control" required>
                                                <option selected disabled>Choose a Form</option>
                                                <?php
                                                    foreach($forms as $row){
                                                        echo "<option>".$row->form_name."</option>";
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <input name="form_amount" id="form_amount" class="form-control" required type="number" readonly value="" placeholder="Amount">
                                        </div>
                                        <div class="col-md-3">
                                            <input class="form-control btn btn-primary" name="submit" id="submit" required type="submit" value="Order Form">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h5 class="text-center">Order Forms History</h5>
                                <hr>
                                <div class="card-body">
									<table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
										<thead>
											<tr>
												<th>#</th>
												<th>Type</th>
												<th>Session</th>
												<th>RRR</th>
												<th>Amount</th>
												<th>Status</th>
												<th>Verify</th>
												<th>Print</th>
											</tr>
										</thead>
										<tbody>
											
											
											<?php $i = 1; foreach($myforms as $row){  ?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row->type ?></td>
												<td><?php echo $row->session; ?></td>
												<td>
                                                    <?php 
                                                        $rrr = str_replace("-","",$row->rrr);
                                                        echo substr($rrr, 0, 4)."-".substr($rrr, 4, 4)."-".substr($rrr, 8, 4); 
                                                    ?>
                                                </td>
												<td>&#8358; <?php echo number_format(str_replace(",","",$row->amount), 2, ".", ","); ?></td>
												<td><?php echo ($row->status == "Paid") ? '<i class="fa fa-check-circle text-success"></i> PAID' : '<i class="fa fa-times-circle text-danger"></i> PENDING'; ?></td>
												<td class="text-success">
                                                    <?php if($row->status == "Paid"){
                                                        echo '<a href="'.site_url('#course/ammend/'.md5(time().rand()).'/'.$row->id).'" class="text-info">
                                                            <i class="fa fa-plus-square"></i> Add/drop
                                                        </a>';
                                                    }else{    
                                                    ?>
													<span style="font-weight:bolder">
                                                        <a href="<?php echo site_url('payment/checkPaymentStatus/'.$row->rrr."/".md5(time()))?>">
                                                        <i class="fa fa-search-dollar text-info"></i> Confirm
                                                        </a>
													</span>
                                                    <?php } ?>
												</td>
                                                <td class="text-info">
													<span>
                                                        <a href="https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/<?php echo $rrr;?>/printinvoiceRequest.pdf" target="_blank">
                                                        <i class="fa fa-print"></i> Receipt
                                                        </a>
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


    $(document).ready(function() {
        
        $('#submit').prop('disabled', true);
        
        $('#form_name').on('change', function() {
            var formid = $(this).val();
            $('#form_amount').empty()
            $('#submit').prop('disabled', true);
            $.ajax({
                url: "<?php echo site_url('form/findFormPrice') ?>",
                type: "POST",
                data: {'id': formid},
                success: function(data) {
                    
                    $('#submit').prop('disabled', false);
                    
                    $('#form_amount').val("") ;
                    $('#form_amount').val(data);
                },
            });
        });
        
        $('#submit').on('click', function() {
            var form_name = $('#form_name').val();
            var form_amount = $('#form_amount').val();
            
            $.ajax({
                url: "<?php echo site_url('form/orderForm') ?>",
                type: "POST",
                data: {'form_name': form_name, 'form_amount': form_amount},
                success: function(data) {
                    console.log(data);
                    window.location.reload();
                },
            });
        });
        
        
    });
</script>
  </script> 

</body>

</html>
