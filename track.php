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
//var_dump($_GET);
$sendPost = new Common();
if($_GET){
	//$_GET['sendMail']=1;//needs to be corrected
	//this makes sure the URLS are getting clicked
	if(!empty($_GET['id']) && !empty($_GET['link'])){
		$link = $sendPost -> base64_url_decode($_GET['link']);$id = $sendPost -> base64_url_decode($_GET['id']);
		$requestType="";//keeping it blank for now
		//now lets send a CURL request
		$data = htmlentities($_SERVER['HTTP_USER_AGENT']);
		$received_data = $sendPost -> getDeviceInfo($data);//lets get the device info
		//array_push($received_data,'mode' => 'tracker', 'id' => $id, 'link' => $link);
		$received_data +=['mode' => 'tracker', 'id' => $id, 'link' => $link];
		//var_dump($received_data);
		$sendPost -> sendCURL(DEFAULT_URL, $received_data, $requestType);//curl send
		//die('mara');
		//lets redirect
		ob_clean();
		ob_flush();
		header( "Location:".$link );//should redirect
			
		//echo '<script>window.location='.$link.'</script>';
	}
	else{
		//this is to update the user info when an image is loaded
		if(!empty($_GET['id'])){
			$id = $sendPost -> base64_url_decode($_GET['id']);
			//now lets send a CURL request
			//$received_data = array('mode' => 'tracker','id' => $id);
			$requestType="";//keeping it blank for now
			//before making the curl call let us get some device info using the below code
			$data = htmlentities($_SERVER['HTTP_USER_AGENT']);
			$received_data = $sendPost -> getDeviceInfo($data);
			//array_push($received_data,"'mode' => 'tracker'","'id' => $id");
			$received_data +=['mode' => 'tracker', 'id' => $id];
				//sending a curl request
				$sendPost -> sendCURL(DEFAULT_URL, $received_data, $requestType);
				$im = imagecreatetruecolor(1, 1);
				$white = imagecolorallocate($im, 255, 255, 255);
				imagefilledrectangle($im, 0, 0, 0, 0, $white);
				header('Content-Type: image/gif');
				imagegif($im);
				imagedestroy($im);
			}
				
		else{//used to send a Json response with tracking data
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
