<?php
	
	class ErrorMessage{
		private $message = "";
		
		public function GetMessage(){
			return $this->message;
		}
		
		public function __construct($string){
			$this->message = $string;
		}
	}
