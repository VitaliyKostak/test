<?php 
class All_usersController{
	function actionAll_users_page()
	{
		require ('controllers/GeneratePageViewController.php');
		GeneratePageViewController::GeneratePageView('all_users');
	}
}
 ?>