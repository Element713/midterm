<?php
class Quote{
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
    

	// Constructor with DB 
	public function __construct($db) {
		$this->conn = $db;
	}

    // Get Quotes
    public function read() {
        // Create query
        $query = 'SELECT 
            q.id,
            q.quote,
            q.category_id,
            a.author AS author_name,
            c.category AS category_name
          FROM ' . $this->table . ' q
          LEFT JOIN authors a ON q.author_id = a.id
          LEFT JOIN categories c ON q.category_id = c.id
          ORDER BY q.id DESC';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }


    // Get Single Quote
    public function read_single() {

    $query = 'SELECT 
                 q.id,
                 q.quote,
                 a.author AS author_name, 
                 c.category AS category_name
              FROM ' . $this->table . ' q
              LEFT JOIN authors a ON q.author_id = a.id
              LEFT JOIN categories c ON q.category_id = c.id
              WHERE q.id = ? 
              LIMIT 1';

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
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
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
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
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
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}

?>