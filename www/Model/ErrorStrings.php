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
		
		const InvalidDishNameCharacters = "<p>Maträttens namn får endast innehålla bokstäver och siffror.</p>";
		const InvalidDishNameLength = "<p>Maträttens namn måste vara mellan 3 och 50 tecken.</p>";
		const InvalidDishUrl = "<p>Kontrollera att maträtterns länk är en giltig adress.</p>";
		const DishExists = "<p>En maträtt med samma namn finns redan.</p>";
		const CouldNotAddDish = "<p>Maträtten kunde inte läggas till i listan.</p>";
		
		const TooFewDishes = "<h3>Lägg till minst fem maträtter för att börja slumpa!</h3>";
		const NoRandomDish = "<h3>Kunde inte slumpa maträtt.</h3>";
		
		/*
		 * 
		 * LOGIN
		 * 
		 */
		const WrongCredentials = "<p>Felaktigt användarnamn eller lösenord.</p>";
		
		
		/*
		 * REGISTER
		 */

		const InvalidUsernameLength = "<p>Användarnamnet måste vara mellan 3 och 30 tecken långt.</p>";
		
		const InvalidUsernameCharacters = "<p>Användarnamnet måste bestå av små bokstäver eller siffror. Användarnamnet får innehålla punkt (.), bindesstreck (-) och understreck (_) men måste börja och sluta med liten bokstav eller siffra.</p>";	
			
		const InvalidPasswordCharacters = "<p>Lösenordet ska vara 8-30 tecken och måste minst innehålla stor bokstav, liten bokstav och siffra. Specialtecken är tillåtna, och rekommenderas.</p>";
		
		const InvalidPasswordLikeUsername = "<p>Lösenordet får inte vara samma som användarnamnet.</p>";
		
		const PasswordsDoNotMatch = "<p>Lösenorden matchar inte varandra.</p>";
		
		const InvalidEmail = "<p>Kontrollera att e-postadressen är giltig.</p>";
		
		const RegistrationFailed = "<h2>Registreringen misslyckades</h2><p>Kontakta webbplatsens administratör om problemet kvarstår.</p>";
		
		const AllFieldsRequired = "<p>Var vänlig fyll i alla fält för att kunna registrera dig.</p>";
		
		const UserExists = "Användarnamnet är upptaget. Var vänlig välj ett annat.";
	}
