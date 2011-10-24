<?php
	
	require_once 'LoginDAL.php';
	require_once 'Constants.php';
	
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
			if($loginDAL->CheckUsernameExists($user) == true){
				
				//If username exists, and the password matches it, set loggedIn to true
				if($loginDAL->ComparePassword($user) == true){
					$_SESSION[Constants::LoggedInSessionKey] = Constants::LoggedInSessionValue;
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
			if($loginDAL->CheckUsernameExists($user) == true){
				
				//If username exists, and the cookies matches set session to logged in
				if($loginDAL->CompareCookie($user) == true){
					$_SESSION[Constants::LoggedInSessionKey] = Constants::LoggedInSessionValue;
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
			unset($_SESSION[Constants::LoggedInSessionKey]);
		}
		
		//Return true if user is logged in
		public function IsLoggedIn(){
			if(isset($_SESSION[Constants::LoggedInSessionKey])){
				if($_SESSION[Constants::LoggedInSessionKey] == Constants::LoggedInSessionValue){	
					return true;
				}
			}
			//Ingen är inloggad
			return false;
		}
		
		//Save cookieinfo
		public function KeepUserLoggedIn(User $user){
			$loginDAL = new LoginDAL();
			$loginDAL->KeepUserLoggedIn($user);
		}
	}