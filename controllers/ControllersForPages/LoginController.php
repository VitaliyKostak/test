<?php 
class LoginController{
	function actionLogin_page()
	{
		require ('controllers/GeneratePageViewController.php');
		GeneratePageViewController::GeneratePageView('Login');
	}
}
 ?>