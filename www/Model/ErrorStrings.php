<?php
	
	class ErrorStrings{
		/*
		 * IMPORTANT ERROR
		 */ 
		 
		 const DefaultError = "<h1>Ett fel inträffade när sidan hämtades.</h1>";
		
		/*
		 * DISH
		 * 
		 */
		
		const InvalidDishNameCharacters = "<p class='errorMessage'>Maträttens namn får endast innehålla bokstäver och siffror.</p>";
		const InvalidDishNameLength = "<p class='errorMessage'>Maträttens namn måste vara mellan 3 och 50 tecken.</p>";
		const InvalidDishUrl = "<p class='errorMessage'>Kontrollera att maträtterns länk är en giltig adress.</p>";
		const DishExists = "<p class='errorMessage'>En maträtt med samma namn finns redan.</p>";
		const CouldNotAddDish = "<p class='errorMessage'>Maträtten kunde inte läggas till i listan.</p>";
		
		const TooFewDishes = "<h3>Lägg till minst fem maträtter för att börja slumpa!</h3>";
		const NoRandomDish = "<h3>Kunde inte slumpa maträtt.</h3>";
		
		/*
		 * 
		 * LOGIN
		 * 
		 */
		const WrongCredentials = "<p class='errorMessage'>Felaktigt användarnamn eller lösenord.</p>";
		
		
		/*
		 * REGISTER
		 */

		const InvalidUsernameLength = "<p class='errorMessage'>Användarnamnet måste vara mellan 3 och 30 tecken långt.</p>";
		
		const InvalidUsernameCharacters = "<p class='errorMessage'>Användarnamnet måste bestå av små bokstäver eller siffror. Användarnamnet får innehålla punkt (.), bindesstreck (-) och understreck (_) men måste börja och sluta med liten bokstav eller siffra.</p>";	
			
		const InvalidPasswordCharacters = "<p class='errorMessage'>Lösenordet ska vara 8-30 tecken och måste minst innehålla stor bokstav, liten bokstav och siffra. Specialtecken är tillåtna, och rekommenderas.</p>";
		
		const InvalidPasswordLikeUsername = "<p class='errorMessage'>Lösenordet får inte vara samma som användarnamnet.</p>";
		
		const PasswordsDoNotMatch = "<p class='errorMessage'>Lösenorden matchar inte varandra.</p>";
		
		const InvalidEmail = "<p class='errorMessage'>Kontrollera att e-postadressen är giltig.</p>";
		
		const RegistrationFailed = "<h2>Registreringen misslyckades</h2><p class='errorMessage'>Kontakta webbplatsens administratör om problemet kvarstår.</p>";
		
		const AllFieldsRequired = "<p class='errorMessage'>Var vänlig fyll i alla fält för att kunna registrera dig.</p>";
		
		const UserExists = "<p class='errorMessage'>Användarnamnet är upptaget. Var vänlig välj ett annat.</p>";
	}
