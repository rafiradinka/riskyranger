<?php include("helper/helper.php"); ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Font Google-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- My Style -->
    <link rel="stylesheet" href="_assets/css/style.css">

    <!-- Responsive Style -->
     <link rel="stylesheet" href="_assets/css/responsive.css">

    <!-- Logo Title Bar-->
    <link rel="icon" href="_assets/img/logo-rr.jpg"
    type="image/x-icon" class="logo">

    <title>Risky Rangers</title>

  </head>
  <body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-transparent position-fixed w-100">
        <div class="container">
          <a class="navbar-brand" href="#">
            <img src="_assets/img/logo-rr.jpg" alt="" width="20" class="d-inline-block align-text-top me-2">
            Risky Rangers</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
              <li class="nav-item mx-2">
                <a class="nav-link active" aria-current="page" href="#hero">Beranda</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="#tentangkami">Tentang Kami</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="#fitur">Fitur</a>
              </li>
              <li class="nav-item mx-2">
                <a class="nav-link" href="#keuntungan">Keuntungan</a>
              </li>
            </ul>

            <div>
              <a href="<?=base_url('views/login.php')?>">
                <button class="button-secondary">Masuk</button>
              </a>
            </div>
          </div>
        </div>
      </nav>

    <!-- Hero Section -->
    <section id="hero">
      <div class="container h-100">
        <div class="row h-100">
          <div class="col-md-6 hero-tagline my-auto">
            <h6>Halo, selamat datang!</h6>
            <h1>Ambil kendali atas resiko bisnismu dengan Risky Rangers</h1>
            <p><span class="fw-bold">Website manajemen resiko</span> yang dirancang untuk membantu anda  mengidentifikasi, menganalisis, dan mengelola resiko secara efektif</p>

              <a href="https://wa.me/+6285155270906">
                <button class="button-lg-primary">Tanya lebih detail</button>
              </a>
              <a href="views/login.php">
                <button class="button-lg-secondary">Get Started</button>    
              </a>
            <div>
              <img src="_assets/img/pc2.png" alt="" class="img-hero">
            </div>       
          </div>
          
        </div>

        <img src="_assets/img/accsent.png" alt="" class="accsent-img h-100 position-absolute end-0 top-0">
        <img src="_assets/img/accsent2.png" alt="" class="accsent2-img h-100 position-absolute start-0 top-0">
      </div>
    </section>

    <!-- Tentang Kami-->
    <section id="tentangkami">
        <div class="container">
            <div class="row mb-4">
             <div class="col-12 text-center fitur-fitur mb-5">
              <h2>Tentang Kami</h2>
              <span class="sub-title">Lorem ipsum dolor sit amet</span>
            </div>

            <div>
              <div class="card2">
                <div class="card-body-about">
                  <p>Risky Rangers adalah solusi manajemen risiko inovatif yang dirancang untuk membantu organisasi menghadapi tantangan operasional dan strategis dengan lebih efektif. Kami hadir dengan tujuan untuk memberikan alat yang canggih dan mudah digunakan, memungkinkan perusahaan untuk mengidentifikasi, menganalisis, dan mengelola risiko secara proaktif..</p>
                </div>
              </div>
            </div>
            
            
        </div>
    </section>

    <!-- Carousel -->
    <section id="fitur">
      <div class="container">
        <div class="col-12 text-center fitur-fitur">
          <h2>Fitur-Fitur</h2>
          <span class="sub-title">Lorem ipsum dolor sit amet</span>
        </div>
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active" data-bs-interval="10000">
            <div class="cards-wrapper justify-content-center">
              <div class="card">
                <img src="_assets/img/fitur1.png" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
              <div class="card">
                <img src="_assets/img/fitur1.png" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
              <div class="card">
                <img src="_assets/img/fitur1.png" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
              
            </div>
          </div>
          <div class="carousel-item" data-bs-interval="2000">
            <div class="cards-wrapper justify-content-center">
              <div class="card">
                <img src="_assets/img/fitur1.png" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
              <div class="card">
                <img src="_assets/img/fitur1.png" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>
              <div class="card">
                <img src="_assets/img/fitur1.png" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
              </div>

            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
        </div>
      </div>
    </section>

    <!-- Keuntungan -->
    <section id="keuntungan">
      <div class="container">
        <div class="row mb-4">
          <div class="col-md-6 offset-md-4 keuntungan my-auto">
            <h2>Keuntungan menggunakan Risky Rangers</h2>
            <span class="sub-title2">Lorem ipsum dolor sit amet consectetur adipisicing elit.</span>
            <div>
              <img src="_assets/img/roket.png" alt="" class="roket-img">
            </div>
          </div>
        </div>

        <img src="_assets/img/accsent.png" alt="" class="accsent-img h-100 position-absolute end-0 top-0">

        <div class="row">
          <div class="col-md-8 offset-md-4">
              <div class="card2">
                <div class="card-body2 mb-3">
                  <h4>Lorem ipsum</h4> 
                  <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                </div>
              </div>
          </div>
          
          <div class="col-md-8 offset-md-4">
            <div class="card2">
              <div class="card-body2 mb-3">
                <h4>Lorem ipsum</h4> 
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>

          <div class="col-md-8 offset-md-4">
            <div class="card2">
              <div class="card-body2 mb-3">
                <h4>Lorem ipsum</h4> 
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- footer -->
    <footer class="d-flex align-items-center position-relative">
      <div class="container-fluid">
        <div class="container">
          <div class="row">
            <div class="col-md-7 d-flex align-items-center">
              <img src="_assets/img/logo-rr.jpg" alt="" class="logofooter">
              <a href="#" class="ms-3">Risky Rangers</a>
            </div>
            <div class="col-md-5 d-flex justify-content-evenly">
              <a href="#hero">Beranda</a>
              <a href="#tentangkami">Tentang Kami</a>
              <a href="#fitur">Fitur</a>
              <a href="#keuntungan">Keuntungan</a>
            </div>
          </div>
          <div class="row position-absolute copyright start-50 translate-middle">
            <div class="col-12">
              <p class="text-center">Copyright by Risky Rangers All Right Reserved</p>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Javascript -->
    <script src="_assets/js/script.js"></script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
  </body>
</html>
