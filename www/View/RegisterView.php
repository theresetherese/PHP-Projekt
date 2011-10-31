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
		
		//Return registration form
		public function DoRegisterBox2(){
			$validator = new Validator();
			//Start registration form	
			$form = "<h1>Registrera användare</h1><form method='post'>
				<p>
					<label for='username'>Användarnamn: </label>
					<input type='text' id='username' name='username' required='required' pattern='^[a-z0-9]+[a-z0-9\.\-_]?([a-z0-9]+)\$' />
				</p>
				<p>
					<label for='username'>Email: </label>
					<input type='email' id='email' name='email' required='required' pattern='^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})\$' />
				</p>
				<p>
					<label for='password'>Lösenord: </label>		
					<input type='password' id='password' name='password' required='required' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}' />
				</p>
				<p>
					<label for='confirmPassword'>Bekräfta lösenord: </label>		
					<input type='password' id='confirmPassword' name='confirmPassword' required='required' pattern='(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,30}' />
				</p>
				<p>
					<input type='submit' id='registerButton' name='" . Constants::RegisterPostKey . "' value='" . Constants::RegisterPostValue . "' />
				</p>
			</form>";
			
			//Return form
			return $form;
		}
		
		public function DoRegisterBox(){
			$validator = new Validator();
			//Start registration form	
			$form = "<h1>Registrera användare</h1><form method='post'>
				<p>
					<label for='username'>Användarnamn: </label>
					<input type='text' id='username' name='username' />
				</p>
				<p>
					<label for='username'>Email: </label>
					<input type='text' id='email' name='email' />
				</p>
				<p>
					<label for='password'>Lösenord: </label>		
					<input type='password' id='password' name='password' />
				</p>
				<p>
					<label for='confirmPassword'>Bekräfta lösenord: </label>		
					<input type='password' id='confirmPassword' name='confirmPassword' />
				</p>
				<p>
					<input type='submit' id='registerButton' name='" . Constants::RegisterPostKey . "' value='" . Constants::RegisterPostValue . "' />
				</p>
			</form>";
			
			//Return form
			return $form;
		}
		
		//Return text for successful registration
		public function DoRegisterSuccessText(){
			return "<h1>Användaren registrerades!</h1>";
		}
		
		//Return link to login
		public function DoLoginLink(){
			return "<p><a href='?' title='Logga in'>Logga in</a></p>";
		}
		
		//Error text
		public function DoErrorText(ErrorMessage $error){
			return $error->GetMessage();
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
			if($this->GetPassword() === $this->GetConfirmPassword()){
				return true;
			}
			else{
				$error = new ErrorMessage(ErrorStrings::PasswordsDoNotMatch);
				return $error;
			}
		}
		
		//Save form data in User object, if it validates
		public function GetUser(){
	
			//Check if post values are OK	
			if ($this->GetUserName() != false && $this->GetEmail() != false && $this->GetPassword() != false && $this->GetConfirmPassword() != false){
					
				$username = $this->GetUserName();
				$email = $this->GetEmail();
				$password = $this->GetPassword();	
				
				//Create User object	
				$user = new User();
				
				//Validate username
				if($user->ValidateUsername($username) instanceof ErrorMessage){
					return $user->ValidateUsername($username);	
				}
				if($user->ValidateEmail($email) instanceof ErrorMessage){
					return $user->ValidateEmail($email);
				}
				if(strtolower($password) == strtolower($username)){
					$error = new ErrorMessage(ErrorStrings::InvalidPasswordLikeUsername);
					return $error;
				}
				if($user->ValidatePassword($password) instanceof ErrorMessage){
					return $user->ValidatePassword($password);
				}
				if($this->ComparePasswords() instanceof ErrorMessage){
					return $this->ComparePasswords();
				}
				
				$user->SetUsername($username);
				$user->SetEmail($email);
				$password = $user->HashPassword($password);
				$user->SetPassword($password);
				
				return $user;

			}
			
			$error = new ErrorMessage(ErrorStrings::AllFieldsRequired);
			return $error;

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