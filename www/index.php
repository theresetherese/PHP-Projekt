<?php

	require_once "Controller/MasterController.php";
	
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