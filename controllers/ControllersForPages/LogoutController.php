<?php 
class LogoutController{
	function actionLogout_page()
	{
		require ('controllers/GeneratePageViewController.php');
		GeneratePageViewController::GeneratePageView('Logout');
	}
}
 ?>