<?php
	
	class Constants {
		
		//Directory URL
		const Server = "http://localhost:8888/PHP/Projekt/www/";
		
		//Salt
		const Salt = "dauyetr34678t58364bcf7392847/&%(V&%B&B876B58765BV765V76V5/I%&(/&V%76V%(&%V/8";
		
		//HMAC
		const SiteKey = "if786gi/(ZtrewZXTRCvuTVI/(67IVB/v%rv765VR%&V&%rv765rv765vr8756oVB)B7675V((/%";
		
		/*
		 * GET keys and values 
		 */
		const RegisterGetKey = "register";
		const RegisterGetValue = "register";
		const UserViewGetKey = "user";
		const DishViewGetKey = "dish";
		const DishViewAllGetValue = "all";
		const DishViewAddGetValue = "add";
		
		/*
		 * POST keys and values
		 */
		
		const KeepMeLoggedInPostKey = "keepLoggedIn";
		const KeepMeLoggedInPostValue = "keepLoggedIn";
		
		const LoginPostKey = "login";
		const LoginPostValue = "Logga in";
		
		const LogoutPostKey = "logout";
		const LogoutPostValue = "Logga ut";
		
		const RegisterPostKey = "regiserUser";
		const RegisterPostValue = "Registrera";
		
		/*
		 * SESSIONS
		 * 
		 */
		
		const LoggedInSessionKey = "loggedIn";
		const LoggedInSessionValue = "loggedIn";
		
		const LoggedInUserSessionKey = "user";
		  
		/*
		 * COOKIES
		 */
		
		//Keep me logged in cookies
		const KeepLoggedInCookieToken = "vsjai_token";
		const KeepLoggedInCookieUserName = "vsjai_un";
		const CookieTime = 604800;	
	}
