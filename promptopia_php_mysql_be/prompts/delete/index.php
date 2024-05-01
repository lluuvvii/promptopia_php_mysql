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
  public function getUser()
  {
    $database = new Database();
    $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
    $prompt_id = $_GET["prompt_id"];
    $sql = "DELETE FROM prompts WHERE prompts.prompt_id=?";
;
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("i", $prompt_id); // "i" untuk tipe data integer
    $stmt->execute();
    $result = $stmt->get_result();

    $database->closeConnection();

    if ($stmt->execute()) {
      $stmt->close();
      echo json_encode(array("message" => "Data prompt berhasil dihapus"));
    } else {
      echo json_encode(array("message" => "Error: " . $sql . "<br>" . $this->conn->error));
    }

    // $result = mysqli_query($this->conn, $sql);
    // $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // echo json_encode($users);
    // echo json_encode($prompt);
    // echo json_encode($tag);
    // echo json_encode($prompt_id);

    // $database->closeConnection();
  }
}

$controller = new UserController();
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
$controller->getUser();
}