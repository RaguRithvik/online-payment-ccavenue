const doValue = (value) => {
            var changeValue = document.getElementById("amount")
            if (isNaN(value)) {
                changeValue.value = "0.00";
                document.getElementById("setamount").innerHTML = changeValue.value
            } else {
                let calc = (Math.round(Number(value) * 100) / 100).toFixed(2)
                changeValue.value = calc
                document.getElementById("setamount").innerHTML = changeValue.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }
            if (Number(value) < 500) {
                document.getElementById("amount").style = "border-color:red"
                document.getElementById("amounthow").style = "display:block";
                return false
            } else {
                document.getElementById("amount").style = "border-color:#ced4da"
                document.getElementById("amounthow").style = "display:none";
                return true
            }
        }
        window.onload = function() {
            var d = new Date().getTime();
            document.getElementById("tid").value = d;
            document.getElementById("order_id").value = document.getElementById("ordid").innerHTML
        };
        const chooseAmount = (amount) => {
            if (amount !== "0.00") {

                var changeValue = document.getElementById("amount")
                changeValue.value = amount;
                changeValue.readOnly = true;
                let calc = (Math.round(Number(amount) * 100) / 100).toFixed(2)
                changeValue.value = calc
                document.getElementById("setamount").innerHTML = changeValue.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                document.getElementById("hishow").style = "display:none";
                document.getElementById("amount").style = "border-color:#ced4da"
                document.getElementById("amounthow").style = "display:none";

            } else {
                document.getElementById("amount").value = "0.00";
                document.getElementById("amount").readOnly = false;
                document.getElementById("setamount").innerHTML = "0.00";
                document.getElementById("hishow").style = "display:inline-block";
                document.getElementById("amount").style = "border-color:red"
            }
        }

        function validateForm() {

            let x = document.forms["myForm"]["amount"].value;
            var chooseamount = document.getElementById("bred")
            var chooseamount1 = document.getElementById("amount")
            var billing_tel = document.getElementById("billing_tel")
            const errorsg = document.getElementById("error-msg").innerHTML

            if (x == "0.00") {
                chooseamount.focus();
                return false;
            } else if (Number(x) < 500) {
                chooseamount1.focus();
                return false;
            } else if (x == "") {
                chooseamount.focus();
                return false;
            }
            if (errorsg !== "") {
                billing_tel.focus()
                return false;
            }
        }
        var idValue;
        const changeId = (value) => {
            idValue = value
            changeIdNumber(value)
        }
        const changeIdNumber = (aadhar) => {

            if (idValue == "") {
                document.getElementById("merchant_param2").style = "border-color:red";
            } else if (idValue == "Aadhaar Number") {
                var adharcardTwelveDigit = /^\d{12}$/;
                var adharSixteenDigit = /^\d{16}$/;
                if (aadhar != '') {
                    if (aadhar.match(adharcardTwelveDigit)) {
                        document.getElementById("merchant_param2").style = "border-color:#ced4da";
                        document.getElementById("aadhaarhide").style = "display:none";
                        return true;
                    } else if (aadhar.match(adharSixteenDigit)) {
                        document.getElementById("merchant_param2").style = "border-color:#ced4da";
                        document.getElementById("aadhaarhide").style = "display:none";
                        return true;
                    } else {
                        document.getElementById("merchant_param2").style = "border-color:red";
                        document.getElementById("aadhaarhide").style = "display:inline-block; color:red;font-size:14px";
                        document.getElementById("panhide").style = "display:none";
                        return false;
                    }
                }

            } else if (idValue == "PAN Number") {

                var panVal = document.getElementById("merchant_param2").value;
                var regpan = /^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;

                if (regpan.test(panVal)) {
                    document.getElementById("merchant_param2").style = "border-color:#ced4da";
                    document.getElementById("panhide").style = "display:none";
                    return true;
                } else {
                    document.getElementById("merchant_param2").style = "border-color:red";
                    document.getElementById("panhide").style = "display:inline-block; color:red;font-size:14px";
                    document.getElementById("aadhaarhide").style = "display:none";
                    return false;
                }
            } else {
                document.getElementById("aadhaarhide").style = "display:none";
                document.getElementById("panhide").style = "display:none";
                document.getElementById("merchant_param2").style = "border-color:red";
            }
            if (document.getElementById("merchant_param2").value.length > 0 && idValue == "Driving License" || document.getElementById("merchant_param2").value.length > 0 && idValue == "Passport Number") {
                document.getElementById("merchant_param2").style = "border-color:#ced4da";
            }
            //            var regpan1=/^(?=.*[a-zA-Z])|(?=.*\d).{5,}$/
            //            if (idValue == "Driving License" && !regpan1.test(document.getElementById("merchant_param2").value)) {
            //                document.getElementById("merchant_param2").style = "border-color:red";
            //            }

        }
        const ValidateEmail = (mail) => {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail)) {
                document.getElementById("emailid").style = "border-color:#ced4da";
                return (true);
            }
            document.getElementById("emailid").style = "border-color:red";
            return (false)
        }