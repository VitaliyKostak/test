<?php 
require ('controllers/UserStatusCheckController.php'); // Підключення методу з визначенням статусу користувача
$UserStatus = UserStatusCheckController::Check();
if ($UserStatus == 'UserActivated') {
	$userId = $_SESSION['logged_user']['id'];
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Всі користувачі</title>
	<meta name="description" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="site-view/css/bootstrap-4.3.1/bootstrap-grid.min.css"/>
	<link rel="stylesheet" href="site-view/fonts/fonts.css"/>
	<link rel="stylesheet" href="site-view/css/style.css"/>
</head>
<body class="all_users">
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
                <h1>Всі користувачі</h1>
				<?php 
				require ('models/GetAllUsers.php');
				$allUsers = GetAllUsers::Get();
				if ($UserStatus == 'UserActivated')
				{
					foreach ($allUsers as $user){
						echo '<div class="wrapUserLink">';
						if( $user->id == $userId )
						{
							echo '<span class="userLink">' . $user->name . ' ' . $user->surname . '</span>';
						}
						else {
							echo '<a class="userLink" href="user_id/' . $user->id . '">' . $user->name . ' ' . $user->surname . '</a>';
						}
						echo '</div>';
					}
				}
				else {
					foreach ($allUsers as $user) {
						echo '<div class="wrapUserLink">';
						echo '<a class="userLink" href="user_id/' . $user->id . '">' . $user->name . ' ' . $user->surname . '</a>';
						echo '</div>';
					}
				}
				
				
				?>
			</div>
		</div>
    </div>
</body>
</html>