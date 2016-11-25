<?php
/**
 * @Sirus
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
	public function Campaign_Controller()
	{
		global  $common, $REQUEST_ARR;
		switch($_SERVER['REQUEST_METHOD']){
			case 'PUT':
				break;
			case 'POST':
				include_once(CAMPAIGN_CLASS_PATH."/campaign.post.php");
				//this makes sure the URLS are getting clicked
				//var_dump($_POST);
				if($_POST['mode']=='campaign'){//die('mara');
					$campaignObj = new CampaignGet();
					$response=$campaignObj -> track_campaign($_POST['campaign_id']);
					if($response){
						return $response;
					}
					break;
				}
			case 'DELETE':
				break;
			case 'GET':
				break;
		}//campaign Controller ends
	}//class ends
}
?>