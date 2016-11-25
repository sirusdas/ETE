<?php
/**
 * @sirus
 */
//error handling
ini_set('display_errors',0);
error_reporting(E_ALL);
$current_dir = getcwd();

//including configuration file
include_once($current_dir.'/include/config.inc.php');

//common class to include common functions used in all API
//echo LIB_PATH."/common.class.php"; die('mara');
include_once(LIB_PATH."/common.class.php");
$common = new Common();
switch($_POST['mode'])
{
	case "campaign":
		include_once(CLASS_PATH."/data.class.php");
		include_once(CAMPAIGN_CLASS_PATH.'/campaign.php');
		$jobObj = new CampaignClass();
		$jobObj->Campaign_Controller();
		break;
	case "tracker":
		include_once(CLASS_PATH."/data.class.php");
		include_once(TRACKER_CLASS_PATH.'/tracker.php');
		$jobObj = new TrackerClass();
		$response =$jobObj->Tracker_Controller();
		break;
	default:
		$common->senderror(500,"No Such Url is Present");
		//echo "No Such Url is Present";
		break;
}