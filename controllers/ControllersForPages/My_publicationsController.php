<?php 
class My_publicationsController{
	function actionMy_publications_page()
	{
		require ('controllers/GeneratePageViewController.php');
		GeneratePageViewController::GeneratePageView('my_publications');
	}
}
 ?>