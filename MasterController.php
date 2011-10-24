<?php
	
	/*
	 * Depending on GET, MasterController calls LoginController or RegisterController
	 * 
	 */
	
	require_once 'LoginController.php';
	require_once 'RegisterController.php';
	require_once 'Constants.php';
	
	class MasterController {
		
		
		
		
		/*
		 * Check if GET isset set with right value and key, and call RegisterController. Else, call LoginController.
		 * 
		 */
		public function DoControll(){
			
			$xhtml = "";
			
			//Register form?	
			if(isset($_GET[Constants::RegisterGetKey]) && $_GET[Constants::RegisterGetKey] == Constants::RegisterGetValue){
				
				//Create RegisterController
				$registerController = new RegisterController();
				
				//Run DoControll() and add result to xhtml
				$xhtml .= $registerController->DoControll();
				
				
			}
			//Login form
			else {
				//Create an instance of LoginController
				$loginController = new LoginController();
				
				//Run DoControll() and add result to xhtml
				$xhtml .= $loginController->DoControll();

			}
			
			return $xhtml;
			
		}
		
	}
