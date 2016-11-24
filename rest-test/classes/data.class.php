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

		public function fetch_user_details($params){
			$sql = 'SELECT user_id,first_name,last_name,email,role,department,dob,street_address_1,street_address_2,suburb,state,postcode,country FROM user WHERE user_id='.$params['user_id'];
			$data = mysqli_query($this->dblink,$sql);			
			if($data){
				while($row=mysqli_fetch_array($data,MYSQLI_ASSOC)) 
				{
					$result['data'][] = $row;
				}
			}
			#var_dump($result); die();
			return $result;		
		}
		
		/**
		 * function to fetch user list.
		 * @access public
		 * @param no parameter
		 * @return no result 
		 */
		public function fetch_user_list($params){
			$sql = 'SELECT user_id,first_name,last_name,email,role,department FROM user';
			$result = false;
			if($params['field'] && $params['order']){
				$order .= ' ORDER BY '.$params['field'].' '.$params['order'];
			}
			if(isset($params['start']) && isset($params['end'])){
				$length = $params['end'] - $params['start']+1;
				$limit .= ' LIMIT '.$params['start'].','.$length;
			}
			if($params['search']){
				$condition = ' WHERE first_name LIKE "'.$params['search'].'%"';
			}
			$sql.= $condition.$order.$limit;
			$count_sql = "SELECT COUNT(1) as total_count from user";
			$count_sql .= $condition;
			$count_data = mysqli_query($this->dblink,$count_sql);
			if($count_data){
				$total_row = mysqli_fetch_row($count_data);
				#var_dump($total_row);
				$result['total'] = $total_row[0];
			}
			$data = mysqli_query($this->dblink,$sql);			
			if($data){
				while($row=mysqli_fetch_array($data,MYSQLI_ASSOC)) 
				{
					$result['data'][] = $row;
				}
			}
			#var_dump($total_row,$result);
			return $result;
			
		}

	}
?>