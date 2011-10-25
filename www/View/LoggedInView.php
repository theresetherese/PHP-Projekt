<?php

	/*
	 * Generates navigation for logged in users
	 * 
	 */
	
	require_once './Model/Constants.php';
	
	class LoggedInView{
		
		public function DoRandomDish(){
			$xhtml = "<h2>Slumpad maträtt</h2>";
			return $xhtml;
		}
		
		public function AddNewDishLink(){
			$xhtml = "<h3><a href='?" . Constants::DishViewGetKey . "=" . Constants::DishViewAddGetValue . "' title='Lägg till en ny maträtt'>Lägg till ny maträtt</h3>";
			return $xhtml;
		}
		
		public function ShowDishesLink(){
			$xhtml = "<h4><a href='?" . Constants::DishViewGetKey . "=" . Constants::DishViewAllGetValue . "' title='Visa alla sparade maträtter'>Visa sparade maträtter</a></h4>";
			return $xhtml;
		}
		
	}
