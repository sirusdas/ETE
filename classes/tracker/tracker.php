<?php
/**
 * @sirus
 */

include_once(LIB_PATH."/common.class.php");
class TrackerClass{
	public function __construct()
	{
	
	}//EO public function __construct()
/*
 * This will help you route to the exact function for the specific request
 */
	public function Tracker_Controller(){
		
		switch($_SERVER['REQUEST_METHOD']){
			case 'PUT':
				break;
			case 'POST':
				include_once(TRACKER_CLASS_PATH."/tracker.post.php");
				//var_dump($_POST);
				$_POST['sendMail']=1;
				//this makes sure the URLS are getting clicked
				if($_POST['type']=="insert"){
					$trackerObj = new TrackerGet();
					$response=$trackerObj -> track_get_latest_track_id();
					if($response){
						return $response;
					}	
				}
				if(!empty($_POST['id']) && !empty($_POST['link'])){
					$link = $_POST['link'];$id = $_POST['id'];
					$trackerObj = new TrackerGet();
					$trackData = $trackerObj->track_clicked_link($id, $link);//we need to send atleast email and camp id
					return $trackData;
				}
				else{
					//this will update the initial client details
					if(!empty($_POST['track_id']) && !empty($_POST['camp_id']) && !empty($_POST['email_id']) && !empty($_POST['sendMail'])){
						$camp_id = $_POST['camp_id']; $email_id= $_POST['email_id']; $sendMail= $_POST['sendMail']; $tack_id= $_POST['track_id'];
						$trackerObj = new TrackerGet();
						$trackData = $trackerObj->track_update_client_details($track_id, $camp_id, $email_id, $sendMail);
						return $trackData;
					}
					else{
							//this is to update the user info when an image is loaded
							if(!empty($_POST['id'] && $_POST['computer_info'] && $_POST['browser_info'])){
								$id = $_POST['id'];$computer_info = $_POST['computer_info'];$browser_info = $_POST['browser_info'];
								$trackerObj = new TrackerGet();
								$trackData = $trackerObj->track_user_info($id,$computer_info,$browser_info);
								return $trackData;
							}
							else{
								//save the device info into db
								$trackerObj = new TrackerGet();
								switch($_POST['action']){
									case "getall" : //get all the data from db using json
										$trackData = $trackerObj->trackGetAll();
										return $trackData;
										break;
									default :
										$common = new Common();
										$common->senderror(500,"this is not a valid action");
								}
							}
					}
				}
				break;
			case 'DELETE':
				break;
			case 'GET':
				break;
		}
	}
}