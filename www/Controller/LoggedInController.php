<?php
	
	/*
	 * Decides which information to show when logged in
	 *  
	 */
	
	class LoggedInController {
		
		public function DoControll(){
			$loggedInView = new LoggedInView();
			
			$xhtml = $loggedInView->DoRandomDish();
			$xhtml .= $loggedInView->AddNewDishLink();
			$xhtml .= $loggedInView->ShowDishesLink();
			
			return $xhtml;
		}
		
	}
