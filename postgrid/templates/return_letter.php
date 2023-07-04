<!DOCTYPE html>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clickpay Statement</title>


</head>
<body>
    <table style="width:794px; margin: 20px auto;font-family: system-ui;padding: 10px 15px;">
        <thead>
            <tr>
                <td style="vertical-align: top; width: 350px;">
                    &nbsp;
                </td>
                <td style="vertical-align: top;">
                    <a href="#" style="
    display: block;
    text-align: right;
    padding-right: 150px;
    margin-bottom: 40px;
">
                        <img src="https://itswebexpert.com/postgrid/logo.jpg" style="
    width: 80px; float:right; margin-bottom: 10px;
">
                    </a>
                    <table border="border" style="
    width: 100%;
    border-collapse: separate;
    border: 1px  solid #000;
    margin-bottom: 10px;
    width: 100%;
">
                        <tbody style="
">
                            <tr>
                                <td style="padding: 5px 20px;font-size:14px;width: 46%;font-weight: 500;text-align: center;background-color: #c8c9cb;">DATE DUE</td>
                                <td style="
    padding: 0 20px;
    text-align: center;
    font-size:14px;
    font-weight: 500;
">{{metadata.duedate}}</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 20px;font-size:14px;width: 46%;font-weight: 500;text-align: center;background-color: #c8c9cb;">AMOUNT DUE</td>
                                <td style="
    padding: 0 20px;
    text-align: center;
    font-size:14 500;
">${{metadata.amount_due}}</td>
                            </tr>
                            <tr>
                                <td style="
    padding: 5px 20px;
    font-size: 14px;
    width: 46%;
    font-weight: 500;
    text-align: center;
    background-color: #c8c9cb;
">ACCOUNT NO.</td>
                                <td style="
    padding: 0 20px;
    text-align: center;
    font-size:14px;
    font-weight: 500;
">{{metadata.account_num}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <p style="
    margin: 0 0 5px 0;
    font-size: 15px;
    font-weight: 500;
    line-height: 1.2;
">Phone: <a href="tel:34770701010" style="
    text-decoration: none;
    color: #000;
">347-707-1010</a></p>
                    <p style="
    margin: 0 0 10px 0;
    font-size: 15px;
    font-weight: 500;
    line-height: 1.2;
">Email: <a href="mailto:office@newgents.com" style="
    text-decoration: none;
    color: #000;
">office@newgents.com</a></p>
                    <hr style="
    margin: 0 0 1px 0;
    border: 0;
    height: 1px;
    background-color: #000;
">
                    <hr style="
    margin: 0 0 0 0;
    border: 0;
    height: 1px;
    background-color: #000;
">
                </td>
            </tr>
        </thead>
        <tbody>
            <tr style="
">
                <td colspan="2" >
                    <p style="
    margin: 80px 0 5px 0;
    text-align: right;
    font-size:16px;
    font-weight: 600;
">This statement does not reflect payments received after {{metadata.duedate}}</p>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="vertical-align: top">
                    <table style="
    width: 100%;
    border-top: 0;
    border-color: #000;
" border="border">
                        <thead>
                            <tr>
                                <td style="
    background-color: #c8c9cb;
    font-size:14px;
    padding: 5px 60px;
    width: 75%;
    font-weight: 600;
    border-left: 0;
    border-right: 0;
">ITEM</td>
                                <td style="
    background-color: #c8c9cb;
    font-size:14px;
    padding: 5px 60px;
    font-weight: 600;
    border-right: 0;
">AMOUNT</td>
                            </tr>
                        </thead>
                        <tbody style="
    border: 1px solid #000;
">
                            <tr style="
    border: 0;
">
                                <td style="
    font-size: 14px;
    padding: 5px 60px;
    font-weight: 400;
    border: 0;
"> {{metadata.item_1_name}}</td>
                                <td style="
    font-size: 14px;
    padding: 5px 60px;
    font-weight: 400;
    border: 0;
"> {{metadata.item_1_amount}}</td>
                            </tr>
                            <tr style="
    border: 0;
">
                                <td style="
    font-size: 14px;
    padding: 5px 60px;
    font-weight: 400;
    border: 0;
"> {{metadata.item_2_name}}</td>
                                <td style="
    font-size: 14px;
    padding: 5px 60px;
    font-weight: 400;
    border: 0;
"> {{metadata.item_2_amount}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="
    vertical-align: top;
">
                    <h3 style="
    margin: 30px 0 50px 0;
    text-align: center;
    font-size: 18px;
    font-weight: 700;
">RETURN THIS PORTION WITH YOUR PAYMENT</h3>
                </td>
            </tr>
            <tr>
                <td style="
    vertical-align: top;
">
                    <p style="
    margin: 0 0 10px 0;
    font-size:14px;
    font-weight: 400;
    line-height: 1.4;
">MAKE CHECK PAYABLE TO:</p>
                    <h5 style="
    margin: 0 0 10px 0;
    font-size:14px;
    font-weight: 600;
    line-height: 1.4;
">Ocean Grande Condominium</h5>
                </td>
                <td style="
    vertical-align: top;
">
                    <table border="border" style="
    width: 100%;
    border-collapse: separate;
    border: 1px  solid #000;
    margin: 0 0 0px 0;
">
                        <tbody style="
">
                            <tr>
                                <td style="padding: 5px 20px;font-size:14px;width: 46%;font-weight: 500;text-align: center;background-color: #c8c9cb;">DATE DUE</td>
                                <td style="
    padding: 0 20px;
    text-align: center;
    font-size:14px;
    font-weight: 500;
"> {{metadata.duedate}}</td>
                            </tr>
                            <tr>
                                <td style="padding: 5px 20px;font-size:14px;width: 46%;font-weight: 500;text-align: center;background-color: #c8c9cb;">AMOUNT DUE</td>
                                <td style="
    padding: 0 20px;
    text-align: center;
    font-size:14px;
    font-weight: 500;
">${{metadata.amount_due}}</td>
                            </tr>
                            <tr>
                                <td style="
    padding: 5px 20px;
    font-size: 14px;
    width: 46%;
    font-weight: 500;
    text-align: center;
    background-color: #c8c9cb;
">ACCOUNT NO.</td>
                                <td style="
    padding: 0 20px;
    text-align: center;
    font-size:14px;
    font-weight: 500;
">{{metadata.account_num}}</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr style="
">
                <td style="
    vertical-align: top;
">
                    <p style="
    margin: 80px 0 0px 0;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.3;
">{{to.firstName}}<br>{{to.companyName}}<br>{{to.addressLine1}} <br>{{to.addressLine2}}<br>{{to.city}}</p>
                </td>
                <td style="
    vertical-align: top; float: right;
">
                    <h4 style="
    font-size:16px;
    font-weight: 600;
    line-height: 1.4;
    margin: 80px 0 20px 0;
">PLEASE REMIT PAYMENT TO:</h4>
                    <p style="
    margin: 0 0 0px 0;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.3;
">Ocean Grande Condominium</p>
                    <p style="
    margin: 0 0 0px 0;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.3;
"><b>C/O:</b> NEWGENT MANAGEMENT, LLC.<br>20 South Broadway, Mezzanine<br>Yonkers, NY 10701</p>
                </td>
            </tr>
        </tbody>
    </table>

</body></html>