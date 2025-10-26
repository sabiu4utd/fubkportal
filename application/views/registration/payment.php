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
                            <div class="row">
                                <div class="col-12 mt-2">
                                    <a href="<?php echo site_url('registration/admissions/' . str_replace("/", "_", $_SESSION['adm_session'])) ?>" class="btn btn-info float-left" style="margin-right:25px">
                                        <i class="fa fa-chevron-circle-left fa-lg"></i>
                                    </a>
                                    <?php $this->load->view('incs/student_header') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body mt-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body">
                                    <?php $this->load->view('incs/student_media');?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                    <table
										class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5">
										<thead>
											<tr>
												<th>#</th>
												<th>Type</th>
												<th>Session</th>
												<th>Level</th>
												<th>RRR</th>
												<th>Amount</th>
												<th>Percent</th>
												<th>Status</th>
												<th>Verify</th>
												<th>Print</th>
											</tr>
										</thead>
										<tbody>
											<?php $i = 1; foreach($pay_history as $row){ ?>
											<tr>
												<td><?php echo $i++; ?></td>
												<td><?php echo $row->type ?></td>
												<td><?php echo $row->session; ?></td>
												<td><?php echo $row->level; ?></td>
												<td>
                                                    <?php 
                                                        $rrr = str_replace("-","",$row->rrr);
                                                        echo substr($rrr, 0, 4)."-".substr($rrr, 4, 4)."-".substr($rrr, 8, 4); 
                                                    ?>
                                                </td>
												<td>&#8358; <?php echo number_format(str_replace(",","",$row->amount), 2, ".", ","); ?></td>
												<td><?php echo number_format(str_replace(",","",$row->percentage_paid), 2, ".", ","); ?>%</td>
												<td><?php echo strtoupper($row->status); ?></td>
												<td class="text-success">
                                                    <?php if($row->status == "Paid"){
                                                        echo '<i class="fa fa-check-circle text-success"></i> PAID';
                                                    }else{    
                                                    ?>
													<span style="font-weight:bolder">
                                                        <a href="<?php echo site_url('registration/checkPaymentStatus/'.md5(rand()).'/'.($row->rrr ? $row->rrr : null).'/'.$student_id."/".md5(time()))?>">
                                                        <i class="fa fa-search-dollar text-info"></i> Confirm
                                                        </a>
													</span>
                                                    <?php } ?>
												</td>
                                                <td class="text-info">
                                                    <?php 
                                                        if($rrr != NULL){
                                                            echo '<span><a href="https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/'.$rrr.'/printinvoiceRequest.pdf" target="_blank"><i class="fa fa-print"></i> Receipt</a></span>';
                                                        }else{
                                                            echo 
                                                            '<span class="badge badge-info">
                                                                RRR Missing<br>
                                                                <a href="'.site_url('registration/deletePayment/'.md5(rand()).'/'.($row->id).'/'.($student_id)."/".md5(time())).'" class="text-danger">
                                                                <i class="fa fa-times text-danger"></i> Delete
                                                                </a>
                                                            </span>';
                                                        }
                                                    ?>
												</td>
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
</body>
</html>