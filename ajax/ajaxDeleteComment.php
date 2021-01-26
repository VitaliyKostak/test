<?php 
require "../db.php";
$commentId = $_POST['commentId'];
$comment = R::load( 'comments', $commentId );
R::trash( $comment );
 
