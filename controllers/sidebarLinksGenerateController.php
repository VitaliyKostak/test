<?php 
class sidebarLinksGenerateController
{
	
	public static function Generate($pageName)
	{
        $sidebarLinks = require ('config/sidebarLinks.php'); // Підключення sidebarLinks
        $siteName = require('config/siteName.php');
        if ( isset($_SESSION['logged_user']['id']) ) {
            $user = R::findOne( 'users', 'id = ? ', array($_SESSION['logged_user']['id']) );
            $userRequestIN = explode("-", $user['request_in'] ); //Вхідні заявки користувача на добавлення у друзі
            $countUserRequestIN = count($userRequestIN) -1;
                echo '<div class="wrap_userFullName">	
                    <p class="userFullName">'.$user->name. ' ' . $user->surname . '</p>
                </div>';
            echo '<ul>';
            foreach ( $sidebarLinks as $expectedPageName => $pageTitle)
            {
                if ( $pageTitle == 'Друзі' ) {
                    if ($countUserRequestIN != 0)
                    {
                        $pageTitle = $pageTitle. ' +' . $countUserRequestIN;
                    }
                }

                if	($expectedPageName == $pageName)
                {
                    echo '<li class="sideBarLink activeSideBarLink"><span>'. $pageTitle .'</span></li>';
                }
                else
                {
                    echo '<li class="sideBarLink"><a href="'. $siteName .$expectedPageName .'">'. $pageTitle .'</a></li>';
                }
            }
            echo '</ul>';
        }
        else {
            echo'<div class="login_registrationLinks">
				<a href="login">Авторизуватися</a>
			</div>
			<div class="login_registrationLinks">
				<a href="registration">Створити аккаунт</a>
			</div>';
        }
	}
}


 ?>