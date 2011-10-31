<?php
	
	class InstallDAL{
		private $createUser = "
	CREATE TABLE IF NOT EXISTS `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) NOT NULL,
  `password` char(128) NOT NULL,
  `email` varchar(80) NOT NULL,
  `cookie` char(128) NOT NULL,
  `ip` varchar(39) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;
	";
	
	private $createDish = "
	CREATE TABLE IF NOT EXISTS `Dish` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `dishName` varchar(50) NOT NULL,
  `creationDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dishInfo` text NOT NULL,
  `url` varchar(200) NOT NULL,
  `thumbnailUrl` varchar(170) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;
	";
	
	public function CheckForTables(){
		$tables = array();
			
		if($stmt = $this->myConnection->prepare("SHOW TABLES")){
			$stmt->execute();
			$stmt->bind_result($result);
			while($stmt->fetch()){
				array_push($tables, $result);
			}
			
			$stmt->close();
			
			return $tables;
		}
		else{
			Log::LogError("Could not show tables.");
		}
	}
	
	public function AddTables(){
		if($stmt = $this->myConnection->prepare($this->createUser)){
				$stmt->execute();
				$stmt->close();
		}
		else{
			Log::LogError("Could not add User table.");
		}
		if($stmt = $this->myConnection->prepare($this->createDish)){
				$stmt->execute();
				$stmt->close();
		}
		else{
			Log::LogError("Could not add Dish table.");
		}
		return true;
	}
	
	public function RemoveTables(){
		if($stmt = $this->myConnection->prepare("DROP TABLE `Dish`, `User`")){
				$stmt->execute();
				$stmt->close();
		}
		else{
			Log::LogError("Could not remove tables.");
		}
		return true;
	}
	
	//Create a new mysqli connection
	public function __construct() {
										
		$this->myConnection = new mysqli(DB_settings::host, DB_settings::user, DB_settings::pass, DB_settings::database);
		$this->myConnection->set_charset("utf8");
		
		/* check connection */
		if (mysqli_connect_errno()) {
			echo "Kunde inte ansluta till databasen. Kontrollera inställningarna.";
			//printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
	
	public function __destruct(){
		$this->myConnection->close();
	}
}
