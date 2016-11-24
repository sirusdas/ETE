<?php
/**
 * campaign class contains all control logic for all required request method.
* created by Uttam Kumar date 19/06/2016
* @link http://trickyuk001.test.com/test/
* @copyright 2016-Swiss Medis Test, Inc.
* @author uttam kumar <trickyuk001@gmail.com>
* @package rest-test
* @version 1.0.0
*/
class CampaignClass
{

	public function __construct()
	{

	}//EO public function __construct()

	/**
	 * controller to include functions as per the request method.
	 * @access public
	 * @param no parameter
	 * @return no return
	 */
	public function campaign_controller()
	{
		global  $common, $REQUEST_ARR;
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'PUT':
				 
				break;

			case 'POST':
				break;

			case 'DELETE':
				break;

			case 'GET':
				include_once(CAMPAIGN_CLASS_PATH."/campaign.get.php");
				$campaignObj = new CampaignGet();
				$campaignObj->campaignList();
/* 				switch($_GET['action']){
					case "list" :
						$campaignObj->campaignList();
						break;
					case "detail" :
						$campaignObj->campaignView();
						break;
					default :
						$common->senderror(500,"this is not a valid action");
				} */
		} // EO switch($_SERVER['REQUEST_METHOD'])
	} //EO public function campaign_controller()
}
?>