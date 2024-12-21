<?php 
include("../auth/session.php");

$sessionManager = new SessionManager();
$sessionManager->cekLogin();

if (isset($_GET['logout'])) {
    $sessionManager->logout();
}

$username = $_SESSION['username'];
$userData = $sessionManager->getUserData($username);
$unit_terkait = isset($userData['unit_terkait']) ? $userData['unit_terkait'] : 'Unit tidak ditemukan';
$level = isset($userData['level']) ? $userData['level'] : 'Level tidak ditemukan';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>Manajemen Resiko</title>
    <link href="../_assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../_assets/css/simple-sidebar.css" rel="stylesheet">
    <link href="../_assets/css/risk-matrix.css" rel="stylesheet">
    <link href="../_assets/css/profile.css" rel="stylesheet">


    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
</head>
<body>
<script src="../_assets/js/jquery.js"></script>
<script src="../_assets/js/bootstrap.min.js"></script>
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href=""><img src="../_assets/img/logo-rr-white.png" alt="" width="20" class="logo-white">Risky Ranger</a>
            </li>
            <li>
                <a href="../views/dashboard.php">Dashboard</a>
            </li>
            <li>
                <a href="../views/riskReg.php">Risk Register</a>
            </li>
            <li>
                <a href="../views/sisMit.php">Analis dan Mitigasi</a>
            </li>
            <li>
                <a href="../views/riskMap.php">Risk Map</a>
            </li>
            <li>
                <a href="../views/manageUser.php">Manage Users</a>
            </li>
            <li>
                <a href="?logout=true" class="text-danger">Logout</a>
            </li>
        </ul>
    </div>
      <!-- /#sidebar-wrapper -->


    <!-- Profile Picture -->
    <div class="hero">
        <nav>

            <img src="../_assets/img/profile.jpeg" rel="logo" class="user-pic" id="profile" onclick="toggleMenu()">
            
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="../_assets/img/profile.jpeg">
                        <h3><?= htmlspecialchars($unit_terkait); ?></h3>
                    </div>
                    <hr>
                    <p>Level: <?= htmlspecialchars($level); ?></p>
                </div>
            </div>
        </nav>
    </div>

    <!-- Javascript -->
    <script src="../_assets/js/profile.js"></script>
    

      <!-- Page Content -->
       <!--  -->