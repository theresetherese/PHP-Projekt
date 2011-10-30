<?php

	require_once "DB_settings.php";
	
	class DishDAL{
		
		/*
		 * Get a users dishes from database.
		 */
		public function GetDishes(User $user){
			$userId = $user->GetUserId();
			$dishId = 0;
			$dishName = "";
			$creationDate = "";
			$dishInfo = "";
			$url = "";
			
			//Clear users dishes to avoid duplicates
			$user->ClearDishes();
			
			//SQL
			if ($stmt = $this->myConnection->prepare("SELECT id, dishName, creationDate, dishInfo, url FROM Dish WHERE userId = ? ORDER BY dishName")){
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
				//TODO Logga fel					
			}
			
		}
		
		/*
		 * Get a specific dish by dishId
		 */
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
				//TODO Logga fel					
			}
		}
		
		/*
		 * Check if user has a dish with specified name
		 */ 
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
				//TODO Logga fel
					
			}
		}
		
		
		/*
		 * Add a dish. Return false if INSERT fails
		 */
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
		
		/*
		 * Delete a dish. Return false if DELETE fails.
		 */
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
