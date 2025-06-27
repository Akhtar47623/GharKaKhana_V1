 
<!DOCTYPE html>
<html>
<head>
    <style type="text/css">
        body {
            font-family: gotham-medium;
        }

        @media only screen and (max-width: 600px) {
            #resetPassword {
                padding: 13px 25px !important;
            }
            .font18 {
                font-size: 18px !important;
            }
            #copyright{
                width: 100% !important;
                float: left;
            }
        }
    </style> 
</head>
<body>
<table width="100%" style="margin: 100px auto; background: #f1f1f1;max-width:800px;" border="0" cellpadding="0"
       cellspacing="0">
    <tbody>
        <tr>
            <td style="background:#f1f1f1;text-align:center;font-size:34px;font-weight:700;font-family:gotham-bold;color: #efb313;padding:20px 0 20px;">
                Contact Us
            </td>
        </tr>
        <tr>
            <td style="height: 10px;background: #efb313;float: left; width: 87%;padding: 25px 50px;border-top: 1px #ffffff solid;font-family: gotham-bold;font-size: 16px;">You have recieved a new message from the contact us form on your website
            </td>    
        </tr>
        <tr>	
        	<td style="background: #f1f1f1;padding: 15px 50px;font-size: 16px;font-family: gotham-medium;line-height: 26px; padding-bottom: 10px;"><b>Name:</b> {{$data['name']}}</td>
        </tr>
        <tr>
            <td style="background: #f1f1f1;padding: 0 50px;font-size: 16px;font-family: gotham-medium;line-height: 26px; padding-bottom: 10px;"><b>Email:</b> {{$data['email']}}</td>
        </tr>
         <tr>   
            <td style="background: #f1f1f1;padding: 0 50px;font-size: 16px;font-family: gotham-medium;line-height: 26px; padding-bottom: 10px;"><b>Mobile:</b> {{$data['mobile']}}</td>
        </tr>
        <tr>
            <td style="background: #f1f1f1;padding: 0 50px;font-size: 16px;font-family: gotham-medium;line-height: 26px; padding-bottom: 10px;"><b>Subject:</b> {{$data['subject']}}</td>
        </tr>
        <tr>
            <td style="background: #f1f1f1;padding: 0 50px;font-size: 16px;font-family: gotham-medium;line-height: 26px; padding-bottom: 10px;"><b>Message:</b> {{$data['message']}}</td>
        </tr>
        <tr>
        <td class="font18" style="background: #f1f1f1;padding: 0 50px;font-size: 12px;font-family: gotham-medium;line-height: 26px; padding-bottom: 10px;">
                Regards,<br>Prep By Chef
            </td>
         </tr>
         <tr>
            <td class="font18" style="background: #f1f1f1; padding:15px 15px; text-align: center; font-size: 12px; font-family: gotham-medium;color:#666666;">
                <span id="copyright">© 2021 All Rights Reserved By PrepByChef. &nbsp;&nbsp;</span>
                
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
   