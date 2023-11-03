<?php
class Post {
    private $conn;
    private $table_name = "posts";

    public $id;
    public $title;
    public $content;
    public $image_path;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT * FROM $this->table_name";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = "INSERT INTO $this->table_name (title, content, image_path) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->title, $this->content, $this->image_path]);
    }

    public function update() {
        $query = "UPDATE $this->table_name SET title = ?, content = ?, image_path = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->title, $this->content, $this->image_path, $this->id]);
    }

    public function delete() {
        $query = "DELETE FROM $this->table_name WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->id]);
    }

    public function readOne() {
        $query = "SELECT * FROM $this->table_name WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$this->id]);
        return $stmt;
    }
    
}
?>
