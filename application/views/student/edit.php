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
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/fixedeader/dataTables.fixedcolumns.bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/datatable/fixedeader/dataTables.fixedheader.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>
<body class="font-muli right_tb_toggle <?php echo " " . $_SESSION['theme_mode']; ?>">
    <div class="page-loader-wrapper">
        <div class="loader"></div>
    </div>
    <div id="main_content">
        <?php $this->load->view('incs/header'); ?>
        <div class="page">
            <?php $this->load->view('incs/pageheader'); ?>
            <div class="section-body">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center ">
                        <div class="header-action">
                            <h1 class="page-title">Student</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="card-footer text-left">
                        <div class="row">
                            <div class="col-12">
                                <div class="font-18 font-weight-bolder uppercase">
                                    PERSONAL INFORMATION
                                    <a class="nav-link float-right p-10" href="<?php echo site_url('student/view'); ?>">
                                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;Back to Profile
                                    </a>
                                </div>
                                <hr>
                            </div><
                            <div class="col-12">
                                <div class="font-18 font-weight-bolder alert alert-danger text-center">
                                    You can only edit your contact information. For any other correction or update, contact the ICT
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-9">
                                <form action="<?php echo site_url('student/saveprofile') ?>" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-sm-12 col-md-6 p-10">
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">State of Origin</div>
                                            <div>
                                                <select name="state" id="state" class="form-control" required>
                                                    <option disbaled>-[Choose a State]-</option>
                                                    <?php foreach($states as $row){
                                                        echo "<option value='".$row->stateid."' ".($contact_info ? ($contact_info->stateid == $row->stateid) ? "selected" : "" : "").">".$row->state_name."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Phone number</div>
                                            <div><input type="number" class="form-control" required value="<?php echo $contact_info ? $contact_info->phone:""; ?>" name="phone" /></div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Personal Email</div>
                                            <div><input type="email" class="form-control" required value="<?php echo $contact_info ? $contact_info->email:""; ?>" name="personal_email" /></div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Postal Address</div>
                                            <div><textarea required class="form-control" name="contact_address" rows="3"><?php echo $contact_info ? $contact_info->caddress:""; ?></textarea></div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Permanent Address</div>
                                            <div><textarea required class="form-control" name="permanent_address" rows="4"><?php echo $contact_info ? $contact_info->haddress:""; ?></textarea></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 p-10">
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">LGA of Origin</div>
                                            <div>
                                                <select name="lga" id="lga" class="form-control" required>
                                                    <option disbaled>-[Choose an LGA]-</option>
                                                    <?php foreach($lgas as $row){
                                                        echo "<option value='".$row->id."' ".($contact_info ? ($contact_info->lgaid == $row->id) ? "selected" : "" : "").">".$row->lga_name."</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Kin's Fullname</div>
                                            <div>
                                                <input type="text" class="form-control" name="nok_name" required value="<?php echo $contact_info ? ucwords(strtolower($contact_info->nok_name)):""; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Relationship</div>
                                            <div>
                                                <select name="nok_relationship" class="form-control" required>
                                                    <option <?php echo $contact_info ? ($contact_info->nok_relationship == "Father") ? "selected" : "" : ""; ?>>Parent</option>
                                                    <option <?php echo $contact_info ? ($contact_info->nok_relationship == "Spouse") ? "selected" : "" : ""; ?>>Spouse</option>
                                                    <option <?php echo $contact_info ? ($contact_info->nok_relationship == "Sibling") ? "selected" : "" : ""; ?>>Sibling</option>
                                                    <option <?php echo $contact_info ? ($contact_info->nok_relationship == "Relative") ? "selected" : "" : ""; ?>>Relative</option>
                                                    <option <?php echo $contact_info ? ($contact_info->nok_relationship == "Others") ? "selected" : "" : ""; ?>>Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Kin's Phone</div>
                                            <div>
                                                <input type="text" class="form-control" name="nok_phone" required value="<?php echo $contact_info ? $contact_info->nok_phone: ""; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Kin's Email</div>
                                            <div>
                                                <input type="email" class="form-control" name="nok_email" value="<?php echo $contact_info ? $contact_info->nok_email:""; ?>" />
                                            </div>
                                        </div>
                                        <div class="col-12 p-10">
                                            <div class="font-18 font-weight-bold">Contact Address</div>
                                            <div><textarea name="nok_address" class="form-control" required rows="2"><?php echo $contact_info ? $contact_info->nok_address:""; ?></textarea></div>
                                        </div>
                                    </div>
                                    <div class="col-12 p-10">
                                        <div>
                                            <input type="submit" value="Update Personal Information" class="form-control btn btn-success" />
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                            <div class="col-sm-12 col-md-3 p-10">
                                <form action="<?php echo site_url('student/uploadPassport') ?>" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-9 p-10 mx-auto">
                                            <div class="font-18 font-weight-bold text-center"><em>JPG &amp; PNG formats Only<br>Between 2MB and 4MB</em></div>
                                            <div class="font-18"><img style="min-height: 300px;min-width: 280px; height: 300px;width: 280px; border:1px solid #000" class="mx-auto" src="<?php echo base_url('passport/'.$student->passport)?>" alt="<?php echo $student->uniqueID; ?>" /></div>
                                            <div><br><input type="file" class="form-control" required name="passport" id="passport" /></div>
                                            <div><br><input type="submit" class="form-control btn btn-primary" value="Upload Passport" /></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php $this->load->view('incs/footer'); ?>
                    </div>
                </div>
                <script src="<?php echo base_url() ?>assets/bundles/lib.vendor.bundle.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
                <script src="<?php echo base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
                <script src="<?php echo base_url() ?>assets/plugins/dropify/js/dropify.min.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
                <script src="<?php echo base_url() ?>assets/bundles/summernote.bundle.js" type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
                <script src="<?php echo base_url() ?>assets/js/core.js" type="e27f9daa9c2f25670b2c3761-text/javascript">
                </script>
                <script src="<?php echo base_url() ?>assets/js/form/dropify.js" type="e27f9daa9c2f25670b2c3761-text/javascript">
                </script>
                <script src="<?php echo base_url() ?>assets/js/page/summernote.js" type="e27f9daa9c2f25670b2c3761-text/javascript">
                </script>
                <script src="<?php echo base_url() ?>assets/js/rocket-loader.min.js" data-cf-settings="e27f9daa9c2f25670b2c3761-|49" defer=""></script>
                <script src="<?php echo base_url() ?>assets/js/table/datatable.js" type="7ab396837eea337a09d7c15b-text/javascript"></script>
                <script src="<?php echo base_url() ?>assets/bundles/dataTables.bundle.js" type="7ab396837eea337a09d7c15b-text/javascript"></script>
</body>
</html>