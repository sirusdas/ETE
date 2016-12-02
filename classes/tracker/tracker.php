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
				//$_POST['sendMail']=1;
				//this makes sure the URLS are getting clicked
				if(!empty($_POST['type']) ){
				    if($_POST['type']=='insert'){
					$camp_id = $_POST['camp_id'];
					$email_id = $_POST['email_id'];
					$trackerObj = new TrackerGet();
					$response=$trackerObj -> track_get_latest_track_id($camp_id, $email_id);
					if($response){
						return $response;
					}
                                     }					
				}
				else{
					if(!empty($_POST['id']) && !empty($_POST['link'])){
						$link = $_POST['link'];$id = $_POST['id'];$computer_info = $_POST['computer_info'];$browser_info = $_POST['browser_info'];
						$trackerObj = new TrackerGet();
						$trackData = $trackerObj->track_clicked_link($id, $link, $computer_info,$browser_info);
						return $trackData;
					}
					else{
						//this will update the initial client details
						if(!empty($_POST['track_id']) && !empty($_POST['camp_id']) && !empty($_POST['email_id'])){
							$camp_id = $_POST['camp_id']; $email_id= $_POST['email_id']; $sendMail= 0; $tack_id= $_POST['track_id'];
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
									$trackerObj = new TrackerGet();
									if($_POST['action']=='getall' && !empty($_POST['action'])){
											$trackData = $trackerObj->trackByPara('','');
											return $trackData;
									}
									if(!empty($_POST['mail'])){
											$email = $_POST['mail'];
											$trackData = $trackerObj->trackByPara($email,'mail');
											return $trackData;
									}
								}
						}
					}
				}
				break;
			case 'DELETE':
				break;
			case 'GET':
				break;
			default:
				$sendError= new Common();
				$sendError -> senderror(404,'Unknown Request');
		}
	}
}