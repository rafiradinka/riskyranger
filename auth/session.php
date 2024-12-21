<?php
session_start();

// Fungsi untuk memeriksa apakah user sudah login
function cek_login() {
    if (!isset($_SESSION['username'])) {
        // Jika belum login, redirect ke halaman login
        header("Location: login.php");
        exit();
    }
}

function cek_level($level) {
    if (!isset($_SESSION['level']) || $_SESSION['level'] != $level) {
        // Redirect ke halaman sesuai level
        if ($_SESSION['level'] == 'Admin') {
            header("Location: dashboard.php");
        } elseif ($_SESSION['level'] == 'Fakultas') {
            // echo 'anda tidak memiliki akses';
            header("Location: no_access.php");
        } else {
            header("Location: ../login.php");
        }
        exit();
    }
}

function tampilkanLevel($level) {
    switch($level) {
        case 'Admin':
            return 'Admin';
        case 'Fakultas':
            return 'Fakultas';
        default:
            return 'Pengguna Tidak Dikenal';
    }
}
$level_tampilan = tampilkanLevel($_SESSION['level']);

function tampilkanNama($username) {
    $conn = mysqli_connect("localhost", "root", "", "riskiranger");
    
    $query = "SELECT username FROM tb_user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        return $row['username'];
    } else {
        return 'Pengguna Tidak Dikenal';
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}

$tampilkan_nama = tampilkanNama($_SESSION['username']);

// Fungsi untuk logout
function logout() {
    // Hapus semua session
    session_unset();
    session_destroy();
    
    // Redirect ke halaman login
    header("Location: ../views/login.php");
    exit();
}
?>