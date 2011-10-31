<?php

/*
 * 
 * Checks for different user states and presents the right information from LoginView.php
 * Calls DoLogin() and DoLogout() from LoginHandler.php
 * 
 */

	
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
						//Create new cookiedata
						$loginView->KeepUserLoggedIn($user);	
						
						$xhtml = $this->DoLoggedIn();
						
					}
					//Cookie login failed
					else {
						$xhtml = $this->DoNotLoggedIn();
					}
				}
				else{				
					$xhtml = $this->DoNotLoggedIn();
				}
				
			}
			//If IsLoggedIn doesn't return true or false, then something is wrong.
			else {
				$error = new ErrorMessage(ErrorStrings::DefaultError);
				$xhtml = $loginView->DoErrorText($error);
			}
			return $xhtml;
		}


		private function DoNotLoggedIn(){
			//Create LoginView and LoginHandler
			$loginView = new LoginView();
			$loginHandler = new LoginHandler();
			
			//Text + loginbox
			$xhtml = $loginView->DoWelcomeText();
			$xhtml .= $loginView->DoLoginBox();
			
			//Check if user tries to log in
			if ($loginView->TriedToLogin() == true){
				
				//Proceed if form is filled correctly
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
						$error = new ErrorMessage(ErrorStrings::WrongCredentials);
						$xhtml = $loginView->DoWelcomeText();
						$xhtml .= $loginView->DoErrorText($error);
						$xhtml .= $loginView->DoLoginBox();
					}
				}
				//Form isn't filled correctly
				else{
					$error = new ErrorMessage(ErrorStrings::WrongCredentials);
					$xhtml = $loginView->DoWelcomeText();
					$xhtml .= $loginView->DoErrorText($error);
					$xhtml .= $loginView->DoLoginBox();
				}
				
			}
			return $xhtml;
		}

		private function DoLoggedIn(){
			//Create LoginView and LoginHandler
			$loginView = new LoginView();
			$loginHandler = new LoginHandler();
			
			//Get username of logged in user
			$user = $loginView->GetLoggedInUser();
			//Get user information
			$user = $loginHandler->GetUserByName($user);
			
			//If user is false, then the username doesn't exists and something is wrong
			if($user == false){
				//TODO Log error
				$loginHandler->DoLogout();
			}
			
			$xhtml = $loginView->DoLoggedInText($user);
			
			//Logout-box
			$xhtml .= $loginView->DoLogoutBox();
			
			//Check if user tries to log out
			if($loginView->TriedToLogout() == true){
				
				//Delete cookies on user aagent
				$loginView->DeleteCookies();
										
				//Log out
				$loginHandler->DoLogout();
				
				$xhtml = $this->DoNotLoggedIn();
				
				return $xhtml;
			}
			
			
			//DishController
			$dishController = new DishController();
			$xhtml .= $dishController->DoControll($user);
			
			
			
			return $xhtml;
		}
	}		
			