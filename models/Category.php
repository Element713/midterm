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

    // Get categories
    public function read(){
        // Create query
        $query = 'SELECT
            id, 
            category
        FROM
        ' . $this->table . '
        ORDER BY
            id ASC ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get single category by ID
    public function read_single() {
        $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->category = $row['category'];
            return true;
        }
        return false;
    }

    // Create Category
    public function create() {
        // Create category
        $query = 'INSERT INTO ' . $this->table . ' SET category = :category';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean and sanitize data
        $this->category = htmlspecialchars(strip_tags($this->category));

        // Bind Data
        $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // Update Category
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                  SET category = :category
                  WHERE id = :id';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean and sanitize data
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        // Bind Data
        $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
        // Execute query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete category
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