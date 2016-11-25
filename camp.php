<?php
/**
 * @sirus
* this page must be filled with CURL request routing and much more
* All client the request will get form here folks and call the tracker.post.php
*
*/
error_reporting(E_ALL);
ini_set('display_errors',0);
$current_dir = getcwd();
include_once($current_dir.'/include/config.inc.php');
include_once($current_dir.'/lib/common.class.php');

$sendPost = new Common();
//var_dump($_GET);
//if($_GET){
	//this makes sure the URLS are getting clicked
	$camp_id='';
	if(!empty($_GET['campaign_id'])){
        $camp_id = $_GET['campaign_id'];
		$requestType='';//keeping it blank for now
		//now lets send a CURL request
		$received_data = array('mode' => 'campaign','campaign_id' => $camp_id);
		echo $sendPost -> sendCURL(DEFAULT_URL, $received_data, $requestType);//curl send
	}
	else{
		$requestType='';//keeping it blank for now
		$received_data = array('mode' => 'campaign','campaign_id' => $camp_id);
		echo $sendPost -> sendCURL(DEFAULT_URL, $received_data, $requestType);//curl send
	}//else closed

//}
