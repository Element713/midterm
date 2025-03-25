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

            // Check if we have authors
            if ($stmt->rowCount() > 0) {
                $authors = [];
                
                // Fetch all authors
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $authors[] = [
                        'id' => $row['id'],
                        'name' => $row['name']
                    ];
                }
                
                return $authors;
            } else {
                return []; // No authors found
            }
        } catch (PDOException $e) {
            echo json_encode(["message" => "Database Error: " . $e->getMessage()]);
            return null;
        }
    }

    // Get a single author by ID
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

                return [
                    'id' => $this->id,
                    'name' => $this->name
                ]; // Return the author data
            }

            return ['message' => 'author_id Not Found']; // Return a message if author not found
        } catch (PDOException $e) {
            echo json_encode(["message" => "Database Error: " . $e->getMessage()]);
            return null;
        }
    }

    // Add a new author (for POST requests)
    public function create() {
        // Query to insert a new author
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Sanitize and bind parameters
            $this->name = htmlspecialchars(strip_tags($this->name));
            $stmt->bindParam(':name', $this->name);

            // Execute query
            if ($stmt->execute()) {
                return [
                    'id' => $this->conn->lastInsertId(),
                    'name' => $this->name
                ];
            }

            return ['message' => 'Failed to create author'];

        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }

    // Update an existing author (for PUT requests)
    public function update() {
        // Query to update an author
        $query = 'UPDATE ' . $this->table . ' SET name = :name WHERE id = :id';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Sanitize and bind parameters
            $this->name = htmlspecialchars(strip_tags($this->name));
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return [
                    'id' => $this->id,
                    'name' => $this->name
                ];
            }

            return ['message' => 'Failed to update author'];

        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }

    // Delete an author
    public function delete() {
        // Query to delete an author
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        try {
            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID parameter
            $stmt->bindParam(':id', $this->id);

            // Execute query
            if ($stmt->execute()) {
                return ['message' => 'Author deleted successfully'];
            }

            return ['message' => 'Failed to delete author'];

        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }
}
?>