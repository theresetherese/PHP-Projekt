<?php
	
	class DishHandler{
		
		public function GetDish(Dish $dish){
			$dishDAL = new DishDAL();
			return $dishDAL->GetDish($dish);
		}
		
		public function GetDishes(User $user){
			$dishDAL = new DishDAL();
			return $dishDAL->GetDishes($user);
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
		
	}
