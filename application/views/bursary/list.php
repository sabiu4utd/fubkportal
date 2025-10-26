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
    </style>


</head>


<body class="font-muli right_tb_toggle <?php echo " " . $_SESSION['theme_mode']; ?>">

    <div id="main_content">
        <?php
        $this->load->view('incs/header');
        $this->load->view('incs/lside');
        ?>
        <div class="page">

            <?php $this->load->view('incs/pageheader'); ?>


            <div class="section-body mt-4 mb-2">
                <div class="container-fluid">
                    <form action="<?php echo site_url('bursary/list');?>" method="post">
                    <div class="row clearfix">
                        <div class="col-md-2 col-sm-6">
                            <select name="session" class="form-control" required>
                                <option selected disabled>Session</option>
                                <?php 
                                foreach($filters["sessions"] as $row){
                                    echo "<option>".$row->session."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <select name="mode" class="form-control" required>
                                <option selected disabled>Entry Mode</option>
                                <!--<option valoe="0">All Entry Modes</option>-->
                                <?php 
                                foreach($filters["mode"] as $row){
                                    echo "<option>".$row."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <select name="type" class="form-control" required>
                                <option selected disabled>Payment Type</option>
                                <!--option value="0">All Payment Types</option-->
                                <?php 
                                foreach($filters["pay_types"] as $row){
                                    echo "<option>".$row->type."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <select name="program" class="form-control" required>
                                <option selected disabled>Programs</option>
                                <!--option valoe="0">All Programs</option-->
                                <?php 
                                foreach($filters["programs"] as $row){
                                    echo "<option value='".$row->id."'>".$row->prog_abbr."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col col-md-2 col-sm-12">
                            <button class="btn btn-success" type="submit" name="submit">Generate Dashboard</button>
                        </div>
                        </form>
                    </div>
                    <hr>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-center">
                                        <?php 
                                            echo  $active_filters['session']." ";
                                            echo ($active_filters['program'] == 0 ? '[All programs]' : '').' list of ';
                                            echo ($active_filters['mode']== 0  ? "[All Modes] " : '['.$active_filters['mode'].'] ');
                                            echo ($active_filters['type']== 0 ? "[All Payment types]" : '['.$active_filters['type'].'] ').' payments'; 
                                        ?>
                                    </h5>
                                    <hr>
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Admission No</th>
                                                    <th>Full Name</th>
                                                    <th>Type</th>
                                                    <th>Session</th>
                                                    <th>Amount</th>
                                                    <th>RRR</th>
                                                    <th>Program</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; foreach ($payments as $row) { ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $row->pnumber; ?></td>
                                                        <td><?php echo strtoupper($row->fullname); ?></td>
                                                        <td><?php echo $row->type; ?></td>
                                                        <td><?php echo $row->session; ?></td>
                                                        <td><?php echo is_numeric($row->amount) ? number_format($row->amount,2,'.',','): $row->amount; ?></td>
                                                        <td><?php 
                                                            $rrr = str_replace("-", "", $row->rrr);
                                                            $original_rrr = isset($row->original_rrr) ? str_replace("-", "", $row->original_rrr): null;
                                                            if(strlen($rrr) == 12){
                                                                echo substr($rrr, 0, 4)."-".substr($rrr, 4, 4)."-".substr($rrr, 8). " ";
                                                                //echo $row->payment_status == "Paid" ? "<i class='text-success fa fa-check'></i>" :  "<i class='text-danger fa fa-times'></i>"; 
                                                                echo ( $rrr == $original_rrr) ? "" :  
                                                                    " <i class='text-danger fa fa-info' data-toggle='tooltip' data-placement='right' title='".substr($row->original_rrr, 0, 4)."-".substr($row->original_rrr, 4, 4)."-".substr($row->original_rrr, 8)."'></i>"; 
                                                            }else{
                                                                echo "No RRR Found";
                                                            }
                                                        ?></td>
                                                        <td><?php echo $row->prog_abbr; ?></td>
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
    <script>
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</body>

</html>