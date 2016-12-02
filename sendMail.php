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
/*
 $mail->isSMTP();                                      // Set mailer to use SMTP
 $mail->Host = 'smtp.rediffmail.com';  // Specify main and backup SMTP servers
 $mail->SMTPAuth = true;                               // Enable SMTP authentication
 $mail->Username = 'trickyuk001@rediffmail.com';                 // SMTP username
 $mail->Password = 'kumar@890';                           // SMTP password
 $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
 $mail->Port = 587;                                   // TCP port to connect to
 */
$mail->setFrom('suresh@xyz.com', 'Mailer');
$mail->addAddress('suresh@xyz.com', 'Suresh Das');     // Add a recipient
$client_email_id = 'suresh@xyz.com';
$mail->addAddress('suresh@xyz.com');                // Name is optional
//$mail->addReplyTo('suresh@xyz.com', 'Information');
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
$data = array('mode' => 'tracker', 'type' => 'insert' ,'camp_id' => $camp_id, 'email_id' => $client_email_id);
$requestType ='';
$response= $sendPost ->sendCURL(DEFAULT_URL, $data, $requestType);//will insert a blank row and will return the id for the row.
$response = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response);
//$response=array("id"=>1);
//var_dump(json_decode($response));
$res = json_decode($response, true);
//echo $res['id'];
//$res = json_decode($response,true);
/*switch (json_last_error()) {
 case JSON_ERROR_NONE:
 echo ' - No errors';
 break;
 case JSON_ERROR_DEPTH:
 echo ' - Maximum stack depth exceeded';
 break;
 case JSON_ERROR_STATE_MISMATCH:
 echo ' - Underflow or the modes mismatch';
 break;
 case JSON_ERROR_CTRL_CHAR:
 echo ' - Unexpected control character found';
 break;
 case JSON_ERROR_SYNTAX:
 echo ' - Syntax error, malformed JSON';
 break;
 case JSON_ERROR_UTF8:
 echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
 break;
 default:
 echo ' - Unknown error';
 break;
 }*/
if($res['id']){$track_id = $res['id'];}//$sendPost -> sendMessage(200,'Row Inserted');}//the id is recieved after the json decode and send a success message
$mail->Subject = 'Here is the subject';
/*
 $mail->Body    = "<img src = '".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."' style='width:1px;height:1px;' >
 <br>
 <a href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode($link)."' > HAPPY FOLKS..</a>
 ";
 */
//search using image link with htaccess rule

/* $mail->Body    = "<img src = '".DEFAULT_URL.$sendPost->base64_url_encode($track_id).".png'  style='width:1px;height:1px;'>
		         <br>
				<a href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode($link)."' > HAPPY FOLKS..</a>
		 	     "; */
// '".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link='

$mail -> Body = "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>xyz</title>
 <meta name='viewport' content='width=device-width, initial-scale=1'> <!-- So that mobile will display zoomed in -->
  <meta http-equiv='X-UA-Compatible' content='IE=edge'> <!-- enable media queries for windows phone 8 -->
  <meta name='format-detection' content='telephone=no'> <!-- disable auto telephone linking in iOS -->
<style type='text/css'>
         /* Client-specific Styles */
         div, p, a, li, td { -webkit-text-size-adjust:none; }
         #outlook a {padding:0;} /* Force Outlook to provide a 'view in browser' menu link. */
         html{width: 100%; }
         body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;}
         /* Prevent Webkit and Windows Mobile platforms from changing default font sizes, while not breaking desktop design. */
         .ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */
         .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;} /* Force Hotmail to display normal line spacing. */
         #backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
         img {outline:none; text-decoration:none;border:none; -ms-interpolation-mode: bicubic;}
         a img {border:none;}
         .image_fix {display:block;}
         p {margin: 0px 0px !important;}
         table td {border-collapse: collapse;}
         table { border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt; }
         a {color: #eb434e;text-decoration: none;text-decoration:none!important;}
		 a:hover{text-decoration:underline !important;}

         /*STYLES*/
         table[class=full] { width: 100%; clear: both; }
		 * { font-family: Helvetica Neue, Helvetica, Helvetica, Arial, sans-serif; }
         /*IPAD STYLES*/
         @media only screen and (max-width: 640px) {
         a[href^='tel'], a[href^='sms'] {
         text-decoration: none;
         color: #33b9ff; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^='tel'], .mobile_link a[href^='sms'] {
         text-decoration: default;
         color: #33b9ff !important;
         pointer-events: auto;
         cursor: default;
         }
		 table {width: 100% !important;}
         table[class=devicewidthinner] {width: 420px !important;text-align:center !important; max-width:100% !important;}
         table[class=devicewidth] {width: 440px !important;text-align:center !important; }
		          img[class=banner] {width: 440px !important;height:220px !important;}
         img[class=col2img] {width: 440px !important;text-align:center !important;width:100% !important;}
		 table[class=devicewidth1] {width: 200px !important;text-align:center !important;width:46% !important;}
         table[class=devicewidthinner1] {width: 180px !important;text-align:center !important;width:46% !important;}
		  img[class=col2img1] {width: 200px !important;height:312px !important;width:46% !important;}
         
         
         }
         /*IPHONE STYLES*/
         @media only screen and (max-width: 480px) {
         a[href^='tel'], a[href^='sms'] {
         text-decoration: none;
         color: #33b9ff; /* or whatever your want */
         pointer-events: none;
         cursor: default;
         }
         .mobile_link a[href^='tel'], .mobile_link a[href^='sms'] {
         text-decoration: default;
         color: #33b9ff !important; 
         pointer-events: auto;
         cursor: default;
         }
         table[class=devicewidth] {width: 320px !important;text-align:center !important;}
         table[class=devicewidthinner] {width: 300px !important;text-align:center !important;}
         img[class=banner] {width: 320px !important;height:153px !important;}
         img[class=col2img] {width: 320px !important;height:227px !important; max-width:100%}
		 table[class=devicewidth1] {width: 320px !important;text-align:center !important;}
         table[class=devicewidthinner1] {width:300px !important;text-align:center !important;}
		  img[class=col2img1] {width: 320px !important;height:312px !important;}
         
         
        
         }
      </style>
</head>

<body>
<table width='100%' bgcolor='#ffffff' cellpadding='0' cellspacing='0' border='0'>
<tr>
<td>
 <table width='640' cellpadding='0' cellspacing='0' border='0' align='center' class='devicewidth'>
 <tr>
 <td  width='100%'>
 <table width='640' cellpadding='0' cellspacing='0' border='0' align='center' class='devicewidth'>
                           <tbody>
                              <!-- Spacing -->
                              <tr>
                                 <td height='20' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td>
                                    <!-- logo -->
                                    <table width='147' align='center' border='0' cellpadding='0' cellspacing='0' class='devicewidth'>
                                       <tbody>
                                          <tr>
                                             <td width='147' height='63' align='center'>
                                                <div class='imgpop'><img src='http://www.thexyz.com/images/emailers/logo.png' width='147' height='63' alt='' border='0'  style='display:block; border:none; outline:none; text-decoration:none;' /></div>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <!-- end of logo -->
                                 </td>
                              </tr>
                              <!-- Spacing -->
                              <tr>
                                 <td height='20' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                              </tr>
                              <!-- Spacing -->
                           </tbody>
                        </table>
 
 
 </td>
 </tr>
 
 <tr>
 <td  width='100%'>
 <table width='640' bgcolor='#f7f7f4' cellpadding='0' cellspacing='0' border='0' align='center' class='devicewidth'>
                           <tbody>
                              
                              <tr>
                                 <td>
                                    
                                    
                                    <table width='70%' align='center'  cellspacing='0' cellpadding='5' border='0' bgcolor='#f7f7f4'>
										<tbody><tr>
											<td width='21%' align='center'>
												<a style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:bold;line-height:24px;text-align:center;font-size:14px;color:#eb434e;letter-spacing:0.2px;text-transform:uppercase;text-decoration:none' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/blog/')."'>
														Blog
												</a>
											</td>
											<td width='1%' style='color:#eb434e;font-weight:bold;'>&nbsp;|&nbsp;</td>
											<td width='25%' align='center'>
												<a style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:bold;line-height:24px;text-align:center;font-size:14px;color:#eb434e;letter-spacing:0.2px;text-transform:uppercase;text-decoration:none' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/vendors/')."'>
														Vendors
												</a>
											</td>
											<td width='1%' style='color:#eb434e;font-weight:bold;'>&nbsp;|&nbsp;</td>
											<td width='22%' align='center'>
												<a style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif;font-weight:bold;line-height:24px;text-align:center;font-size:14px;color:#eb434e;letter-spacing:0.2px;text-transform:uppercase;text-decoration:none' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/contact/')."'>
														Contact Us
												</a>
											</td>
											
											
										</tr>
								</tbody></table>
                                 </td>
                              </tr>
                              
                           </tbody>
                        </table>
 
 
 </td>
 </tr>
 <tr>
 <td  width='100%'>
 
 <table bgcolor='#ffffff' width='600' cellpadding='0' cellspacing='0' border='0' align='center' class='devicewidth'>
                           <tbody>
                             
                              <tr>
                                 <td>
                                    <table width='600' align='center' cellpadding='0' cellspacing='0' border='0' class='devicewidthinner'>
                                       <tbody> <tr>
                                             <td height='18'></td>
                                          </tr>
                                       
                                          <!-- Title -->
                                          <tr>
                                             <td align='center' >
                                             
                                             
                                             <table width='83' align='center' border='0' cellpadding='0' cellspacing='0' class='devicewidth'>
                                       <tbody>
                                          <tr>
                                             <td width='83' height='36' align='center'>
                                                <div class='imgpop'>
                                                   <a target='_blank' href='#'>
                                                   <img src='http://www.thexyz.com/images/emailers/hello.png' width='83' height='36' alt='' border='0'  style='display:block; border:none; outline:none; text-decoration:none;'>
                                                   </a>
                                                </div>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                                                                            </td>
                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                          <tr>
                                             <td height='15'></td>
                                          </tr>
                                          <!-- End of spacing -->
                                          <!-- content -->
                                          <tr>
                                             <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 14px; color: #919090; text-align:left;line-height: 20px;'>
                                               We are so happy for you! Youre getting married or your bestie is and we are super stoked!
Would you like to make it special by having your support system all synced up? We got you
covered with the latest styles that will look great on everyone. Cant skip town for a fun
bachelorette? WE can help. We have also rounded up some  interesting ways you could get to
know your beau a little more before your wedding day and finally, we have some haute destinations
in Asia if you want to be a getaway bride! This is your time and we are with you ALL THE WAY!
                                             </td>
                                          </tr>
                                       
                                          <tr>
                                             <td width='100%' height='20'></td>
                                          </tr>
                                          <!-- Spacing -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
 
 </td>
 </tr>
 <tr>
 <td  width='100%'>
 
 <table width='600' align='center' cellpadding='0' cellspacing='0' border='0' class='devicewidthinner'>
                              <tbody>
                                 <!-- Title -->
                                 <tr>
                                   <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 28px; font-weight:bold; color: #eb434e; text-align:left;line-height: 30px; text-align:center'>
                                               BRIDESMAID DRESS STYLES
                                             </td>
                                 </tr>
                                 <!-- End of Title -->
                                 <!-- spacing -->
                                
                                 
                                 <tr>
                                    <td width='100%' height='20'></td>
                                 </tr>
                                 
                                 <tr>
                                   
                                   
                        <td align='center'>
                                      <img width='600' border='0'  alt='' style='display:block; border:none; outline:none; text-decoration:none;' src='http://www.thexyz.com/images/emailers/banner.jpg' class='banner'>
                                    </td>
                       
                                    
                                 </tr>
                                 <!-- Spacing -->
                                 <tr>
                                    <td width='100%' height='20'></td>
                                 </tr>
                              </tbody>
                           </table>
 </td>
 </tr>
 
 <tr>
 <td  width='100%'>
 
 <table bgcolor='#ffffff' width='640' cellpadding='0' cellspacing='0' border='0' align='center' class='devicewidth'>
                           <tbody>
                              
                              <tr>
                                 <td>
                                    <table width='600' align='center' cellpadding='0' cellspacing='0' border='0' class='devicewidthinner'>
                                       <tbody>
                                          <!-- Title -->
                                          <tr>
                                             <td style='font-family:HelveticaNeueLTStd-Bd, Helvetica, arial, sans-serif; font-size: 18px; color: #eb434e; text-align:center; line-height: 24px;'>
                                                <a href='#' style='color: #eb434e;'>View Story</a></td>
                                          </tr>
                                          <!-- End of Title -->
                                          <!-- spacing -->
                                          <tr>
                                             <td width='100%' height='15' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                          
                                         <tr>
                                             <td width='100%'>
                                               <img src='http://www.thexyz.com/images/emailers/recent-stories-header.jpg' width='600' height='35' alt='' border='0' style='display:block; border:none; outline:none; text-decoration:none; max-width:100%' /></td>
                                          </tr>
                                          
                                          <tr>
                                             <td width='100%' height='20' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                          <!-- Spacing -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                             
                           </tbody>
                        </table>
 
 
  </td>
 </tr>
 
 <tr>
 <td  >
 <table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;margin-top:15px;' align='left'>
                            <tr>
                                <td style='padding:0 20px;'>
                                
                                 <table border='0' cellpadding='0' cellspacing='0' width='39%' style='border-collapse: collapse;font-size: 15px;color: #000000;line-height: 20px ; max-width:100%' align='left'>
                                 <tr>
                                 	<td  width='100%' align='center' >
                                    
                                    <img src='http://www.thexyz.com/images/emailers/left-image.jpg' align='absmiddle' style='width:100%; height:auto'>
                                    
                                     </td>
                                 </tr>
                                 </table>
                                 <table width='1%' border='0' align='left' cellpadding='0' cellspacing='0' class='mobilespacing'>
                                       <tbody>
                                          <tr>
                                             <td width='100%' height='15' style='font-size:5px; line-height:5px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                  <table border='0' cellpadding='0' cellspacing='0' width='59%' style='border-collapse: collapse;font-size: 15px;
color: #000000;line-height: 20px;min-height: 90px;margin-bottom:15px;' align='right'>
                                  <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 14px; color: #eb434e; text-align:left; line-height: 16px; text-transform:uppercase'>
                                                            BACHELORETTE IDEAS FOR WHEN YOU CANT get out of town</td>
                                                      </tr>
                                                       <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; color: #919090; text-align:left; line-height: 20px;'>
                                                            By Team xyz Saturday, August 6, 2016</td>
                                                      </tr>
                                                <tr>
                                                         <td width='100%' height='5' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                                      </tr>      
                                                      
                                                     <tr>
                     <td width='333' align='center' height='1' bgcolor='#d1d1d1' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                  </tr>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width='100%' height='10' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                                      </tr>
                                                      <!-- /Spacing -->
                                                      <!-- content -->
                                                      <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 14px; color: #919090; text-align:left; line-height: 16px;'>
                                                            While a weekend getaway sounds tempting, its possible that your squad
may not be able to empty their schedules to skip out of town. But that
doesnt mean you cant have the best party ever! Read on for fabulous
bachelorettes that you can have in your city itself...<a href=''  style='color:#eb434e; text-decoration:none'>Read More</a>
                                                         </td>
                                                      </tr>
                                                      <!-- end of content -->
                                                      <!-- Spacing -->
                                                     
                                 </table>
                                  <div style='clear:both;'></div>  
                    
                                </td>
                            </tr>                    
                        </table>
 
 
 
 </td>
 </tr>
 
  <tr>
 <td  width='100%'>
 <table width='640' align='center' cellspacing='0' cellpadding='0' border='0' class='devicewidth'>
               <tbody>
                  <tr>
                     <td align='center' height='10' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                  </tr>
               </tbody>
            </table>
 
  </td>
 </tr>
 
 <tr>
 <td >
 <table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;margin-top:15px;' align='left'>
                            <tr>
                                <td style='padding:0 20px;'>
                                
                                 <table border='0' cellpadding='0' cellspacing='0' width='39%' style='border-collapse: collapse;font-size: 15px;color: #000000;line-height: 20px ; max-width:100%' align='right'>
                                 <tr>
                                 	<td  width='100%' align='center' >
                                    
                                    <img src='http://www.thexyz.com/images/emailers/right-image.jpg' align='absmiddle' style='width:100%; height:auto'>
                                    
                                     </td>
                                 </tr>
                                 </table>
                                 <table width='1%' border='0' align='right' cellpadding='0' cellspacing='0' class='mobilespacing'>
                                       <tbody>
                                          <tr>
                                             <td width='100%' height='15' style='font-size:5px; line-height:5px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                  <table border='0' cellpadding='0' cellspacing='0' width='59%' style='border-collapse: collapse;font-size: 15px;
color: #000000;line-height: 20px;min-height: 90px;margin-bottom:15px;' align='left'>
                                  <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 14px; color: #eb434e; text-align:left; line-height: 16px; text-transform:uppercase'>
                                                            5 OFFBEAT WEDDING DESTINATIONS IN ASIA</td>
                                                      </tr>
                                                       <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; color: #919090; text-align:left; line-height: 20px;'>
                                                             By Minila DSouza, Team xyz Monday, August 1, 2016</td>
                                                      </tr>
                                                <tr>
                                                         <td width='100%' height='5' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                                      </tr>      
                                                      
                                                     <tr>
                     <td width='333' align='center' height='1' bgcolor='#d1d1d1' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                  </tr>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width='100%' height='10' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                                      </tr>
                                                      <!-- /Spacing -->
                                                      <!-- content -->
                                                      <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 14px; color: #919090; text-align:left; line-height: 16px;'>
                                                            Youve always dreamed of a destination wedding, but with an
onslaught of Thailand weddings by friends and family, the concept
can seem less thrilling and more déjà vu (and not in the good way!)
Its time to bring the intrigue back... <a href=''  style='color:#eb434e; text-decoration:none'> Read More</a>
                                                         </td>
                                                      </tr>
                                                      <!-- end of content -->
                                                      <!-- Spacing -->
                                                     
                                 </table>
                                  <div style='clear:both;'></div>  
                    
                                </td>
                            </tr>                    
                        </table>
  </td>
 </tr>
 
 <tr>
 <td  width='100%'>
 
  <table width='640' align='center' cellspacing='0' cellpadding='0' border='0' class='devicewidth'>
               <tbody>
                  <tr>
                     <td align='center' height='10' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                  </tr>
               </tbody>
            </table>
 
 
 </td>
 </tr>
 
 <tr>
 <td  width='100%'>
 
 <table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;margin-top:15px;' align='left'>
                            <tr>
                                <td style='padding:0 20px;'>
                                
                                 <table border='0' cellpadding='0' cellspacing='0' width='39%' style='border-collapse: collapse;font-size: 15px;color: #000000;line-height: 20px ; max-width:100%' align='left'>
                                 <tr>
                                 	<td  width='100%' align='center' >
                                    
                                    <img src='http://www.thexyz.com/images/emailers/left-image2.jpg' align='absmiddle' style='width:100%; height:auto'>
                                    
                                     </td>
                                 </tr>
                                 </table>
                                 <table width='1%' border='0' align='left' cellpadding='0' cellspacing='0' class='mobilespacing'>
                                       <tbody>
                                          <tr>
                                             <td width='100%' height='15' style='font-size:5px; line-height:5px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                  <table border='0' cellpadding='0' cellspacing='0' width='59%' style='border-collapse: collapse;font-size: 15px;
color: #000000;line-height: 20px;min-height: 90px;margin-bottom:15px;' align='right'>
                                  <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 14px; color: #eb434e; text-align:left; line-height: 16px; text-transform:uppercase'>
                                                            ARRANGED MARRIAGES: GET TO KNOW THEM...</td>
                                                      </tr>
                                                       <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; color: #919090; text-align:left; line-height: 20px;'>
                                                            By Roanna Fernandes, Team xyz Wednesday, August 3, 2016</td>
                                                      </tr>
                                                <tr>
                                                         <td width='100%' height='5' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                                      </tr>      
                                                      
                                                     <tr>
                     <td width='333' align='center' height='1' bgcolor='#d1d1d1' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                  </tr>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width='100%' height='10' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                                      </tr>
                                                      <!-- /Spacing -->
                                                      <!-- content -->
                                                      <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 14px; color: #919090; text-align:left; line-height: 16px;'>
                                                           With a wedding, there is the anxiousness of not knowing each other well
enough, theres also the major involvement of the families when it comes to
the planning.We have some cute remedies that can give you a chance to
get to know your SO a little more... <a href=''  style='color:#eb434e; text-decoration:none'> Read More</a>
                                                         </td>
                                                      </tr>
                                                      <!-- end of content -->
                                                      <!-- Spacing -->
                                                      
                                 </table>
                                  <div style='clear:both;'></div>  
                    
                                </td>
                            </tr>                    
                        </table>
 
 
 
 </td>
 </tr>
 
 <tr>
 <td  width='100%'>
 <table width='640' align='center' cellspacing='0' cellpadding='0' border='0' class='devicewidth'>
               <tbody>
                  <tr>
                     <td align='center' height='10' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                  </tr>
               </tbody>
            </table>
 
 </td>
 </tr>
 
 <tr>
 <td  width='100%'>
 <table border='0' cellpadding='0' cellspacing='0' width='100%' style='border-collapse: collapse;margin-top:15px;' align='left'>
                            <tr>
                                <td style='padding:0 20px;'>
                                
                                 <table border='0' cellpadding='0' cellspacing='0' width='39%' style='border-collapse: collapse;font-size: 15px;color: #000000;line-height: 20px ; max-width:100%' align='right'>
                                 <tr>
                                 	<td  width='100%' align='center' >
                                    
                                    <img src='http://www.thexyz.com/images/emailers/right-image2.jpg' align='absmiddle' style='width:100%; height:auto'>
                                    
                                     </td>
                                 </tr>
                                 </table>
                                 <table width='1%' border='0' align='right' cellpadding='0' cellspacing='0' class='mobilespacing'>
                                       <tbody>
                                          <tr>
                                             <td width='100%' height='15' style='font-size:5px; line-height:5px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                       </tbody>
                                    </table>
                                  <table border='0' cellpadding='0' cellspacing='0' width='59%' style='border-collapse: collapse;font-size: 15px;
color: #000000;line-height: 20px;min-height: 90px;margin-bottom:15px;' align='left'>
                                  <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 14px; color: #eb434e; text-align:left; line-height: 16px; text-transform:uppercase'>
                                                            POSING LIKE A PRO: COMMANDMENTS!</td>
                                                      </tr>
                                                       <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 12px; color: #919090; text-align:left; line-height: 20px;'>
                                                            By Team xyz Thursday, July 28, 2016</td>
                                                      </tr>
                                                <tr>
                                                         <td width='100%' height='5' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                                      </tr>      
                                                      
                                                     <tr>
                     <td width='333' align='center' height='1' bgcolor='#d1d1d1' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                  </tr>
                                                      <!-- Spacing -->
                                                      <tr>
                                                         <td width='100%' height='10' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                                      </tr>
                                                      <!-- /Spacing -->
                                                      <!-- content -->
                                                      <tr>
                                                         <td style='font-family:HelveticaNeueLTStd-Bd,Helvetica Neue,Helvetica,Arial,sans-serif; font-size: 14px; color: #919090; text-align:left; line-height: 16px;'>
                                                            Your marriage is forever, and so are your wedding photos.
To create an album that doesnt make you (and your grandkids) cringe
30 years down the line, its advisable to pay heed to posing tips from
those who mean well...<a href=''  style='color:#eb434e; text-decoration:none'> Read More</a>
                                                         </td>
                                                      </tr>
                                                      <!-- end of content -->
                                                      <!-- Spacing -->
                                                      
                                 </table>
                                  <div style='clear:both;'></div>  
                    
                                </td>
                            </tr>                    
                        </table>
 
 
 </td>
 </tr>
 
 <tr>
 <td  width='100%'>
 
 <table bgcolor='#ffffff' width='640' cellpadding='0' cellspacing='0' border='0' align='center' class='devicewidth'>
                           <tbody>
                              
                              <tr>
                                 <td>
                                    <table width='600' align='center' cellpadding='0' cellspacing='0' border='0' class='devicewidthinner'>
                                       <tbody>
                                         
                                          <tr>
                                             <td width='100%' height='30' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                          
                                         <tr>
                                             <td width='100%'>
                                               <img src='http://www.thexyz.com/images/emailers/vendor-header.jpg' width='600' height='35' alt='' border='0' style='display:block; border:none; outline:none; text-decoration:none; max-width:100%' /></td>
                                          </tr>
                                          
                                          <tr>
                                             <td width='100%' height='20' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                          <!-- Spacing -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                             
                           </tbody>
                        </table>
 
  </td>
 </tr>
 <tr>
 <td >
 <table width='100%' border='0' cellspacing='0' cellpadding='0' align='center' class='full'>
                  <tr>
                   <td width='10' class='sidespace' rowspan='2'>&nbsp;</td>
                  
                    <td width='14%' align='center' style='font:11px  HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;' mc:edit='text25'><img src='http://www.thexyz.com/images/emailers/decor.jpg' width='60' height='60'></td>
                    <td width='2%' style='color:#000000;'  mc:edit='text26'>&nbsp;</td>
                    <td width='14%' align='center' style='font:11px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'  mc:edit='text27'><img src='http://www.thexyz.com/images/emailers/photo.jpg' width='60' height='60' /></td>
                    <td width='2%' style='color:#000000;'  mc:edit='text28'>&nbsp;</td>
                    <td width='14%' align='center' style='font:11px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'  mc:edit='text29'><img src='http://www.thexyz.com/images/emailers/travel.jpg' width='60' height='60'></td>
                    <td width='2%' style='color:#000000;'  mc:edit='text28'>&nbsp;</td>
                    <td width='14%' align='center' style='font:11px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'  mc:edit='text29'><img src='http://www.thexyz.com/images/emailers/jewwllary.jpg' width='60' height='60'></td>
                    <td width='2%' style='color:#000000;'  mc:edit='text28'>&nbsp;</td>
                     <td width='14%' align='center' style='font:11px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'  mc:edit='text29'><img src='http://www.thexyz.com/images/emailers/email.jpg' width='60' height='60'></td><td width='2%' style='color:#000000;'  mc:edit='text28'>&nbsp;</td>
                     
                      <td width='14%' align='center' style='font:11px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'  mc:edit='text29'><img src='http://www.thexyz.com/images/emailers/catering.jpg' width='60' height='60'></td>
                       <td width='10' rowspan='2'>&nbsp;</td>
                  </tr>
                  <tr>
                   <td mc:edit='text25' align='center' style='font:12px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'><a style='color:#eb434e; text-decoration:none;' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/vendor-category/decor-and-lighting/7/')."'> Decor & Lighting </a></td>
                    <td  mc:edit='text26' style='color:#000000;'> </td>
                    <td  mc:edit='text27' align='center' style='font:12px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'><a style='color:#eb434e; text-decoration:none;' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/vendor-category/photographer/5/')."'> Photographer</a></td>
                    <td  mc:edit='text28' style='color:#000000;'></td>
                    <td  mc:edit='text29' align='center' style='font:12px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'><a style='color:#eb434e; text-decoration:none;' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/vendor-category/travel-and-transportation/12/')."'> Travel & Transportation</a></td>
                     <td  mc:edit='text26' style='color:#000000;'> </td>
                    <td  mc:edit='text29' align='center' style='font:12px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'><a style='color:#eb434e; text-decoration:none;' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/vendor-category/jewellery/9/')."'> Jewellery</a></td>
                     <td  mc:edit='text26' style='color:#000000;'> </td>
                    <td  mc:edit='text29' align='center' style='font:12px HelveticaNeueLTStd-Bd,  Helvetica,  Arial, sans-serif; color:#ffffff;'><a style='color:#eb434e; text-decoration:none;' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/vendor-category/invitations/20/')."'> Invitations</a></td>
                     <td  mc:edit='text26' style='color:#000000;'> </td>
                    <td  mc:edit='text29' align='center' style='font:12px HelveticaNeueLTStd-Bd, Helvetica,  Arial, sans-serif; color:#ffffff;'><a style='color:#eb434e; text-decoration:none;' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/vendor-category/catering/8/')."'> Catering</a></td>
                    </tr>
                 
                </table>
 
   </td>
 </tr>
 
 
<tr>
 <td  width='100%'>
 
 <table bgcolor='#ffffff' width='640' cellpadding='0' cellspacing='0' border='0' align='center' class='devicewidth'>
                           <tbody>
                              
                              <tr>
                                 <td>
                                    <table width='360' align='center' cellpadding='0' cellspacing='0' border='0' class='devicewidthinner'>
                                       <tbody>
                                         
                                          <tr>
                                             <td width='100%' height='20' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                          
                                         <tr>
                                             <td width='100%' align='center'>
                                               <img src='http://www.thexyz.com/images/emailers/view-all.jpg' alt='' width='360' height='21' usemap='#Map' style='display:block; border:none; outline:none; text-decoration:none; max-width:100%; text-align:center' border='0' /></td>
                                          </tr>
                                          
                                          <tr>
                                             <td width='100%' height='20' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                          <!-- Spacing -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                             
                           </tbody>
                        </table>
 
   </td>
 </tr>
 
 

 
 <tr>
 <td  width='100%'>
 
 <table bgcolor='#ffffff' width='640' cellpadding='0' cellspacing='0' border='0' align='center' class='devicewidth'>
                           <tbody>
                              
                              <tr>
                                 <td>
                                    <table width='640' align='center' cellpadding='0' cellspacing='0' border='0' class='devicewidthinner'>
                                       <tbody>
                                         
                                          <tr>
                                             <td width='100%' height='10' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                          
                                         <tr>
                                            <td width='100%' align='center' height='1' bgcolor='#eb434e' style='font-size:1px; line-height:1px;'>&nbsp;</td
                                          ></tr>
                                          
                                          <tr>
                                             <td width='100%' height='10' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                          
                                          
                                           <tr>
                                             <td width='100%' >
                                             
                                            <table  width='35%' align='center' border='0' cellpadding='0' cellspacing='0' class='devicewidth1'>
                                       <tbody>
                                          <tr>
                                             <td width='30' height='30' align='center'>
                                                <div class='imgpop'>
                                                   <a target='_blank' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('https://www.facebook.com/xyz/')."'>
                                                   <img src='http://www.thexyz.com/images/emailers/facebook.jpg' alt='' border='0' width='28' height='28' style='display:block; border:none; outline:none; text-decoration:none;'>
                                                   </a>
                                                </div>
                                             </td>
                                             <td align='left' width='15' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                                             <td width='30' height='30' align='center'>
                                                <div class='imgpop'>
                                                   <a target='_blank' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('https://twitter.com/xyzIndia')."'>
                                                   <img src='http://www.thexyz.com/images/emailers/twitter.jpg' alt='' border='0' width='28' height='28' style='display:block; border:none; outline:none; text-decoration:none;'>
                                                   </a>
                                                </div>
                                             </td>
                                             <td align='left' width='15' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                                             <td width='30' height='30' align='center'>
                                                <div class='imgpop'>
                                                   <a target='_blank' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('https://plus.google.com/116397003545848374981')."'>
                                                   <img src='http://www.thexyz.com/images/emailers/g-plus.jpg' alt='' border='0' width='28' height='28' style='display:block; border:none; outline:none; text-decoration:none;'>
                                                   </a>
                                                </div>
                                             </td>
                                              <td align='left' width='15' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                                             <td width='30' height='30' align='center'>
                                                <div class='imgpop'>
                                                   <a target='_blank' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('https://www.youtube.com/channel/UC5hnKLcpvRmX7UtfSosN26A')."'>
                                                   <img src='http://www.thexyz.com/images/emailers/youtube.jpg' alt='' border='0' width='28' height='28' style='display:block; border:none; outline:none; text-decoration:none;'>
                                                   </a>
                                                </div>
                                             </td>
                                               <td align='left' width='15' style='font-size:1px; line-height:1px;'>&nbsp;</td>
                                             <td width='30' height='30' align='center'>
                                                <div class='imgpop'>
                                                   <a target='_blank' href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('https://www.instagram.com/xyzindia/')."'>
                                                   <img src='http://www.thexyz.com/images/emailers/intsagram.jpg' alt='' border='0' width='28' height='28' style='display:block; border:none; outline:none; text-decoration:none;'>
                                                   </a>
                                                </div>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table> 
                                             
                                             
                                             </td>
                                          </tr>
                                           <tr>
                                             <td width='100%' height='10' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                          </tr>
                                          <tr>
                                             <td width='100%' style='font-family:HelveticaNeueLTStd-Bd, Helvetica, arial, sans-serif; font-size: 12px; color: #eb434e; text-align:center; line-height: 16px;'> © 2016 Copyright - xyz</td>
                                          </tr>
                                         <tr>
                                             <td width='100%' height='10' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                         </tr>
                                         <tr>
                                         <td width='100%'>
                                         <table bgcolor='#ffffff' width='640' cellpadding='0' cellspacing='0' border='0' align='center' class='devicewidth'>
				<tr>
					<td align='center'>
						<p>
							<a href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/')."' style='font-family:HelveticaNeueLTStd-Bd, Helvetica, arial, sans-serif; font-size: 12px; color: #eb434e; text-align:center; line-height: 16px;'>Update Profile </a> <span  style='font-family: Helvetica, arial, sans-serif; font-size: 12px; color: #eb434e; text-align:center; line-height: 16px;'>|</span>
							<a href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/')."' style='font-family:HelveticaNeueLTStd-Bd, Helvetica, arial, sans-serif; font-size: 12px; color: #eb434e; text-align:center; line-height: 16px;'>Unsubscribe </a> <span  style='font-family: Helvetica, arial, sans-serif; font-size: 12px; color: #eb434e; text-align:center; line-height: 16px;'>|</span>
							<a href='".DEFAULT_URL."track.php?id=".$sendPost->base64_url_encode($track_id)."&link=".$sendPost->base64_url_encode('http://www.xyz.com/privacy-policy/')."' style='font-family:HelveticaNeueLTStd-Bd, Helvetica, arial, sans-serif; font-size: 12px; color: #eb434e; text-align:center; line-height: 16px;'>Privacy</a>
						</p>
					</td>
				</tr>
			</table>
                                         
                                         
                                         </td>
                                         </tr>
                                         <tr>
                                           <td width='100%' height='15' style='font-size:1px; line-height:1px; mso-line-height-rule: exactly;'>&nbsp;</td>
                                         </tr>
                                          <!-- Spacing -->
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                             
                           </tbody>
                        </table>
 </td>
 </tr>
 
</table>
</td>
</tr>

</table>



<map name='Map' id='Map'>
  <area shape='rect' coords='150,1,209,21' href='#' />
</map>
</body>
</html>

";

//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//echo htmlentities($mail->Body);
if(!$mail->send())
{
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