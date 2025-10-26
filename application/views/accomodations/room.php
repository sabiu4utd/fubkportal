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
                                    <div class="card">
                                        <div class="card-body">
                                            <a class="float-right p-4" href="<?php echo site_url('accomodations/hostel/'.$bedspaces[0]->hostel_hash)?>"><i class="fa fa-arrow-left"></i> Go Back</a>
                                            <form action="<?php echo site_url('accomodations/allocate')?>" method="post">
                                            <table class="table">
                                                <tr>
                                                    <th>Hostel</th><td colspan="3"><?php echo $bedspaces[0]->hostelname; ?></td>
                                                    <th>Location</th><td><?php echo $bedspaces[0]->location; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Gender</th><td><?php echo $bedspaces[0]->hostelfor; ?></td>
                                                    <th>Room</th><td><?php echo $bedspaces[0]->room_name; ?></td>
                                                    <th>Status</th>
                                                    <td>
                                                        <span class="badge badge-<?php echo $bedspaces[0]->room_status == 'Reserved' ? 'danger': 'success'; ?>" style="width:150px; font-size:13px">
                                                            <?php echo $bedspaces[0]->room_status ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="text-center" style="font-weight:bolder; color:#000">
                                                        <div class="h2">Assign A Bed Space</div>
                                                        <p style="color:red"><?php echo $this->session->flashdata('msg')?></p>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <th colspan="">Select Bedpace</th><td><?php //var_dump($bedspaces);?>
                                                        <select name="bedspace" class="form-control">
                                                            <option disabled selected>Select Bedspace</option>
                                                            <?php foreach($bedspaces as $row){ 
                                                                echo "<option ".($row->reservation_status=='Reserved' ? 'disabled' : '')." value='".$row->bedspace_id."'>".$row->bedspace."</option>";
                                                            }?>
                                                        </select>
                                                    </td>
                                                    <th>Student PNumber</th>
                                                    <td>
                                                        <input type="text" class="form-control" name="pnumber" required placehoder="Enter the Student admission number" minlength="10" maxlength="10"/>
                                                    </td>
                                                    <td colspan="2">
                                                        <input type="hidden" name="room_hash" value="<?php echo $bedspaces[0]->room_hash?>" />
                                                        <input type="hidden" name="hostel_hash" value="<?php echo $bedspaces[0]->hostel_hash?>" />
                                                        <input type="submit" class="form-control btn btn-primary" value="Allocate Bedspace" />
                                                    </td>
                                                    
                                                </tr>
                                            </table>
                                            </form>   
                                        </div>
                                        <div class="card-body">
                                            <p class="text-muted m-b-0">
                                            <div class="row">
                                                <?php foreach($bedspaces as $row){?>
                                                <div class="col-md-4 card" style="border:1px dotted darkgray">
                                                    <div class="card-body">
                                                        <div class="card-title p-0" style="font-size:17px">
                                                            <?php echo $row->bedspace.'<hr>';
                                                            
                                                            if($row->reservation_id){ ?>
                                                            <div style="border:1px solid gray; min-width:210px; min-height:20px;">
                                                                <img src="<?php echo base_url('passport/'.$row->passport)?>" style=" width:100%;">
                                                            </div>
                                                            
                                                            <table class="table table-stripped">
                                                                <tr><td colspan="2" style="text-align:center"><?php echo strtoupper($row->surname).', '.$row->firstname.' '.$row->othername; ?> </td></tr>
                                                                <tr><th>PNumber</th><td><?php echo $row->pnumber?></td></tr>
                                                                <tr><th>Gender</th><td><?php echo $row->gender ?></td></tr>
                                                                <tr><th>Level</th><td><?php echo $row->current_level. ' Level'; ?></td></tr>
                                                                <tr><th>Hostel</th><td><?php echo $row->hostelname; ?></td></tr>
                                                                <tr><th>Room</th><td><?php echo $row->room_name; ?></td></tr>
                                                                <tr>
                                                                    <td colspan="2" class=" text-danger">
                                                                        <i class="fa fa-recycle"></i> 
                                                                        <a href="<?php echo site_url('accomodations/reallocate/'.$row->hostelid.'/'.$row->roomid.'/'.$row->reservation_id); ?>">Re-allocate</a>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                            <?php }else{
                                                                echo "<div style='width:200px; height:40px' class='alert alert-warning mx-auto text-center'>VACANT</div>";
                                                            } ?>
                                                            
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