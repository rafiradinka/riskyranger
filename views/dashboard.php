<?php include("../template/_header.php");?>

    <style>
            #page-content-wrapper h3 {
              color: #1E9B96;
            }

            .img-dashboard {
              position: absolute;
              scale: 0.35;
              top:-45rem;
              right: -40rem;
              z-index: 1;
            }

            #menu-toggle {
              z-index: 3;
            }
    </style>

    <div id="page-content-wrapper">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1><b>Dashboard</b></h1>
                <h3>Selamat Datang, <?= htmlspecialchars($unit_terkait); ?>!<h3>
                <a href="#menu-toggle" class="btn btn-default" id="menu-toggle">Toggle Menu</a>
                <img src="../_assets/img/dashboard-img.png" alt="" class="img-dashboard">
            </div>
        </div>
      </div>
    </div>

<?php include("../template/_footer.php");?>