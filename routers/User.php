<?php
    include "./models/User.php";
    function get_all_users(){
        $user = new User();
        echo json_encode($user->getAllUsers());
    }
?>