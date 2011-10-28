<?php
	
	class DishController{
	
		public function DoControll(){
			$dishView = new DishView();
			$dishHandler = new DishHandler();
			
			//Get username from session
			$user = $dishView->GetLoggedInUser();
			
			//Get userid
			$loginHandler = new LoginHandler();
			$user = $loginHandler->GetUserByName($user);
			
			//If user is false, then the username doesn't exists
			if($user == false){
				//TODO Handle error when username doesnt exist. Log out?
			}
			
			//View random dish, add dish form and all dishes	
			$xhtml = $dishView->DoRandomDish();
			
			//Dish form
			$xhtml .= $dishView->DoAddDish();
			
			//Check if user tries to add a dish
			if($dishView->TriedToAddDish() == true){
				//Collect form input
				$dish = $dishView->GetDishFromForm();
				
				//If dish returned is not false, proceed
				if($dish != false){
					if($dishHandler->DishNameExists($dish, $user) == false){
						if($dishHandler->AddDish($dish, $user) != false){
							$xhtml .= $dishView->DoAddedDishText();
						}
						else{
							$xhtml .= $dishView->DoFailedAddDishText();
						}
					}
					else{
						//TODO MATRÄTTEN FINNS REDAN
					}
				}
				else{
					//TODO Uppgifterna dish stämmer inte
				}				
			}
			
			$dishes = $dishHandler->GetDishes($user);
			
			if($dishes != false){
				$xhtml .= $dishView->DoAllDishes($dishes);
			}
			
			
			
			return $xhtml;
		}
	
	}