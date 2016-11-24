<?php
/**
 * @sirus
 */


class TrackerClass{
	public function __construct()
	{
	
	}//EO public function __construct()

	public function Tracker_Controller(){
		
		switch($_SERVER['REQUEST_METHOD']){
			case 'PUT':
				break;
			case 'POST':
				break;
			case 'DELETE':
				break;
			case 'GET':
				include_once(TRACKER_CLASS_PATH."/tracker.post.php");
				//this makes sure the URLS are getting clicked
				if(!empty($_GET['id']) && !empty($_GET['link'])){
					$link = $_GET['link'];$id = $_GET['id'];
					$trackerObj = new TrackerGet();
					$trackData = $trackerObj->track_clicked_link($id, $link);//we need to send atleast email and camp id
				}
				else{
					//this is to update the user info with image
					if(!empty($_GET['id']) && !empty($_GET['mail']) && !empty($_GET['camp_id'])){
						$email_id = $_GET['mail']; $camp_id = $_GET['camp_id'];$id = $_GET['id'];
						$trackerObj = new TrackerGet();
						$trackData = $trackerObj->track_user_info($id, $email_id, $camp_id);//we need to send atleast email and camp id
					}
					else{
						//save the dvice info into db
						$trackerObj = new TrackerGet();
						switch($_GET['action']){
							case "tracker" :
								//$trackData = $trackerObj->track();
								break;
							case "getall" : //get all the data from db using json
								$trackData = $trackerObj->trackGetAll();
								break;
							default :
								$common->senderror(500,"this is not a valid action");
						}
					}
				}
				break;
		}
	}
}