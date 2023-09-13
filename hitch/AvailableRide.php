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

    $uname=$user_data['name'];

    if (!empty($loc1) && !empty($dest1) && !empty($seats1) && !empty($date1)) {
        $query = "SELECT uname, date, time, vehicle, seats FROM drive WHERE loc='$loc1' AND dest='$dest1' AND seats>='$seats1'";
        $result = mysqli_query($con, $query);
        if (mysqli_num_rows($result) > 0) {
            $isAvailable=true;
        } else {
            $isAvailable=false;
            $query3="select uname,loc,des,seats from notify where uname='$uname'and loc='$loc1'and des='$dest1' and seats='$seats1' and date='$date1'";
            $result1=mysqli_query($con,$query3);
            if(mysqli_num_rows($result1)==0)
            {
                $query2="insert into notify (uname,loc,des,seats,date,isAvailable) values ('$uname','$loc1','$dest1','$seats1','$date1','0') ";
                mysqli_query($con,$query2);
            }
            
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
