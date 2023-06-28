<?php
                            include('Crypto.php');
                            error_reporting(0);
                            $workingKey='9C5750B83E0A6B29B39ECF80C9B2B85E';     //Working Key should be provided here.
                            $encResponse=$_POST["encResp"];         //This is the response sent by the CCAvenue Server
                            $rcvdString=decrypt($encResponse,$workingKey);      //Crypto Decryption used as per the specified working key.
                            $order_status="";
                            $decryptValues=explode('&', $rcvdString);
                            $dataSize=sizeof($decryptValues);
                            
                            $year = (string)date("Y",strtotime("-1 year"));
                            $year1 = (string)substr(date('Y'), 2, 2);
                            $today = date("F j Y");
                            for($i = 0; $i < $dataSize; $i++) 
                            {
                                $information=explode('=',$decryptValues[$i]);
                                
                                if($i==3)   $order_status=$information[1];
                                
                                if($i==0)    $order_id=$information[1];
                                if($i==40)   $trans_date=date("F j Y");
                                if($i==11)   $billing_name=$information[1];
                                if($i==26)   $merchant_param1=$information[1];
                                if($i==27)   $merchant_param2=$information[1];
                                if($i==17)   $billing_tel=$information[1];
                                if($i==18)   $billing_email=$information[1];
                                if($i==12)   $billing_address=$information[1];
                                if($i==13)   $billing_city=$information[1];
                                if($i==14)   $billing_state=$information[1];
                                if($i==15)   $billing_zip=$information[1];
                                if($i==16)   $billing_country=$information[1];
                                if($i==10)   $amount=$information[1];
                                if($i==9)    $currency=$information[1];
                                if($i==1)   $tracking_id=$information[1];
                            } 
                            if($order_status==="Success")
                            {
                            //Amount number   Aborted
                               $number = $amount;
                               $no = floor($number);
                               $point = round($number - $no, 2) * 100;
                               $hundred = null;
                               $digits_1 = strlen($no);
                               $i = 0;
                               $str = array();
                               $words = array('0' => '', '1' => 'one', '2' => 'two',
                                '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
                                '7' => 'seven', '8' => 'eight', '9' => 'nine',
                                '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
                                '13' => 'thirteen', '14' => 'fourteen',
                                '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
                                '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
                                '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
                                '60' => 'sixty', '70' => 'seventy',
                                '80' => 'eighty', '90' => 'ninety');
                               $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
                               while ($i < $digits_1) {
                                 $divider = ($i == 2) ? 10 : 100;
                                 $number = floor($no % $divider);
                                 $no = floor($no / $divider);
                                 $i += ($divider == 10) ? 1 : 2;
                                 if ($number) {
                                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                                    $str [] = ($number < 21) ? $words[$number] .
                                        " " . $digits[$counter] . $plural . " " . $hundred
                                        :
                                        $words[floor($number / 10) * 10]
                                        . " " . $words[$number % 10] . " "
                                        . $digits[$counter] . $plural . " " . $hundred;
                                 } else $str[] = null;
                              }
                              $str = array_reverse($str);
                              $result = implode('', $str);
                              $points = ($point) ?
                                "." . $words[$point / 10] . " " . 
                                      $words[$point = $point % 10] : '';
                            
                            include_once('tcpdf/tcpdf.php');
                            //----- Code for generate pdf
                            $pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
                            $pdf->SetCreator(PDF_CREATOR);  
                            //$pdf->SetTitle("Export HTML Table data to PDF using TCPDF in PHP");  
                            $pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
                            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
                            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
                            $pdf->SetDefaultMonospacedFont('helvetica');  
                            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
                            $pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
                            $pdf->setPrintHeader(false);  
                            $pdf->setPrintFooter(false);  
                            $pdf->SetAutoPageBreak(TRUE, 10);  
                            $pdf->SetFont('helvetica', '', 12);  
                            $pdf->AddPage(); //default A4
                            //$pdf->AddPage('P','A5'); //when you require custome page size 
                            
                            $content = ''; 

                            $content .= '
                            
                           <table style="width: 100%" cellpadding="0">
        <tr style="line-height: 0">
            <td style="width: 37%"></td>
            <td style="width: 30%"><img src="logo.png" alt="" style="width: 100px;margin: 0 auto;display: table-cell;"></td>
            <td></td>
        </tr>
        <tr style="line-height: 70%;">
            <td style="width: 100%">
                <h1 style="color: #38a28b;text-align: center;margin-bottom: 10px;padding:0">ADHI RAKSHA WELFARE TRUST</h1>
            </td>
        </tr>
        <tr style="line-height: 65%;">
            <td style="width: 100%">
                <h5 style="color: #cb5a1b;font-weight: 400;text-align: center; font-size: 14px;">Registration Number: 42 / 2021</h5>
                <h5 class="sub-title" style="color: #cb5a1b;font-weight: 400;text-align: center; font-size: 14px;">PAN # AAITA4754B </h5>
            </td>
        </tr>
        <tr style="line-height: 70%;">
            <td style="width: 100%">
                <p style="color: #406467;text-align: center;font-size: 12px;margin-top: 10px;font-weight: 100;">21/8, Door no.1, Vijaya apartments, Sadhulla street, T Nagar, Chennai. 600017.</p>
                <p style="color: #406467;text-align: center;font-size: 12px;margin-top: 10px;font-weight: 100;">Email: adhirakshawelfaretrust@gmail.com - Website: www.adhirakshawelfaretrust.com</p>
            </td>
        </tr>
        <tr style="line-height: 60%;">
            <td style="width: 100%"><p style="border-bottom: 1px dashed #cb5a1b;"></p></td>
        </tr>
        <tr style="line-height: 60%;">
            <td style="width: 100%">
                <h1 style="color: #cb5a1b;text-align: center;margin-bottom: 10px;padding:0">80G DONATION RECEIPT</h1>
            </td>
        </tr>
        <tr>
            <td style="width: 100%">
                <h2 style="color: #333;text-align: center;font-size: 11px; font-weight:100">Exemption U/S 80G of IT Act 1961 vide URN: AAITA4754BF20219 </h2>
            </td>
        </tr>
        
        <tr>
            <td style="width: 5%"></td>
            <td style="width: 20%">
                <h2 style="color: #333;text-align: left;font-size: 11px;">Receipt Number: </h2>
                <h2 style="color: #333;text-align: left;font-size: 11px;">Issue Date: </h2>
            </td>
            <td style="width: 60%">
                <h2 style="color: #333;text-align: left;font-size: 11px; font-weight:100"> <span></span>  '.$year.' - '.$year1.' / W'. $order_id .'  </h2>
                <h2 style="color: #333;text-align: left;font-size: 11px; font-weight:100"> <span></span> '. $trans_date .' </h2>
            </td>
        </tr>
        <tr>
            <td style="width: 5%"></td>
            <td  style="width: 90%">
               <h2 style="color: #333;text-align: left;font-size: 11px;">Dear '. $billing_name .'</h2>
            </td>
        </tr>
        
        <tr style="line-height: 50%;">
            <td style="width: 5%"></td>
            <td style="width: 20%">
                <h2 style="color: #333;text-align: left;font-size: 11px;">'. $merchant_param1 .': </h2>
            </td>
            <td style="width: 60%">
                <h2 style="color: #333;text-align: left;font-size: 11px; font-weight:100">'. $merchant_param2 .' </h2>
            </td>
        </tr>
        <tr style="line-height: 70%;">
            <td style="width: 5%"></td>
            <td style="width: 20%">
                <h2 style="color: #333;text-align: left;font-size: 11px;">Phone No.: </h2>
            </td>
            <td style="width: 60%">
                <h2 style="color: #333;text-align: left;font-size: 11px; font-weight:100">'. $billing_tel .' </h2>
            </td>
        </tr>
        
        <tr style="line-height: 70%;">
            <td style="width: 5%"></td>
            <td style="width: 20%">
                <h2 style="color: #333;text-align: left;font-size: 11px;line-height: 13px">Address:  </h2>
            </td>
            <td style="width: 60%">
                <h2 style="color: #333;text-align: left;font-size: 11px; font-weight:100; line-height: 13px">'.$billing_address.", " .$billing_city.', '.$billing_state.", " .$billing_country.", ".$billing_zip.'</h2>
            </td>
        </tr>
        

        <tr style="line-height: 70%;">
            <td style="width: 100%">
                <h2 style="color: #333;text-align: center;font-size: 11px; font-weight:100">We thankfully acknowledge the receipt of your donation, a sum of </h2>
            </td>
        </tr>
</table>
<table style="width: 100%">
        <tr><td></td></tr>
        <tr>
            <td style="width:10%"></td>
            <td style="width:80%;background-color: #fff2cc">
                <h1 style="text-align: center;">'.$currency.' '. $amount .'</h1>
                <h4 style="text-align: center;margin-left: 45%;background: #fff;width: 25%;padding-right: 10%;padding-top: 10px;padding-bottom: 10px;">'.ucwords($result) . "Rupees  " . ucwords($points) . " Only".'</h4>
                <h6></h6>
            </td>
            <td style="width:10%"></td>
        </tr>
</table>
<table style="width:100%">
        <tr>
            <td>
            <h6 style="color: #333;font-size: 11px;font-weight:100">Vide Online Transfer Transaction ID '. $tracking_id .' Dated '. $trans_date .' towards Donation</h6>
            </td>
        </tr>
        <tr><td align="right">
            <h1></h1>
            <h6 style="color: #333;text-align: right;font-size: 11px;font-weight:100">for ADHI RAKSHA WELFARE TRUST</h6>
            <img src="signature.png" alt="" style="width: 50px;">
            <h6 style="color: #333;text-align: right;font-size: 11px;font-weight:100">Signed by Authorised Signatory</h6>
            </td>
        </tr>
        
</table>'; 
                        $pdf->writeHTML($content);

                        $file_location = "/home/adhiraks/public_html/donate-now/uploads/"; //add your full path of your server
                        //$file_location = "/opt/lampp/htdocs/examples/generate_pdf/uploads/"; //for local xampp server

                        $datetime=date('dmY_hms');
                        $file_name = "INV_".$datetime.".pdf";
                        ob_end_clean();

                        $pdf->Output($file_location.$file_name, 'F'); // F means upload PDF file on some folder
                        //echo "Email send successfully!!";
                            error_reporting(E_ALL ^ E_DEPRECATED);  
                            include_once('PHPMailer/class.phpmailer.php');  
                            require ('PHPMailer/PHPMailerAutoload.php');

                            $body='';
                            $body .="<html>
                            <head>
                            <style type='text/css'> 
                            body {
                            font-family: Calibri;
                            font-size:16px;
                            color:#000;
                            }
                            </style>
                            </head>
                            <body>
                            Dear $billing_name,
                            <br><br>
                            We would like to express our sincere gratitude for your contribution to our trust. Your donation is very important to us. It helps us to continue our commitment to serving the community. 
                            <br><br>
                            Please find attached 80G Donation Receipt copy.
                            <br><br><br>
                            Yours sincerely, <br><br>
                            Mr. S. Raghu<br>
                            Chairman, <br>
                            Adhi Raksha Welfare Trust
                            </body>
                            </html>";

                            $mail = new PHPMailer();
                            $mail->CharSet = 'UTF-8';
                            $mail->IsMAIL();
                            $mail->IsSMTP();
                            $mail->Subject    = "Online Payment Receipt";
                            $mail->From = "receipts.adhirakshawelfaretrust@gmail.com";
                            $mail->FromName = "Adhi Raksha Welfare Trust";
                            $mail->IsHTML(true);
                            $mail->AddAddress($billing_email); // To mail id
                            // $to= $billing_email;
                            // $addr = explode(',',$to);
                            // foreach ($addr as $ad) {
                            //     $mail->AddAddress(trim($ad)); 
                            // }
                            //$mail->AddCC('info.shinerweb@gmail.com'); // Cc mail id
                            //$mail->AddBCC('info.shinerweb@gmail.com'); // Bcc mail id
                            //Set SMTP host name                          
                            $mail->Host = "smtp.gmail.com";
                            //Set this to true if SMTP host requires authentication to send email
                            $mail->SMTPAuth = true;                          
                            //Provide username and password     
                            $mail->Username = "receipts.adhirakshawelfaretrust@gmail.com";                 
                            $mail->Password = "msmiayxiewyejovp";                           
                            //If SMTP requires TLS encryption then set it
                            $mail->SMTPSecure = "tls";                           
                            //Set TCP port to connect to
                            $mail->Port = 587;   
                            $mail->AddAttachment($file_location.$file_name);
                            $mail->MsgHTML ($body);
                            $mail->WordWrap = 50;
                            $mail->Send();  
                            $mail->SmtpClose();
                            if($mail->IsError()) {
                        //  echo "Mailer Error: " . $mail->ErrorInfo;
                            } else {
                        //      echo "Message sent!";                   
                            };
}
else{
    
    //echo "Email send successfully!!";
                            error_reporting(E_ALL ^ E_DEPRECATED);  
                            include_once('PHPMailer/class.phpmailer.php');  
                            require ('PHPMailer/PHPMailerAutoload.php');

                            $body='';
                            $body .="<html>
                            <head>
                            <style type='text/css'> 
                            body {
                            font-family: Calibri;
                            font-size:16px;
                            color:#000;
                            }
                            </style>
                            </head>
                            <body>
                            Dear $billing_name,
                            <br><br>
                            Your online payment has been failed., Please contact our team. Further details our E-mail Id: adhirakshawelfaretrust@gmail.com, Mobile number:- +91-9884400422
                            <br><br>
                            Yours sincerely, <br><br>
                            Mr. S. Raghu<br>
                            Chairman, <br>
                            Adhi Raksha Welfare Trust
                            </body>
                            </html>";

                            $mail = new PHPMailer();
                            $mail->CharSet = 'UTF-8';
                            $mail->IsMAIL();
                            $mail->IsSMTP();
                            $mail->Subject    = "Online Payment";
                            $mail->From = "receipts.adhirakshawelfaretrust@gmail.com";
                            $mail->FromName = "Adhi Raksha Welfare Trust";
                            $mail->IsHTML(true);
                            $mail->AddAddress($billing_email); // To mail id
                            // $to= $billing_email;
                            // $addr = explode(',',$to);
                            // foreach ($addr as $ad) {
                            //     $mail->AddAddress(trim($ad)); 
                            // }
                            //$mail->AddCC('info.shinerweb@gmail.com'); // Cc mail id
                            //$mail->AddBCC('info.shinerweb@gmail.com'); // Bcc mail id
                            //Set SMTP host name                          
                            $mail->Host = "smtp.gmail.com";
                            //Set this to true if SMTP host requires authentication to send email
                            $mail->SMTPAuth = true;                          
                            //Provide username and password     
                            $mail->Username = "receipts.adhirakshawelfaretrust@gmail.com";                 
                            $mail->Password = "msmiayxiewyejovp";                           
                            //If SMTP requires TLS encryption then set it
                            $mail->SMTPSecure = "tls";                           
                            //Set TCP port to connect to
                            $mail->Port = 587;   
//                            $mail->AddAttachment($file_location.$file_name);
                            $mail->MsgHTML ($body);
                            $mail->WordWrap = 50;
                            $mail->Send();  
                            $mail->SmtpClose();
                            if($mail->IsError()) {
                        //  echo "Mailer Error: " . $mail->ErrorInfo;
                            } else {
                        //      echo "Message sent!";                   
                            };
    
    
    
}
                        //----- End Code for generate pdf
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Adhi Raksha Welfare Trust</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="icon" href="https://adhirakshawelfaretrust.com/wp-content/uploads/2021/09/cropped-ARWT-logo-32x32.jpg" sizes="32x32" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" href="https://adhirakshawelfaretrust.com/wp-content/uploads/2021/09/cropped-ARWT-logo-32x32.jpg" sizes="32x32" />
    <style>
        * {
            font-family: 'Roboto', sans-serif;
        }
        .bg {
            background-color: #6c7bee;
            width: 480px;
            overflow: hidden;
            margin: 0 auto;
            box-sizing: border-box;
            padding: 40px;
            font-family: 'Roboto';
            margin-top: 40px;
        }

        .card {
            background-color: #fff;
            width: 100%;
            float: left;
            margin-top: 40px;
            border-radius: 5px;
            box-sizing: border-box;
            padding: 80px 30px 25px 30px;
            text-align: center;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        }

        .card__success,
        .card__failed {
            position: absolute;
            top: -50px;
            left: 145px;
            width: 100px;
            height: 100px;
            border-radius: 100%;
            background-color: #60c878;
            border: 5px solid #fff;
        }

        .card__failed {
            background-color: #FF0000 !important;
        }

        .card__success i,
        .card__failed i {
            color: #fff;
            line-height: 90px;
            font-size: 45px;
        }

        .card__msg {
            text-transform: uppercase;
            color: #55585b;
            font-size: 18px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .card__submsg {
            color: #959a9e;
            font-size: 16px;
            font-weight: 400;
            margin-top: 0px;
        }

        .card__body {
            background-color: #f8f6f6;
            border-radius: 4px;
            width: 100%;
            margin-top: 30px;
            float: left;
            box-sizing: border-box;
            padding: 30px;
        }

        .card__avatar {
            width: 50px;
            height: 50px;
            border-radius: 100%;
            display: inline-block;
            margin-right: 10px;
            position: relative;
            top: 7px;
        }

        .card__recipient-info {
            display: inline-block;
        }

        .card__recipient {
            color: #232528;
            text-align: left;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .card__email {
            color: #838890;
            text-align: left;
            margin-top: 0px;
        }

        .card__price {
            color: #232528;
            font-size: 70px;
            margin-top: 25px;
            margin-bottom: 30px;
        }

        .card__price span {
            font-size: 60%;
        }

        .card__method {
            color: #d3cece;
            text-transform: uppercase;
            text-align: left;
            font-size: 11px;
            margin-bottom: 5px;
        }

        .card__payment {
            background-color: #fff;
            border-radius: 4px;
            width: 100%;
            height: 100px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card__credit-card {
            width: 50px;
            display: inline-block;
            margin-right: 15px;
        }

        .card__card-details {
            display: inline-block;
            text-align: left;
        }

        .card__card-type {
            text-transform: uppercase;
            color: #232528;
            font-weight: 600;
            font-size: 12px;
            margin-bottom: 3px;
        }

        .card__card-number {
            color: #838890;
            font-size: 12px;
            margin-top: 0px;
        }

        .card__tags {
            clear: both;
            padding-top: 15px;
        }

        .card__tag {
            text-transform: uppercase;
            background-color: #f8f6f6;
            box-sizing: border-box;
            padding: 3px 5px;
            border-radius: 3px;
            font-size: 10px;
            color: #d3cece;
        }

        #collapsibleNavbar a {
            background: #c76131;
            color: white;
            font-weight: bold;
            font-size: small;
            border-radius: 25px;
            padding-top: 5px;
            padding-bottom: 5px;
            font-size: 15px
        }

        #collapsibleNavbar li {
            padding-left: 2px;
        }

        .top-bar {
            background-color: #363537;
        }

        .mail-me {
            list-style-type: none;
            margin-bottom: 0;
        }

        .mail-me li {
            display: inline-block;
        }

        .mail-me li a {
            color: #fff;
            text-decoration: none;
            font-size: 13px
        }

        .bg-shadow {
            -webkit-box-shadow: 0 1px 10px -6px rgb(0 0 0 / 42%), 0 1px 10px 0 rgb(0 0 0 / 12%), 0 4px 5px -2px rgb(0 0 0 / 10%);
            box-shadow: 0 1px 10px -6px rgb(0 0 0 / 42%), 0 1px 10px 0 rgb(0 0 0 / 12%), 0 4px 5px -2px rgb(0 0 0 / 10%)
        }

        .wp-block-button__link {
            color: darkorange;
            background-color: #32373c;
            border-radius: 9999px;
            box-shadow: none;
            cursor: pointer;
            display: inline-block;
            font-size: 1.125em;
            padding: calc(0.667em + 2px) calc(1.333em + 2px);
            text-align: center;
            text-decoration: none;
            overflow-wrap: break-word;
            box-sizing: border-box;
            margin-top: 15px
        }

        .wp-block-button__link:hover {
            color: #fff
        }

        .bottom {
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="top-bar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <ul class="mail-me">
                        <li><a href=""><i class="fa fa-envelope-o" aria-hidden="true"></i> adhirakshawelfaretrust@gmail.com</a></li>
                        <li><a href=""><i class="fa fa-phone" aria-hidden="true"></i> +91-9884400422</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="text-right" style="text-align: right">
                        <div class="textwidget custom-html-widget"><a href="https://www.facebook.com/adhirakshawelfaretrust" target="”_blank”" style="font-size:20px; padding-right:10px; color:#4267B2;" rel="noopener"><i class="fa fa-facebook"></i></a><a href="https://www.twitter.com/AdhiTrust" target="”_blank”" style="font-size:20px; padding-right:10px; color:skyblue;" rel="noopener"><i class="fa fa-twitter"></i></a><a href="https://www.instagram.com/adhirakshawelfaretrust" target="”_blank”" style="font-size:20px; padding-right:10px; color:#8a3ab9" rel="noopener"><i class="fa fa-instagram"></i></a><a href="https://www.youtube.com/adhirakshawelfaretrust" target="”_blank”" style="font-size:20px; padding-right:10px; color:#FF0000" rel="noopener"><i class="fa fa-youtube"></i></a></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <nav class="navbar navbar-expand-sm bg-shadow">
        <div class="container-fluid">
            <a class="navbar-brand" href="https://adhirakshawelfaretrust.com/"><img src="adhiraksha_logotitle.png" width="65%" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="https://adhirakshawelfaretrust.com/" role="button" data-bs-toggle="dropdown">About Us </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="https://adhirakshawelfaretrust.com/team/">Team</a></li>
                            <li><a class="dropdown-item" href="https://adhirakshawelfaretrust.com/contact-us/">Contact Us</a></li>
                            <li><a class="dropdown-item" href="https://adhirakshawelfaretrust.com/donor-details/">Donor Details</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a title="Projects" href="https://adhirakshawelfaretrust.com/blog/" class="nav-link">Projects</a>
                    </li>
                    <li class="nav-item"><a title="Testimonials" href="https://adhirakshawelfaretrust.com/testimonials/" class="nav-link">Testimonials</a></li>
                    <li class="nav-item"><a title="Events" href="https://adhirakshawelfaretrust.com/gallery/" class="nav-link">Events</a></li>
                    <li class="nav-item"><a title="Newsletters" href="https://adhirakshawelfaretrust.com/newsletters/" class="nav-link">Newsletters</a></li>
                    <li class="nav-item"><a title="Donate" href="https://adhirakshawelfaretrust.com/donate/" class="nav-link">Donate</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="https://adhirakshawelfaretrust.com/legal/" role="button" data-bs-toggle="dropdown">Legal</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="https://adhirakshawelfaretrust.com/terms-conditions/">Terms &amp; Conditions</a></li>
                            <li><a class="dropdown-item" href="https://adhirakshawelfaretrust.com/privacy-policy-2/">Privacy Policy</a></li>
                            <li><a class="dropdown-item" href="https://adhirakshawelfaretrust.com/refund-policy/">Refund Policy</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="clearfix"></div>
                <div class="bg">
                    <div class="card">
                        <?php 
                            if($order_status==="Success"){?>
                        <span class="card__success"><i class="fa fa-check-circle"></i></span>

                        <h1 class="card__msg">Payment Complete</h1>
                        <h2 class="card__submsg">Thank you for your transfer</h2>

                        <div class="card__tags">
                            <span class="card__tag">completed</span>
                            <span class="card__tag">#<?php echo $tracking_id; ?></span>
                        </div>
                        <?php } 
                            if($order_status==="Aborted"){
                            ?>
                        <span class="card__failed"><i class="fa fa-times-circle"></i></span>
    
                        <h1 class="card__msg">Payment Failed </h1>
                        
                        <h2 class="card__submsg">We will keep you posted regarding the status of your order through e-mail</h2>

                        <div class="card__tags">
                            <span class="card__tag">Failed</span>
                            <span class="card__tag">#<?php echo $tracking_id; ?></span>
                        </div>
                        <?php }
                            if($order_status==="Failure"){?>
                        <span class="card__failed"><i class="fa fa-times-circle"></i></span>

                        <h1 class="card__msg">Payment Failed</h1>
                        <h2 class="card__submsg">However,the transaction has been declined.</h2>

                        <div class="card__tags">
                            <span class="card__tag">Failed</span>
                            <span class="card__tag">#<?php echo $tracking_id; ?></span>
                        </div>
                        <?php }
                        if($order_status==="Failure"){?>
                        <span class="card__failed"><i class="fa fa-times-circle"></i></span>

                        <h1 class="card__msg">Error</h1>
                        <h2 class="card__submsg">Security Error. Illegal access detected.</h2>

                        <div class="card__tags">
                            <span class="card__tag">Failed</span>
                            <span class="card__tag">#<?php echo $tracking_id; ?></span>
                        </div>
                        <?php
                        }
                            ?>
                    </div>
                    <div style="margin-bottom:40px">
                        
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="mt-5 bg-dark text-white">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="v-counter" style="line-height: 4;">
                        <span>Total Visitors: </span>
                        <span class="count-holder" style="background-color:#C76131; color:#D3D3D3"><?php include('count2.php'); ?></span>
                    </div>
                </div>
                <div class="col-md-4"><a class="wp-block-button__link" href="https://adhirakshawelfaretrust.com/privacy-policy-2/">Privacy Policy</a> <a class="wp-block-button__link" href="https://adhirakshawelfaretrust.com/terms-conditions/">Terms &amp; Conditions</a></div>
                <div class="col-md-4">
                    <p style="text-align: right;line-height: 4">© Adhi Raksha Welfare Trust 2022</p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>