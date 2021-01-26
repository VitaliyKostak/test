<?php 
require "../db.php";
$inDataArr = explode('?', $_POST['outPutData']);
$commentValue = $inDataArr[0];
$publicationId = $inDataArr[1];
$publication = R::load( 'publications', $publicationId );
if ($publication->id !=0 )
{
    $userId = $_SESSION['logged_user']['id'];
    $publicationTime = time();
    $comment = R::dispense('comments');
    $comment->author_identeficator = $userId;
    $comment->publication_identeficator = $publicationId;
    $comment->body_comment = $commentValue;
    $comment->publication_time = $publicationTime;
    $justAddedCommentId = R::store ($comment);
    
        $commentAuthor = R:: findOne('users', 'id = ?', array($userId));
        $commentPublicationTimeArr = getdate($publicationTime);
        $commentPublicationTime = $commentPublicationTimeArr['mday'] . "." . $commentPublicationTimeArr['mon'] . "." . $commentPublicationTimeArr['year'] . " " . $commentPublicationTimeArr['hours']. ':' . $commentPublicationTimeArr['minutes'];
        echo '<span class="commentAuthor">'. $commentAuthor['name'] . ' ' . $commentAuthor['surname']. '</span>';
        echo '<span class="commentPublicationTime">'. $commentPublicationTime . '</span>';
        echo '<span alt="Видалити ваш коментар" class="deleteComment" data-commentId="' . $justAddedCommentId . '">Видалити</span>'; 
        echo '<p class="commentVal">'. $commentValue . '</p>';
}

 
