<?php
class Quote {
    // DB Stuff
    private $conn;
    private $table = 'quotes';

    // Quote Properties
    public $id;
    public $quote;
    public $category_id;
    public $category_name;
    public $author_id;
    public $author_name;
    public $created_at;

    // Constructor with DB 
    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all Quotes
    public function read() {
        // Create query
        $query = 'SELECT 
                    q.id,
                    q.quote,
                    a.author AS author_name,
                    c.category AS category_name
                FROM ' . $this->table . ' q
                LEFT JOIN authors a ON q.author_id = a.id
                LEFT JOIN categories c ON q.category_id = c.id
                ORDER BY q.created_at DESC';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        try {
            $stmt->execute();
            $quotes = [];

            // Fetch results
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $quotes[] = [
                    'id' => $row['id'],
                    'quote' => $row['quote'],
                    'author_name' => $row['author_name'],
                    'category_name' => $row['category_name']
                ];
            }

            return $quotes;
        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }

    // Get a single Quote
    public function read_single() {
        // Create query
        $query = 'SELECT 
                    q.id,
                    q.quote,
                    a.author AS author_name,
                    c.category AS category_name
                FROM ' . $this->table . ' q
                LEFT JOIN authors a ON q.author_id = a.id
                LEFT JOIN categories c ON q.category_id = c.id
                WHERE q.id = ?
                LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id, PDO::PARAM_INT);

        // Execute query
        try {
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Set properties
                $this->quote = $row['quote'];
                $this->author_name = $row['author_name'];
                $this->category_name = $row['category_name'];

                return [
                    'id' => $this->id,
                    'quote' => $this->quote,
                    'author_name' => $this->author_name,
                    'category_name' => $this->category_name
                ];
            }

            return ['message' => 'Quote not found'];
        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }
    }

    // Create Quote
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
                  SET quote = :quote, 
                      author_id = :author_id, 
                      category_id = :category_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean and sanitize data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind Data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);

        // Execute query
        try {
            if ($stmt->execute()) {
                return [
                    'message' => 'Quote created successfully',
                    'id' => $this->conn->lastInsertId(),
                    'quote' => $this->quote,
                    'author_id' => $this->author_id,
                    'category_id' => $this->category_id
                ];
            }
        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }

        return ['message' => 'Failed to create quote'];
    }

    // Update Quote
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                  SET quote = :quote, 
                      author_id = :author_id, 
                      category_id = :category_id
                  WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean and sanitize data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        // Execute query
        try {
            if ($stmt->execute()) {
                return [
                    'message' => 'Quote updated successfully',
                    'id' => $this->id,
                    'quote' => $this->quote,
                    'author_id' => $this->author_id,
                    'category_id' => $this->category_id
                ];
            }
        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }

        return ['message' => 'Failed to update quote'];
    }

    // Delete Quote
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
        try {
            if ($stmt->execute()) {
                return ['message' => 'Quote deleted successfully'];
            }
        } catch (PDOException $e) {
            return ["message" => "Database Error: " . $e->getMessage()];
        }

        return ['message' => 'Failed to delete quote'];
    }
}
?>