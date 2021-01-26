<?php 
require ('controllers/UserStatusCheckController.php'); // Подключение Класса с методом определеня статуса Пользователя
$UserStatus = UserStatusCheckController::Check();
if ( $UserStatus == 'NonAuthorized' ) 
{
	header("Location:login");
	exit;
}
elseif ( $UserStatus == 'UserActivated' )
{
	unset($_SESSION['logged_user']);
    $siteName = require('config/siteName.php');
	header("Location:login");
	exit;
}
?>