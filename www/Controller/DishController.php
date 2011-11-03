<?php
	
	class DishController{
	
		public function DoControll(User $user){
			$dishView = new DishView();
			$dishHandler = new DishHandler();
			
			//Present form to add dish
			$xhtml = $this->DoDishForm($user);
				
			//Get dishes from user
			$user = $dishHandler->GetDishes($user);
			
			
			//Get random dish
			if(count($user->GetDishes()) >= 5){
				
				//Get random dish
				$randomDish = $dishHandler->GetRandomDish($user);
				
				if($randomDish instanceof Dish){
					//View random dish	
					$xhtml .= $dishView->DoRandomDish($randomDish);
				}
				else{
					$error = new ErrorMessage();
					$xhtml .= $dishView->DoErrorText($error);
				}
			}
			else{
				$error = new ErrorMessage(ErrorStrings::TooFewDishes);
				$xhtml .= $dishView->DoErrorText($error);
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
				
				//If dish actually is a dish
				if($dish instanceof Dish){
					//Check if dish already exists
					if($dishHandler->DishNameExists($dish, $user) == false){
						//Add dish	
						if($dishHandler->AddDish($dish, $user) != false){
							$xhtml = $dishView->DoAddedDishText();
							$xhtml .= $dishView->DoAddDish();
						}
						//Print error message if AddDish() fails
						else{
							$error = new ErrorMessage(ErrorStrings::CouldNotAddDish);
							$xhtml = $dishView->DoErrorText($error);
							$xhtml .= $dishView->DoAddDish();
						}
					}
					//Dish already exists
					else{
						$error = new ErrorMessage(ErrorStrings::DishExists);
						$xhtml = $dishView->DoErrorText($error);
						$xhtml .= $dishView->DoAddDish();
					}
				}
				//User input was invalid
				else{
					$xhtml = $dishView->DoErrorText($dish);
					$xhtml .= $dishView->DoAddDish();
				}				
			}
			
			return $xhtml;
		}
	
	}