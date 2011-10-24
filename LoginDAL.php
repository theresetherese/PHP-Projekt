<?php

	require_once("DB_settings.php");

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
		
		public function CheckUsernameExists (User $user){
			//Save username	
			$username = $user->GetUsername();
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
				throw new Exception("Database Error.", 1);
					
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
				throw new Exception("Database Error.", 1);
					
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
			$ip = $user->GetIP();
			
			if($stmt = $this->myConnection->prepare("INSERT INTO User VALUES('',?,?,'',?)")){
				$stmt->bind_param("sss", $username, $password, $ip);
				$stmt->execute();
				$stmt->close();
				return true;
			}
			else{
				throw new Exception("Database Error.", 1);
					
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
				throw new Exception("Database Error.", 1);
					
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
				throw new Exception("Database Error.", 1);
					
			}
			
			$this->myConnection->close();
		}
		
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