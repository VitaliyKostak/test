<?php 
require "../db.php";
$input_data_arr = explode("?", $_POST['outPutData']); // Повертає масив строк.
$requiredAction = $input_data_arr[0]; // Потрібні дії
$friendUserId = intval($input_data_arr[1]); // id користувача (friend)
$userId = $_SESSION['logged_user']['id']; // id користувача (я)
$friendUser = R::findOne('users', 'id = ?', array($friendUserId) );
$user = R::findOne('users', 'id = ?', array($userId) );
$userRequestINarr = explode("-", $user['request_in']); // массив з id's користувачів котрі відправили заявку на добавлення у друзі
$userRequestOUTarr = explode("-", $user['request_out']); // массив з id's користувачів котрим була відправлена заявка на добавлення у друзі
$friendUserRequestOUTarr = explode("-", $friendUser['request_out']); // массив з id's користувачів котрим була відправлена заявка на добавлення у друзі
$friendUserRequestINarr = explode("-", $friendUser['request_in']); // массив з id's користувачів котрі відправили заявку на добавлення у друзі
$userFriendListArr = explode("-", $user['friends_list']); // массив з id's користувачів котрі у списку друзів
$Friend_FriendListArr = explode("-", $friendUser['friends_list']); // массив з id's користувачів котрі у списку друзів

if ( $requiredAction == 'btnFriendADD' ) // Натиснути кнопка "Добавити у друзі"
{
    if ( !in_array($friendUserId, $userRequestOUTarr) && !in_array($friendUserId, $userRequestINarr) && !in_array($userId, $friendUserRequestOUTarr) && !in_array($userId, $friendUserRequestINarr) && !in_array($friendUserId, $userFriendListArr) && !in_array($userId, $Friend_FriendListArr) )
    {
        $userRequestOUTarr[] = $friendUserId; // Добавлення id в массив користувачів котрим була відправлена заявка на добавлення у друзі
        $user['request_out'] = implode("-", $userRequestOUTarr);
        R::store($user); // Оновлення БД
        $friendUserRequestINarr[ ]= $userId; // Добавлення id в массив користувачів котрі відправили заявку на добавлення у друзі
        $friendUser['request_in'] = implode("-", $friendUserRequestINarr);
        R::store($friendUser); // Оновлення БД
        $returnedData = 'btnFriendRequestOUT' . '?' . 'Ви відправили заявку';
        echo $returnedData;
    }
}
// Відмінити відправлену заявку
elseif ($requiredAction == 'btnFriendRequestOUT')
{
    if ( in_array($friendUserId, $userRequestOUTarr) && in_array($userId, $friendUserRequestINarr) )
    {
        $keyFriendUserId = array_search($friendUserId, $userRequestOUTarr); // Ключ елемента массива зі значенням id friendUser
        unset($userRequestOUTarr[$keyFriendUserId]); // Видалення елемента з id  friendUserId
        $user['request_out'] = implode("-", $userRequestOUTarr);
        R::store($user); // Оновлення БД
   
        $keyUserId = array_search($userId, $friendUserRequestINarr); // Ключ елемента массива зі значенням id User
        unset($friendUserRequestINarr[$keyUserId]); // Видалення елемента з id UserId
        $friendUser['request_in'] = implode("-", $friendUserRequestINarr);
        R::store($friendUser); // Оновлення БД
        $returnedData = 'btnFriendADD' . '?' . '+ Добавити у друзі';
        echo $returnedData;
    }
    
    
    
}
// Прийняти заявку у друзі
elseif ($requiredAction == 'btnFriendRequestIN+')
{
    if ( in_array($friendUserId, $userRequestINarr) && in_array($userId, $friendUserRequestOUTarr) && !in_array($friendUserId, $userFriendListArr) && !in_array($userId, $Friend_FriendListArr) )
    {
        $userFriendListArr[] = $friendUserId; // Добавлення id в массив користувачів котрі у списку друзів
        $user['friends_list'] = implode("-", $userFriendListArr);
        $userRequestINarr = explode("-", $user['request_in']); /// массив з id's користувачів котрі відправили заявку на добавлення у друзі
        $keyFriendUserId = array_search($friendUserId, $userRequestINarr); // Ключ елемента массива зі значенням id friendUser
        unset($userRequestINarr[$keyFriendUserId]); // Видалення елемента з id  friendUserId
        $user['request_in'] = implode("-", $userRequestINarr);
        R::store($user); // Оновлення БД
        $Friend_FriendListArr[] = $userId; // Добавлення id в массив користувачів котрі у списку друзів
        $friendUser['friends_list'] = implode("-", $Friend_FriendListArr);
        $friendUserRequestOUTarr = explode("-", $friendUser['request_out']); // массив з id's котрим була відправлена заявка у друзі
        $keyUserId = array_search($userId, $friendUserRequestOUTarr); // Ключ елемента массива зі значенням id User
        unset($friendUserRequestOUTarr[$keyUserId]); // Видалення елемента з id UserId
        $friendUser['request_out'] = implode("-", $friendUserRequestOUTarr);
        R::store($friendUser); // Оновлення БД
        $returnedData = 'btnAdded' . '?' . 'У вас у друзях';
        echo $returnedData;
    } 
    
    
}
// Відхилити заявку у друзі
elseif ($requiredAction == 'btnFriendRequestIN-')
{
    if ( in_array($friendUserId, $userRequestINarr) && in_array($userId, $friendUserRequestOUTarr) )
    {
        $keyFriendUserId = array_search($friendUserId,$userRequestINarr); // Ключ елемента массива зі значенням id friendUser
        unset($userRequestINarr[$keyFriendUserId]); // Видалення елемента з id  friendUserId
        $user['request_in'] = implode("-", $userRequestINarr);
        R::store($user); // Оновлення БД
        $keyUserId = array_search($userId, $friendUserRequestOUTarr); // Ключ елемента массива зі значенням id User
        unset($friendUserRequestOUTarr[$keyUserId]); // Видалення елемента з id UserId
        $friendUser['request_out'] = implode("-", $friendUserRequestOUTarr);
        R::store($friendUser); // Оновлення БД
        $returnedData = 'btnFriendADD' . '?' . '+ Добавити у друзі';
        echo $returnedData;
    }
    
    
    
}
// Видалити зі списку друзів
elseif ($requiredAction == 'btnAdded')
{
    if ( in_array($friendUserId, $userFriendListArr) && in_array($userId, $Friend_FriendListArr)  ) 
    {
        $keyFriendUserId = array_search($friendUserId, $userFriendListArr); // Ключ елемента массива зі значенням id friendUser
        unset($userFriendListArr[$keyFriendUserId]); // Видалення елемента з id  friendUserId
        $user['friends_list'] = implode("-",  $userFriendListArr);
        R::store($user); // Оновлення БД
        $keyUserId = array_search($userId, $Friend_FriendListArr); // Ключ елемента массива зі значенням id friendUser
        unset($Friend_FriendListArr[$keyUserId]); // Видалення елемента з id  friendUserId
        $friendUser['friends_list'] = implode("-",  $Friend_FriendListArr);
        R::store($friendUser); // Оновлення БД
        $returnedData = 'btnFriendADD' . '?' . '+ Добавити у друзі';
        echo $returnedData;
    }
   
}
?>