<?php

	require_once '../Model/DAL/DB_settings.php';
	require_once 'InstallController.php';
	require_once 'InstallDAL.php';
	require_once 'InstallHandler.php';
	require_once 'InstallView.php';
	
	$installController = new InstallController();
	$icControll = $installController->DoControll();
	
	$body = $icControll;
?>

<!DOCTYPE html>
<html>
	<head>
    	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    	<title>Installera</title>
	</head>

	<body>
		
		<?php echo $body; ?>
		
	</body>
</html>