<!doctype html>
<?php 
 $opt="";
foreach($program as $p){
    $opt .="<option value=".$p->id." >".$p->prog_abbr." [".$p->id."]</option>";
   }
								            

?>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['pageTitle']; ?></title>

    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/x-icon" />


    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet"
        href="<?php echo base_url()?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url()?>assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
    <link rel="stylesheet"
        href="<?php echo base_url()?>assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">

    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
        
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    

</head>

<body class="font-muli right_tb_toggle <?php echo " ".$_SESSION['theme_mode']; ?>">

    <div class="page-loader-wrapper">
        <div class="loader">
        </div>
    </div>
    <div id="main_content">
        <?php 
            $this->load->view('incs/header');
            $this->load->view('incs/lside');
        ?>

        <div class="page">

            <?php $this->load->view('incs/pageheader');?>

            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action">
                            <h1 class="page-title">Payments</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item"><a href="#">Course Schedule</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Library-all">
                            
                                <a href="<?php echo site_url('payment/schedule');?>" class="float-right p-4"> <i class="fa fa-arrow-left"></i> View Schedule</a>
                            <div class="card">
                                <div class="card-body">
								
								<!--<form method="POST" action="<?php echo site_url('payment/create_schedule'); ?>">-->
								<!--    <div class="row">-->
								<!--        <div class="col-md-2">-->
    				<!--				        <select class="form-control" name="session" required>-->
        <!--								        <option selected disabled>Session</option>-->
        <!--								        <option>2022/2023</option>-->
        <!--								        <option>2023/2024</option>-->
        <!--								        <option>2024/2025</option>-->
        <!--								        <option>2025/2026</option>-->
        <!--								        <option>2026/2027</option>-->
        <!--								    </select>-->
    				<!--				    </div>-->
    				<!--				    <div class="col-md-2">-->
    				<!--				         <select class="form-control" name="programid" required>-->
        <!--								        <option>Program</option>-->
        <!--								      
        <!--								    </select>-->
    				<!--				    </div>-->
    				<!--				    <div class="col-md-3">-->
    				<!--				         <select class="form-control" name="type" required>-->
        <!--								        <option selected disabled>Type</option>-->
        <!--								        <option>DE</option>-->
        <!--								        <option>PG</option>-->
        <!--								        <option>UTME</option>-->
        <!--								    </select>-->
    				<!--				    </div>-->
    				<!--				    <div class="col-md-2">-->
    				<!--				        <select class="form-control" name="level" required>-->
        <!--								        <option selected disabled>Level</option>-->
        <!--								        <option>100</option>-->
        <!--								        <option>200</option>-->
        <!--								        <option>300</option>-->
        <!--								        <option>400</option>-->
        <!--								        <option>410</option>-->
        <!--								        <option>420</option>-->
        <!--								        <option>500</option> -->
        <!--								        <option>510</option> -->
        <!--								        <option>520</option> -->
        <!--								        <option>600</option>-->
        <!--								        <option>700</option>-->
        <!--								        <option>800</option>-->
        <!--								        <option>900</option>-->
        <!--								    </select>-->
    				<!--				    </div>-->
    				<!--				   <div class="col-md-3">-->
    				<!--				       <input type="submit" class="btn btn-primary" value="Load Fee Items" />-->
    				<!--				   </div>-->
								<!--    </div>-->
								   
								<!--</form>-->
								<br><hr>
								</div>
							
								<div class="card-body">
								    <h3 class="text-center">
								        Create schedule for <?php //echo $program->prog_abbr. ' in '.$session; ?>
								        <span class="float-right totalUnits"></span>
								    </h3>
								    <hr>
								    <form method="post" action="<?php echo site_url('course/save_course_Schedule')?>">
								         <select class="form-control" name="programid">
								            <?php echo $opt; ?>
								         </select>
                                    <table class="table table-hover">
                                        <tr>
                                            <th>#</th>
                                            <th>Course Code</th>
                                            <th>Course Title</th>
                                            <th>Credit Unit</th>
                                            <th>Session</th>
                                            <th>Choose</th>
                                        </tr>
                                        
                                        <?php $i = 1; $total=0; foreach($result as $r){  ?>
                                            <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo $r->own_by=='nuc'? "FUBK_".$r->course_code : $r->course_code; ?></td>
                                            <td><?php echo $r->course_title; ?></td>
                                            <td><?php echo $r->credit_unit; ?></td>
                                            <td><?php echo $r->session; ?></td>
                                            <td><input  type="checkbox" name="ids[]" value="<?php echo $r->id."-".$r->course_code; ?>" class="form-control " /></td>
                                                
                                            </tr>
                                          
                                        <?php } ?>
                                        <tr>
                                            <th colspan="2" style="text-align:right">Total Amount</th>
                                            <th style="font-weight:900; color:#000" class="totalUnits" id="totalUnits"></th>
                                            <td colspan="4">
                                                <input type="submit" class="form-control btn btn-success" value="Save Schedule"/>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                                </div>
                              
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <?php $this->load->view('incs/footer');?>
        </div>
    </div>
    
   
    <script src="<?php echo base_url()?>assets/bundles/lib.vendor.bundle.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>

    <script src="<?php echo base_url()?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/bundles/dataTables.bundle.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/plugins/sweetalert/sweetalert.min.js"
        type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>

    <script src="<?php echo base_url()?>assets/js/core.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/js/page/dialogs.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url()?>assets/js/table/datatable.js" type="60cf6dc1a00fc0dbf92d681a-text/javascript">
    </script>
    <script src="<?php echo base_url()?>assets/js/rocket-loader.min.js" data-cf-settings="60cf6dc1a00fc0dbf92d681a-|49"
        defer=""></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
    totalUnits = 0
        
    function checkTotal(element) {
        let boxStatus = element.checked; //get the check status of the checkbox
        let boxValue = element.value; //get the value of the checkbox
        let boxItems = boxValue.split("-"); //slipt the value
        
        if(boxStatus){
            totalUnits += parseInt(boxItems[1])
        }else{
            totalUnits -= parseInt(boxItems[1])
        }
        
        document.querySelectorAll(".totalUnits").forEach(function(el) {
            el.innerText = totalUnits.toFixed(2);
        });
    }
    
  </script> 

</body>

</html>
