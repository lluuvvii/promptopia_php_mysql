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
    $data = json_decode(file_get_contents("php://input"), true);
    $prompt = $data['prompt'];
    $tag = $data['tag'];
    $prompt_id = $_GET["prompt_id"];

    $sql = "UPDATE prompts SET prompt=?, tag=? WHERE prompt_id=?";
    $stmt = $this->conn->prepare($sql);
    $stmt->bind_param("ssi", $prompt, $tag, $prompt_id);

    if ($stmt->execute()) {
      $stmt->close();
      echo json_encode(array("message" => "Data prompt berhasil diperbarui"));
    } else {
      echo json_encode(array("message" => "Error: " . $sql . "<br>" . $this->conn->error));
    }

    $database->closeConnection();
  }
}

$controller = new UserController();
if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
$controller->getUser();
}