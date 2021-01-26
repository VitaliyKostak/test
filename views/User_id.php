<?php 
global $dataOfUser;
$userId = $dataOfUser['id'];
$userName = $dataOfUser['name'];
$userSurname = $dataOfUser['surname'];
$numberOfUserArticles = R::count('publications', "author_identeficator = ?", array($dataOfUser['id'])); // Кількість публікацій власника сторінки
require ('controllers/UserFriendStatusCheckController.php'); // Чи є власник сторінки у списку друзів
require ('controllers/UserStatusCheckController.php'); // Статус користувача
require ('models/GetPublications.php');
$publications  = GetPublications::Get('oneUser', $userId); // публікації власника сторінки
$UserStatus = UserStatusCheckController::Check();
if ( $UserStatus == 'UserActivated' ) 
{
	if ( $dataOfUser['id'] == $_SESSION['logged_user']['id'] ) // Перехід на свою ж сторінку - неможливий
	{
		header("Location: my_publications");
		exit;
	}
}

 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $userName . ' ' .  $userSurname?></title>
		<meta name="description" content="" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="../site-view/css/bootstrap-4.3.1/bootstrap-grid.min.css"/>
		<link rel="stylesheet" href="../site-view/fonts/fonts.css"/>
		<link rel="stylesheet" href="../site-view/css/style.css"/>
	</head>
	<body class="user_page">
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
					<div class="wrapUserTopBlock">
						<div class="wrapNameBlock">
							<p class="hostUserName"><?php echo $userName . ' ' .  $userSurname?></p>
							<p class="numberOfUserArticles">Публикацій: <?php echo $numberOfUserArticles?></p>
						</div>
						<?php 
						if ( $UserStatus == 'UserActivated' )
						{
							echo UserFriendStatusCheckController::Check($_SESSION['logged_user']['id'], $userId);
						}
					echo '</div>';
					if ($numberOfUserArticles !=0)
					{
						echo '<div class="wrap-publications">';
						require ('controllers/publicationsOutputController.php');
						publicationsOutputController::output($publications);
						echo '</div>';
                    }
					?>	
				</div>
			</div>
		</div>
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/btnFriend.js"></script>
		<script src="../js/publicationScript.js"></script>
	</body>
</html>