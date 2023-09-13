<?php
session_start();

include("connections.php");
include("functions.php");

global $loc1; 
global $dest1; 
global $seats1; 
global $date1; 
global $isAvailable;

$user_data = check_login($con);

if (isset($_POST['go'])) {
    $loc1 = $_POST['loc'];
    $dest1 = $_POST['dest'];
    $seats1 = $_POST['seats'];
    $date1 = $_POST['date'];

    if (!empty($loc1) && !empty($dest1) && !empty($seats1) && !empty($date1)) {
        $query = "SELECT uname, date, time, vehicle, seats FROM drive WHERE loc='$loc1' AND dest='$dest1' AND seats>='$seats1'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $isAvailable = true;
        } else {
            $isAvailable = false;
        }
    } else {
        echo "Please enter all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>List of rides</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="asset/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital@1&display=swap" rel="stylesheet">
</head>
<body>
<section id="navbar">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mx-5 bg-light">
            <h4 class="hitch-h1">hitch</h4>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signToRide.php">Find a Ride</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="signToDrive.php">Offer a Ride</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-lg-4">
            <img src="./asset/web-gecf1449ab_1280.jpg" class="img-fluid rounded" alt="Bootstrap Themes" loading="lazy">
        </div>
        <div class="col-lg-8">
            <?php if ($isAvailable == true) : ?>
                <div class="card">
                    <div class="card-header">
                        <h5>Available Rides</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php while ($row = mysqli_fetch_array($result)) :
                            $driver = $row['uname'];
                            $vehicle = $row['vehicle'];
                            $seats = $row['seats'];


                            ?>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6><?php echo $row["uname"]; ?></h6>

                                        <h6>vehicle type   : <?php echo $row["vehicle"]; ?></h6>
                                        <h6>number of seats: <?php echo $row["seats"]; ?></h6>
                                        <h6>date: <small class="text-muted"><?php echo $row["date"]; ?></small></h6>
                                    </div>
                                    <form method="POST" action="">
                                        <input type="hidden" value="<?php echo $row["uname"]; ?>" name="username">
                                        <button type="submit" class="btn btn-outline-dark" name="request">Request</button>
                                    </form>
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php else : ?>
                <div class="alert alert-info" role="alert">
                    <h5>No available rides found.</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
if (isset($_POST['request'])) {
    $driver = $_POST['username'];
    $id = $user_data['id'];
    $uName = $user_data['uname'];
    $ph_no = $user_data['ph_no'];

    $query1 = "INSERT INTO waiting (id, name, ph_no, driver) VALUES ('$id', '$uName', '$ph_no', '$driver')";
    mysqli_query($con, $query1);
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>
</html>
<?php
    
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="";
    $dbname="hitch";

    if(!$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
    {
        die("Cannot connect to database");
    }
    <?php

    session_start();
    include("connections.php");
    include("functions.php");

    $user_data=check_login($con);

    if($_SERVER['REQUEST_METHOD']=="POST")
    {
        $uname=$user_data['uname'];
        $query="delete from drive where uname='$uname'";

        mysqli_query($con,$query);

        header("Location: index.php");
        die;
        
    }


    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./asset/style.css">



    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital@1&display=swap" rel="stylesheet">

</head>
<body>
<!--navbar-->


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
            <a class="nav-link" href="index.php">Home <span class="sr-only"></span></a>
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

  <div class="col-md-6 p-lg-5 mx-auto my-5">
      <h1 class="display-3 fw-bold">YOUR RIDE HAS BEEN REGISTERED</h1>
      <h3 class="fw-normal text-muted mb-3">wait for peers to join</h3>
      <div class="d-flex gap-3  lead fw-normal">
      <a href="index.php" class="btn btn-dark ">Home</a>
      <a href="requests.php" class="btn btn-dark ">Requests</a>
      <form method="POST">
      <button class="btn btn-dark ">End Journey</button>

      </form>

      </div>
    </div>


</body><?php

function check_login($con)
{
    if(isset($_SESSION['id']))
    {
        $id=$_SESSION['id'];
        $query="select * from users where id='$id' limit 1";

        $result=mysqli_query($con,$query);

        if($result && mysqli_num_rows($result)>0)
        {
            $user_data=mysqli_fetch_assoc($result);
            return $user_data;
        }
    } 
    
    header("location: login.php");
    die;
} 


<?php
  session_start();
  include("connections.php");
  include("functions.php");

  $user_data=check_login($con);

?>








<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>hitch</title>
  <link rel="stylesheet" href="./asset/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
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
        <img  width="300" height="300"  src="./asset/featurepic.jpg" alt="picture">
        
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









  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
</body>

</html>



<?php
 session_start();

 include("connections.php");
 include("functions.php");
 
  
 if ($_SERVER['REQUEST_METHOD'] =="POST")
 {
     //something was posted
     $user_name=$_POST['uname'];
     $password=$_POST['password'];
 
     if(!empty($user_name)&& !empty($password) )
     {
         
         $query1 = "select * from users where uname = '$user_name' limit 1";
         
        
          $result = mysqli_query($con,$query1);
          

          $count=mysqli_num_rows($result);
          



        if($result && $count>0)
        {
            
              $user_data=mysqli_fetch_assoc($result);
            
              if($user_data['password'] === $password )
              {
                $_SESSION['id'] = $user_data['id'];
                header("Location: index.php");
                die;
              }
              else
              {
                echo("Enter the correct password");
              }
            
            
        
            
        }  
        else
        {  
          echo"please enter some valid information!";
        }
      }
 }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="./asset/style.css">



    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital@1&display=swap" rel="stylesheet">

</head>

<body>

  <section id="navbar">

    <div class="container-fluid">
      <nav class="navbar navbar-expand-lg navbar-light bg-light mx-5  bg-light">

        <h4 class="hitch-h1 ">hitch</h4>
       
       
      </nav>
    </div>
 </section>


    




<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
  <div class="modal-dialog" role="document">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-header p-5 pb-4 border-bottom-0">
        <h1 class="fw-bold mb-0 fs-2">Log in</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" fdprocessedid="4x0la6"></button>
      </div>
      
      


        
      <div class="modal-body p-5 pt-0">
        <form  action="" method="POST" class="">
          <div class="form-floating mb-3">
            <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com" fdprocessedid="f9bzpb" name="uname">
            <label for="floatingInput">User Name</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password" fdprocessedid="zrk37a" name="password">
            <label for="floatingPassword">Password</label>
          </div>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" fdprocessedid="kpcbbk">Log in</button>
          <small class="text-body-secondary">If you are not registered yet .</small>

         
       
       <a href="signup.php" class=" my-4">Sign up</a>
           
          
         
        </form>
        <a href="https://www.youtube.com" class="my-4 ">YouTube</a> 
      </div>
    </div>
  </div>
</div>














<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>

</body>
</html>
<?php
    session_start();

    if(isset($_SESSION['id']))
    {
        unset($_SESSION['id']);
    }

    header("Location: login.php");
    die;
    <?php
    session_start();
    
    include("connections.php");
    include("functions.php");
    global $isAvailable;
    
    $user_data = check_login($con);
    
    if (isset($_SESSION)) {
        $driver = $user_data['uname'];
        $query = "SELECT name, ph_no FROM waiting WHERE driver='$driver' ";
    
        $result = mysqli_query($con, $query);
    
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $isAvailable = true;
            } else {
                $isAvailable = false;
            }
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
    
    // Accept request
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Check if the accepted request's phone number is set
        if (isset($_POST['accept_request'])) {
            $phoneNumber = $_POST['accept_request'];
    
            // Get the driver's current seats value
            $seatsQuery = "SELECT seats FROM drive WHERE uname='$driver'";
            $seatsResult = mysqli_query($con, $seatsQuery);
    
            if ($seatsResult) {
                $seatsRow = mysqli_fetch_assoc($seatsResult);
                $currentSeats = $seatsRow['seats'];
    
                // Decrement the seats value
                $newSeats = $currentSeats - 1;
    
                // Update the driver's seats value in the database
                $updateSeatsQuery = "UPDATE drive SET seats='$newSeats' WHERE uname='$driver'";
                mysqli_query($con, $updateSeatsQuery);
    
                // Display the accepted request
               
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }
    }
    
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
    
        <title>List of rides</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital@1&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="asset/style.css">
    
        <style>
            .image-container {
                text-align: center;
            }
    
            .image-container img {
                max-width: 100%;
            }
        </style>
    </head>
    
    <body>
        <section id="navbar">
            
            <div class="container-fluid">
                <nav class="navbar navbar-expand-lg navbar-light bg-light mx-5  bg-light">
    
                    <h4 class="hitch-h1 ">hitch</h4>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="index.php">Home <span class="sr-only"></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="signToRide.php">Find a Ride</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="signToDrive.php">Offer a Ride</a>
                            </li>
                         
                        </ul>
    
                    </div>
    
                </nav>
            </div>
        </section>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 my-5 image-container">
                    <img src="./asset/Screenshot 2023-06-22 214634.png" class="img-fluid rounded" alt=" Themes" loading="lazy">
                </div>
    
                <div class="col-lg-8">
                    <?php if ($isAvailable == true) : ?>
                        <div class="card">
                            <div class="card-header">
                                <h5>Requests</h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <?php while ($row = mysqli_fetch_array($result)) : ?>
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6><?php echo $row["name"]; ?></h6>
                                                <small class="text-muted">contact to connect : <?php echo $row["ph_no"]; ?></small>
                                            </div>
                                            <form method="POST" action="">
                                                <input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
                                              
                                    <button type="submit" name="accept_request" value="<?php echo $row["ph_no"]; ?>" class="btn btn-dark btn-sm">Accept</button>
                                            </form>
                                        </div>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-info" role="alert">
                            <h5>No Requests found</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    </body>
    
    </html>
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

<?php

  session_start();
  

  include("connections.php");
  include("functions.php");

  $user_data=check_login($con);

  




?>







<!DOCTYPE html>
<html>
  <head>
    <title>hitchs</title>
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
               
               
    
              </ul>
    
            </div>
          
          </nav>
        </div>


      <!--.....-->
      

     

        <div class="row featurette">
            <div class="col-md-7 order-md-3">
                <div class="col-md-6 " id="form">
                    <h2>Where do you want to go?</h2>
                    <form method="POST" action="AvailableRide.php">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="loc" required>
                        <label for="floatingInput">starting location</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="dest" required>
                        <label for="floatingInput">destination</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="seats" required>
                        <label for="floatingInput">number of passengers</label>
                      </div>
                      <div class="form-floating mb-3">
                        <input type="date" class="form-control rounded-3" id="floatingInput" placeholder="text" fdprocessedid="f9bzpb" name="date" required>
                        <label for="floatingInput">date of the journey</label>
                      </div>
                      <button type="submit" name="go" class="my-2 btn btn-primary">Go</button>
                    </form>
                  </div>
            </div>
            <div class="col-md-5 order-md-1">
                <img width="500" class="my-4" src="./asset/ride.png">
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
<?php
session_start();

include("connections.php");
include("functions.php");

// Function to validate the password
function validatePassword($password) {
    $uppercase = preg_match('/[A-Z]/', $password);
    $lowercase = preg_match('/[a-z]/', $password);
    $number = preg_match('/[0-9]/', $password);
    $length = strlen($password) >= 8;
    return $uppercase && $lowercase && $number && $length;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Something was posted
    $email = $_POST['email'];
    $user_name = $_POST['uname'];
    $phone = $_POST['phNum'];
    $pass = $_POST['pass1'];
    $passRE = $_POST['pass2'];
    $name = $_POST['name'];

    if (!empty($email) && !empty($user_name) && !empty($phone) && !empty($pass) && !empty($passRE) && !empty($name)) {
        if ($pass == $passRE) {
            if (validatePassword($pass)) {
                // Check if the username is already taken
                $check_query = "SELECT * FROM users WHERE uname = '$user_name'";
                $check_result = mysqli_query($con, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    echo '<script>  alert ( "Username already taken. Please choose a different username.")</script>';
                } else {
                    $query = "INSERT INTO users (name, email, uname, ph_no, password) VALUES ('$name', '$email', '$user_name', '$phone', '$pass')";

                    if (mysqli_query($con, $query)) {
                        header("Location: login.php");
                        exit;
                    } else {
                        echo "Error: " . mysqli_error($con);
                    }
                }
            } else {
                echo '<script> alert("Password should be at least 8 characters long and include an uppercase letter, a lowercase letter, and a number.")</script>';
            }
        } else {
            echo '<script> alert("Passwords do not match")</script>';
        }
    } else {
        echo '<script> alert ("Please enter all required information!") </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hitch</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./asset/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:ital@1&display=swap" rel="stylesheet">
    <style>
        .password-strength {
            font-size: 12px;
            color: #dc3545;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<section id="navbar">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light mx-5  bg-light">
            <h4 class="hitch-h1">hitch</h4>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="login.php" class="btn btn-dark my-4">Log in</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</section>

<div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1"
     role="dialog" id="modalSignin">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-5 pb-4 border-bottom-0">
                <h1 class="fw-bold mb-0 fs-2">Sign up</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        fdprocessedid="4x0la6"></button>
            </div>
            <div class="modal-body p-5 pt-0">
                <form method="POST" action="">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="Your Name"
                               fdprocessedid="zrk37a" name="name" required>
                        <label for="floatingInput">Your Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control rounded-3" id="floatingInput"
                               placeholder="name@example.com" fdprocessedid="f9bzpb" name="email" required>
                        <label for="floatingInput">Email</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control rounded-3" id="floatingInput" placeholder="text"
                               fdprocessedid="zrk37a" name="uname" required>
                        <label for="floatingInput">User Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="tel" class="form-control rounded-3" id="floatingInput" placeholder="number"
                               fdprocessedid="zrk37a" name="phNum" required>
                        <label for="floatingInput">Phone Number</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="passwordInput"
                               placeholder="Password" fdprocessedid="zrk37a" name="pass1" required>
                        <label for="passwordInput">Create Password</label>
                        <div id="passwordStrength" class="password-strength"></div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control rounded-3" id="confirmPasswordInput"
                               placeholder="Password" fdprocessedid="zrk37a" name="pass2" required>
                        <label for="confirmPasswordInput">Confirm Password</label>
                    </div>
                    <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" fdprocessedid="kpcbbk">
                        Sign up
                    </button>
                    <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
<script>
    const passwordInput = document.getElementById("passwordInput");
    const passwordStrength = document.getElementById("passwordStrength");

    passwordInput.addEventListener("input", function () {
        const password = passwordInput.value;
        const strength = getPasswordStrength(password);

        passwordStrength.textContent = getPasswordStrengthMessage(strength);
    });

    function getPasswordStrength(password) {
        // Function to calculate password strength based on your criteria
        const uppercase = /[A-Z]/.test(password);
        const lowercase = /[a-z]/.test(password);
        const number = /[0-9]/.test(password);
        const length = password.length >= 8;

        let strength = 0;
        if (uppercase) strength++;
        if (lowercase) strength++;
        if (number) strength++;
        if (length) strength++;

        return strength;
    }

    function getPasswordStrengthMessage(strength) {
        // Function to get password strength message based on strength value
        switch (strength) {
            case 0:
                return "";
            case 1:
                return "There must be 8 character,uppercase,lowercase,special character(.,@#$)";
            case 2:
                return "There must be 8 character,uppercase,lowercase,special character(.,@#$)";
            case 3:
                return "Strong password";
            case 4:
                return "Very strong password";
            default:
                return "";
        }
    }
</script>
</body>
</html>
