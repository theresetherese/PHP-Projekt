<?php
	
	require_once 'Validator.php';
	
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
		
		public function ValidateDishName($_dishName){
			$validator = new Validator();
			
			if(strlen($_dishName) <= 50 && strlen($_dishName) >= 3){
				if ($validator->validLettersAndDigits($_dishName)){
					
					return true;
				}
				return false;
			}
			return false;
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
		
		public function SetDishInfo($_dishInfo){
			$this->dishInfo = htmlspecialchars($_dishInfo);
		}
		
		public function GetUrl(){
			return $this->url;
		}
		
		public function SetUrl($_url){
			$this->url = $_url;
		}
		
		public function ValidateUrl($_url){
			$validator = new Validator();
			if ($validator->validUrl($_url) == true){
				return true;
			}
			return false;
		}
		
		public function GetThumbnailUrl(){
			return $this->thumbnailUrl;
		}
		
		public function SetThumbnailUrl($_thumbnail){
			$this->thumbnailUrl = $_thumbnailUrl;
		}
		
		public function ValidateThumbnailUrl($_thumbnail){
			$validator = new Validator();
			if ($validator->validUrl($_url) == true){
				return true;
			}
			return false;
		}
	}
