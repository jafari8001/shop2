<?php
include "./models/Database.php";
class User{
    private $db;
    public function __construct() {
        $this->db = Database::getInstance("shop") ;
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