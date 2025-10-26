
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hostel Clearance</title>
    
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <style>
        .body {
            width: 21cm;
            height: 29.7cm;
            margin: 15mm 45mm 30mm 20mm;
            border: 0.5px solid silver;
             margin:auto; height:auto;
              padding:30px
            /* change the margins as you want them to be. */
        }
        
        table th{
            text-align:left;
        }
    </style>

</head>

<body>
    <div class="body" style="font-size:12px; height:1490px; width:990px">
        <img src="<?php echo base_url('assets/images/fubk-icon.png') ?>" alt="" style="width: 150px; float:left">
        <center>
            <span style="text-align:center; font-size:25pt; font-family: stencil;">FEDERAL UNIVERSITY BIRNIN KEBBI</span><br />
            <span style="text-align:center; font-size:18pt">(STUDENT AFFAIRS DIVISION)</span><br />
            <span style="text-align:center; font-size:12pt">P.M.B 1157, KEBBI STATE NIGERIA</span> <br /><br />
            <span style="text-align:center; font-size:14pt; text-decoration: underline;">STUDENT’S BEDSPACE CONFIRMATION &amp; CLEARANCE FORM</span>
        </center>
        <br />
        <br />
        <br />
        <table class="table table-bordered" style="width:90%; font-size:15px ">
        	<tr>
        	    <th>Student Name</th>
        	    <td><?php echo strtoupper($result->surname)." ".$result->firstname." ".$result->othername; ?></td>
        	    <td rowspan="5"><img src="<?php echo base_url('passport/'.$result->passport); ?>" style="width:200px"/></td>
        	</tr>
        	<tr><th>Admission Number</th><td><?php echo $result->pnumber; ?></td></tr>
        	<tr><th>Programme</th><td><?php echo $result->prog_abbr; ?></td></tr>
        	<tr><th>Gender/ Level</th><td><?php echo $result->gender.'/ '.$result->current_level; ?></td></tr>
        	<tr><th>Contact</th><td><?php echo $result->phone; ?></td></tr>
    	</table>
        <br /><br />
         
        
    
        <h3 style="text-decoration: underline; text-align: center; font-family: tahoma; font-size:18px"> RESERVATION DETAILS</h3>
    
    
        <div style="text-align: justify;  font-family: tahoma; width:90%">
        <table class="table table-bordered" style="width:100%;font-size:13px; ">
        	<tr><th>Hostel Name</th><td><?php echo $reservation->hostelname;?></td></tr>
        	<tr><th>Hostel Location</th><td><?php echo $reservation->location;?></td></tr>
        	<tr><th>Room Name</th><td><?php echo $reservation->room_name;?></td></tr>
        	<tr><th>Bedspace</th><td><?php echo $reservation->bedspace;?></td></tr>
        	<tr><th>RRR Number</th><td><?php echo isset($reservation->rrr) ? $reservation->rrr : "N/A";?></td></tr>
    	</table>
    
            <br /><br />
            <h3 style="text-decoration: underline; text-align: center; font-size:18px">UNDERTAKING</h3>
            <div style="font-size:14px;">
            I <strong><?php echo strtoupper($result->surname)." ".$result->firstname." ".$result->othername; ?></strong>, do hereby accept the bed space allocated to me as above. I would be the one to use it for period approved and pledged to abide by all the rules and regulations governing the university Halls of residence as contained in the student Handbook and those to be regularly issued by the authority. I also understand that any breach of those rules understand would lead to disciplinary action against me
            <br /><br />
            __________________ <br>Student's Signature
    
            <br />
            <br />
            <h3 style="text-decoration: underline; text-align: center;font-size:18px">FOR OFFICIAL USE ONLY</h3> <br />
            <div style="font-size:14px">
                <div>
                    <span class="float-left">
                        ____________________________________________________________<br>(Clearing Officer)
                    </span>
                    <span class="float-right">
                        _____________<br>(Signature/Date)
                    </span>
                </div>
                <br /><br /><br /><br />
                <div>
                    <span class="float-left">
                        _____________________________________________________________________________________________________________<br>(Clearing Officer's Comment)
                    </span>
                </div>
                <br /><br /><br /><br />
                <div>
                    <span class="float-left">
                        ____________________________________________________________<br>(Supervisor/Matron)
                    </span>
                    <span class="float-right">
                        _____________<br>(Signature/Date)
                    </span>
                </div>
                <br /><br /><br /><br />
                <div>
                    <span class="float-left">
                        _____________________________________________________________________________________________________________<br>(Supervisor/Matron's Comment)
                    </span>
                </div>
            </div>
            <br /><br /><br /><br />
            <em>Printed on <?php echo date('d-m-Y H:i:s')?></em>
            </div>
        </div>
    </div>



    <div class="body" style="font-size:12px; height:1490px; width:990px; page-break:after">
        
    <p style="text-align:justify; font-size:10pt; width:950px; line-height:1.5">
								 
        <strong>(1) CRITERIA FOR ALLOCATION</strong> <br />
             (a)   Medical certificate.<br />
             (b)  Only bonafide students are offered accommodation.<br />
             (c)  The accommodation is based on first come first serve.<br />
        <strong>(2) NO OUTSIDER TO BE ALLOWED IN THE HOSTEL</strong><br />
        No person other than a bonafide student of the University admitted to the hostel. Any student who accommodate any person or family member in his/her room will be liable to forfeit his/her accommodation. <br />
        <strong>(3) NO STUDENT WILL BE ALLOWED IN THE HOSTEL 12 HOURS AFTER THE SCHOOL IS OFFICIALLY CLOSED FOR VACATION.</strong><br />
        All student living in the hostel should vacate twelve hours after the closure of the school.   <br />
           

        <strong>(4)   GUESTS AND VISITORS</strong><br />
        Guests and visitors are only allowed in the hostel area from 8:00am to 6:00 pm. Students are advised to strictly adhere to this provision as the hostel supervisor, matron , a hostel representative or security man has the right to ask a guest to leave the premises.
        <strong> NB: it is strictly forbidden for male visitors to enter the female hostel and vice versa.</strong><br />
        <strong>(5) SUB-LETTING ACCOMODATION</strong> <br />
        It is an offence for any student to sub-let his accommodation to another who has not secured accommodation. In cases where accommodation is found to be secretly sublet, both the accommodation and fees will be forfeited by the culprits.
        <br />
        <strong>(6) DUTIES  REGARDING THEIR ROOMS</strong> <br />
        The students shall keep their rooms in a neat and tidy condition and shall be responsible jointly and individually for the furniture issued to them and fittings present in the room. The room shall not be disfigured by writing, drawing, fixing of nails. Inmates are to be held responsible for any damage. They should report any repairs to the matrons, hostel supervisor or hall representative as the case may be. No change of keys is allowed.
        <br />
        <strong>(7) DAMAGE TO THE UNIVERSITY PROPERTY.</strong><br />
        Any student who damages any university property is being held liable for the damages done or caused. Under extreme cases a student may be asked replace or pay the damage done or caused to the property.
        <br /><strong>(8) COOKING NOT PERMISSIBLE</strong><br />
          No cooking of any kind shall be allowed in the rooms or corridors.<br />
         Any Students caught cooking in the room or corridors will be deprived from the hostel accommodation and also face the student’s disciplinary committee.<br />

        <strong>(9) BUSINESS TRANSACTION</strong><br />
          Business transaction of any kind is prohibited in hostel. <br />
        <strong>(10) INSPECTION OF ROOMS</strong><br />
        The rooms shall be open for inspection by the hall admin and other officer of the university at any time, and any student obstructing such inspection or refusing the same shall be liable to disciplinary action and punishment, which may involve his permanent eviction from the hostel besides such other punishment as may be awarded to him by the University Disciplinary committee.<br />


        <strong>(11) PROPER USE OF FACILITIES</strong><br />
        The Students in the hostel shall use lavatories and bathrooms, urinals etc .properly and cause no damage to the various fixtures, these place of convenience must be use strictly and properly for the purposes they are meant. WCs must not be abused with hard paper, sticks or stones.  Students must not relieve themselves anywhere within the hostel surrounding except in the lavatories. Students who break these rules will face severe disciplinary action.
        <br /><strong>(12) AVOIDING OF WASTE</strong><br />
        The student shall avoid any wastage of electricity, water etc. and shall in no circumstances, leave their rooms with light or fans on.<br />
        <strong>(13) USE OF HEATERS/MUSIC SYSTEMS/MOTORIZED VEHICLE ETC</strong> <br />
        No student shall keep any type of motorized two wheelers/vehicles.<br />
        No student shall use high power music system and play such gadgets in a manner which may be prejudicial to the studies and comforts of any student in the hostel.<br />
        Use of heaters and other electrical equipment shall be prohibited.<br />
        <strong>(14) PROPER USE OF COMMON ROOM</strong><br />
        The student shall make proper use of the common room and not remove, misuse or damage any furniture or other material/equipment/gadgets.<br />
         <strong>(15) VISIT IN PROPER DRESS</strong><br />
        Student are expected to visit common room, and places outside the hostel in proper dress.<br />
        <strong>(16) PREGNANCY </strong> <br />
        Student who become pregnant during the course of studies are advised to obtain adequate medical attention from appropriate places and to inform the matron. For health reasons, pregnant students are required to vacate the hostel at least twelve weeks (12) before delivery and should not return until they are declared medically fit to continue with their studies. Mothers are not allowed to stay with babies in the hostel.<br />
        <strong>(17) PETS</strong><br />
        For health and sanitary reasons pets like birds, fish, cats, dogs, and reptiles are strictly prohibited in and around the hostel area.<br />
        <strong>(18) SECURITY OF PROPERTY</strong><br />
        All university property must be handle with care by any student; any damage or breakage to any of the university property must be repaired or paid for by the student involved. Student in possession of large sums of money are advised in their own interest to open an account with a bank of their own choice because the university will not guarantee the safety of their money. <br />
        <strong>(19) ACT OF  INDISCIPLINE</strong><br />
        All regulation applicable to the other hostel shall also apply to the girl’s hostel unless they are barred or modified by the above special regulations, the following shall constitute acts of indiscipline:<br />
        Keeping, carrying, using or supplying of any fire arms, lethal weapons, knife in the room or outside.
        Keeping, using or supplying intoxicants in any form. Gambling in any form.
        Ragging, harassing of students. Demonstration in any form including procession and meeting strike or hunger strike.
        Attending or organizing unauthorized meeting and participation in such meeting.
        Displaying notices, leaflets, or posters, not signed or countersigned by university officer.
        Boycotting of a University function, Programme, activity or preventing any student from attending to classes’ functions, programme or any other activity of the University.
        Recourse of violence, assault, intimidation, rioting, or any misbehavior or intimidation of an employee of the university. Incitement to commit any act of indiscipline. Any breach of law of the country, rules and regulations of the University, Disturbing other student in their studies. Damaging any university property, Disorderly behavior in any form.

        <br /><strong>(20) RETURN OF HOSTEL PROPETY</strong><br />
         All hostel properties issued to the student shall    be returned to the porter, otherwise he/she shall be liable for charges equal to the cost of the property issued to them.
</p>

    </div>
    </div>
    
</body>

</html>