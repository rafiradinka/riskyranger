<?php 
include("../template/_header.php");
include("../models/m_riskMatrix.php");

$database = new Database();
$dbConnection = $database->getConnection();;

$riskMatrix = new RiskMap($dbConnection);
$cartesianMatrix = $riskMatrix->generateCartesianRiskMap();
?>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                <h1><b>Risk Map</b></h1>
                    <ol class="breadcrumb">
                    <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                        <li><a href=""><i class="fa fa-dashboard"></i></a></li>
                        <li><a href=""><?= htmlspecialchars($level); ?></a></li>
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

    <script>
   // membuka tooltip ketika klik titik point
    const toggleRiskPoint = (element) => {
        document.querySelectorAll('.risk-point').forEach(point => {
            if (point !== element) point.classList.remove('active');
        });
        element.classList.toggle('active');
    };

    // menutup tooltip ketika klik bagian selain titik point
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.risk-point')) {
            document.querySelectorAll('.risk-point').forEach(point => {
                point.classList.remove('active');
            });
        }
    });
    </script>

<?php include("../template/_footer.php");?>