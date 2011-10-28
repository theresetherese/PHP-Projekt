<?php
	
	/*
	 * 
	 * Checks if the username and password combination is correct and sets session loggedIn to true or false.
	 * Checks if a user is logged in.
	 * 
	 */
	
	class LoginHandler{
		
		//Start a session if it doesn't exist
		public function __construct(){
			if(isset($_SESSION) == false){	
				session_start();
			}
		}
		
		//Log in user
		public function DoLogin(User $user){
			
			$loginDAL = new LoginDAL();
			
			//Check if username exists	
			if($loginDAL->GetUserByName($user) != false){
				
				//If username exists, and the password matches it, set loggedIn to true
				if($loginDAL->ComparePassword($user) == true){
					$username = $user->GetUsername();
					session_regenerate_id();
					$_SESSION[Constants::LoggedInSessionKey] = Constants::LoggedInSessionValue;
					$_SESSION[Constants::LoggedInUserSessionKey] = $username;
					return true;
				}
				
				//Wrong password
				return false;
			}	
			
			//Wrong username
			return false;	
		}
		
		public function DoCookieLogin(User $user){
			$loginDAL = new LoginDAL();
			
			//Check if username exists	
			if($loginDAL->GetUserByName($user) != false){
				
				//If username exists, and the cookies matches set session to logged in
				if($loginDAL->CompareCookie($user) == true){
					$username = $user->GetUsername();
					session_regenerate_id();
					$_SESSION[Constants::LoggedInSessionKey] = Constants::LoggedInSessionValue;
					$_SESSION[Constants::LoggedInUserSessionKey] = $username;
					return true;
				}
				
				//Wrong cookie or ip
				return false;
			}	
			
			//Wrong username
			return false;	
		}
		
		//Log out user
		public function DoLogout(){
			session_destroy();
		}
		
		//Return true if user is logged in
		public function IsLoggedIn(){
			if(isset($_SESSION[Constants::LoggedInSessionKey])){
				if($_SESSION[Constants::LoggedInSessionKey] == Constants::LoggedInSessionValue){	
					return true;
				}
				return false;
			}
			//Ingen är inloggad
			return false;
		}
		
		//Save cookieinfo
		public function KeepUserLoggedIn(User $user){
			$loginDAL = new LoginDAL();
			$loginDAL->KeepUserLoggedIn($user);
		}
		
		//Get user by name
		public function GetUserByName(User $user){
			$loginDAL = new LoginDAL();
			$user = $loginDAL->GetUserByName($user);
			return $user;
		}
	}