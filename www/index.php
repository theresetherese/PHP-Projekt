<?php

	require_once 'Controller/LoggedInController.php';
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
	
	require_once 'View/LoggedInView.php';
	require_once 'View/LoginView.php';
	require_once 'View/RegisterView.php';
	
	
	
	//Start session
	session_start();
	
	//Initiate $body
	$body = "";
	
	//Collect body content from MasterController
	$masterController = new MasterController();
	$mcDoControll = $masterController->DoControll();
	
	$body = $mcDoControll;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
    	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    	<title>Vad ska jag äta idag?</title>
	</head>

	<body>
		
		<?php echo $body; ?>
		
	</body>
</html>