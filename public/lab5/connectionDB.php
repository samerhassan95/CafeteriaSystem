<?php

class Database
{
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $conn;

    public function __construct($host, $dbname, $user, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->user = $user;
        $this->password = $password;
    }

    public function connect()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname}";
        $this->conn = new PDO($dsn, $this->user, $this->password);
        return $this->conn;
    }

    public function insert($table_name, $columns, $values)
    {
        function myfunction($v)
        {
            return ":" . $v;
        }

        $preparedColumns = array_map("myfunction", $columns);
        $columnsStr = implode(",", $columns);
        $preparedColumnsStr = implode(",", $preparedColumns);

        $query = "INSERT INTO {$table_name} ({$columnsStr}) VALUES ({$preparedColumnsStr})";
        $stmt = $this->conn->prepare($query);
        for ($i = 0; $i < count($columns); $i++) {
            $stmt->bindParam($columns[$i], $values[$i]);
        }
        $stmt->execute();
        return 1;
    }

    public function select($table_name)
    {
        $query = "SELECT * FROM {$table_name}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }

    public function selectUser($table_name,$field,$value)
    {
        $query = "SELECT * FROM {$table_name} where {$field} = '{$value}'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    public function update($table_name, $columns, $values,$field,$value)
    {
        function myfunction($v)
        {
            return $v."=:".$v;
        }

        $columnsMapped = array_map("myfunction",$columns);
        $columnsStr = implode(",",$columnsMapped);

        $query = "UPDATE {$table_name} set {$columnsStr} where {$field} = {$value}";
        var_dump($query);

        $stmt = $this->conn->prepare($query);
        for ($i = 0; $i < count($columns); $i++) {
            echo $columns[$i]." ".$values[$i]."<br>";
            $stmt->bindParam($columns[$i], $values[$i]);
        }
        $stmt->execute();
        return 1;
    }

    public function delete($table_name, $record_id)
    {
        $query = "DELETE FROM $table_name WHERE id={$record_id}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return 1;
    }
}

//function connect_to_db()
//{
//    $dsn = "mysql:host={localhost};dbname=phplabs";
//
//    try {
//        $conn = new PDO($dsn, DB_USER, DB_PASSWORD);
//        return $conn;
//    } catch (PDOException $e) {
//        echo 'Connection failed: ' . $e->getMessage();
//    }
//}