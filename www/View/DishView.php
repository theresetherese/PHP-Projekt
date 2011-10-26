<?php
	
	class DishView{
		
		public function DoRandomDish(){
			$xhtml = "RANDOM DISH";
			return $xhtml;
		}
		
		public function DoAllDishes(){
			$xhtml = "All dishes!";
			return $xhtml;
		}
		
		public function DoNavigation(){
			$xhtml = "<h3><a href='?" . Constants::DishViewGetKey . "=" . Constants::DishViewAddGetValue . "' title='Lägg till en ny maträtt'>Lägg till ny maträtt</h3>";
			$xhtml .= "<h4><a href='?" . Constants::DishViewGetKey . "=" . Constants::DishViewAllGetValue . "' title='Visa alla sparade maträtter'>Visa sparade maträtter</a></h4>";
			return $xhtml;
		}

		
		public function TriedToShowAllDishes(){
			if(isset($_GET[Constants::DishViewGetKey]) && $_GET[Constants::DishViewGetKey] == Constants::DishViewAllGetValue){
				return true;
			}
			return false;
		}
		
		public function TriedToShowDish(){
			
		}
		
		public function TriedToAddDish(){
			
		}
		
	}
