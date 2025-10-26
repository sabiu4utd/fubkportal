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
                                                    <p class="text-muted m-b-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
                                                            <thead>
                                                                <tr>
                                                                    <td colspan="3" style="text-align:left"><a href="<?php echo site_url('sbs/viewall/3')?>" class="btn btn-info">All Applicants</a></td>
                                                                    <td colspan="3" style="text-align:left"><a href="<?php echo site_url('sbs/viewall/1')?>" class="btn btn-success">Admitted Applicant</a></td>
                                                                    <td colspan="3" style="text-align:center"><a href="<?php echo site_url('sbs/viewall/0')?>" class="btn btn-primary">Unadmitted Applicant</a></td>
                                                                    <td colspan="3" style="text-align:right"><a href="<?php echo site_url('sbs/viewall/2')?>" class="btn btn-danger">Rejected Applicant</a></td>
                                                                    
                                                                </tr>
                                                                
                                                                
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                    
                                                                    $i = 1; 
                                                                    $filter = "ALL";
                                                                    if($this->uri->segment(3) == 0) $filter = "UNADMITTED";
                                                                    if($this->uri->segment(3) == 1) $filter = "ADMITTED";
                                                                    if($this->uri->segment(3) == 2) $filter = "REJECTED";
                                                                ?>
                                                                <tr> <th colspan="12"><hr></th></tr>
                                                                <tr> <th colspan="12" class="text-center h2"><h2>List of <?php echo $filter; ?> Applicants</h2></th></tr>
                                                                <?php //if ($this->session->flashdata('msg')){ ?>
                                                                <tr> <th colspan="12" class="text-center alert alert-info"><?php echo $this->session->flashdata('msg'); ?></th></tr>
                                                                <?php //} ?>
                                                                <tr>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">#</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Fullame</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Origin</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Sex</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Program</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Paid?</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Olevels</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Admission?</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Admit</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Reject</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Cancel</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Manage</th>
                                                                   
                                                                </tr>
                                                                </tr>
                                                                <?php
                                                                if(isset($applicants)){ 
                                                                    
                                                                    foreach ($applicants as $row) { ?>
                                                                    <tr>
                                                                        <td><?php  echo $i++; ?></td>
                                                                        <td><?php echo trim(strtoupper($row->fullname)) ?></td>
                                                                        <td><?php echo $row->state_name != 'Unassigned' ? ($row->state_name.'/'.$row->lga_name) : 'NA'; ?></td>
                                                                        <td><?php echo $row->gender == "Male"? "M":"F"; ?></td>
                                                                        <td><?php 
                                                                            if($row->prog_abbr == "SBS Science"){
                                                                                echo "SCIE";
                                                                            }else if($row->prog_abbr == "SBS Arts"){
                                                                                echo "ARTS";
                                                                            }else{
                                                                                echo "ENVI";
                                                                            }
                                                                        ?></td>
                                                                        <td><?php echo $row->rrr;  ?></td>
                                                                        <td><?php echo ucwords($row->subject) ?></td>
                                                                        <td><?php
                                                                            
                                                                            if($row->admission_status == "pending"){
                                                                                echo "<i class='fa fa-circle text-info'></i>";        
                                                                            }elseif($row->admission_status == "admitted"){
                                                                                echo "<i class='fa fa-circle text-success'></i>";        
                                                                            }if($row->admission_status == "rejected"){
                                                                                echo "<i class='fa fa-circle text-danger'></i>";        
                                                                            }
                                                                            echo " ".$row->admission_status;
                                                                        ?></td>
                                                                        <td><a href="<?php echo site_url('sbs/process/'.$row->order_hash.'/1/'.$this->uri->segment(3))?>">Admit <i class="fa fa-check text-green"></i></a></td>
                                                                        <td><a href="<?php echo site_url('sbs/process/'.$row->order_hash.'/2/'.$this->uri->segment(3))?>">Reject <i class="fa fa-times text-red"></i></a></td>
                                                                        <td><a href="<?php echo site_url('sbs/process/'.$row->order_hash.'/3/'.$this->uri->segment(3))?>">Cancel <i class="fa fa-rotate-right text-info"></i></a></td>
                                                                         <td><a href="<?php echo site_url('sbs/view/'.$row->order_hash)?>" target="_blank">View <i class="fa fa-eye text-info"></i></a></td>
                                                                        
                                                                    </tr>
                                                                <?php }}else{ echo "<tr><td colspan='12' class='h3 text-center'> No Applicant matching ".$filter." found</td></tr>";} ?>
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
</body>

</html>