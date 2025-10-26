<!doctype html>
<html lang="en" dir="ltr">
<?php //var_dump($schedule); ?>
<?php 
$prg = "";
foreach($result as $r){
   $prg .="<option value=".$r->id." >".$r->prog_abbr." </option>"; 
} ?>
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
                                <li class="breadcrumb-item"><a href="#">Payment Schedule</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Library-all">
                            
                                <a href="<?php echo site_url('payment/create_item');?>" class="float-right p-4"> <i class="fa fa-plus"></i>Create Fee Item</a> | 
                                <a href="<?php echo site_url('payment/create_schedule');?>" class="float-right p-4"> <i class="fa fa-plus"></i>Create Schedule</a>
                            <div class="card">
                                <div class="card-body">
								
								<form method="POST" action="<?php echo site_url('payment/schedule'); ?>">
								    <div class="row">
								        <div class="col-md-2">
    								        <select class="form-control mt-3" name="session" required>
        								        <option disable>2022/2023</option>
        								        <option disable>2023/2024</option>
        								        <option selected>2024/2025</option>
        								        <option disabled>2025/2026</option>
        								        <option disabled>2026/2027</option>
        								    </select>
    								    </div>
    								    <div class="col-md-2">
    								         <select class="form-control mt-3" name="programid" required>
        								        <option>Program</option>
        								        <?php echo $prg; ?>
        								    </select>
    								    </div>
    								    <div class="col-md-3">
    								         <select class="form-control mt-3" name="type" required>
        								        <option selected disabled>Type</option>
        								        <option>DE</option>
        								        <option>PG</option>
        								        <option>UTME</option>
        								    </select>
    								    </div>
    								    <div class="col-md-2">
    								        <select class="form-control mt-3" name="level">
        								        <option selected disabled>Level</option>
        								        <option>100</option>
        								        <option>200</option>
        								        <option>300</option>
        								        <option>400</option>
        								        <option>410</option>
        								        <option>420</option>
        								        <option>500</option>
        								        <option>510</option>
        								        <option>520</option> 
        								        <option>600</option>
        								        <option>700</option>
        								        <option>710</option>
        								        <option>800</option>
        								        <option>810</option>
        								        <option>900</option>
        								        <option>910</option>
        								    </select>
    								    </div>
    								   <div class="col-md-3 mx-auto">
    								       <input type="submit" class="btn btn-primary form-control" value="Load Payment Schedule" />
    								   </div>
								    </div>
								   
								</form></div>
								<br><hr>
								<?php if(isset($info) and isset($program)){?>
								<h3 class="text-center"><?php echo $program->program.' payment schedule for '.$info["session"].' '.($schedule[0]->type??'').' '.($schedule[0]->level??'').' Level'; ?></h3>
								
								<div class="card-body">
                                <table class="table table-hover">
                                    <tr>
                                        <th>SN</th>
                                        <th>Items</th>
                                        <th>Amount</th>
                                        <th>Level</th>
                                        <th>Type</th>
                                        <th>Session</th>
                                        <th>Edit</th>
                                    </tr>
                                    
                                    <?php $i = 1; $total=0; foreach($schedule as $r){ $total = $total+$r->amount; ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $r->item; ?></td>
                                            <td style=""><?php echo number_format($r->amount, 2, '.', ','); ?></td>
                                            <td><?php echo $r->level; ?></td>
                                            <td><?php echo $r->type; ?></td>
                                            <td><?php echo $r->session; ?></td>
                                            <td><a href="<?php echo site_url('payment/edititem/'.$r->id); ?>"><i class='fa fa-edit'></i> Edit</a></td>
                                        </tr>
                                      
                                    <?php } ?>
                                    <tr>
                                        <th colspan="2" style="text-align:right">Total Amount</th>
                                        <th style="font-weight:900; color:#000"><?php echo number_format($total, 2, '.', ','); ?></th>
                                        <td colspan="3">&nbsp;</td>
                                    </tr>
                                </table>

                                </div>
                                <?php } ?>
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
