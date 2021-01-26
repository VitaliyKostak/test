<?php 
require ('controllers/UserStatusCheckController.php'); // Статус користувача;
$UserStatus = UserStatusCheckController::Check();
if ( $UserStatus == 'NonAuthorized' ) 
{
		header("Location: login");
		exit;
}
$userId = $_SESSION['logged_user']['id'];
$user  = R::findOne( 'users', 'id = ? ', array($userId) ); // (я)
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Друзі</title>
		<meta name="description" content="" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="site-view/css/bootstrap-4.3.1/bootstrap-grid.min.css"/>
		<link rel="stylesheet" href="site-view/fonts/fonts.css"/>
		<link rel="stylesheet" href="site-view/css/style.css"/>
	</head>
	<body class="friendList_page">
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
                <?php 
                $userFriendList = array_reverse(explode("-", $user['friends_list'] )); //Друзі користувача
                $userRequestIN = array_reverse(explode("-", $user['request_in'] )); //Вхідні заявки користувача на добавлення у друзі
                $userRequestOUT = array_reverse(explode("-", $user['request_out'] )); //Вихідні заявки користувача на добавлення у друзі
                $countUserFriendList = count($userFriendList) -1;
                $countUserRequestIN= count($userRequestIN) -1;
                $countUserRequestOUT = count($userRequestOUT) -1;
                ?>
				<div class="col-xl-8">
					<div class="wrapTabsLine">
                        <div class="wrapTab"><span class="tabName friendListTab activeTab">Мої друзі (<?php echo $countUserFriendList; ?>)</span></div>
                        <div class="wrapTab"><span class="tabName requestInTab">Вхідні заявки (<?php echo $countUserRequestIN; ?>)</span></div>
                        <div class="wrapTab"><span class="tabName requestOutTab">Відправлені заявки (<?php echo $countUserRequestOUT; ?>)</span></div>
                    </div>
                    <div class="wrapTabsBlock">
                        <div class="tabBlock friendListTabBlock activeTabBlock">
                            <?php 
                            foreach ($userFriendList as $friendId)
                            {
                                if($friendId != '')
                                {
                                    $friendUser  = R::findOne( 'users', 'id = ? ', array($friendId) );
                                    $friendUserName = $friendUser->name . ' ' . $friendUser->surname;
                                    echo '<div class="wrapBtnFriend">';
                                    echo '<div class="wrapNameBlock">';
                                    if ($friendId != $userId) {
                                        echo '<a class="hostUserName" href="user_id/'.$friendId.'">' . $friendUserName . '</a>';
                                    }
                                    else {
                                        echo '<p class="hostUserName">' . $friendUserName . '</p>';
                                    }
                                    echo '</div>';
                                    echo '<input id="btnFriend" data-user_id="'.$friendUser->id.'" class="btnFriend btnAdded" type="submit" value="У вас у друзях">';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="tabBlock requestInTabBlock" style="display:none">
                        <?php 
                            foreach ($userRequestIN as $friendInId)
                            {
                                if($friendInId != '')
                                {
                                    $friendUser  = R::findOne( 'users', 'id = ? ', array($friendInId) );
                                    $friendUserName = $friendUser->name . ' ' . $friendUser->surname;
                                    echo '<div class="wrapBtnFriend">';
                                    echo '<div class="wrapNameBlock">';
                                    if ($friendInId != $userId) {
                                        echo '<a class="hostUserName" href="user_id/'.$friendInId.'">' . $friendUserName . '</a>';
                                    }
                                    else {
                                        echo '<p class="hostUserName">' . $friendUserName . '</p>';
                                    }
                                    echo '</div>';
                                    echo '<input data-user_id="'.$friendUser->id.'" class="btnFriend btnFriendRequestIN+" type="submit" value="Прийняти">
                                    <input data-user_id="'.$friendUser->id.'" class="btnFriend btnFriendRequestIN-" type="submit" value="Відхилити">';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                        <div class="tabBlock requestOutTabBlock" style="display:none">
                        <?php 
                            foreach ($userRequestOUT as $friendOutId)
                            {
                                if($friendOutId != '')
                                {
                                    $friendUser  = R::findOne( 'users', 'id = ? ', array($friendOutId) );
                                    $friendUserName = $friendUser->name . ' ' . $friendUser->surname;
                                    echo '<div class="wrapBtnFriend">';
                                    echo '<div class="wrapNameBlock">';
                                    if ($friendOutId != $userId) {
                                        echo '<a class="hostUserName" href="user_id/'.$friendOutId.'">' . $friendUserName . '</a>';
                                    }
                                    else {
                                        echo '<p class="hostUserName">' . $friendUserName . '</p>';
                                    }
                                    echo '</div>';
                                    echo '<input id="btnFriend" data-user_id="'.$friendUser->id.'" class="btnFriend btnFriendRequestOUT" type="submit" value="Ви відправили заявку">';
                                    echo '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php 
                ?>
				</div>
			</div>
		</div>
        <script src="js/btnFriend.js"></script>
        <script src="js/friendList.js"></script>
	</body>
</html>