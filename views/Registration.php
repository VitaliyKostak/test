<?php 
require ('controllers/UserStatusCheckController.php'); // Підключення методу з визначенням статутсу користувача
$UserStatus = UserStatusCheckController::Check();
if ( $UserStatus == 'UserActivated' ) 
{
	$siteName = require('config/siteName.php');
	header("Location: $siteName");
	exit;
}
require('controllers/RunActionDBeditController.php');
RunActionDB_editController::ActionOnRegistration($_POST);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Регистрация</title>
	<meta name="description" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="site-view/css/bootstrap-4.3.1/bootstrap-grid.min.css"/>
	<link rel="stylesheet" href="site-view/fonts/fonts.css"/>
	<link rel="stylesheet" href="site-view/css/style.css"/>
</head>
<body class="registration_page">
		<!-- Контентна частина -->
		<section class="main-registration-login-block">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-3 col-12 offset-0">
						<div class="wrap-registration_login-block">
							<h1>Регістрация</h1>
								<form action="registration" method="POST">
									<div>
										<input type="text" class="input-registration_login-block" id="input_email" placeholder="E-mail" name="email" value="<?php echo @$data['email']?>">
									</div>
									<div>
										<input type="text" class="input-registration_login-block" id="input_name" placeholder="Ім'я" name="name" value="<?php echo @$data['name']?>">
									</div>
									<div>
										<input type="text" class="input-registration_login-block" id="input_surname" placeholder="Прізвище" name="surname" value="<?php echo @$data['surname']?>">
									</div>
									<div>
										<input type="password" class="input-registration_login-block" id="input_password" placeholder="Пароль" name="password">
									</div>
									<div>
										<button class="button-registration_login-block" name="do_signup">Регістрация</button>
									</div>
									<div>
										<a href="login">Авторизуватися</a>
									</div>
								</form>
						</div>
					</div>
				</div>
			</div>
		</section>
</body>
</html>