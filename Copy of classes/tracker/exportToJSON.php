
		<?php
		/**
		 * Mobile Detect Library
* - export -
* =====================
*
* Use the resulting JSON export file in other languages
* other than PHP. Always check for 'version' key because
* new major versions can modify the structure of the JSON file.
*
* The result of running this script is the export.json file.
*
* @license     Code and contributions have 'MIT License'
*              More details: https://github.com/serbanghita/Mobile-Detect/blob/master/LICENSE.txt
*
*/
// Included nicejson function to beautify the result JSON file.
// This library is not mandatory.
		if( file_exists(dirname(__FILE__).'/nicejson/nicejson.php') ) {
			include_once dirname(__FILE__).'/nicejson/nicejson.php';
		}
		// Include Mobile Detect.
		require_once dirname(__FILE__).'/Mobile_Detect.php';
		$detect = new Mobile_Detect;
		$json = array(
				// All headers that trigger 'isMobile' to be 'true',
				// before reaching the User-Agent match detection.
				'deviceType' => $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer'),
				// All possible User-Agent headers.
				'deviceInfo' => htmlentities($_SERVER['HTTP_USER_AGENT'])
		);
		$fileName = dirname(__FILE__).'/Mobile_Detect.json';
		// Write the JSON file to disk.11
		// You can import this file in your app.
		if (file_put_contents(
				$fileName,
				function_exists('json_format') ? json_format($json) : json_encode($json)
				)) {
					echo 'Done. Check '.realpath($fileName).' file.';
				}
				else {
					echo 'Failed to write '.realpath($fileName).' to disk.';
				}
