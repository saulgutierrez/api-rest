<?php
    require_once "controllers/routes.controller.php";
    require_once "controllers/courses.controller.php";
    require_once "controllers/clients.controller.php";
    
    $routes = new RoutersController();
    $routes->index();
?>