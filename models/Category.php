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
    // Create query to get a single quote by ID
    $query = 'SELECT 
                q.id,
                q.quote,
                a.author AS author_name,
                c.category AS category_name
              FROM ' . $this->table . ' q
              LEFT JOIN authors a ON q.author_id = a.id
              LEFT JOIN categories c ON q.category_id = c.id
              WHERE q.id = :id LIMIT 1';

    // Prepare the statement
    $stmt = $this->conn->prepare($query);

    // Bind the ID parameter
    $stmt->bindParam(':id', $this->id);

    // Execute the query
    $stmt->execute();

    // Check if any record is found
    if ($stmt->rowCount() > 0) {
        // Fetch the result
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set the class properties
        $this->id = $row['id'];
        $this->quote = $row['quote'];
        $this->author_name = $row['author_name'];
        $this->category_name = $row['category_name'];

        return true; // Quote found
    } else {
        return false; // Quote not found
    }
}
}?>