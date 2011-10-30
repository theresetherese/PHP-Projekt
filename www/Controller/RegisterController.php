<?php
	
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
				$xhtml = $registerView->DoRegisterBox();
				$xhtml .= $registerView->DoLoginLink();
				
				//Check if user tries to register
				if($registerView->TriedToRegister() == true){
					
					$user = $registerView->GetUser();
					
					//Proceed if form is filled correctly
					if ($user instanceof User){
						//Present error message if user already exists
						$userExists = $registerHandler->DoesUserExist($user);	
						if($userExists instanceof ErrorMessage){	
							$xhtml = $registerView->DoRegisterBox();	
							$xhtml .= $registerView->DoErrorText($registerHandler->DoesUserExist($user));
						}
						//Try to register user
						else{
							//DoRegister()
							if($registerHandler->DoRegister($user) == true){
								
								//Registered
								$xhtml = $registerView->DoRegisterSuccessText();
								$xhtml .= $registerView->DoLoginLink();
								
							}
							//If user couldn't be added
							else {
								$xhtml = $registerView->DoRegisterBox();
								$error = new ErrorMessage(ErrorStrings::RegistrationFailed);
								$xhtml = $registerView->DoErrorText($error);
							}
						}
					}
					//Form isn't filled correctly
					else{
						$xhtml = $registerView->DoRegisterBox();
						$xhtml .= $registerView->DoErrorText($user);
						$xhtml .= $registerView->DoLoginLink();
					}
					
				}
			}

			return $xhtml;
		}
		
	}
