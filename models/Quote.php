<?php
class Quote{
	// DB Stuff
	private $conn;
	private $table = 'quotes';

// Props
	public $id;
	public $quote;
    public $category_id;
	public $category_name;
    public $author_id;
	public $author_name;
    

	//constructor
	public function __construct($db) {
		$this->conn = $db;
	}

    // Get 
    public function read() {
        $query = 'SELECT  q.id,q.quote, q.category_id, a.author AS author_name, c.category AS category_name FROM ' . $this->table . ' q LEFT JOIN authors a ON q.author_id = a.id LEFT JOIN categories c ON q.category_id = c.id ORDER BY q.id DESC';
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }


    // singe 
    public function read_single() {

    $query = 'SELECT  q.id,  q.quote,  a.author AS author_name,   c.category AS category_name FROM ' . $this->table . ' q LEFT JOIN authors a ON q.author_id = a.id LEFT JOIN categories c ON q.category_id = c.id WHERE q.id = ? LIMIT 1';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id, PDO::PARAM_INT);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($row) {
        $this->quote = $row['quote'];
        $this->author_name = $row['author_name'];
        $this->category_name = $row['category_name'];
        return true;
    } else {
        return false;
    }
}

    // Create 
    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)';
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId(); 
            return true;
        }
        return false;
    }

    // Update 
    public function update() {
            // Create, prepare,bind,clean data
        $query = 'UPDATE ' . $this->table . '
                  SET quote = :quote,  author_id = :author_id, category_id = :category_id  WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id, PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $this->category_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;  }  return false; }

    // Delete 
    public function delete() {
        // Create, prepare,bind,clean data
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);

        $stmt->execute();

        // Check row count
        if ($stmt->rowCount() > 0) {
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