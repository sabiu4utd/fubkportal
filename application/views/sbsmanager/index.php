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

    <!--<div class="page-loader-wrapper">-->
    <!--    <div class="loader"></div>-->
    <!--</div>-->
    <div id="main_content">
        <?php
        $this->load->view('incs/header');
        $this->load->view('incs/lside');
        ?>
        <div class="page">

            <?php $this->load->view('incs/pageheader'); ?>


            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="row clearfix">
                        <div class="col-xl-12">
                            <div class="row clearfix row-deck">
                                <div class=" col-12 mb-2 text-center">
                                    <h3 style="text-align:center" class="text-center">SBS Manager</h3>
                                </div>

                                <div class="col-6 col-md-2 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('sbsmanager/') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-home"></i>
                                                <span>SBS Home</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-6 col-md-2 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('sbsmanager/admissions') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-user-plus"></i>
                                                <span>Admissions</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="<?php echo site_url('sbsmanager/registrations') ?>" class="my_sort_cut text-muted">
                                                <i class="fa fa-vote-yea"></i>
                                                <span>Registrations</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="#<?php echo site_url('') ?>" class="my_sort_cut text-muted"onclick="alert('Feature coming soon')">
                                                <i class="fa fa-tools"></i>
                                                <span>Setup</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="#<?php echo site_url('') ?>" class="my_sort_cut text-muted" onclick="alert('Feature coming soon')">
                                                <i class="fa fa-file-export"></i>
                                                <span>Reports</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-2 raise">
                                    <div class="card">
                                        <div class="card-body">
                                            <a href="#<?php echo site_url('') ?>" class="my_sort_cut text-muted" onclick="alert('Feature coming soon')">
                                                <i class="fa fa-file-export"></i>
                                                <span>Others</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-center">
                                        Application Summary for <?php echo $_SESSION['sbs_session'] ?>
                                        <span style="float:right;">
                                            <form method="post" action="<?php echo site_url('result/change_session') ?>">
                                                <select name="semester" class="form-control">
                                                    <?php
                                                    // foreach ($sessions as $row) {
                                                    //     echo "<option value='" . $row->id . "'>" . $row->value . " Semester, " . $row->session . "</option>";
                                                    // }
                                                    ?>
                                                </select>
                                                <button type="submit" class="btn btn-success"><i class="fa fa-arrow-circle-right"></i></button>
                                            </form>
                                        </span>
                                    </h5>
                                    <hr>
                                    <p class="text-muted m-b-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover js-basic-example dataTable table-striped table_custom border-style spacing5" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Program</th>
                                                    <th>Applications</th>
                                                    <th>Submissions</th>
                                                    <th>Admitted</th>
                                                    <th>Rejected</th>
                                                    <th>Pending</th>
                                                    <th>Manage</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1;
                                                foreach ($stats as $row) { //var_dump($row); 
                                                if($row->program_id > 21){ ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo strtoupper($row->program) ?></td>
                                                        <td><?php echo number_format($row->applied ?? 0, 0, '.',','); ?></td>
                                                         <td><?php //echo 
                                                        //             "Submitted: ".number_format($row->submitted ?? 0, 0, '.',',').' ('.number_format((100*$row->submitted/$row->applied), 0, '.',',').'% of applications)<br>'.
                                                        //             "Male: ".number_format($row->malesubmitted ?? 0, 0, '.',',').' ('.number_format((100*$row->malesubmitted/$row->submitted), 0, '.',',').'%)&nbsp;|&nbsp;'.
                                                        //             "Female: ".number_format($row->femalesubmitted ?? 00, 0, '.',',').' ('.number_format((100*$row->femalesubmitted/$row->submitted), 0, '.',',').'%)'
                                                        ?></td>
                                                        <td><?php 
                                                                 echo "Admitted: ".number_format($row->admitted, 0, '.',',')."<br>";
                                                                 echo  "Male: ".number_format($row->maleadmitted, 0, '.',',');
                                                                 if($row->admitted > 0) { echo ' ('.number_format((100*$row->maleadmitted/$row->admitted), 0, '.',',').'%)&nbsp;|&nbsp;'; } //else {echo '0'; }
                                                                  echo  " Female: ".number_format($row->femaleadmitted, 0, '.',',');
                                                                  if($row->admitted > 0) { echo ' ('.number_format((100*$row->femaleadmitted/$row->admitted), 0, '.',',').'%)'; } //else { echo '0'; }
                                                        ?></td>
                                                        <td><?php echo number_format($row->rejected, 0, '.',',') ?></td>
                                                        <td><?php echo number_format($row->pending, 0, '.',',') ?></td>
                                                        
                                                        <td>
                                                            <a class="btn btn-info btn-sm" href="<?php echo site_url('sbsmanager/view/' . md5(time() . rand()) . '/'.$row->program_id).'/0/'. md5(time() . rand()); ?>"></a>
                                                            <i class="fa fa-user-shield"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } } ?>
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