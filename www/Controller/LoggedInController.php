<?php
	
	/*
	 * Decides which information to show when logged in
	 *  
	 */
	
	require_once './View/LoggedInView.php';
	
	class LoggedInController {
		
		public function DoControll(){
			$loggedInView = new LoggedInView();
			
			$xhtml = $loggedInView->DoRandomDish();
			$xhtml .= $loggedInView->AddNewDishLink();
			$xhtml .= $loggedInView->ShowDishesLink();
			
			return $xhtml;
		}
		
	}
