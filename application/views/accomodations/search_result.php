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
                    <div class="card">
                        <div class="card-body">
                            <div>
                                <a href="<?php echo site_url('staff')?>" class="float-right p-4">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        <br><br>
                      
                        </div>
                        
                         <div class="row">
                            <div class="col-md-3 col-sm-3 pt-4"></div>
                            <div class="col-md-6 col-sm-6 pt-4">
                                <div class="table-responsive" style="width:100%">
                                                    
                                                    <table class="table table-hover">
                                                        <?php  if(!$result){ echo "<h1>No Reservation Record Found</h1>"; } else {?>
                                                        <tbody>
                                                            <tr>
                                                                <td style="font-weight:bold">Full Name:</td>
                                                                <td><?php echo $result->firstname." ".$result->surname." ".$result->othername; ?></td>
                                                            </tr>
                                                             <tr>
                                                                <td style="font-weight:bold">Level:</td>
                                                                <td><?php echo $result->current_level; ?></td>
                                                            </tr>
                                                             <tr>
                                                                <td style="font-weight:bold">Hostel:</td>
                                                                <td><?php echo $result->hostelname; ?></td>
                                                            </tr>
                                                             <tr>
                                                                <td style="font-weight:bold">Room:</td>
                                                                <td><?php echo $result->room_name; ?></td>
                                                            </tr>
                                                             <tr>
                                                                <td style="font-weight:bold">Bedspace:</td>
                                                                <td><?php echo $result->bedspace; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold">Location:</td>
                                                                <td><?php echo $result->location; ?></td>
                                                            </tr>
                                                             <tr>
                                                                <td style="font-weight:bold">Reservation Status:</td>
                                                                <td><?php echo $result->reservation_status; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="font-weight:bold">Session:</td>
                                                                <td><?php echo $result->session; ?></td>
                                                            </tr>
                                                            
                                                           
                                                        </tbody>
                                                        <?php } ?>
                                                    </table>
                                                  
                                                </div>
                                            
                                </div>
                                 <div class="col-md-3 col-sm-3 pt-4"></div>
                            </div>
                              <?php  if(!$result){ } else {?>
                              <!--<a href="<?php echo site_url('accomodations/revoke/'.$result->bedspaceid."/".$result->reservationid); ?>" class="btn btn-danger">Revoke Reservation</a>-->
                                <?php } ?>
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