<?php 
include("../template/_header.php");
include("../models/m_riskMatrix.php");

$mysqli = new mysqli("localhost", "root", "", "riskiranger"); 
if ($mysqli->connect_error) {
    die("Koneksi gagal: " . $mysqli->connect_error);
}
$riskMatrix  = new RiskMatrix($mysqli);

$matrix = $riskMatrix->generateRiskMatrix();

// Generate Cartesian Risk Matrix SVG
$cartesianMatrix = $riskMatrix->generateCartesianRiskMatrix();
?>
    <div id="page-content-wrapper">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
            <h1><b>Risk Map</b></h1>
                <ol class="breadcrumb">
                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                    <li><a href=""><i class="fa fa-dashboard"></i></a></li>
                    <li><a href=""><?= $level_tampilan?></a></li>
                    <li class="active">Risk Map</li>
                </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="risk-matrix-container">
                    <?= $cartesianMatrix ?>
                </div>
            </div>
        </div>
      </div>
    </div>

<?php include("../template/_footer.php");?>