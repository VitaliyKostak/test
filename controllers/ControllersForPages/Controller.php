<?php 
class Controller{
	function actionMain_page()
	{
		require ('controllers/GeneratePageViewController.php');
		GeneratePageViewController::GeneratePageView('');
	}
}
?>