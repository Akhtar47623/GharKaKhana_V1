<?php

// Database

$config['host'] = "localhost";
$config['user'] = "makem_hm";
$config['pass'] = "1Z7epNgIEsS!!";
$config['database'] = "makem_homemade";

$con = mysqli_connect($config['host'],$config['user'],$config['pass'],$config['database']);

// Check Connection

if($con->connect_error){
	die("Connection failed: " . $con->connect_error);
}

// Strict Mode

mysqli_query($con,"SET GLOBAL sql_mode = 'NO_ENGINE_SUBSTITUTION'");
mysqli_query($con,"SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'");

// Date Database

$dateQ = mysqli_query($con,"select curdate() as today");
$dateR = mysqli_fetch_array($dateQ);
$dateEdited = $dateR['today'];

$dateTimeQ = mysqli_query($con,"select now() as dateTime");
$dateTimeR = mysqli_fetch_array($dateTimeQ);
$dateTimeEdited = $dateTimeR['dateTime'];

// Classes

// Excel
include 'class/PHPExcel/Classes/PHPExcel.php';
include 'class/PHPExcel/Classes/PHPExcel/IOFactory.php';

// Mailer
require('class/PHPMailer/class.phpmailer.php');

//if(class_exists('PHPMailer')){
//}

//if(!class_exists('PHPMailer')){
	//echo exit;
//}

// Mobile
include 'class/mobile/Mobile_Detect.php';
$detect = new Mobile_Detect();

// PDF
require('class/fpdf/fpdf.php');

// Twilio
require 'class/twilioPHP/Twilio/autoload.php';
use Twilio\Rest\Client;

$AccountSid = "ACb11ca34a5a12c4c37f6b05e98f2f26c9";
$AuthToken = "63baa7c2685c5d15e8a3b80f2537dd7e";

?>