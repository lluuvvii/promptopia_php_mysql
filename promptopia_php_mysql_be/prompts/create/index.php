<?php
header('Access-Control-Allow-Origin: *'); // Memperbolehkan permintaan dari semua domain/origin, bisa diganti dengan domain tertentu jika diperlukan
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
require_once ('../../index.php');

class UserController
{
  private $host = 'localhost';
  private $username = 'lluuvvii';
  private $password = 'console.log(\'kuonji64\')';
  private $database = 'share_prompt';
  private $conn;
  // public function getUser()
  // {
  //     $database = new Database();
  //     $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
  //     $sql = 'SELECT * FROM users';
  //     $result = mysqli_query($this->conn, $sql);
  //     $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

  //     echo json_encode($users);

  //     $database->closeConnection();
  // }

  public function createUser()
  {
    $database = new Database();
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
    $data = json_decode(file_get_contents("php://input"), true);
    // Ambil data POST
    $prompt = $data['prompt'];
    $tag = $data['tag'];
    $user_id = $data['userId'];

    // Lakukan validasi data jika diperlukan

    // Masukkan data ke database
    $sql = "INSERT INTO prompts (prompt, tag, user_id) VALUES ('$prompt', '$tag', '$user_id')";
    if ($this->conn->query($sql) === TRUE) {
      echo json_encode($data);
    } else {
      echo "Error: " . $sql . "<br>" . $this->conn->error;
    }

    $database->closeConnection();
  }
}

$controller = new UserController();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $controller->createUser();
}