<?php
    class UserRouter{
        private $db;
        private $user;
        public function __construct($db) {
            $this->db = $db;
            $this->user = new User($this->db);
        }

        public function get_all_users(){
            return json_encode($this->user->getAllUsers());
        }

        public function add_user(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $inputJSON = file_get_contents('php://input');
            $data = json_decode($inputJSON, true);

            return json_encode($this->user->addUser($data));
            
        }else {
            return json_decode("data is not set");
        }
    }


    }

?>