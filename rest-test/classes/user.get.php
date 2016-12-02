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
class UserGet{
	public function __construct()
	{
	
	}//EO public function __construct() 

	public function userView(){
		global $common;
		//user id can be passed as 1,2,3 for multiple users details
		if(!isset($_GET['user_id'])){
				$common->senderror(500,"Please enter valid user id");
		}
		$params['user_id'] = $common->prevent_xss($_GET['user_id']);
		$dbObj = new Data();
		$result = $dbObj->fetch_user_details($params);
		header("Content-Type: application/xml");
		$xml = '<?xml version="1.0" encoding="ISO-8859-1"?><response responseCode="200">';
		$xml .= "<users>";
		foreach($result['data'] as $key=>$value){
			$xml .= "<user>";
			foreach($value as $field=>$val){
				$xml .= '<'.strtolower($field).'><![CDATA['.$val.']]></'.strtolower($field).'>';
			}
			$xml.="</user>";
		}
		$xml .= '</users>';
		$xml .= '</response>';			
		echo $xml;
	}

	/**
	 * function to fetch user list.
	 * @access public
	 * @param no parameter
	 * @return no return
	 */
	public function userList(){
		global $common;
		if(isset($_GET['start']) && isset($_GET['end'])){	
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
		}
		$dbObj = new Data();
		#var_dump($params);
		$result = $dbObj->fetch_user_list($params);		
		header("Content-Type: application/xml");
		$xmlMeta = "<start>" . $params['start'] . "</start>";
		$xmlMeta .= "<end>" . $params['end'] . "</end>";
		$xmlMeta .= "<total>" . $result['total'] . "</total>";

		$xml = '<?xml version="1.0" encoding="ISO-8859-1"?><response responseCode="200">';
		$xml .= "<meta>" . $xmlMeta . "</meta>";
		$xml .= "<users>";
		foreach($result['data'] as $key=>$value){
			$xml .= "<user>";
			foreach($value as $field=>$val){
				$xml .= '<'.strtolower($field).'><![CDATA['.$val.']]></'.strtolower($field).'>';
			}
			$xml.="</user>";
		}
		$xml .= '</users>';
		$xml .= '</response>';			
		echo $xml;
	}
}
?>