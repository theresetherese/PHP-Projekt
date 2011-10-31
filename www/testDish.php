<?php

	require_once 'Controller/LoginController.php';
	require_once 'Controller/MasterController.php';
	require_once 'Controller/RegisterController.php';
	
	require_once 'Model/DAL/DB_settings.php';
	require_once 'Model/DAL/DishDAL.php';
	require_once 'Model/DAL/LoginDAL.php';
	require_once 'Model/Constants.php';
	require_once 'Model/Dish.php';
	require_once 'Model/DishHandler.php';
	require_once 'Model/ErrorMessage.php';
	require_once 'Model/ErrorStrings.php';
	require_once 'Model/LoginHandler.php';
	require_once 'Model/RegisterHandler.php';
	require_once 'Model/User.php';
	require_once 'Model/Validator.php';
	
	require_once 'View/LoginView.php';
	require_once 'View/RegisterView.php';


	class TestDish{
		
		public function TestDishObject(){
			
			$dish = new Dish();
			$date = new DateTime();
			
			if($dish->ValidateDishName("Makaroner och köttbullar") instanceof ErrorMessage){
				echo "ValidateDishName returns false on valid dishname<br />";
				return false;
			}
			
			if(!$dish->ValidateDishName("Spaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssås") instanceof ErrorMessage){
				echo "ValidateDishName returns true on too long dishname<br />";
				return false;
			}
			
			if(!$dish->ValidateDishName("Spa#€€ghetti och köttfärssås") instanceof ErrorMessage){
				echo "ValidateDishName returns true on dishname with special characters<br />";
				return false;
			}
			
			$dish->SetDishInfo("<p>hello world</p>");
			
			if($dish->GetDishInfo() !== "hello world"){
				echo "SetDishInfo does not strip tags";
				return false;
			}
			
			if($dish->ValidateUrl("http://www.recept.nu/1.300846/anette_rosvall_och_emma_hamberg/huvudratter/fisk_skaldjur/hoki_med_aggsas") instanceof ErrorMessage){
				echo "ValidateUrl returns false on valid url";
				return false;
			}
			
			if($dish->ValidateUrl("http://www.tasteline.com/recept/Radjursfile_med_rotsakspytt_och_smorfrasta_kantareller") instanceof ErrorMessage){
				echo "ValidateUrl returns false on valid url";
				return false;
			}
			
			if(!$dish->ValidateUrl("http:/www.tasteline.com/recept/Radjursfile_med_rotsakspytt_och_smorfrasta_kantareller") instanceof ErrorMessage){
				echo "ValidateUrl returns true on invalid url<br />";
				return false;
			}
			
			
			return true;
			
		}
		
		
		public function TestDishDAL(){
			$dishDAL = new DishDAL();
			
			$user = new User();
			$user->SetUserId(2);
			
			$user = $dishDAL->GetDishes($user);
			
			if(count($user->GetDishes()) == 0){
				echo "User has no dishes<br />";
				return false;
			}
			
			$dish = new Dish();
			$dish->SetId(94);
			
			$dish = $dishDAL->GetDish($dish);
			
			if($dish->GetDishName() != "Chili con carne"){
				echo "DishNameExists could not return Chili con carne";
				return false;
			}
			
			$addDish = new Dish();
			$addDish->SetDishName("Tacos");
			$addDish->SetDishInfo("Taco, taco so goood, in my tummy yummy yummy gimme more");
			$addDish->SetUrl("http://tacoisgood.com");
			
			$addDish = $dishDAL->AddDish($addDish, $user);
			
			if($addDish == false){
				echo "Dish was NOT added.<br />";
				return false;
			}
			else{
				echo "Dish was added.<br />";
			}
			
			if($dishDAL->DeleteDish($addDish) == true){
				echo "Dish was deleted.<br />";
			}
			else{
				echo "Dish was not deleted.<br />";
				return false;
			}
			
			if($dishDAL->DishNameExists($dish, $user) == false){
				echo "DishNameExists returned false on existing dish<br />";
				return false;
			}
			
			return true;
		}
		
		public function TestDishHandler(){
			$dishHandler = new DishHandler();
			
			$user = new User();
			$user->SetUserId(2);
			$user = $dishHandler->GetDishes($user);
			
			if(count($user->GetDishes()) == 0){
				echo "GetDishes() does not get dishes.";
				return false;
			}
			
			$dish = $dishHandler->GetRandomDish($user);
							
			if(!$dish instanceof Dish){
				echo "GetRandomDish() does not return dish object.";
				return false;
			}
			
			return true;	
		}
		
		public function Test(){
			echo "<h1>Dish.php</h1>";
				
			if($this->TestDishObject() == true){
				echo "Dish.php OK<br />";
			}
			else {
				echo "Dish.php FAILED<br />";
			}
			
			
			echo "<h1>DishDAL.php</h1>";
			if($this->TestDishDAL() == true){
				echo "DishDAL.php OK<br />";
			}
			else {
				echo "DishDAL.php FAILED<br />";
			}
			
			echo "<h1>DishHandler.php</h1>";
			if($this->TestDishHandler() == true){
				echo "DishHandler.php OK<br />";
			}
			else {
				echo "DishHandler.php FAILED<br />";
			}

		}
		
	
		
	}
	
	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
    	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    	<title>Vad ska jag äta idag?</title>
	</head>

	<body>';
	$test = new TestDish();
	$test->Test();
	
	echo "</body></html>";
	
