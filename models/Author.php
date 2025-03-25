<?php
class Author {
    // DB connection
    private $conn;
    private $table = 'authors'; 

    // Properties
    public $id;
    public $name;

    // Constructor
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all authors
    public function read() {
        // Query to fetch authors
        $query = 'SELECT id, name FROM ' . $this->table . ' ORDER BY id ASC';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            return $stmt;
        } catch (PDOException $e) {
            echo json_encode(["message" => "Database Error: " . $e->getMessage()]);
            return null;
        }
    }

    // Get single author by ID
    public function read_single() {
        // Query to fetch single author
        $query = 'SELECT id, name FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind the ID parameter
            $stmt->bindParam(':id', $this->id);

            // Execute query
            $stmt->execute();

            // Check if any author exists
            if ($stmt->rowCount() > 0) {
                // Get the result
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Set properties
                $this->id = $row['id'];
                $this->name = $row['name'];

                return true;
            }

            return false; // No author found
        } catch (PDOException $e) {
            echo json_encode(["message" => "Database Error: " . $e->getMessage()]);
            return false;
        }
    }
}
?>