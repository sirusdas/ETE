<?php
/**
 * @sirus
*/
class CampaignGet{
	public function __construct()
	{

	}//EO public function __construct()

	/**
	 * function to fetch user list.
	 * @access public
	 * @param no parameter
	 * @return no return
	 */
	/*
	 * All about tracking
	 */
	public function track_campaign($camp_id){
		if($_POST){
			$dbObj = new Data();
			$result = $dbObj->fetch_campaign_list($camp_id);
			echo json_encode( $result);
		}// if ends
		else{
			$common = new Common();
			$common->senderror(500,"Who knows what... it was not a post request Folks??? :D");
			//echo "Who knows what... it was not a post request Folks??? :D";
		}
	}
}
?>