<?php
/**
 * Data class contains all functions required to fetch data from database.
 * created by Uttam Kumar date 19/06/2016
 * @link http://trickyuk001.test.com/test/
 * @copyright 2016-Swiss Medis Test, Inc. 
 * @author uttam kumar <trickyuk001@gmail.com>
 * @package rest-test
 * @version 1.0.0
 */
class Common
{

  public function __construct()
  {
    
  }//EO public function __construct()

  /**
	 * Prevent Cross-Site Scripting attacks from taking place.
	 * @access public
	 * @param string $str The string to be processed
	 * @return string $str The modified string
	 */
  public function prevent_xss($str)
  {
    if(!isset($str)){
		return false;
	}
	if (is_array($str)) {
      foreach($str as $key => $value){
		$str[$key] = $this->prevent_xss($value);
      }
    } else {
      $str = preg_replace('!<script([^>]*)>!si', '&lt;script$1&gt;', $str);
      $str = preg_replace('!<object([^>]*)>!si', '&lt;object$1&gt;', $str);
      $str = str_replace('</script>', '&lt;/script&gt;', $str);
      $str = preg_replace('!(\S+)script\s*:!si', '$1scriipt:', $str);
      $str = preg_replace('!\bon[a-zA-Z]*\s*=!si', 'onHack=', $str);
    }
    return $str;
  }
 
 /**
	 * send errorxml as response to error.
	 * @access public
	 * @param int $response code The int to be processed
	 * @parans string $message The string errormessage
	 */
   public function senderror($response_code, $message = '')
  {
    // set the content type  
    header('Content-type: text/xml');  
	
	if(!is_array($message)){
		$message = array($message);
	}
	echo $this->getErrorXml($response_code, $message);

	@ob_flush();
	exit;
  }//EO public function senderror($error_code, $message = '')

   /**
	 * construct errorxml as response to error.
	 * @access public
	 * @param int $response code The int to be processed
	 * @params string $message The string errormessage
	 * @return string $error_xml as xml string
	 */ 
  private function getErrorXml($response_code, $messages = array()){
	$error_xml = '<error responseCode="'.$response_code.'">';
	foreach($messages as $msg){
		$error_xml .= '<errorMessage><![CDATA['.$msg.']]></errorMessage>';
	}
	$error_xml .= '</error>';
	return $error_xml;
  }

}
?>