<?php
if (!isset($_SESSION['loginStatus']) or !isset($_SESSION['username'])) {
	redirect('auth/logout', 'refresh');
}
/*$roleid = $_SESSION['type']; ?>
<!--<div id="left-sidebar" class="sidebar">
	<h5 class="brand-name">FUBK Portal
		<a href="javascript:void(0)" class="menu_option float-right">
			<i class="fa fa-list" data-toggle="tooltip" data-placement="left" title="Grid & List Toggle"></i>
		</a>
	</h5>
	<ul class="nav nav-tabs">
		<?php if($_SESSION['user_type'] == "STAFF") { ?>
		<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu-staff">Staff</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu-students">Students</a></li>
		<?php }elseif($_SESSION['user_type'] == "STUDENT"){ ?>
		<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#menu-student">Student</a></li>
		<?php } ?>
	</ul>
	<div class="tab-content mt-3">
	<?php if($_SESSION['user_type'] == "STAFF") { ?>
		<div class="tab-pane fade show active" id="menu-staff" role="tabpanel">
			<nav class="sidebar-nav">
			<?php if($_SESSION['user_type'] == "STUDENT") { ?>
				<ul class="metismenu">
					<li>
						<a href="<?php echo site_url('staff/index'); ?>"><i class="fa fa-home"></i><span>Home</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('staff/view'); ?>"><i class="fa fa-user"></i><span>Profile</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('payslip/myslips'); ?>"><i class="fa fa-dollar"></i><span>Payslips</span></a>
					</li>
					<li>
						<a onclick="coming_soon()" href="#"><i class="fa fa-fast-forward"></i><span>Promotion</span></a>
					</li>
					<li>
						<a onclick="coming_soon()" href="#"><i class="fa fa-network-wired"></i><span>Staff Training</span></a>
					</li>
					<li>
						<a onclick="coming_soon()" href="#"><i class="fa fa-map-signs"></i><span>Leave Request</span></a>
					</li>
				</ul>
			<?php }else {?>
				<ul class="metismenu">
					<li>
						<a href="<?php echo site_url('staff/index'); ?>"><i class="fa fa-home"></i><span>Home</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('staff/view'); ?>"><i class="fa fa-user"></i><span>Profile</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('payslip/myslips'); ?>"><i class="fa fa-dollar"></i><span>Payslips</span></a>
					</li>
					<li>
						<a onclick="coming_soon()" href="#"><i class="fa fa-fast-forward"></i><span>Promotion</span></a>
					</li>
					<li>
						<a onclick="coming_soon()" href="#"><i class="fa fa-network-wired"></i><span>Staff Training</span></a>
					</li>
					<li>
						<a onclick="coming_soon()" href="#"><i class="fa fa-map-signs"></i><span>Leave Request</span></a>
					</li>
				</ul>
				<?php } if ($roleid == '6') { //registrar 
				?>
					<hr>
					<h6 class="brand-name font-16">Extra Actions</h6>
					<hr>
					<ul class="metismenu">
						<li>
							<a href="<?php echo site_url('staff/viewall'); ?>"><i class="fa fa-chalkboard-teacher"></i><span>Staff Manager</span></a>
						</li>
						<li>
							<a href="<?php echo site_url('payslip'); ?>"><i class="fa fa-users"></i><span>Payslip Manager</span></a>
						</li>
						<li>
							<a href="<?php echo site_url('dataentry/index'); ?>"><i class="fa fa-chalkboard-teacher"></i><span>Data Entry Manager</span></a>
						</li>
					</ul>
				<?php } elseif ($roleid == '7') { //dataentry-officer 
				?>
					<hr>
					<h6 class="brand-name font-16">Extra Actions</h6>
					<hr>
					<ul class="metismenu">
						<li>
							<a href="<?php echo site_url('dataentry/index'); ?>"><i class="fa fa-chalkboard-teacher"></i><span>Data Entry Manager</span></a>
						</li>
					</ul>
				<?php } else if ($roleid == '8') { //bursar 
				?>
					<hr>
					<h6 class="brand-name font-16">Extra Actions</h6>
					<hr>
					<ul class="metismenu">
						<li>
							<a href="<?php echo site_url('payslip'); ?>"><i class="fa fa-users"></i><span>Payslip Manager</span></a>
						</li>
					</ul>
				<?php } ?>
			</nav>
		</div>
		<div class="tab-pane fade show" id="menu-students" role="tabpanel">
			<nav class="sidebar-nav">
				<ul class="metismenu">
					<li>
						<a href="<?php echo site_url("staff/allocated_courses")?>"><i class="fa fa-chalkboard-teacher"></i><span>Courses</span></a>
					</li>
					<li>
						<a href="<?php echo site_url("staff/evaluation")?>"><i class="fa fa-vial"></i><span>Course Evaluation</span></a>
					</li>
					<li>
						<a href="#" onclick="coming_soon()"><i class="fa fa-users"></i><span>Timetable</span></a>
					</li>
					<li><a href="#" onclick="coming_soon()"><i class="fa fa-users"></i><span>Attendances</span></a></li>
				</ul>
				<hr>
				<h6 class="brand-name font-16">Extra Actions</h6>
				<hr>
				<ul class="metismenu">
					<li>
						<a href="<?php echo site_url('result/index'); ?>"><i class="fa fa-poll-h"></i><span>Result Manager</span></a>
					</li>
				</ul>
			</nav>
		</div>
	<?php }elseif($_SESSION['user_type'] == "STUDENT"){ ?>
		<div class="tab-pane fade show active" id="menu-student" role="tabpanel">
			<nav class="sidebar-nav">
				<ul class="metismenu">
					<li>
						<a href="<?php echo site_url('student/index'); ?>"><i class="fa fa-home"></i><span>Home</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('student/view'); ?>"><i class="fa fa-user"></i><span>Profile</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('payment/history'); ?>"><i class="fa fa-dollar"></i><span>Payments</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('course/registration'); ?>"><i class="fa fa-copyright"></i><span>Course Registration</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('accomodation/myaccomodation'); ?>"><i class="fa fa-house-user"></i><span>Accomodation</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('result/myresult'); ?>"><i class="fa fa-poll"></i><span>Results</span></a>
					</li>
				</ul>
			</nav>
		</div>
	<?php } else{ //redirect('auth/logout', 'refresh');
	}?>
	</div>
</div>
	-->
*/
