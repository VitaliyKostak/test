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
require ('models/AddPublication.php');
AddPublication::Add($_POST, $userId);
$numberOfUserArticles = R::count('publications', "author_identeficator = ?", array($userId)); // Кількість публікацій
require ('models/GetPublications.php');
$publications  = GetPublications::Get('oneUser', $userId);
 ?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Мої публікації</title>
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
                <div class="wrap-block-adder-publication">
                    <form action="my_publications" method="POST">
                        <textarea id="my_publication_text" name="my_publication" minlength="1" maxlength="200"></textarea>
                        <input id="button_publication_adder" type="submit" disabled="disabled" name="go_publicate" value="Опублікувати">
                    </form>
                </div>
                <div class="wrap-my-publications">
                    <p id="count-publications">Публікацій: <?php echo $numberOfUserArticles; ?></p>
                    <?php 
                    echo '<div class="wrap-publications">';
					require ('controllers/publicationsOutputController.php');
					publicationsOutputController::output($publications);
					echo '</div>';
                    ?>
                </div>
			</div>
		</div>
    </div>
    <script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/my_publications.js"></script>
	<script src="js/publicationScript.js"></script>
</body>
</html>