<?php
/**
 * @sirus
 */
class TrackerGet{
	
	public function __construct(){
		
	}//nothing folks ... :)
	
/* 	public function error_list($type,$info){
		$result .=[$type => $info];
	} */
//this is used to insert a new row of the URL getting cliked
	public function track_clicked_link($track_id, $link){
		if($_GET){
			//echo $details->country.$details->region.$details->city; // city
				$dbObj = new Data();
				$result = $dbObj->insert_clicked_link($track_id, $link);
		}// if ends
		else{
			echo "Who knows what... it was not a post request Folks??? :D";
		}
	}
	
/* //this is used to update a new row of the URL getting cliked
	public function track_update_link($track_id,$link){
		if($_GET){
			//echo $details->country.$details->region.$details->city; // city
			$dbObj = new Data();
			$result = $dbObj->update_clicked_link($track_id, $link);
		}// if ends
		else{
			echo "Who knows what... it was not a post request Folks??? :D";
		}
	}
	 */
//this is used to update about the client ip and device info
	public function track_user_info($track_id,$email_id, $camp_id){	
		if($_GET){
			$flag = 0;
			require_once dirname(__FILE__).'/Mobile_Detect.php';
			$detect = new Mobile_Detect;
			$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
			if(empty($deviceType)){
				//do something folks
				$result .= ["Device Type" => "Empty"];
				//error_list("Device Type","Empty");
				$flag = 1;
			}
			//echo $deviceType."<br>";
			//echo htmlentities($_SERVER['HTTP_USER_AGENT']);
			$data = htmlentities($_SERVER['HTTP_USER_AGENT']);
			
			if(!empty($data)){
				$deviceInfo = explode("(", $data);
			//echo $deviceInfo[1]."<br>";
			$deviceInfo = explode(")", $deviceInfo[1]);
			$computer_info = $deviceInfo[0];
			$browser_info = $deviceInfo[1];
			//echo $computer_info." and ".$browser_info;
			}
			else{
				//do something folks
				$result .= ["Device Info" => "Empty"];
				//error_list("Device Info","Empty");
				$flag = 1;
			} //$data
			
			/*
			 * Trying to get the IP address and info....
			 */
			
			$details = json_decode(file_get_contents("http://ipinfo.io/"));
			if(empty($details->ip)&&empty($details->country)&&empty($details->region)&&empty($details->city)){
				//do something folks
				$result .= ["IP Details" => "Extraction Failed. Please Check internet connection"];
				//error_list("IP Details","Extraction Failed. Please Check internet connection");
				$flag = 1;
			}
			//echo $details->country.$details->region.$details->city; // city
			if($flag == 0){
				$dbObj = new Data();
				$result = $dbObj->update_client_details($track_id,$email_id, $camp_id,$deviceType,$computer_info,$browser_info,$details->ip,$details->country,$details->region,$details->city);
				
			}
			echo json_encode( $result );
/* 			else{
				return error_list();
			} */
		}// if ends
		else{
			echo "Who knows what... it was not a post request Folks??? :D";
		}
	}

//this is used to get all the contents from the db and send a json response
	public function trackGetAll(){
		if($_GET){
			$flag = 0;
			//echo $details->country.$details->region.$details->city; // city
			if($flag == 0){
				$dbObj = new Data();
				$result = $dbObj->retrive_client_details();
			}
			echo json_encode( $result );
		}// if ends
		else{
			echo "Who knows what... it was not a post request Folks??? :D";
		}
	}
}