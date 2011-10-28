<?php 

/* 
 * Generates texts for different states, and collects data from forms
 * 
 */


	class RegisterView{
		
		/*
		 * 
		 * Texts and forms
		 * -----------------------------------------
		 * 
		 */
		
		//Return welcome-text
		public function DoRegisterText() {
			return "<h1>Register user</h1>";
		}
		
		//Return registration form
		public function DoRegisterBox(){
			$validator = new Validator();
			//Start registration form	
			$form = "<form method='post'>
				<p>
					<label for='username'>Username: </label>
					<input type='text' id='username' name='username' required='required' pattern='^[a-z0-9]+[a-z0-9\.\-_]?([a-z0-9]+)\$' />
				</p>
				<p>
					<label for='username'>Email: </label>
					<input type='email' id='email' name='email' required='required' pattern='^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})\$' />
				</p>
				<p>
					<label for='password'>Password: </label>		
					<input type='password' id='password' name='password' required='required' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}' />
				</p>
				<p>
					<label for='confirmPassword'>Confirm password: </label>		
					<input type='password' id='confirmPassword' name='confirmPassword' required='required' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}' />
				</p>
				<p>
					<input type='submit' id='registerButton' name='" . Constants::RegisterPostKey . "' value='" . Constants::RegisterPostValue . "' />
				</p>
			</form>";
			
			//Return form
			return $form;
		}
		
		//Return text for invalid username
		public function DoInvalidUsername(){
			return "<p>The username must start and end with the letters a-z or a digit, and can only contain the special characters . _ -</p>";
		}
		
		//Return text for invalid password
		public function DoInvalidPassword(){
			return "<p>The password must be between 6 and 30 characters long, and must contain an uppercase letter, a lowercase letter and a digit.</p>";
		}
		
		//Return text for invalid password
		public function DoInvalidEmail(){
			return "<p>Enter a valid email address.</p>";
		}
		
		//return text for invalid submission
		public function DoInvalidSubmission(){
			return "<h1>Registration failed.</h1>";
		}
		
		//Return text for successful registration
		public function DoRegisterSuccessText(){
			return "<h1>Registration completed.</h1>";
		}
		
		//Return text for failed registration
		public function DoRegisterFailText(){
			return "<h1>Registration failed. Please try again.</h1>";
		}
		
		//Return link to login
		public function DoLoginLink(){
			return "<a href='?' title='Logga in'>Logga in</a>";
		}
		
		/*
		 * 
		 * Get user input
		 * -----------------------------------------------
		 * 
		 */
		
		//Get username from form, return @string
		public function GetUserName(){
			//Return username if submitted
			if (isset($_POST["username"]) == true && empty($_POST["username"]) == false){
				return $_POST["username"];
			}
	    	return false;
		}
		
		//Get email from form, return @string
		public function GetEmail(){
			//Return emial if submitted
			if (isset($_POST["email"]) == true && empty($_POST["email"]) == false){
				return $_POST["email"];
			}
	    	return false;
		}
		
		//Get password from form, return @string
		public function GetPassword(){
			//Return password if submitted
			if (isset($_POST["password"]) == true && empty($_POST["password"]) == false){
				return $_POST["password"];
			}
	    	return false;
		}
		
		//Get confirm password from form, return @string
		public function GetConfirmPassword(){
			//Return password if submitted
			if (isset($_POST["confirmPassword"]) == true && empty($_POST["confirmPassword"]) == false){
				return $_POST["confirmPassword"];
			}
	    	return false;
		}
		
		//Compare the two passwords
		public function ComparePasswords(){
			//Check that both passwords are set
			if($this->GetPassword() != false && $this->GetConfirmPassword() != false){
				//If both are set, then are they the same?	
				if($this->GetPassword() === $this->GetConfirmPassword()){
					return true;
				}
				else{
					return false;
				}
			}
			return false;
		}
		
		//Save form data in User object, if it validates
		public function GetUser(){
	
			//Check if post values are OK	
			if ($this->GetUserName() != false && $this->GetEmail() != false && $this->ComparePasswords() != false){
					
				$username = $this->GetUserName();
				$email = $this->GetEmail();
				$password = $this->GetPassword();	
				
				//Create User object	
				$user = new User();
				
				//Validate username and password
				if($user->ValidateUsername($username) == true && $user->ValidatePassword($password) == true && $user->ValidateEmail($email) == true){
					
					//Set username
					$user->SetUsername($username);
					
					//Set email
					$user->SetEmail($email);
										
					//Salt and hash password, SetPassword
					$user->SetPassword($user->HashPassword($password));
					
					return $user;
				}
				
				return false;
			}
			
			return false;

		}
		
		//Return true if user has clicked register-button
		public function TriedToRegister(){
			if (isset($_POST[Constants::RegisterPostKey]) == true){
				if($_POST[Constants::RegisterPostKey] == Constants::RegisterPostValue){
					return true;
				}
				return false;
			}
			return false;
		}
		
	}