<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['pageTitle']; ?></title>
    <link rel="icon" href="<?php echo base_url() ?>assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url() ?>assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <a class="float-right p-4" href="<?php echo site_url('accomodations')?>"><i class="fa fa-arrow-left"></i> Go Back</a>
                                    
                                            <table class="table">
                                                <tr>
                                                    <th>Hostel Name</th><td><?php echo $hostel[0]->hostelname; ?></td>
                                                    <th>Hostel Code</th><td><?php echo $hostel[0]->hostelcode; ?></td>
                                                    <th>Hostel Gender</th><td><?php echo $hostel[0]->hostelfor; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Hostel Location</th><td><?php echo $hostel[0]->location; ?></td>
                                                    <th>Total Rooms</th><td><?php echo $hostel[0]->total_rooms; ?></td>
                                                    <th>Booked Bedspaces</th><td><?php echo $hostel[0]->total_reserved.' / '.$hostel[0]->total_bedspaces; ?></td>
                                                </tr>
                                            </table>
                                                
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted m-b-0">
                                            <div class="table-responsive">
                                                <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:left; font-weight:bolder; color:#000">#</th>
                                                            <th style="text-align:left; font-weight:bolder; color:#000">Room Name</th>
                                                            <th style="text-align:left; font-weight:bolder; color:#000">Booked Bedspaces</th>
                                                            <th style="text-align:left; font-weight:bolder; color:#000">Status</th>
                                                            <th style="text-align:left; font-weight:bolder; color:#000">Manage</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; foreach ($hostel as $row) {  ?>
                                                            <tr>
                                                                <td><?php echo $i++; ?></td>
                                                                <td><?php echo strtoupper($row->room_name) ?></td>
                                                                <td>
                                                                    <?php 
                                                                        echo $row->total_reserved.' out of '.$row->capacity.' ';
                                                                        echo ($row->total_reserved != $row->capacity) ? '<i class="fa fa-circle-check" style="color:green"></i>' : '<i class="fa fa-circle-xmark" style="color:red"></i>';
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo site_url('accomodations/updateroom/'.$row->hostel_hash.'/'.$row->room_hash.'/'.$row->status)?>">
                                                                    <span class="badge badge-<?php echo $row->status == 'Visible' ? 'success' : 'danger' ?>" style="width:70px; padding-top:3px; padding-bottom-3px">
                                                                        <?php echo $row->status ?>
                                                                    </span>
                                                                    </a>
                                                                </td>
                                                                <td><a href="<?php echo site_url('accomodations/room/'.$row->hostel_hash.'/'.$row->room_hash)?>">View Room</a></td>
                                                                
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
            <?php $this->load->view('incs/footer'); ?>
        </div>
    </div>
    <script src="<?php echo base_url() ?>assets/bundles/lib.vendor.bundle.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/bundles/dataTables.bundle.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/sweetalert/sweetalert.min.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url() ?>assets/js/core.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/page/dialogs.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url() ?>assets/js/table/datatable.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url() ?>assets/js/rocket-loader.min.js" data-cf-settings="60cf6dc1a00fc0dbf92d681a-|49"
        defer=""></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo base_url() ?>assets/js/rocket-loader.min.js" data-cf-settings="e27f9daa9c2f25670b2c3761-|49" defer=""></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js" integrity="sha512-fD9DI5bZwQxOi7MhYWnnNPlvXdp/2Pj3XSTRrFs5FQa4mizyGLnJcN6tuvUS6LbmgN1ut+XGSABKvjN0H6Aoow==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>