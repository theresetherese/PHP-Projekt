<?php

	class User {
		
		private $userId = NULL;
		private $username = "";
		private $email = "";
		private $password = "";
		private $cookieData = "";
		private $ip = "";
		private $dishes = array();
		
		public function GetUserId(){
			return $this->userId;
		}
		
		public function SetUserId($_userId){
			$this->userId = $_userId;
		}
		
		public function GetUsername(){
			return $this->username;
		}
		
		/*
		 * Set username to lowercase to avoid problems. 
		 */
		public function SetUsername($_username){
			$_username = strtolower($_username);	
			$this->username = $_username;
		}
		
		
		/*
		 * Validate username.
		 * Must be 3-30 characters.
		 * Can only start and end with letters or digits.
		 * Can contain . _ - 
		 * Return true if username ok, else error message
		 */
		public function ValidateUsername($_username){
			$validator = new Validator();
			
			//String to lowercase
			$_username = strtolower($_username);
			
			//Check username length, min 3 max 30
			if (strlen($_username) >= 3 && strlen($_username) <= 30) {
				//Validate characters	
				if($validator->validUsername($_username)){
					return true;
				}
				//Invalid characters
				else{
					$error = new ErrorMessage(ErrorStrings::InvalidUsernameCharacters);
					return $error;
				}
			}
			//Invalid length
			else{
				$error = new ErrorMessage(ErrorStrings::InvalidUsernameLength);
				return $error;
			}
		}
		
		public function GetEmail(){
			return $this->email;
		}
		
		public function SetEmail($_email){
			$this->email = $_email;
		}
		
		/*
		 * Validate email adress. 
		 * Set string to lowercase.
		 * Return true if email ok, else error message.
		 */
		public function ValidateEmail($_email){
			$validator = new Validator();
			
			//String to lowercase
			$_email = strtolower($_email);
			
			if($validator->validEmail($_email) == true){
				return true;
			}
			
			else{
				$error = new ErrorMessage(ErrorStrings::InvalidEmail);
				return $error;
			}
		}
		
		public function GetPassword(){
			return $this->password;
		}
		
		public function SetPassword($_password){
			$this->password = $_password;
		}
		
		/*
		 * Must be 8-30 characters.
		 * Must containt lowercase letter, uppercase letter and digit.
		 * Can contain special characters.
		 * Can not be same as username.
		 * Return true if ok, else return error message.
		 */
		public function ValidatePassword($_password){
			$validator = new Validator();
			
			//Check if password is valid
			if($validator->validPassword($_password)){
				return true;
			}
			//Invalid characters or length
			else{
				$error = new ErrorMessage(ErrorStrings::InvalidPasswordCharacters);
				return $error;
			}
		}
		
		/*
		 * Salt + password + sitekey
		 * Hash with sha512
		 */
		public function HashPassword($_password){
			return hash_hmac('sha512', Constants::Salt . $_password, Constants::SiteKey);
		}
		
		public function GetCookieData(){
			return $this->cookieData;
		}
		//TODO validate cookiedata
		public function SetCookieData($_cookieData){
			$this->cookieData = $_cookieData;
		}
		
		public function GetIP(){
			return $this->ip;
		}
		//TODO Validate ip
		public function SetIP($_ip){
			$this->ip = $_ip;
		}
		
		public function GetDishes(){
			return $this->dishes;
		}
		
		public function ClearDishes(){
			$this->dishes = array();
		}
		
		public function PushDish(Dish $dish){
			array_push($this->dishes, $dish);
		}
	}
