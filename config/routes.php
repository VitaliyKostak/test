<?php 
return array(
	'' => '/main_page',
	'registration' => 'registration/registration_page',
	'logout' => 'logout/logout_page',
	'login' => 'login/login_page',
	'my_publications' => 'my_publications/my_publications_page',
	'all_users' => 'all_users/all_users_page',
	'friend_list' => 'friend_list/friend_list_page',
	'user_id/([1-9]([0-9]{1,9})?)' => 'user_id/user_id_page/$1'
);
 ?>