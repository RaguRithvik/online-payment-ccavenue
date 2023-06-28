<?php
$min  = 1;
$max  = 10;
$num1 = rand( $min, $max );
$num2 = rand( $min, $max );
$sum  = $num1 + $num2;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Online Payment</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="select2.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="https://adhirakshawelfaretrust.com/wp-content/uploads/2021/09/cropped-ARWT-logo-32x32.jpg" sizes="32x32" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <link rel="stylesheet" href="style.css">


</head>

<body>

    <div class="container mt-5">
        <div class="row">

            <div class="col-md-2"></div>
            <div class="col-sm-8">
                <div id="Checkout" class="inline">
                    <h1>Donate Now</h1>
                    <div class="card-row">

                    </div>
                    <form method="post" action="ccavRequestHandler.php" class="row" onsubmit="return validateForm()" name="myForm" id="form">

                        <div class="col-md-4"></div>
                        <div class="form-group col-md-8">
                            <label for="PaymentAmount">Donate Amount</label>
                            <div class="amount-placeholder">
                                <span>Rs</span>
                                <span id="setamount">0.00</span>
                                <span id="ordid" class="hide"><?php include('count.php'); ?></span>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label or="NameOnCard">Donate an amount you wish <span class="red">*</span></label>
                            <select required class="form-control form-select" name="foodAmount" onchange="chooseAmount(this.value)" id="bred">
                                <option value="0.00">Choose Amount</option>
                                <option value="3000.00">Food for 50 people - ₹ 3,000.00</option>
                                <option value="6000.00">Food for 100 people - ₹ 6,000.00</option>
                                <option value="12000.00">Food for 200 people - ₹ 12,000.00</option>
                                <option value="0.00">Other(Minimum Rs 500)</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">Amount <span class="red" id="hishow">*</span></label>
                            <input class="form-control" type="text" id="amount" onblur="doValue(this.value)" name="amount" value="" readOnly>
                            <span class="red hide" id="amounthow">Minimum Rs 500</span>

                        </div>
                        <div class="col-md-12">
                            <hr>
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">Full Name <span class="red">*</span></label>
                            <input class="form-control" type="text" required name="billing_name" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">Email <span class="red">*</span></label>
                            <input class="form-control" type="email" required name="billing_email" value="" id="emailid" onblur="ValidateEmail(this.value)">
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">Mobile Number <span class="red">*</span></label><br />
                            <input class="form-control" type="text" required name="billing_tel" value="" id="billing_tel">
                            <span id="valid-msg" class="hide">Valid</span>
                            <span id="error-msg" class="hide red"></span>
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">ID Type <span class="red">*</span></label>
                            <select required class="form-control form-select" name="merchant_param1" onchange="changeId(this.value)" id="merchant_param1">
                                <option value=""></option>
                                <option value="PAN Number">PAN Number</option>
                                <option value="Aadhaar Number">Aadhaar Number</option>
                                <option value="Driving License">Driving License</option>
                                <option value="Passport Number">Passport Number</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">ID Number <span class="red">*</span></label>
                            <input class="form-control" type="text" required name="merchant_param2" value="" onblur="changeIdNumber(this.value)" id="merchant_param2">
                            <span id="aadhaarhide" class="hide"> Aadhaar Format:- 484950515253</span>
                            <span id="panhide" class="hide"> PAN Format:- AAAAA9999A</span>
                        </div>
                        <input type="text" name="currency" value="INR" class="hide" />
                        <div class="form-group col-md-12">
                            <label or="NameOnCard">Address <span class="red">*</span></label>
                            <textarea class="form-control" required name="billing_address"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">Country <span class="red">*</span></label>
                            <select name="billing_country" class="countries form-control form-select js-searchBox" id="countryId" required>
                                <option value="">Select Country</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">State </label>
                            <select name="billing_state" class="states form-control form-select js-searchBox1" id="stateId">
                                <option value="">Select State</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">City </label>
                            <select name="billing_city" class="cities form-control form-select js-searchBox2" id="cityId">
                                <option value="">Select City</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label or="NameOnCard">Zip (PinCode) </label>
                            <input class="form-control" type="text" name="billing_zip">
                        </div>

                        <input type="text" name="tid" id="tid" class="hide" />
                        <input type="text" name="merchant_id" value="" class="hide" />
                        <input type="text" name="order_id" id="order_id" class="hide" />

                        <input type="date" name="trans_date" class="hide" />
                        <input type="text" name="redirect_url" value="success4.php" class="hide" />
                        <input type="text" name="cancel_url" value="success4.php" class="hide" />
                        <input type="text" name="language" value="EN" class="hide" />

                        <div class="col-12">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <label for="quiz" class="col-sm-3 col-form-label">
                                            <?php echo $num1 . '+' . $num2; ?>?
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="number" class="form-control quiz-control" id="quiz" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <span id="captcha" class="hide red">Please Verify Captcha</span>
                                </div>
                            </div>
                            <br>
                        </div>
                        
                        <div class="col-md-12">
                            <button id="PayButton" class="btn btn-block btn-success submit-button" type="submit" style="width: 100%; margin-top:10px;text-transform: uppercase;" data-res="<?php echo $sum; ?>">
                                <span class="submit-button-lock"></span>
                                <span class="align-middle">Donate</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="countrystatecity.js" type="text/javascript"></script>
    <script src="main.js" type="text/javascript"></script>
    <script>
        const phoneInputField = document.querySelector("#billing_tel");

        const phoneInput = window.intlTelInput(phoneInputField, {
            initialCountry: "IN", //change according to your own country.
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
        });
    </script>
    <script type="text/javascript">
        var input = document.querySelector("#billing_tel"),
            errorMsg = document.querySelector("#error-msg"),
            validMsg = document.querySelector("#valid-msg");

        // here, the index maps to the error code returned from getValidationError - see readme
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

        // initialise plugin
        var iti = window.intlTelInput(input, {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
        });

        var reset = function() {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        // on blur: validate
        input.addEventListener('blur', function() {
            reset();
            if (input.value.trim()) {
                if (iti.isValidNumber()) {
                    validMsg.style = "display:none"
                    validMsg.classList.remove("hide");

                } else {
                    input.classList.add("error");
                    var errorCode = iti.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                }
            }
        });

        // on keyup / change flag: reset
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    </script>
    <script type="text/javascript">
        const submitButton = document.querySelector('[type="submit"]');
        const quizInput = document.querySelector(".quiz-control");
        const captcha = document.getElementById("captcha");
        quizInput.addEventListener("input", function(e) {
            const res = submitButton.getAttribute("data-res");
            if (this.value == res) {
                submitButton.removeAttribute("disabled");
                captcha.style = "display:none"
            } else {
                submitButton.setAttribute("disabled", "");
                captcha.style = "display:block"
            }
        });
    </script>
    <script src="select-min.js"></script>
    <script>
        $(".js-searchBox").select2({
            placeholder: "Select Country",
            allowClear: true
        });
        $(".js-searchBox1").select2({
            placeholder: "Select State",
            allowClear: true
        });
        $(".js-searchBox2").select2({
            placeholder: "Select City",
            allowClear: true
        });
    </script>
</body>

</html>