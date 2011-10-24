<?php
require_once './Log.php';

class LogView {
	
	//Print all stored log posts
	public function ShowMessages() {
		$ret = "<h1>Messages</h1><div><ul>";
		foreach(Log::$msgArr as $key => $value) {
			$ret .= "<li>$value</li>";
		}
		$ret .= "</ul></div>";
		return $ret;
	}
	
	//Print all stored log posts
	public function ShowErrors() {
		$errors = "<h1>Errors</h1><ul>";
		$errors .= Log::GetErrors();
		$errors .= "</ul>";
		return $errors;
	}

	//Automatic test
	public function Test() {
		$aData = 243;
		$anArray = array(2,4,3, "fiskpinne");
		
		Log::LogMessage("LogView: OK!");
		Log::LogMessage("LogView: Hej!");
		Log::LogMessage("LogView: Hopp!", $anArray);
		Log::LogMessage("LogView: Pille!", $aData);
		Log::LogError("LogView: ETT FEEEELÖ!");
		return $this -> ShowMessages() . " " . $this -> ShowErrors();
	}

}
