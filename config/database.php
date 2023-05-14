<?php

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost:3906');
}
if (!defined('DB_USER')) {
    define("DB_USER", "root");
}
if (!defined('DB_PASS')) {
    define("DB_PASS", "");
}
if (!defined('DB_DATABASE')) {
    define("DB_DATABASE", "php_cafe");
}
return new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DATABASE, DB_USER, DB_PASS);


// <?php
// // config/database.php

// class Database {
//   private $host = 'localhost';
//   private $username = 'root';
//   private $password = '';
//   private $dbname = 'php_cafe';
  
//   private $conn;

//   private static $instance;

//   public static function getInstance() {
//     if (!self::$instance) {
//       self::$instance = new self();
//     }
//     return self::$instance;
//   }

//   public function getConnection() {
//     if (!$this->conn) {
//       try {
//         $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->dbname, $this->username, $this->password);
//         $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//       } catch(PDOException $e) {
//         echo 'Connection Error: ' . $e->getMessage();
//       }
//     }
//     return $this->conn;
//   }

//   public function execute($sql, $params = null) {
//     $stmt = $this->conn->prepare($sql);
//     $stmt->execute($params);
//     return $stmt;
//   }
// }
// 
