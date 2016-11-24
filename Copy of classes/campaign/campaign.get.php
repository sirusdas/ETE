<?php
/**
 * UserGet class contains all functions required to fetch user data for all user based API.
* created by Uttam Kumar date 19/06/2016
* @link http://trickyuk001.test.com/test/
* @copyright 2016-Swiss Medis Test, Inc.
* @author uttam kumar <trickyuk001@gmail.com>
* @package rest-test
* @version 1.0.0
*/
class CampaignGet{
	public function __construct()
	{

	}//EO public function __construct()

/* 	public function campaignView(){
		global $common;
		//user id can be passed as 1,2,3 for multiple users details
		if(!isset($_GET['campaign_id'])){
			$common->senderror(500,"Please enter valid campaign id");
		}
		$params['campaign_id'] = $common->prevent_xss($_GET['campaign_id']);
		$dbObj = new Data();
		$result = $dbObj->fetch_user_details($params);
		header("Content-Type: application/json");
		foreach($result['data'] as $key=>$value){
			$json .= "<user>";
			foreach($value as $field=>$val){
				$json .= '<'.strtolower($field).'><![CDATA['.$val.']]></'.strtolower($field).'>';
			}
			$json.="</user>";
		}
		$json .= '</users>';
		$json .= '</response>';
		echo $json;
	} */

	/**
	 * function to fetch user list.
	 * @access public
	 * @param no parameter
	 * @return no return
	 */
	public function campaignList(){
		global $common;
		if(!empty($_GET['campaign_id'])){
			$params = $common->prevent_xss($_GET['campaign_id']);
		}
/* 		if(isset($_GET['start']) && isset($_GET['end'])){
			if(!is_numeric($_GET['start']) || !is_numeric($_GET['end'])){
				$common->senderror(500,"Please enter valid start and end parameter for pagination");
			}
			elseif($_GET['start']>$_GET['end']){
				$common->senderror(500,"Please enter start parameter less than end parameter for pagination");
			}
			else{
					
				$params['start'] = $common->prevent_xss($_GET['start']);
				$params['end'] = $common->prevent_xss($_GET['end']);
			}
		}
		else{
			$params['start'] = 0;
			$params['end'] =10;
		}
		if($_GET['search']){
			$params['search'] = $common->prevent_xss($_GET['search']);
		}
		if($_GET['field'] && $_GET['order']){
			$params['field'] = $common->prevent_xss($_GET['field']);
			$params['order'] = $common->prevent_xss($_GET['order']);
		} */
		if(isset($_GET['campaign_id'])){
			$dbObj = new Data();
			#var_dump($params);
			$result = $dbObj->fetch_campaign_list($params);
			//header("Content-Type: application/json");
		}
		else{
			$dbObj = new Data();
			$result = $dbObj->fetch_campaign_list("");//$params will be empty here
		}
			//echo $result;
			echo json_encode( $result );
	}
}
?>