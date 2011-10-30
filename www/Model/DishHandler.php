<?php
	
	class DishHandler{
		
		public function GetDish(Dish $dish){
			$dishDAL = new DishDAL();
			return $dishDAL->GetDish($dish);
		}
		
		public function GetDishes(User $user){
			$dishDAL = new DishDAL();
			$user = $dishDAL->GetDishes($user);
			return $user;
		}
		
		public function AddDish(Dish $dish, User $user){
			$dishDAL = new DishDAL();
			return $dishDAL->AddDish($dish, $user);
		}
		
		public function DeleteDish(Dish $dish){
			$dishDAL = new DishDAL();
			return $dishDAL->DeleteDish($dish);
		}
		
		public function DishNameExists(Dish $dish, User $user){
			$dishDAL = new DishDAL();
			return $dishDAL->DishNameExists($dish, $user);
		}
		
		public function GetRandomDish(User $user){
			//Get a random indexnumber from dishes array
			$numberOfDishes = count($user->GetDishes());
			$randomNumber = rand(0, $numberOfDishes - 1);
			
			//Array with dishes
			$dishes = $user->GetDishes();
			//Choose a dish
			$dish = $dishes[$randomNumber];

			return $dish;
		}
		
	}
