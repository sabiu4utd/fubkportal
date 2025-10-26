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
    
     <script src="<?php echo base_url() ?>assets/js/newjs/jquery/jquery.unobtrusive-ajax.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/newjs/jquery/jquery.validate.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/newjs/jquery/jquery.validate.unobtrusive.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/newjs/jquery/jquery-1.6.2.min.js"></script>
    <script src="<?php echo base_url() ?>assets/js/newjs/jquery/jquery-ui.min.js"></script>

    
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
            <?php $this->load->view('incs/pageheader');  ?>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-body">
                            <a href="<?php echo site_url('course/history')?>" style="float:right; "><i class="fa fa-arrow-left text-primary"></i> Back</a>
                            <br>
                            <div class="card-body">
                                <p><h4 style="text-center">Course Registration</h4></p>
                                <?php if(!$authorisedstatus->code_used ) { ?>
                                    <p>Enter the Code received from your level coordinator. This code would have been sent to you via email as well.</p>
                                    <form action="<?php echo site_url('course/verifycode')?>" method="post">
                                        <div class="row">
                                            <div class="col-md-3" >
                                                <input type="text" minlength="8" maxlenght="8" placeholder="Enter your code here" class="form-control" name="code" required />
                                            </div>
                                            <div class="col-md-2" ><input type="submit" class="form-control btn btn-success" value="Confirm Code" /></div>
                                        </div>
                                        
                                    </table>
                                    </form>
                                <?php }else{ ?>
                                <p class="text-muted m-b-0">
                                    <?php if($courseInfo){?>
                                    <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5" style="border: 1px solid gray">
                                        <tr>
                                            <th style="text-align: left; color:black">Level</th><td><?php echo $courseInfo[0]->level; ?></td>
                                            <th style="text-align: left; color:black">Session</th><td><?php echo $courseInfo[0]->session; ?></td>
                                        </tr>
                                        
                                    </table>
                                    <?php } else{ 
                                        echo '<p style="text-align: center" class="alert alert-danger">Course schedule is unavailable. Please contact the MIS</p>';
                                       } ?>
                                    <div class="table-responsive">
                                    <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                        <thead>
                                            <tr>
                                                <th style="text-align: left;">#</th>
                                                <th style="text-align: left;">Course Code</th>
                                                <th style="text-align: left;">Course Title</th>
                                                <th style="text-align: left;">Credit Units</th>
                                                <th style="text-align: left;">Semester</th>
                                                <th style="text-align: left;">Type</th>
                                                <th style="text-align: left;"> Select Course
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <form method="post" action="<?php echo site_url('course/creg'); ?>" name="listForm">
                                            <?php 
                                            
                                            //from carryovers
                                                $i = 1; 
                                                $totalUnits = 0; 
                                                foreach ($carryovers as $row) {  
                                                ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo strtoupper($row->course_code);   ?></td>
                                                    <td><?php echo $row->course_title ?></td>
                                                    <td><?php echo $row->credit_unit; 
                                                        $totalUnits += $row->credit_unit;
                                                    ?></td>
                                                    <td><?php echo ucwords($row->semester) ?></td>
                                                    <td><?php echo ucwords("Carryover") ?></td>
                                                    <td>
                                                        <input type="checkbox" id="cs" name="courses[]" class="checkbox" checked onclick="return false;" value="<?php echo $row->courseid.'-'.$row->credit_unit; ?>" onchange="checkTotal(this)">
                                                    </td>
                                                   
                                                </tr>
                                            <?php } 
                                            //from course schedule
                                            foreach ($courseInfo as $row) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo $row->own_by == "NUC" ? "FUBK_".strtoupper($row->course_code): strtoupper($row->course_code) ?></td>
                                                    <td><?php echo $row->course_title ?></td>
                                                    <td><?php  echo $row->credit_unit; ?></td>
                                                    <td><?php echo ucwords($row->semester) ?></td>
                                                    <td><?php echo ucwords($row->type) ?></td>
                                                    <td>
                                                        <input  type="checkbox" id="cs" name="courses[]" class="checkbox" value="<?php echo $row->courseid.'-'.$row->credit_unit; ?>" onchange="checkTotal(this)">
                                                    </td>
                                                   
                                                </tr>
                                            <?php } ?>
                                                <tr>
                                                    <td colspan="3" style="text-align:right; font-weight:900">Total Credit Units Selected</td>
                                                    <td style="text-align:left; font-weight:900" id="totalUnits"><?php echo $totalUnits?></td>
                                                    <td colspan="3" >&nbsp;</td>
                                                </tr>
                                        </tbody>
                                        
                                        
                                    </table>
                                    <?php if($courseInfo){?>
                                        <input type="submit" id="submit_creg" value="Save"  class="btn btn-primary btn-block" />
                                    <?php }} ?>
                                </form>
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
    
        totalUnits = <?php echo $totalUnits; ?>
        
        function checkAll(){
            let boxStatus = element.checked; //get the check status of the checkbox
        }
        
        function checkTotal(element) {
            let boxStatus = element.checked; //get the check status of the checkbox
            let boxValue = element.value; //get the value of the checkbox
            let boxItems = boxValue.split("-");; //slipt the value
            
            if(boxStatus){
                totalUnits += parseInt(boxItems[1])
            }else{
                totalUnits -= parseInt(boxItems[1])
            }
            
            $("#totalUnits").text(totalUnits)
            
            if(totalUnits > 48){
                alert("Maximum units reached");
                //e.preventDefault();
                $('#submit_creg').prop('disabled', true);
                return
            }else{
                $('#submit_creg').prop('disabled', false);
            }
            
            // document.listForm.total.value = '';
            // var sum = 0;
            // for (i=0;i<document.listForm.cs.length;i++) {
            //   if (document.listForm.cs[i].checked) {
            //       var a = document.listForm.cs[i].value;
            //       var indexOfdash = a.indexOf("-");
            //       var b = a.substring(indexOfdash+1);
            //       //document.write(b); exit;
            //       //var indexOfdash = document.listForm.cs[i].value.indexOf("-");
            //       //var unit = document.listForm.cs[i].value.substring(indexOfdash+1);
            //       sum = sum + parseInt(b);
            //       //sum = sum + parseInt(document.listForm.cs[i].value.substring(indexOfdash + 1);
            //   }
            // }
            // document.listForm.total.value = sum;
            // if (sum >= 1 && sum <= 48) {
            //     $('#submit_creg').prop('disabled', false);
            // } else {
            //     $('#submit_creg').prop('disabled', true);
            // }
        }
    </script>
    
   

   
    </script>
    
     <script src="<?php echo base_url() ?>assets/js/scrollspyNav.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/font-icons/feather/feather.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/sweetalerts/sweetalert2.min.js"></script>
    <script src="<?php echo base_url() ?>assets/plugins/sweetalerts/custom-sweetalert.js"></script>
</body>

</html>