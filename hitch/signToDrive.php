<?php
  session_start();
  include("connections.php");
  include("functions.php");

  $user_data=check_login($con);

  if($_SERVER['REQUEST_METHOD']=="POST")
  { 
    $uname=$user_data['uname'];
    $loc=$_POST['loc'];
    $dest=$_POST['dest'];
    $seats=$_POST['seats'];
    $date=$_POST['date'];
    $time=$_POST['time'];
    $vehicle=$_POST['vehicle'];

    if(!empty($loc)&&!empty($dest)&&!empty($seats)&&!empty($date)&&!empty($time)&&!empty($vehicle))
    {
      $query="insert into drive(uname,loc,dest,seats,date,time,vehicle) values('$uname','$loc','$dest','$seats','$date','$time','$vehicle')";
      mysqli_query($con,$query);

      $query1="select * from notify where loc='$loc' and des='$dest' and seats='$seats' and isAvailable='0'";
      $result=mysqli_query($con,$query1);
      if (mysqli_num_rows($result) > 0) {
        $query2="update notify set isAvailable='1' where loc='$loc' and des='$dest' and seats='$seats' and isAvailable='0'";
        mysqli_query($con,$query2);
      }

      header("Location: DriveStarted.php");
      die;
    }
    else
    {
      echo"<script type='text/javascript'>alert('Enter all fields')</script>";
    }
    
  }
  


?>












<!DOCTYPE html>
<html>
  <head>
    <title>hitch</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
   <!--font-->
   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital@1&display=swap" rel="stylesheet">
    
    
    <!-- Custom CSS -->
    

    </style>
    <link rel="stylesheet" href="./asset/style.css">
  </head>
  <body>
    

        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg navbar-light bg-light mx-5  bg-light">
    
            <h4 class="hitch-h1 ">hitch</h4>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
              aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
         
          </nav>
        </div>
     



   

      <!--.....-->
      

     









    

        <div class="row featurette">
            <div class="col-md-7 order-md-3">
                <div class="col-md-6 " id="form">
                    <h2>Where are you going ? </h2>
                    <form method="POST" action="">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="loc">
                        <label for="floatingInput">starting location</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="dest">
                        <label for="floatingInput">destination</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="number" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="seats">
                        <label for="floatingInput">number of seats</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="date" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="date">
                        <label for="floatingInput">date of the journey</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="time" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="time">
                        <label for="floatingInput">starting time of journey</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="vehicle">
                        <label for="floatingInput">vehicle type</label>
                      </div>


                      <button type="submit" class="my-2 btn btn-primary">Go</button>
                    </form>
                  </div>
            </div>
            <div class="col-md-5 order-md-1">
                <img width="500" class="my-4 mx-4" src="./asset/web-g7c6ca1e38_1920.png">
            </div>
          </div>





       








    
  <footer class="bg-dark text-light py-4 mt-5">
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <h5>About hitch</h5>
          <p style="font-family: Arial, sans-serif;">Tired of high costs and hassle when traveling long distances alone?
            <br> Say hello to inter-city ride sharing! Enjoy new friends, save on gas and tolls, and outsmart airlines
            and uncomfortable buses. Join the ride sharing revolution and take control of your travel and destiny!</p>
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
