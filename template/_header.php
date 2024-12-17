<?php 
include("../config/config.php");
include("../helper/helper.php");
include("../auth/session.php");

cek_login();

if (isset($_GET['logout'])) {
  logout();
}

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
    <link href="<?= base_url('_assets/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('_assets/css/simple-sidebar.css')?>" rel="stylesheet">
  </head>
  <body>
    <script src="<?=base_url('_assets/js/jquery.js')?>"></script>
    <script src="<?=base_url('_assets/js/bootstrap.min.js')?>"></script>
    <div id="wrapper">
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
          <li class="sidebar-brand">
            <a href=""><span class="text-primary"><b>Risky</b></span> Ranger </a>
          </li>
          <li>
            <a href="<?=base_url('views/dashboard.php')?>">Dashboard</a>
          </li>
          <li>
            <a href="<?=base_url('views/riskReg.php')?>">Risk Register</a>
          </li>
          <li>
          <a href="<?=base_url('views/sisMit.php')?>">Analis dan Mitigasi</a>
          </li>
          <li>
            <a href="#">Risk Map</a>
          </li>
          <li>
            <a href="<?=base_url('views/manageUser.php')?>">Manage Users</a>
          </li>
          <li>
            <a href="?logout=true" class="text-danger">Logout</a>
          </li>
        </ul>
      </div>
      <!-- /#sidebar-wrapper -->

      <!-- Page Content -->
      <div id="page-content-wrapper">
        <div class="container-fluid">