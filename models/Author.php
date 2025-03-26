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
            $stmt->bindParam(':id', $this->id);

            // Execute query
            $stmt->execute();

            // Check if any author exists
            if ($stmt->rowCount() > 0) {
                // Get the result
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Set properties
                $this->id = $row['id'];
                $this->author = $row['author'];

                return true;
            }
            return false; // No author found
    }

    // Create Author
    public function create() {
        // Create author
        $query = 'INSERT INTO ' . $this->table . ' SET author = :author';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean and sanitize data
        $this->author = htmlspecialchars(strip_tags($this->author));

        // Bind Data
        $stmt->bindParam(':author', $this->author, PDO::PARAM_STR);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // Update Author
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                  SET author = :author
                  WHERE id = :id';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean and sanitize data
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Bind Data
        $stmt->bindParam(':author', $this->author, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete Author
    public function delete() {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Bind data
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>