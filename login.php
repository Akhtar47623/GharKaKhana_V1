<?php

$url = $_GET['url'];

function url_origin($s, $use_forwarded_host = false){
	$ssl = (! empty($s['HTTPS'] ) && $s['HTTPS'] == 'on');
	$sp = strtolower($s['SERVER_PROTOCOL']);
	$protocol = substr($sp, 0, strpos($sp, '/')).(($ssl) ? 's' : '');
	$port = $s['SERVER_PORT'];
	$port = ((!$ssl && $port=='80') || ($ssl && $port=='443')) ? '' : ':'.$port;
	$host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
	$host = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
	return $protocol.'://'.$host;
}

function full_url($s, $use_forwarded_host = false){
	return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
}

$absolute_url = full_url($_SERVER);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.js"></script>
<title>Home Chef</title>
</head>
<body>
<table width="100%" align="center" cellpadding="1" cellspacing="5" style="table-layout:auto">
  <tr>
    <td align="center"><h1>WELCOME TO HOME CHEF</h1></td>
  </tr>
</table>
<form action="login2.php" method="post" target="_top">
<input name="url" type="hidden" value="<?php echo $url ?>"/>
<table align="center" width="100%" cellpadding="1" cellspacing="5" align="center" style="table-layout:auto">
  <tr>
	<td width="33%" valign="middle" style="font-size:18px" align="right">Email:</td>
	<td valign="middle" style="font-size:18px"><input type="text" name="email" id="email" style="width:200px; height:30px; font-size:18px;"/></td>
	<td width="33%" valign="middle" style="font-size:18px" align="center" rowspan="3"><a href="register.php"><h3>Register Now To Order Online</h3></a></td>
  </tr>
  <tr>
	<td valign="middle" style="font-size:18px" align="right">Password:</td>
	<td valign="middle" style="font-size:18px"><input type="password" name="password" id="password" style="width:200px; height:30px; font-size:18px;"/></td>
  </tr>
  <tr>
	<td valign="middle" style="font-size:18px">&nbsp;</td>
	<td valign="middle" style="font-size:18px"><input type="submit" name="submit" value="Login"/></td>
  </tr>
</table>
<br/>
<table align="center" width="100%" cellpadding="1" cellspacing="5" align="center" style="table-layout:auto">
  <tr>
	<td width="25%" valign="middle" style="font-size:18px" align="center">MADE TO ORDER MEALS</td>
	<td width="25%" valign="middle" style="font-size:18px" align="center">CATERING</td>
	<td width="25%" valign="middle" style="font-size:18px" align="center">HOSTING</td>
	<td valign="middle" style="font-size:18px" align="center">COOKING AT EVENTS</td>
  </tr>
  <tr>
	<td valign="middle" style="font-size:18px"><img src="images/stock_food/1.jpg" width="100%"></td>
	<td valign="middle" style="font-size:18px"><img src="images/stock_food/2.jpg" width="100%"></td>
	<td valign="middle" style="font-size:18px"><img src="images/stock_food/3.jpg" width="100%"></td>
	<td valign="middle" style="font-size:18px"><img src="images/stock_food/4.jpg" width="100%"></td>
  </tr>
  <tr>
	<td valign="middle" style="font-size:18px">&nbsp;</td>
	<td valign="middle" style="font-size:18px">&nbsp;</td>
	<td valign="middle" style="font-size:18px">&nbsp;</td>
	<td valign="middle" style="font-size:18px">&nbsp;</td>
  </tr>
  <tr>
	<td valign="middle" style="font-size:18px" align="center" colspan="4"><a href="cook/register.php"><h1>REGISTER TO BE A HOME CHEF</h1></a></td>
  </tr>
  <tr>
	<td valign="middle" style="font-size:18px" align="center" colspan="4">Already registered, <a href="cook/login.php">click here</a> to login</td>
  </tr>
</table>
</form>
<br/>
<br/>
</body>
</html>