<?php 
class RegistrationController{
	function actionRegistration_page()
	{
		require ('controllers/GeneratePageViewController.php');
		GeneratePageViewController::GeneratePageView('Registration');
	}
}
?>