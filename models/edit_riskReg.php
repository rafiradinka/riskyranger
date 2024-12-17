<?php 
ob_start();
include("../config/config.php");
include("m_riskReg.php");

$mysqli = new mysqli("localhost", "root", "", "riskiranger"); 
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$user = new RiskReg($mysqli);

// Use mysqli real_escape_string instead of connection object
if (isset($_POST['id_risk']) && !empty($_POST['id_risk'])) {
    $id_risk = $mysqli->real_escape_string($_POST['id_risk']);
} else {
    echo "ID risk tidak ditemukan.";
    exit;
}


$tujuan = $mysqli->real_escape_string($_POST['tujuan']);
$kode_risk = $mysqli->real_escape_string($_POST['kode_risk']);
$jenis_risk = $mysqli->real_escape_string($_POST['jenis_risk']);
$bisnis_risk = $mysqli->real_escape_string($_POST['bisnis_risk']);
$sumber_risk = $mysqli->real_escape_string($_POST['sumber_risk']);
$uraian_risk = $mysqli->real_escape_string($_POST['uraian_risk']);
$penyebab_risk = $mysqli->real_escape_string($_POST['penyebab_risk']);
$kualitatif_risk = $mysqli->real_escape_string($_POST['kualitatif_risk']);
$kuantitatif_risk = $mysqli->real_escape_string($_POST['kuantitatif_risk']);
$risk_owner = $mysqli->real_escape_string($_POST['risk_owner']);
$unit_terkait = $mysqli->real_escape_string($_POST['unit_terkait']);

// Validate inputs
// if (empty($tujuan) || empty($kode_risk) || empty($jenis_risk) || empty($bisnis_risk) || empty($sumber_risk) || empty($uraian_risk) || empty($penyebab_risk)) {
//     echo "Semua field harus diisi!";
//     exit;
// }

// Attempt to update user
$result = $user->edit($id_risk, $tujuan, $kode_risk, $jenis_risk, $bisnis_risk, $sumber_risk, $uraian_risk, $penyebab_risk, $kualitatif_risk, $kuantitatif_risk, $risk_owner, $unit_terkait);

ob_end_flush();