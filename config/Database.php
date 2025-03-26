<?php
class Database {    
    private $conn;
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;

    public function __construct(){
        $this->host = getenv('HOST');
        $this->port = 5432;
        $this->dbname = getenv('DBNAME');
        $this->username = getenv('USERNAME');
        $this->password = getenv('PASSWORD');
    }

    public function connect() {
		if ($this->conn){
            return $this->conn;
        } else {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname}";

            try {
                $this->conn = new PDO($dsn, $this->username, $this->password, $options);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Database connection failed', 'message' => $e->getMessage()]);
                exit;
            }
            return $this->conn;
        }
    }   
}
