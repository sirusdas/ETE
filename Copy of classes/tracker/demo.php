
<?php
/*
 * @Suresh
 */
require_once dirname(__FILE__).'/Mobile_Detect.php';
$detect = new Mobile_Detect;
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$scriptVersion = $detect->getScriptVersion();

//echo $deviceType."<br>";
 //echo htmlentities($_SERVER['HTTP_USER_AGENT']);
$data = htmlentities($_SERVER['HTTP_USER_AGENT']);

$deviceInfo = explode("(", $data);
//echo $deviceInfo[1]."<br>";
$deviceInfo = explode(")", $deviceInfo[1]);
$computer_info = $deviceInfo[0];
$browser_info = $deviceInfo[1];
//echo $computer_info." and ".$browser_info;


/*
 * Trying to get the IP address and info....
 */

$details = json_decode(file_get_contents("http://ipinfo.io/"));
//echo $details->country.$details->region.$details->city; // city
//echo $details->ip;