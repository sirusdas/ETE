<?php
/**
 * @sirus
 */
include_once(LIB_PATH."/common.class.php");
class TrackerGet{
	
	public function __construct(){
		
	}//nothing folks ... :)
public $result='';
/*
 * Trying to get the latest track id
 */
	public function track_get_latest_track_id($camp_id, $email_id){
		if($_POST){
			//echo $details->country.$details->region.$details->city; // city
			$dbObj = new Data();
			$result = $dbObj->get_latest_track_id($camp_id, $email_id);
			//header('Content-Type: application/json');
			echo json_encode( $result);
		}// if ends
		else{
			$common = new Common();
			$common->senderror(500,"Who knows what... it was not a post request Folks??? :D");
			//echo "Who knows what... it was not a post request Folks??? :D";
		}
	}

	public function track_update_client_details($track_id,$camp_id,$email_id,$sendMail){
		if($_POST){
			$dbObj = new Data();
			$result = $dbObj->update_client_basic_details($track_id,$camp_id, $email_id, $sendMail);
			echo json_encode( $result);
		}// if ends
		else{
			$common = new Common();
			$common->senderror(500,"Who knows what... it was not a post request Folks??? :D");
			//echo "Who knows what... it was not a post request Folks??? :D";
		}
	}
//this is used to insert a new row of the URL getting cliked
	public function track_clicked_link($track_id, $link, $computer_info, $browser_info){
		if($_POST){
			    TrackerGet::track_user_info($track_id, $computer_info, $browser_info);
			    //var_dump($result);die('mara');
				$dbObj = new Data();
				$result = $dbObj->insert_clicked_link($track_id, $link);
				echo json_encode( $result);
		}// if ends
		else{
			$common = new Common();
			$common->senderror(500,"Who knows what... it was not a post request Folks??? :D");
			//echo "Who knows what... it was not a post request Folks??? :D";
		}
	}

//this is used to update about the client ip and device info
	public function track_user_info($track_id, $computer_info, $browser_info){	
		if($_POST){
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
			//$data = htmlentities($_SERVER['HTTP_USER_AGENT']);//this just didnt work as its a serverside file with post request and....GOOGLE
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
				$result = $dbObj->update_client_details($track_id,$deviceType,$computer_info,$browser_info,$details->ip,$details->country,$details->region,$details->city);
				
			}
			echo json_encode( $result );
		}// if ends
		else{
			$common = new Common();
			$common->senderror(500,"Who knows what... it was not a post request Folks??? :D");
			//echo "Who knows what... it was not a post request Folks??? :D";
		}
	}

//this is used to get all the contents from the db and send a json response
/* 	public function trackGetAll(){
		if($_POST){
				$dbObj = new Data();
				$result = $dbObj->retrive_client_details();
				echo json_encode( $result );
		}// if ends
		else{
			$common = new Common();
			$common->senderror(500,"Who knows what... it was not a post request Folks??? :D");
			//echo "Who knows what... it was not a post request Folks??? :D";
		}
	} */
	
	public function trackByPara($email,$type){
		if($_POST){
			$dbObj = new Data();
			$result = $dbObj->retrive_client_details($email,$type);
			echo json_encode( $result );
		}// if ends
		else{
			$common = new Common();
			$common->senderror(500,"Who knows what... it was not a post request Folks??? :D");
			//echo "Who knows what... it was not a post request Folks??? :D";
		}
	}
}