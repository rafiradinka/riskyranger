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
            echo 'anda tidak memiliki akses';
            // header("Location: dashboard.php");
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