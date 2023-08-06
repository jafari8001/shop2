<?php
include "./models/Database.php";
class User{
    private $db;
    public function __construct() {
        $this->db = Database::getInstance("shop") ;
    }

    public function addUser($data){
        if (!isset($data['username']) || empty($data['username']) ||
            !isset($data['email']) || empty($data['email']) ||
            !isset($data['password']) || empty($data['password']) ||
            !isset($data['role']) || empty($data['role'])) {
            return [
                "status" => "400",
                "message" => "Fill in all fields",
                "data" => ""
            ];
        }else {
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];
            $role = $data['role'];
        }
        if ($this->userExists($username)) {
            return [
                "status" => "409",
                "message" => "This Username is exist",
                "data" => ""
            ];
        }else {
            $connection = $this->db->getConnection();
            $query = "INSERT INTO users (username, email, password, role) VALUE (:username, :email, :password, :role)";
            try {
                $addUser = $connection->prepare($query);
                $addUser->execute([
                    "username"=>$username, 
                    "email"=>$email, 
                    "password"=>$password, 
                    "role"=>$role]);
                return [
                    "status" => "200",
                    "message" => "User added",
                    "data" => [
                        "username" => $username,
                        "email" => $email,
                        "password" => $password,
                        "role" => $role
                    ]
                ];

            } catch (PDOException $err) {
                return [
                "status" => $err->getCode(),
                "message" => $err->getMessage(),
                "data" => ""
                ];
            }
        }
    }

    public function userExists($username){
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM `users` WHERE username = :username";
        $check = $connection->prepare($query);
        $check->execute(["username"=>$username]);
        if ($check->rowCount() > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function getAllUsers(){
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM users";
        try {
            $stmt = $connection->query($query);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $users;
        } catch (PDOException $err) {
            return $err->getMessage();
        }
    }



}


?>