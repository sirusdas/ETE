<?php
/**
 * user class contains all control logic for all required request method.
 * created by Uttam Kumar date 19/06/2016
 * @link http://trickyuk001.test.com/test/
 * @copyright 2016-Swiss Medis Test, Inc. 
 * @author uttam kumar <trickyuk001@gmail.com>
 * @package rest-test
 * @version 1.0.0
 */
class UserClass
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
  public function user_controller()
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
				include_once(CLASS_PATH."/user.get.php");
				$userObj = new UserGet();
				switch($_GET['action']){
					case "list" : 
								$userObj->userList();
							break;
					case "detail" :
							$userObj->userView();
							break;
					default :
						 $common->senderror(500,"this is not a valid action");
				}
	} // EO switch($_SERVER['REQUEST_METHOD'])
  } //EO public function user_controller()
}
?>