<?php
	
	class DishController{
	
		public function DoControll(User $user){
			$dishView = new DishView();
			$dishHandler = new DishHandler();
			
			//Get userid
			$loginHandler = new LoginHandler();
			$user = $loginHandler->GetUserByName($user);
			
			//If user is false, then the username doesn't exists
			if($user == false){
				//TODO Handle error when username doesnt exist. Log out?
				throw new Exception("Error Processing Request", 1);
			}
			
			//Get dishes from user
			$user = $dishHandler->GetDishes($user);
			
			$xhtml = $this->DoDishForm($user);
				
			//Update dishes
			$user = $dishHandler->GetDishes($user);
			
			
			//Get random dish
			if(count($user->GetDishes()) >= 5){
				
				//Get random dish
				$randomDish = $dishHandler->GetRandomDish($user);
				
				//View random dish, add dish form and all dishes	
				$xhtml .= $dishView->DoRandomDish($randomDish);
			}
			else{
				$xhtml .= $dishView->DoNoDishes();
			}
			
			//view all dishes
			$xhtml .= $dishView->DoAllDishes($user);
			
			return $xhtml;
			
		}
		
		public function DoDishForm(User $user){
			$dishView = new DishView();
			$dishHandler = new DishHandler();
			
			//Dish form
			$xhtml = $dishView->DoAddDish();
			
			//Check if user tries to add a dish
			if($dishView->TriedToAddDish() == true){
				//Collect form input
				$dish = $dishView->GetDishFromForm();
				
				//If dish returned is not false, proceed
				if($dish != false){
					//Check if dish already exists
					if($dishHandler->DishNameExists($dish, $user) == false){
						//Add dish	
						if($dishHandler->AddDish($dish, $user) != false){
							$xhtml .= $dishView->DoAddedDishText();
						}
						else{
							$xhtml .= $dishView->DoFailedAddDishText();
						}
					}
					else{
						$xhtml .= $dishView->DoDishExistsText();
					}
				}
				else{
					//TODO Uppgifterna dish stämmer inte
				}				
			}
			
			return $xhtml;
		}
	
	}