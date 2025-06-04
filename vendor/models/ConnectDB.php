<?php 
class ConnectDB {  
    private static $instance = null;
    private $conn;
    
    private function __construct()
    {
        $this->conn = null;
        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if ($this->conn->connect_error) {
            throw new Exception("Connection DB error!");
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new ConnectDB();
        }

        return self::$instance;
    }

    public function getConnection() {
        return $this->conn;
    }
}