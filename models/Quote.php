<?php
class Quote {
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all quotes or filtered by parameters
    public function read($params = []) {
        $query = "SELECT * FROM " . $this->table;
        
        $conditions = [];
        if (isset($params['id'])) {
            $conditions[] = "id = :id";
        }
        if (isset($params['author_id'])) {
            $conditions[] = "author_id = :author_id";
        }
        if (isset($params['category_id'])) {
            $conditions[] = "category_id = :category_id";
        }
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->conn->prepare($query);

        if (isset($params['id'])) {
            $stmt->bindParam(':id', $params['id']);
        }
        if (isset($params['author_id'])) {
            $stmt->bindParam(':author_id', $params['author_id']);
        }
        if (isset($params['category_id'])) {
            $stmt->bindParam(':category_id', $params['category_id']);
        }

        $stmt->execute();
        return $stmt;
    }

    // Create a quote
    public function create() {
        $query = "INSERT INTO " . $this->table . " (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Update a quote
    public function update() {
        $query = "UPDATE " . $this->table . " SET quote = :quote, author_id = :author_id, category_id = :category_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a quote
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
