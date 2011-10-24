<?php
	
	require_once 'Validator.php';
	
	class Dish{
		
		private $id = "";
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
			//TODO Implement validation
			$this->dishName = $_dishName;
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
			//TODO convert characters to &
			$this->dishInfo = $_dishInfo;
		}
		
		public function GetUrl(){
			return $this->url;
		}
		
		public function SetUrl($_url){
			//TODO Implement validation
			$this->url = $_url;
		}
		
		public function GetThumbnailUrl(){
			return $this->thumbnailUrl;
		}
		
		public function SetThumbnailUrl($_thumbnail){
			//TODO Implement validation
			$this->thumbnailUrl = $_thumbnailUrl;
		}
	}
