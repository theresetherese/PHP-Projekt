<?php

	class InstallHandler{
		
		public function AddTables(){
			$installDAL = new InstallDAL();
			return $installDAL->AddTables();
		}
		
		public function RemoveTables(){
			$installDAL = new InstallDAL();
			return $installDAL->RemoveTables();
		}
		
		public function CheckForTables(){
			$installDAL = new InstallDAL();
			$tables = $installDAL->CheckForTables();
			if(in_array("Dish", $tables) && in_array("User", $tables)){
				return true;
			}
			return false;
		}
	}
