<?php
    include "./routers/Router.php";
    include "./routers/User.php";
    include "./models/Database.php";


    $router = new Router();
    $dbClass = new Database("shop");
    $db = $dbClass::getInstance("shop");
    
    $router->addRoute('get-all-users', function () {
        global $db;
        get_all_users($db);
    });

    $router->addRoute('add-user', function () {
        global $db;
        add_user($db);
    });
    
    $url = $_SERVER['REQUEST_URI'];
    $router->dispatch($url);
?>