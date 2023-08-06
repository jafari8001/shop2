<?php
    include "./routers/Router.php";
    include "./routers/User.php";
    include "./routers/Database.php";
    include "./models/Database.php";

    $router = new Router();
    
    
    $router->addRoute('create-database', function () {
        create_database();
    });
    
    $router->addRoute('get-all-users', function () {
        get_all_users();
    });

    $router->addRoute('add-user', function () {
        add_user();
    });
    
    $url = $_SERVER['REQUEST_URI'];
    $router->dispatch($url);
?>