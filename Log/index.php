<?php
    require_once "Log.php";
	require_once "View/LogView.php";
	$title = "The Amazing Logger";
	$logView = new LogView();
	
	
	$body = "";
	$body .= $logView->Test();
	
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv">
	<head>
		<title><?php echo $title ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" type="text/css" media="screen" href="screen.css" />
	</head>
	
	<body>
			<?php echo $body ?>
	</body>

</html>
