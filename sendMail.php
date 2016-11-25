<?php
/**
 * @sirus
 */
require dirname(__FILE__).'/PHPMailer/PHPMailerAutoload.php';
$current_dir = getcwd();
include_once($current_dir.'/include/config.inc.php');
include_once($current_dir.'/lib/common.class.php');

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.rediffmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'trickyuk001@rediffmail.com';                 // SMTP username
$mail->Password = 'kumar@890';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                   // TCP port to connect to

$mail->setFrom('trickyuk001@rediffmail.com', 'Mailer');
//$mail->addAddress('suresh@marriager.com', 'Suresh Das');     // Add a recipient
$client_email_id = 'trickyuk001@rediffmail.com';
$mail->addAddress('trickyuk001@rediffmail.com');               // Name is optional
//$mail->addReplyTo('suresh@marriager.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML
$camp_id = 1;$link = "http://www.google.com";
/*we need to get the last track id and then add one to it and then compose the url with this tracking id
 * or as per coach changing this whole structure to make a call to track.php with a encrypted code and then decrypt and do the processing
 * implementing CURL based retrival
 * Task Remainig: Encryption and Decryption while sending mail.
 */
//lets send a CURL request and insert a row and get the current id of that blank row
$sendPost = new Common();
$data = array('mode' => 'tracker','type' => 'insert');
$requestType ='';
$response= $sendPost ->sendCURL(DEFAULT_URL, $data, $requestType);//will insert a blank row and will return the id for the row.
$res = json_decode($response,true);
if($res['id']){$track_id = $res['id'];$sendPost -> sendMessage(200,'Row Inserted');}//the id is recieved after the json decode and send a success message
$mail->Subject = 'Here is the subject';
$mail->Body    = "<img src = '".DEFAULT_URL."/track.php?id=".$sendPost->base64_url_encode($track_id)." style=width:1px;height:1px;' >
		         <br>
				 HAPPY FOLKS..<a href='".DEFAULT_URL."/track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode($link)."' />
		 	     ";
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
if(!$mail->send()) {
	$msg= 'Message could not be sent because of ';
	$msg .= $mail->ErrorInfo.'';
	$sendPost -> senderror(500,$msg);
	//Attempting to send a CURL request to the REST API
	$url=DEFAULT_URL;
	$data=array('mode' => 'tracker','track_id' => $track_id, 'camp_id' => $camp_id, 'email_id' => $client_email_id, 'sendMail' => 0);
	$sendPost->sendCURL($url, $data);
	
} else {
	$msg = 'Message has been sent';
	$sendPost -> sendMessage(200,$msg);
	$url=DEFAULT_URL;
	$requestType= 'POST';
	$data=array('mode' => 'tracker','track_id' => $track_id, 'camp_id' => $camp_id, 'email_id' => $client_email_id, 'sendMail' => 1);
	$sendPost->sendCURL($url, $data, $requestType);
}