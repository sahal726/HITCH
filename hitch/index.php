<?php
session_start();
include("connections.php");
include("functions.php");

$user_data = check_login($con);
//  while(!$isAvailable)
//  {
//   $query = "SELECT uname, date, time, vehicle, seats FROM drive WHERE loc='$loc1' AND dest='$dest1' AND seats>='$seats1'";
//   $result = mysqli_query($con, $query);
//   if (mysqli_num_rows($result) > 0) {
//       $isAvailable=true;
//   } else {
//       $isAvailable=false;
//   }
//  }

if (isset($_POST["del_notify"])) {
  $not_id = $_POST["id"];
  $del_sql = "delete from notify where id='$not_id'";
  $run_not = mysqli_query($con, $del_sql);
}

?>








<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>hitch</title>
  <link rel="stylesheet" href="./asset/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital@1&display=swap" rel="stylesheet">



  <link href="https://fonts.googleapis.com/css2?family=Vina+Sans&display=swap" rel="stylesheet">
</head>

<body>


  <!-- navigation bar -->

  <section id="navbar">

    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light bg-light px-3  bg-light">

        <h4 class="hitch-h1 ">hitch</h4>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="myindex.php">Home <span class="sr-only"></span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./signToRide.php">Find a Ride</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./signToDrive.php">Offer a Ride</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="requests.php">Requests</a>
            </li>


          </ul>

        </div>

        <?php

        $uname = $user_data["name"];
        $notify_sql = "select * from notify where uname='$uname' AND isAvailable='1'";
        $run_notify = mysqli_query($con, $notify_sql);
        $notify_count = mysqli_num_rows($run_notify);

        ?>

        <div class="dropdown">
          <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Notification <span class="badge text-bg-danger"><?php echo $notify_count ?></span>
          </button>
          <ul class="dropdown-menu p-4">

            <?php

            if ($notify_count > 0) {
              while ($notify_row = mysqli_fetch_array($run_notify)) {

                $notify_id = $notify_row["id"];
                $notify_dest = $notify_row["des"];
                $notify_loc = $notify_row["loc"];
                $notify_seats = $notify_row["seats"];
                $notify_date = $notify_row["date"];

            ?>
                <li>
                  <p class="fw-bold">Your ride is available now!</p>
                  <p class="mb-0">Destination : <?php echo $notify_dest ?></p>
                  <p class="mb-0">Location : <?php echo $notify_loc ?></p>
                  <p class="mb-0">Seats : <?php echo $notify_seats ?></p>
                  <form action="AvailableRide.php" method="post">
                    <input type="hidden" name="loc" value="<?php echo $notify_loc ?>" required>
                    <input type="hidden" name="dest" value="<?php echo $notify_dest ?>" required>
                    <input type="hidden" name="seats" value="<?php echo $notify_seats ?>" required>
                    <input type="hidden" name="date" value="<?php echo $notify_date ?>" required>
                    <button type="submit" name="go" class="btn btn-warning btn-sm mt-2 w-100">View More</button>
                  </form>
                  <form action="" method="post">
                    <input type="hidden" name="id" value="<?php echo $notify_id ?>" required>
                    <button type="submit" name="del_notify" class="btn btn-danger btn-sm mt-1 w-100">Delete</button>
                  </form>
                </li>

            <?php }
            } ?>
          </ul>
        </div>

        <form class="form-inline">
          <a href="logout.php" class="btn btn-dark my-4 mx-2">log out</a>
        </form>
      </nav>
    </div>
  </section>



  <!-- hero section -->


  <section class="hero-center alisection   py-5  text-center bgcolor  ">
    <div class="container " style="background-color: black;">
      <div class="row align-items-center justify-content-center align-items-center">
        <div class="col-lg-6">
          <h1 style="color: white;" class="tagline my-4">Join Our Carpooling Community Today</h1>
          <h1 class="hitch-h1 logo-1 my-4">hitch</h1>
          <p class="py-5 " style="color:white">Save money, reduce your carbon footprint, and meet new people by sharing
            rides with hitch.</p>
          <a href="./signToRide.php" class="btn btn-primary my-4 mx-2">Sign to ride</a>
          <a href="./signToDrive.php" class="btn btn-primary my-4">Sign to drive</a>
        </div>
      </div>
    </div>
  </section>



  <!-- features-->

  <div class="container marketing">



    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1">why<span class="hitch-h1"> hitch</span> <span class="text-body-secondary">?</span></h2>
        <p class="lead"> Hitch is the perfect carpooling website for frequent travelers who want an affordable and eco-friendly transportation option. With our easy-to-use platform, you can quickly connect with others who are traveling in the same direction and split the cost of fuel, tolls, and other expenses. Our commitment to safety and security ensures that all rides are safe and reliable. So sign up for Hitch today and start saving money on your travels while also reducing traffic congestion and air pollution.</p>
      </div>

      <div class="col-md-5">
        <img width="300" height="300" src="./asset/featurepic.jpg" alt="picture">

      </div>
    </div>

    <hr class="featurette-divider">



    <hr class="featurette-divider">

    <div class="row featurette">
      <div class="col-md-7">
        <h2 class="featurette-heading fw-normal lh-1">And lastly, how to <span class="text-body-secondary">hitch.</span></h2>
        <p class="lead">To use Hitch, sign up for a free account, set up your profile, search for rides, book your ride, connect with your ride partner, and enjoy your ride. Our user-friendly platform and commitment to safety make it easy for you to find affordable and sustainable transportation options that meet your needs.</p>
      </div>
      <div class="col-md-5">
        <img src="./asset/road-trip-g4ec50ab39_1280.png" height="300" width="300" alt="picture">
      </div>
    </div>

    <hr class="featurette-divider">

    <!-- /END THE FEATURETTES -->

  </div>

  <!-- footer -->

  <footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>About hitch</h5>
          <p style="font-family: Arial, sans-serif;">Tired of high costs and hassle when traveling long distances alone?
            <br> Say hello to inter-city ride sharing! Enjoy new friends, save on gas and tolls, and outsmart airlines
            and uncomfortable buses. Join the ride sharing revolution and take control of your travel and destiny!
          </p>
        </div>
        <div class="col-md-4">
          <h5>Useful Links</h5>
          <ul class="list-unstyled">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Terms of Use</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
        <div class="col-md-4">
          <h5>Contact Us</h5>
          <ul class="list-inline social-media-list mb-0">
            <li class="list-inline-item">
              <a href="https://www.facebook.com/">
                <img src="" alt="facebook">
              </a>
            </li>
            <li class="list-inline-item">
              <a href="https://twitter.com/login">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="https://www.instagram.com/">
                <i class="fab fa-instagram"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
      <hr>
      <div class="text-center">
        <p>&copy; 2023 hitch. All rights reserved.</p>
      </div>
    </div>
  </footer>









  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>