<?php
  session_start();
  include "product_class.php";
  if (empty($_SESSION['admin'])) {
      header('location: index.php');
  }
  if ($_SESSION['admin']['role'] == 'admin') {
      header('location: admin_panel.php');
  }
  $session_id = $_SESSION['admin']['id'];
  $Products = new Products();
  
  $display = $Products->displayProduct();
  $message = '';
  if (isset($_GET["action"])) {
      if ($_GET["action"] == "delete") {
          $cookie_data = stripslashes($_COOKIE['shopping_cart']);
          $cart_data = json_decode($cookie_data, true);
          foreach ($cart_data as $keys => $values) {
              if ($cart_data[$keys]['item_id'] == $_GET["id"] && $cart_data[$keys]['session_id'] == $session_id) {
                  unset($cart_data[$keys]);
                  $item_data = json_encode($cart_data);
                  setcookie("shopping_cart", $item_data, time() + (86400 * 30));
                  header("location:user_page.php?remove=1");
              }
          }
      }
      if ($_GET["action"] == "clear") {
          $cookie_data = stripslashes($_COOKIE['shopping_cart']);
          $cart_data = json_decode($cookie_data, true);
          foreach ($cart_data as $keys => $values) {
              if ($cart_data[$keys]['session_id'] == $session_id) {
                  unset($cart_data[$keys]);
                  $item_data = json_encode($cart_data);
                  setcookie("shopping_cart", $item_data, time() + (86400 * 30));
                  header("location:user_page.php?clearall=1");
              }
          }
  
  
          //   setcookie("shopping_cart", "", time() - 3600);
          //   header("location:user_page.php?clearall=1");
      }
  }
  
  if (isset($_GET["success"])) {
      $message = '
  
   <div class="alert alert-success alert-dismissible fade show" role="alert">
   Item Added into Cart
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
   ';
  }
  
  if (isset($_GET["remove"])) {
      $message = '
  
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
   Item removed from Cart
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
   ';
  }
  if (isset($_GET["clearall"])) {
      $message = '
  
   <div class="alert alert-danger alert-dismissible fade show" role="alert">
   Your Shopping Cart has been clear...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
   ';
  }
  
  ?>
<!-- <a class="dropdown-item" href="logoutadmin.php">Long Out</a> -->
<?php
  //  if(isset($_SESSION['License']) && !empty($_SESSION['License'])){
  ?>
<!-- <div class="alert alert-success text-center"> -->
<?php
  // echo $_SESSION['License'];
  ?>
<!-- </div> -->
<?php
  // }
  ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Zipper Lenses</title>
    <style>
      .column {
      float: left;
      width: 33.3%;
      margin-bottom: 16px;
      padding: 0 8px;
      margin-left: 430px;
      }
      .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      margin: 8px;
      }
      .container {
      padding: 0 16px;
      }
      .container::after, .row::after {
      content: "";
      clear: both;
      display: table;
      }
      .title {
      color: grey;
      }
      .button {
      border: none;
      outline: 0;
      display: inline-block;
      padding: 8px;
      color: white;
      background-color: #000;
      text-align: center;
      cursor: pointer;
      width: 100%;
      }
      .button:hover {
      background-color: #555;
      }
      @media screen and (max-width: 650px) {
      .column {
      width: 100%;
      display: block;
      }
      }
    </style>
  </head>
  <body>
    <header class="section-header">
      <section class="header-main border-bottom py-2">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-2 col-4">
              <a href="home.php" class="brand-wrap">
              <img class="logo" src="image/logo.jpg">
              </a>
            </div>
            <div class="col-lg-4 col-sm-12">
              <form action="#" class="search">
              <div class="input-group w-70">
                <input type="text" class="form-control" id="search_button" placeholder="Search">
                <div class="input-group-append">
                  <button class="btn btn-dark" type="submit">
                  <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-4">
              <ul class="head_nav">
                <li class="nav item">
                  <a class="nav link text-dark" href="home.php">Home</a>
                </li>
                <li class="nav item">
                  <a class="nav link text-dark " href="user_page.php">Product</a>
                </li>
                <li class="nav item">
                  <a class="nav link text-dark active" href="Aboutus.php">About Us</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-2 col-sm-6 col-12">
              <div class="d-flex justify-content-end">
                <ul class="nav">
                  <li class="nav-item me-3 pe-3">
                    <button type="button" class="btn btn-dark position-relative" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa fa-shopping-cart"></i> <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?php
                      if (isset($_COOKIE["shopping_cart"])) {
                          $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                      
                          $cart_data = json_decode($cookie_data, true);
                      } else {
                          $cart_data = array();
                      }
                      
                      $session = array_column($cart_data, 'session_id');
                      if(in_array($session_id,$session))
                      {
                          echo array_count_values($session)[$session_id];
                      } else {
                          echo "0";
                      }
                      
                      ?>
                    </span>
                    </button>
                  </li>
                  <li class="nav-item me-2">
                    <div class="btn-group">
                      <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-user"></i>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="changePassword.php">Change Password</a></li>
                        <li>
                          <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="logoutadmin.php">Log Out</a></li>
                      </ul>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>
    </header>
    <main>
    <div class="herosection" style="background-image: url(image/support_main.jpg);">
      <div class="container">
        <h1>About us</h1>
        <h2>Learn more about the <br>Technology & Design of our products.</h2>
      </div>
    </div>
      <div class="container">
        <div class="about-section">
        <div class="col-md-12  mb-5 mt-5">
            <div class="d-flex page_title">
              <hr class="my-auto flex-grow-1">
              <div class="px-3 text-uppercase fs-2 ">
                <h3>About our Technology & Design</h3>
              </div>
              <hr class="my-auto flex-grow-1">
            </div>
          </div>
          <ul class="tech_list">
            <li>Expanding the possibilities of imaging through combining cutting-edge digital processing with networking technologies.</li>
            <li>Realizing extremely high optical performance with a revolutionary lens mount system, leading image expression to a new dimension.</li>
            <li>Enhancing viewing for diverse purposes from birdwatching to marine observation.</li>
            <li>Facilitating the manufacture of increasingly larger-sized and higher- definition flat-panel displays.</li>
            <li>Contributing to the advancement of semiconductors — the brains of digital devices.</li>
            <li>Measuring absolute grid distortion values for all wafers prior to exposure. Correction values are fed forward to the lithography system.</li>
            <li>Advancing beyond the limit of conventional technologies to achieve observation of intricate structures inside cells.</li>
            <li>Improving the efficiency of retinal imaging diagnostics to reduce the burden on patients.</li>
            <li>Assisting factory automation with high-precision auto measuring of electronic components.</li>
            <li>Providing nondestructive inspection of products with intricate inner structure, utilizing X-ray transmission.</li>
            <li>Offering non-contact, 3D measurement of large aircraft and automotive parts, as well as wind turbine blades.</li>
          </ul>
          <img src="image/about_text.jpg" alt="" class="mt-4">
          <div class="col-md-12  mb-5 mt-5">
            <div class="d-flex page_title">
              <hr class="my-auto flex-grow-1">
              <div class="px-3 text-uppercase fs-2 ">
                <h3>Myself</h3>
              </div>
              <hr class="my-auto flex-grow-1">
            </div>
          </div>
          <div class="row mb-5">
            <div class="column">
              <div class="card">
                
                <img src="image/Jesh.jpg" alt="Canon Rebel T8i" />
                <div class="team_detail">
                  <h2>Jeshwanth Ramineni</h2>
                  <p class="title">Web Developer</p>
                  <p>Jeshwanth is senior web developer. He is Expert in PHP, mySql and javascript.</p>
                  <p>Email : Jeshwanth@gmail.com</p>
                  <p>Contact Number : +1 (234) 567 2589</p>
                </div>
              </div>
            </div>
            <!-- <div class="column">
              <div class="card">
                <img src="image/team2.jpg" alt="Parthvi" />
                <div class="team_detail">
                  <h2>Parthvi Shah</h2>
                  <p class="title">Web Designer</p>
                  <p>Parthvi is web and graphic designer of our team.</p>
                  <p>Email : Parthvi@hotmail.com</p>
                  <p>Contact Number : +1 (223) 456 6789</p>
                </div>
              </div>
            </div>
            <div class="column">
              <div class="card">
                <img src="image/team3.jpg" alt="Canon Rebel T8i" />
                <div class="team_detail">
                  <h2>Shreyansh Chavada</h2>
                  <p class="title">Web Developer</p>
                  <p>Shreyansh is expertise in e-commerse development is an asset for our team.</p>
                  <p>Email : Shreyansh@yahoo.com</p>
                  <p>Contact Number : +1 (234) 567 5589</p>
                </div>
              </div>
            </div> -->
          </div>
        </div>
      </div>
    </main>
    <footer class="bg-dark text-center text-lg-start text-white">
      <!-- Grid container -->
      <div class="container p-4">
        <!--Grid row-->
        <div class="row mt-4">
          <!--Grid column-->
          <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">See other cameras</h5>
            <ul class="list-unstyled mb-0">
              <li>
                <a href="#!" class="text-white"><i class="fas fa-camera fa-fw fa-sm me-2"></i>Bestsellers</a>
              </li>
              <li>
                <a href="#!" class="text-white"><i class="fas fa-camera fa-fw fa-sm me-2"></i>All Cameras</a>
              </li>
              <li>
                <a href="#!" class="text-white"><i class="fas fa-camera fa-fw fa-sm me-2"></i>Our Cameras</a>
              </li>
            </ul>
          </div>
          <!--Grid column-->
          <!--Grid column-->
          <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">Execution of the contract</h5>
            <ul class="list-unstyled">
              <li>
                <a href="#!" class="text-white"><i class="fas fa-shipping-fast fa-fw fa-sm me-2"></i>Supply</a>
              </li>
              <li>
                <a href="#!" class="text-white"><i class="fas fa-backspace fa-fw fa-sm me-2"></i>Returns</a>
              </li>
              <li>
                <a href="#!" class="text-white"><i class="far fa-file-alt fa-fw fa-sm me-2"></i>Regulations</a>
              </li>
              <li>
                <a href="#!" class="text-white"><i class="far fa-file-alt fa-fw fa-sm me-2"></i>Privacy policy</a>
              </li>
            </ul>
          </div>
          <!--Grid column-->
          <!--Grid column-->
          <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">Publishing house</h5>
            <ul class="list-unstyled">
              <li>
                <a href="#!" class="text-white">Zipper Lens</a>
              </li>
              <li>
                <a href="#!" class="text-white">999 Blah Blah College</a>
              </li>
              <li>
                <a href="#!" class="text-white">N4H 5K8 ON</a>
              </li>
              <li>
                <a href="#!" class="text-white"><i class="fas fa-briefcase fa-fw fa-sm me-2"></i>Send us a book</a>
              </li>
            </ul>
          </div>
          <!--Grid column-->
          <!--Grid column-->
          <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
            <h5 class="text-uppercase">Write to us</h5>
            <ul class="list-unstyled">
              <li>
                <a href="#!" class="text-white"><i class="fas fa-at fa-fw fa-sm me-2"></i>zipperlens@blah.com</a>
              </li>
              <li>
                <a href="#!" class="text-white"><i class="fas fa-shipping-fast fa-fw fa-sm me-2"></i>Check the order status</a>
              </li>
              <li>
                <a href="#!" class="text-white"><i class="fas fa-envelope fa-fw fa-sm me-2"></i>Join the newsletter</a>
              </li>
            </ul>
          </div>
          <!--Grid column-->
        </div>
        <!--Grid row-->
      </div>
      <!-- Grid container -->
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        © 2022 Copyright:
        <a class="text-white" href="https://zipperlens.com/">zipperlens.com</a>
      </div>
      <!-- Copyright -->
    </footer>
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
  </body>
</html>