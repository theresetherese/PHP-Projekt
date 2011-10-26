<?php
	require_once 'Controller/LoginController.php';
	require_once 'Controller/MasterController.php';
	require_once 'Controller/RegisterController.php';
	
	require_once 'Model/DAL/DB_settings.php';
	require_once 'Model/DAL/DishDAL.php';
	require_once 'Model/DAL/LoginDAL.php';
	require_once 'Model/Constants.php';
	require_once 'Model/Dish.php';
	require_once 'Model/DishHandler.php';
	require_once 'Model/LoginHandler.php';
	require_once 'Model/RegisterHandler.php';
	require_once 'Model/User.php';
	require_once 'Model/Validator.php';
	
	require_once 'View/LoginView.php';
	require_once 'View/RegisterView.php';
	
	session_start();
	
	
	if (TestLoginHandler() == true){
		echo "<h2>LoginHandler.php OK</h2>";
	}
	else{
		echo "<h2>LoginHandler.php FAILED</h2>";
	}
	
	/*
	 * 
	 * Test LoginHandler.php
	 * DoLogout(), DoLogin(), IsLoggedIn()
	 * 
	 */
	function TestLoginHandler(){
			
		$loginHandler = new LoginHandler();	
		
		//Users	
		$validUser = new User();
		$validUser->SetUsername("Test");
		$validUser->SetPassword($validUser->HashPassword("Test1234"));
		
		$invalidUser = new User();
		$invalidUser->SetUsername("sdfgsghdfghdgh");
		$invalidUser->SetPassword("dfghdfghhdfghdfgh");
		
		$rightNameWrongPass = new User();
		$rightNameWrongPass->SetUsername("saltat2");
		$rightNameWrongPass->SetPassword("ihkjhjh");
		
		$wrongNameRightPass = new User();
		$wrongNameRightPass->SetUsername("kjhkjh");
		$wrongNameRightPass->SetPassword($validUser->HashPassword("Saltat1234"));	
		
		//Force logout
		$loginHandler->DoLogout();
		
		//IsLoggedIn
		if($loginHandler->IsLoggedIn() == true){
			echo "IsLoggedIn() should return false.";
			return false;
		}
		
		//DoLogin with wrong credentials
		if ($loginHandler->DoLogin($invalidUser) == true){
			echo "DoLogin() should return false when wrong credentials are used.";
			return false;
		}
		
		//DoLogin with valid credentials
		if ($loginHandler->DoLogin($validUser) == false){
			echo "DoLogin() should return true when vaild credentials are used.";
			return false;
		}
		
		
		//IsLoggedIn
		if ($loginHandler->IsLoggedIn() == false){
			echo "IsLoggedIn() should return true.";
			return false;
		}
		
		//Logout
		$loginHandler->DoLogout();
		
		//DoLogin with wrong user and password combination
		if($loginHandler->DoLogin($rightNameWrongPass) == true){
			echo "DoLogin() should return false when wrong username and password combination is used.";
			return false;
		}
		
		return true;
	}
	
	
	
	/*
	 * 
	 * Test LoginView.php
	 * Login- and logoutbutton, GetUserName() and GetPassword()
	 * 
	 */
	
	echo "<h2>LoginView.php</h2>";
	
	$loginView = new LoginView();
	echo $loginView->DoLoginBox();
	echo $loginView->DoLogoutBox();
	
	
	//Test login-button 
	if ($loginView->TriedToLogin() == true ) 
	{
	  	echo "User clicked Login with username: ";
		//Test GetUserName() and GetPassword()
	  	echo $loginView->GetUserName() . " and password: " . $loginView->GetPassword();
		
		if (isset($_POST['keepLoggedIn']) && $_POST['keepLoggedIn'] == "keepLoggedIn"){
			echo "<br />Keep user logged in was checked.";
		}
	}
	//Test logout-button
	if ($loginView->TriedToLogout() ) 
	{
	  	echo "<br />User clicked Logout";
	}
	
	/*
	 * 
	 * Test LoginHandler.php
	 * DoLogin(), DoLogout(), IsLoggedIn()
	 * 
	 */
	
	
	
	/*
	 * 
	 * Test LoginDAL.php
	 * GetUserByName(), ComparePassword(), AddUser(), DeleteUser()
	 * 
	 */
	
	echo '<h2>LoginDAL.php</h2>';
	
	if (TestLoginDAL() == true){
		echo "<br /><strong>Test of LoginDAL.php OK</strong>";
	}
	else {
		echo "<br /><strong>Test of LoginDAL.php failed.</strong>";
	}
	 
	function TestLoginDAL(){	
				
	 	$loginDAL = new LoginDAL();
		
		$validUser = new User();
		$validUser->SetUsername("Test");
		$validUser->SetPassword($validUser->HashPassword("Test1234"));
		
		$invalidUser = new User();
		$invalidUser->SetUsername("sdfgsghdfghdgh");
		$invalidUser->SetPassword("dfghdfghhdfghdfgh");
		
		$rightNameWrongPass = new User();
		$rightNameWrongPass->SetUsername("Test");
		$rightNameWrongPass->SetPassword("ihkjhjh");
		
		$wrongNameRightPass = new User();
		$wrongNameRightPass->SetUsername("kjhkjh");
		$wrongNameRightPass->SetPassword($validUser->HashPassword("Test1234"));
		
		$userToAdd = new User();
		$userToAdd->SetUsername("userrrr");
		$userToAdd->SetPassword($validUser->HashPassword("Abcdef123"));
		
		
		//Test if $loginDAL is a LoginDAL object
		if (!($loginDAL instanceof LoginDAL)){
			echo "The LoginDAL object was not created correctly.<br />";
			return false;
		}
		
		//Test GetUserByName with existing username
		if ($loginDAL->GetUserByName($validUser) == false){
			echo "GetUserByName returned false when checking for an existing username.<br />";
			return false;
		}
		
		//Test GetUserByName with wrong username
		if ($loginDAL->GetUserByName($invalidUser) == true){
			echo "GetUserByName returned true when checking for an invalid username.<br />";
			return false;
		}
		
		//Test ComparePassword with valid user
		if ($loginDAL->ComparePassword($validUser) == false){
			echo "ComparePassword returned false for a valid user.<br />";
			return false;
		}
		
		//Test ComparePassword with invalid user
		if ($loginDAL->ComparePassword($invalidUser) == true){
			echo "ComparePassword returned true for an invalid user.<br />";
			return false;
		}
		
		//Test ComparePassword with valid username and wrong password
		if ($loginDAL->ComparePassword($rightNameWrongPass) == true){
			echo "ComparePassword returned true for a user with valid username and wrong password.<br />";
			return false;
		}
		
		//Test ComparePassword with wrong username and valid password
		if ($loginDAL->ComparePassword($wrongNameRightPass) == true){
			echo "ComparePassword returned true for a user with wrong username and right password.<br />";
			return false;
		}
		
		//Test AddUser
		//Check if user exists
		if ($loginDAL->GetUserByName($userToAdd) == false){
			//Try to add user	
			if($loginDAL->AddUser($userToAdd)){
				echo "User was added.<br />";
			}
			else{
				echo "AddUser didn't succeed.<br />";
				return false;
			}
		}
		
		//Test DeleteUser
		//Check if user exists
		if ($loginDAL->GetUserByName($userToAdd) == true){
			//Try to delete user
			if($loginDAL->DeleteUser($userToAdd) == true){
				echo "User was deleted.<br />";
			}
			else{
				echo "DeleteUser didn't succeed.<br />";
				return false;
			}
		}
		else{
			echo "Can not delete a user that doesn't exist.<br />";
			return false;
		}
		
		
		
		return true;
	}
	
	
	/*
	 * 
	 * Test of User.php
	 * Getters and setters
	 * 
	 */
	
	echo "<h2>User.php</h2>";
	
	if(TestUser() == true){
		echo "<br /><strong>User.php OK</strong><br />";
	}
	else {
		echo "<br /><strong>User.php FAILED</strong><br />";
	}
	
	function TestUser(){
		$user = new User();
		
		//Valid username
		if($user->ValidateUsername("username") == false){
			echo "ValidateUsername() returned false on valid username username.";
			return false;				
		}
		
		//Valid username
		if($user->ValidateUsername("123") == false){
			echo "ValidateUsername() returned false on valid username 123.";
			return false;				
		}
		
		//Valid username
		if($user->ValidateUsername("namn-efternamn") == false){
			echo "ValidateUsername() returned false on valid username namn-efternamn.";
			return false;				
		}
		
		//Invalid username
		if($user->ValidateUsername("qwertyuiopASDFGHJKL123456789003adfgsdfgsdfgdfghdghsdkjfhglkshfdglkjhsdflkghjlskdfghjlkjh") == true){
			echo "ValidateUsername() returned true on invalid username.";
			return false;				
		}
		
		//Invalid username
		if($user->ValidateUsername("___") == true){
			echo "ValidateUsername() returned true on invalid username.";
			return false;				
		}
		
		//Invalid username
		if($user->ValidateUsername("___sdfg") == true){
			echo "ValidateUsername() returned true on invalid username.";
			return false;				
		}
		
		//Invalid username
		if($user->ValidateUsername("sdf___") == true){
			echo "ValidateUsername() returned true on invalid username.";
			return false;				
		}
		
		//Invalid username
		if($user->ValidateUsername("") == true){
			echo "ValidateUsername() returned true on invalid username.";
			return false;				
		}
		
		//Valid password
		if($user->ValidatePassword("Abcdefg1") == false){
			echo "ValidatePassword() returned false on valid password.<br />";
			return false;
		}
		
		//Valid password
		if($user->ValidatePassword("kjhJhkj75!%€&") == false){
			echo "ValidatePassword() returned false on valid password.<br />";
			return false;
		}
		
		//Invalid password
		if($user->ValidatePassword("12345678") == true){
			echo "ValidatePassword() returned true on invalid password.<br />";
			return false;
		}
		
		//Invalid password
		if($user->ValidatePassword("abc") == true){
			echo "ValidatePassword() returned true on invalid password.<br />";
			return false;
		}

		return true;
	}
	
	
	/*
	 * Test RegisterView.php
	 * 
	 */
	
	echo "<h2>RegisterView.php</h2>";
	
	$registerView = new RegisterView();
	echo $registerView->DoRegisterBox();
	
	
	//Test login-button 
	if ($registerView->TriedToRegister() == true ) 
	{
	  	echo "User clicked Register with username: ";
		
	  	echo $registerView->GetUserName() . " and password: " . $registerView->GetPassword();
		
		echo "<br />Confirm password was: " . $registerView->GetConfirmPassword();
		

		if($registerView->ComparePasswords() == true){
			echo "<br />The passwords match.";
		}
		else {
			echo "<br />The passwords did not match.";
		}
	}
	
	
	
	/*
	 * 
	 * Test RegisterHandler.php
	 * 
	 */
	
	echo "<h1>RegisterHandler.php</h1>";
	
	if(TestRegisterHandler() == true){
		echo "<br /><strong>RegisterHandler.php OK</strong>";
	}
	else {
		echo "<br /><strong>RegisterHandler.php FAILED</strong>";
	}
	
	function TestRegisterHandler(){
			
		$registerHandler = new RegisterHandler();
		
		$user = new User();
		$user->SetUsername("usertoaddanddelete");
		$user->SetPassword("Password123");
		
		if($registerHandler->DoRegister($user) == false){
			echo "RegisterHandler->DoRegister failed<br />";
			return false;
		}
		else{
			echo "User was added.<br />";
		}
		if($registerHandler->DoDelete($user) == false){
			echo "RegisterHandler->DoDelete failed<br />";
			return false;
		}
		else{
			echo "User was deleted.<br />";
		}
		return true;
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
