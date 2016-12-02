<?php
/**
 * @sirus
 */
include_once(LIB_PATH."/common.class.php");
	class Data{
		private $dblink ='';
		/**
		 * function to create database connection.
		 * @access public
		 * @param no parameter
		 * @return no return
		 */
		public function __construct()
		{
			if(!$this->dblink){
				$this->dblink = mysqli_connect(DB_HOST_MYSQL,DB_USER_MYSQL,DB_PASSWORD_MYSQL)	or $this->error(mysql_error()." Mysql connect error at ".date()." on ".$this->server);
				mysqli_select_db($this->dblink,DB_NAME_MYSQL) or $this->error("Mysql select db error at ".@date()." on ".$this->server);
			}
		
		}//EO public function __construct()


		
		/**
		 * function to fetch user list.
		 * @access public
		 * @param no parameter
		 * @return no result 
		 */
		public function fetch_campaign_list($params){
			$data = array();
			$result =array();
			if(!empty($params)){
				//with respect to requested campaign id
				$sql = "SELECT * FROM `campaign` WHERE `id` =".$params;
				if(mysqli_query($this->dblink,$sql)){ $data = mysqli_query($this->dblink,$sql); }
				else{ $common = new Common();$common->logerror($sql,"Error: " . mysqli_error($this->dblink)); }
				
				if (mysqli_num_rows($data) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($data)) {
						$result= ["id" => $row["id"], "name" => $row["name"], "Created Date" => $row["date_created"]];
					}
				} 
	              
			}
			else{
				//all the campaign id
				$sql = "SELECT * FROM `campaign`;";
				if(mysqli_query($this->dblink,$sql)){ $data = mysqli_query($this->dblink,$sql); }
				else{ $common = new Common();$common->logerror($sql,"Error: " . mysqli_error($this->dblink)); }
				
				if (mysqli_num_rows($data) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($data)) {
						$result[]= ["id" => $row["id"], "name" => $row["name"], "Created Date" => $row["date_created"]];
						
					}
				}
			}
			return $result;
		}//fetch campaign ends

		//update contents and needs email id and camp_id and updated date to do so
		public function update_client_details($track_id,$deviceType,$computer_info,$browser_info,$ip,$country,$region,$city){
			$date = date('Y-m-d H:i:s');
			$sql = "UPDATE `tracker` SET  `mail_opened`= 1, `country`='".$country."', `state`='".$region."', `city`='".$city."', `device`='".$deviceType."', `ip`='".$ip."', `browser`='".$browser_info."', `os` = '".$computer_info."',`updated_date` = CURRENT_TIMESTAMP WHERE  id = ".$track_id.";";
				
			if (mysqli_query($this->dblink,$sql)) {
				//echo "New record created successfully";
				return "Update Successful";
			} else {
				$common = new Common();
				$common->logerror($sql,"Error: " . mysqli_error($this->dblink)); 
				//return  "Error: " . $sql . "<br>" . mysqli_error($this->dblink);
			}
		}
		
		//this will insert all the links into the database
		public function insert_clicked_link($track_id, $link){
			$track_check = Data::getTrackDetails($track_id, $link);
			if($track_check == false){
				$sql = "INSERT INTO `url_tracked` (`id`, `track_id`, `url_clicked`, `url_count`, `created_date`, `updated_date`) VALUES (NULL, ".$track_id.", '".$link."', 1, CURRENT_TIMESTAMP, NULL);";
				if (mysqli_query($this->dblink,$sql)) {
					return "Inserted a Row Successful";
				} else {
					$common = new Common();$common->logerror($sql,"Error: " . mysqli_error($this->dblink));
					//return  "Error: " . $sql . "<br>" . mysqli_error($this->dblink);
				}
			}
			else{//we will update the db
				$sql = "UPDATE `url_tracked` SET `url_count`= url_count + 1 ,`updated_date`= CURRENT_TIMESTAMP WHERE `track_id`=".$track_id."  AND `url_clicked`='".$link."' ;";
				if (mysqli_query($this->dblink,$sql)) {
					header( "Location:$link" );//should redirect
				} else {
					$common = new Common();$common->logerror($sql,"Error: " . mysqli_error($this->dblink));
					//return  "Error: " . $sql . "<br>" . mysqli_error($this->dblink);
				}
			}
		}
		
		
		
		//lets check if the track id and link exist
		public function getTrackDetails($track_id, $link){
			$sql = "SELECT * FROM url_tracked where track_id = ".$track_id." AND url_clicked = '".$link."'";
			if(mysqli_query($this->dblink,$sql)){ $data = mysqli_query($this->dblink,$sql); }
			else{ $common = new Common();$common->logerror($sql,"Error: " . mysqli_error($this->dblink)); }
			
			if(mysqli_num_rows($data)>0){
				return true;
			}
			else{
				return false;
			}
		}
		
		
		//will be used to get the details from db and present it in json format
		public function retrive_client_details($para,$type){
			$data = array();
			$result =array();
			
			switch ($type){
				case 'mail':
					//var_dump("ele");
					$sql = "SELECT tracker.* , url_tracked.url_clicked, url_tracked.url_count FROM url_tracked INNER JOIN tracker ON tracker.id = url_tracked.track_id WHERE tracker.email_id ='".$para."'";
					if(mysqli_query($this->dblink,$sql)){ $data = mysqli_query($this->dblink,$sql); }
					else{ $common = new Common();$common->logerror($sql,"Error: " . mysqli_error($this->dblink)); }
					
					if (mysqli_num_rows($data) > 0) {
						// output data of each row
						while($row = mysqli_fetch_assoc($data)) {
							$result[]= ['id' => $row['id'], 'Campaign ID' => $row['camp_id'], 'Email ID' => $row['email_id'], 'Mail Delivered' => $row['mail_delivered'], 'Created Date' => $row['created_date'], 'Country' => $row['country'], 'State' => $row['state'], 'City' => $row['city'], 'Device' => $row['device'], 'IP' => $row['ip'], 'Browser' => $row['browser'], 'OS' => $row['os'], 'URL Clicked' => $row['url_clicked'], 'URL Count' => $row['url_count']];
						}
					}
					break;
				
				default:
					$sql = "SELECT tracker.* , url_tracked.url_clicked, url_tracked.url_count FROM url_tracked INNER JOIN tracker ON tracker.id = url_tracked.track_id ";
					if(mysqli_query($this->dblink,$sql)){ $data = mysqli_query($this->dblink,$sql); }
					else{ $common = new Common();$common->logerror($sql,"Error: " . mysqli_error($this->dblink)); }
					
					if (mysqli_num_rows($data) > 0) {
						// output data of each row
						while($row = mysqli_fetch_assoc($data)) {
							$result[]= ['id' => $row['id'], 'Campaign ID' => $row['camp_id'], 'Email ID' => $row['email_id'], 'Mail Delivered' => $row['mail_delivered'], 'Created Date' => $row['created_date'], 'Country' => $row['country'], 'State' => $row['state'], 'City' => $row['city'], 'Device' => $row['device'], 'IP' => $row['ip'], 'Browser' => $row['browser'], 'OS' => $row['os'], 'URL Clicked' => $row['url_clicked'], 'URL Count' => $row['url_count']];
					
						}
					}
					break;
			}
			
			return $result;
		}
		
		public function update_client_mail_status($status){
			
		}
		/*
		 * Update the db
		 */

		public function update_client_basic_details($track_id,$camp_id,$email_id,$mail_delivered){
			$sql = "UPDATE `tracker` SET camp_id =".$camp_id.", email_id= '".$email_id."', 0, mail_delivered= '".$mail_delivered."', CURRENT_TIMESTAMP, where id= ".$track_id;
				
			if (mysqli_query($this->dblink,$sql)) {
				return "Update Successful";
			} else {
				$common = new Common();$common->logerror($sql,"Error: " . mysqli_error($this->dblink)); 
				//return  "Error: " . $sql . "<br>" . mysqli_error($this->dblink);
			}
		}
		
		//get latest track_id
		public function get_latest_track_id($camp_id, $email_id){
			$sql = "INSERT INTO `tracker` (`id`, `camp_id`, `email_id`, `mail_opened`, `mail_delivered`, `created_date`, `country`, `state`, `city`, `device`, `ip`, `browser`, `os`, `updated_date`) VALUES (NULL,".$camp_id.", '".$email_id."', 0, 0, CURRENT_TIMESTAMP, '', '', '', '', '', '', '', NULL)";
			//$data = mysqli_query($this->dblink,$sql);
				
			if (mysqli_query($this->dblink, $sql)) {
				$last_id = mysqli_insert_id($this->dblink);
				$result= array("id" => $last_id);
			} else {
				 $common = new Common();$common->logerror($sql,"Error: " . mysqli_error($this->dblink));
				 $result='';
			}
			
			mysqli_close($this->dblink);
			return $result;
		}//ends
	}
?>