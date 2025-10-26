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
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css"/>
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
                                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5" id="myTable">
                                                            <thead>
                                                                 <?php 
                                                                    $i = 1; 
                                                                    $prog = $this->uri->segment(4, 22);
                                                                    $program = "Part-Time";
                                                                    if($this->uri->segment(4) == 198) $program = "Cert. in Artificial Intelligence/Machine Learning";
                                                                    if($this->uri->segment(4) == 197) $program = "Cert. in Data Analysis & Visualization";
                                                                    if($this->uri->segment(4) == 196) $program = "Cert. in Product Management";
                                                                    if($this->uri->segment(4) == 193) $program = "Cert. in Security Studies";
                                                                    if($this->uri->segment(4) == 194) $program = "Cert. in Software Development";
                                                                    if($this->uri->segment(4) == 195) $program = "Cert. in Cyber Security";
                                                                    if($this->uri->segment(4) == 173) $program = "Diploma in Applied Biology";
                                                                    if($this->uri->segment(4) == 175) $program = "Diploma in Mass Communication";
                                                                    if($this->uri->segment(4) == 192) $program = "Dip. in Statistics";
                                                                    if($this->uri->segment(4) == 190) $program = "Dip. in Biotechnology";
                                                                    if($this->uri->segment(4) == 172) $program = "Diploma in Environmental Biology";
                                                                    if($this->uri->segment(4) == 171) $program = "Diploma in Criminology and Security Studies";
                                                                    if($this->uri->segment(4) == 160) $program = "B.Sc. Sociology";
                                                                    if($this->uri->segment(4) == 161) $program = "B.Sc. Political Science";
                                                                    if($this->uri->segment(4) == 162) $program = "B.A. History and International Studies";
                                                                    if($this->uri->segment(4) == 163) $program = "B.Sc. Geography";
                                                                    if($this->uri->segment(4) == 164) $program = "B.A. English Language";
                                                                    if($this->uri->segment(4) == 165) $program = "B.Sc. Economics";
                                                                    if($this->uri->segment(4) == 167) $program = "B.Sc. Business Administration";
                                                                    if($this->uri->segment(4) == 168) $program = "B.Sc. Computer Science";
                                                                    if($this->uri->segment(4) == 159) $program = "B.Sc. Accounting";
                                                                    //if($this->uri->segment(4) == 193) $program = "Cert. in Security Studies";
                                                                                      
                                                                    
                                                                    $filter = "ALL";
                                                                    if($this->uri->segment(5) == 0) $filter = "UNADMITTED";
                                                                    if($this->uri->segment(5) == 1) $filter = "ADMITTED";
                                                                    if($this->uri->segment(5) == 2) $filter = "REJECTED";
                                                                ?>
                                                                <tr> <th colspan="13" class="text-center" style="color:#000"><h3>List of <?php echo '<b>'.$filter.'</b> Applicants for <b style=color:red>'.$program ?></b></h3></th></tr>
                                                                <tr>
                                                                    <td colspan="1" style="text-align:left"><a href="<?php echo site_url('sbsmanager/index/'.md5(rand()))?>" ><i class="fa fa-arrow-left"></i></a></td>
                                                                    <td colspan="3" style="text-align:center"><a href="<?php echo site_url('sbsmanager/view/'.md5(rand()).'/'.$prog.'/3')?>" class="badge badge-info badge-sm p-1">All Applicants</a></td>
                                                                    <td colspan="3" style="text-align:left"><a href="<?php echo site_url('sbsmanager/view/'.md5(rand()).'/'.$prog.'/1')?>" class="badge badge-success badge-sm p-1">Admitted Applicant</a></td>
                                                                    <td colspan="3" style="text-align:center"><a href="<?php echo site_url('sbsmanager/view/'.md5(rand()).'/'.$prog.'/0')?>" class="badge badge-primary badge-sm p-1">Unadmitted Applicant</a></td>
                                                                    <td colspan="3" style="text-align:right"><a href="<?php echo site_url('sbsmanager/view/'.md5(rand()).'/'.$prog.'/2')?>" class="badge badge-danger badge-sm p-1">Rejected Applicant</a></td>
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                               
                                                                <?php if ($this->session->flashdata('msg')){ ?>
                                                                <tr> <th colspan="13" class="text-center alert alert-info"><?php echo $this->session->flashdata('msg'); ?></th></tr>
                                                                <?php } ?>
                                                                <tr>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">#</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">App No</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Fullame</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Origin</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Sex</th>
                                                                    <!--<th style="text-align:left; font-weight:bolder; color:#000">Program</th>-->
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">RRR</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Olevels</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Admission?</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Admit</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Reject</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">Cancel</th>
                                                                    <th style="text-align:left; font-weight:bolder; color:#000">View</th>
                                                                   
                                                                </tr>
                                                                </tr>
                                                                <?php
                                                                if(isset($applicants)){ 
                                                                    
                                                                    foreach ($applicants as $row) { ?>
                                                                    <tr>
                                                                        <td><?php  echo $i++; ?></td>
                                                                        <td><?php echo $row->applicant_id ?></td>
                                                                        <td><?php echo trim(strtoupper($row->fullname)) ?></td>
                                                                        <td><?php echo $row->state_name != 'Unassigned' ? ($row->state_name.'<br>'.$row->lga_name) : 'NA'; ?></td>
                                                                        <td><?php echo $row->gender == "Male"? "M":"F"; ?></td>
                                                                        <td><?php echo $row->rrr;  ?></td>
                                                                        <td><?php echo ucwords($row->subject) ?></td>
                                                                        <td><? 
                                                                            
                                                                            if($row->admission_status == "pending"){
                                                                                echo "<i class='fa fa-circle text-info'></i>";        
                                                                            }elseif($row->admission_status == "admitted"){
                                                                                echo "<i class='fa fa-circle text-success'></i>";        
                                                                            }if($row->admission_status == "rejected"){
                                                                                echo "<i class='fa fa-circle text-danger'></i>";        
                                                                            }
                                                                            echo " ".$row->admission_status;
                                                                        ?></td>
                                                                        <td><a href="<?php echo site_url('sbsmanager/process/'.$row->order_hash.'/1/'.$this->uri->segment(3))?>"><i class="fa fa-check text-green"></i></a></td>
                                                                        <td><a href="<?php echo site_url('sbsmanager/process/'.$row->order_hash.'/2/'.$this->uri->segment(3))?>"><i class="fa fa-times text-red"></i></a></td>
                                                                        <td><a href="<?php echo site_url('sbsmanager/process/'.$row->order_hash.'/3/'.$this->uri->segment(3))?>"><i class="fa fa-rotate-right text-info"></i></a></td>
                                                                        <td><a href="<?php echo site_url('sbsmanager/view/'.$row->order_hash)?>" target="_blank"><i class="fa fa-eye text-info"></i></a></td>
                                                                        
                                                                    </tr>
                                                                <?php }}else{ echo "<tr><td colspan='13' class='h3 text-center'> No Applicant matching ".$filter." found</td></tr>";} ?>
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
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script>
        $('#myTable').DataTable( {
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        } );
        
        $('#myTable').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        } );
    </script>
</body>

</html>