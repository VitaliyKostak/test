<?php 
class Friend_listController{
	function actionFriend_list_page()
	{
		require ('controllers/GeneratePageViewController.php');
		GeneratePageViewController::GeneratePageView('friend_list');
	}
}
 ?>