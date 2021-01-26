<?php 
class UserStatusCheckController
{
	// Авторизований/Не авторизований
	public static function Check()
	{
		if (isset($_SESSION['logged_user']))
		{
			$UserStatus = 'UserActivated';
		}

		else

		{
			$UserStatus = 'NonAuthorized';
		}
		return $UserStatus;
	}
}


 ?>