<?php
	
	class DishController{
	
		public function DoControll(){
			$dishView = new DishView();
			$dishHandler = new DishHandler();
				
			$xhtml = $dishView->DoRandomDish();
			$xhtml .= $dishView->DoNavigation();
			
			if($dishView->TriedToShowAllDishes() == true){
				$xhtml = $dishView->DoNavigation();	
				$xhtml .= $dishView->DoAllDishes();
			}
			
			return $xhtml;
		}
	
	}