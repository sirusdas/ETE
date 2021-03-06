<?php
/**
 * @sirus
 */
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
				$sql = "SELECT * FROM `campaign` WHERE `id` =".$params;
				$data = mysqli_query($this->dblink,$sql);
				
				if (mysqli_num_rows($data) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($data)) {
						$result= ["id" => $row["id"], "name" => $row["name"], "Created Date" => $row["date_created"]];
					}
				} 
	              
			}
			else{
				$sql = "SELECT * FROM `campaign`;";
				$data = mysqli_query($this->dblink,$sql);
				
				if (mysqli_num_rows($data) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($data)) {
						$result[]= ["id" => $row["id"], "name" => $row["name"], "Created Date" => $row["date_created"]];
						
					}
				}
			}
			return $result;
		}//fetch campaign ends
		
		public function insert_client_details($camp_id,$email_id,$mail_delivered){
			$sql = "INSERT INTO `tracker` (`id`, `camp_id`, `email_id`, `mail_opened`, `mail_delivered`, `created_date`, `country`, `state`, `city`, `device`, `ip`, `browser`, `os`,`updated_date`) VALUES ('', '".$camp_id."', '".$email_id."', 0, '".$mail_delivered."', CURRENT_TIMESTAMP, '', '', '', '', '', '', '', '');";
			
			if (mysqli_query($this->dblink,$sql)) {
				//echo "New record created successfully";
				return "Success";
			} else {
				return  "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		//update contents and needs email id and camp_id and updated date to do so
		public function update_client_details($track_id, $email_id, $camp_id,$deviceType,$computer_info,$browser_info,$ip,$country,$region,$city){
			$date = date('Y-m-d H:i:s');
			$sql = "UPDATE `tracker` SET  `mail_opened`= 1, `country`='".$country."', `state`='".$region."', `city`='".$city."', `device`='".$deviceType."', `ip`='".$ip."', `browser`='".$browser_info."', `os` = '".$computer_info."',`updated_date` = '".$date."' WHERE email_id = '".$email_id."' AND camp_id = ".$camp_id." AND id = ".$track_id.";";
				
			if (mysqli_query($this->dblink,$sql)) {
				//echo "New record created successfully";
				return "Update Successful";
			} else {
				return  "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
		}
		
		//this will insert all the links into the database
		public function insert_clicked_link($track_id, $link){
			$track_check = Data::getTrackDetails($track_id, $link);
			//echo $track_check;die();
			if($track_check == false){
				$sql = "INSERT INTO `url_tracked` (`id`, `track_id`, `url_clicked`, `url_count`, `created_date`, `updated_date`) VALUES (NULL, '".$track_id."', '".$link."', '1', CURRENT_TIMESTAMP, '');";
				if (mysqli_query($this->dblink,$sql)) {
					//echo "New record created successfully";
					header( "Location:$link" );//should redirect
					//return "Inserted a Row Successful";
				} else {
					return  "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
				echo "<script>window.location = '".$link."'</script>";
			}
			else{//we will update the db
				$sql = "UPDATE `url_tracked` SET `url_count`= url_count + 1 ,`updated_date`= 'CURRENT_TIMESTAMP' WHERE `track_id`=".$track_id."  AND `url_clicked`='".$link."' ;";
				if (mysqli_query($this->dblink,$sql)) {
					//echo "New record created successfully";
					header( "Location:$link" );//should redirect
					//return "Inserted a Row Successful";
				} else {
					return  "Error: " . $sql . "<br>" . mysqli_error($conn);
				}
				//header( "Location:$link" );//should redirect
				echo "<script>window.location = '".$link."'</script>";
				
			}
			
			
			//header( "Location:$link" );//should redirect
			//echo "<script>window.location = '".$link."'</script>";
		}
		
		//this will update all the links into the database
/* 		public function update_clicked_link($track_id,$link){
			$sql = "UPDATE table `url_tracked` SET `url_count`= url_count + 1 ,`updated_date`= CURRENT_TIMESTAMP WHERE `track_id`=".$track_id."  AND `url_clicked`=".$link." ;";
			if (mysqli_query($this->dblink,$sql)) {
				//echo "New record created successfully";
				header( "Location:$link" );//should redirect
				//return "Inserted a Row Successful";
			} else {
				return  "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
			//header( "Location:$link" );//should redirect
			echo "<script>window.location = '".$link."'</script>";
		} */
		
		//get latest track_id
		public function get_latest_track_id(){
			$sql = "SELECT MAX(id) AS id FROM tracker";
			$data = mysqli_query($this->dblink,$sql);
			
			if (mysqli_num_rows($data) > 0) {
				// output data of each row
				while($row = mysqli_fetch_assoc($data)) {
					$result= $row["id"];
				}
			}
			else{
				$result=1;
			}
			return $result;
		}
		
		//lets check if the track id and link exist
		public function getTrackDetails($track_id, $link){
			$sql = "SELECT * FROM url_tracked where track_id = ".$track_id." AND url_clicked = '".$link."'";
			$data= mysqli_query($this->dblink, $sql);
			
			if(mysqli_num_rows($data)>0){
				return true;
			}
			else{
				return false;
			}
		}
		
		
		//will be used to get the details from db and present it in json format
		public function retrive_client_details(){
			$data = array();
			$result =array();
				$sql = "SELECT * FROM `tracker`;";
				$data = mysqli_query($this->dblink,$sql);
		
				if (mysqli_num_rows($data) > 0) {
					// output data of each row
					while($row = mysqli_fetch_assoc($data)) {
						$result[]= ["id" => $row["id"], "Campaign ID" => $row["camp_id"], "Email ID" => $row["email_id"], "Mail Delivered" => $row["mail_delivered"], "Created Date" => $row["created_date"], "Country" => $row["country"], "State" => $row["state"], "City" => $row["city"], "Device" => $row["device"], "IP" => $row["ip"], "Browser" => $row["browser"], "OS" => $row["os"]];
		
					}
				}
			return $result;
		}
		
		public function update_client_mail_status($status){
			
		}

	}
?>