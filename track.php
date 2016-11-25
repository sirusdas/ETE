<?php
/**
 * @sirus
 * this page must be filled with CURL request routing and much more
 * All client the request will get form here folks and call the tracker.post.php
 * 
 */
$current_dir = getcwd();
include_once($current_dir.'/include/config.inc.php');
include_once($current_dir.'/lib/common.class.php');

$sendPost = new Common();
			if($_GET){
				//$_GET['sendMail']=1;//needs to be corrected
				//this makes sure the URLS are getting clicked
				if(!empty($_GET['id']) && !empty($_GET['link'])){
					$link = $sendPost -> base64_url_decode($_GET['link']);$id = $sendPost -> base64_url_decode($_GET['id']);
					$requestType="";//keeping it blank for now
					//now lets send a CURL request
					$received_data = array('mode' => 'tracker','id' => $id, 'link' => $link);
					$sendPost -> sendCURL(DEFAULT_URL, $received_data, $requestType);//curl send
					//lets redirect
					header( "Location:$link" );//should redirect
				}
				else{
						//this is to update the user info when an image is loaded
						if(!empty($_GET['id'])){
							$id = $sendPost -> base64_url_decode($_GET['id']);
							//now lets send a CURL request
							$received_data = array('mode' => 'tracker','id' => $id);
							$requestType="";//keeping it blank for now
							//before making the curl call let us get some device info using the below code
							$data = htmlentities($_SERVER['HTTP_USER_AGENT']);
								
							if(!empty($data)){
								$deviceInfo = explode("(", $data);
								//echo $deviceInfo[1]."<br>";
								$deviceInfo = explode(")", $deviceInfo[1]);
								$computer_info = $deviceInfo[0];
								$browser_info = $deviceInfo[1];
								//putting everything we got into an array
								$received_data = array('mode' => 'tracker','id' => $id,'computer_info' => $computer_info, 'browser_info' => $browser_info);
								//sending a curl request
								$sendPost -> sendCURL(DEFAULT_URL, $received_data, $requestType);
							}
							else{
								$common = new Common();
								$common->senderror(500,"No Deive info was found");
								//echo "No Deive info was found";
							}
							
						}
						else{
							if(!empty($_GET['action']) && $_GET['action']=='getall'){
								//lets get all the details about client
								$requestType = '';
								$received_data = array('mode' => 'tracker','action' => 'getall');
								echo $sendPost -> sendCURL(DEFAULT_URL, $received_data, $requestType);
							}
							if(!empty($_GET['mail'])){
								$email = $_GET['mail'];
								//lets get all the details about client
								$requestType = '';
								$received_data = array('mode' => 'tracker','mail' => $email);
								echo $sendPost -> sendCURL(DEFAULT_URL, $received_data, $requestType);
							}
						}

				}//else closed
				
		}
	