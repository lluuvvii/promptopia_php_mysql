<?php
header('Access-Control-Allow-Origin: *'); // Memperbolehkan permintaan dari semua domain/origin, bisa diganti dengan domain tertentu jika diperlukan
header('Content-Type: application/json');
require_once ('../../index.php');

class UserController
{
  private $host = 'localhost';
  private $username = 'lluuvvii';
  private $password = 'console.log(\'kuonji64\')';
  private $database = 'share_prompt';
  private $conn;
  public function getUser()
  {
    // $data = json_decode(file_get_contents("php://input"), true);
    // Ambil data POST
    // if (isset($_GET['id'])) {
    //   echo "MY ID: " . $_GET["id"];
    // }
    $user_id = $_GET["user_id"];
    $database = new Database();
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
    // $sql = 'SELECT * FROM prompts WHERE user_id = ?';
    $sql = "SELECT prompts.*, users.* FROM prompts INNER JOIN users ON prompts.user_id = users.user_id WHERE prompts.user_id = ?";
    // $sql = "SELECT prompts.*, users.* FROM prompts LEFT JOIN users ON prompts.user_id = users.user_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $user_id); // "i" untuk tipe data integer
    $stmt->execute();
    $result = $stmt->get_result();
    // $user = $result->fetch_assoc();

    // $result = mysqli_query($this->conn, $sql);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    echo json_encode($users);

    $database->closeConnection();
  }
}

$controller = new UserController();
$controller->getUser();
