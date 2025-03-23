<?php

class Database {
    private $conn;


    //db c onnect
    public function connect() {
        $host = getenv('HOST');
        $port = getenv('PORT');
        $db_name = getenv('DBNAME');
        $username = getenv('USERNAME');
        $password = getenv('PASSWORD');

        $this->conn = null;

                $dsn = "pgsql:host={$this->host}; port={$this->port};dbname={$this->db_name}";
         
        try {
                 $this->conn = new PDO($dsn, $this->username, $this->password);
                 
                 $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDEOxception $e){
            echo 'connection error' . $e->getMessage();
        }
        return $this->conn;
    }
}
echo "Database connection established successfully.";