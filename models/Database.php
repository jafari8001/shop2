<?php
include "./config.php";
class Database{
    private $dns;
    private $db_user;
    private $db_password;
    private $connection;
    private static $instance;

    public function __construct($db_name) {
        $this->dns = DNS;
        $this->db_user = DB_USER;
        $this->db_password = DB_PASS;
        try {
            $this->connection = new PDO($this->dns, $this->db_user, $this->db_password);
            $this->connection->exec("CREATE DATABASE IF NOT EXISTS $db_name");
            $this->connection->exec("USE $db_name");
        } catch (PDOException $err) {
            die("Database connection error: " . $err->getMessage());
        }
        
    }

    // for connect to database
    public static function getInstance($db_name){
        if (self::$instance === null) {
            self::$instance = new self($db_name);
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    // public function insertDB($data){
    //     $keys = array_keys($data);
    //     $values = array_values($data);
    // }

    // create default tabels 
    public function create_table(){
        try {
            $this->connection->exec("CREATE TABLE IF NOT EXISTS `users`(
                `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
                `username` VARCHAR(255) NOT NULL,
                `name` VARCHAR(255) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `password` VARCHAR(255) NOT NULL,
                `role` VARCHAR(255) NOT NULL
            )");
                
            $this->connection->exec("CREATE TABLE IF NOT EXISTS `products` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(255) NOT NULL,
                `price` DECIMAL(10, 2) NOT NULL,
                `views` INT DEFAULT 0,
                `sales` INT DEFAULT 0,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `deleted_at` TIMESTAMP NULL
            )");
            
            $this->connection->exec("CREATE TABLE IF NOT EXISTS `orders` (
                `id` INT AUTO_INCREMENT PRIMARY KEY,
                `user_id` INT NOT NULL,
                `product_ids` TEXT NOT NULL,
                `total_price` DECIMAL(10, 2) NOT NULL,
                `address` VARCHAR(255) NOT NULL,
                `postal_code` VARCHAR(10) NOT NULL,
                `city` VARCHAR(100) NOT NULL,
                `state` VARCHAR(100) NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `deleted_at` TIMESTAMP NULL,
                FOREIGN KEY (user_id) REFERENCES users(id)
            )");
            return [
                "status"=>"200",
                "message"=>"tables created",
                "data"=>""
            ];
        } catch (PDOException $err) {
            return [
                "status"=>"500",
                "message"=>$err->getMessage(),
                "data"=>""
            ];
        }
    }
}

?>