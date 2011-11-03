<?php

	require_once 'Controller/DishController.php';
	require_once 'Controller/LoginController.php';
	require_once 'Controller/MasterController.php';
	require_once 'Controller/RegisterController.php';
	
	require_once 'Model/DAL/DB_settings.php';
	require_once 'Model/DAL/DishDAL.php';
	require_once 'Model/DAL/LoginDAL.php';
	require_once 'Model/Constants.php';
	require_once 'Model/Dish.php';
	require_once 'Model/DishHandler.php';
	require_once 'Model/ErrorMessage.php';
	require_once 'Model/ErrorStrings.php';
	require_once 'Model/LoginHandler.php';
	require_once 'Model/RegisterHandler.php';
	require_once 'Model/User.php';
	require_once 'Model/Validator.php';
	
	require_once 'View/DishView.php';
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

<!DOCTYPE html>
<html>
	<head>
    	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    	<title>Vad ska jag äta idag?</title>
    	<link rel="stylesheet" type="text/css" href="style.css" />
	</head>

	<body>
		<?php echo $body; ?>
		</div>		
	</body>
</html>