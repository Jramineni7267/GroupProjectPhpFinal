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
      .img-s {
      opacity: 0;
      transition: 0.3s;
      }
      .card:hover .img-s {
      opacity: 1;
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
									<a class="nav link text-dark active" href="home.php">Home</a>
								</li>
								<li class="nav item">
									<a class="nav link text-dark" href="user_page.php">Product</a>
								</li>
								<li class="nav item">
									<a class="nav link text-dark" href="Aboutus.php">About Us</a>
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

		<!-- Main section start here  -->
    <main>
			<div class="herosection">
				<div class="container">
					<h1>FUJIFILM X-H2S <br> Creator ready</h1>
					<h2>For content creators, vloggers <br>and streamers.</h2>
				</div>
			</div>
				<div class="container">
						<div class="row">
							<div class="col-md-12  mb-5 mt-5">
								<div class="d-flex page_title">
									<hr class="my-auto flex-grow-1">
									<div class="px-3 text-uppercase fs-2 ">
										<h3>OUR BEST SELLERS</h3>
									</div>
									<hr class="my-auto flex-grow-1">
								</div>
							</div>
							<div class="col-md-6 col-12 mb-5 mt-5">
							<h4>Canon EOS R10</h4>
							<p class="text-justify">The Olympus Pen is the ideal introduction to an interchangeable lens camera, or for  those looking for an affordable upgrade. Equipped with a 24.1 Megapixel CMOS (APS-C) sensor, DIGIC 8 image processor and an ISO range of 100-25600 (expandable to 51200*), the EOS Rebel T8i 
								is our most advanced EOS Rebel yet, delivering high-quality performance that kicks your photos 
								and videos up a notch. Whether you're capturing simple moments with friends or family, or 
								snapping fast-moving subjects like pets or athletes, maintain smooth and accurate focus with 
								the camera's high-speed continuous shooting of up to 7 frames per second (up to 7.5 fps during 
								Live View shooting).</p>
							</div>
							<div class="col-md-6 col-12 text-center">
								<img src="image/Canon.jpg" alt="Canon EOS R10" class="best_img"/>
							</div>
						</div>  
						<div class="row">
							<div class="col-md-6 col-12 text-center">
								<img src="image/Panosonic.jpg" class="best_img" alt="Panosonic" />
							</div>
							<div class="col-md-6 col-12 mb-5 mt-5">
								<h4>Panosonic Vintage</h4>
								<p class="text-justify">The Sony is the ideal introduction to an interchangeable lens camera, or for those looking for an affordable upgrade. Equipped with a 24.1 Megapixel CMOS (APS-C) sensor, 
								DIGIC 8 image processor and an ISO range of 100-25600 (expandable to 51200*), the EOS Rebel T8i 
								is our most advanced EOS Rebel yet, delivering high-quality performance that kicks your photos 
								and videos up a notch. Whether you’re capturing simple moments with friends or family, or 
								snapping fast-moving subjects like pets or athletes, maintain smooth and accurate focus with 
								the camera’s high-speed continuous shooting of up to 7 frames per second (up to 7.5 fps during 
								Live View shooting).</p>
							</div>
						</div>   
						<div class="row">
							<div class="col-md-6 col-12 mb-5 mt-5">
								<h4>DX-format cameras</h4>
								<p class="text-justify"> The Nikon DSLR D3500 is the ideal introduction to an interchangeable lens camera, or for 
            those looking for an affordable upgrade. Equipped with a 24.1 Megapixel CMOS (APS-C) sensor, 
            DIGIC 8 image processor and an ISO range of 100-25600 (expandable to 51200*), the EOS Rebel T8i 
            is our most advanced EOS Rebel yet, delivering high-quality performance that kicks your photos 
            and videos up a notch. Whether you’re capturing simple moments with friends or family, or 
            snapping fast-moving subjects like pets or athletes, maintain smooth and accurate focus with 
            the camera’s high-speed continuous shooting of up to 7 frames per second (up to 7.5 fps during 
            Live View shooting).</p>
							</div>
							<div class="col-md-6 col-12 text-center">
								<img src="image/Nikon.png" class="best_img" alt="Nikon" />
							</div>
						</div>       
        </div>
        <!-- model for shopping cart -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Model title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="table-responsive">
                  <?php echo $message; ?>
                  <div align="right">
                    <a href="user_page.php?action=clear" class="btn btn-danger btn-sm mb-1"><b>Clear Cart <i class="fa fa-trash-alt"></i></b></a>
                  </div>
                  <table class="table table-bordered">
                    <tr>
                      <th width="40%">Item Name</th>
                      <th width="10%">Quantity</th>
                      <th width="20%">Price</th>
                      <th width="15%">Total</th>
                      <th width="5%">Action</th>
                    </tr>
                    <?php
                      if (isset($_COOKIE["shopping_cart"])) {
                      
                          //    echo "<pre>";
                          //   print_r($_COOKIE["shopping_cart"]);
                      
                          $total = 0;
                          $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                          $cart_data = json_decode($cookie_data, true);
                      
                      
                          $session_ID = array_column($cart_data, 'session_id');
                          if (in_array($session_id, $session_ID)) {
                              foreach ($cart_data as $keys => $values) {
                                  if($cart_data[$keys]["session_id"] ==  $session_id){
                      
                      
                      
                      ?>
                    <tr>
                      <td>
                        <?php echo $values["item_name"]; ?>
                      </td>
                      <td><?php echo $values["item_quantity"]; ?></td>
                      <td>$ <?php echo $values["item_price"]; ?></td>
                      <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2); ?></td>
                      <td><a href="user_page.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger"><i class="fa fa-trash"></i></span></a></td>
                    </tr>
                    <?php
                      $total = $total + ($values["item_quantity"] * $values["item_price"]);
                      }
                      }
                      }
                      
                      ?>
                    <tr>
                      <td colspan="3" align="right">Total</td>
                      <td align="right">$ <?php echo number_format($total, 2); ?></td>
                      <td><a href="invoice.php" class="btn btn-dark <?= ($total>1)?"":"disabled";
                        ?><i class="far fa-credit-card"></i>&nbsp;&nbsp;Invoice</a> </td>
                    </tr>
                    <?php
                      } else {
                          echo '
                      <tr>
                      <td colspan="5" align="center">No Item in Cart</td>
                      </tr>
                      ';
                      }
                      
                      ?>
                  </table>
                </div>
              </div>
            </div>
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
				</div>
			</div>
			<!-- Copyright -->
			<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
				&copy; 2022 Copyright:
				<a class="text-white" href="https://zipperlens.com/">zipperlens.com</a>
			</div>
		</footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  </body>
  
</html>