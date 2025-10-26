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
    
</head>
<body class="font-muli theme-cyan gradient">
	<div class="auth option2 row" style="margin-top:10px">
        <div class="auth_left col-9">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <a class="header-brand" href="#">
                            <div class="card-title mt-3"><img src="<?php echo base_url();?>assets/images/university-logo.png"  style="width:200px"/></div>
                            <div class="card-title mt-2" style="font-size:24px">University Portal</div>
                            <div class="card-title mt-2" style="font-size:18px; color: #FF0000">
                                Please use this form to confirm and pay for your Graduation Gown, Alumni and/or Order of Proceedings
                            </div>
                        </a>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-12"><hr></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-9">
                                <input type="text" class="form-control text-center" placeholder="Enter Your University Admission Number " required name="admission_no" id="admission_no" minlength=10 maxlength=10 autocomplete="off">
                            </div>
                            <div class="col-md-3">
                                <button class="form-control btn btn-success" id="findRecords" >Find Records</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="loading" style="display:none;">
                        <div class="row">
                            <div class="col-12 text-center" style="color:#ff0000">Loading... Please Wait</div>
                        </div>
                    </div>
                    <div class="form-group" id="infoLoader" style="display:none;">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="text-center" style="padding-top:0px; padding-bottom:15px; font-size:17px">Graduant Information</div>
                                <table class="table table-stripped">
                                    <tr>
                                        <th>Graduant's Name:</th><td><span id="name">Loading...</span></td>
                                        <th>Admission Number:</th><td><span id="admission_number">Loading...</span></td>
                                    </tr>
                                    <tr>
                                        <th>Session Admitted:</th><td><span id="session_admitted">Loading...</span></td>
                                        <th>Session Graduated:</th><td><span id="session_graduated">Loading...</span></td>
                                    </tr>
                                    <tr>
                                        <th>Gender:</th><td><span id="gender">Loading...</span></td>
                                        <th>Entry Mode:</th><td><span id="mode">Loading...</span></td>
                                    </tr>
                                    <tr>
                                        <th>Programme:</th><td><span id="program">Loading...</span></td>
                                        <th>Status:</th><td><span id="status">GRADUATED</span></td>
                                    </tr>
                                    <tr>
                                        <th>Class of Degree:</th><td colspan="3"><span id="degree_class">Loading...</span></td>
                                    </tr>
                                    <tr>
                                        <th>Rent Graduation Gown:<br/><input type="checkbox" id="gown" name="gown" class="form-control" /></th>
                                        <td colspan="3">₦3,000.00</td>
                                    </tr>
                                    <tr>
                                        <th>Order of Proceedings:<br/><input type="checkbox" id="proceedings" name="proceedings" class="form-control" /></th>
                                        <td colspan="3">₦10,000.00 </td>
                                    </tr>
                                    <tr>
                                        <th>Alumni Fees:<br/><input type="checkbox" id="alumni" name="alumni" class="form-control" /></th>
                                        <td colspan="3">₦5,000.00 </td>
                                    </tr>
                                    <tr>
                                        <th>Total to Pay:</th>
                                        <td>₦<span id="total" name="total">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">
                                            <button class='btn btn-primary' id='generateInvoice'>Click to Generate Remita Invoice</button>
                                        </th>
                                        <th colspan="2">
                                            <span id='generatedInvoice'></span>
                                        </th>
                                    </tr>
                                </table>
                            </div>
                            <div class="text-muted mt-4"><hr></div>
                            
                            
                        </div>
                    </div>
                    <div class="form-group" id="infoErrorLoader" style="display:none;">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="text-center alert alert-danger" style="font-size:17px">Invalid Admission Number or No records found</div>
                                
                            </div>
                            <div class="text-muted mt-4"><hr></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="text-muted mt-4"><hr></div>
                        <div class="text-muted mt-1"><a href="<?php echo site_url('auth/login')?>">Click to Go back to the Portal </a></div>
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

        // Price constants
        const GOWN_PRICE = 3000;
        const PROCEEDINGS_PRICE = 10000;
        const ALUMNI_PRICE = 5000;

        // When "Find Records" button is clicked
        $("#findRecords").click(function() {
            $('#infoLoader').hide();
            $('#infoErrorLoader').hide();
            
            let admission_no = $("#admission_no").val();
            if (admission_no.length != 10){
                alert("Invalid Admission Number. Please check and try again");
            } else {
                $('#loading').show();
                $.post(
                    "<?php echo site_url('registration/loadGraduate');?>",
                    {admission_no: admission_no},
                    function(data, status){
                        $('#loading').hide();
                        if(data === "false"){
                            $('#infoErrorLoader').show();
                            $('#infoLoader').hide();
                            $('#infoErrorLoader').html('<div class="alert alert-danger text-center">Invalid Admission Number</div>');
                        } else {
                            $('#infoLoader').show();
                            $('#infoErrorLoader').hide();
                            let res = JSON.parse(data);

                            // Populate fields with response data
                            $("#name").html(res.name);
                            $("#admission_number").html(res.admission_no);
                            $("#session_admitted").html(res.session_admitted);
                            $("#session_graduated").html(res.session_graduated);
                            $("#gender").html(res.gender);
                            $("#mode").html(res.entrymode);
                            $("#program").html(res.degree_program);
                            $("#degree_class").html(res.degree_class);

                            updateTotal();
                        }
                    }
                );
            }
        });

        // Update total dynamically when checkboxes change
        $("#gown, #proceedings, #alumni").change(function() {
            updateTotal();
        });

        // Function to calculate the total amount
        function updateTotal() {
            let total = 0;

            if ($("#gown").is(":checked")) {
                total += GOWN_PRICE;
            }
            if ($("#proceedings").is(":checked")) {
                total += PROCEEDINGS_PRICE;
            }
            if ($("#alumni").is(":checked")) {
                total += ALUMNI_PRICE;
            }

            $("#total").html(total.toLocaleString('en-NG', { style: 'currency', currency: 'NGN' }));
        }

        // Generate Remita invoice
        $('#generateInvoice').click(function() {
            let admission_no = $("#admission_no").val();
            let totalAmount = $('#total').text().replace('₦', '').replace(',', '');

            $('#generatedInvoice').html('Generating Invoice, please wait...');

            $.post(
                "<?php echo site_url('registration/generateGraduantsInvoice');?>",
                {
                    admission_no: admission_no,
                    total_amount: totalAmount
                },
                function(data, status) {
                    $('#generatedInvoice').html("<strong>RRR Generated: </strong>" + data + "<br><a target='_blank' href='https://login.remita.net/remita/exapp/api/v1/send/api/print/billsvc/biller/"+data+"/printinvoiceRequest.pdf'><i class='fa fa-print'></i> Click here to print Invoice</a>");
                }
            );
        });
    });
</script>

</body>
</html>