<!doctype html>
<html lang="en" dir="ltr">
<?php //var_dump($current_reservation); exit; ?>
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

        .num {
            font-size: 28px;
            font-weight: bolder;
            text-align: center;
        }

        .per {
            font-size: 18px;
            font-weight: bolder;
            text-align: center;
        }

        span b {
            text-transform: uppercase;
        }
        thead th, tfoot th{
            text-align: right;
        }
    </style>
</head>

<body class="font-muli right_tb_toggle <?php echo " " . $_SESSION['theme_mode']; ?>">
    <div id="main_content">
        <?php
        $this->load->view('incs/header');
        $this->load->view('incs/lside');
        ?>
        <div class="page">
            
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="card">
                        <div class="row">
                               
                           <div class="card-body">
                            <div class="col-md-12 col-sm-12 pt-4">
                                
                                <div class="card-body">
                                    <p class="text-muted m-b-0">
                                        <div class="row">
                                           
                                            <div class="col-md-12">
                                                <div class="table-responsive">
                                                    <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                                      
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Session</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Hostel Name</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Room Name</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Bedspace</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Reservation?</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Paid?</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Manage</th>
                                                               
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                           
                                                           
                                                            
                                                                if($current_reservation && $current_reservation->reservation_status != "Approved") { 
                                                                    echo '<tr> <td colspan="8" class="alert alert-danger text-center">Reservation status will be updated within 48 hours...</td></tr>';
                                                                } else {
                                                                $i = 1;
                                                                if(!$current_reservation) {?>
                                                                    <tr>
                                                                        <td><?php echo $_SESSION['active_session'] ?></td>
                                                                        <td>No Reservation</td>
                                                                        <td>No Reservation</td>
                                                                        <td>No Reservation</td>
                                                                        <td>No Reservation</td>
                                                                        <td>No Reservation</td>
                                                                        <td>
                                                                           
                                                                            <a href="<?php echo site_url('accomodations/reserve_bedspace'); ?>"> 
                                                                            <i class="fa fa-bed"></i> Reserve Bedspace </a>
                                                                         
                                                                        <td>
                                                                        
                                                                    </tr>
                                                                

                                                            <?php }  foreach ($myreservation as $row) { ?>
                                                                <tr>
                                                                    <td><?php echo $row->session; ?></td>
                                                                    <td><?php echo $row->hostelname; ?></td>
                                                                    <td><?php echo $row->room_name; ?></td>
                                                                    <td><?php echo $row->bedspace; ?></td>
                                                                    <td><?php echo $row->reservation_status; ?></td>
                                                                    <td> <?php  
                                                                        if($row->reservation_status == "Pending"){
                                                                            echo "<span class='badge badge-danger'>Reservation Pending</span>";
                                                                        }else{
                                                                            if($row->session == $_SESSION['active_session']){
                                                                                if(!$accomodation_payment){ 
                                                                                    echo '<a href="'.site_url('accomodations/gen_acco_invoice').'"> <i class="fa fa-search-dollar text-info"></i> Generate Remita</a>';
                                                                                }elseif($accomodation_payment && $accomodation_payment->status == "Pending"){ 
                                                                                    echo '<a href="'.site_url('accomodations/confirm/'.$accomodation_payment->orderid).'"> <i class="fa fa-search-dollar text-info"></i> Confirm Payment</a>';
                                                                                }else {
                                                                                    echo '<a target="_blank" href="https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/'.$accomodation_payment->rrr.'/printinvoiceRequest.pdf"> <i class="fa fa-print"></i> Print Receipt</a>';
                                                                                }
                                                                            }else{
                                                                                echo "Completed";
                                                                            }
                                                                            
                                                                        } ?>
                                                                    </td>
                                                                    <td> <?php 
                                                                        if($row->reservation_status == "Pending"){
                                                                            echo "<span class='badge badge-danger'>Reservation Pending</span>";
                                                                        }else{
                                                                            if($row->session == $_SESSION['active_session']){
                                                                                if(!$accomodation_payment){ 
                                                                                    echo 'Unpaid';
                                                                                }elseif($accomodation_payment && $accomodation_payment->status == "Pending"){ 
                                                                                    if($accomodation_payment->rrr){ 
                                                                                        echo '<a target="_blank" href="https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/'.$accomodation_payment->rrr.'/printinvoiceRequest.pdf"> <i class="fa fa-print"></i> Print Receipt</a>';
                                                                                    } else{ echo 'Unpaid';}
                                                                                }else {
                                                                                    echo '<a target="_blank" href="'.site_url('accomodations/clearance/'.$accomodation_payment->rrr).'"> <i class="fa fa-print"></i> Print Docs</a>';
                                                                                }
                                                                            }else{
                                                                                echo "Completed";
                                                                            }
                                                                            
                                                                        } ?>
                                                                    </td>
                                                                </tr>
                                                            <?php }} ?>
                                                            
                                                                
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </p>
                                           
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
</body>

</html>