<?php 
class User_idController{
	function actionUser_id_page($userId)
	{
		$userId = $userId[0];
		require 'models/userByID.php';
		global $dataOfUser;
		$dataOfUser = UserByID::get_UserByID($userId);
		if ( $dataOfUser == false ) {
			// Перенаправити на 404
			$siteName = require('config/siteName.php');
			header("Location: $siteName");
			exit;
		}
		else
		{
			require ('controllers/GeneratePageViewController.php');
			GeneratePageViewController::GeneratePageView('User_id');
		}
		
	}
}
 ?>