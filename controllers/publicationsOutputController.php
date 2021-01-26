<?php 
class publicationsOutputController
{
	public static function output($publicationsArr)
	{
        $siteName = require('config/siteName.php');
        $UserStatus = UserStatusCheckController::Check();
        require ('models/GetComments.php');
        foreach($publicationsArr as $key)
		{
            // require ('controllers/UserStatusCheckController.php');
            $UserStatus = UserStatusCheckController::Check();
			$author = R:: findOne('users', 'id = ?', array($key->author_identeficator));
			$authorName = $author->name . ' ' . $author->surname;
			$publicateTimeArr = getdate($key->publication_time);
			$publicateTime = $publicateTimeArr['mday'] . "." . $publicateTimeArr['mon'] . "." . $publicateTimeArr['year'] . " " . $publicateTimeArr['hours']. ':' . $publicateTimeArr['minutes'];
            echo '<div class="wrap-publication" id="'.$key->id.'">';
            if ($UserStatus == 'NonAuthorized') {
                echo '<a class="name-author" href="'.$siteName.'user_id/' . $key->author_identeficator . '">'. $authorName .'</a>';
            }
            else if ($UserStatus == 'UserActivated')
            {
                if ( $_SESSION['logged_user']['id'] != $key->author_identeficator )
                {
                    echo '<a class="name-author" href="'.$siteName.'user_id/' . $key->author_identeficator . '">'. $authorName .'</a>';
                }
                else {
                    echo '<span class="name-author">'. $authorName .'</span>';
                }
            }
            
			
			echo '<span class="publication-time">'. $publicateTime .'</span>';
			if ( $UserStatus == 'UserActivated' && $_SESSION['logged_user']['id'] == $key->author_identeficator)
			{
				echo '<span alt="Видалити вашу публікацію" class="delete-publication">Видалити</span>';
			}
            echo '<p class="body-publication">' .$key->publicate_content . '</p>';
            $numberPublicationComments = R::count('comments', "publication_identeficator = ?", array($key->id)); // Кількість коментарів до публікації
            echo '<p class="btn-comments-publication">Коментарі ('.$numberPublicationComments.')</p>';
            echo '<div class="wrapBodyComments" style="display:none">';
            if ( $UserStatus == 'UserActivated' && $_SESSION['logged_user']['id'] != $key->author_identeficator)
			{
				echo '<textarea class="commentValue" minlength="1" maxlength="200"></textarea>';
                echo '<input data-publicatationId="' . $key->id . '" class="buttonCommentAdder" type="submit" value="Добавити коментар">';
			}
            
            if ($numberPublicationComments != 0 )
            {
                echo '<div class="wrapComments">';
                $comments  = GetComments::Get($key->id);
                foreach ($comments as $comment)
                {
                    $commentAuthor = R:: findOne('users', 'id = ?', array($comment->author_identeficator));
                    $commentPublicationTimeArr = getdate($comment->publication_time);
                    $commentPublicationTime = $commentPublicationTimeArr['mday'] . "." . $commentPublicationTimeArr['mon'] . "." . $commentPublicationTimeArr['year'] . " " . $commentPublicationTimeArr['hours']. ':' . $commentPublicationTimeArr['minutes'];
                    $commentValue = $comment->body_comment;
                    echo '<div class="wrapComment">';
                    if ($UserStatus == 'UserActivated' && $_SESSION['logged_user']['id'] != $comment->author_identeficator)
                    {
                        echo '<a class="commentAuthor" href="'.$siteName.'user_id/' . $comment->author_identeficator . '">'. $commentAuthor['name'] . ' ' . $commentAuthor['surname']. '</a>';
                    }
                    else if ($UserStatus == 'UserActivated' && $_SESSION['logged_user']['id'] == $comment->author_identeficator){
                        echo '<span class="commentAuthor">'. $commentAuthor['name'] . ' ' . $commentAuthor['surname']. '</span>';
                    }
                    else {
                        echo '<a class="commentAuthor" href="'.$siteName.'user_id/' . $comment->author_identeficator . '">'. $commentAuthor['name'] . ' ' . $commentAuthor['surname']. '</a>';
                    }
                    echo '<span class="commentPublicationTime">'. $commentPublicationTime . '</span>';
                    if ( $UserStatus == 'UserActivated' && $_SESSION['logged_user']['id'] == $comment->author_identeficator)
			        {
				        echo '<span alt="Видалити ваш коментар" class="deleteComment" data-commentId="' . $comment->id . '">Видалити</span>'; 
                    }
                    echo '<p class="commentVal">'. $commentValue . '</p>';
                    
                    echo '</div>';
                }
                echo '</div>';
            }
            echo '</div>';
            echo '</div>';
		}
	}
}


 ?>