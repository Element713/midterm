<?php
class Author {
    private $conn;
    private $table = 'authors'; 

    public $id;
    public $author;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get 
    public function read() {
        $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY id ASC';

            $stmt = $this->conn->prepare($query);
            $stmt->execute();

            return $stmt;
    }

    // Get single  (by ID)
    public function read_single() {
        $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = :id LIMIT 1';

            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':id', $this->id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
               
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $this->id = $row['id'];
                $this->author = $row['author'];

                return true;
            }
            return false; 
    }

    // Create 
    public function create() {
       $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author) RETURNING id';

       $stmt = $this->conn->prepare($query);
   
       $this->author = htmlspecialchars(strip_tags($this->author));
   
       $stmt->bindParam(':author', $this->author, PDO::PARAM_STR);

       if ($stmt->execute()) {
           $row = $stmt->fetch(PDO::FETCH_ASSOC);
           $this->id = $row['id']; 
           return true;
       }
       return false;
   }
    // Update 
    public function update() {
        $query = 'UPDATE ' . $this->table . '
                  SET author = :author WHERE id = :id';

        $stmt = $this->conn->prepare($query);
    
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
    
        $stmt->bindParam(':author', $this->author, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
    
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