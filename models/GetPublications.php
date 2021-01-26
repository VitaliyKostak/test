<?php 	
class GetPublications
{
 	public static function Get($type, $Id)
	{
		if ($type == 'oneUser'){
			return R::find( 'publications', "author_identeficator = ? ORDER BY `publication_time` DESC", array($Id));
		}
		else if ($type == 'manyUsers') {
			$user  = R::findOne( 'users', 'id = ? ', array($Id) );
			$userFriendList = explode("-", $user['friends_list'] ); //Друзі користувача
			return R::findLike( 'publications', array('author_identeficator' => $userFriendList), 'ORDER BY `publication_time` DESC' );
			
		}
    	
	}
}