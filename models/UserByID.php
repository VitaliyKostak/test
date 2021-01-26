<?php 	
class UserByID
{
							// Метод отримання одного запису користувача в з БД
 	public static function get_UserByID($id)
	{
		// ID в число !
 		$id = intval($id);
 		// Перевірка чи переданий ID
 		if ($id) 
 			{
 				// Якщо переданий
 				$theUser = R::load('users', $id);
 			}
 		// Чи існує користувач з таким ID
 		if (!$theUser->id) 
 			{
 				return false;
 			}
 		else 
 			{
 				return $theUser;
 			}
 		
	}
}
 ?>
