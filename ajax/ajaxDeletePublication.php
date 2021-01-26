<?php 
require "../db.php";
$publicationId = $_POST['publicationId'];
$publication = R::load( 'publications', $publicationId );
if ($_SESSION['logged_user']['id'] == $publication->author_identeficator)
{
    require ('../models/GetComments.php');
    $comments  = GetComments::Get($publicationId);
    R::trash( $publication );
    R::trashAll( $comments );
    $numberPublications = R::count('publications', "author_identeficator = ?", array($_SESSION['logged_user']['id'])); // Кількість публікацій користувача
    echo $numberPublications;
}

 
