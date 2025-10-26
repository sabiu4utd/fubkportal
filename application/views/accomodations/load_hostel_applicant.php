<!doctype html>
<?php $opt = "";
    foreach($rooms as $room){
        $opt .="<option value=".$room->id." >".$room->room_name."</option>";
    }
?>
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
        
        .zoom {
            
              transition: transform .2s; /* Animation */
              width: 50px;
              height: 50px;
              margin: 0 auto;
            }

        .zoom:hover {
                 transform: scale(1.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
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
                                <a href="<?php echo site_url('accomodations/index')?>" class="float-right p-4">
                                    <i class="fa fa-arrow-left"></i> Back
                                </a>
                            </div>
                        <br><br>
                      
                       
                        </div>
                        
                         <div class="row">
                            <div class="col-md-12 col-sm-12 pt-4">
                                <div class="table-responsive" style="width:100%">
                                                    <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                                        <thead>
                                                            <tr>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Student Name</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Department</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Level</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Hostel Applied</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Student ID</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Passport</th>
                                                                 <th style="text-align:left; font-weight:bolder; color:#000">Date Reserve</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Decline</th>
                                                                <th style="text-align:left; font-weight:bolder; color:#000">Assign Room</th>
                                                                

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($result as $row) { ?>
                                                               <tr>
                                                                   <td><?php echo strtoupper($row->surname)." ".$row->firstname." ".$row->othername; ?></td>
                                                                   <td><?php echo $row->prog_abbr; ?></td>
                                                                   <td>
                                                                        <?php echo $row->current_level."/";
                                                                            if($row->session_admitted == $this->session->userdata("active_session"))
                                                                               {
                                                                                echo "Fresh Student";
                                                                               } else{
                                                                                   echo "Returning Student";
                                                                               }
                                                                        ?>
                                                                   </td>
                                                                   <td><?php echo $row->hostelname."/".$row->location; ?></td>
                                                                   <td><?php echo $row->pnumber; ?></td>
                                                                   <td>
                                                                      <div class="zoom">
                                                                          <img src="<?php  echo base_url().'passport/'.$row->passport; ?>"   />
                                                                      </div>
                                                                           
                                                                       
                                                                     </td>
                                                                     <td>
                                                                       <?php echo $row->datereserved; ?>  
                                                                     </td>
                                                                   <td>
                                                                   	<!--<a href="<?php echo site_url('accomodations/loadRoom/'.$row->hostelid.'/'.$row->userid) ?>">Allocate Space</a>-->
                                                                   	<a href="<?php echo site_url('accomodations/revoke/'.$row->hostelid.'/'.$row->userid) ?>">Decline</a>
                                                                   </td>
                                                                   <td><a href="#" data-toggle="modal" data-target="#<?php echo 'myModal'.$row->pnumber; ?>">Allocate Bedspace</a></td>
                                                               </tr>
                                                               
                                                               
                                                               
                                                            <!-- Modal -->
                                                            <div id="<?php echo 'myModal'.$row->pnumber; ?>" class="modal fade" role="dialog">
                                                              <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                                                                    <h4 class="modal-title">Reserve Bed Space </h4>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <form method="POST" action="<?php echo site_url('accomodations/reserve_space_for_applicant'); ?> ">
                                                                        <input type="hidden" name="userid" value="<?php echo $row->userid; ?>" >
                                                                        <input type="hidden" name="hostelid" value="<?php echo $row->hostelid; ?>" >
                                                                        <input class="form-control mt-3" type="text" readonly value="<?php echo strtoupper($row->surname)." ".$row->firstname." ".$row->othername; ?>" />
                                                                        <input class="form-control mt-3" type="text" readonly value="<?php echo $row->hostelname."/".$row->location; ?>" />
                                                                        <input class="form-control mt-3" type="text" readonly value="<?php echo $row->prog_abbr; ?>" />
                                                                        <input class="form-control mt-3" type="text" readonly value="<?php echo $row->current_level."Level/"; echo $this->session->userdata("active_session")==$row->session_admitted ? "Fresh":"Returning";?>" />
                                                                        <select class="form-control mt-3" id="room" name="roomid">
                                                                            <option>Choose Room for Student</option>
                                                                            <?php echo $opt; ?>
                                                                        </select>
                                                                        <select name="bedspaceid" id="bedspaces" class="form-control mt-3">
                                                                           <option>Choose Bedspace</option>
                                                                        </select>
                                                                        <br />
                                                                        <input type="submit" value="Reserved" class="btn btn-primary" />
                                                                    </form> 
                                                                    <div id="bedspaces"></div>
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                  </div>
                                                                </div>
                                                            
                                                              </div>
                                                            </div>
                                                               
                                                               
                                                             
                                                             
                                                               
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
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
                $('#room').on('change', function() {
                    var roomid = $(this).val();
                    //alert(roomid);
                    $('#bedspaces').empty()
                    $.ajax({
                        url: "<?php echo site_url('/accomodations/bedspace') ?>",
                        type: "POST",
                        data: {
                            'roomid': roomid,
                           },
                        success: function(data) {
                            //console.log(data)
                            $('#bedspaces').empty().html(data);
                        },
                    });
                });
            </script>
</body>

</html>