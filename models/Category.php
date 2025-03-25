<?php
class Category {
    // DB stuff
    private $conn;
    private $table = 'categories'; 

    // Properties
    public $id;
    public $catagory;

    // Constructor with DB 
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all categories
    public function read() {
        // Create query to fetch all categories
        $query = 'SELECT id, name FROM ' . $this->table . ' ORDER BY id DESC';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Execute query
            $stmt->execute();

            // Check if categories are found
            if ($stmt->rowCount() > 0) {
                $categories = [];

                // Fetch all categories
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $categories[] = [
                        'id' => $row['id'],
                        'catagory' => $row['catagory']
                    ];
                }

                return $categories;
            } else {
                return []; // No categories found
            }
        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }

    // Get single category by ID
    public function read_single() {
        // Query to fetch a single category
        $query = 'SELECT id, name FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID parameter
            $stmt->bindParam(':id', $this->id);

            // Execute query
            $stmt->execute();

            // Check if category is found
            if ($stmt->rowCount() > 0) {
                // Get the result
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // Set properties
                $this->id = $row['id'];
                $this->catagory = $row['catagory'];

                return [
                    'id' => $this->id,
                    'catagory' => $this->catagory
                ];
            }

            return ['message' => 'category_id Not Found']; // Return message if category not found
        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }

    // Create a new category (POST request)
    public function create() {
        // Query to insert a new category
        $query = 'INSERT INTO ' . $this->table . ' SET catagory = :catagory';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Sanitize and bind the name parameter
            $this->catagory = htmlspecialchars(strip_tags($this->catagory));
            $stmt->bindParam(':catagory', $this->catagory);

            // Execute query
            if ($stmt->execute()) {
                return [
                    'id' => $this->conn->lastInsertId(),
                    'catagory' => $this->catagory
                ];
            }

            return ['message' => 'Failed to create category'];

        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }

    // Update a category (PUT request)
    public function update() {
        // Query to update a category
        $query = 'UPDATE ' . $this->table . ' SET catagory = :catagory WHERE id = :id';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Sanitize and bind parameters
            $this->catagory = htmlspecialchars(strip_tags($this->catagory));
            $stmt->bindParam(':catagory', $this->catagory);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return [
                    'id' => $this->id,
                    'catagory' => $this->catagory
                ];
            }

            return ['message' => 'Failed to update category'];

        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }

    // Delete a category (DELETE request)
    public function delete() {
        // Query to delete a category
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID parameter
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return ['message' => 'Category deleted successfully'];
            }

            return ['message' => 'Failed to delete category'];

        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }
}
?>