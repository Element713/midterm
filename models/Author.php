<?php
class Author {
    // DB connection
    private $conn;
    private $table = 'authors'; 

    // Properties
    public $id;
    public $author;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all authors
    public function read() {
        // Query to fetch authors
        $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY id ASC';

            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
    }

    // Get single author by ID
    public function read_single() {
        // Query to fetch single author
        $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Bind the ID parameter
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
        // Execute query
        $stmt->execute();
    
        // Fetch result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            // Set properties
            $this->id = $row['id'];
            $this->author = $row['author'];
            return true;
        } else {
            // Return message when the author is not found
            echo json_encode(["message" => "Author Not Found"]);
            exit();
        }
    }
}
?>