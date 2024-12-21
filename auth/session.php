<?php
include('../config/config.php');

class SessionManager {
    private $conn;
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function getUserData($username) {
        $query = "SELECT level, unit_terkait FROM tb_user WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return null;
        }

        $stmt->bind_param('s', $username);
        if (!$stmt->execute()) {
            $stmt->close();
            return null;
        }

        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row;
        }
        
        $stmt->close();
        return null;
    }

    public function cekLogin() {
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit();
        }
        
        // Fetch and set user data if not already set
        if (!isset($_SESSION['level']) || !isset($_SESSION['unit_terkait'])) {
            $userData = $this->getUserData($_SESSION['username']);
            if ($userData) {
                $_SESSION['level'] = $userData['level'];
                $_SESSION['unit_terkait'] = $userData['unit_terkait'];
            }
        }
    }

    public function cekLevel($requiredLevel) {
        if (!isset($_SESSION['level']) || $_SESSION['level'] != $requiredLevel) {
            switch ($_SESSION['level']) {
                case 'Admin':
                    header("Location: dashboard.php");
                    break;
                case 'Fakultas':
                    header("Location: no_access.php");
                    break;
                default:
                    header("Location: ../login.php");
            }
            exit();
        }
    }

    public function tampilkanLevel($level) {
        $query = "SELECT level FROM tb_user WHERE level = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return 'Error: ' . $this->conn->error;
        }

        $stmt->bind_param('s', $level);
        if (!$stmt->execute()) {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }

        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return htmlspecialchars($row['level']);
        }
        
        $stmt->close();
        return 'Level Tidak Ditemukan';
    }

    public function tampilkanUnit($unit_terkait) {
        $query = "SELECT unit_terkait FROM tb_user WHERE unit_terkait = ?";
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            return 'Error: ' . $this->conn->error;
        }

        $stmt->bind_param('s', $unit_terkait);
        if (!$stmt->execute()) {
            $error = 'Error: ' . $stmt->error;
            $stmt->close();
            return $error;
        }

        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return htmlspecialchars($row['unit_terkait']);
        }
        
        $stmt->close();
        return 'Unit Tidak Ditemukan';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ../views/login.php");
        exit();
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>