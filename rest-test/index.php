<?php
/**
 * REST API index file to route controll to he different REST controller.
 * created by Uttam Kumar date 19/06/2016
 * @link http://trickyuk001.test.com/test/
 * @copyright 2016-Swiss Medis Test, Inc. 
 * @author uttam kumar <trickyuk001@gmail.com>
 * @package resttest
 * @version 1.0.0
 */
//error handling
ini_set('display_errors',1);
error_reporting(E_ALL);
$current_dir = getcwd();

//including configuration file
include_once($current_dir.'\include\config.inc.php');

//common class to include common functions used in all API
include_once(LIB_PATH."/common.class.php");
$common = new Common();
switch($_GET['mode'])
{
	case "user":
		include_once(CLASS_PATH."/data.class.php");
		include_once(CLASS_PATH.'/user.php');
		$jobObj = new UserClass();
		$jobObj->User_controller();
		break;
	default:
	echo "No Such Url is Present.";
	break;
}