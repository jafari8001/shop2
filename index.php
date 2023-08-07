<?php
    include "./routers/Router.php";
    include "./routers/User.php";
    include "./models/Database.php";
    include "./models/User.php";
    include "./config.php";


    $router = new Router();

    $dbClass = new Database("shop");

    $user_router = new UserRouter($dbClass);
    
    $router->addRoute('get-all-users', function () {
        global $user_router;
        echo $user_router->get_all_users();
    });

    $router->addRoute('add-user', function () {
        global $user_router;
        echo $user_router->add_user();
    });
    
    $url = $_SERVER['REQUEST_URI'];
    $router->dispatch($url);
?>