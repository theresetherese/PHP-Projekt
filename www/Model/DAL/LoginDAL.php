<?php

	require_once "DB_settings.php";

	class LoginDAL {
		
		//Create variable to hold DB connection
		private $myConnection = NULL;
		
		
		/**
		 *
		 * Checks if a username exists in the database
		 * 
		 * @param User
		 * @return bool
		 *  
		 */
		
		public function GetUserByName(User $user){
			//Save username	
			$username = $user->GetUsername();
			$id = 0;
			$email = "";
			
			//SQL
			if($stmt = $this->myConnection->prepare("SELECT id, email FROM User WHERE username = ?")){
				$stmt->bind_param("s", $username);
				$stmt->execute();
				$stmt->bind_result($id, $email);
				$stmt->fetch();

				if($id > 0){
					$user->SetUserId($id);
					$user->SetEmail($email);
					//Close
					$stmt->close();
					return $user;
				}
				else{
					//Close
					$stmt->close();
					return false;	
				}
				
			}
			else{
				Log::LogError("Could not get user by name.");
					
			}
			
			//Close
			$this->myConnection->close();
		}
		
		public function GetUserById (User $user){
			//Save username	
			$id= $user->GetUserId();
			$affectedRows = 0;
			
			//SQL
			if ($stmt = $this->myConnection->prepare("SELECT username, email FROM User WHERE id = ?")){
				$stmt->bind_param("i", $id);
				$stmt->execute();
				$stmt->store_result();
				$affectedRows = $stmt->num_rows;
					
				if($affectedRows > 0){
					$stmt->bind_result($id, $email);
					$stmt->fetch();
					$user->SetUserId($id);
					$user->SetEmail($email);
					return $user;
				}
				else{
					return false;	
				}
				
				//Close
				$stmt->close();
				
			}
			else{
				Log::LogError("Could not get user by id.");
					
			}
			
			//Close
			$this->myConnection->close();
		}
		
		/**
		 *
		 * Compares a username and a password
		 * 
		 * @param User
		 * @return bool
		 *  
		 */
		public function ComparePassword(User $user){
			//Save username	and password
			$username = $user->GetUsername();
			$password = $user->GetPassword();
			
			//Variables for storing results
			$usernameResult = "";
			$passwordResult = "";
			
			//SQL
			if ($stmt = $this->myConnection->prepare("SELECT username, password FROM User WHERE username = ? AND password = ?")){
				$stmt->bind_param("ss", $username, $password);
				$stmt->execute();
				$stmt->bind_result($usernameResult, $passwordResult);
				$stmt->fetch();
				
				//Return true if username and password match
				if ($usernameResult == $username && $passwordResult == $password){
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
				Log::LogError("Could not compare passwords.");
					
			}
			
			//Close
			$this->myConnection->close();
		}
		
		
		/*
		 * Compares cookiedata and last used ip
		 * when user logs in with cookie
		 * 
		 */
		public function CompareCookie(User $user){
			//Save cookieData, username and ip
			$username = $user->GetUsername();
			$cookieData = $user->GetCookieData();
			$ip = $user->GetIP();
			
			//Variables for storing results
			$usernameResult = "";
			$cookieDataResult = "";
			$ipResult = "";
			
			//SQL
			if ($stmt = $this->myConnection->prepare("SELECT username, cookie, ip FROM User WHERE username = ?")){
				$stmt->bind_param("s", $username);
				$stmt->execute();
				$stmt->bind_result($usernameResult, $cookieDataResult, $ipResult);
				$stmt->fetch();
				
				//Return true if username, cookie and ip match
				if ($usernameResult == $username && $cookieDataResult == $cookieData && $ipResult == $ip){
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
				Log::LogError("Could not compare cookies.");
					
			}
			
			//Close
			$this->myConnection->close();
		}
		
		/**
		 *
		 * Adds a new user to the database
		 * 
		 * @param User
		 * @return bool
		 *  
		 */
		
		public function AddUser(User $user){
			
			$username = $user->GetUsername();
			$password = $user->GetPassword();
			$email = $user->GetEmail();
			$ip = $user->GetIP();
			$rowsAffected = 0;
			
			if($stmt = $this->myConnection->prepare("INSERT INTO User VALUES('',?,?,?,'',?)")){
				$stmt->bind_param("ssss", $username, $password, $email, $ip);
				$stmt->execute();
				$rowsAffected = $stmt->affected_rows;
				$stmt->close();
				
				if($rowsAffected > 0){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				Log::LogError("Could not add user.");
					
			}
			
			$this->myConnection->close();
			
		}
		
		
		/**
		 *
		 * Deletes a user from the database
		 * 
		 * @param User
		 *  
		 */
		
		public function DeleteUser(User $user){
			$username = $user->GetUsername();
			
			if($stmt = $this->myConnection->prepare("DELETE FROM User WHERE username = ?")){
				$stmt->bind_param("s", $username);
				$stmt->execute();
				$stmt->close();
				
				return true;
			}
			else{
				Log::LogError("Could not delete user.");
					
			}
			
			$this->myConnection->close();
		}
		
		/*
		 * Saves keep user logged in cookie and ip
		 */
		public function KeepUserLoggedIn(User $user){
			$cookieData = $user->GetCookieData();
			$username = $user->GetUsername();
			$ip = $user->GetIP();
			
			if($stmt = $this->myConnection->prepare("UPDATE User SET cookie = ?, ip = ? WHERE username = ?")){
				$stmt->bind_param("sss", $cookieData, $ip, $username);
				$stmt->execute();
				$stmt->close();
				return true;
			}
			else{
				Log::LogError("Could not update cookie and ip in database.");
					
			}
			
			$this->myConnection->close();
		}
		
		//Create a new mysqli connection
		public function __construct() {
											
			$this->myConnection = new mysqli(DB_settings::host, DB_settings::user, DB_settings::pass, DB_settings::database);
			$this->myConnection->set_charset("utf8");
			
			/* check connection */
			if (mysqli_connect_errno()) {
				Log::LogError("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		}
	}