<!doctype html>
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
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/dropify/css/dropify.min.css">
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/summernote/dist/summernote.css" />

    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
</head>


<body class="font-muli right_tb_toggle <?php echo " ".$_SESSION['theme_mode']; ?>">

    <div class="page-loader-wrapper">
        <div class="loader">
        </div>
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
                            <h1 class="page-title">Staff</h1>
                            <ol class="breadcrumb page-breadcrumb">
                                <li class="breadcrumb-item"><a href="#">FUBK-PORTAL</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Register New Staff</li>
                            </ol>
                        </div>
                        <ul class="nav nav-tabs page-header-tab">
                            <li class="nav-item">
                                <a class="nav-link active p-10" href="<?php echo base_url('staff/viewall/')?>"><i class="fa fa-edit"></i>View all Staff</a>
								
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="card-footer text-left">
                        <div class="row">
                            <div class="col-12">
                                <div class="font-18 font-weight-bolder">Personal Information</div>
								<hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Title</div>
                                <div>
									<select name="title" required  class="form-control">
										<option>Mal.</option>
										<option>Mal.</option>
										<option>Mr.</option>
										<option>Mrs.</option>
										<option>Miss.</option>
										<option>Dr.</option>
										<option>Prof.</option>
									</select>
								</div>
                            </div>
							<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Staff Surname</div>
                                <div>
									<input type="text" class="form-control" placeholder="Enter Staff's Surname" required name="surname" />
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Staff Firstname</div>
                                <div>
									<input type="text" class="form-control" placeholder="Enter Staff's Firstname" required name="firstname"/>
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Staff Othername(s)</div>
                                <div>
									<input type="text" class="form-control" placeholder="Enter Staff's Othername(s)" required name="othernames" />
								</div>
                            </div>
						</div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Gender</div>
                                <div>
									<select name="gender" required  class="form-control">
										<option>Male</option>
										<option>Female</option>
									</select>
								</div>
                            </div>
							<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Date of Birth</div>
                                <div>
									<input type="date" class="form-control" placeholder="Enter Staff's Date of Birth" required name="dob" />
								</div>
                            </div>
                            
                        
							<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Marital Status</div>
                                <div>
									<select name="gender" required  class="form-control">
										<option>Single</option>
										<option>Married</option>
										<option>Divorced</option>
										<option>Separated</option>
									</select>
								</div>
                            </div>
						
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">State of Origin</div>
                                <div>
									<select name="state" id="state" required  class="form-control">
										<?php foreach($states as $row){ 
											echo "<option value='".$row->id."'>".$row->state_name."</option>";
										} ?>
									</select>
								</div>
                            </div>
						</div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">LGA of Origin</div>
                                <div>
									<select name="lga" id="lga" required  class="form-control"></select>
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Town</div>
                                <div>
									<input type="text" class="form-control" placeholder="Enter Town of Birth" name="town" />
								</div>
                            </div>
                        
							<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Phone number</div>
                                <div>
									<input type="text" class="form-control" placeholder="Enter Contact Phone" required name="phone" />
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Email Address</div>
                                <div>
									<input type="text" class="form-control" placeholder="Enter Personal Email" required name="email" />
								</div>
                            </div>
						</div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 p-10">
                                <div class="font-18 font-weight-bold">Contact Address</div>
                                <div>
									<textarea rows="2" class="form-control" placeholder="Enter Contact Address" required name="contact_address" ></textarea>
								</div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6 col-xl-6 p-10">
                                <div class="font-18 font-weight-bold">Permanent Address</div>
                                <div>
									<textarea rows="2" class="form-control" placeholder="Enter Permanent Address" required name="permanent_address" ></textarea>
								</div>
                            </div>
                        </div>
                    </div>
					<div class="card-footer text-left">
                        <div class="row">
                            <div class="col-12">
                                <div class="font-18 font-weight-bolder">Employement Information</div>
								<hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Employee Number</div>
                                <div>
									<input type="text" class="form-control" placeholder="Enter Employee Number" required name="employee_no" />
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Registry File Number</div>
                                <div>
									<input type="text" class="form-control" placeholder="Enter Registry File Number" name="registry_file_no" />
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Designation</div>
                                <div>
									<select name="designation" required  class="form-control">
										<?php foreach($states as $row){ 
											echo "<option value='".$row->id."'>".$row->state_name."</option>";
										} ?>
									</select>
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Appointment Type</div>
                                <div>
									<select name="appt_type" required  class="form-control">
										<?php foreach($states as $row){ 
											echo "<option value='".$row->id."'>".$row->state_name."</option>";
										} ?>
									</select>	
								</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Date of First Appointment</div>
                                <div>
									<input type="date" class="form-control" placeholder="Enter Date of 1st Appointment" required name="dofa" />
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Date of Last Promotion</div>
                                <div>
									<input type="date" class="form-control" placeholder="Enter Date of Last Promotion" name="dolp" />
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Rank</div>
                                <div>
									<select name="rank" required  class="form-control">
										<?php foreach($states as $row){ 
											echo "<option value='".$row->id."'>".$row->state_name."</option>";
										} ?>
									</select>
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Directorate/Faculty</div>
                                <div>
									<select name="directorate" id="directorate" required  class="form-control">
										<?php foreach($states as $row){ 
											echo "<option value='".$row->id."'>".$row->state_name."</option>";
										} ?>
									</select>
								</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Department/Unit</div>
                                <div>
									<select name="dept" id="dept" required  class="form-control">
										<?php foreach($states as $row){ 
											echo "<option value='".$row->id."'>".$row->state_name."</option>";
										} ?>
									</select>
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Salary Structure</div>
                                <div>
									<select name="salary_structure" required  class="form-control">
										<?php foreach($states as $row){ 
											echo "<option value='".$row->id."'>".$row->state_name."</option>";
										} ?>
									</select>
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Grade Level</div>
                                <div>
									<select name="grade_level" required  class="form-control">
										<?php for($i = 1; $i < 15; $i++){ 
											echo "<option>".$i."</option>";
										} ?>
									</select>
								</div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Step</div>
                                <div>
									<select name="step" required  class="form-control">
										<?php for($i = 1; $i < 15; $i++){ 
											echo "<option>".$i."</option>";
										} ?>
									</select>
								</div>
                            </div>
                        </div>
                    </div>
					<div class="card-footer text-left">
                        <div class="row">
                            <div class="col-12">
                                <div class="font-18 font-weight-bolder">Financial Information</div>
								<hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Bank Name</div>
                                <div><?php echo $staff->employee_no; ?></div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Account Number</div>
                                <div><?php echo $staff->registry_file_no; ?></div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Sort Code</div>
                                <div><?php echo $staff->designation; ?></div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">BVN</div>
                                <div><?php echo $staff->dofa; ?></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">PFA Administrator</div>
                                <div><?php echo $staff->dofa; ?></div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">PFA PIN</div>
                                <div><?php echo $staff->dob; ?></div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Rank</div>
                                <div><?php echo $staff->ippis_no; ?></div>
                            </div>
                            <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 p-10">
                                <div class="font-18 font-weight-bold">Area of Specialization</div>
                                <div><?php echo $staff->designation; ?></div>
                            </div>
                        </div>
                    </div>
					<div class="card-footer text-left">
                        <div class="row">
                            <div class="col-12">
                                <div class="font-18 font-weight-bolder">Academic Qualifications</div>
								<hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-10">

                            </div>
                            
                        </div>
                    </div>
					<div class="card-footer text-left">
                        <div class="row">
                            <div class="col-12">
                                <div class="font-18 font-weight-bolder">Administrative Appointments</div>
								<hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-10">
								
                            </div>
                            
                        </div>
                    </div>
					<div class="card-footer text-left">
                        <div class="row">
                            <div class="col-12">
                                <div class="font-18 font-weight-bolder">Training &amp; Development</div>
								<hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-10">
								
                            </div>
                            
                        </div>
                    </div>
					<div class="card-footer text-left">
                        <div class="row">
                            <div class="col-12">
                                <div class="font-18 font-weight-bolder">Promotions</div>
								<hr>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 p-10">
								
                            </div>
                            
                        </div>
                    </div>

                    <?php $this->load->view('incs/footer');?>
                </div>
            </div>

            <script src="<?php echo base_url()?>assets/bundles/lib.vendor.bundle.js"
                type="e27f9daa9c2f25670b2c3761-text/javascript"></script>

            <script src="<?php echo base_url()?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
                type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
            <script src="<?php echo base_url()?>assets/plugins/dropify/js/dropify.min.js"
                type="e27f9daa9c2f25670b2c3761-text/javascript"></script>
            <script src="<?php echo base_url()?>assets/bundles/summernote.bundle.js"
                type="e27f9daa9c2f25670b2c3761-text/javascript"></script>

            <script src="<?php echo base_url()?>assets/js/core.js" type="e27f9daa9c2f25670b2c3761-text/javascript">
            </script>
            <script src="<?php echo base_url()?>assets/js/form/dropify.js"
                type="e27f9daa9c2f25670b2c3761-text/javascript">
            </script>
            <script src="<?php echo base_url()?>assets/js/page/summernote.js"
                type="e27f9daa9c2f25670b2c3761-text/javascript">
            </script>
            <script src="<?php echo base_url()?>assets/js/rocket-loader.min.js"
                data-cf-settings="e27f9daa9c2f25670b2c3761-|49" defer=""></script>
</body>

</html>
