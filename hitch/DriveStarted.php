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


</body>