<?php

/*
 * 
 * Checks for different user states and presents the right information from LoginView.php
 * Calls DoLogin() and DoLogout() from LoginHandler.php
 * 
 */

	require_once "./Model/LoginHandler.php";
	require_once "./Model/User.php";
	require_once "./View/LoginView.php";
	
	class LoginController {
		
		/*
		 * Creates view and handler. Presents different views if user is logged in or not.
		 * Checks if user tries to login, collects user input and sends it to handler.
		 * Checks if user has cookies
		 * 
		 */
		public function DoControll(){
			
			//Create LoginView and LoginHandler
			$loginView = new LoginView();
			$loginHandler = new LoginHandler();
			
			//If user is logged in
			if ($loginHandler->IsLoggedIn() == true){
				$xhtml = $this->DoLoggedIn();
				return $xhtml;				
			}
			//User isn't logged in
			else if ($loginHandler->IsLoggedIn() == false){
				
				//Check if user has cookies
				if($loginView->HasCookies() != false){
					//Try to login with cookies
					$user = $loginView->HasCookies();
					if($loginHandler->DoCookieLogin($user) == true){
						$xhtml = "COOKIELOGIN";	
						$xhtml .= $this->DoLoggedIn();
						
						//Create new cookiedata
						$loginView->KeepUserLoggedIn($user);
					}
					//Cookie login failed
					else {
						$xhtml = $this->DoNotLoggedIn();
					}
				}
				else{				
					$xhtml = $this->DoNotLoggedIn();
				}
				
				return $xhtml;
			}
			//If IsLoggedIn doesn't return true or false, then something is wrong.
			else {
				throw new Exception("Error when generating page.", 1);
			}
		}


		private function DoNotLoggedIn(){
			//Create LoginView and LoginHandler
			$loginView = new LoginView();
			$loginHandler = new LoginHandler();
			
			//Text + loginbox
			$xhtml = $loginView->DoLoginText();
			$xhtml .= $loginView->DoLoginBox();
			$xhtml .= $loginView->DoRegisterLink();
			
			//Check if user tries to log in
			if ($loginView->TriedToLogin() == true){
				
				//Proceed if form is filled
				if ($loginView->GetUser() != false){
					
					//Save user info
					$user = $loginView->GetUser();
					
					//DoLogin()
					if($loginHandler->DoLogin($user) == true){
						
						//Set Cookies if user wants to be logged in
						if ($loginView->KeepLoggedIn() == true){
							$user = $loginView->KeepUserLoggedIn($user);
							$loginHandler->KeepUserLoggedIn($user);
						}
						
						//Logged in!
						$xhtml = $this->DoLoggedIn();
						
					}
					//If wrong username and password
					else {
						$xhtml = $loginView->DoWrongCredentialsText();
						$xhtml .= $loginView->DoLoginBox();
						$xhtml .= $loginView->DoRegisterLink();
					}
				}
				//Form isn't filled correctly
				else{
					$xhtml = $loginView->DoWrongCredentialsText();
					$xhtml .= $loginView->DoLoginBox();
					$xhtml .= $loginView->DoRegisterLink();
				}
				
			}
			return $xhtml;
		}

		private function DoLoggedIn(){
			//Create LoginView and LoginHandler
			$loginView = new LoginView();
			$loginHandler = new LoginHandler();
			
			//Text + logoutbox
			$xhtml = $loginView->DoLoggedInText();
			$xhtml .= $loginView->DoLogoutBox();
			
			//Check if user tries to log out
			if($loginView->TriedToLogout() == true){
				
				//Log out
				$loginHandler->DoLogout();
				
				//Delete cookies on user aagent
				$loginView->DeleteCookies();
				
				$xhtml = $loginView->DoLoggedOutText();
				$xhtml .= $loginView->DoLoginBox();
				$xhtml .= $loginView->DoRegisterLink();
			}
			
			return $xhtml;
		}
	}		
			