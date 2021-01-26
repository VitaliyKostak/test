<?php 
class RunActionDB_editController
{
	// ACTION на сторінці регістрації
	public static function ActionOnRegistration($sourceArr)
	{
		if (isset ($sourceArr['do_signup'])) 
		{
			
			// Тут регістрація
			$l_email = strlen(trim($sourceArr["email"])); //Довжина поля "email"
			$l_name = strlen(trim($sourceArr["name"])); //Довжина поля "Имя"
			$l_surname = strlen(trim($sourceArr["surname"])); //Довжина поля "Фамилия"
			$l_password = strlen($sourceArr["password"]); //Довжина поля "Пароль"
			$errors = array();
			// Валідація email'а
			if (preg_match('#[0-9a-z_-]+@[0-9a-z_-]+\.[a-z]{2,6}$#i', $sourceArr['email'])) 
			{
				$email = $sourceArr['email'];
			}
			elseif ($l_email == 0) 
			{
		    	$errors[] = 'Ви не ввели Email';
			}
			else 
			{
				$errors[] = 'Ви ввели не корректний адрес электронної пошти';
			}
			// Валідація name'а
			if ($l_name == 0) 
			{
		    	$errors[] = "Ви не ввели ім'я";
			} 
			elseif ($l_name <2) 
			{
		    	$errors[] = "Ім'я повинно мати не менше 2-х символів";
			}
			// Валідація surname'а
			if ($l_surname == 0) 
			{
		    	$errors[] = 'Ви не ввели прізвище';
			} 
			elseif ($l_surname < 2 ) 
			{
		    	$errors[] = 'Прізвище повинно мати не менше 2-х символів';
			}
			if ($l_password == 0) 
			{
		    	$errors[] = 'Ви не ввели пароль';
			 } 
			 elseif ($l_password < 6) 
			 {
		     	$errors[] = 'Пароль повинен мати не менше 6 символів';
			 }
			if (R::count('users', "email = ?", array($sourceArr['email']))>0) 
			{
				$errors[] = 'Этот адрес электронной почты уже привязан к другому аккаунту.';
			}
			if (empty($errors)) 
			{
				$user = R::dispense('users');
				$user->email = $email;
				$user->name = trim($sourceArr['name']);
				$user->surname = trim($sourceArr['surname']);
				$user->password = password_hash($sourceArr['password'], PASSWORD_DEFAULT);
				R:: store ($user);
				$_SESSION['logged_user'] = $user;
				$siteName = require('config/siteName.php');
				header("Location:$siteName");
			 	exit();
			}
			else 
			{
				foreach ( $errors as $key ) 
				{
		    		echo $key . '<br>';
				}
			}
		}
	}
	// ACTION На сторінці авторизації
	public static function ActionOnLogin($sourceArr)
	{
		if (isset ($sourceArr['do_login'])) 
		{
			// Авторизація
			$l_email = strlen(trim($sourceArr["email"])); //довжина поля "email"
			$l_password = strlen($sourceArr["password"]); //довжина поля "Пароль"
			$user = R:: findOne('users', 'email = ?', array(trim($sourceArr['email'])));
			$errors = array();

			if ($l_password == 0) 
			{
		    	$errors[] = 'Ви не ввели пароль';
			 } 
			 if ($user)
			 {
			 		// Логін існує
			 	if (password_verify($sourceArr['password'], $user->password)) 
			 	{
			 		// Автризація
			 		$_SESSION['logged_user'] = $user;
			 		$siteName = require('config/siteName.php');
					header("Location:$siteName");
					exit();
			 	}
			 	else 
			 	{
			 		$errors[] = 'Пароль невірний';	
			 	}
			 }
			 else
			 {
			 	if ($l_email == 0) 
			 	{
					$errors[] = 'Ви не ввели Email';
				}		
				else{
					$errors[] = 'Користувача с таким email не знайдено';
				}
			 }

			if ( !empty($errors)) 
			{
				foreach ($errors as $value) 
				{
		    		echo $value . '<br>';
				}
			}
			
		}	
	}
}
?>