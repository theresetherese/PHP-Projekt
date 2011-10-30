<?php
		
	class Dish{
		
		private $id = 0;
		private $dishName = "";
		private $creationDate = "";
		private $dishInfo = "";
		private $url = "";
		private $thumbnailUrl = "";
		
		public function GetId(){
			return $this->id;
		}
		
		public function SetId($_id){
			$this->id = $_id;
		}
		
		public function GetDishName(){
			return $this->dishName;
		}
		
		public function SetDishName($_dishName){
			$this->dishName = $_dishName;
		}
		
		/*
		 * Validate dish name.
		 * Must be 3-50 characters.
		 * Can only contain letters and digits.
		 * Return true if name is ok, else return error message.
		 */
		public function ValidateDishName($_dishName){
			$validator = new Validator();
			
			if(strlen($_dishName) <= 50 && strlen($_dishName) >= 3){	
				if ($validator->validLettersAndDigits($_dishName)){
					return true;
				}
				else{
					$errorMessage = new ErrorMessage(ErrorStrings::InvalidDishNameCharacters);
					return $errorMessage;
				}
			}
			else{
				$errorMessage = new ErrorMessage(ErrorStrings::InvalidDishNameLength);
				return $errorMessage;
			}
		}
		
		public function GetCreationDate(){
			return $this->creationDate;
		}
		
		public function SetCreationDate($_creationDate){
			$this->creationDate = $_creationDate;
		}
		
		public function GetDishInfo(){
			return $this->dishInfo;
		}
		
		/*
		 * Remove html and javascript tags. <b> and <i> are allowed. 
		 */
		public function SetDishInfo($_dishInfo){
			$validator = new Validator();
			$this->dishInfo = $validator->stripJavascript($_dishInfo);
		}
		
		public function GetUrl(){
			return $this->url;
		}
		
		public function SetUrl($_url){
			$this->url = $_url;
		}
		
		/*
		 *Validate url. Return true if ok, else error message. 
		 */
		public function ValidateUrl($_url){
			$validator = new Validator();
			if ($validator->validUrl($_url) == true){
				return true;
			}
			else{
				$errorMessage = new ErrorMessage(ErrorStrings::InvalidDishUrl);
				return $errorMessage;
			}
		}
	}
