
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New Order</title>
</head>

<body style="background:#f1f1f1;padding-top:20px;padding-bottom:20px;">
    <center>
        <table class="" border="0" cellspacing="0" cellpadding="0" width="600"
            style="max-width:600px;background-color:#ffffff; border-collapse:collapse">
            <tbody>
                <tr>
                    <td height="50"></td>
                </tr>
                
                <tr>
                    <td style="padding-left:20px;" align="center">
                        <p style="margin:5px 0px 5px 0px;font-weight:600;font-size:36px;"><span style="color:#004000;">New Order</span></p>
                    </td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
                <tr>
                    <td style="text-align:center; font-size: 24px;">Hello! {{$name}} Please manage new order.</td>
                </tr>
                <tr style="margin-top: 20px;">
                    <td style="padding-left:20px;">                        
                        <table>
                            <tr>
                                <td>Invoice ID:</td>
                                <td style="padding-left: 20px;">{{ $invoice_id }}</td>
                            </tr>
                            <tr>
                                <td>Number Of Tickets:</td>
                                <td style="padding-left: 20px;">{{ $number_of_ticket }}</td>
                            </tr>
                            <tr>
                                <td>Amount Of Bitcoin:</td>
                                <td style="padding-left: 20px;">{{ $price_in_bitcoin }} BTC</td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td style="padding-left: 20px;">{{ $address }}</td>
                            </tr>                            
                        </table>
                    </td>

                </tr>         
                <tr>
                    <td height="10"></td>
                </tr>
               
                <tr>
                    <td style="padding-left:20px;">
                        <p style="margin:5px 0px 5px 0px;font-size:16px;color:#222;font-family: Montserrat;font-weight:500;">
                            For any further assistance contact our support team at &nbsp;&nbsp; <a
                                href="#" style="color:#0000ee;font-size:18px">contact@flowylottery.com</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;">
                        <p style="margin:5px 0px 5px 0px;font-size:18px;color:#222;font-family: Montserrat;font-weight:600;">
                            Sincerely
                        </p>
                    </td>
                </tr>

                <tr>
                    <td height="10"></td>
                </tr>
                <tr>
                    <td style="padding-left:20px;">
                        <p style="margin:5px 0px 5px 0px;font-size:18px;color:#222;font-family: Montserrat;font-weight:600;">
                            Flowy Lottery Team
                        </p>
                        <p style="margin:5px 0px 5px 0px;font-size:18px;color: #0738ca;font-family: Montserrat;font-weight:600;">
                            UK
                        </p>
                    </td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
            </tbody>
        </table>


    </center>
</body>

</html>