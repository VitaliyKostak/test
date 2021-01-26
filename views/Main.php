<?php 
require ('controllers/UserStatusCheckController.php'); // Підключення методу з визначенням статусу користувача
$UserStatus = UserStatusCheckController::Check();
if ( $UserStatus == 'NonAuthorized' ) 
{
	header("Location: login");
	exit;
}
$userId = $_SESSION['logged_user']['id'];
$user = R:: findOne('users', 'id = ?', array($userId));
$userFullName = $user['name']. ' ' . $user['surname'];
require ('models/GetPublications.php');
$publications = GetPublications::Get('manyUsers', $userId);
$publicationsLength = count($publications);
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Стрічка</title>
	<meta name="description" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="site-view/css/bootstrap-4.3.1/bootstrap-grid.min.css"/>
	<link rel="stylesheet" href="site-view/fonts/fonts.css"/>
	<link rel="stylesheet" href="site-view/css/style.css"/>
</head>
<body class="main_page">
	<div class="container-fluid">	
		<div class="row">
			<div class="col-xl-3">
					<nav class="side_bar">
					<?php 
						require ('controllers/sidebarLinksGenerateController.php');
						sidebarLinksGenerateController::Generate($PageName);
					?>
						
					</nav>					
			</div>
			<div class="col-xl-8">
				<?php 
				if ($publicationsLength ==0 ){
					echo '<h1>Немає публікацій друзів</h1>';
				}
				else {
					echo '<h1>Публікації друзів</h1>';
					echo '<div class="wrap-my-publications">';
                    echo '<div class="wrap-publications">';
					require ('controllers/publicationsOutputController.php');
					publicationsOutputController::output($publications);
					echo '</div>';
                	echo '</div>';
				}
				?>
			</div>
		</div>
	</div>
	<script src="js/publicationScript.js"></script>
</body>
</html>
