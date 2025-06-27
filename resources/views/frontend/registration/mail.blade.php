 
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
        <td style="height: 7px;background: #efb313;line-height: 7px;float: left; width: 100%;padding: 0;border-top: 1px #ffffff solid;">
            &nbsp;
        </td>
    </tr>
    <tr>
    	<td style="background: #f1f1f1; text-align: center; font-size: 34px; font-weight: 700;
        font-family:gotham-bold;color:#efb313;padding: 60px 0 50px;">
            {{__('sentence.valiacc') }}
        </td>
    </tr>
    <tr>
        <td class="font18" style="background: #f1f1f1;padding: 0 50px;font-size: 18px;font-family: gotham-light; font-weight: 400;line-height: 22px;">
            <strong style="font-family: gotham-medium;">{{__('sentence.dear') }} {{$data['display_name']}},</strong>
            <br><br>{{__('sentence.congmsg') }} 
            <br>{{__('sentence.valicode') }} {{$data['validate_code']}}
        </td>
    </tr><br><br>
    <tr>	
    	<td>
        <a id="resetPassword" class="font18"
   style="background: #efb313;color: #ffffff;padding: 11px 29px;border-radius: 40px;font-size: 24px;font-family: gotham-medium;text-decoration: none;margin-left: 49px;"
   href="{{$data['btn_url']}}">{{__('sentence.validate') }}</a></td>
    </tr>
    <tr>
        <td style="background: #f1f1f1;padding: 0 50px;font-size: 18px;font-family: gotham-medium;line-height: 26px; padding-bottom: 30px;"></td>
    </tr>
    <tr>
    <td class="font18" style="background: #f1f1f1;padding: 0 50px;font-size: 18px;font-family: gotham-medium;line-height: 26px; padding-bottom: 30px;">
            {{__('sentence.regards') }}<br>Prep By Chef
        </td>
     </tr>
     <tr>
        <td class="font18" style="background: #f1f1f1; padding:15px 15px; text-align: center; font-size: 12px; font-family: gotham-medium;color:#666666;">
            <span id="copyright">{{__('sentence.copy-right')}} &nbsp;&nbsp;</span>
           
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
   