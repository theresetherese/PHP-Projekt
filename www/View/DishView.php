<?php
	
	class DishView{
		
		public function DoRandomDish(Dish $dish){
			$xhtml = "<div id='randomDish'><h2>";		
			$xhtml .= $dish->GetDishName();
			$xhtml .= "</h2>";
			if($dish->GetDishInfo() != ""){
				$xhtml .= '<p>';
				$xhtml .= $dish->GetDishInfo();
				$xhtml .= '</p>';
			}
				
			$dateAdded = new DateTime($dish->GetCreationDate());
			
			$xhtml .= '<p><em>Skapad: ';
			$xhtml .= $dateAdded->format('Y-m-d');
			$xhtml .= '</em></p>';

			if($dish->GetUrl() != ""){
				$xhtml .= '<p class="visitUrl">';
				$xhtml .= '<a href="';
				$xhtml .= $dish->GetUrl();
				$xhtml .= '" title="Besök maträttens länk">Besök länk</a>';
				$xhtml .= '</p>';
			}
			
			$xhtml .= "<p class='newRandomDish'><a href='index.php' title='Klicka för att ladda om sidan och slumpa fram en annan maträtt'>Slumpa ny maträtt</a></p></div>";
			
			return $xhtml;
		}
		
		/*
		 * Form to add dish 
		 */
		public function DoAddDish(){
			$xhtml = '
			<div id="addDishForm">
			<fieldset>
			<legend>Lägg till ny maträtt</legend>
				<form method="post">
					<p>
						<label for="dishname">Namn:</label>
						<input type="text" name="dishname" id="dishname" />
					</p>
					<p>
						<label for="dishurl">Länk:</label>
						<input type="text" name="dishurl" id="dishurl" />
					</p>
					<p>
						<label for="dishinfo">Information:</label>
						<textarea name="dishinfo" id="dishinfo"></textarea>
					</p>
					<p>
						<input type="submit" id="' . Constants::DishViewPostKey . '" name="' . Constants::DishViewPostKey . '" value="' . Constants::DishViewAddPostValue . '" />
					</p>
				</form>
			</fieldset>
			</div>
			';
			return $xhtml;
		}
		
		/*
		 * Loop through all dishes and present them in a list
		 */
		
		public function DoAllDishes(User $user){
			$xhtml = '<h2>Alla sparade maträtter</h2>';	
				
			if(count($user->GetDishes()) > 0){
			
				$xhtml .= '<ul>';
			
				foreach ($user->GetDishes() as $dish) {
						
					$xhtml .= '<li><h3>';
					$xhtml .= $dish->GetDishName();
					$xhtml .= '</h3>';
					
					
					if($dish->GetDishInfo() != ""){
						$xhtml .= '<p>';
						$xhtml .= $dish->GetDishInfo();
						$xhtml .= '</p>';
					}
					
					$dateAdded = new DateTime($dish->GetCreationDate());
					
					$xhtml .= '<p>Skapad: ';
					$xhtml .= $dateAdded->format('Y-m-d');
					$xhtml .= '</p>';
	
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

			//If no dishes exist
			else{
				$xhtml .= '<h3>Inga sparade maträtter!</h3>'; 
			}
			
			return $xhtml;
			
		}
		
		public function DoAddedDishText(){
			$xhtml = "<p>Maträtten har lagts till i listan!</p>";
			return $xhtml;
		}
		
		public function DoErrorText(ErrorMessage $error){
			$xhtml = $error->GetMessage();
			return $xhtml;
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
			//Continue if a name is returned
			if($this->GetDishName() != false){
					
				$dishname = $this->GetDishName();
				
				$dish = new Dish();
				
				//Validate name
				if($dish->ValidateDishName($dishname) instanceof ErrorMessage){
					return $dish->ValidateDishName($dishname);	
				}
				else{
					$dish->SetDishName($dishname);
				}
				
				//Check for information
				if($this->GetDishInfo() != false){
					$dishinfo = $this->GetDishInfo();
					$dish->SetDishInfo($dishinfo);	
				}
				
				//Check for url and validate if it exists
				if($this->GetDishUrl() != false){
					$dishurl = $this->GetDishUrl();
					
					if($dish->ValidateUrl($dishurl) instanceof ErrorMessage){
						return $dish->ValidateUrl($dishurl);
					}
					else{
						$dish->SetUrl($dishurl);
					}
				}
				
				return $dish;
			}
			//Name is empty
			else{
				$error = new ErrorMessage(ErrorStrings::InvalidDishNameLength);
				return $error;
			}
		}
		
		public function GetDishFromForm(){
			return $this->ValidateDish();
		}
		
		public function TriedToAddDish(){
			if(isset($_POST[Constants::DishViewPostKey]) && $_POST[Constants::DishViewPostKey] == Constants::DishViewAddPostValue){
				return true;
			}
			return false;
		}
		
	}
