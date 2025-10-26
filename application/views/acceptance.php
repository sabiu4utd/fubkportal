<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="<?php echo base_url()?>assets/images/favicon.ico" type="image/x-icon" />
    <title><?php echo $_SESSION['pageTitle']; ?></title>
    <link rel="stylesheet" href="<?php echo base_url()?>assets/plugins/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url()?>assets/css/style.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <script src="https://www.google.com/recaptcha/api.js?render=6Lc-pgseAAAAACDHAkWOeBm6RpQMX2bNTUJ750UB"></script>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7683315879221411"
     crossorigin="anonymous"></script>
    <script>
        // grecaptcha.ready(function() {
        //     grecaptcha.execute('6Lc-pgseAAAAACDHAkWOeBm6RpQMX2bNTUJ750UB', {action: 'submit'}).then(function(token) {
        //         //console.log(token);
        //         document.getElementById("g-token").value = token;
        //         if(token.length < 10) location.reload();
        //     });
        // });
    </script>
</head>
<body class="font-muli theme-cyan gradient">
	<div class="auth option2 row" style="margin-top:10px">
        <div class="auth_left col-9">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div class="header-brand" >
                            <div class="card-title mt-3"><img src="<?php echo base_url();?>assets/images/university-logo.png" style="width:250px" /></div>
                            <!--<div class="card-title mt-2" style="font-size:24px">University Portal</div>-->
                            <div class="card-title mt-2" style="font-size:18px; color: #000">
                                You are to pay your acceptance fee before coming to the University
                            </div>
                            <div class="card-title mt-1" style="font-size:14px; color: #FF0000">
                                Ensure that you have been given admission before you complete this form.
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12"><hr></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-9">
                                <input type="text" class="form-control text-center" placeholder="Enter Your JAMB or PG/SBS Application Number from eForms" required name="jamb_no" id="jamb_no" autocomplete="off">
                            </div>
                            <div class="col-3">
                                <button class="form-control btn btn-success" id="findRecords" >Find Records</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="loading" style="display:none;">
                        <div class="row">
                            <div class="col-12 text-center" style="color:#ff0000">Please Wait...</div>
                        </div>
                    </div>
                    <div class="form-group" id="infoLoader" style="display:none;">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="text-center" style="padding-top:0px; padding-bottom:15px; font-size:17px">Applicant Information</div>
                                <table class="table table-stripped">
                                    <tr>
                                        <th>Candidate Name:</th><td colspan="3"><span id="xfullname">Loading...</span></td>
                                    </tr>
                                    <tr>
                                        <th>Candidate's Number:</th><td><span id="xjambno">Loading...</span></td>
                                        <th>Session Applied:</th><td><span id="xsession">Loading...</span></td>
                                    </tr>
                                    <tr>
                                        <th>Gender:</th><td><span id="xgender">Loading...</span></td>
                                        <th>Entry Mode:</th><td><span id="xmode">Loading...</span></td>
                                    </tr>
                                    <tr>
                                        <th>Programme:</th><td><span id="xprogram">Loading...</span></td>
                                        <th>Department:</th><td><span id="xdept">Loading...</span></td>
                                    </tr>
                                    <tr>
                                        <th>Remita Reference:</th><td id="xrrr"></td>
                                        <th>Invoice Amount:</th><td  id="xamount"></td>
                                    </tr>
                                    <tr>
                                        <th>Being Paid for:</th>
                                        <td colspan="2"  id="xdesc"></td>
                                        <td id="xprint"></td>
                                    </tr>
                                    <tr>
                                        <th colspan="4" style="text-align:center; font-size:20px; color: black">Complete your details below to generate your invoice</th>
                                    </tr>
                                    <!--<form method='post' action="<?php echo site_url('registration/basic_update'); ?>" enctype="multipart/form-data">-->
                                    <tr>
                                        <th>Enter Email Address</th>
                                        <td>
                                            <input class="form-control" required type="email" name="email" id="email" placeholder="Enter your Email Address"/>
                                        </td>
                                        <th>Enter your Phone Number</th>
                                        <td>
                                             <input class="form-control" required  type="text" name="phone" id="phone" placeholder="Enter your Phone Number"/>
                                        </td>
                                       
                                    </tr>
                                    <tr>
                                        <th>Enter your NIN</th>
                                        <td>
                                            <input class="form-control" required type="text" name="nin" id="nin" placeholder="National Identity Verification Number (NIN)"/>
                                        </td>
                                        <th>Upload your photo</th>
                                        <td>
                                            <input type="file" required name="photo" id="photo" class="form-control" />
                                             
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td colspan=4>
                                            <input type='submit' value='Save' class='btn btn-dark btn-block' id="saveRecords" />
                                        </td>
                                    </tr>
                                    <!--</form>-->
                                </table>
                            </div>
                            <div class="text-muted mt-4"><hr></div>
                            <div class="card-body">
                                <h5>To Pay now, use the guide below:</h5>
                                <ul>
                                    <li>Click on the link <a target="_blank" href="https://login.remita.net/remita/onepage/biller/payment.spa">Here</a></li>
                                    <li>Click on the Pay E-Invoice Tab</li>
                                    <li>Enter the RRR displayed on your Invoice</li>
                                    <li>Click on Submit and proceed with steps</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="infoErrorLoader" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <div class="" style="padding-top:0px; padding-bottom:15px; font-size:22px; color:#FF0000">
                                    No Applicant found with this JAMB/Application Number.<br><br>
                                    <ol style="font-size:17px">
                                        <li>Please confirm the JAMB or Application Number is correct</li>
                                        <li>If in doubt, login to the forms portal <a href="https://eforms.fubk.edu.ng" target="_blank">here</a> to confirm your Application number</li>
                                        <li>Confirm that your name is on the Admission's List</li>
                                        <li>Please Email mis@fubk.edu.ng for further assistance</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-muted mt-4"><hr></div>
                        <div class="text-muted mt-1"><a href="<?php echo site_url('auth/login')?>">Click to Login </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url()?>assets/bundles/lib.vendor.bundle.js" type="e4a7806aed088581f862dd92-text/javascript"></script>
    <script src="<?php echo base_url()?>assets/js/core.js" type="e4a7806aed088581f862dd92-text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('#loading').hide();
            $('#infoLoader').hide();
            $('#infoErrorLoader').hide();
            
            $( "#findRecords" ).click(function() {
                $('#infoLoader').hide();
                $('#infoErrorLoader').hide();
                let jamb_no = $("#jamb_no").val()
                if (jamb_no.length < 8 || jamb_no.length > 20){
                    alert("Invalid JAMB/Applicant Number. Please check and try again")
                }else{
                    $('#loading').show();
                    $.post("<?php echo site_url('registration/generate');?>",
                    {jamb_no: jamb_no},
                    function(data, status){
                        $('#loading').hide();
                        console.log(data);
                        if(data == "false"){
                            $('#infoErrorLoader').show();
                            $('#infoLoader').hide();
                        }else{
                            $('#infoLoader').show();
                            $('#infoErrorLoader').hide();
                            
                            res = JSON.parse(data)
                            $("#xjambno").html(res["jamb_no"]);
                            $("#xsession").html(res["session_admitted"]);
                            $("#xgender").html(res["gender"]);
                            $("#xmode").html(res["entrymode"]);
                            $("#xfullname").html(res["surname"] + ", "+res["firstname"]+ " "+res["othername"]);
                            $("#xprogram").html(res["prog_abbr"]);
                            $("#xdept").html(res["dept"]);
                           if(res["passport"]!="default.jpg"){
                                 $("#xrrr").html(res["rrr"]);
                                 $("#xdesc").html(res["desc"]);
                                 $("#xamount").html('&#x20A6;'+res["amount"]);
                                 $("#xprint").html("<a target='_blank' href='https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/"+res["rrr"]+"/printinvoiceRequest.pdf'><i class='fa fa-print'></i> Print Invoice</a>");
                            } 
                           
                        }
                });
              }
            });
            
            $( "#saveRecords" ).click(function() {
                $('#infoLoader').hide();
                $('#infoErrorLoader').hide();
                let photo = $("#photo")[0].files;
                const form_data = new FormData();
                if(photo.length ===0){
                    alert("You have not uploaded photo");
                    return;
                }
                form_data.append("jamb_no", $("#jamb_no").val())
                form_data.append("nin", $("#nin").val())
                form_data.append("email", $("#email").val())
                form_data.append("phone", $("#phone").val())
                form_data.append("photo", photo[0])
               // alert(jamb_no)
                    $('#loading').show();
                    $.ajax({
                        url:"<?php echo site_url('registration/saveRecord');?>",
                        type:"post",
                        data:form_data,
                        contentType:false,
                        processData:false,
                        success:function(response){
                            console.log(response)
                        },
                        error:function(error){
                            console.log(error)
                        }
                        
                    })
                    // post("<?php echo site_url('registration/saveRecord');?>",
                    // form_data,
                    // function(data, status){
                    //     $('#loading').hide();
                    //     console.log(data);
                    //     if(data == "false"){
                    //         $('#infoErrorLoader').show();
                    //         $('#infoLoader').hide();
                    //     }else{
                    //         $('#infoLoader').show();
                    //         $('#infoErrorLoader').hide();
                            
                    //         res = JSON.parse(data)
                    //         $("#xjambno").html(res["jamb_no"]);
                    //         $("#xsession").html(res["session_admitted"]);
                    //         $("#xgender").html(res["gender"]);
                    //         $("#xmode").html(res["entrymode"]);
                    //         $("#xfullname").html(res["surname"] + ", "+res["firstname"]+ " "+res["othername"]);
                    //         $("#xprogram").html(res["prog_abbr"]);
                    //         $("#xdept").html(res["dept"]);
                    //         $("#xrrr").html(res["rrr"]);
                    //         $("#xdesc").html(res["desc"]);
                    //         $("#xamount").html('&#x20A6;'+res["amount"]);
                    //         $("#xprint").html("<a target='_blank' href='https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/"+res["rrr"]+"/printinvoiceRequest.pdf'><i class='fa fa-print'></i> Print Invoice</a>");
                    //     }
                    // });
                
            });
        });
    </script>
</body>
</html>