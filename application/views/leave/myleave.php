<!doctype html>
<html lang="en" dir="ltr">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $_SESSION['pageTitle']; ?></title>

    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>

<body class="font-muli right_tb_toggle <?php echo " ".$_SESSION['theme_mode']; ?>">

    <div class="page-loader-wrapper">
        <div class="loader"></div>
    </div>
    <div id="main_content">
        <?php $this->load->view('incs/header');?>
        <?php //$this->load->view('incs/rside');?>
        <?php $this->load->view('incs/lside');?>

        <div class="page">

            <?php $this->load->view('incs/pageheader');?>
            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action">
                            <h1 class="page-title">Leave</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item active" aria-current="page">My Leave Applications</li>
                            </ol>
                        </div>
                        <a href="<?php echo site_url('leave/create');?>" class="btn btn-success btn-sm">Create New Leave Application</a>
                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-vcenter text-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Type</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Number of day(s)</th>
                                                <th>Leave Reason</th>
                                                <th>Status</th>
                                                <th>Manage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php $i = 1; foreach($leaves as $row){ ?>
                                            <tr>
                                                <td class="width45"><?php echo $i++;?></td>
                                                <td><?php echo $row->type;?></td>
                                                <td><?php echo date("Y-m-d", $row->start_date);?></td>
                                                <td><?php echo date("Y-m-d", $row->end_date);?></td>
                                                <td><?php echo (floor($row->end_date - $row->start_date)/86400)." day(s)";?></td>
                                                <td><?php echo $row->reason;?></td>
                                                <td>
													<span>
														<?php if($row->leave_status == 1){ ?>
															<a class="text-success"> <i class="fa fa-check-circle"></i> Approved</a>
														<?php } else if($row->leave_status == 0){ ?>
															<a class="text-info"> <i class="fa fa-edit"></i> Pending</a>
														<?php } else{ ?>
															<a class="text-danger"> <i class="fa fa-times-circle"></i> Rejected</a>
														<?php } ?>
													</span>
												</td>
                                                <td>
													<a href="<?php echo site_url('leave/edit/'.$row->leave_hash);?>" class="btn btn-icon btn-sm"><i class="fa fa-edit text-success"></i></a>		
                                                </td>
                                            </tr>
											<?php } ?>
                                            
                                        </tbody>
                                    </table>
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
        type="9fd9ada6d233c2bf7246e925-text/javascript"></script>


    <script src="<?php echo base_url()?>assets/js/core.js" type="9fd9ada6d233c2bf7246e925-text/javascript"></script>
    <script
        src="<?php echo base_url()?>assets/js/rocket-loader.min.js"
        data-cf-settings="9fd9ada6d233c2bf7246e925-|49" defer=""></script>
</body>

</html>
