<?php
class Log {

	//Storage for log post's
	public static $msgArr = array();

	//create and store log post's
	public static function LogMessage($msg, $data = NULL) {
		$date = new DateTime();
		$date = $date -> format("Y-m-d H:i:s");

		//did we get any extra data to print?
		if($data !== NULL) {
			//is it an array?
			if(is_array($data)) {
				$finalData = "| ";
				//step through it and collect values
				foreach($data as $key => $value) {
					$finalData .= " $value |";
				}
				$data = $finalData;
			}
			//push the message and data
			array_push(self::$msgArr, $date . " : " . $msg . " <br />Data: " . $data);
		} else {
			//no, we didn't, go ahead and push the basic message
			array_push(self::$msgArr, $date . " : " . $msg);
		}
	}

	public static function LogError($msg) {
		$date = new DateTime();
		$date = $date -> format("Y-m-d H:i:s");
		$logMsg = $date . " : " . $msg;

		if(isset($_SERVER['REMOTE_ADDR'])) {
			$logMsg .= " {ip} " . $_SERVER['REMOTE_ADDR'];
		}

		$filename = "log.log";
		$fileRef = fopen($filename, "a");
		fwrite($fileRef, $logMsg . "\n");
		fclose($fileRef);

		//push error to log
		array_push(self::$msgArr, "<span style=\"color:#f00\">" . $logMsg . "</span>");
	}

	public static function GetErrors() {

		$filename = "log.log";
		$fileRef = fopen($filename, "rb");
		$messages = "";

		while(!feof($fileRef)) {
			$messages .= "<li>" . fgets($fileRef) . "</li>";
		}
		fclose($fileRef);

		/*while(!feof($fileRef)){
		 $line = stream_get_line($fileRef, filesize($filename), "\n");
		 if($line){
		 $messages .= "<li>" . $line . "<li/>";
		 }
		 }
		fclose($fileRef);*/
		return $messages;

	}

}
