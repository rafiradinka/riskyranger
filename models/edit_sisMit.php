<?php 
ob_start();
include("../config/config.php");
include("m_sisMit.php");

$mysqli = new mysqli("localhost", "root", "", "riskiranger"); 
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$user = new SisMit($mysqli);

// Use mysqli real_escape_string instead of connection object
if (isset($_POST['id_risk']) && !empty($_POST['id_risk'])) {
    $id_risk = $mysqli->real_escape_string($_POST['id_risk']);
} else {
    echo "ID risk tidak ditemukan.";
    exit;
}

$hood_inh = $mysqli->real_escape_string($_POST['hood_inh']);
$imp_inh = $mysqli->real_escape_string($_POST['imp_inh']);
$risk_inh = $hood_inh * $imp_inh;

$control = $mysqli->real_escape_string($_POST['control']);
$memadai = $mysqli->real_escape_string($_POST['memadai']);
$dijalankan = $mysqli->real_escape_string($_POST['dijalankan']);

$hood_res = $mysqli->real_escape_string($_POST['hood_res']);
$imp_res = $mysqli->real_escape_string($_POST['imp_res']);
$risk_res = $hood_res * $imp_res;

$perlakuan = $mysqli->real_escape_string($_POST['perlakuan']);
$mitigasi = $mysqli->real_escape_string($_POST['mitigasi']);

$hood_mit = $mysqli->real_escape_string($_POST['hood_mit']);
$imp_mit = $mysqli->real_escape_string($_POST['imp_mit']);
$risk_mit = $hood_mit * $imp_mit;

// Attempt to update user
$result = $user->edit($id_risk, $hood_inh, $imp_inh, $risk_inh, $control, $memadai, $dijalankan, $hood_res, $imp_res, $risk_res, $perlakuan, $mitigasi, $hood_mit, $imp_mit, $risk_mit);

if ($result) {
    echo "Update berhasil";
} else {
    echo "Update gagal";
}

ob_end_flush();