<?php 
require "libsBackEnd/rb.php";
R::setup( 'mysql:host=localhost;dbname=test.ua',
        'root', '' );
R::freeze(true);
session_start();
 ?>