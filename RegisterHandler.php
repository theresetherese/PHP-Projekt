<?php
	
	require_once 'LoginDAL.php';
	
	class RegisterHandler{
		
		public function DoRegister(User $user){
			$loginDAL = new LoginDAL();
			
			if($loginDAL->CheckUsernameExists($user) == true){
				return false;
			}
			else{
				if($loginDAL->AddUser($user) == true){
					return true;
				}
				return false;
			}
		}
		
		public function DoDelete (User $user){
			$loginDAL = new LoginDAL();
			
			if($loginDAL->CheckUsernameExists($user) == true){
				if($loginDAL->DeleteUser($user) == true){
					return true;
				}
			}
			else{
				return false;
			}
		}
		
	}
