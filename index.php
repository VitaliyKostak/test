<?php 
    // Підключення БД
    require 'db.php';
    error_reporting(E_ALL);
    require_once 'components/router.php';
    $router = new Router;
    $router->run();
    
 ?>