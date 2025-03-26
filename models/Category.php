<?php
class Category {
    // DB stuff
    private $conn;
    private $table = 'categories'; 

    // Properties
    public $id;
    public $category;

    // Constructor with DB 
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all categories
    public function read() {
        // Create query
        $query = 'SELECT id, category FROM ' . $this->table . ' ORDER BY id ASC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get a single category by ID
    public function read_single() {
        // Create query
        $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind the ID parameter
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        // Execute query
        $stmt->execute();

        // Fetch result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // Assign values to object properties
            $this->id = $row['id'];
            $this->category = $row['category'];
        } else {
            // Set category to null if not found
            $this->category = null;
        }
    }
}?>