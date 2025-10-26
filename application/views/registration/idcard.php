<style>
	table {
		border: none;
	}
	#details td {
		font-size: 9.5px;
		font-family: Helvetica;
		font-weight: bold;
	}
	@media all {
		.page-break {
			display: none;
		}
	}
	@media print {
		.page-break {
			display: block;
			page-break-before: always;
		}
	}
    
	.passport {
		width: 95px;
		height: 130px;
		float: right;
		margin-right: 4px;
		margin-top: 4px;
		border: 1px solid grey;
	}
	.logo {
		width: 137px;
		height: 40px;
		float: left;
		padding: 8px;
	}
	.qrcode {
		width: 40px;
		height: 37px;
	}
	#details .name_label {
		font-size: 17px;
		text-align: left;
		padding-bottom: 4px;
	}
	#details .label {
		font-size: 13.5px;
	}
	#details .smlabel {
		font-size: 13.5px;
	}
	#details .value {
		font-size: 16px;
	}
</style>


	<div style="width:327px; height:180px;  margin:auto; margin-top:4px; position:relative; border-radius:13px; padding:5px">
		<table style="" id="details" cellspacing="1px" cellpadding="1px">
			<tr>
				<td style="width:77%; vertical-align:top;">
					<img src="<?php echo base_url('assets/images/university-logo.png') ?>" class="logo">
					<table>
						<tr>
							<td colspan="2" class="name_label">
								<?php echo strtoupper($idcards->surname) . "<br>" . ucwords(strtolower($idcards->firstname . " " . $idcards->othername)); ?>
							</td>
						</tr>
						<tr>
							<td class="value" colspan="2" style="font-size:19px; padding-top:4px;"><?php echo $idcards->pnumber; ?></td>
						</tr>
					</table>
				</td>
				<td style="width:23%; vertical-align:top">
					<img src="<?php echo base_url('passport/'.$idcards->passport) ?>" class="passport">
				</td>
			</tr>
			<tr>
			<tr>
				<td class="label" style="padding-left:3.5px; padding-top:2.5px; text-align:left" colspan="2"><?php echo strtoupper($idcards->dept_name); ?></td>
			</tr>
			</tr>
			<tr>
			<tr>
				<td class="label" style="padding-left:3.5px; padding-top:3px;">
					<span style="float:left; padding:0px; 1px 3px 1px;">
						<img src="<?php echo base_url('assets/images/IDCardQRCode.png.png') ?>" class="qrcode">
					</span>
					<span style="float:left; padding:4px; 1px 3px 1px; font-weight:normal; font-size:13px">
						Undergraduate<br>
						Valid Dates:
						<?php
						$start = substr($idcards->session_admitted, 0, 4);
						$end = $idcards->entrymode == "UTME" ? substr($idcards->duration, -3) : substr($idcards->duration_de, -3);
						$end = str_replace("(", "", $end);
						$end = str_replace(")", "", $end);
						echo $start . " - " . ($start + $end);
						?>
					</span>
				</td>
				<td class="label" style="padding:3px 2px 3px 0px; color:red; font-weight:900; font-size:22px;">STUDENT</td>
			</tr>
			</tr>
		</table>
	</div>
	<div class="page-break"></div>
	</div>
	<div style="width:327px; height:180px;  margin:auto; margin-top:4px; position:relative; border-radius:13px; padding:5px">
		<table style="" id="details" cellspacing="1px" cellpadding="1px">
			<tr>
				<td style="width:65%; vertical-align:center; font-size:11.5px;" class="holder">
					<br>If found, please return to:<br><br>
					Security Division<br>
					Federal University Birnin Kebbi<br>
					PMB 1157, Birnin-Kebbi<br>
					Kebbi State, Nigeria<br><br>
					<u>secuirty@fubk.edu.ng</u><br>
					+234 (0) 815 045 9378
				</td>
				<td style="width:35%; vertical-align:top; font-weight:normal; font-size:11.5px;padding-top:7px;">
					<br>Card Services:<br>
					<u>cards@fubk.edu.ng</u><br><br>
					MIS Directorate<br>
					<u>mis@fubk.edu.ng</u><br><br>
					University Library
					<u>library@fubk.edu.ng</u><br><br>
				</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center; font-weight:normal; font-size:11.5px;padding:5px;">This Card remains the property of the University, any attempt to forge, copy or duplicate this may result in prosecution</td>
			</tr>
		</table>
	</div>
	<div class="page-break"></div>
	</div>
