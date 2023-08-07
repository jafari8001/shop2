<?php
class Database{
    private $dns;
    private $db_user;
    private $db_pass;
    private $connection;
    private static $instance;

    public function __construct($db_name) {
    
        $this->dns = DNS;
        $this->db_user = DB_USER;
        $this->db_pass = DB_PASS;
        try {
            $this->connection = new PDO($this->dns, $this->db_user, $this->db_pass);
            $this->connection->exec("CREATE DATABASE IF NOT EXISTS $db_name");
            $this->connection->exec("USE $db_name");

            $this->connection->exec("CREATE TABLE IF NOT EXISTS users (
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL
            )");
                
            $this->connection->exec("CREATE TABLE IF NOT EXISTS products (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                price DECIMAL(10, 2) NOT NULL,
                views INT DEFAULT 0,
                sales INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL
            )");
            
            $this->connection->exec("CREATE TABLE IF NOT EXISTS carts (
                id INT PRIMARY KEY AUTO_INCREMENT,
                user_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP  NULL ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP  NULL,
                FOREIGN KEY (user_id) REFERENCES users(id),
                FOREIGN KEY (product_id) REFERENCES products(id)
            )");
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
}

?>