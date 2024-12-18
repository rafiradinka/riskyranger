<?php
require_once '../config/config.php';

class UserQuery {
    private $db;

    // Konstruktor untuk inisialisasi database
    public function __construct() {
        $dtb = $this->db = new Database();
        return $dtb;
    }

    // Metode untuk login dengan MD5
    public function login($username, $password) {
        $hashed_password = md5($password);

        // Menghindari SQL Injection
        $stmt = $this->db->conn->prepare("SELECT username, level FROM tb_user WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $hashed_password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Memeriksa login
        if ($result->num_rows == 1) {
            // Login berhasil
            $user = $result->fetch_assoc();
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['level'] = $user['level'];
            if ($user['level'] == 'Admin') {
                header("Location: dashboard.php");
                exit();
            } elseif ($user['level'] == 'Fakultas') {
                header("Location: dashboard.php");
                exit();
            }
            return true;
        } else {
            // Login gagal
            return false;
        }
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>