<?php
header('Access-Control-Allow-Origin: *'); // Memperbolehkan permintaan dari semua domain/origin, bisa diganti dengan domain tertentu jika diperlukan
header('Content-Type: application/json');
require_once ('../index.php');

class PromptController
{
  private $host = 'localhost';
  private $username = 'lluuvvii';
  private $password = 'console.log(\'kuonji64\')';
  private $database = 'share_prompt';
  private $conn;
  public function getPrompt()
  {
    $database = new Database();
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
    // $sql = 'SELECT * FROM prompts';
    $sql = "SELECT prompts.*, users.* FROM prompts LEFT JOIN users ON prompts.user_id = users.user_id";
    // $result = mysqli_query($this->conn, $sql);
    $result = $this->conn->query($sql);
    // $prompts = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $prompts = array();

    // Jika query berhasil dieksekusi
    if ($result) {
      // Ambil setiap baris hasil query
      while ($row = $result->fetch_assoc()) {
        // Lakukan apa pun yang diperlukan dengan setiap baris
        // Misalnya, tambahkan ke dalam array $prompts
        $prompts[] = $row;
      }

      // Bebaskan hasil query
      $result->free();
    } else {
      echo "Query gagal dieksekusi: " . $this->conn->error;
    }

    echo json_encode($prompts);

    $database->closeConnection();
  }
}

$controller = new PromptController();
$controller->getPrompt();