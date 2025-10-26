<!doctype html>
<html lang="en" dir="ltr">
<?php //var_dump($hostels); 
    $hostel = "";
  
    foreach ($hostels as $r){
        if($r->total_reserved < $r->total_bedspaces ){
             $hostel .= "<option value=".$r->id.">".$r->hostelname." [".$r->location." ]</option>";
        }
      
    }


?>
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
                            
                            <div class="col-md-12 col-sm-12 pt-4">
                                <a href="<?php echo site_url('staff')?>" class="float-right p-4"><i class="fa fa-arrow-left"></i> Back</a>
                                <div class="card-body">
                                    <h3 class="alert alert-info">Reserve hostel and Wait for allocation of room and bedspace by Admin</h3>
                                    <p class="text-muted m-b-0">
                                        <div class="row">
                                            
                                            <div class="col-md-12">
                                            <form method="POST" action="<?php echo site_url('accomodations/reserve_space'); ?>">
                                                <div class="row">
                                                    <div class="col">
                                                   <select name="hostel" id="hostel" class="form-control" required>
                                                        <option value="" selected disabled>Choose Hostel</option>
                                                        <?php echo $hostel; ?>
                                                   </select>
                                                    </div>
                                                   <div class="col">
                                                      <input type="submit" value="Reserve Bedspace" class="btn btn-primary" >
                                                   <!-- <select name="hostel" id="room" class="form-control">-->
                                                   <!-- <option value="" selected disabled>Choose Room</option>-->
                                                    
                                                   <!--</select>-->
                                                    </div>
                                                </div>
                                                </form> 
                                                <!--<div id="bedspace" class="card mt-5"></div>-->
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
    <script>


    $(document).ready(function() {
        $('#hostel').on('change', function() {
          
            var hostelid = $(this).val();
            $('#bedspace').empty()
            $.ajax({
                url: "<?php echo site_url('/accomodations/rooms') ?>",
                type: "POST",
                data: {
                    'hostelid': hostelid
                },
                success: function(data) {
                    $('#bedspace').empty()
                    $('#room').html(data);
                },
            });
        });
        
        $('#room').on('change', function() {
            var roomid = $(this).val();
            $('#bedspace').empty()
            $.ajax({
                url: "<?php echo site_url('/accomodations/bedspace') ?>",
                type: "POST",
                data: {
                    'roomid': roomid
                },
                success: function(data) {
                    //console.log(data)
                    $('#bedspace').empty().html(data);
                },
            });
        });
    });
</script>
</body>

</html>