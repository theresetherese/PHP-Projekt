<?php
	
	require_once 'Validator.php';

	class User {
		
		private $userId = "";
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
		
		
		public function SetUsername($_username){
			$this->username = $_username;
		}
		
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
					return false;
				}
			}
			//Invalid length
			else{
				return false;
			}
		}
		
		public function GetEmail(){
			return $this->email;
		}
		
		public function SetEmail($_email){
			$this->email = $_email;
		}
		
		public function ValidateEmail($_email){
			$validator = new Validator();
			
			//String to lowercase
			$_email = strtolower($_email);
			
			if($validator->validEmail($_email) == true){
				return true;
			}
			
			return false;
		}
		
		public function GetPassword(){
			return $this->password;
		}
		
		public function SetPassword($_password){
			$this->password = $_password;
		}
		
		public function ValidatePassword($_password){
			$validator = new Validator();
			
			//Check if password is valid
			if($validator->validPassword($_password)){
				//Confirm that password is not the same as username
				if($_password != $this->GetUsername()){
					return true;
				}
				//Same as username
				else{
					return false;
				}
			}
			//Invalid characters or length
			else{
				return false;
			}
		}
		
		public function HashPassword($_password){
			return hash_hmac('sha512', Constants::Salt . $_password, Constants::SiteKey);
		}
		
		public function GetCookieData(){
			return $this->cookieData;
		}
		
		public function SetCookieData($_cookieData){
			$this->cookieData = $_cookieData;
		}
		
		public function GetIP(){
			return $this->ip;
		}
		
		public function SetIP($_ip){
			$this->ip = $_ip;
		}
		
		public function GetDishes(){
			return $this->dishes;
		}
		
		public function PushDish(Dish $dish){
			array_push($this->dishes, $dish);
		}
	}
