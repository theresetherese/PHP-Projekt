<?php

	require_once '../View/RegisterView.php';
	require_once '../Model/RegisterHandler.php';
	require_once '../Model/LoginHandler.php';
	require_once '../View/LoginView.php';
	
	/*
	 * Is user is logged out, present Register form.
	 * 
	 */

	class RegisterController {
		
		public function DoControll(){
				
			$loginHandler = new loginHandler();
			
			//User can not register when already logged in	
			if($loginHandler->IsLoggedIn() == true){
				$xhtml = "<h1>You have to be logged out to register a user.</h1>";
			}
			else{	
			
				$registerView = new RegisterView();
				$registerHandler = new RegisterHandler();
				
				//Text + registerbox
				$xhtml = $registerView->DoRegisterText();
				$xhtml .= $registerView->DoRegisterBox();
				$xhtml .= $registerView->DoLoginLink();
				
				//Check if user tries to register
				if($registerView->TriedToRegister() == true){
					
					//Proceed if form is filled correctly
					if ($registerView->GetUser() != false){
						
						//Save user info
						$user = $registerView->GetUser();
						
						//DoRegister()
						if($registerHandler->DoRegister($user) == true){
							
							//Registered
							$xhtml = $registerView->DoRegisterSuccessText();
							$xhtml .= $registerView->DoLoginLink();
							
						}
						//If user couldn't be added
						else {
							$xhtml = $registerView->DoRegisterFailText();
							$xhtml .= $registerView->DoRegisterBox();
						}
					}
					//Form isn't filled correctly
					else{
						$xhtml = $registerView->DoInvalidSubmission();
						$xhtml .= $registerView->DoInvalidUsername();
						$xhtml .= $registerView->DoInvalidEmail();
						$xhtml .= $registerView->DoInvalidPassword();
						$xhtml .= $registerView->DoRegisterBox();
					}
					
				}
			}

			return $xhtml;
		}
		
	}
