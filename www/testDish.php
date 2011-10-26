<?php

	require_once 'Model/DAL/DishDAL.php';
	require_once 'Model/Dish.php';
	require_once 'Model/User.php';
	require_once 'Model/DishHandler.php';
	//require_once 'Controller/DishController.php';
	require_once 'Model/Constants.php';
	//require_once 'View/DishView.php';
	require_once 'Model/Validator.php';



	class TestDish{
		
		public function TestDishObject(){
			
			$dish = new Dish();
			$date = new DateTime();
			
			if($dish->ValidateDishName("Makaroner och köttbullar") == false){
				echo "ValidateDishName returns false on valid dishname<br />";
				return false;
			}
			
			if($dish->ValidateDishName("Spaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssåsSpaghetti och köttfärssås") == true){
				echo "ValidateDishName returns true on too long dishname<br />";
				return false;
			}
			
			if($dish->ValidateDishName("Spa#€€ghetti och köttfärssås") == true){
				echo "ValidateDishName returns true on dishname with special characters<br />";
				return false;
			}
			
			$dish->SetDishInfo("<p>hello world</p>");
			
			if($dish->GetDishInfo() !== "&lt;p&gt;hello world&lt;/p&gt;"){
				echo "SetDishInfo does not encode special characters";
				return false;
			}
			
			if($dish->ValidateUrl("http://www.recept.nu/1.300846/anette_rosvall_och_emma_hamberg/huvudratter/fisk_skaldjur/hoki_med_aggsas") == false){
				echo "ValidateUrl returns false on valid url";
				return false;
			}
			
			if($dish->ValidateUrl("http://www.tasteline.com/recept/Radjursfile_med_rotsakspytt_och_smorfrasta_kantareller") == false){
				echo "ValidateUrl returns false on valid url";
				return false;
			}
			
			if($dish->ValidateUrl("http:/www.tasteline.com/recept/Radjursfile_med_rotsakspytt_och_smorfrasta_kantareller") == true){
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
			$dish->SetId(3);
			
			$dish = $dishDAL->GetDish($dish);
			
			if($dish->GetDishName() != "Chili con carne"){
				echo "GetDishName() could not return Chili con carne";
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
			
		}
		
		public function TestDishView(){
			
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
			
			echo "<h1>DishView.php</h1>";
			if($this->TestDishView() == true){
				echo "DishView.php OK<br />";
			}
			else {
				echo "DishView.php FAILED<br />";
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
	
