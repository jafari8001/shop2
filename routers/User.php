<?php
    include "./models/User.php";
    $user = new User();
    function get_all_users($db){
        global $user;
        echo json_encode($user->getAllUsers());
    }

    function add_user($db){
        global $user;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $inputJSON = file_get_contents('php://input');
            $data = json_decode($inputJSON, true);

            echo json_encode($user->addUser($data));
            
        }else {
            echo json_decode("data is not set");
        }
        
    }
?>