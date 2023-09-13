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
