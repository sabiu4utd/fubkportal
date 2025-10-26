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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-12">
                                    <h3 class="card text-center">Pending Reservation of <?php echo $pendings[0]->hostelname." - [".$pendings[0]->hostelfor."] - ".$pendings[0]->location ?></h3>
                                    <?php if($this->session->flashdata('msg')){
                                     echo '<p class="alert alert-success">'.$this->session->flashdata('msg') .'</p>';
                                    } ?>
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="text-muted m-b-0">
                                            <div class="row">
                                                <?php foreach($pendings as $row){ ?>
                                                <div class="col-md-4 card" style="border:1px dotted darkgray">
                                                    <div class="card-body">
                                                        <div class="card-title p-0" style="font-size:17px">
                                                            <?php echo strtoupper($row->surname).' '.$row->firstname.' '.$row->othername; ?>   
                                                            <hr>
                                                            <div style="border:1px solid gray; min-width:210px; min-height:20px;">
                                                                <?php //var_dump($row->DATERESERVED);echo $row->datereserved;?>
                                                            <img src="<?php echo base_url('passport/'.$row->passport)?>" style=" width:100%;">
                                                            </div>
                                                            <table class="table table-stripped">
                                                                <tr><th>PNumber</th><td><?php echo $row->pnumber?></td></tr> 
                                                                <tr><th>Gender</th><td><?php echo $row->gender ?></td></tr>
                                                                </tr><th>Level</th><td><?php echo $row->current_level. ' Level'; ?></td></tr>
                                                                </tr><th>Hostel</th><td><?php echo $row->hostelname; ?></td></tr>
                                                                </tr><th>Room</th><td><?php echo $row->room_name; ?></td></tr>
                                                                </tr><th>Bed</th><td><?php echo $row->bedspace; ?></td></tr>
                                                                </tr><th>Date Reserved</th><td><?php echo $row->datereserved ? date('m-d-Y H:i:s', $row->datereserved) : ''; ?></td></tr>
                                                                <tr>
                                                                    <td><a href="<?php echo site_url('accomodations/priorityapproval/1/'.$row->reservation_id)?>" class="badge badge-success p-2 text-white float-left">Approve <i class="fa fa-check"></i></a></td>
                                                                    <td><a href="<?php echo site_url('accomodations/priorityapproval/0/'.$row->reservation_id)?>" class="badge badge-danger p-2 text-white float-right">Reject <i class="fa fa-times"></i></a></td>
                                                                </tr>
                                                            </table>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
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
</body>

</html>