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
                                <div class="col-md-9 col-sm-12 mx-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <a class="float-right p-4" href="<?php echo site_url('accomodations/room/'.$reservation->hostelid.'/'.$reservation->roomid)?>"><i class="fa fa-arrow-left"></i> Go Back</a>
                                            <form action="<?php echo site_url('accomodations/updateallocation')?>" method="post">
                                            <table class="table table-stripped">
                                                <tr>
                                                    <th class="h3" colspan="2">
                                                        <h2 class="text-center" style="color:black">RE-ALLOCATE BEDSPACE</h2>
                                                        <p style="color:red"><?php echo $this->session->flashdata('msg')?></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Student Name</th><td><?php echo $reservation->surname. ", ".$reservation->firstname. " ".$reservation->othername; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Student ID</th><td><?php echo $reservation->pnumber; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Gender</th><td><?php echo $reservation->gender; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Programme</th><td><?php echo $reservation->prog_abbr; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Current Hostel</th><td><?php echo $reservation->hostelname; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Current Room</th><td><?php echo $reservation->room_name; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Current Bedspace</th><td><?php echo $reservation->bedspace; ?></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="6" class="text-center" style="font-weight:bolder; color:#000">
                                                        <div class="h4">Reallocate Bed Space</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>New Hostel</th>
                                                    <td>
                                                        <select name="hostelname" id="hostelname" class="form-control">
                                                            <?php foreach($hostels as $row) {
                                                                echo '<option value="'.$row->id.'">'.$row->hostelname.'</option>';
                                                            } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>New Room</th>
                                                    <td>
                                                        <select name="room" id="room" class="form-control">
                                                            <option></option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>New Bedspace</th>
                                                    <td>
                                                        <select name="bedspace" id="bedspace" class="form-control">
                                                            <option></option>
                                                        </select>
                                                    </td>
                                                </tr>
                                               <input type="hidden" name="reservation_id" value="<?php echo $reservation->reservation_id; ?>">
                                                <input type="hidden" name="oldbedspaceid" value="<?php echo $reservation->bedspaceid; ?>">
                                                <tr>
                                                    <th>
                                                        <a class="float-left p-2" href="<?php echo site_url('accomodations/room/'.$reservation->hostelid.'/'.$reservation->roomid)?>"><i class="fa fa-arrow-left"></i> Go Back</a>
                                                    </th>
                                                    <th>
                                                        <button type="submit" class="btn btn-warning p-2" style="display:block; ">Reallocate Room</button>
                                                    </th>
                                                </tr>
                                            </table>
                                            </form>   
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
    <script src="<?php echo base_url() ?>assets/bundles/lib.vendor.bundle.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/bundles/dataTables.bundle.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/plugins/sweetalert/sweetalert.min.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"> </script>
    <script src="<?php echo base_url() ?>assets/js/core.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url() ?>assets/js/page/dialogs.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"> </script>
    <script src="<?php echo base_url() ?>assets/js/table/datatable.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"> </script>
    <script src="<?php echo base_url() ?>assets/js/rocket-loader.min.js" data-cf-settings="60cf6dc1a00fc0dbf92d681a-|49" defer=""></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo base_url() ?>assets/js/rocket-loader.min.js" data-cf-settings="e27f9daa9c2f25670b2c3761-|49" defer=""></script>
    <script>
        $(document).ready(function() {
            $('#hostelname').on('change', function() {
              
                var hostelid = $(this).val();
                $('#bedspace').empty()
                $.ajax({
                    url: "<?php echo site_url('/accomodations/getrooms') ?>",
                    type: "POST",
                    data: {
                        'hostelid': hostelid
                    },
                    success: function(data) {
                        console.log(data)
                        $('#bedspace').empty()
                        $('#room').html(data);
                    },
                });
            });
            
            $('#room').on('change', function() {
                var roomid = $(this).val();
                $('#bedspace').empty()
                $.ajax({
                    url: "<?php echo site_url('/accomodations/getbedspace') ?>",
                    type: "POST",
                    data: {
                        'roomid': roomid
                    },
                    success: function(data) {
                        console.log(data)
                        $('#bedspace').empty().html(data);
                    },
                });
            });
        });
    </script>
</body>

</html>