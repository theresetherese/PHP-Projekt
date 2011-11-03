<?php 

/* 
 * Generates login- and logoutform
 * Generates error messages for wrong username or password
 * Collects form input and validates it
 * Checks if user has cookies
 * 
 */


	class LoginView{
		
		/*
		 * 
		 * Texts and forms
		 * -----------------------------------------
		 * 
		 */
		
		//Return welcome-text
		public function DoWelcomeText() {
			return "<div id='welcome'><h1>Vad ska jag äta idag?</h1>
			<p><a href='?" . Constants::RegisterGetKey . "=" . Constants::RegisterGetValue . "'>Registrera dig</a> för att spara maträtter du gillar, och slumpa fram dem när fantasin tagit slut!</p></div>";
		}
		
		//Return login form
		public function DoLoginBox(){
			//Start login form	
			$form = "<div id='loginform'><form method='post'>
				<fieldset>
					<legend>Logga in</legend>
					<p>
						<label for='username'>Användarnamn: </label>
						<input type='text' id='username' name='username' required='required' />
					</p>
					<p>
						<label for='password'>Lösenord: </label>		
						<input type='password' id='password' name='password' required='required' />
					</p>
					<p class='floatLeft'>
						<label for='keepLoggedIn' id='keeploggedin'>Kom ihåg mig</label>
						<input type='checkbox' id='" . Constants::KeepMeLoggedInPostKey . "' name='" . Constants::KeepMeLoggedInPostKey . "' value='" . Constants::KeepMeLoggedInPostValue . "' />
					</p>
					<p class='floatRight'>
						<input type='submit' id='loginButton' name='" . Constants::LoginPostKey . "' value='" . Constants::LoginPostValue . "' />
					</p>
				</fieldset>
			</form></div>";
			
			//Return form
			return $form;
		}
		
		
		//Return logout form
		public function DoLogoutBox(){
			return "<form method='post' action='index.php'>
					<input type='submit' id='" . Constants::LogoutPostKey . "' name='" . Constants::LogoutPostKey . "' value='" . Constants::LogoutPostValue . "' />
			</form>";
		}
		
		//Return text for logged in users
		public function DoLoggedInText(User $user){
			return "<div id='topContainer'><div id='topContent'><h1>Vadskajagätaidag.se</h1><div id='logoutBox'><p>Hej, " . $user->GetUsername() . "</p> " . $this->DoLogoutBox() . "</div></div></div><div id='wrapper'>";
		}
		
		//Return link to registration
		public function DoRegisterLink(){
			return '<a href="?' . Constants::RegisterGetKey . '=' . Constants::RegisterGetValue . '">Registrera dig</a>';
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
		
		//Save cookies
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
		
		public function GetLoggedInUser(){
			if(isset($_SESSION[Constants::LoggedInUserSessionKey])){
				$user = new User();
				$user->SetUsername($_SESSION[Constants::LoggedInUserSessionKey]);
				return $user;
			}
			
			return false;
		}
		
		//If client has cookies, validate and save them to user object with ip and return user object
		public function HasCookies(){
			if (isset($_COOKIE[Constants::KeepLoggedInCookieUserName]) && isset($_COOKIE[Constants::KeepLoggedInCookieToken])){
				$user = new User();
				$username = $_COOKIE[Constants::KeepLoggedInCookieUserName];
				$cookieData = $_COOKIE[Constants::KeepLoggedInCookieToken];
				
				//Save cookieinfo to user object if username validates
				if($user->ValidateUsername($username)){
					$user->SetUsername($username);
					$user->SetCookieData($cookieData);
					$user->SetIP($this->GetIP());
					
					return $user;
				}
				
				return false;
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