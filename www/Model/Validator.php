<?php

class Validator{
	const emailRegex = '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^';
	const ssNr12 = '^(18|19|20)[0-9][0-9](0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])-?[0-9]{4}^'; //matchar 19891102-7202 eller 198911027202
	const ssNr10 = '^[0-9][0-9](0[1-9]|1[012])(0[1-9]|[12][0-9]|3[01])-?[0-9]{4}^'; //matchar 8911027202 eller 891102-7202
	const dateRegex = '^(19|20)?[0-9][0-9]-?(0[1-9]|1[012])-?(0[1-9]|[12][0-9]|3[01])$^'; //matchar 11-09-30, 110930, 2011-09-30
	const passwordRegex = '^(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])([0-9 A-Z a-z]{8,25})$^'; //Kräver liten bokstav, stor bokstav, siffra och mellan 8-25 tecken
	const passwordRegex2 = '^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,30}^'; //Kräver liten bokstav, stor bokstav, siffra och kan innehålla specialtecken
	const lettersAndDigitsRegex = '^[\w]^';
	const usernameRegex2 = '/^[a-z0-9]+[a-z0-9\.\-_]?([a-z0-9]+)$/';
	const thumbnailRegex = '';
    
    public function validEmail($email){
    	if (preg_match(Validator::emailRegex, $email)) {
  			return true;
		}
		return false;
    }
	
	public function validSocialSecurityNr($nr){
		if (preg_match(Validator::ssNr12, $nr)){
			$nr = substr($nr, 2); //klipp
			$nr = str_replace('-', '', $nr); //ta bort streck
			if($this->luhn($nr)){
				return $nr;
			}
			else {
				return false;
			}
		}
		if (preg_match(Validator::ssNr10, $nr)){
			$nr = str_replace('-', '', $nr); //ta bort streck
			if($this->luhn($nr)){
				return $nr;
			}
			else {
				return false;
			}
		}
		return false;
	}
	function luhn($ssn){
	    $sum = 0;
	 
	    for ($i = 0; $i < strlen($ssn)-1; $i++)
	    {
	        $tmp = substr($ssn, $i, 1) * (2 - ($i & 1)); //växla mellan 212121212
	        if ($tmp > 9) $tmp -= 9;
	        $sum += $tmp;
	    }
	 
	    //extrahera en-talet
	    $sum = (10 - ($sum % 10)) % 10;
	 
	    return substr($ssn, -1, 1) == $sum;
	}
	
	public function validateDate($date){
		if (preg_match(Validator::dateRegex, $date)) {
			$date = str_replace('-', '', $date); //ta bort streck
			if(strlen($date)>6){
				$date = substr($date, 2); //klipp
			}
  			return $date;
		}
		return false;
	}
	
	public function stripJavascript($text){
		$text = strip_tags($text, '<b><i>');
		return $text;
	}
	
	public function noJavascriptHTML($text){
		return strip_tags($text);
	}
	
	public function validPassword($password){
    	if (preg_match(Validator::passwordRegex2, $password)) {
  			return true;
		}
		return false;
    }
	
	public function validUsername($username){
		if (preg_match(Validator::usernameRegex2, $username)){
			return true;
		}
		return false;
	}
	
	public function validNumber($nr){
		return is_numeric($nr);
	}
	
	public function convertToEntities($string){
		return htmlspecialchars($string);
	}
	
	public function validLettersAndDigits($string){
		if (preg_match(Validator::lettersAndDigitsRegex, $string)){
			return true;
		}
		return false;
	}
	
	public function validUrl($string){
		if (filter_var($string, FILTER_VALIDATE_URL) != false){
			return true;
		}
		
		return false;
	}
	
	public function validThumbnail($thumbnail){
		if (preg_match($thumbnailRegex, $thumbnail)){
			return true;
		}
		return false;
	}
	
	public function validIP($ip){
		if (filter_var($ip, FILTER_VALIDATE_IP) != false){
			return true;
		}
		return false;
	}
	
	function Test(){
		echo "Test startar <br />";
		
		if($this->validEmail("ella@kallman.se") == false){
				
			echo "Fel validEmail 1";
			return false;
		}
		if($this->validEmail("ella@kallman.lnu.se") == false){
				
			echo "Fel validEmail 2";
			return false;
		}
		if($this->validEmail("ella.ella@kallman.se") == false){
				
			echo "Fel validEmail 3";
			return false;
		}
		if($this->validEmail("ellakallman.se") == true){
				
			echo "Fel validEmail 4";
			return false;
		}
		if($this->validEmail("ellakallman") == true){
				
			echo "Fel validEmail 4";
			return false;
		}
		echo "Epost-test OK <br />";
		
		
		if($this->validateDate('2011-05-30') == false){
			echo "Fel validateDate 1";
			return false;
		}
		if($this->validateDate('11-05-30') == false){
			echo "Fel validateDate 2";
			return false;
		}
		if($this->validateDate('110530') == false){
			echo "Fel validateDate 3";
			return false;
		}
		if($this->validateDate('11---0530') == true){
			echo "Fel validateDate 3";
			return false;
		}
		echo "Datum-test OK <br />";
		
		if($this->validSocialSecurityNr('891102-7202') == false){
			echo "Fel SSNR 1";
			return false;
		}
		if($this->validSocialSecurityNr('8911027202') == false){
			echo "Fel SSNR 2";
			return false;
		}
		if($this->validSocialSecurityNr('19891102-7202') == false){
			echo "Fel SSNR 3";
			return false;
		}
		if($this->validSocialSecurityNr('198911027202') == false){
			echo "Fel SSNR 4";
			return false;
		}
		if($this->validSocialSecurityNr('207899-8765') == true){
			echo "Fel SSNR 5";
			return false;
		}
		if($this->validSocialSecurityNr('hej') == true){
			echo "Fel SSNR 6";
			return false;
		}
		if($this->validSocialSecurityNr('891102720212345') == true){
			echo "Fel SSNR 7";
			return false;
		}
		if($this->validSocialSecurityNr('21891102-7202') == true){
			echo "Fel SSNR 8";
			return false;
		}
		echo "Personnummer-test OK <br />";
		
		if($this->stripJavascript('<p>Paragraf</p>') == '<p>Paragraf</p>'){
			echo "Fel stripJavascript 1";
			return false;
		}
		if($this->stripJavascript('<b>Bold</b>') != '<b>Bold</b>'){
			echo "Fel stripJavascript 2";
			return false;
		}
		if($this->stripJavascript('<script>alert("Hej");</script>') != 'alert("Hej");'){
			echo "Fel stripJavascript 3";
			return false;
		}
		/*if($this->stripJavascript('<b onclick="hej()">Bold</b>') == '<b onclick="hej()">Bold</b>'){
			echo "Fel stripJavascript 4";
			return false;
		}*/
		
		echo "Javscript-test 1 OK <br />";
		
		if($this->noJavascriptHTML('<p>Paragraf</p>') != 'Paragraf'){
			echo "Fel noJavascriptHTML 1";
			return false;
		}
		
		echo "Javscript & HTML-test OK <br />";
		
		if($this->validPassword('abc')){
			echo "Fel password 1";
			return false;
		}
		if($this->validPassword('ujoihjoioabc1')){
			echo "Fel password 2";
			return false;
		}
		if($this->validPassword('abcAAoikji4') == false){
			echo "Fel password 3";
			return false;
		}
		if($this->validPassword('AAAAAAAAAA7')){
			echo "Fel Password 4";
			return false;
		}
		
		echo "Passwordtest OK <br />";
		
		if($this->validNumber(5) == false){
			echo "Fel Nummer 1";
			return false;
		}
		if($this->validNumber(5e6) == false){
			echo "Fel Nummer 2";
			return false;
		}
		if($this->validNumber('5') == false){
			echo "Fel Nummer 3";
			return false;
		}
		if($this->validNumber('hejhej')){
			echo "Fel Nummer 4";
			return false;
		}
		if($this->validNumber(0xA) == false){
			echo "Fel Nummer 5";
			return false;
		}
		if($this->validNumber(5.7) == false){
			echo "Fel Nummer 6";
			return false;
		}
		
		echo "Nummertest OK";
		
	}
}