<?php 
ob_start();
include("config/config.php");
include("helper/helper.php");

if(isset($_SESSION['username'])){
    echo "<script>window.location='".base_url("views/dashboard.php")."'</script>";
} else {
    echo "<script>window.location='".base_url("views/login.php")."'</script>";
}
?>
