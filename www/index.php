<?php

	require_once "Controller/MasterController.php";
	
	//Start session
	session_start();
	
	//Initiate $title och $body
	$title = "Login";
	$body = "";
	
	//Check which information to show
	$masterController = new MasterController();
	$mcDoControll = $masterController->DoControll();
	
	$body = $mcDoControll;
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
    	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    	<title><?php echo $title; ?></title>
	</head>

	<body>
		
		<?php echo $body; ?>
		
	</body>
</html>