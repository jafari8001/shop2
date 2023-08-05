<?php
    include "./routers/Router.php";
    include "./routers/User.php";

    $router = new Router();
    
    
    $router->addRoute('get-all-users', function () {
        get_all_users();
    });
    
    $url = $_SERVER['REQUEST_URI'];
    $router->dispatch($url);
?>