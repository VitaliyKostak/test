<?php 
require "../db.php";
$publicationId = $_POST['publicationId'];
$numberPublicationComments = R::count('comments', "publication_identeficator = ?", array($publicationId)); // Кількість коментарів до публікації
echo $numberPublicationComments;
 
