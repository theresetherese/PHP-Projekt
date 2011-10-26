<?php

	
	class RegisterHandler{
		
		public function DoRegister(User $user){
			$loginDAL = new LoginDAL();
			
			if($loginDAL->GetUserByName($user) != false){
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
			
			if($loginDAL->GetUserByName($user) != false){
				if($loginDAL->DeleteUser($user) == true){
					return true;
				}
			}
			else{
				return false;
			}
		}
		
	}
