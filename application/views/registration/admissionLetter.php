<?php //var_dump($info); die;?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            width: 21cm;
            height: 29.7cm;
            margin: 15mm 45mm 30mm 20mm;
            /* change the margins as you want them to be. */
        }
    </style>
</head>

<body style="border: 0.5px solid silver; margin:auto; height:auto; padding:30px">
    <img src="<?php echo base_url('assets/images/fubk-icon.png') ?>" alt="FUBK Logo" style="width: 150px; float:left">
    <center>
        <span style="text-align:center; font-size:25pt; font-family: stencil;">FEDERAL UNIVERSITY BIRNIN KEBBI</span><br />
        <span style="text-align:center; font-size:20pt">
            <?php echo $info->entrymode =="PG"? "(POSTGRADUATE SCHOOL)": "(OFFICE OF THE REGISTRAR)" ?></span><br />
        <span style="text-align:center; font-size:15pt">P.M.B 1157, KEBBI STATE NIGERIA</span>
    </center>
    <br />
    <br />
    <br />

    <?php
    if ($info->entrymode == 'DE') {
        $duration = $info->duration_de;
    } else {
        $duration = $info->duration;
    }
    ?>
<br>
    <span style="font-family:tahoma; font-size:15pt">
        <table>
        <tr><td><b>Admission Number:</b></td><td style="padding-left:10px"> <?php echo $info->pnumber; ?> </td></tr>
        <tr><td><b>Student's Name:</b></td><td style="padding-left:10px"> <?php echo strtoupper($info->surname). " " . ucwords(strtolower($info->firstname . " " . $info->othername)); ?> </td></tr>
        <tr><td><b>Programme:</b></td><td style="padding-left:10px"> <?php echo $info->prog_abbr; ?></td></tr>
        </table>
        
    </span>
<br /><br /><br />

    <h3 style="text-decoration: underline; text-align: center; font-family: tahoma; font-size:15pt"><?php echo $info->session_admitted; //$this->session->userdata('active_session'); ?> SESSION CONFIRMATION OF ADMISSION</h3>

    <div style="text-align: justify; font-size:15pt; font-family: tahoma; width:100%">
        This is to confirm that the above named has been admitted to read: <strong><?php echo $info->prog_abbr; ?></strong> for <strong><?php echo $duration ; ?></strong> <?php echo $info->entrymode =="PG"? "semesters": "years";?> with admission number <strong><?php echo $info->pnumber; ?></strong>. Relevant Units are requested to note and register the Candidate accordingly, subject to his/her acceptance of the undertaking below.


        <br /><br />
        Thank you.

        <br />
        <br />
        _____________________________<br />
        <?php echo $info->entrymode == "PG" ? "Secretary, Postgraduate School" : "For: Registrar"; ?>
        <br />
        <br />
        <h3 style="text-decoration: underline; text-align: center;">UNDERTAKING</h3>

        I <?php echo strtoupper($info->surname)." ".ucwords(strtolower($info->firstname." ".$info->othername));?> the undersigned, hereby accept the provisional admission offered to me. I further accept that the offer may be withdrawn by the University within the duration of the study if it is discovered that I have not satisfied the entry requirements or that my entry qualification is otherwise than as presented at the time of registration. <br /><br />

        To this end, I undertake to bring certified proof(s) of my qualification (e.g. <?php echo $info->entrymode == "PG" ? "O'Levels, A'Levels" : "SSCE, ND,"; ?> e.t.c) from awarding examination bodies within one year.<br /><br />

        Dated this <?php echo date("l jS M, Y"); ?>. <br /><br /><br />
        __________________ <br>Student's Signature


    </div>
</body>

</html>