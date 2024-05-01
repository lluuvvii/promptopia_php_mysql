<?php
class Database
{
    private $host = 'localhost';
    private $username = 'lluuvvii';
    private $password = 'console.log(\'kuonji64\')';
    private $database = 'share_prompt';
    private $conn;

    // Constructor untuk membuat koneksi saat objek dibuat
    public function __construct()
    {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            if ($this->conn->connect_error) {
                throw new Exception("Koneksi gagal: " . $this->conn->connect_error);
            }
            // echo "Koneksi berhasil";
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    // Metode untuk menutup koneksi
    public function closeConnection()
    {
        $this->conn->close();
        // echo "Koneksi ditutup";
    }

    // Metode lainnya untuk eksekusi query, dll bisa ditambahkan sesuai kebutuhan
}
