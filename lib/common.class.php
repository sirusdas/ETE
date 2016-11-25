<?php
/**
 * Edited By Sirus 
 */
class Common
{

  public function __construct()
  {
    
  }//EO public function __construct()
  
  /*
   * Modifying the base64 to remove +/= to -_,
   */
  function base64_url_encode($input) {
  	return strtr(base64_encode($input), '+/=', '-_,');
  }
  
  function base64_url_decode($input) {
  	return base64_decode(strtr($input, '-_,', '+/='));
  }
  
  /**
   * this will receive all the post request
   * @access public
   * @param string $url ... this is the url the request will route to.
   * @params string $data ... this is the array of fields to send it to the route url
   */
  public function sendCURL($received_url, $received_data, $requestType='GET'){
  
  
  	$url = $received_url;
  	$data = $received_data;
    //var_dump($data,$url);
  	//
  	// A very simple PHP example that sends a HTTP POST to a remote site
  	//
  
  	$ch = curl_init();
  
  	curl_setopt($ch, CURLOPT_URL,$received_url);
  	curl_setopt($ch, CURLOPT_POST, 1);
  	curl_setopt($ch, CURLOPT_POSTFIELDS, $received_data);
  
  	// in real life you should use something like:
  	// curl_setopt($ch, CURLOPT_POSTFIELDS,
  	//          http_build_query(array('postvar1' => 'value1')));
  
  	// receive server response ...
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  	$server_output = curl_exec ($ch);
  
  	curl_close ($ch);
  
  	// further processing ....
  	if ($server_output == "OK") {
  		echo $server_output; 
  	} 
  	else {
  		  return $server_output;
  	}
  }

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
  
  /*
   *This is a common function to display a success message.
   */
  
  public function sendMessage($response_code, $message){
  	// set the content type
  	header('Content-Type: application/json');
  	if(!is_array($message)){
  		$message = array($message);
  	}
  	echo $this->getMessageJson($response_code, $message);
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
    header('Content-Type: application/json');  
	
	if(!is_array($message)){
		$message = array($message);
	}
	echo $this->getErrorJson($response_code, $message);

	//@ob_flush();
	//exit;
  }//EO public function senderror($error_code, $message = '')

   /**
	 * construct errorJson as response to error.
	 * @access public
	 * @param int $response code The int to be processed
	 * @params string $message The string errormessage
	 * @return string $error_Json as Json String
	 */ 
  private function getErrorJson($response_code, $messages = array()){
	$error_json = array(['Error Code'=> $response_code]);
	foreach($messages as $msg){
		array_push($error_json,['Error Message' => $msg]);
	}
	return json_encode($error_json);
  }
  
  
  private function getMessageJson($response_code, $messages = array()){
  	$msg_json = array(['Success Code'=> $response_code]);
  	foreach($messages as $msg){
  		array_push($msg_json,['Success Message' => $msg]);
  	}
  	return  json_encode($msg_json);
  }

}
?>