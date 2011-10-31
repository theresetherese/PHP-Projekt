<?php

	class InstallController{
		public function DoControll(){
			$installHandler = new InstallHandler();
			$installView = new InstallView();
			
			$xhtml = $installView->DoLinks();
			
			if($installView->TriedToInstall()){
				if($installHandler->AddTables()){
					if($installHandler->CheckForTables()){	
						$xhtml = $installView->DoSuccessText();
					}
					else{
						$xhtml = $installView->DoFailText();
					}
				}
				else{
					$xhtml = $installView->DoFailText();
				}
			}
			
			if($installView->TriedToUninstall()){	
				if($installHandler->RemoveTables()){
					if($installHandler->CheckForTables() == false){	
						$xhtml = $installView->DoSuccessText();
					}
					else{
						$xhtml = $installView->DoFailText();
					}
				}
				else{
					$xhtml = $installView->DoFailText();
				}
			}
			
			return $xhtml;
		}
	}
