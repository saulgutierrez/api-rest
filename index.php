<?php
    require_once "controllers/routes.controller.php";
    require_once "controllers/courses.controller.php";
    require_once "controllers/clients.controller.php";
    require_once "models/clients.model.php";
    require_once "models/courses.model.php";
    
    $routes = new RoutersController();
    $routes->index();
?>