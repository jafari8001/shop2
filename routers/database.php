<?php
    // include "./models/Database.php";
    function create_database(){
        $db = new Database("shop");
        $db::getInstance("shop");
    }
?>