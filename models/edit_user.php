<?php 
ob_start();
include("../config/config.php");
include("m_manageUser.php");

$mysqli = new mysqli("localhost", "root", "", "riskiranger"); 
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$user = new ManUser($mysqli);


if (isset($_POST['id_user']) && !empty($_POST['id_user'])) {
    $id_user = $mysqli->real_escape_string($_POST['id_user']);
} else {
    echo "ID pengguna tidak ditemukan.";
    exit;
}

$username = $mysqli->real_escape_string($_POST['username']);
$level = $mysqli->real_escape_string($_POST['level']);
$unit_terkait = $mysqli->real_escape_string($_POST['unit_terkait']);

$result = $user->edit($id_user, $username, $level, $unit_terkait);

ob_end_flush();