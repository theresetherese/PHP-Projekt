<?php

	require_once "DB_settings.php";
	
	class DishDAL{
		
		//Get all dishes from user
		public function GetDishes(User $user){
			//Save username	
			$userId = $user->GetUserId();
			$dishId = 0;
			$dishName = "";
			$creationDate = "";
			$dishInfo = "";
			$url = "";
			
			//SQL
			if ($stmt = $this->myConnection->prepare("SELECT id, dishName, creationDate, dishInfo, url FROM Dish WHERE userId = ?")){
				$stmt->bind_param("i", $userId);
				$stmt->execute();
				$stmt->bind_result($dishId, $dishName, $creationDate, $dishInfo, $url);
				while($stmt->fetch()){
					$dish = new Dish();
					$dish->SetId($dishId);
					$dish->SetDishName($dishName);
					$dish->SetCreationDate($creationDate);
					$dish->SetDishInfo($dishInfo);
					$dish->SetUrl($url);
					$user->PushDish($dish);
				}
				
				//Close
				$stmt->close();
				
				return $user;
				
			}
			else{
				throw new Exception("Database Error.", 1);
					
			}
			
		}
		
		//Get a specific dish by id
		public function GetDish(Dish $dish){
			$dishId = $dish->GetId();
			//SQL
			if ($stmt = $this->myConnection->prepare("SELECT dishName, creationDate, dishInfo, url FROM Dish WHERE id = ?")){
				$stmt->bind_param("i", $dishId);
				$stmt->execute();
				$stmt->bind_result($dishName, $creationDate, $dishInfo, $url);
				while($stmt->fetch()){
					$dish->SetDishName($dishName);
					$dish->SetCreationDate($creationDate);
					$dish->SetDishInfo($dishInfo);
					$dish->SetUrl($url);
				}
				
				//Close
				$stmt->close();
				return $dish;
			}
			else{
				throw new Exception("Database Error.", 1);
					
			}
		}
		
		//Check if dishname exists
		public function DishNameExists(Dish $dish, User $user){
			$dishName = $dish->GetDishName();
			$userId = $user->GetUserId();
			$affectedRows = 0;
			
			//SQL
			if ($stmt = $this->myConnection->prepare("SELECT * FROM Dish WHERE dishName = ? AND userId = ?")){
				$stmt->bind_param("si", $dishName, $userId);
				$stmt->execute();
				$stmt->store_result();
				$affectedRows = $stmt->num_rows;			
				
				//Close
				$stmt->close();
				
				if($affectedRows > 0){
					return true;
				}
				else{
					return false;	
				}
				
			}
			else{
				throw new Exception("Database Error.", 1);
					
			}
		}
		
		
		//Add a dish
		public function AddDish(Dish $dish, User $user){
			$userId = $user->GetUserId();	
			$dishName = $dish->GetDishName();
			$dishInfo = $dish->GetDishInfo();
			$url = $dish->GetUrl();
			$rowsAffected = 0;
			
			//SQL
			if ($stmt = $this->myConnection->prepare("INSERT INTO Dish VALUES('',?,?,CURRENT_TIMESTAMP,?,?,'')")){
				$stmt->bind_param("isss", $userId, $dishName, $dishInfo, $url);
				$stmt->execute();
				$rowsAffected = $stmt->affected_rows;
				$dish->SetId($stmt->insert_id);
				//Close
				$stmt->close();	
				
				if($rowsAffected > 0){
					return $dish;
				}
				else{
					return false;
				}
							
			}
			else{
				throw new Exception("Database Error.", 1);		
			}
			
		}
		
		//Delete a dish
		public function DeleteDish(Dish $dish){
			$dishId = $dish->GetId();
			$rowsAffected = 0;
			
			if($stmt = $this->myConnection->prepare("DELETE FROM Dish WHERE id = ?")){
				$stmt->bind_param("i", $dishId);
				$stmt->execute();
				
				$rowsAffected = $stmt->affected_rows;
				
				$stmt->close();
				
				if($rowsAffected > 0){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				throw new Exception("Database Error.", 1);
					
			}
		}
				
		//Create a new mysqli connection
		public function __construct() {
											
			$this->myConnection = new mysqli(DB_settings::host, DB_settings::user, DB_settings::pass, DB_settings::database);
			$this->myConnection->set_charset("utf8");
			
			/* check connection */
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}
		}
		
		public function __destruct(){
			$this->myConnection->close();
		}
		
	}
