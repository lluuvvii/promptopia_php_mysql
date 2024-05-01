<?php
header('Access-Control-Allow-Origin: *'); // Memperbolehkan permintaan dari semua domain/origin, bisa diganti dengan domain tertentu jika diperlukan
header('Content-Type: application/json');
require_once ('../index.php');

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
        $sql = 'SELECT * FROM users';
        $result = mysqli_query($this->conn, $sql);
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

        echo json_encode($users);

        $database->closeConnection();
    }
}

$controller = new UserController();
$controller->getUser();