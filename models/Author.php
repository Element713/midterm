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
        $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            echo json_encode($row);
        } else {
            echo json_encode(["message" => "category_id Not Found"]);
        }
        exit(); // Stop further output to ensure JSON validity
    }
    }?>