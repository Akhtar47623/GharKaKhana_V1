 <!-- <a id="resetPassword" class="font18"
   style="background: #e0006c;color: #ffffff;padding: 20px 60px;border-radius: 40px;font-size: 24px;font-family: gotham-medium;text-decoration: none;"
   href="{{$data['btn_url']}}">Reset my password</a> -->
   

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
        <td style="height: 7px;background: #23b97a;line-height: 7px;float: left; width: 100%;padding: 0;border-top: 1px #ffffff solid;">
            &nbsp;
        </td>
    </tr>
    <tr>
    	<td style="background: #f1f1f1; text-align: center; font-size: 34px; font-weight: 700;
        font-family:gotham-bold;color:#23b97a;padding: 60px 0 50px;">
            Password Reset
        </td>
     </tr>
    <tr>
        <td class="font18" style="background: #f1f1f1;padding: 0 50px;font-size: 18px;font-family: gotham-light; font-weight: 400;line-height: 22px;">
            <strong style="font-family: gotham-medium;">Dear, {{$data['display_name']}}</strong>
            <br><br>Need to reset your password? No problem. Just click below to get started.
            <br>If you didn't request to change your password, you don't have to do anything.
        </td>
    </tr><br><br>
    <tr>	
    	<td>
        <a id="resetPassword" class="font18"
   style="background: #23b97a;color: #ffffff;padding: 11px 29px;border-radius: 40px;font-size: 24px;font-family: gotham-medium;text-decoration: none;margin-left: 49px;"
   href="{{$data['btn_url']}}">Reset my password</a></td>
    </tr>
    <tr>
        <td style="background: #f1f1f1;padding: 0 50px;font-size: 18px;font-family: gotham-medium;line-height: 26px; padding-bottom: 30px;"></td>
    </tr>
    <tr>
    <td class="font18" style="background: #f1f1f1;padding: 0 50px;font-size: 18px;font-family: gotham-medium;line-height: 26px; padding-bottom: 30px;">
            Regards,<br>HomeChef
        </td>
     </tr>
     <tr>
        <td class="font18" style="background: #f1f1f1; padding:15px 15px; text-align: center; font-size: 12px; font-family: gotham-medium;color:#666666;">
            <span id="copyright">© 2020 All Rights Reserved. &nbsp;&nbsp;</span>
            <a class="font18" style="font-size: 12px; font-family: gotham-medium;color:#000; text-decoration: none;color:#666666;"
               href="#">Terms of Use</a> |
            <a class="font18" style="font-size: 12px; font-family: gotham-medium;color:#000; text-decoration: none;color:#666666;"
               href="#">Privacy Policy</a>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
   