<?php
	
	require_once 'DB_settings.php';
	
	class DishDAL{
		
		//Get user and all dishes
		public function GetDishes(User $user){
			//Save username	
			$userId = $user->GetUserId();
			$usernameResult = "";
			
			//SQL
			if ($stmt = $this->myConnection->prepare("SELECT username FROM User WHERE username = ?")){
				$stmt->bind_param("s", $username);
				$stmt->execute();
				$stmt->bind_result($usernameResult);
				$stmt->fetch();
				
				//Return true if username exists
				if ($usernameResult == $username){
					return true;
				}
				//Else return false
				else{
					return false;
				}
				
				//Close
				$stmt->close();
				
			}
			else{
				throw new Exception("Database Error.", 1);
					
			}
			
			//Close
			$this->myConnection->close();
		}
		
		//Get a specific dish
		
		//Add a dish
		
		//Delete a dish
				
		//Create a new mysqli connection
		public function __construct() {
											
			$this->myConnection = new mysqli(DB_settings::host, DB_settings::user, DB_settings::pass, DB_settings::database);
			$this->myConnection->set_charset("utf8");
			
			/* check connection */
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		}
		
	}
