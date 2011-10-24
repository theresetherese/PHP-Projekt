<?php 

/* 
 * Generates texts for different states, and collects data from forms
 * 
 */

	require_once '../Model/User.php';
	require_once '../Model/Constants.php';

	class LoginView{
		
		/*
		 * 
		 * Texts and forms
		 * -----------------------------------------
		 * 
		 */
		
		//Return welcome-text
		public function DoLoginText() {
			return "<h1>Welcome!</h1>
			<p>Log in with your username and password.</p>";
		}
		
		//Return login form
		public function DoLoginBox(){
			//Start login form	
			$form = "<form method='post'>
				<p>
					<label for='username'>Username: </label>
					<input type='text' id='username' name='username' />
				</p>
				<p>
					<label for='password'>Password: </label>		
					<input type='password' id='password' name='password' />
				</p>
				<p>
					<input type='submit' id='loginButton' name='" . Constants::LoginPostKey . "' value='" . Constants::LoginPostValue . "' />
					<label for='keepLoggedIn'>Keep me logged in</label>
					<input type='checkbox' id='" . Constants::KeepMeLoggedInPostKey . "' name='" . Constants::KeepMeLoggedInPostKey . "' value='" . Constants::KeepMeLoggedInPostValue . "' />
				</p>
			</form>";
			
			//Return form
			return $form;
		}
		
		//Return text for wrong user credentials
		public function DoWrongCredentialsText(){
			return "<h1>Wrong username or password. Please try again.</h1>";
		}
		
		//Return text for successful login
		public function DoLogInSuccessText(){
			return "<h1>You are successfully logged in!</h1>";
		}
		
		//Return text for already logged in user
		public function DoLoggedInText(){
			return "<h1>You are logged in</h1>";
		}
		
		//Return logout form
		public function DoLogoutBox(){
			return "<form method='post'>
				<p>
					<input type='submit' id='" . Constants::LogoutPostKey . "' name='" . Constants::LogoutPostKey . "' value='" . Constants::LogoutPostValue . "' />
				</p>
			</form>";
		}
		
		//Return text for logged out user
		public function DoLoggedOutText(){
			return "<h1>You are now logged out!</h1>
			<p>Please come back soon!</p>";
		}
		
		//Return link to registration
		public function DoRegisterLink(){
			return '<a href="index.php?' . Constants::RegisterGetKey . '=' . Constants::RegisterGetValue . '">Register user</a>';
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
		
		//Get password from form, return @string
		public function GetPassword(){
			//Return password if submitted
			if (isset($_POST["password"]) == true && empty($_POST["password"]) == false){
				return $_POST["password"];
			}
	    	return false;
		}
		
		//Save form data in User object, if it validates
		public function GetUser(){
	
			//Check if post values are OK	
			if ($this->GetUserName() != false && $this->GetPassword() != false){
					
				$username = $this->GetUserName();
				$password = $this->GetPassword();	
				$ip = $this->GetIP();
				
				//Create User object	
				$user = new User();
				
				//Validate username and password
				if($user->ValidateUsername($username) == true && $user->ValidatePassword($password) == true){
					
					//Set username
					$user->SetUsername($username);
										
					//Salt and hash password, SetPassword
					$user->SetPassword($user->HashPassword($password));
					
					return $user;
				}
			}
			return false;

		}
		
		public function GetIP(){
			return $_SERVER["REMOTE_ADDR"];
		}
		
		//Check if user wants to be remembered
		public function KeepLoggedIn(){

			if (isset($_POST[Constants::KeepMeLoggedInPostKey]) == true){
				if($_POST[Constants::KeepMeLoggedInPostKey] == Constants::KeepMeLoggedInPostValue){
					return true;
				}
				
				return false;
			}
			return false;
		}
		
		//Save cookie
		public function KeepUserLoggedIn(User $user){
			//Create cookiedata
			$cookieData = $this->GetUserName() . time();
			$cookieData = hash_hmac('sha512', Constants::Salt . $cookieData, Constants::SiteKey);
			
			//Save cookies
			setcookie(Constants::KeepLoggedInCookieToken, $cookieData, time() + Constants::CookieTime );
			setcookie(Constants::KeepLoggedInCookieUserName, $this->GetUserName(), time() + Constants::CookieTime );
			
			//Save cookieData and IP
			$user->SetCookieData($cookieData);
			$user->SetIP($this->GetIP());
			
			return $user;
		}
		
		//If client has cookies, save them to user with ip and return user object
		public function HasCookies(){
			if (isset($_COOKIE[Constants::KeepLoggedInCookieUserName]) && isset($_COOKIE[Constants::KeepLoggedInCookieToken])){
				$user = new User();
				$user->SetUsername($_COOKIE[Constants::KeepLoggedInCookieUserName]);
				$user->SetCookieData($_COOKIE[Constants::KeepLoggedInCookieToken]);
				$user->SetIP($this->GetIP());
				return $user;
			}
			
			return false;
		}
		
		//Delete cookies
		public function DeleteCookies(){
			setcookie(Constants::KeepLoggedInCookieToken, "", time() - Constants::CookieTime );
			setcookie(Constants::KeepLoggedInCookieUserName, "", time() - Constants::CookieTime );
		}
		
		//Return true if user has clicked login-button
		public function TriedToLogin(){
			if (isset($_POST[Constants::LoginPostKey]) == true){
				if($_POST[Constants::LoginPostKey] == Constants::LoginPostValue){
					return true;
				}
				return false;
			}
			return false;
		}
		
		//Return true if user has clicked logout-button
		public function TriedToLogout(){
			if (isset($_POST[Constants::LogoutPostKey]) == true){
				if ($_POST[Constants::LogoutPostKey] == Constants::LogoutPostValue){
					return true;
				}
				return false;
			}
			return false;
		}
	}