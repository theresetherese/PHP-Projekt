<?php
	
	class DishView{
		
		public function DoRandomDish(){
			$xhtml = "<h2>RANDOM DISH</h2>";
			return $xhtml;
		}
		
		public function DoAddDish(){
			$xhtml = '<form method="post">
				<p>
					<label for="dishname">Namn:</label>
					<input type="text" name="dishname" id="dishname" required="required" />
				</p>
				<p>
					<label for="dishurl">Länk:</label>
					<input type="url" name="dishurl" id="dishurl" />
				</p>
				<p>
					<label for="dishinfo">Information:</label>
					<textarea name="dishinfo" id="dishinfo"></textarea>
				</p>
				<p>
					<input type="submit" id="' . Constants::DishViewPostKey . '" name="' . Constants::DishViewPostKey . '" value="' . Constants::DishViewAddPostValue . '" />
				</p>
			</form>';
			return $xhtml;
		}
		
		public function DoAllDishes(User $user){
			$xhtml = '<h2>Alla sparade maträtter</h2>';	
				
			if(count($user->GetDishes() > 0)){
			
			$xhtml .= '<ul>';
			
			foreach ($user->GetDishes() as $dish) {
					
				$xhtml .= '<li>';
				$xhtml .= $dish->GetDishName();
				
				
				if($dish->GetDishInfo() != ""){
					$xhtml .= '<p>';
					$xhtml .= $dish->GetDishInfo();
					$xhtml .= '</p>';
				}
				if($dish->GetUrl() != ""){
					$xhtml .= '<p>';
					$xhtml .= '<a href="';
					$xhtml .= $dish->GetUrl();
					$xhtml .= '" title="Besök maträttens länk">Besök länk</a>';
					$xhtml .= '</p>';
				}
				
			}
			$xhtml .= '</li>';
			$xhtml .= '</ul>';
			}
			else{
				$xhtml .= '<h3>Inga sparade maträtter!</h3>'; 
			}
			return $xhtml;
			
		}
		
		public function DoAddedDishText(){
			$xhtml = "<p>Maträtten har lagts till i listan!</p>";
			return $xhtml;
		}
		
		public function DoFailedAddDishText(){
			$xhtml = "<p>Maträtten kunde inte läggas till i listan.</p>";
		}
		
		/*
		 * Collect user input and check GET and POST
		 * 
		 */	
		
		
		public function GetDishName(){
			if (isset($_POST["dishname"]) == true && empty($_POST["dishname"]) == false){
				return $_POST["dishname"];
			}
	    	return false;
		}
		
		public function GetDishInfo(){
			if (isset($_POST["dishinfo"]) == true && empty($_POST["dishinfo"]) == false){
				return $_POST["dishinfo"];
			}
	    	return false;
		}
		
		public function GetDishUrl(){
			if (isset($_POST["dishurl"]) == true && empty($_POST["dishurl"]) == false){
				return $_POST["dishurl"];
			}
	    	return false;
		}
		
		public function ValidateDish(){
			if($this->GetDishName() != false){
				$dishname = $this->GetDishName();
				$dish = new Dish();
				
				if($dish->ValidateDishName($dishname) == true){
					$dish->SetDishName($dishname);
				}
				else{
					return false;
				}
				
				if($this->GetDishInfo() == true){
					$dishinfo = $this->GetDishInfo();
					$dish->SetDishInfo($dishinfo);	
				}
				
				if($this->GetDishUrl() == true){
					$dishurl = $this->GetDishUrl();
					if($dish->ValidateUrl($dishurl) == true){
						$dish->SetUrl($dishurl);
					}
					else{
						return false;
					}
				}
				
				return $dish;
			}
			
			return false;
		}
		
		public function GetDishFromForm(){
			$dish = $this->ValidateDish();
			
			if($dish != false){
				return $dish;
			}
			
			return false;
		}
		
		public function GetLoggedInUser(){
			if(isset($_SESSION[Constants::LoggedInUserSessionKey])){
				$user = new User();
				$user->SetUsername($_SESSION[Constants::LoggedInUserSessionKey]);
				return $user;
			}
			
			return false;
		}
		
		public function TriedToShowDish(){
			
		}
		
		public function TriedToAddDish(){
			if(isset($_POST[Constants::DishViewPostKey]) && $_POST[Constants::DishViewPostKey] == Constants::DishViewAddPostValue){
				return true;
			}
			return false;
		}
		
	}
