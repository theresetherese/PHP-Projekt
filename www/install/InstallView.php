<?php

	class InstallView{
		public function DoSuccessText(){
			$xhtml = "<h1>Åtgärden utfördes korrekt</h1>";
			return $xhtml;
		}
		
		public function DoFailText(){
			$xhtml = "<h1>Åtgärden kunde inte utföras</h1>";
		}
		
		public function DoLinks(){
			$xhtml = "<p><a href='?install=install'>Installera tabeller i databasen</a></p>";
			$xhtml .= "<p><a href='?uninstall=uninstall'>Avinstallera tabeller</a></p>";
			return $xhtml;
		}
		
		public function TriedToInstall(){
			if(isset($_GET['install']) && $_GET['install'] == 'install'){
				return true;
			}
			return false;
		}
		
		public function TriedToUninstall(){
			if(isset($_GET['uninstall']) && $_GET['uninstall'] == 'uninstall'){
				return true;
			}
			return false;
		}
	}
