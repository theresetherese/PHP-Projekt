<?php

	
	class RegisterHandler{
			
		public function DoesUserExist(User $user){
			$loginDAL = new LoginDAL();	
			if($loginDAL->GetUserByName($user) instanceof User){
				$error = new ErrorMessage(ErrorStrings::UserExists);
				return $error;
			}
			else{
				return false;
			}
		}	
		
		public function DoRegister(User $user){
			$loginDAL = new LoginDAL();		
			if($loginDAL->AddUser($user) == true){
				return true;
			}
			return false;
		}
		
		public function DoDelete (User $user){
			$loginDAL = new LoginDAL();		
			if($loginDAL->DeleteUser($user) == true){
				return true;
			}
			return false;
		}
		
	}
