<?php
	
	require_once 'DB_settings.php';
	//require_once '../Dish.php';
	
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
				
			}
			else{
				throw new Exception("Database Error.", 1);
					
			}
			
			return $user;
			
			//Close
			$this->myConnection->close();
		}
		
		//Get a specific dish
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
				
			}
			else{
				throw new Exception("Database Error.", 1);
					
			}
			
			return $dish;
			
			//Close
			$this->myConnection->close();
		}
		
		
		//Add a dish
		
		//Delete a dish
				
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
		
	}
