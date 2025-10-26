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
	
	#details .holder{
	    font-size:13.5px;
	    padding:5px;
	    font-weight:normal;
	}
</style>
<?php 

for($i = 0; $i < $number; $i++){  ?>
<div style="width:327px; height:204px;  margin:auto; margin-top:150px; position:relative; border:1px solid #000; border-radius:13px">
	<table style="" id="details" cellspacing="1px" cellpadding="1px">
	    <tr>
	        <td style="width:65%; vertical-align:center;" class="holder">
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
	            
	            Student Support
	            <u>support@fubk.edu.ng</u>
	        </td>
	        
	    </tr>
	    <tr>
	        <td colspan="2" style="text-align:center; font-weight:normal; font-size:11.5px;padding:5px;">This Card remains the property of the University, any attempt to forge, copy or duplicate this may result in prosecution</td>
	    </tr>
	    
	</table>
</div>
	<div class="page-break"></div>
	
</div>
<?php }	?>