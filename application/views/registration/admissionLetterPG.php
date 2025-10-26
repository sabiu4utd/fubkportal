<html>

<head>
    <title>PG Admission Letter for <?php echo $info->firstname ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body class="m-1">
    <div class="container" style="width: 21cm; height: 29.70; border-radius: 8px; padding: 1px;">
        <section class="row">
            <img src="<?php echo base_url('/assets/images/fubk-icon.png')?>" class="float-left" style="width: 4cm; height: 3cm;" />
            <span class="header-text float-right text-center" style="width: 17cm;">
                <div style="font-weight: 900; font-size: 34px;">FEDERAL UNIVERSITY BIRNIN KEBBI</div>
                <div style="font-size:18; margin-top: -10px;">PMB 1157, BIRNIN KEBBI, KEBBI STATE, NIGERIA</div>
                <div style="font-family: Impact, Haettenschweiler, 'Arial Narrow Bold', sans-serif; font-size: 25px; margin-top: -5px;">POSTGRADUATE SCHOOL</div>
                <div style="display: flex; justify-content: space-evenly; font-size: 14px;">
                    <span><b>Email:</b> pgschool@fubk.edu.ng</span>
                    <span><b>Website:</b> https://fubk.edu.ng/pgschool</span>
                    <span><b>GSM:</b> +2348030723645</span>
                </div>
            </span>
            <hr style="margin-top: 4px; margin-left: 15px; margin-right: 15px; width: 97%;"/>
            <div style="display: flex; justify-content: space-evenly; font-size: 13px; margin-top: -15px;">
                <span><b>DEAN:</b> PROF. U.M CHAFE DVM MVSc, PhD</span>
                <span><b>DEPUTY DEAN:</b> PROF ALIYU ABDULLAHI TURAKI BSc, MSc (UDUS), PhD (Greenwich, UK)</span>
            </div>
            <hr style="margin-top: 4px; margin-left: 15px; margin-right: 13px; width: 97%;"/>
            <div style="display: flex; justify-content: space-evenly; font-size: 14.5px; margin-top: -15px;">
                <span><b>SECRETARY:</b> MUBARAK BELLO TUGA BA History (UDUS), PGDPA (NOUN), MPA (UDUS)</span>
            </div>
            <hr style="margin-top: 4px; margin-left: 15px; margin-right: 15px; width: 97%;"/>
        </section>
        <section class="row" style="padding:30px; font-size: 14; text-align: justify;">
            <div style="margin-bottom: 15PX;">
                <span style="float: left;"><?php echo trim('<b>'.strtoupper($info->surname.", ".$info->firstname." ".$info->othername)).'</b> ('.$info->pnumber.')'  ?></span>
                <span style="float: right;"><?php echo date('d/m/Y');?></span>
            </div>
            <div>
                <?php //var_dump($info);?>
                Dear Sir/Madam,<br><br>

                <div style="font-weight: bold; text-align: center; font-size: 14px;">OFFER OF PROVISIONAL ADMISSION TO HIGHER <?php echo $info->current_level == 700 ? "DIPLOMA": "DEGREE"; ?> FOR THE <?php echo $info->session_admitted; ?> ACADEMIC SESSION</div><br><br>

                I am pleased to inform you that your application for Postgraduate admission into Federal University Birnin Kebbi has been successful.<br><br>

                You have been offered provisional admission to pursue a Full-time course of study leading to the award of <b><?php echo $info->prog_abbr?></b> in the <b>Faculty of <?php echo $info->division_name;?></b>.<br><br>
                The programme will run for a minimum period of <?php echo $info->duration;?> semesters and maximum period of <?php echo $info->duration_de;?> semesters.<br><br>

                This offer is conditional upon the receipt of your academic transcript by the Postgraduate School and the confirmation of your qualification as listed by you in the application form.<br><br>

                You will be required to produce the original copies of all your academic qualifications and NYSC certificate for verification during registration. If at any time after admission it is discovered that you do not possess any of the qualifications upon which this offer of admission has been made, you will be required to withdraw from the University.<br><br>

                If you accept this offer on the conditions stated above, you will be required to electronically complete the enclosed acceptance of offer of admission form in duplicate and submit to the Secretary, Postgraduate School, Federal University Birnin Kebbi immediately. Registration commences on the 15<sup>th</sup> of May, 2023 and ends on the 29<sup>th</sup> of May, 2023. Late registration may not be allowed.<br><br>

                You can also download the schedule of registration fees for the 2022/2023 academic session on the Postgraduate School portal. You are required to purchase a copy each of the Postgraduate Student Handbook and the Book of Abstract of Thesis and Dissertations.<br><br>
                Congratulations.<br><br><br>
                <img src="<?php echo base_url('/assets/images/pg_signature.jpeg')?>" style="width: 110px;" /><br>
                <b>Mubarak B. Tuga</b><br>
                <i>Secretary, Postgraduate School</i> 
            </div>

        </section>
    </div>
</body>

</html>