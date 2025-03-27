<?php
class Category {
    // DB stuff
    private $conn;
    private $table = 'categories'; 

    // Properties
    public $id;
    public $category;

    // Constructor 
	public function __construct($db) {
		$this->conn = $db;
	}

    // Get 
    public function read(){
        $query = 'SELECT id, category  FROM ' . $this->table . ' ORDER BY  id ASC ';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    // Get category single (by ID)
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
   // create
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category) RETURNING id';
            
        $stmt = $this->conn->prepare($query);
            
        $this->category = htmlspecialchars(strip_tags($this->category));    
            
   
        $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);
            
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id']; 
            return true;
            }
            return false;
        }

    // Update Category
    public function update() {
        // Create query
        $query = 'UPDATE ' . $this->table . '
                  SET category = :category  WHERE id = :id';
    
        // Prepare statement
        $stmt = $this->conn->prepare($query);
    
        // Clean
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        $stmt->bindParam(':category', $this->category, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
       //make it happen 
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete 
    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
    
        $stmt = $this->conn->prepare($query);
    
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function findById() {
        $query = 'SELECT id FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
?>