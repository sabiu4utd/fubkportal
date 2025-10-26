<style>
	table{
		border:none;
	}
	#details td{
		font-size:9.5px;
		font-family:Helvetica;
		font-weight: bold ;
		
	}
	@media all {
	.page-break	{ display: none; }
	}

	@media print {
		.page-break	{ display: block; page-break-before: always; }
	}
	
	.passport{
	    width:95px; 
	    height:130px; 
	    float:right; 
	    margin-right:4px;
	    margin-top:4px;
	    border:1px solid grey;
	}
	
	.logo{
	    width:137px; 
	    height:40px; 
	    float:left; 
	    padding:8px;
	}
	
	.qrcode{
	    width:40px; 
	    height:37px; 
	}
	
	#details .name_label{
	    font-size:17px; 
	    text-align:left; 
	    padding-bottom:4px; 
	}
	
	#details .label{
	    font-size:13.5px;
	}
	
	#details .smlabel{
	    font-size:13.5px;
	}
	
	#details .value{
	    font-size:16px;
	}
</style>
<?php 
if(isset($user) or isset($found)){ 
    if(!$found){
        echo '<div style="font-weight:900; text-align:center; color:red; font-size:34px">ID Card NOT Valid</div>';
    }else{
        
        if($type == "Identity Card"){
            echo '<div style="font-weight:900; text-align:center; color:green; font-size:24px">Identity Card is Valid</div>';

?>
<div style="width:327px; height:205px;  margin:auto; margin-top:4px; position:relative; border-radius:13px; padding:5px; border:1px solid #000">
	
    <table style="" id="details" cellspacing="1px" cellpadding="1px">
	    <tr>
	        <td style="width:77%; vertical-align:top;">
	            <img src="<?php echo base_url()?>assets/images/university-logo.png" class="logo">
	            <table>
	                <tr>
    					<td colspan="2" class="name_label">
    					    <?php echo strtoupper($user->surname)."<br>".ucwords(strtolower($user->firstname." ".$user->othername)); ?>
    					</td>
    				</tr>
    				<tr>
    					<td class="value" colspan="2" style="font-size:19px; padding-top:4px;"><?php echo $user->pnumber; ?></td>
    				</tr>
    				
	            </table>
	            
	        </td>
	        <td style="width:23%; vertical-align:top">
	            <img src="<?php echo base_url('passport/'.$user->passport); ?>" class="passport">
	        </td>
	        
	    </tr>
	    <tr>
			<tr>
				<td class="label" style="padding-left:3.5px; padding-top:2.5px; text-align:left" colspan="2"><?php echo strtoupper($user->dept_name); ?></td>
			</tr>
	    </tr>
	    
	    <tr>
			<tr>
				<td class="label" style="padding-left:3.5px; padding-top:3px;">
				    <span style="float:left; padding:0px; 1px 3px 1px;">
				        <img src="<?php echo base_url()?>assets/images/IDCardQRCode_master.png" class="qrcode">
				    </span>
				    <span style="float:left; padding:4px; 1px 3px 1px; font-weight:normal; font-size:13px">
				        Undergraduate<br>
				        Valid Dates: 
				        <?php
				            $start = substr($user->session_admitted, 0, 4);
				            $end = $user->entrymode == "UTME" ? substr($user->duration, -3) : substr($user->duration_de, -3) ;
				            $end = str_replace("(", "", $end);
				            $end = str_replace(")", "", $end);
				            
				            echo $start." - ".($start + $end);
				        ?>
				    </span>
				</td>
				<td class="label" style="padding:3px 2px 3px 0px; color:red; font-weight:900; font-size:22px;">STUDENT</td>
			</tr>
	    </tr>
	</table>
</div>
<?php }else{ ?>
    <div class="page" style="width: 90%; margin:20px; color:#000; margin:auto">
            <div class="section-body mt-4">
                <div class="container-fluid">
                    <div class="tab-content">
                        <div class="tab-pane active" id="Library-all">
                            <div class="card">
                                <div class="card-body"> 
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <img src="<?php echo base_url() ?>assets/images/fubk-icon.png" style="display:block; margin-left:auto; margin-right:auto; width:110px; padding-bottom: 5px;" />
                                            <h2 style="text-align:center; font-size:25px">FEDERAL UNIVERSITY BIRNIN KEBBI</h2>
                                            <h2 style="text-align:center; font-size:28px">STUDENT EXAMINATION CARD</h2>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-12 p-10">
                                            
                                            <hr> <h2 class="text-left" style="font-size:27px;">Student Information</h2><hr>
                                            <table style=" width:100%; color:#000; font-size:19px">
                                                <tr>
                                                    <th style="width:27%; text-align:left">FULL NAME</th>
                                                    <td style="width:53%; text-align:left"><?php echo strtoupper($user->surname) . " " . ucwords(strtolower($user->firstname . " " . $user->othername)); ?></td>
                                                    <td rowspan="6"><img src="<?php echo base_url('passport/'.$user->passport);?>" style="margin-left:auto; margin-right:auto; width:210px;" /></td>
                                                </tr>
                                                <tr>
                                                    <th style=" text-align:left">ADMISSION NO</th><td style="text-align:left"><?php echo $user->pnumber; ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align:top; text-align:left">GENDER</th>
                                                    <td style="vertical-align:top; text-align:left"><?php echo $user->gender; ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="vertical-align:top; text-align:left">LEVEL</th>
                                                    <td style="vertical-align:top; text-align:left">
                                                        <?php
                                                            $level =  $courses[0]->level; 
                                                            if (($level % 100) == 10) echo "SPILL OVER I";
                                                            else if (($level % 100) == 20) echo "SPILL OVER II";
                                                            else echo $level." Level";
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:left">PROGRAM</th>
                                                    <td style="text-align:left"><?php echo $user->prog_abbr; ?></td>
                                                </tr>
                                                <tr>
                                                    <th style="text-align:left">SEMESTER &amp; SESSION</th>
                                                    <td style="text-align:left"><?php echo $courses[0]->value.' Semester, '.$courses[0]->session; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 p-10">
                                            <hr> <h2 class="text-left" style="font-size:27px;">Courses Registered for <?php echo $courses[0]->value.' Semester, '.$courses[0]->session; ?></h2><hr>
                                            <table style=" width:100%; color:#000; font-size:19px; border-collapse:collapse" border="1">
                                                <tr style="color:#000">
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Code</th>
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Code</th>
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Code</th>
                                                    <th style="color:#000; font-weight:bolder">#</th>
                                                    <th style="color:#000; font-weight:bolder">Code</th>
                                                </tr>
                                                <tbody>
                                                    <tr>
                                                        <?php
                                                        $i = 1;
                                                        foreach ($courses as $row) {
                                                            echo "<td style='vertical-align:top'>" . $i . "</td>";
                                                            echo "<td style='vertical-align:top'><b>" 
                                                                .$row->course_code."</b><br>"
                                                                .($row->tt_time ?? 'Check General TT'). "<br>"
                                                                .(date('D d-m-Y', strtotime($row->tt_date)) ?? "Check General TT") ."<br/>"
                                                                .($row->venue ?? 'Check General TT')."</b><br>"
                                                                ."</td>";
                                                            echo ($i % 4 == 0) ? "</tr><tr>" : "";
                                                            $i++;
                                                        }
                                                        ?>
                                                    <tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 p-10">
                                            <hr>
                                            <br>
                                            <table style=" width:100%; color:#000; ">
                                                <tr style="color:#000">
                                                    <th style="vertical-align:top; width: 20%">
                                                        <img src="<?php echo base_url('assets/images/IDCardQRCode_master.png'); ?>" style="margin-left:auto; margin-right:auto; width:185px;" />
                                                    </th>
                                                    <th style="vertical-align:top">
                                                        <p style="text-align:justify">
                                                            <span style="font-size:14px;">This Examination Card is for the bearer alone, and to be used for the stated examinations ONLY. Any other use of this for any other purpose is considered a breach of University's policy and will be punishable according to the University's disciplinary procedures.</span>
                                                        </p>
                                                        <p class="text-center" style="color:red; font-weight:bolder">
                                                            Valid only after Signed &amp; Stamped by the EMC<br>
                                                            <span>See Overleaf (back) for Regulations<br>Please check with Departmental Timetable 24 hrs before each examination</span>
                                                        </p>
                                                    </th>
                                                    <th style="vertical-align:top; width: 20%; text-align:center">
                                                        <img src="<?php echo base_url('assets/images/signature.jpg'); ?>" style="margin-left:auto; margin-right:auto; width:175px;" />
                                                        <br>Chairman EMC<br>Sign &amp; Stamp
                                                    </th>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
<?php }}} else{ ?>
    <div style="width:700px; margin:auto; font-size:24px">
        <fieldset>
        <legend style="font-weight:900; font-size:35px">Document Verification System</legend>
        <p style="text-align:center">Use this tool to verify Identity Card and Examination Card for students. For any question, contact <a href="" mailto="mis@fubk.edu.ng">mis@fubk.edu.ng</a></p>
        <form action="<?php echo site_url('card/verify')?>" method="post">
            <input type="text" minlength="10" maxlength="10" required name="studentid" placeholder="Enter the Admission Number" style="width:100%; padding:5px; margin-bottom:10px; margin-top:10px; font-size:25px" />
            <div style="margin-bottom:40px;margin-top:10px; ">
                <span style="float:left"><input type="radio" required name="type" value="Identity Card" style="padding:5px;" /> ID Card</span>
                <span style="float:right"><input type="radio" required name="type" value="Exam Card" style="padding:5px;" />Exam Card</span>
            </div>
            <input type="submit" value="Click to Verify" class="btn btn-primary" style="color:#fff; font-size:25px; background-color:green; padding:5px; width:50%; margin:auto; font-weight:700; margin-top:20px; border-radius:10px"/>
        </form>
        </fieldset>
    </div>
<?php } ?>