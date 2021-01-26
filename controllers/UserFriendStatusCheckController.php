<?php 
class UserFriendStatusCheckController
{

	public static function Check($UserId, $OtherUserId)
	{
        $user  = R::findOne( 'users', 'id = ? ', array($UserId) ); // (я)
        $userFriendList = explode("-", $user['friends_list'] ); //Друзі користувача
        $userRequestIN = explode("-", $user['request_in'] ); //Вхідні заявки користувача на добавлення у друзі
        $userRequestOUT = explode("-", $user['request_out'] ); //Вихідні заявки користувача на добавлення у друзі

        if ( $user['friendsList'] != NULL )
        {
            foreach ( $userFriendList as $key )
            {
                if ( $key == $OtherUserId )
                {
                    
                    return '<input id="btnFriend" data-user_id="'.$OtherUserId.'" class="btnFriend btnAdded" type="submit" value="У вас у друзях">';
                    exit;
                }
            }
        }
        
        if ( $user['requestIN'] != NULL )
        {
            foreach ( $userRequestIN as $key )
            {
                if ( $key == $OtherUserId )
                {
                    return '<input data-user_id="'.$OtherUserId.'" class="btnFriend btnFriendRequestIN+" type="submit" value="Прийняти">
                    <input data-user_id="'.$OtherUserId.'" class="btnFriend btnFriendRequestIN-" type="submit" value="Відхилити">';
                    exit;
                }
            }
        }
        if ( $user['requestOUT'] != NULL )
        {
            foreach ( $userRequestOUT as $key )
            {
                if ( $key == $OtherUserId )
                {
                    return '<input id="btnFriend" data-user_id="'.$OtherUserId.'" class="btnFriend btnFriendRequestOUT" type="submit" value="Ви відправили заявку">';
                    exit;
                }
            }
        }
        return '<input id="btnFriend" data-user_id="'.$OtherUserId.'" class="btnFriend btnFriendADD" type="button" value="+ Добавити у друзі">';
    }
}


 ?>